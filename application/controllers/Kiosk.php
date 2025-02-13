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
            $open_time = $roominfo->opentime;
            $close_time = $roominfo->closetime;
            //get the area information.
            $start_hour = (int)date('H', strtotime($open_time));
            $end_hour = (int)date('H', strtotime($close_time));
            // Generate the hourly ranges and fill the array with zeros
            for ($i = $start_hour; $i < $end_hour; $i++) {
                $hour_ranges[] = "$i-" . ($i + 1); // Example: "8-9", "9-10"
                $hour_blocks[] = 0;                // Add 0 for each hour block
            }
            

            //convert hourblocks to string.
            $hour_blocks_string = '[' . implode(',', $hour_blocks) . ']';
            
            $data = array(
                'date' => $date,
                'Floor' => $floorname,
                'Room' => $roomname,
                'Slot' => $slot,
                'status' => $hour_blocks_string
                //the culprit
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

        if($code_type=='QR' || $code_type=='qr'){
        $data  =$this->db->get_where('student', ['qrcode' => $code])->row_array();
        }
        else if ($code_type == "rfid" || $code_type == "RFID"){
        $data  =$this->db->get_where('student', ['rfid' => $code])->row_array();
        }
        else if ($code_type == "pin" || $code_type == "PIN"){
        $data  =$this->db->get_where('student', ['pin' => $code])->row_array();
        }

        if($data == NULL){
        echo "no student record";
        return;
        }
        else{
        $srcode = $data['srcode'];
        $username = ($data['first_name'].' '.$data['last_name']) ; 
            
        if($code_type=='QR' || $code_type=='qr'){
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
        else if  ($code_type == "pin" || $code_type == "PIN"){
        $data = array(            
            'username' => $username,                     
            'pin' => $code,    
            'srcode' => $srcode,   
            'kiosk' => $kiosk_id,
            'in_time' => $date,
            'date' => $Sdate
        );
        }
        $this->db->insert('attend', $data);

        // $this->load->controller('Master');
        // $type = 'stud_timein';
        // $this->load->model('Notif_model');
        // $this->Notif_model->notifications($type, $data);
        // $this->master->notifications($type, $data);

        echo "time in success";
        }
    }
    public function TimeOut()
    {
        date_default_timezone_set("Asia/Manila");
        $Sdate = date('Y-m-d');    // today     
        $date = date('Y-m-d H:i:s', time());  
        $code_type = $this->input->get("code_type");  // QR or RFID or PIN
        $code = $this->input->get("code");       // QR or RFID code or Pin
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
            // echo "Today Date: ".$Sdate. " Code: ".$code. " kiosk: ".$kiosk_id. " code_type: ".$code_type. " Date: ".$date;
            // echo "<br>";
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
    public function TimeInOut()
    {
        date_default_timezone_set("Asia/Manila");
        // DATE TODAY
        $Sdate = date('Y-m-d', time());
        // DATE AND TIME TODAY
        $date = date('Y-m-d H:i:s', time());
    
        $code_type = $this->input->get("code_type");
        $code = $this->input->get("code");
        $kiosk_id = $this->input->get("kiosk_id");
        $isStudent = TRUE;
        // Check the code type and adjust the query condition accordingly
        if ($code_type == 'qr' || $code_type == 'QR') {
            $data = $this->db->get_where('student', ['qrcode' => $code])->row_array();
        } else if ($code_type == 'rfid' || $code_type == 'RFID') {
            $data = $this->db->get_where('student', ['rfid' => $code])->row_array();
        } else if ($code_type == 'pin' || $code_type == 'PIN') {
            $data = $this->db->get_where('student', ['pin' => $code])->row_array();
        } else {
            echo "invalid code type";
            return;
        }
    
        if ($data == NULL) {
            //check if the query is for faculty uncomment for additional pain in the ass
            // if ($code_type == 'qr' || $code_type == 'QR') {
            //     $data = $this->db->get_where('faculty', ['qrcode' => $code])->row_array();
            //     $isStudent = FALSE;
            // } else if ($code_type == 'rfid' || $code_type == 'RFID') {
            //     $data = $this->db->get_where('faculty', ['rfid' => $code])->row_array();
            //     $isStudent = FALSE;
            // } else if ($code_type == 'pin' || $code_type == 'PIN') {
            //     $data = $this->db->get_where('faculty', ['pin' => $code])->row_array();
            //     $isStudent = FALSE;
            // } else {
            //     echo "invalid code type";
            //     return;
            // }
            if ($data == NULL) {
            echo "no student record";
            return;
            }
        }
        //check the flag if true or false
        if ($isStudent) {
            $category = 'student';
        }
        else {
            $category = 'faculty';
        }
        // Check for today's attendance record with incomplete "out_time"
        $records = $this->db->get_where('attend', [
            'srcode' => $data['srcode'],
            'date' => $Sdate,
            'out_time' => NULL // Check if "out_time" is NULL
        ])->row_array();
        if ($records) {
            // If an incomplete record exists, proceed to "time-out"
            $this->db->where('id', $records['id']);
            $this->db->update('attend', ['out_time' => $date]);
            
            echo "time out success";
        } else {
            // Create a new "time-in" record
            $srcode = $data['srcode'];
            $username = ($data['first_name'] . ' ' . $data['last_name']);
    
            $data = [
                'username' => $username,
                'category' => $category,
                'qrcode' => ($code_type == 'qr' ? $code : ""),
                'RFID' => ($code_type == 'rfid' ? $code : ""),
                'pin' => ($code_type == 'pin' ? $code : ""),
                'srcode' => $srcode,
                'kiosk' => $kiosk_id,
                'in_time' => $date,
                'date' => $Sdate
            ];
    
            $this->db->insert('attend', $data);
            echo "time in success";
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

    public function TimeInOutforTest()
    {
        date_default_timezone_set("Asia/Manila");
        // DATE TODAY
        $Sdate = date('Y-m-d', time());
        // DATE AND TIME TODAY
        $date = date('Y-m-d H:i:s', time());
    
        $code_type = $this->input->post("code_type");
        $code = $this->input->post("code");
        $kiosk_id = $this->input->post("kiosk_id");
        $isStudent = TRUE;
        // Check the code type and adjust the query condition accordingly
        if ($code_type == 'qr' || $code_type == 'QR') {
            $data = $this->db->get_where('student', ['qrcode' => $code])->row_array();
        } else if ($code_type == 'rfid' || $code_type == 'RFID') {
            $data = $this->db->get_where('student', ['rfid' => $code])->row_array();
        } else if ($code_type == 'pin' || $code_type == 'PIN') {
            $data = $this->db->get_where('student', ['pin' => $code])->row_array();
        } else {
            // echo "invalid code type";
            //load the view Testing 
            redirect('manual/manualAttendance');
        }
    
        if ($data == NULL) {
            if ($data == NULL) {
            $this->session->set_flashdata('error', 'No student record found.');
            redirect('manual/manualAttendance');

            }
        }
        //check the flag if true or false
        if ($isStudent) {
            $category = 'student';
        }
        else {
            $category = 'faculty';
        }
        // Check for today's attendance record with incomplete "out_time"
        $records = $this->db->get_where('attend', [
            'srcode' => $data['srcode'],
            'date' => $Sdate,
            'out_time' => NULL // Check if "out_time" is NULL
        ])->row_array();
        if ($records) {
            // If an incomplete record exists, proceed to "time-out"
            $this->db->where('id', $records['id']);
            $this->db->update('attend', ['out_time' => $date]);
            
            $this->session->set_flashdata('success', 'Time out Success!');
            redirect('manual/manualAttendance');
        } else {
            // Create a new "time-in" record
            $srcode = $data['srcode'];
            $username = ($data['first_name'] . ' ' . $data['last_name']);
    
            $data = [
                'username' => $username,
                'category' => $category,
                'qrcode' => ($code_type == 'qr' ? $code : ""),
                'RFID' => ($code_type == 'rfid' ? $code : ""),
                'pin' => ($code_type == 'pin' ? $code : ""),
                'srcode' => $srcode,
                'kiosk' => "Manual",
                'in_time' => $date,
                'date' => $Sdate
            ];
    
            $this->db->insert('attend', $data);
            $this->session->set_flashdata('success', 'Time in Success!');
            redirect('manual/manualAttendance');
        }
    }

    public function reservationTesting()
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
            //GENERATE BY GETTING SEAT LIST FIRST
            $floorname =  $floor;
            $roomname =  $room;
            $d = $this->db->get_where('slot',['date'=>$date,'Floor'=>$floorname,'Room'=>$roomname])->result_array();        
            $roominfo = $this->db->get_where('area',['floor'=>$floorname,'room'=>$roomname])->row();
        
            if ($d != NULL )
            {
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
                if($timeslot[$stime] =='1' )
                {  // occupied 
                $this->session->set_flashdata('warning', 'Seat is already Occupied');
                $this->load->view('Testing');           
                }
                else{     // vacant 
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
                $this->session->set_flashdata('success', 'Reservation Success!');
                $this->load->view('Testing');
            }
            else {
                $this->session->set_flashdata('error', 'Reservation error!');
                $this->load->view('Testing');
            }
            }
            else{      
                $slot=0;
                $open_time = $roominfo->opentime;
                $close_time = $roominfo->closetime;
                //get the area information.
                $start_hour = (int)date('H', strtotime($open_time));
                $end_hour = (int)date('H', strtotime($close_time));
                // Generate the hourly ranges and fill the array with zeros
                for ($i = $start_hour; $i < $end_hour; $i++) {
                    $hour_ranges[] = "$i-" . ($i + 1); // Example: "8-9", "9-10"
                    $hour_blocks[] = 0;                // Add 0 for each hour block
                }
            

            //convert hourblocks to string.
            $hour_blocks_string = '[' . implode(',', $hour_blocks) . ']';
            
            $data = array(
                'date' => $date,
                'Floor' => $floorname,
                'Room' => $roomname,
                'Slot' => $slot,
                'status' => $hour_blocks_string
                //the culprit
            );
            
            $Max_slot=$roominfo->slotnumber;
            for ($slot=1;$slot<=$Max_slot;$slot++){
                $data['Slot'] = $slot;
                $this->db->insert('slot', $data);
            }               
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
                if($timeslot[$stime] =='1' )
                {  // occupied 
                $this->session->set_flashdata('warning', 'Seat is already Occupied');
                $this->load->view('Testing');           
                }
                else{     // vacant 
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
                $this->session->set_flashdata('success', 'Reservation Success!');
                $this->load->view('Testing');
            }
            else {
                $this->session->set_flashdata('error', 'Reservation error!');
                $this->load->view('Testing');
            }
        }
    }

    public function getSeatstest(){
        // Get POST data
        $room = $this->input->post('room');
        $floor = $this->input->post('floor');
        // Fetch seat data
        $seats = $this->db->get_where('area', ['room' => $room, 'floor' => $floor])->result_array();

        $floorname =  $floor;
        $roomname =  $room;
        $d = $this->db->get_where('slot',['date'=>$date,'Floor'=>$floorname,'Room'=>$roomname])->result_array();        
        $roominfo = $this->db->get_where('area',['floor'=>$floorname,'room'=>$roomname])->row();


        echo json_encode($seats);
    }

    // public function HttpGetTimeInOut()
    // {
    //     //get the timezone
    //     date_default_timezone_set("Asia/Manila");
    //     // DATE TODAY
    //     $Sdate = date('Y-m-d', time());
    //     // DATE AND TIME TODAY
    //     $date = date('Y-m-d H:i:s', time());
    //     //get the value of kiosk_id
    //     $kiosk_id = $this->input->get("kiosk_id");
    //     //get the username
    //     if ($this->input->get("username") !== null) {
    //       $userName = $this->input->get("username");
    //     }
    //     //get the password
    //     if ($this->input->get("password") !== null) {
    //       $userName = $this->input->get("password");
    //     }

    //     //get the srcode
    //     if ($this->input->get("studentID") !== null) {
    //       $studentID = $this->input->get("studentID");
    //     }

    //     //if they use codes, get code_type
    //     if ($this->input->get('code_type') !== null) {
    //       $code_type = $this->input->get("code_type");
    //     }

    //     if ($this->input->get('kiosk_id') !== null) {
    //         $kiosk_id = $this->input->get("kiosk_id");
    //     }

    //     if (isset($kiosk_id) && empty($kiosk_id) || !isset($kiosk_id)) {
    //         http_response_code(400);
    //         echo json_encode(array("status" => "error", "message" => "(kiosk_id) Empty parameter(s) detected."));
    //         return;
    //     }

    //     //validations
    //     if ($this->input->get('code') !== null) {
    //       // check if $code_type = either pin, rfid, or qr
    //     //   if ($code_type == 'pin' || $code_type == 'PIN') {
    //     if ($code_type == 'birthdate' || $code_type == 'BIRTHDATE') {
    //         $pin = $this->input->get("code");
    //       } else if ($code_type == 'rfid' || $code_type = 'RFID') {
    //         $rfid = $this->input->get("code");
    //       } else if ($code_type == "qr" || $code_type == 'QR'){
    //         $qr = $this->input->get('code');
    //       }else{
    //         http_response_code(400);
    //         echo json_encode(array("status" => "error", "message" => "Invalid input code."));
    //         return;
    //       }
    //     }
    //     //idk how this shit works. only god knows how. prolly not.
    //     if (isset($studentID) && empty($studentID) || !isset($studentID)) {
    //         http_response_code(400);
    //         echo json_encode(array("status" => "error", "message" => "(studentID) Empty parameter(s) detected."));
    //         return;
    //     }else{
    //         //check the three if empty or null.
    //         if (isset($code_type) && empty($code_type)){
    //             http_response_code(400);
    //             echo json_encode(array("status" => "error", "message" => "(codetype )Empty parameter(s) detected."));
    //             return;
    //         }else{
    //         if (isset($pin) && empty($pin) || isset($rfid) && empty($rfid) || isset($qr) && empty($qr)){
    //             http_response_code(400);
    //             echo json_encode(array("status" => "error", "message" => "(PIN RFID QR)Empty parameter(s) detected."));
    //             return;
    //         }else{
    //             if (isset($pin)) {
    //                 $data = $this->db->get_where('student', ['pin' => $pin, 'srcode' => $studentID])->row_array();
    //                 } 
    //             else if (isset($rfid)) {
    //                     $data = $this->db->get_where('student', ['pin' => $pin, 'srcode' => $studentID])->row_array();
    //                 } 
    //             else if (isset($qr)) {
    //                     $data = $this->db->get_where('student', ['pin' => $pin, 'srcode' => $studentID])->row_array();
    //                 }
    //             }
    //         }
    //     }
    //     //check the username and password if empty or null
    //     if (isset ($userName) && empty($userName) || isset($password) && empty($password)) {
    //         http_response_code(400);
    //         echo json_encode(array("status" => "error", "message" => "(UN PASS) Empty parameter(s) detected."));
    //         return;
    //     }
    //     else if (isset($userName) && !empty($userName) || isset($password) && !empty($password)) {
    //       $data = $this->db->get_where('student', ['username' => $userName])->row_array();
    //       //verification (in php hash)
    //       if ($data != NULL && password_verify($password, $data['password'])) {
    //           $data = $data;
    //       } else {
    //           http_response_code(400);
    //           echo json_encode(array("status" => "error", "message" => "Incorrect password."));
    //           $data = NULL;
    //           return;
    //       }
    //       //perform other verification if not the same hashing method. idk if i can tho.
    //       /***********************************************************/
    //       /* HERE LIES MIKHAN WHO DOESN'T KNOW HOW TO IMPLEMENT THAT */
    //       /***********************************************************/
    //     }
    //     //check if there is a student record for the parameters above.
    //     if ($data == NULL) {
    //         http_response_code(200);
    //         echo json_encode(array("status" => "error", "message" => "No student record found."));
    //         return;
    //     }

    //     // Check for today's attendance record with incomplete "out_time"
    //     $records = $this->db->get_where('attend', [
    //         'srcode' => $data['srcode'],
    //         'date' => $Sdate,
    //         'out_time' => NULL // Check if "out_time" is NULL
    //     ])->row_array();

    //     if ($records) {
    //         // If an incomplete record exists, proceed to "time-out"
    //         $this->db->where('id', $records['id']);
    //         $this->db->update('attend', ['out_time' => $date]);
    //         http_response_code(200);
    //         echo json_encode(array("status" => "success", "message" => "Time-out success"));
    //         return;
    //     } else {
    //         // Create a new "time-in" record
    //         $srcode = $data['srcode'];
    //         $category = 'student';
    //         $username = ($data['first_name'] . ' ' . $data['last_name']);
    //         $data = [
    //             'username' => $username,
    //             'category' => $category,
    //             // 'qrcode' => ($code_type == 'qr' ? $code : ""),
    //             // 'RFID' => ($code_type == 'rfid' ? $code : ""),
    //             // 'pin' => ($code_type == 'pin' ? $code : ""),
    //             'srcode' => $srcode,
    //             'kiosk' => $kiosk_id,
    //             'in_time' => $date,
    //             'date' => $Sdate
    //         ];
    //         $this->db->insert('attend', $data);
    //         http_response_code(200);
    //         echo json_encode(array("status" => "success", "message" => "Time-in success"));
    //         return;
    //     }
    // }

    // public function HttpGetTimeInOut()
    // {
    //     //get the timezone
    //     date_default_timezone_set("Asia/Manila");
    //     // DATE TODAY
    //     $Sdate = date('Y-m-d', time());
    //     // DATE AND TIME TODAY
    //     $date = date('Y-m-d H:i:s', time());

    //     //get the srcode
    //     if ($this->input->get("studentID") !== null) {
    //       $studentID = $this->input->get("studentID");
    //     }

    //     //get the code types.
    //     if ($this->input->get('code_type') !== null) {
    //       $code_type = $this->input->get("code_type");
    //     }

    //     if ($this->input->get('kiosk_id') !== null) {
    //         $kiosk_id = $this->input->get("kiosk_id");
    //     }

    //     if (isset($kiosk_id) && empty($kiosk_id) || !isset($kiosk_id)) {
    //         http_response_code(400);
    //         echo json_encode(array("status" => "error", "message" => "Empty parameter(s) detected."));
    //         return;
    //     }

    //     //idk how this shit works. only god knows how. prolly not.
    //     //translation: if studentID is set AND student ID is empty OR student ID is not set. how tf did this work.
    //     if (isset($studentID) && empty($studentID) || !isset($studentID)) {
    //         http_response_code(400);
    //         echo json_encode(array("status" => "error", "message" => "Empty parameter(s) detected."));
    //         return;
    //     }else{
    //         //check the code type first if empty or null.
    //         if (isset($code_type) && empty($code_type) || !isset($code_type)){
    //             http_response_code(400);
    //             echo json_encode(array("status" => "error", "message" => "Empty parameter(s) detected."));
    //             return;
    //         }
    //         else{
    //             //validations
    //             if ($this->input->get('code') !== null) {
    //                 if ($code_type == 'birthdate' || $code_type == 'BIRTHDATE') {
    //                     $bdate = $this->input->get("code");
    //                 } else if ($code_type == 'rfid' || $code_type = 'RFID') {
    //                     $rfid = $this->input->get("code");
    //                 } else if ($code_type == "qr" || $code_type == 'QR'){
    //                     $qr = $this->input->get('code');
    //                 } else if ($code_type == 'pin' || $code_type == 'PIN'){
    //                     $pin = $this->input->get("code");
    //                 }
    //                 else{
    //                     http_response_code(400);
    //                     echo json_encode(array("status" => "error", "message" => "Invalid code type."));
    //                     return;
    //                 }
    //             } else{
    //                 http_response_code(400);
    //                 echo json_encode(array("status" => "error", "message" => "Empty parameter(s) detected."));
    //                 return;
    //             }

    //             if (isset($bdate) && empty($bdate) || isset($rfid) && empty($rfid) || isset($qr) && empty($qr) || isset($pin) && empty($pin)){
    //                 http_response_code(400);
    //                 echo json_encode(array("status" => "error", "message" => "Empty parameter(s) detected."));
    //                 return;
    //             }
    //             else {
    //                 if (isset($bdate)) {
    //                     $data = $this->db->get_where('student', ['pin' => $bdate, 'srcode' => $studentID])->row_array();
    //                 } 
    //                 else if (isset($rfid)) {
    //                     $data = $this->db->get_where('student', ['rfid' => $rfid, 'srcode' => $studentID])->row_array();
    //                 } 
    //                 else if (isset($qr)) {
    //                     $data = $this->db->get_where('student', ['qrcode' => $qr, 'srcode' => $studentID])->row_array();
    //                 }
    //                 else if (isset($pin)) {
    //                     $data = $this->db->get_where('student', ['pin' => $pin, 'srcode' => $studentID])->row_array();
    //                 }
    //                 else{
    //                     $data = NULL;
    //                 }
    //             }
    //         }
    //     }

    //     //check if there is a student record for the parameters above.
    //     if ($data == NULL) {
    //         http_response_code(200);
    //         echo json_encode(array("status" => "error", "message" => "No student record found."));
    //         return;
    //     }

    //     // Check for today's attendance record with incomplete "out_time"
    //     $records = $this->db->get_where('attend', [
    //         'srcode' => $data['srcode'],
    //         'date' => $Sdate,
    //         'out_time' => NULL // Check if "out_time" is NULL
    //     ])->row_array();

    //     if ($records) {
    //         // If an incomplete record exists, proceed to "time-out"
    //         $this->db->where('id', $records['id']);
    //         $this->db->update('attend', ['out_time' => $date]);
    //         http_response_code(200);
    //         echo json_encode(array("status" => "success", "message" => "Time-out success"));
    //         return;
    //     } else {
    //         // Create a new "time-in" record
    //         $srcode = $data['srcode'];
    //         $category = 'student';
    //         $username = ($data['first_name'] . ' ' . $data['last_name']);
    //         $data = [
    //             'username' => $username,
    //             'category' => $category,
    //             // 'qrcode' => ($code_type == 'qr' ? $code : ""),
    //             // 'RFID' => ($code_type == 'rfid' ? $code : ""),
    //             // 'pin' => ($code_type == 'pin' ? $code : ""),
    //             'srcode' => $srcode,
    //             'kiosk' => $kiosk_id,
    //             'in_time' => $date,
    //             'date' => $Sdate
    //         ];
    //         $this->db->insert('attend', $data);
    //         http_response_code(200);
    //         echo json_encode(array("status" => "success", "message" => "Time-in success"));
    //         return;
    //     }
    // }
    public function HttpGetTimeInOut()
    {
        // Get the timezone
        date_default_timezone_set("Asia/Manila");
    
        // Date variables
        $Sdate = date('Y-m-d', time()); // Date today
        $date = date('Y-m-d H:i:s', time()); // Date and time today
    
        // Get parameters
        $studentID = $this->input->get("studentID") ?? null;
        $code_type = $this->input->get("code_type") ?? null;
        $kiosk_id = $this->input->get("kiosk_id") ?? null;
        $code = $this->input->get("code") ?? null;
    
        // Validate kiosk_id
        if (empty($kiosk_id)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Empty parameter(s) detected."]);
            return;
        }
    
        // Validate code_type
        if (empty($code_type)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Empty parameter(s) detected."]);
            return;
        }
    
        // Require studentID only for birthdate validation
        if (strtolower($code_type) === "birthdate" && empty($studentID)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Student ID is required when using birthdate."]);
            return;
        }
    
        // Validate code
        if (empty($code)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Missing code."]);
            return;
        }
    
        // Identify the type of code
        $bdate = $rfid = $qr = $pin = null;
        switch (strtolower($code_type)) {
            case 'birthdate':
                $bdate = $code;
                break;
            case 'rfid':
                $rfid = $code;
                break;
            case 'qr':
                $qr = $code;
                break;
            case 'pin':
                $pin = $code;
                break;
            default:
                http_response_code(400);
                echo json_encode(["status" => "error", "message" => "Invalid code type."]);
                return;
        }
    
        // Fetch student data based on available identifier
        if (!empty($bdate)) {
            $data = $this->db->get_where('student', ['pin' => $bdate, 'srcode' => $studentID])->row_array();
        } elseif (!empty($rfid)) {
            $data = $this->db->get_where('student', ['rfid' => $rfid])->row_array();
        } elseif (!empty($qr)) {
            $data = $this->db->get_where('student', ['qrcode' => $qr])->row_array();
        } elseif (!empty($pin)) {
            $data = $this->db->get_where('student', ['pin' => $pin])->row_array();
        } else {
            $data = null;
        }
    
        // Check if student exists
        if ($data === null) {
            http_response_code(200);
            echo json_encode(["status" => "error", "message" => "No student record found."]);
            return;
        }
    
        // Check for incomplete attendance record (missing out_time)
        $records = $this->db->get_where('attend', [
            'srcode' => $data['srcode'],
            'date' => $Sdate,
            'out_time' => null
        ])->row_array();
    
        if ($records) {
            // Time-out the student
            $this->db->where('id', $records['id']);
            $this->db->update('attend', ['out_time' => $date]);
            http_response_code(200);
            echo json_encode(["status" => "success", "message" => "Time-out success"]);
            return;
        } else {
            // Time-in the student
            $srcode = $data['srcode'];
            $category = 'student';
            $username = $data['first_name'] . ' ' . $data['last_name'];
            
            $attendanceData = [
                'username' => $username,
                'category' => $category,
                'srcode' => $srcode,
                'kiosk' => $kiosk_id,
                'in_time' => $date,
                'date' => $Sdate
            ];
    
            $this->db->insert('attend', $attendanceData);
            http_response_code(200);
            echo json_encode(["status" => "success", "message" => "Time-in success"]);
            return;
        }
    }
    
    // public function HttpGetUserInfo(){
    //     date_default_timezone_set("Asia/Manila");
    //     //--------------------------------------------------------------//
    //     //----------------------GET REQUESTS-----------------------------//
    //     //--------------------------------------------------------------//
    //     //get the srcode
    //     if ($this->input->get("studentID") !== null) {
    //         $studentID = $this->input->get("studentID");
    //     }
    //     //get the code types.
    //     if ($this->input->get('code_type') !== null) {
    //         $code_type = $this->input->get("code_type");
    //     }
    //     //get the value of the code type
    //     if ($this->input->get('code') !== null) {
    //         $code = $this->input->get("code");
    //     }
    //     //--------------------------------------------------------------//
    //     //----------------STUDENT && CODE VALIDATION--------------------//
    //     //--------------------------------------------------------------//
    //     if (isset($studentID) && empty($studentID) || !isset($studentID)) {
    //         http_response_code(400);
    //         echo json_encode(array("status" => "error", "message" => "Empty parameter(s) detected."));
    //         return;
    //     }else{
    //         //check the code type first if empty or null.
    //         if (isset($code_type) && empty($code_type) || !isset($code_type)){
    //             http_response_code(400);
    //             echo json_encode(array("status" => "error", "message" => "Empty parameter(s) detected."));
    //             return;
    //         }
    //         else{
    //             if ($this->input->get('code') !== null) {
    //                 if ($code_type == 'birthdate' || $code_type == 'BIRTHDATE') {
    //                     $bdate = $this->input->get("code");
    //                 } else if ($code_type == 'rfid' || $code_type = 'RFID') {
    //                     $rfid = $this->input->get("code");
    //                 } else if ($code_type == "qr" || $code_type == 'QR'){
    //                     $qr = $this->input->get('code');
    //                 } else if ($code_type == 'pin' || $code_type == 'PIN'){
    //                     $pin = $this->input->get("code");
    //                 }
    //                 else{
    //                     http_response_code(400);
    //                     echo json_encode(array("status" => "error", "message" => "Invalid code type."));
    //                     return;
    //                 }
    //             } else{
    //                 http_response_code(400);
    //                 echo json_encode(array("status" => "error", "message" => "Empty parameter(s) detected."));
    //                 return;
    //             }

    //             if (isset($bdate) && empty($bdate) || isset($rfid) && empty($rfid) || isset($qr) && empty($qr) || isset($pin) && empty($pin)){
    //                 http_response_code(400);
    //                 echo json_encode(array("status" => "error", "message" => "Empty parameter(s) detected."));
    //                 return;
    //             }
    //             else {
    //                 if (isset($bdate)) {
    //                     $data = $this->db->get_where('student', ['pin' => $bdate, 'srcode' => $studentID])->row_array();
    //                 } 
    //                 else if (isset($rfid)) {
    //                     $data = $this->db->get_where('student', ['rfid' => $rfid])->row_array();
    //                     print_r($data);
    //                 } 
    //                 else if (isset($qr)) {
    //                     $data = $this->db->get_where('student', ['qrcode' => $qr])->row_array();
    //                 }
    //                 else if (isset($pin)) {
    //                     $data = $this->db->get_where('student', ['pin' => $pin])->row_array();
    //                 }
    //                 else{
    //                     $data = NULL;
    //                 }
    //             }
    //         }
    //     }
    //     if ($data == NULL) {
    //         http_response_code(200);
    //         echo json_encode(array("status" => "error", "message" => "No student record found."));
    //         return;
    //     }
        // /*!!!!
        //     This function HttpGetUserInfo basically is self-explanatory. It gets the user info. (ALL)
        //     BUT, since this is the first function to run in the KIOSK, I also implemented to check if the student 
        //     do have a pending reservation. This function additionaly checks if the reservation is still valid. If not, it will fill up the timein and timeout.
        // !!!!*/
        // // Fetch booking data
        // if (isset($bdate) || isset($qr) || isset($pin) || isset($rfid)) {
        //     if (isset($bdate)) {
        //         $this->db->where(['code' => $studentID . '_' . $bdate]);
        //     }
        //     if (isset($qr)) {
        //         $this->db->or_where(['code' => $qr]);
        //     }
        //     if (isset($pin)) {
        //         $this->db->or_where(['code' => $pin]);
        //     }
        //     if (isset($rfid)) {
        //         $this->db->or_where(['code' => $rfid]);
        //     }
            
        //     $booking_data = $this->db->get('booking')->result_array();
        // } else {
        //     http_response_code(400);
        //     echo json_encode(array("status" => "error", "message" => "Empty parameter(s) detected."));
        //     return;
        // }
        // // Get current date
        // $current_date = date('Y-m-d');
        // foreach ($booking_data as $booking) {
        //     // Extract booking details
        //     $date = $booking['date'];
        //     $start_time = $booking['start_time'];
        //     $end_time = $booking['end_time'];
        //     $area_floor = $booking['floor'];
        //     $area_name = $booking['room'];
        //     $seat_slot = $booking['slot_id'];
        //     $booking_date = $booking['date'];
        //     $in_time = $booking['in_time'];
        //     $out_time = $booking['out_time'];
            
        //     if ($in_time == NULL || $out_time == NULL) {
        //         // Get area info
        //         $area_info = $this->db->get_where('area', ['floor' => $area_floor, 'room' => $area_name])->row_array();
        //         $open_time = strtotime($area_info['opentime']);
        //         $close_time = strtotime($area_info['closetime']);

        //         // Generate time slots
        //         $timesIndex = [];
        //         for ($time = $open_time, $counter = 0; $time <= $close_time; $time = strtotime('+1 hour', $time), $counter++) {
        //             $timesIndex[$counter] = date('H:i', $time);
        //         }

        //         // Get the current time
        //         $current_time = date('H:i:s');
        //         $current_time_format = date('H:i', strtotime($current_time));
        //         $start_time_equi = $timesIndex[$start_time];
        //         $end_time_equi = $timesIndex[$end_time];

        //         // Convert to DateTime objects
        //         $current_time_object = new DateTime($current_time_format);
        //         $end_time_object = new DateTime($end_time_equi);
        //         $start_time_object = new DateTime($start_time_equi);
        //         $start_time_object->sub(new DateInterval('PT1H'));

        //         // Booking validation logic
        //         if ($date == $current_date) {
        //             if ($current_time_object <= $end_time_object && $current_time_object >= $start_time_object) {
        //                 // User is allowed to time in and out.
        //             } elseif ($current_time_object < $start_time_object) {
        //                 // User is early; do nothing.
        //             } elseif ($current_time_object > $end_time_object) {
        //                 // User is late.
        //                 if ($booking['in_time'] == NULL) {
        //                     $this->fillTimeInTimeOuts($booking['id'], $start_time_equi, $end_time_equi);
        //                 } elseif ($booking['out_time'] == NULL && $booking['in_time'] != NULL) {
        //                     $this->fillTimeouts($booking['id'], $end_time_equi);
        //                 }
        //             }
        //             //dec 3 < dec 4
        //         } else if ($current_date > $date) {
        //             $this->fillTimeInTimeOuts($booking['id'], $start_time_equi, $end_time_equi);
        //         } else if ($current_date < $date) {
        //         //FIXED !
        //         }
        //     }
    //     }

    //     http_response_code(200);
    //     echo json_encode(array("status" => "success", "message" => "User found.", "data" => $data));
    // }
    public function HttpGetUserInfo(){
        date_default_timezone_set("Asia/Manila");
    
        $studentID = $this->input->get("studentID");
        $code_type = $this->input->get("code_type");
        $code = $this->input->get("code");
    
        // Validate that code_type is provided
        if (empty($code_type)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Empty parameter(s) detected."]);
            return;
        }
    
        // Validate that code is provided
        if (empty($code)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Empty parameter(s) detected."]);
            return;
        }
    
        // Validate studentID only when using birthdate
        if (strtolower($code_type) === 'birthdate' && empty($studentID)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Empty parameter(s) detected."]);
            return;
        }
    
        // Assign the correct variable based on code_type
        switch (strtolower($code_type)) {
            case 'birthdate':
                $bdate = $code;
                break;
            case 'rfid':
                $rfid = $code;
                break;
            case 'qr':
                $qr = $code;
                break;
            case 'pin':
                $pin = $code;
                break;
            default:
                http_response_code(400);
                echo json_encode(["status" => "error", "message" => "Invalid code type."]);
                return;
        }
    
        // Fetch student data
        if (!empty($bdate)) {
            $data = $this->db->get_where('student', ['pin' => $bdate, 'srcode' => $studentID])->row_array();
        } elseif (!empty($rfid)) {
            $data = $this->db->get_where('student', ['rfid' => $rfid])->row_array();
        } elseif (!empty($qr)) {
            $data = $this->db->get_where('student', ['qrcode' => $qr])->row_array();
        } elseif (!empty($pin)) {
            $data = $this->db->get_where('student', ['pin' => $pin])->row_array();
        } else {
            $data = null;
        }
    
        if ($data === null) {
            http_response_code(200);
            echo json_encode(["status" => "error", "message" => "No student record found."]);
            return;
        }
        /*!!!!
            This function HttpGetUserInfo basically is self-explanatory. It gets the user info. (ALL)
            BUT, since this is the first function to run in the KIOSK, I also implemented to check if the student 
            do have a pending reservation. This function additionaly checks if the reservation is still valid. If not, it will fill up the timein and timeout.
        !!!!*/
        // Fetch booking data
        if (isset($bdate) || isset($qr) || isset($pin) || isset($rfid)) {
            if (isset($bdate)) {
                $this->db->where(['code' => $studentID . '_' . $bdate]);
            }
            if (isset($qr)) {
                $this->db->or_where(['code' => $qr]);
            }
            if (isset($pin)) {
                $this->db->or_where(['code' => $pin]);
            }
            if (isset($rfid)) {
                $this->db->or_where(['code' => $rfid]);
            }
            
            $booking_data = $this->db->get('booking')->result_array();
        } else {
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "Empty parameter(s) detected."));
            return;
        }
        // Get current date
        $current_date = date('Y-m-d');
        foreach ($booking_data as $booking) {
            // Extract booking details
            $date = $booking['date'];
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
        
        http_response_code(200);
        echo json_encode(["status" => "success", "message" => "User found.", "data" => $data]);
    }
    
    
    public function HttpGetReservationList(){
        date_default_timezone_set("Asia/Manila");
        //--------------------------------------------------------------//
        //----------------------GET REQUESTS-----------------------------//
        //--------------------------------------------------------------//
        //get the srcode
        if ($this->input->get("studentID") !== null) {
            $studentID = $this->input->get("studentID");
        }
        //get the code types.
        if ($this->input->get('code_type') !== null) {
            $code_type = $this->input->get("code_type");
        }
        //get the value of the code type
        if ($this->input->get('code') !== null) {
            $code = $this->input->get("code");
        }
        //--------------------------------------------------------------//
        //----------------STUDENT && CODE VALIDATION--------------------//
        //--------------------------------------------------------------//
        if (isset($studentID) && empty($studentID) || !isset($studentID)) {
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "Empty parameter(s) detected."));
            return;
        }else{
            //check the code type first if empty or null.
            if (isset($code_type) && empty($code_type) || !isset($code_type)){
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => "Empty parameter(s) detected."));
                return;
            }
            else{
                if ($this->input->get('code') !== null) {
                    if ($code_type == 'birthdate' || $code_type == 'BIRTHDATE') {
                        $bdate = $studentID . '_' . $code;
                    } else if ($code_type == 'rfid' || $code_type = 'RFID') {
                        $rfid = $this->input->get("code");
                    } else if ($code_type == "qr" || $code_type == 'QR'){
                        $qr = $this->input->get('code');
                    } else if ($code_type == 'pin' || $code_type == 'PIN'){
                        $pin = $this->input->get("code");
                    }
                    else{
                        http_response_code(400);
                        echo json_encode(array("status" => "error", "message" => "Invalid code type."));
                        return;
                    }
                } else{
                    http_response_code(400);
                    echo json_encode(array("status" => "error", "message" => "Empty parameter(s) detected."));
                    return;
                }

                if (isset($bdate) && empty($bdate) || isset($rfid) && empty($rfid) || isset($qr) && empty($qr) || isset($pin) && empty($pin)){
                    http_response_code(400);
                    echo json_encode(array("status" => "error", "message" => "Empty parameter(s) detected."));
                    return;
                }
                else {
                    if (isset($bdate)) {
                        $data = $this->db->get_where('booking',['code_type'=>$code_type,'code'=>$bdate])->result_array();
                    } 
                    else if (isset($rfid)) {
                        $data = $this->db->get_where('booking',['code_type'=>$code_type,'code'=>$rfid])->result_array();
                    } 
                    else if (isset($qr)) {
                        $data = $this->db->get_where('booking',['code_type'=>$code_type,'code'=>$qr])->result_array();
                    }
                    else if (isset($pin)) {
                        $data = $this->db->get_where('booking',['code_type'=>$code_type,'code'=>$pin])->result_array();
                    }
                    else{
                        $data = NULL;
                    }
                }
            }
        }
        if ($data == NULL) {
            http_response_code(200);
            echo json_encode(array("status" => "error", "message" => "No booking data."));
            return;
        }
        else{
            http_response_code(200);
            echo json_encode(array("status" => "success", "message" => "Booking data found.", "data" => $data));
        }
    }
    public function HttpPostSeatReservation(){
        $device = $this->input->post("device");
        $user_id = $this->input->post("user_id");
        $code_type = $this->input->post("code_type");
        $code = $this->input->post("code");
        $floor = $this->input->post("floor"); // desired floor
        $room = $this->input->post("room");// desired room
        $slot = $this->input->post("slot");// desired slot
        $date = $this->input->post("date");  // desired date       
        $stime = $this->input->post("stime");// desired start time
        $etime = $this->input->post("etime");// desired end time
        $studentID = $this->input->post("studentID");

        

        //check all the parameters if null or empty.
        if (($device === null) || ($user_id === null) || ($floor === null) || ($room === null) || ($slot === null) || ($date === null) || ($stime === null) || ($etime === null)) {
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "Empty parameter(s) detected."));
            return;
        }
        //set the data array to save in the booking table.
        $data = array(
            'device' => $device,
            'user_id' => $user_id,
            'code_type' => $code_type,
            'floor' => $floor,
            'room' => $room,
            'slot_id' => $slot,
            'date' => $date,
            'start_time' => $stime,
            'end_time' => $etime,
            'at_time' => date("Y-m-d H:i:s", strtotime("today"))
        );

        //--------------------------------------------------------------//
        //----------------STUDENT && CODE VALIDATION--------------------//
        //--------------------------------------------------------------//
        if (isset($studentID) && empty($studentID) || !isset($studentID)) {
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "Empty parameter(s) detected."));
            return;
        }else{
            //check the code type first if empty or null.
            if (isset($code_type) && empty($code_type) || !isset($code_type)){
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => "Empty parameter(s) detected."));
                return;
            }
            else{
                if ($this->input->post('code') !== null) {
                    if ($code_type == 'birthdate' || $code_type == 'BIRTHDATE') {
                        // $bdate = $this->input->get("code"); //possible issue: not unique. better make a unique identifier.
                        $bdate = $studentID . '_' . $code; //only solution i can think of.
                    } else if ($code_type == 'rfid' || $code_type = 'RFID') {
                        $rfid = $this->input->post("code");
                    } else if ($code_type == "qr" || $code_type == 'QR'){
                        $qr = $this->input->post('code');
                    } else if ($code_type == 'pin' || $code_type == 'PIN'){
                        $pin = $this->input->post("code");
                    }
                    else{
                        http_response_code(400);
                        echo json_encode(array("status" => "error", "message" => "Invalid code type."));
                        return;
                    }
                } else{
                    http_response_code(400);
                    echo json_encode(array("status" => "error", "message" => "Empty parameter(s) detected."));
                    return;
                }

                if (isset($bdate) && empty($bdate) || isset($rfid) && empty($rfid) || isset($qr) && empty($qr) || isset($pin) && empty($pin)){
                    http_response_code(400);
                    echo json_encode(array("status" => "error", "message" => "Empty parameter(s) detected."));
                    return;
                }
                else {
                    if (isset($bdate)) {
                        //add $bdate to the data array
                        $data['code'] = $bdate;
                    } 
                    else if (isset($rfid)) {
                        $data['code'] = $rfid;
                    } 
                    else if (isset($qr)) {
                        $data['code'] = $qr;
                    }
                    else if (isset($pin)) {
                        $data['code'] = $pin;
                    }
                    else{
                        $data = NULL;
                    }
                }
            }
        }
            if ($data == NULL) {
                http_response_code(200);
                echo json_encode(array("status" => "error", "message" => "No data found with the given parameters."));
                return;
            }
            if(!$this->db->insert('booking', $data)){
                http_response_code(500);
                echo json_encode(array("status" => "error", "message" => "Error inserting data to database."));
                return;
            }
            
            $slotdata = $this->db->get_where('slot', ['date'=>$date,'Floor' =>$floor,'Room' =>$room,'Slot' =>$slot])->row();
            if($slotdata != NULL){
                $slottemp = trim($slotdata->status, "[");
                $slottemp = trim($slottemp, "]");
                $timeslot = explode(",",$slottemp) ;

                if($timeslot[$stime] =='1' ){  // occupied 
                    http_response_code(200);
                    echo json_encode(array("status" => "error", "message" => "Slot is occupied"));
                    return;         
                }
                else {
                    for($i=$stime; $i<$etime; $i++)            
                        $timeslot[$i] = '1';
                    $data = array(                
                        'status' => '['.implode(',',$timeslot).']'
                    );              
                    $this->db->where('id', $slotdata->id);
                    $this->db->update('slot', $data);
            
                    // // Generate the time slots
                    // $counter = 0; // Initialize counter
                    // for ($time = $open_time; $time <= $close_time; $time = strtotime('+1 hour', $time)) {
                    // $times[$counter] = date('H:i', $time);
                    // // echo $times[$counter];
                    // $counter++;
                    // }
                    
                    http_response_code(200);
                    echo json_encode(array("status" => "success", "message" => "Reservation successful."));
                    return;
                }     
            }
            else {
                http_response_code(200);
                echo json_encode(array("status" => "error", "message" => "No slot information."));
                return;
            }    
        
    }
    public function HttpGetAreaList(){
        $floorname =  $this->input->get("floorname");
        if (!isset($floorname)){
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "Empty parameter(s) detected."));
            return;
        }

        $d = $this->db->get_where('area',['Floor'=>$floorname])->result_array();        
        if ($d != NULL ){
            http_response_code(200);
            echo  json_encode(array("status" => "success", "message" => "Area data found.", "data" => $d));
        }
        else{
            http_response_code(200);
            echo json_encode(array("status" => "error", "message" => "No area data found."));
        }
    }
    public function HttpGetFloorList(){
        if (!$this->db->select('DISTINCT(floor)')){
            http_response_code(500);
            echo json_encode(array("status" => "error", "message" => "Error getting data from database."));
            return;
        }
        $d = $this->db->get('area')->result_array();        
        if ($d != NULL ){
            http_response_code(200);
            echo  json_encode(array("status" => "success", "message" => "Floor data found.", "data" => $d));
        }
        else{
            http_response_code(200);
            echo json_encode(array("status" => "error", "message" => "No floor data found."));
        }
    }
    public function HttpGetSeatList(){
        $date = $this->input->get("date"); 
        if (!isset($date)){
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "Empty parameter(s) detected."));
            return;
        }
        
        $floorname =  $this->input->get("floorname");
        $roomname =  $this->input->get("roomname"); 
        if (empty($floorname) || empty($roomname)){
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "Empty parameter(s) detected."));
            return;
        }

        $d = $this->db->get_where('slot',['date'=>$date,'Floor'=>$floorname,'Room'=>$roomname])->result_array();        
        $roominfo = $this->db->get_where('area',['floor'=>$floorname,'room'=>$roomname])->row();
        
        if ($d != NULL )
            {
                http_response_code(200);
                echo json_encode(array("status" => "success", "message" => "Seat data found.", "data" => $d));
            }
        else{      
            $slot=0;
            $open_time = $roominfo->opentime;
            $close_time = $roominfo->closetime;
            //get the area information.
            $start_hour = (int)date('H', strtotime($open_time));
            $end_hour = (int)date('H', strtotime($close_time));
            // Generate the hourly ranges and fill the array with zeros
            for ($i = $start_hour; $i < $end_hour; $i++) {
                $hour_ranges[] = "$i-" . ($i + 1); // Example: "8-9", "9-10"
                $hour_blocks[] = 0;                // Add 0 for each hour block
            }
            

            //convert hourblocks to string.
            $hour_blocks_string = '[' . implode(',', $hour_blocks) . ']';
            
            $data = array(
                'date' => $date,
                'Floor' => $floorname,
                'Room' => $roomname,
                'Slot' => $slot,
                'status' => $hour_blocks_string
                //the culprit
            );
            
            $Max_slot=$roominfo->slotnumber;
            for ($slot=1;$slot<=$Max_slot;$slot++){
            $data['Slot'] = $slot;
            $this->db->insert('slot', $data);
            }               
            $data = $this->db->get_where('slot',['date'=>$date,'Floor'=>$floorname,'Room'=>$roomname])->result_array();        
            if ($data != NULL){
                http_response_code(200);
                echo json_encode(array("status" => "success", "message" => "Seat data found.", "data" => $data));
            }
        }
    }
    public function HttpPostSeatTimeIn(){
        date_default_timezone_set("Asia/Manila");
        $time = date('H:i:s', time());
        $book_id = $this->input->get('book_id');
        if (empty($book_id)){
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "Empty parameter(s) detected."));
            return;
        }
        
        $data  =$this->db->get_where('booking', ['id' => $book_id])->row_array();
        if($data){
            $queryUpdate = "UPDATE `booking` SET `in_time` = '" . $time . "', `in_status` = 'occupied'  WHERE  `id` = '$book_id'";
            if ($this->db->query($queryUpdate)){   
                http_response_code(200);
                echo json_encode(array("status" => "success", "message" => "Time in success."));
            }else{
                http_response_code(500);
                echo json_encode(array("status" => "error", "message" => "Error updating database."));
            }
        }
        else{
            http_response_code(200);
            echo json_encode(array("status" => "error", "message" => "No booking data found."));
            return;
        }
    }
    

    /*
    http://{serverIP}/{serverName}/Kiosk/SeatTimeIn?book_id={id}

    http://{serverIP}/{serverName}/Kiosk/SeatTimeOut?book_id={id}

    http://{serverIP}/{serverName}/Kiosk/GetUserBookAllList?code_type={type}&&code=             DONE HttpGetReservationList

    http://{serverIP}/{serverName}/Kiosk/GetAreaList?floorname={floor} =                        DONE HttpGetAreaList

    http://{serverIP}/{serverName}/Kiosk/GetFloorList                                           DONE HttpGetFloorList

    http://{serverIP}/{serverName}/Kiosk/UserGetInfo?code_type={type}&code=                     DONE HttpGetUserInfo

    http://{serverIP}/{serverName}/Kiosk/ReqBookSeat                                            DONE HttpPostSeatReservation

    http://{serverIP}/{serverName}/Kiosk/GetSeatList?floorname={floorname}&roomname={roomname}&date={currentDate} DONE httpGet
     */
}


