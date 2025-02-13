<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manual extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Admin_model');
        $this->load->model('Public_model');
        $this->load->model('Reservation_model');
        $this->load->model('Student_model');


        
    }
    public function index(){
        $this->load->view('templates/table_header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('views/admin/manualAttendance');
        $this->load->view('templates/table_footer');
    }
    public function manualAttendance(){
        $d['title'] = 'Manual Attendance';
        $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
        // $d['studentList'] = $this->db->get('student')->result_array();
        $d['attendance'] = $this->Public_model->get_attend();


        $this->load->view('templates/table_header',$d);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('admin/manualAttendance', $d);
        $this->load->view('templates/table_footer');
    }
    public function clearAllSetData(){
        $this->session->unset_userdata('student_info');
        $this->session->unset_userdata('reservation_info');
        $this->session->unset_userdata('area_info');
        $this->session->unset_userdata('seat_info');

    }

    public function manualReservation(){
        $d['title'] = 'Manual Reservation';
        $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
        $d['students'] = $this->db->get('student')->result_array();
        // $d['areas'] = $this->db->get('area')->result_array();
        //get the floors from the function HttpGetFloorList
        $d['floors'] = $this->HttpGetFloorList();

        $this->load->view('templates/table_header',$d);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('admin/manualReserve', $d);
        $this->load->view('templates/table_footer');
    }
    
    public function HttpGetUserInfo(){
        date_default_timezone_set("Asia/Manila");
        //get the srcode
        if ($this->input->post("studentID") !== null) {
            $studentID = $this->input->post("studentID");
        }

        if (isset($studentID) && empty($studentID) || !isset($studentID)) {
            $this->session->set_flashdata('error', 'Empty Paramters. Please Select a Student.');
            redirect('manual/manualReservation');
        }else{
            $data = $this->db->get_where('student', ['srcode' => $studentID])->row_array();
        }
        if ($data == NULL) {
            $this->session->set_flashdata('error', 'No student record found.');
            redirect('manual/manualReservation');
        }

        $this->db->where(['code' => $studentID . date('mdY', strtotime($data['birthdate']))]);
        $booking_data = $this->db->get('booking')->result_array();
        if(!$booking_data){
            $this->session->set_flashdata('success', 'Student Found. No reservation found.');
            $this->session->set_userdata('student_info', $data);
            $this->session->set_userdata('reservation_info', $data);
            redirect('manual/manualReservation');
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

        $this->session->set_flashdata('success', 'Student Found. Recent Reservation has expired and was automatically filled.');
        $this->session->set_userdata('student_info', $data);
        redirect('manual/manualReservation');
    }

    public function HttpGetFloorList(){
        if (!$this->db->select('DISTINCT(floor)')){
            $this->session->set_flashdata('error', 'Error in extracting floor data from the database');
            redirect('manual/manualReservation');
            return;
        }
        $d = $this->db->get('area')->result_array();        
        if ($d != NULL ){
            return $d; 
        }
        else{
            $this->session->set_flashdata('error', 'No available floors. Please check the area tab.');
            redirect('manual/manualReservation');
        }
    }
    public function HttpGetAreaList(){
        $floorname =  $this->input->post("floor");
        if (!isset($floorname)){
            $this->session->set_flashdata('error', 'Empty Paramters. Please Select a Floor.');
            redirect('manual/manualReservation');
        }

        $d = $this->db->get_where('area',['Floor'=>$floorname])->result_array();        
        if ($d != NULL ){
            //ADD the $d to the exisiting $this->session->set_userdata('reservation_info', $data);
            $this->session->set_userdata('area_info', $d);
            redirect('manual/manualReservation');
        }
        else{
            $this->session->set_flashdata('error', 'No area not Found. Please check the area tab.');
            redirect('manual/manualReservation');
        }
    }

    public function HttpGetSeatList(){
        $date = $this->input->get("date"); 
        if (!isset($date)){
            $this->session->set_flashdata('error', 'Empty Parameters. Please Select a Date.');
            redirect('manual/manualReservation');
        }
        
        $floorname =  $this->input->get("floor");
        $roomname =  $this->input->get("room"); 
        if (empty($floorname) || empty($roomname)){
            $this->session->set_flashdata('error', 'Empty Parameters. Please Select a Floor and Room. ');
            redirect('manual/manualReservation');
        }

        $d = $this->db->get_where('slot',['date'=>$date,'Floor'=>$floorname,'Room'=>$roomname])->result_array();        
        $roominfo = $this->db->get_where('area',['floor'=>$floorname,'room'=>$roomname])->row();
        
        if ($d != NULL )
            {
                $this->session->set_userdata('seat_info', $d);
                redirect('manual/manualReservation');
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
            $this->session->set_flashdata('error', 'Empty Parameters. Please Select a Student.');
            redirect('manual/manualReservation');
        }else{
            //check the code type first if empty or null.
            if (isset($code_type) && empty($code_type) || !isset($code_type)){
                $this->session->set_flashdata('error', 'Empty Parameters. Please Select a Code Type.');
                redirect('manual/manualReservation');
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
                        $this->session->set_flashdata('error', 'Invalid Code Type. Please Select a Valid Code Type.');
                        redirect('manual/manualReservation');
                    }
                } else{
                    $this->session->set_flashdata('error', 'Empty Parameters. Please Select a Code.');
                    redirect('manual/manualReservation');
                }

                if (isset($bdate) && empty($bdate) || isset($rfid) && empty($rfid) || isset($qr) && empty($qr) || isset($pin) && empty($pin)){
                    $this->session->set_flashdata('error', 'Empty Parameters. Code is required.');
                    redirect('manual/manualReservation');
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
                $this->session->set_flashdata('error', 'No data found. Please try again.');
                redirect('manual/manualReservation');
            }
            if(!$this->db->insert('booking', $data)){
                $this->session->set_flashdata('error', 'Error in saving data. Please try again.');
                redirect('manual/manualReservation');
            }
            
            $slotdata = $this->db->get_where('slot', ['date'=>$date,'Floor' =>$floor,'Room' =>$room,'Slot' =>$slot])->row();
            if($slotdata != NULL){
                $slottemp = trim($slotdata->status, "[");
                $slottemp = trim($slottemp, "]");
                $timeslot = explode(",",$slottemp) ;

                if($timeslot[$stime] =='1' ){  // occupied 
                    $this->session->set_flashdata('error', 'Seat is already reserved. Please try again.');
                    redirect('manual/manualReservation');      
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
                    
                    $this->session->set_flashdata('success', 'Reservation successful.');
                    redirect('manual/manualReservation');
                }     
            }
            else {
                $this->session->set_flashdata('error', 'No Seats Found. Please try again.');
                redirect('manual/manualReservation');
            }    
        
    }

}