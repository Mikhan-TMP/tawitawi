<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Seat extends CI_Controller
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
    if(isset($this->session->userdata['username'])==false)
    redirect('auth');

    $floorname =array('GF','2F','3F','4F','5F','6F','7F'); 
    $roomcount =array(4,9,7,3,10,9,5); 
    
    $array = array("name" => "John", "age" => 25, "hobbies" => array("reading", "gaming", "coding"));
    $status = array(0,1,0,1,0,1,0,1,0,1,0,1);

    // Attendance Form
    $d['title'] = 'Seat Status';
    $d['slot'] = $this->db->get('slot')->result_array();    
    $d['roomname'][0] = $this->db->get_where('room', ['floor' => 'GF'])->result_array();
    $d['roomname'][1] = $this->db->get_where('room', ['floor' => '2F'])->result_array();
    $d['roomname'][2] = $this->db->get_where('room', ['floor' => '3F'])->result_array();
    $d['roomname'][3] = $this->db->get_where('room', ['floor' => '4F'])->result_array();
    $d['roomname'][4] = $this->db->get_where('room', ['floor' => '5F'])->result_array();
    $d['roomname'][5] = $this->db->get_where('room', ['floor' => '6F'])->result_array();
    $d['roomname'][6] = $this->db->get_where('room', ['floor' => '7F'])->result_array();
   
       
      for($floor_no=0; $floor_no <7 ; $floor_no++){
          $seatcount[$floor_no ] = $this->db->get_where('slot', ['Floor' =>$floorname[$floor_no]])->num_rows();       
      }

    $d['seatcount'] =$seatcount; 
    $d['Floorname'] =$floorname; 
    $d['roomcount'] =$roomcount; 

    // echo json_encode($d['slot']); 
    // echo json_encode($d['roomcount']); 

   //  $this->db->replace('slot', $data);
     // $serialized = serialize($status);
     /*
      $serialized = json_encode($status);
      $data = array(
      'Slot' => 2,
      'status' => $serialized
      );
      $id=1;
      $this->db->where('id', $id);
      $this->db->update('slot', $data);

      $data = $this->db->get_where('slot', ['id' => $id])->row_array();
      print_r($data['status']);      
      $unserialized = json_decode($data['status']);
      print_r($unserialized);

     */
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
  
        $this->load->view('templates/header',$d);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('seat/index', $d); 
        $this->load->view('templates/table_footer');
        
  }
   /*********************************************************************************/
  public function roomstatus()
  {
    // Add Department
    $d['title'] = 'Room Status';    
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    $d['roomlist'] = $this->db->get('room')->result_array();
   
    // $floor ='GF';
    // $d['slot'] = $this->db->get_where('slot', ['floor' => $floor ])->result_array();
    //echo json_encode($d['slot']);    
    if(isset($_GET['start']))
      $date = $_GET['start'];
    else
      $date = date("Y-m-d", strtotime("today"));
  
    if(isset($_GET['room'])) {
        $roomname = $_GET['room'];
        if($roomname == "all")
          $d['slot'] = $this->db->get_where('roomslot', ['date'=>$date ])->result_array();
        else
          $d['slot'] = $this->db->get_where('roomslot', ['room' => $roomname,'date'=>$date ])->result_array();
    }
    else{
        $roomname = "";
        $d['slot'] = $this->db->get_where('roomslot', ['date'=>$date ])->result_array();
    }
    $d['roomname'] =$roomname;
    $d['date'] =$date;    
    
          
    $this->load->view('templates/header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('seat/roomstatus', $d); 
    $this->load->view('templates/footer');
    
  }
   /*********************************************************************************/
  public function slotstatus()
  {
    // Add Department
    $d['title'] = 'Seat Status';    
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);    
    $d['roomlist'] = $this->db->get('area')->result_array();
    if(isset($_GET['start']))
      $date = $_GET['start'];
    else
      $date = date("Y-m-d", strtotime("today"));
    
    if(isset($_GET['room'])) {
        $roomname = $_GET['room'];
        if($roomname == "all")
          $d['slot'] = $this->db->get_where('slot', ['date'=>$date ])->result_array();
        else
          $d['slot'] = $this->db->get_where('slot', ['room' => $roomname,'date'=>$date ])->result_array();
    }
    else{
        $roomname = "";
        $d['slot'] = $this->db->get_where('slot', ['date'=>$date ])->result_array();
    }
    $d['roomname'] =$roomname;
    $d['date'] =$date;    
    
            
    $this->load->view('templates/header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('seat/slotstatus', $d); 
    $this->load->view('templates/footer');
    
  }
  
  /*********************************************************************************/
  
  public function monitoring()
  {
    $d['title'] = 'Live Monitoring';
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);    
    $floorQuery = $this->db->distinct()->select('floor')->get('area')->result_array();
    $floorList = array();
    foreach ($floorQuery as $row)
    {
      $floorList[] = $row['floor'];
    }
    $d['roomlist'] =  $floorList;

      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('seat/monitoring', $d);
      $this->load->view('templates/footer');
    
  }

  public function live()
  {
    // Add Department
    $d['title'] = 'Live Monitoring';
    $floor = $this->input->get('Floor');
    //$d['areas'] = $this->db->get_where('area', ['floor' => $floor])->result_array();

    date_default_timezone_set("Asia/Manila");
    $dateToday = date('Y-m-d', time());
    $currentTime = date('H:i:s', time());
    $bookings = $this->db->get_where('booking', ['date' => $dateToday])->result_array();

    // // Iterate through booking records
    $displayData = array();
    foreach ($bookings as $booking)
    {
      $room = $booking['room'];
      
      $this->db->select('opentime, closetime');
      $this->db->where('room', $room);
      $area = $this->db->get('area')->row_array();

      if (!empty($area))
      {

        $startTime = $booking['start_time'];
        $endTime = $booking['end_time'];
        // $startTime = 11;
        // $endTime = 13;
        $areaOpenTime = DateTime::createFromFormat('H:i:s', $area['opentime'])->format('H');
        $convertedStartTime = DateTime::createFromFormat('H', $areaOpenTime + $startTime)->format('H:i:s');
        $convertedEndTime = DateTime::createFromFormat('H', $areaOpenTime + $endTime)->format('H:i:s');

        // print_r(json_encode($convertedEndTime));

        if($convertedStartTime <= $currentTime && $convertedEndTime >= $currentTime)
        {
            $displayData[] = array(
                'floor' => $booking['floor'],
                'area' => $booking['room'],
                'seat' => $booking['slot_id'],
                'timeStart' => $convertedStartTime,
                'timeEnd' => $convertedEndTime,
                'occupied' => $booking['in_time'] == null ? false : true
            );
        }
        else
        {
            $displayData[] = array(
                'floor' => null,
                'area' => null,
                'seat' => null,
                'timeStart' => null,
                'timeEnd' => null,
                'occupied' => null
            );
        }
      }
      // print_r($displayData);
    }
    
    $areaList = $this->db->distinct()->get_where('area', ['floor' => $floor])->result_array();
    $areas = array();

    for ($i=0; $i < count($areaList) ; $i++) { 
      // echo $i;
      $areas[$i]['name'] = $areaList[$i]['room'];
      $list = array();
      for ($ii=0; $ii < $areaList[$i]['slotnumber']; $ii++)
      { 
        $content['id'] = $ii + 1;
        if(!empty($displayData))
        {
          
          foreach($displayData as $display)
          {
            
            if($ii + 1 == $display['seat'] && $areas[$i]['name'] == $display['area'])
            {
              $content['status'] = 'Occupied';
              
              $current_time = new DateTime();
              $end_time_str = $display['timeEnd'];
              $end_time = DateTime::createFromFormat('H:i:s', $end_time_str);
              $time_difference = $current_time->diff($end_time);
              $timeRemaining = $time_difference->format('%H:%I');
              
              $content['timeRemaining'] = $timeRemaining;
              break;
            }
            else
            {
              $content['status'] = 'Available';
              $content['timeRemaining'] = null;
            }
          }
        }
        else
        {
          $content['status'] = 'Available';
          $content['timeRemaining'] = null;
        }
        $list[$ii] = $content;
       
      }
      // print_r($content);
      $areas[$i]['list'] = $list;
    }

    // print_r(json_encode($areas));

    $d['areas'] = $areas;

    // print_r($areas);
      // foreach ($areaList as $list)
      // {
      //   $areas['name'] = $list['room'];

      //   for ($i=1; $i < $list['slotnumber'] + 1; $i++)
      //   { 
          
      //   }
      //   //print_r(json_encode($list));
      //   print_r($areas);
      // }
     
    $this->load->view('templates/header', $d);    
    $this->load->view('seat/live', $d); 
  }

   /*********************************************************************************/
  public function a_slot()
  {
    // Add Department
    $d['title'] = 'Department';
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    // Form Validation
    $this->form_validation->set_rules('d_id', 'Department ID', 'required|trim|exact_length[3]|alpha');
    $this->form_validation->set_rules('d_name', 'Department Name', 'required|trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/department/a_dept', $d); // Add Department Page
      $this->load->view('templates/footer');
    } else {
      $this->_addDept();
    }
  }
 /*********************************************************************************/
  public function bookroom()
  {
    // check session username 
    if(isset($this->session->userdata['username'])==false)
      redirect('auth');

    //   ALTER TABLE `roomslot` ADD `2023-09-21` VARCHAR(50) NULL DEFAULT NULL AFTER `uniqueid`;
    
    $d['roomlist'] = $this->db->get('room')->result_array();      
    $roomname = $this->input->post('roomname'); 
    $date = $this->input->post('atdate');
    // echo $date."=".$roomname;
    if($date == null)
      $date = date("Y-m-d", strtotime("today"));
    if($roomname != null){
      $roomslot = $this->db->get_where('roomslot', ['date'=>$date,'Room' =>$roomname])->result_array();
      $roominfo = $this->db->get_where('room', ['Room' =>$roomname])->result();    
      // print_r($roominfo);
      if($roomslot == null){
        $data = array( 
            'floor' => $roominfo['floor'],
            'room' => $roomname,            
            'date' => $date,
            'opentime'=> $roominfo['opentime'],
            'operationtime' => $roominfo['operation'],            
            'closetime' => $roominfo['closetime'],
            'status' => '[0,0,0,0,0,0,0,0,0,0,0,0]'
        );
        $this->db->insert('roomslot', $data);
      }             
    }
    else
    {    
      $roomslot = $this->db->get_where('roomslot',['date' =>$date])->result_array();  
      if($roomslot==NULL){        
        foreach ($d['roomlist'] as $dpt) {
          $data = array(
            'floor' => $dpt['floor'],
            'room' => $dpt['room'],            
            'date' => $date,
            'opentime'=> $dpt['opentime'],
            'operationtime' => $dpt['operationtime'],            
            'closetime' => $dpt['closetime'],
            'status' => '[0,0,0,0,0,0,0,0,0,0,0,0]'
          );
          $this->db->insert('roomslot', $data);
        }  
      }                 
    }
        
    $d['title'] = 'Room Reservation';    
    $d['date'] = $date;    
    $d['roomslot'] = $this->db->get_where('roomslot', ['date'=>$date])->result_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    
    $this->load->view('templates/header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('seat/bookroom', $d); 
    $this->load->view('templates/footer');    
  }
   /*********************************************************************************/
   public function v_room()
   {
     $d['title'] = 'Reservation Detail Information';     
     $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
     $room=$_GET['room'];
     $tslot=$_GET['slot']+8;
     $date=$_GET['date'];
     
    
    
    $d['roomslot'] = $this->db->get_where('roombooklog', ['date'=>$date,'room'=>$room,'start_time'=>$tslot])->row_array();
    
    //print_r($d['roomslot']);
     if($d['roomslot'] == null){
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');           
      $this->load->view('templates/footer');
     }
     else{
        $this->load->view('templates/header', $d);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');        
        $this->load->view('seat/v_room', $d); 
        $this->load->view('templates/footer');
     }

   }

   public function a_room()
   {
     // Add Department
     $d['title'] = 'Room Reservation';
     $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
     // Form Validation
     $this->form_validation->set_rules('d_id', 'Department ID', 'required|trim|exact_length[3]|alpha');
     $this->form_validation->set_rules('d_name', 'Department Name', 'required|trim');
 
     if ($this->form_validation->run() == false) {
       $this->load->view('templates/header', $d);
       $this->load->view('templates/sidebar');
       $this->load->view('templates/topbar');
       $this->load->view('seat/a_room', $d); // Add Department Page
       $this->load->view('templates/footer');
     } else {
       $this->_addDept();
     }
   }
   public function e_room($d_id, $stime)
   {
    // echo("ID:". $d_id.'Start:'.$stime );
     // Edit Department
     $d['title'] = 'Room Reservation';
     $d['d_old'] = $this->db->get_where('roomslot', ['id' => $d_id])->row_array();    
     $d['d_slot'] = $stime;    
     $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
     // Form Validation
     // $this->form_validation->set_rules('text', 'e_title', 'required'); 
     // if($this->form_validation->run() == false) {      
     $operationtime =  $d['d_old']['operationtime']; 
     if(!isset($_POST['updateroom'])){
       $this->load->view('templates/header', $d);
       $this->load->view('templates/sidebar');
       $this->load->view('templates/topbar');
       $this->load->view('seat/e_room', $d); // Edit Department Page
       $this->load->view('templates/footer');
     } 
     else {
         $date= $this->input->post('date');    
         $etime = $this->input->post('end_time'); 
      //   echo "End time:".$etime;
         $data = array(           
           'floor' => $this->input->post('floor'),
           'room' => $this->input->post('room'),
           'date' => $this->input->post('date'),
           'start_time' => $stime,
           'end_time' => $etime,
           'at_time' => date("Y-m-d H:i:s", strtotime("now")),      
           'Noa' => $this->input->post('Noa'),
           'title' => $this->input->post('e_title'),
           'username' => $this->input->post('Organizer'),
           'contact' => $this->input->post('contact'),  
           'email' => $this->input->post('email'),
           'description' => $this->input->post('Description'),
         );
         $this->db->insert('roombooklog', $data);    
         //update roomslot status 
         $roomslot = $this->db->get_where('roomslot', ['id' => $d_id])->row_array();        
         // echo gettype($roomslot);
         //echo json_encode($roomslot); 
         $timeslotdata= $roomslot['status'];         
         if($roomslot != NULL){            
            $slottemp = trim($timeslotdata, "[");
            $slottemp = trim($slottemp, "]");        
            $timeslot = explode(",",$slottemp) ;
            // echo gettype($timeslot);
            
            echo "reserved successfully";
            
            for($i=0; $i<12; $i++){
              if(($i>=$stime)&&($i <$etime)){
                $timeslot[$i] = '1';         
              }              
            }
          //  print_r($timeslot);
           
            $data = array(                
              'status' => '['.implode(',',$timeslot).']'
            );              
          //  print_r($data);
            $this->db->where('id', $d_id);
            $this->db->update('roomslot', $data);              
         }
         else{
            echo "invalid slot information";
         }
         redirect('seat/bookroom');
     }
   }
   
  /*********************************************************************************/
  public function book()
  {
    if(isset($this->session->userdata['username'])==false)
    redirect('auth');

    $roomcount =array(3,9,6,3,10,8,5); 
    $floorname =array('GF','2F','3F','4F','5F','6F','7F'); 
    $d['title'] = 'Seat Reservation';
    $d['slot'] = $this->db->get('slot')->result_array();  
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    $d['roomname'][0] = $this->db->get_where('room', ['floor' => 'GF'])->result_array();
    $d['roomname'][1] = $this->db->get_where('room', ['floor' => '2F'])->result_array();
    $d['roomname'][2] = $this->db->get_where('room', ['floor' => '3F'])->result_array();
    $d['roomname'][3] = $this->db->get_where('room', ['floor' => '4F'])->result_array();
    $d['roomname'][4] = $this->db->get_where('room', ['floor' => '5F'])->result_array();
    $d['roomname'][5] = $this->db->get_where('room', ['floor' => '6F'])->result_array();
    $d['roomname'][6] = $this->db->get_where('room', ['floor' => '7F'])->result_array();
    $d['roomcount'] =$roomcount; 
    for($floor_no=0; $floor_no <7 ; $floor_no++){
      for($room_no=0; $room_no < $roomcount[$floor_no] ; $room_no++){       
        $seatcount[$floor_no ][$room_no] = $this->db->get_where('slot', ['Floor' =>$floorname[$floor_no],'Room'=>$d['roomname'][$floor_no][$room_no]['room']])->num_rows();        
      }      
    }
    $d['seatcount'] =$seatcount; 
        
    $this->load->view('templates/header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('seat/book', $d); 
    $this->load->view('templates/footer');
    
  }
 /*********************************************************************************/
  public function e_slot($d_id)
  {
    // Edit Department
    $d['title'] = 'Seat update';
    $d['d_old'] = $this->db->get_where('slot', ['id' => $d_id])->row_array();    
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    // Form Validation
    $this->form_validation->set_rules('d_name', 'Department Name', 'required|trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('seat/e_slot', $d); // Edit Department Page
      $this->load->view('templates/footer');
    } 
    else {
      $name = $this->input->post('d_name');
      $this->_editDept($d_id, $name);
    }
  }
  
   /*********************************************************************************/
  
  
  public function BookData()
  {    
   // if(isset($_POST['device']) && isset($_POST['floor']) && isset($_POST['room']) && isset($_POST['slot'] && isset ($_POST['userid']))){      
    if($_POST['device'] != null) {
      $data = array(
        'device' => $this->input->post("device"),
        'userid' => $this->input->post("userid"),
        'code_type' => $this->input->post("code_type"),
        'usercode' => $this->input->post("code"),
        'floor' => $this->input->post("floor"),
        'room' => $this->input->post("room"),
        'slot' => $this->input->post("slot_id"),
        'date' => date('Y-m-d', time()),
        'stime' => rand(8,18),
        'etime' => $stime+2,      
        );
        $this->db->insert('book', $data);
        /*
        $slotdata = $this->db->get_where('slot', ['Floor' =>$floor,'Room' =>$room,'Slot' =>$slot])->row();
        echo json_encode($slotdata);
        if($slotdata){          
          $timeslot = $slotdata['status'];
           echo $timeslot;        
          if($timeslot[$stime]){  // occupied 
              echo "already reserved";
              print(json_encode($timeslot));
          }
          else {     // vacant 
              echo "reserved successfully";
              $timeslot[$stime] = 1;
              $slotdata['status'] = json_encode($timeslot);            
              echo $slotdata;
          } 
        }
        else {
          echo "invalid slot information";
        } 
        */                      
      }
      else {
        echo "invalid input";
      }
      
  }
  public function ChangeSlotData()
  {
    
    $d['device'] =  $this->input->get("device");
    $d['floor'] =  $this->input->get("floor");
    $d['room'] =  $this->input->get("room");
    $d['slot'] =  $this->input->get("slot");
    
    $d['slot'] = $this->db->get_where('slot', ['Floor' => $d['floor'],'Room' => $d['room'],'Slot' =>$d['slot']])->result_array();
    echo json_encode($d['slot']);
  
  }
  
  public function GetRoomList() 
  {
    $floorname =  $this->input->get("floorname");
    $this->db->select('DISTINCT(room)');
    $d = $this->db->get_where('room',['Floor'=>$floorname])->result_array();        
    if ($d != NULL )
        echo  json_encode($d);  
    else
        echo  json_encode("No Data");
  }
    
}
