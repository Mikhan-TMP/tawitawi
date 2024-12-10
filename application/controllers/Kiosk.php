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
          $data['Slot'] = $slot;
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
              
                                  // Generate the time slots
                    $counter = 0; // Initialize counter
                    for ($time = $open_time; $time <= $close_time; $time = strtotime('+1 hour', $time)) {
                      $times[$counter] = date('H:i', $time);
                      // echo $times[$counter];
                      $counter++;
                    }
            }     
          }
          else {
            echo "no slot information";
          }    
  }
  public function GetUserBookList()
  {
    date_default_timezone_set("Asia/Manila");
    // $code_type =  $this->input->get("code_type");
    $code =  $this->input->get("code");        
    // $date = date("Y-m-d", strtotime("today"));
    $d = $this->db->get_where('booking',['code'=>$code])->result_array();
    // $d = $this->db->get_where('booking',['code_type'=>$code_type,'code'=>$code,'date'=>$date])->result_array();

    if ($d != NULL )
        echo  json_encode($d);  
    else
        echo  json_encode("No Data");
  }
  public function GetUserBookAllList()
  {
    date_default_timezone_set("Asia/Manila");
    $code_type =  $this->input->get("code_type");
    $code =  $this->input->get("code");
    
    $d = $this->db->get_where('booking',['code_type'=>$code_type,'code'=>$code])->result_array();
    if ($d != NULL )
        echo  json_encode($d);  
    else
        echo  json_encode("No Data");
  }
  public function fillTimeInTimeOuts($book_id, $start_time_equi, $end_time_equi){
    $this->db->where('id', $book_id); 
    $this->db->update('booking', [
      'in_time' => $start_time_equi,
      // 'in_status' => 'occupied',
      // 'out_status' => 'exit',
      'in_status' => 'late-in',
      'out_status' => 'late-exit',
      'out_time' => $end_time_equi]);
  }

  public function fillTimeOuts($book_id, $end_time_equi){
    $this->db->where('id', $book_id); 
    $this->db->update('booking', [
      'out_status' => 'late-exit',
      'out_time' => $end_time_equi]);
  }
  public function CancelBook()
  {
    date_default_timezone_set('Asia/Manila');

    // $code =  $this->input->get("code");      
    $book_id =  $this->input->get("book_id");        

    $this->db->where('id', $book_id);
    $this->db->where('in_time IS NULL');
    $this->db->where('out_time IS NULL');
    $this->db->order_by('id', 'DESC'); 
    $this->db->limit(1); 
    $data  = $this->db->get('booking')->row_array();
    if(!$data){
      echo ("No Data.");
      return;
    }
    // $book_id = $data['id'];
    $start_time_index  = $data['start_time'];
    $end_time_index = $data['end_time'];

    $area_floor = $data['floor'];
    $area_name = $data['room'];
    $seat_slot = $data['slot_id'];
    $booking_date = $data['date'];
    $area_info = $this->db->get_where('area', array('floor' => $area_floor, 'room' => $area_name, ))->row_array();
    $open_time = strtotime($area_info['opentime']);
    $close_time = strtotime($area_info['closetime']);
    $timesIndex = array();
    $counter = 0; // Initialize counter
    for ($time = $open_time; $time <= $close_time; $time = strtotime('+1 hour', $time)) {
      $timesIndex[$counter] = date('H:i', $time);
      $counter++;
    }
    $start_time = $timesIndex[$start_time_index];
    $end_time = $timesIndex[$end_time_index];
    $current_date = date('Y-m-d');
    $slots_data = $this->db->get_where('slot', [
      'Floor' => $area_floor,
      'Room' => $area_name,
      'Slot' => $seat_slot,
      'date' => $booking_date
    ])->row_array();
    if (!$slots_data) {
      echo "No slot record";
      return;
    }
    $slot_status = $slots_data['status'];
    // echo $slot_status;

    $slot_status = substr($slot_status, 1, -1);
    $slot_status = explode(',', $slot_status);
    //now that slot status is an array, change the value of the index to 0, starting from start_index to endtime_index
    foreach ($slot_status as &$status) {
      $status = 0;
    }
    $slot_status = '['. implode(',', $slot_status). ']';
    // echo $slot_status;
    //apply
    $this->db->where('Floor', $area_floor);
    $this->db->where('Room', $area_name);
    $this->db->where('Slot', $seat_slot);
    $this->db->where('date', $booking_date);
    $this->db->update('slot', ['status' => $slot_status]);
    //update the booking table with the out_time and out_status.
    $this->db->where('id', $book_id);
    $this->db->update('booking', [
      'in_time' => date('H:i:s'),
      'in_status' => 'cancelled',
      'out_status' => 'cancelled', 
      // 'in_status' => 'occupied',
      // 'out_status' => 'exit',
      'out_time' => date('H:i:s')]);
    
    echo "successfully cancelled";

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
  // public function SeatTimeOut()
  // {
  //   date_default_timezone_set("Asia/Manila");
  //   $date = date('H:i:s', time());

  //   $book_id = $this->input->get('book_id');
  //   $data  =$this->db->get_where('booking', ['id' => $book_id])->row_array();
  //   if($data){
  //     $queryUpdate = "UPDATE `booking` SET `out_time` = '" . $date . "', `out_status` = 'exit'  WHERE  `id` = '$book_id'";                    
  //     $this->db->query($queryUpdate);
  //     echo "time out success";
  //   }
  //   else{
  //     echo "no booking record";
  //     return;
  //   }
  // }

  public function SeatTimeOut(){
    date_default_timezone_set("Asia/Manila");
    $book_id = $this->input->get('book_id');

    $data  =$this->db->get_where('booking', ['id' => $book_id])->row_array();
    if(!$data){
      echo 'no booking record';
      return;
    }

    //get the endtime of the reservation
    $end_time = $data['end_time'];
    $current_time = date('H:i:s');
    $current_time_format = date('H:i', strtotime($current_time));
    $area_floor = $data['floor'];
    $area_name = $data['room'];
    $seat_slot = $data['slot_id'];
    $booking_date = $data['date'];
    $area_info = $this->db->get_where('area', array('floor' => $area_floor, 'room' => $area_name, ))->row_array();
    $open_time = strtotime($area_info['opentime']);
    $close_time = strtotime($area_info['closetime']);
    $timesIndex = array();
    $counter = 0; // Initialize counter
    for ($time = $open_time; $time <= $close_time; $time = strtotime('+1 hour', $time)) {
      $timesIndex[$counter] = date('H:i', $time);
      $counter++;
    }
    $end_time = $timesIndex[$end_time];
    $end_time_format = date('H:i', strtotime($end_time));
    //get the current time for comparison
    if ($data){
      $end_time_format = new DateTime($end_time_format);
      $current_time = new DateTime($current_time_format);

      // Compare the two times
      if ($current_time < $end_time_format) {
        //get more details for data extraction from area table
        $area_info_floor = $data['floor'];
        $area_info_room = $data['room'];
        $area_info_seat = $data['slot_id'];
        $area_info_date =  $data['date'];
        
        //execute the query
        $area_details = $this->db->get_where('area', array('Floor' => $area_info_floor, 'Room' => $area_info_room))->row_array();
        
        if (!$area_details) {
          echo "no area record";
          return;
        }

        //now that you got the details of the area, look for seat status by comparing the details to slot table.
        $slots_data = $this->db->get_where('slot', [
            'Floor' => $area_info_floor,
            'Room' => $area_info_room,
            'Slot' => $area_info_seat,
            'date' => $area_info_date
        ])->row_array();

        if (!$slots_data) {
          echo "no slot record";
          return;
        }
        //compare dates from the booking and slot table.
        $data_date = date('Y-m-d', strtotime(trim($data['date'])));
        $slots_date = date('Y-m-d', strtotime(trim($slots_data['date'])));

        if ($data_date == $slots_date) {
          //get the opening time and closing time of the area
          $open_time = strtotime($area_details['opentime']);
          $close_time = strtotime($area_details['closetime']);

          //initialize an array to store the time slots of the area
          $times = array();

          //generate the time slots
          $counter = 0; // Initialize counter
          for ($time = $open_time; $time <= $close_time; $time = strtotime('+1 hour', $time)) {
            $times[$counter] = date('H:i', $time);
            // echo $times[$counter];
            $counter++;
          }

          //explode the status of the slots
          if (!is_array($slots_data['status'])) {
            $slots_data['status'] = explode(',', trim($slots_data['status'], '[]')); // Clean up potential extra brackets
          }

          //since the time here is less than the reservation endtime, the seat will be made availble
          //for example, the resrvation was for 1pm-4pm and the user timedout at 3:30
          //we will ignore the  30 minutes and get only 3:00pm.
          $datetime = new DateTime($current_time_format);
          $datetime->setTime($datetime->format('H'), 0, 0);
          $rounded_time = $datetime->format('H:i');

          //now we will be mapping where the start and end time are in the array.
          $start_index = array_search($rounded_time, $times);
          // $end_index = array_search($end_time_format, $times);
          $end_index = array_search($end_time, $times);

          if ($start_index !== false && $end_index !== false) {
            // Loop through the indices to mark the slots as available (0)
            for ($i = $start_index; $i < $end_index; $i++) {
                if (isset($slots_data['status'][$i])) {
                    if ($slots_data['status'][$i] == 1) {
                        $slots_data['status'][$i] = 0;
                    } 
                } 
            }
            // Update the slots in the database
            $this->db->where('Floor', $area_info_floor);
            $this->db->where('Room', $area_info_room);
            $this->db->where('Slot', $area_info_seat);
            $this->db->where('date', $area_info_date);
            // Convert the array back to the string format
            $updated_slots = implode(',', $slots_data['status']);
            // To ensure the format is [0,0,0,0,0,0,0,0,1,0,0], wrap the result with square brackets
            $updated_slots = '[' . $updated_slots . ']';

            $current_time_format = date('H:i:s');
            $this->db->update('slot', ['status' => $updated_slots]);
            $this->db->where('id', $book_id);
            $this->db->update('booking', [
              'out_status' => 'early-exit',
              // 'out_status' => 'exit',
              'out_time' => $current_time_format]);
              echo 'time out success';
            // echo 'Pag nag display to, success. dapat mag freeup ng space kung early timeout.';
        } //end of if for indeces
      }//end of if current time < end time
      else if ($current_time >= $end_time){
        $this->db->where('id', $book_id);
        $this->db->update('booking', [
          'out_status' => 'late-exit',
          'out_time' => $end_time]);
        echo 'time out success';
        // echo 'Pag nag display to, success timeout na hindi magfreeup yung space kasi gamit na. late timeout lang ganon.';
      } 

      }
    }//end of if data exists.



    
  }

  public function UserGetInfo()
  {
    date_default_timezone_set("Asia/Manila");
    $code_type = $this->input->get("code_type");
    $code = $this->input->get("code");
    
      if($code_type=='QR' || $code_type=='qr') {
          $data  =$this->db->get_where('student', ['qrcode' => $code])->row_array();
      } 
      else if ($code_type == "rfid" || $code_type == "RFID") {
          $data  =$this->db->get_where('student', ['rfid' => $code])->row_array();
      }else{
          $data  =$this->db->get_where('student', ['pin' => $code])->row_array();
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
      //since always pang student 'to. get the student srcode.
      $rfid = $data['rfid'];
      $qr = $data['qrcode'];
      $pin = $data['pin'];
      // echo '<br>';
      // echo "RFID: " . $rfid . " QR: " . $qr;


      //compare the srcode to the booking. get the latest booking.
      // $this->db->where('id');
      // Fetch booking data
      $this->db->where(['code' => $rfid]);
      $this->db->or_where(['code' => $qr]);
      $this->db->or_where(['code' => $pin]);
      // $this->db->limit(1);
      $booking_data = $this->db->get('booking')->result_array();

      // Get current date
      $current_date = date('Y-m-d');
      // echo "Current Date: " . $current_date . "<br>";

      foreach ($booking_data as $booking) {
          // Extract booking details
          $date = $booking['date'];
          // echo "Booking Date: " . $date . "<br>";
          
          $start_time = $booking['start_time'];
          $end_time = $booking['end_time'];
          $area_floor = $booking['floor'];
          $area_name = $booking['room'];
          $seat_slot = $booking['slot_id'];
          $booking_date = $booking['date'];
          $in_time = $booking['in_time'];
          $out_time = $booking['out_time'];
          
          if ($in_time == NULL || $out_time == NULL) {
            // Get area info
            $area_info = $this->db->get_where('area', ['floor' => $area_floor, 'room' => $area_name])->row_array();
            $open_time = strtotime($area_info['opentime']);
            $close_time = strtotime($area_info['closetime']);

            // Generate time slots
            $timesIndex = [];
            for ($time = $open_time, $counter = 0; $time <= $close_time; $time = strtotime('+1 hour', $time), $counter++) {
                $timesIndex[$counter] = date('H:i', $time);
            }

            // Get the current time
            $current_time = date('H:i:s');
            $current_time_format = date('H:i', strtotime($current_time));
            $start_time_equi = $timesIndex[$start_time];
            $end_time_equi = $timesIndex[$end_time];

            // Convert to DateTime objects
            $current_time_object = new DateTime($current_time_format);
            $end_time_object = new DateTime($end_time_equi);
            $start_time_object = new DateTime($start_time_equi);
            $start_time_object->sub(new DateInterval('PT1H'));

            // Booking validation logic
            if ($date == $current_date) {
                if ($current_time_object <= $end_time_object && $current_time_object >= $start_time_object) {
                    // User is allowed to time in and out.
                } elseif ($current_time_object < $start_time_object) {
                    // User is early; do nothing.
                } elseif ($current_time_object > $end_time_object) {
                    // User is late.
                    if ($booking['in_time'] == NULL) {
                        $this->fillTimeInTimeOuts($booking['id'], $start_time_equi, $end_time_equi);
                    } elseif ($booking['out_time'] == NULL && $booking['in_time'] != NULL) {
                        $this->fillTimeouts($booking['id'], $end_time_equi);
                    }
                }
                //dec 3 < dec 4
            } else if ($current_date > $date) {
                $this->fillTimeInTimeOuts($booking['id'], $start_time_equi, $end_time_equi);
            } else if ($current_date < $date) {
              //FIXED !
            }
          }
      }
      echo json_encode($data) ;   
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
    if($code_type=='QR' || $code_type=='qr')
      $data  =$this->db->get_where('student', ['qrcode' => $code])->row_array();
    else if ($code_type == "rfid" || $code_type == "RFID")
      $data  =$this->db->get_where('student', ['rfid' => $code])->row_array();
    else
      $data  =$this->db->get_where('student', ['pin' => $code])->row_array();

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
     else if ($code_type == "rfid" || $code_type == "RFID"){
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
    else {
      $data = array(            
        'username' => $username,                     
        'qrcode' => "",
        'RFID' => "", 
        'pin' => $code,    
        'srcode' => $srcode,   
        'kiosk' => $kiosk_id,
        'in_time' => $date,
        'date' => $Sdate
      );
    }
    $this->db->insert('attend', $data);

    // $this->load->controller('Master');
    $type = 'stud_timein';
    $this->load->model('Notif_model');
    $this->Notif_model->notifications($type, $data);
    // $this->master->notifications($type, $data);

    echo "time in success";
    }
  }
  public function TimeOut()
  {
      date_default_timezone_set("Asia/Manila");
      $Sdate = date('Y-m-d');    // today     
      $date = date('Y-m-d H:i:s', time());  
      $code_type = $this->input->get("code_type");  // QR or RFID
      $code = $this->input->get("code");       // QR or RFID code
      $kiosk_id = $this->input->get("kiosk_id");  // kiosk id
      
      // Check the code type and adjust the query condition accordingly
      if ($code_type == 'rfid' || $code_type == 'RFID') {
          $data = $this->db->get_where('attend', ['rfid' => $code, 'date' => $Sdate, 'out_time' => NULL])->row_array();
      } else if ($code_type == 'qr' || $code_type == 'QR') {
          $data = $this->db->get_where('attend', ['qrcode' => $code, 'date' => $Sdate, 'out_time' => NULL])->row_array();
      } else if ($code_type == 'pin' || $code_type == 'PIN') {
          $data = $this->db->get_where('attend', ['pin' => $code, 'date' => $Sdate, 'out_time' => NULL])->row_array();
      } else {
          echo "Invalid code type";
          return;
      }
  
      if ($data == NULL) {
          echo "Today Date: ".$Sdate. " Code: ".$code. " kiosk: ".$kiosk_id. " code_type: ".$code_type. " Date: ".$date;
          echo "<br>";
          echo "no entry data";
      } else {
          $id = $data['id'];
          $update_data = [
              'out_time' => $date
          ];
          $this->db->update('attend', $update_data, ['id' => $id]);
  
          $type = 'stud_timeout';
          $this->load->model('Notif_model');
          $this->Notif_model->notifications($type, $data);
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
  
  // $checkPass = $this->db->get_where('student', ['password' => $password])->row_array();

  // if($checkPass)
  // {
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
          $type = 'stud_timeout';
          $this->load->model('Notif_model');
          $this->Notif_model->notifications($type, $data);
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
          $type = 'stud_timein';
          $this->load->model('Notif_model');
          $this->Notif_model->notifications($type, $data);
          echo "time in success";
        }
      }   
  // } 
  // else {
  //   echo 'No Pass or Wrong Pass';
  // }

  
}
  public function GetSmallImageList()
  {
    $imgList = glob('assets/images_S/*.{png,jpg,jpeg,gif,webp}', GLOB_BRACE);
    foreach($imgList as $filename){
      if(is_file($filename)){
        echo base_url().$filename.'|';
      }   
    }

  }
  public function GetBigImageList()
  {
    $imgList = glob('assets/images_S/*.{png,jpg,jpeg,gif,webp}', GLOB_BRACE);
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

      public function prefillTimeIns(){

        // date_default_timezone_set("Asia/Manila");
        // $book_id = $this->input->get('book_id');
        // $data  =$this->db->get_where('booking', ['id' => $book_id])->row_array();
        // if($data){
        //   // get the current time.
        // $current_time = date('H:i:s');
        // //convert current time to 12 hour format.
        // $current_time_format = date('h:i A', strtotime($current_time));

        // //get the current date.
        // $current_date = date('Y-m-d');
        // //get the end_time from the database
        // // $bookings = $this->db->get('booking')->result();
        // $booking = $this->db->get_where('booking', ['id' => $book_id])->row();
        //   $end_time = $booking->end_time;
        //   $end_time_format = "";

        //   if ($end_time >= 1 && $end_time <= 6) {
        //       $end_time_format = $end_time. ':00 PM';
        //   }
        //   elseif ($end_time >= 7 && $end_time <= 12) {
        //       $end_time_format = $end_time. ':00 AM';
        //   }
        //     if(strtotime($end_time_format) <= strtotime($current_time_format)){
        //         if ($booking->in_time == NULL){
        //             // autofill the in_time and the out_time
        //             $this->db->where('id', $booking->id);
        //             $this->db->update('booking', ['in_time' => $current_time, 'out_time' => $current_time, 'out_status' => 'auto-exit', 'in_status' => 'auto-in']);
        //             echo 'Data autofilled';
        //             // echo "Booking ID: ".$booking->id." updated with in_time: ".$current_time." and out_time: ".$current_time."<br><br>";
        //         }
        //         else{
        //           echo 'No data';
        //         }
        //     }
        //     else{
        //         echo 'The end time is not over yet.<br><br>';
        //     }
          
        // }else{
        //   echo "No booking data";
        // }
        
    }


      // public function handleMissingTimeouts(){
      //     // Set timezone to Asia/Manila for accurate time calculations
      //     date_default_timezone_set("Asia/Manila");

      //     $book_id = $this->input->get('book_id');
      //     $data  =$this->db->get_where('booking', ['id' => $book_id])->row_array();

      //     // Set default out time
      //     $default_out_time = '23:59:59';

      //     // Get yesterday's date
      //     $yesterday = date('Y-m-d', strtotime('-1 day'));
      //     // get the current date
      //     $current_date = date('Y-m-d');

      //     // Find bookings with `in_time` but no `out_time` where `in_time` is before today (i.e., from yesterday or earlier)
      //     $query = "SELECT id, date, in_time 
      //               FROM `booking` 
      //               WHERE `in_time` IS NOT NULL 
      //                 AND `out_time` IS NULL 
      //                 AND `date` < ?";  // Ensure the date comparison is correct
      //     $bookings = $this->db->query($query, [$current_date])->result_array();

      //     if ($bookings) {
      //         foreach ($bookings as $booking) {
      //             $book_id = $booking['id'];
      //             $in_time = $booking['in_time'];

      //             // Output the in_time for debugging
      //             echo "Booking ID: $book_id, In Time: $in_time\n";

      //             // Check if `in_time` is valid
      //             if ($in_time && strtotime($in_time) !== false) {
      //                 // Use the valid `in_time` to set the `out_time`
      //                 $updateQuery = "UPDATE `booking` 
      //                                 SET `out_time` = ?, 
      //                                     `out_status` = 'auto-exit' 
      //                                 WHERE `id` = ?";
      //                 $this->db->query($updateQuery, [$default_out_time, $book_id]);
      //                 echo "Booking ID $book_id updated with out_time: " . date('Y-m-d H:i:s') . "\n";
      //             } else {
      //                 // If `in_time` is invalid, use a fallback value or skip
      //                 echo "Invalid in_time for booking ID: $book_id. Skipping update.\n";
      //             }
      //         }
      //         echo "Missing timeouts updated.";
      //     } else {
      //         echo "No missing timeouts found.";
      //     }
      // }


      public function prefillTimeouts(){
        // // Set timezone to Asia/Manila for accurate time calculations
        // date_default_timezone_set("Asia/Manila");

        // $book_id = $this->input->get('book_id');
        // $data  =$this->db->get_where('booking', ['id' => $book_id])->row_array();

        // // Set default out time
        // $default_out_time = '23:59:59';

        // // Get yesterday's date
        // $yesterday = date('Y-m-d', strtotime('-1 day'));
        // // get the current date
        // $current_date = date('Y-m-d');
        // $in_time = $data['in_time'];
        // if ($data['out_time'] == NULL && $data['in_time'] != NULL && $data['date'] < $current_date) {
        //   echo "Booking ID: $book_id, In Time: $in_time\n";
        //   if ($in_time && strtotime($in_time) !== false) {
        //       // Use the valid `in_time` to set the `out_time`
        //       $updateQuery = "UPDATE `booking` 
        //                       SET `out_time` = ?, 
        //                           `out_status` = 'auto-exit' 
        //                       WHERE `id` = ?";
        //       $this->db->query($updateQuery, [$default_out_time, $book_id]);
        //       echo 'Data autofilled';
        //       // echo "Booking ID $book_id updated with out_time: " . $default_out_time . "<br>";
        //   }
        // }else{
        //   echo "No missing timeouts found.";
        // }
    }


    public function prefillBookingData() {
      // // Set timezone to Asia/Manila for accurate time calculations
      // date_default_timezone_set("Asia/Manila");
  
      // $book_id = $this->input->get('book_id');
      // $data = $this->db->get_where('booking', ['id' => $book_id])->row_array();
  
      // if (!$data) {
      //     echo "No booking data found.";
      //     return;
      // }
  
      // // Get current date and time
      // $current_time = date('H:i:s');
      // $current_time_format = date('h:i A', strtotime($current_time));
      // $current_date = date('Y-m-d');
      // $default_out_time = '23:59:59';
  
      // $in_time = $data['in_time'];
      // $out_time = $data['out_time'];
      // $date = $data['date'];

      // if (strtotime($date) < strtotime($current_date)) {
      //   $this->db->where('id', $book_id);
      //   $this->db->update('booking', [
      //       'in_time' => $in_time ?? '00:00:00', // Default to the start of the day if null
      //       'out_time' => $out_time ?? $default_out_time, // Default to the end of the day if null
      //       'in_status' => $in_time ? $data['in_status'] : 'occupied',
      //       'out_status' => $out_time ? $data['out_status'] : 'exit'
      //   ]);
      //   echo "Past booking autofilled.";
      //   return;
      // }

      // // Case 1: Prefill `in_time` and `out_time` when `in_time` is NULL
      // if ($in_time === NULL) {
      //     // Get the end time and format it
      //     $booking = $this->db->get_where('booking', ['id' => $book_id])->row();
      //     $end_time = $booking->end_time;
      //     $end_time_format = "";
  
      //     if ($end_time >= 1 && $end_time <= 6) {
      //         $end_time_format = $end_time . ':00 PM';
      //     } elseif ($end_time >= 7 && $end_time <= 12) {
      //         $end_time_format = $end_time . ':00 AM';
      //     }
  
      //     if (strtotime($end_time_format) <= strtotime($current_time_format)) {
      //         $this->db->where('id', $booking->id);
      //         $this->db->update('booking', [
      //             'in_time' => $current_time,
      //             'out_time' => $current_time,
      //             'in_status' => 'occupied',
      //             'out_status' => 'exit'
      //         ]);
      //         echo "In and out times autofilled.";
      //     } else {
      //         echo "The end time is not over yet.";
      //     }
      //     return;
      // }
  
      // if ($out_time === NULL && $in_time !== NULL) {
      //       // Get the end time and format it
      //       $booking = $this->db->get_where('booking', ['id' => $book_id])->row();
      //       $end_time = $booking->end_time;
      //       $end_time_format = "";
    
      //       if ($end_time >= 1 && $end_time <= 6) {
      //           $end_time_format = $end_time . ':00 PM';
      //       } elseif ($end_time >= 7 && $end_time <= 12) {
      //           $end_time_format = $end_time . ':00 AM';
      //       }
      //       if (strtotime($end_time_format) <= strtotime($current_time_format)) {
      //           $this->db->where('id', $booking->id);
      //           $this->db->update('booking', [
      //               'out_time' => $current_time,
      //               'out_status' => 'exit'
      //           ]);
      //           echo "Out time autofilled.";
      //       } else {
      //           echo "The end time is not over yet.";
      //       }
      //   } else {
      //       echo "No missing timeouts or data to autofill.";
      // }
      // // return;
  }

  public function bookingStatusCheck(){
    // Set timezone to Asia/Manila for accurate time calculations
    date_default_timezone_set("Asia/Manila");
    //get the data from the tap
    $book_id = $this->input->get('book_id');

    $data = $this->db->get_where('booking', ['id' => $book_id])->row_array();
    if (!$data) {
        echo "No booking data found.";
        return;
    }
    echo '<pre>';
    print_r($data);
    echo '<pre>';

    //check if the booking has time in.
    $in_time = $data['in_time'];
    $out_time = $data['out_time'];

    echo "<br>";
    echo $in_time . "<br>";
    echo $out_time . "<br>";

    // check the booking date, booking start_time, and end_time.
    $date = $data['date'];
    $start_time = $data['start_time'];
    $end_time = $data['end_time'];

    echo "<br>";
    echo $date . "<br>";
    echo  "Start time Index: " . $start_time . "<br>";
    echo "End time Index: " . $end_time . "<br>";

    //get the current time and make sure it is correctly formatted
    $current_time = date('H:i:s');
    $current_time_format = date('H:i', strtotime($current_time));

    echo "<br>";
    echo  "Current Time: " . $current_time . "<br>";
    echo "Current Time Format: " . $current_time_format . "<br>";

    //get the details of the booking and compare it to the slot database to get the details of the slot.
    $area_floor = $data['floor'];
    $area_name = $data['room'];
    $seat_slot = $data['slot_id'];
    $booking_date = $data['date'];
    echo "<br>";
    echo "Area Floor: " . $area_floor . "<br>";
    echo "Area Name: " . $area_name . "<br>";
    echo "Seat Slot: " . $seat_slot . "<br>";
    echo "Booking Date: " . $booking_date . "<br>";

    $area_info = $this->db->get_where('area', array('floor' => $area_floor, 'room' => $area_name, ))->row_array();

    echo "<br>";
    echo '<pre>';
    print_r($area_info);
    echo '<pre>';
    //get the open time and close time of the area.
    $open_time = strtotime($area_info['opentime']);
    $close_time = strtotime($area_info['closetime']);

    echo "<br>";
    echo "Open Time: " . $open_time . "<br>";
    echo "Close Time: " . $close_time . "<br>";
    
    $timesIndex = array();
    $counter = 0; // Initialize counter
    for ($time = $open_time; $time <= $close_time; $time = strtotime('+1 hour', $time)) {
      $timesIndex[$counter] = date('H:i', $time);
      $counter++;
    }

    echo "<br>";
    echo "Times Index: ";
    echo implode(', ', $timesIndex);
    echo "<br>";

    //loop through all times and get the index of the start time.
    //initialize counter
    echo 'Again, Start Time Index is: ' . $start_time . "<br>";
    echo 'Now, lets print the timesIndex Array' . "<br>";
    print_r($timesIndex);
    echo "<br>";
    echo "The first index of the timesIndex Array is: " . $timesIndex[0] . "<br>";
    echo "Therefore, the start time is: " . $timesIndex[$start_time] . "<br>";
    //Now, set the start_time_equi and end_time_equi

    $start_time_equi = $timesIndex[$start_time];
    $end_time_equi = $timesIndex[$end_time];
    echo "The start time is: " . $start_time_equi . "<br>";
    echo "The end time is: " . $end_time_equi . "<br>";
    

    //get the current date
    $current_date = date('Y-m-d');
    echo "<br>";
    echo "The current date is: " . $current_date . "<br>";
    echo "The current time is: " . $current_time_format . "<br>";
    echo "The booking date is: " . $booking_date . "<br>";
    
    //check if the current time is less than the end time
    //but first, make time object for two for comparison to work
    $current_time_object = new DateTime($current_time_format);

    $end_time_object = new DateTime($end_time_equi);
    //subrtract 1 hour from the start_time_equi
    $start_time_object = new DateTime($start_time_equi);
    $start_time_object->sub(new DateInterval('PT1H'));

    echo "<br>";
    echo "The current time object is: " . $current_time_object->format('H:i') . "<br>";
    echo "The start time object - 1 hour is: " . $start_time_object->format('H:i') . "<br>";
    echo "The end time object is: " . $end_time_object->format('H:i') . "<br>";
    echo "The current date is: " . $current_date . "<br>";
    echo "The booking date is: " . $booking_date . "<br>";



    //now compare
    //if the current time is between an hour earlier than the start_time, and the end time, then the user is still allowed to time in and out.
    if ($current_time_object <= $end_time_object && $current_time_object >= $start_time_object) {
      echo "The current time is between the start and end time." . "<br>";
      //EARLIER
          //if the booking date is the same as the current date, then let the user do its thing
          if($current_date == $booking_date){
            //if the user has not yet timed in, let the user time in.
            if($in_time == null){
              $timeInDetails = $this->db->get_where('booking', ['id' => $book_id])->row_array();
              if ($timeInDetails){
                $this->db->where('id', $book_id);
                $this->db->update('booking', [
                  'in_time' => $current_time,
                  'in_status' => 'occupied'
                ]);
                echo "time in success";
              }
              else{
                echo "No booking data found.";
              }
            }
            //if the user has timedin already but not yet timed out.
            else if($in_time != null && $out_time == null){
              $area_info_floor = $data['floor'];
              $area_info_room = $data['room'];
              $area_info_seat = $data['slot_id'];
              $area_info_date =  $data['date'];
              echo "Area info: " . $area_info_floor . ", " . $area_info_room . ", " . $area_info_seat . ", " . $area_info_date . "<br>";

              $area_details = $this->db->get_where('area', array('Floor' => $area_info_floor, 'Room' => $area_info_room))->row_array();
              echo "Area details: ";
              echo '<pre>';
              print_r($area_details);
              echo '</pre>';
              echo "<br>";
              if (!$area_details) {
                echo "no area record";
                return;
              }
              $slots_data = $this->db->get_where('slot', [
                  'Floor' => $area_info_floor,
                  'Room' => $area_info_room,
                  'Slot' => $area_info_seat,
                  'date' => $area_info_date
              ])->row_array();
              echo "Slot details: ";
              echo '<pre>';
              print_r($slots_data);
              echo '</pre>';
              echo "<br>";
              if (!$slots_data) {
                echo "no slot record";
                return;
              }
              //compare dates from the booking and slot table.
              $data_date = date('Y-m-d', strtotime(trim($data['date'])));
              $slots_date = date('Y-m-d', strtotime(trim($slots_data['date'])));

              if ($data_date == $slots_date) {
                //get the opening time and closing time of the area
                $open_time = strtotime($area_details['opentime']);
                $close_time = strtotime($area_details['closetime']);

                echo 'Opening Time: '.$open_time . "<br>";
                echo 'Closing Time: '.$close_time . "<br>";


                if (!is_array($slots_data['status'])) {
                  $slots_data['status'] = explode(',', trim($slots_data['status'], '[]')); // Clean up potential extra brackets
                }
                echo '<pre>';
                print_r($slots_data['status']);
                echo '</pre>';

                //since the time here is less than the reservation endtime, the seat will be made availble
                //for example, the resrvation was for 1pm-4pm and the user timedout at 3:30
                //we will ignore the  30 minutes and get only 3:00pm.
                $datetime = new DateTime($current_time_format);
                $datetime->setTime($datetime->format('H'), 0, 0);
                $rounded_time = $datetime->format('H:i');
                echo 'Rounded Time: ' . $rounded_time . "<br>";

                //now we will be mapping where the start and end time are in the array.
                //in this case, the start time will be the rounded time
                $start_index = array_search($rounded_time, $timesIndex);
                $end_index = array_search($end_time_equi, $timesIndex);
                echo 'Times Index: ';
                echo '<pre>';
                print_r($timesIndex);
                echo '</pre>';
                echo '<br>';
                echo 'Start Index: '. $start_index . "<br>";
                echo 'End Index: '. $end_index . "<br>";
                if ($start_index !== false && $end_index !== false) {
                  // Loop through the indices to mark the slots as available (0)
                  for ($i = $start_index; $i < $end_index; $i++) {
                      if (isset($slots_data['status'][$i])) {
                          if ($slots_data['status'][$i] == 1) {
                              $slots_data['status'][$i] = 0;
                          } 
                      } 
                  }
                }
                echo 'The slot status is now: ' . json_encode($slots_data['status']) . '<br>';
                // Update the slots in the database
                $this->db->where('Floor', $area_info_floor);
                $this->db->where('Room', $area_info_room);
                $this->db->where('Slot', $area_info_seat);
                $this->db->where('date', $area_info_date);
                $updated_slots = implode(',', $slots_data['status']);
                $updated_slots = '[' . $updated_slots . ']';
                $this->db->update('slot', ['status' => $updated_slots]);
                $this->db->where('id', $book_id);
                $this->db->update('booking', [
                  'out_status' => 'exit',
                  'out_time' => $current_time_format]);
                echo 'timeout sucess';
              }
            }
          }
          //else, if dates are not the same or the end time is over, then fill everything so the user can reserve again. 
          else{
            $this->db->where('id', $book_id);
            $this->db->update('booking', [
              'out_status' => 'exit',
              'out_time' => $end_time_equi]);
            echo 'timeout sucess';
          }
      } 
    //this could mean that the user is trying to time in ahead of the reservaftion time.
    else if ($current_time_object < $start_time_object){
      //if ifs on a different date, then ofcourse we need to fill everything.
        if ($current_date != $booking_date){
          //check if the in_time is null
          if ($in_time == null || $out_time == null) {
            $this->db->where('id', $book_id); 
            $this->db->update('booking', [
              'in_time' => $start_time_equi,
              'in_status' => 'occupied',
              'out_status' => 'exit',
              'out_time' => $end_time_equi]);
            echo 'timeout sucess';
          }
        }
        else if ($current_date == $booking_date){
          echo 'do nothing and wait for your time.';
        }
      
    }
    //this means that the user forgots to timeout.
    else if ($current_time_object > $end_time_object){
      //no need to check for dates. just check if the in_time is null
      if ($in_time == null || $out_time == null) {
        $this->db->where('id', $book_id); 
        $this->db->update('booking', [
          'in_time' => $start_time_equi,
          'in_status' => 'occupied',
          'out_status' => 'exit',
          'out_time' => $end_time_equi]);
        echo 'autofill reservation sucess';
      }
    }
      // echo "The current time is later than the end time. Booking has no time out yet.";
      
  }
  
}


