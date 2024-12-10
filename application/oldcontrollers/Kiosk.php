<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kiosk extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
  
   // is_logged_in();   
    $this->load->library('form_validation');
    $this->load->model('Public_model');
    $this->load->model('Admin_model');
  }
  public function index()
  {
    
  }

  public function GetFloorList() 
  {
    $this->db->select('DISTINCT(floor)');
    $d = $this->db->get('area')->result_array();        
    if ($d != NULL )
        echo  json_encode($d);  
    else
        echo  json_encode("No Data");
  }
  public function GetAreaList() 
  {
    $floorname =  $this->input->get("floorname");
    // $this->db->select('DISTINCT(room)');
    $d = $this->db->get_where('area',['Floor'=>$floorname])->result_array();        
    if ($d != NULL )
        echo  json_encode($d);  
    else
        echo  json_encode("No Data");
  }
  
  public function GetSeatList() 
  {
    
    if(!isset($_GET['date'])){
      echo "no date";
      return;
    }else{
      $date = $this->input->get("date"); 
    }
    /*$date = date("Y-m-d", strtotime("today")); */
    $floorname =  $this->input->get("floorname");
    $roomname =  $this->input->get("roomname"); 
    $d = $this->db->get_where('slot',['date'=>$date,'Floor'=>$floorname,'Room'=>$roomname])->result_array();        
    $roominfo = $this->db->get_where('area',['floor'=>$floorname,'room'=>$roomname])->row();
    
    if ($d != NULL )
        echo  json_encode($d);  
    else{      
        $slot=0;
        $data = array(
            'date' => $date,
            'Floor' => $floorname,
            'Room' => $roomname,
            'Slot' => $slot,
            'status' => "[0,0,0,0,0,0,0,0,0,0,0]"
        );
        
        $Max_slot=$roominfo->slotnumber;
        for ($slot=1;$slot<=$Max_slot;$slot++){
          $data['Slot'] =$slot;
          $this->db->insert('slot', $data);
        }               
        $d = $this->db->get_where('slot',['date'=>$date,'Floor'=>$floorname,'Room'=>$roomname])->result_array();        
        echo  json_encode($d);  
    }
  }

  public function ReqBookSeat()
  {    
    
    // if($this->input->post("device") != null) {      
      $device = $this->input->post("device");
      $user_id = $this->input->post("user_id");
      $code_type = $this->input->post("code_type");
      $code = $this->input->post("code");        
      $floor = $this->input->post("floor"); // desired floor
      $room = $this->input->post("room");// desired room
      $slot = $this->input->post("slot");// desired slot
      $date = $this->input->post("date");  // desired date       
      $stime = $this->input->post("stime");// desired stiem
      $etime = $this->input->post("etime");// desired etime
      
      $data = array(
        'device' => $this->input->post("device"),
        'user_id' => $this->input->post("user_id"),
        'code_type' => $this->input->post("code_type"),
        'code' => $this->input->post("code"),
        'floor' => $this->input->post("floor"),
        'room' => $this->input->post("room"),
        'slot_id' => $this->input->post("slot"),
        'date' => $this->input->post("date"),
        'start_time' => $this->input->post("stime"),
        'end_time' => $this->input->post("etime"),
        'at_time' => date("Y-m-d H:i:s", strtotime("today"))
        );
        
        $this->db->insert('booking', $data);
        
        $slotdata = $this->db->get_where('slot', ['date'=>$date,'Floor' =>$floor,'Room' =>$room,'Slot' =>$slot])->row();
        if($slotdata != NULL){
          // echo gettype($slotdata);
          // echo json_encode($slotdata);
          //$timeslot = explode(",",$slotdata->status) ;
          $slottemp = trim($slotdata->status, "[");
          $slottemp = trim($slottemp, "]");
        //  $timeslot = explode(",",$slotdata->status) ;
          $timeslot = explode(",",$slottemp) ;
          // echo gettype($timeslot);
        //  print_r($timeslot);          
         
            if($timeslot[$stime] =='1' ){  // occupied 
                echo "already reserved";              
            }
            else {     // vacant 
              echo "reserved successfully";
              for($i=$stime; $i<$etime; $i++)            
                $timeslot[$i] = '1';
              $data = array(                
                'status' => '['.implode(',',$timeslot).']'
              );              
              $this->db->where('id', $slotdata->id);
              $this->db->update('slot', $data);              
            }     
          }
          else {
            echo "no slot information";
          }    
  }
  public function GetUserBookList()
  {
    $code_type =  $this->input->get("code_type");
    $code =  $this->input->get("code");        
    $date = date("Y-m-d", strtotime("today"));
    $d = $this->db->get_where('booking',['code_type'=>$code_type,'code'=>$code,'date'=>$date])->result_array();        
    if ($d != NULL )
        echo  json_encode($d);  
    else
        echo  json_encode("No Data");
  }
  public function GetUserBookAllList()
  {
    $code_type =  $this->input->get("code_type");
    $code =  $this->input->get("code");        
    
    $d = $this->db->get_where('booking',['code_type'=>$code_type,'code'=>$code])->result_array();        
    if ($d != NULL )
        echo  json_encode($d);  
    else
        echo  json_encode("No Data");
  }
  public function CancelBook()
  {
    $code_type =  $this->input->get("code_type");
    $code =  $this->input->get("code");        
    $id =  $this->input->get("book_id");        
    
    echo ("deleted or delete fail (not yet) ");
    /*
    $d = $this->db->get_where('booking',['code_type'=>$code_type,'code'=>$code])->result_array();        
    if ($d != NULL )
        echo  json_encode($d);  
    else
        echo  json_encode("No Data");
    */
  }
#############################################################################  
  public function GetSlotData()
  {    
    $d['device'] =  $this->input->get("device");
    $d['floor'] =  $this->input->get("floor");
    $d['room'] =  $this->input->get("room");    
    $d['slot'] = $this->db->get_where('slot', ['Floor' => $d['floor'],'Room' => $d['room']])->result_array();
    print(json_encode($d['slot']));  
  }
  public function ChangeSlotData() /* need change */
  {
    
    $d['device'] =  $this->input->get("device");
    $d['floor'] =  $this->input->get("floor");
    $d['room'] =  $this->input->get("room");
    $d['slot'] =  $this->input->get("slot");    
    $d['slot'] = $this->db->get_where('slot', ['Floor' => $d['floor'],'Room' => $d['room'],'Slot' =>$d['slot']])->result_array();
    echo json_encode($d['slot']);
  
  }
  public function SeatTimeIn()
  {
    date_default_timezone_set("Asia/Manila");
    $time = date('H:i:s', time());
    /*
    $user = $this->input->get('user_id');
    $code_type = $this->input->get("code_type");
    $code = $this->input->get("code");        
    */
    $book_id = $this->input->get('book_id');
    
    $data  =$this->db->get_where('booking', ['id' => $book_id])->row_array();
    if($data){
      $queryUpdate = "UPDATE `booking` SET `in_time` = '" . $time . "', `in_status` = 'occupied'  WHERE  `id` = '$book_id'";
      $this->db->query($queryUpdate);
      echo "time in success";   
    }
    else{
      echo "no booking record";
      return;
    }
  }
  public function SeatTimeOut()
  {
    date_default_timezone_set("Asia/Manila");
    $date = date('H:i:s', time());
    /*
    $user = $this->input->get('user_id');
    $code_type = $this->input->get("code_type");
    $code = $this->input->get("code");            
    */
    $book_id = $this->input->get('book_id');
    $data  =$this->db->get_where('booking', ['id' => $book_id])->row_array();
    if($data){
      $queryUpdate = "UPDATE `booking` SET `out_time` = '" . $date . "', `out_status` = 'exit'  WHERE  `id` = '$book_id'";                    
      $this->db->query($queryUpdate);
      echo "time out success";
    }
    else{
      echo "no booking record";
      return;
    }
  }

  public function UserGetInfo()
  {
    $code_type = $this->input->get("code_type");
    $code = $this->input->get("code");
    $password = $this->input->get("password");
    
    $confirmPass = $this->db->get_where('student', ['password' => $password])->row_array();

    if($confirmPass){
    
      if($code_type=='QR'){
          $data  =$this->db->get_where('student', ['qrcode' => $code])->row_array();
      } else {
          $data  =$this->db->get_where('student', ['rfid' => $code])->row_array();
      }
      
      if($data == NULL){
        if($code_type=='QR')
          $data  =$this->db->get_where('faculty', ['qrcode' => $code])->row_array();
        else 
          $data  =$this->db->get_where('faculty', ['rfid' => $code])->row_array();
        if($data==NULL){
          if($code_type=='QR')
          $data  =$this->db->get_where('visitor', ['qrcode' => $code])->row_array();
          else 
          $data  =$this->db->get_where('visitor', ['rfid' => $code])->row_array();
          if($data==NULL)
            $data['category'] ="null";
          else
            $data['category'] ="visitor";        
        }
        else 
          $data['category'] ="faculty";
      }
      else{
        $data['category'] ="student";
      }

      
      echo json_encode($data) ;   
    } else {
      $data['category'] = 'null';
      echo json_encode($data);
    }
  }
  public function UserGetSR()
  {
     $code = $this->input->get("code");     

     $data  =$this->db->get_where('student', ['srcode' => $code])->row_array();
    echo json_encode($data) ;   
  }
  
  public function TimeIn()
  {
    date_default_timezone_set("Asia/Manila");
    $Sdate = date('Y-m-d', time());
    $date = date('Y-m-d H:i:s', time());    
    $code_type = $this->input->get("code_type");
    $code = $this->input->get("code");    
    $kiosk_id = $this->input->get("kiosk_id");        
    if($code_type=='QR')
      $data  =$this->db->get_where('student', ['qrcode' => $code])->row_array();
    else 
      $data  =$this->db->get_where('student', ['rfid' => $code])->row_array();
    if($data == NULL){
      echo "no student record";
      return;
    } 
    else{
     $srcode = $data['srcode'];
     $username = ($data['first_name'].' '.$data['last_name']) ;    
     if($code_type=='QR'){
        $data = array(            
          'username' => $username,                     
          'qrcode' => $code,
          'srcode' => $srcode,
          'RFID' =>"",          
          'kiosk' => $kiosk_id,
          'in_time' => $date,
          'date' => $Sdate
        );
     }
     else {
      $data = array(            
        'username' => $username,                     
        'qrcode' =>"",
        'RFID' => $code,     
        'srcode' => $srcode,   
        'kiosk' => $kiosk_id,
        'in_time' => $date,
        'date' => $Sdate
      );
    }    
    $this->db->insert('attend', $data);
    echo "time in success";
    }
  }
  public function TimeOut()
  {
    date_default_timezone_set("Asia/Manila");
    $Sdate = date('Y-m-d', time());    // today     
    $date = date('Y-m-d H:i:s', time());  
    $code_type = $this->input->get("code_type");  // QR or RFID
    $code = $this->input->get("code");       // QR or RFID code
    $kiosk_id = $this->input->get("kiosk_id");  // kiosk id
    
    $data  =$this->db->get_where('attend', ['qrcode' => $code ,'date'=> $Sdate,'out_time'=>NULL])->row_array();  // search for QR code and not exit time
    
    if($data == NULL){
      echo "no entry data";
    }
    else{      
      $id =$data['id'];
      $queryUpdate = "UPDATE `attend`  SET `out_time` = '" .$date. "'  WHERE  `id` = '$id'";
      $this->db->query($queryUpdate);
      echo "time out success";    
    }
  }
  public function TapQR()
  {
    date_default_timezone_set("Asia/Manila");
    $Sdate = date('Y-m-d', time());
    $date = date('Y-m-d H:i:s', time());    
    $code_type = $this->input->get("code_type");
    $code = $this->input->get("code");    
    $kiosk_id = $this->input->get("kiosk_id");            
    // echo $code_type." ".$code." ".$kiosk_id."Date :".$Sdate;
    if($code_type=='QR')
      $data  =$this->db->get_where('attend', ['qrcode' => $code,'date'=>$Sdate] )->row_array();  // in today , he was attend or not . if he is attend , make to timeout , if not, make time in 
    else 
      $data  =$this->db->get_where('attend', ['rfid' => $code,'date'=>$Sdate])->row_array();

    if($data == NULL){
      if($code_type=='QR')
        $data  =$this->db->get_where('student', ['qrcode' => $code])->row_array();
      else 
        $data  =$this->db->get_where('student', ['rfid' => $code])->row_array();
      if($data == NULL){
        echo "No QR Data";
        return;
      }
      else{        
        $srcode = $data['srcode'];
        $username = ($data['first_name'].' '.$data['last_name']) ;         
        $data = array(            
          'username' => $username,
          'srcode' => $srcode,
          'qrcode' =>"",
          'RFID' =>"",          
          'kiosk' => $kiosk_id,
          'in_time' => $date,
          'date' => $Sdate
        );        
        if($code_type=='QR')
          $data['qrcode'] = $code;
        else 
          $data['RFID'] = $code;
        $this->db->insert('attend', $data);
        echo "time in success";
      }
    } 
    else{
      $id =$data['id'];
      $queryUpdate = "UPDATE `attend`  SET `out_time` = '" .$date. "'  WHERE  `id` = '$id'";
      $this->db->query($queryUpdate);
      echo "time out success";          
    }     
  
}
public function TapQRPair()
{
  date_default_timezone_set("Asia/Manila");
  $Sdate = date('Y-m-d', time());
  $date = date('Y-m-d H:i:s', time());
  $code_type = $this->input->get("code_type");
  $code = $this->input->get("code");    
  $kiosk_id = $this->input->get("kiosk_id");
  $password = $this->input->get("password");
  
  $checkPass = $this->db->get_where('student', ['password' => $password])->row_array();

  if($checkPass)
  {
    if($code_type == 'QR'){
      $data = $this->db->order_by('id', 'desc')->get_where('attend', ['qrcode' => $code,'date'=>$Sdate])->row_array();
    }else 
    {
      $data  =$this->db->order_by('id', 'desc')->get_where('attend', ['rfid' => $code,'date'=>$Sdate])->row_array();
    }
  
      if($data == NULL)
      {
        if($code_type=='QR')
          $data  =$this->db->get_where('student', ['qrcode' => $code])->row_array();
        else 
          $data  =$this->db->get_where('student', ['rfid' => $code])->row_array();
  
        if($data == NULL)
        {
          echo "No QR Data";
          return;
        }
  
        $srcode = $data['srcode'];
          $username = ($data['first_name'].' '.$data['last_name']) ;         
          $data = array(            
            'username' => $username,
            'srcode' => $srcode,
            'qrcode' =>"",
            'RFID' =>"",          
            'kiosk' => $kiosk_id,
            'in_time' => $date,
            'date' => $Sdate
          );        
          if($code_type=='QR')
            $data['qrcode'] = $code;
          else 
            $data['RFID'] = $code;
          $this->db->insert('attend', $data);
          echo "time in success";
      }
      else
      {
        if(empty($data['out_time']))
        {
          $id =$data['id'];
          $queryUpdate = "UPDATE `attend` SET `out_time` = '$date', `kiosk` = '$kiosk_id' WHERE `id` = '$id'";
          // $queryUpdate = "UPDATE `attend`  SET `out_time` = '" .$date. "'   WHERE  `id` = '$id'";
          // $queryUpdate = "UPDATE `attend`  SET `kiosk` = '" .$kiosk_id. "'  WHERE  `id` = '$id'";
          $this->db->query($queryUpdate);
          echo "time out success";   
        }
        else
        {
          if($code_type=='QR')
            $data  =$this->db->get_where('student', ['qrcode' => $code])->row_array();
          else 
            $data  =$this->db->get_where('student', ['rfid' => $code])->row_array();
  
          if($data == NULL){
            echo "No QR Data";
            return;
          }
  
          $srcode = $data['srcode'];
          $username = ($data['first_name'].' '.$data['last_name']) ;         
          $data = array(            
            'username' => $username,
            'srcode' => $srcode,
            'qrcode' =>"",
            'RFID' =>"",          
            'kiosk' => $kiosk_id,
            'in_time' => $date,
            'date' => $Sdate
          );        
          if($code_type=='QR')
            $data['qrcode'] = $code;
          else 
            $data['RFID'] = $code;
          $this->db->insert('attend', $data);
          echo "time in success";
        }
      }   
  } else {
    echo 'No Pass or Wrong Pass';
  }

  
  }
  public function GetSmallImageList()
  {
    $imgList = glob('assets/images_S/*.png');
    foreach($imgList as $filename){
      if(is_file($filename)){
        echo base_url().$filename.'|';
      }   
    }

  }
  public function GetBigImageList()
  {
    $imgList = glob('assets/images_L/*.png');
    foreach($imgList as $filename){
      if(is_file($filename)){
        echo base_url().$filename.'|';
      }   
    }

  }
  public function GetVideoList()
  {
    $imgList = glob('assets/videos/*.mp4');
					foreach($imgList as $filename){
						if(is_file($filename)){
							echo base_url().$filename.'|';
						}   
					}
  }
  public function TestDB()
  {
    
    for ($index= 1;$index <13;$index++){
      $code = rand(400000,999999);
      $queryUpdate = "UPDATE `faculty`  SET `qrcode` = '" .$code. "'  WHERE  `id` = '$index'";
      $this->db->query($queryUpdate);
      echo $index."=".$code."<br>";
    }
  }

  
}
