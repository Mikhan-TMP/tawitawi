<?php
defined('BASEPATH') or exit('No direct script access allowed');

class test extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
  
    $this->load->library('form_validation');
    $this->load->model('Public_model');
    $this->load->model('Admin_model');
    $this->load->model('Reservation_model');
  }
  public function index()
  {
    $date = '2024-08-14';
    $floor = 'GF';
    $room = 'PWD COLLECTION ROOM';
    $slot = '1';

    $slotdata = $this->db->get_where('slot', ['date'=>$date,'Floor' =>$floor,'Room' =>$room,'Slot' =>$slot])->row();
    // print_r(json_encode($slotdata));

    if($slotdata != NULL){
        $slottemp = trim($slotdata->status, "[");
        $slottemp = trim($slotdata->status, "]");
        $timeslot = explode(",", $slottemp);
        $stime = '1';
        $etime = '1';
        
        if($timeslot[$stime] == '1'){
            echo 'already reserved';
        } else {
            echo 'reserved successfully';
            for($i=$stime; $i<$etime; $i++)            
                $timeslot[$i] = '1';
              $data = array(                
                'status' => '['.implode(',',$timeslot).']'
              ); 
              print_r($data);
        }
    } else {
        echo 'no slot information';
    }
  }
  public function submitReservation() 
    {
        $studentID = $this->input->post('srcode');
        $user = $this->Reservation_model->getUserInfoBySID($studentID)->row_array();
        $area = $this->input->post('floor');
        $room = $this->input->post('room');
        $duration = $this->input->post('duration');
        $time = $this->input->post('time');
        $time = intval($time);
        $result = $duration + $time;
        $device = 0;
        $user_id = $user['id'];
        $code_type = 'RFID';
        $code = $user['qrcode'];
        $seat = $this->input->post("seat");
        $date = $this->input->post('date');
        
        // Check slot availability
        $slotdata = $this->db->get_where('slot', ['date' => $date, 'Floor' => $area, 'Room' => $room, 'Slot' => $seat])->row();
        if ($slotdata != NULL) {
            $slottemp = trim($slotdata->status, "[");
            $slottemp = trim($slottemp, "]");
            $timeslot = explode(",", $slottemp);
            
            // Check if the slot is already reserved during the requested time
            $is_reserved = false;
            for ($i = $time; $i < $result; $i++) {
                if ($timeslot[$i] == '1') { // occupied
                    $is_reserved = true;
                    break;
                }
            }

            if ($is_reserved) {
                // Slot is already reserved
                echo json_encode([
                    'success' => false,
                    'message' => 'The selected slot is already reserved. Please choose another time or seat.'
                ]);
                return; // Exit the function to prevent further execution
            } else {
                // Reserve the slot
                for ($i = $time; $i < $result; $i++) {
                    $timeslot[$i] = '1';
                }
                $data = [
                    'status' => '['.implode(',', $timeslot).']'
                ];
                $this->db->where('id', $slotdata->id);
                $this->db->update('slot', $data);
            }
        } else {
            // No slot information available
            echo json_encode([
                'success' => false,
                'message' => 'No slot information available for the selected date, floor, room, and seat.'
            ]);
            return; // Exit the function to prevent further execution
        }

        // Proceed to insert reservation data after successful slot check
        $data = array(
            'device' => $device,
            'user_id' => $user_id,
            'code_type' => $code_type,
            'code' => $code,
            'floor' => $area,
            'room' => $room,
            'slot_id' => $seat,
            'date' => $date,
            'start_time' => $time,
            'end_time' => $result,
            'at_time' => date("Y-m-d H:i:s", strtotime("today"))
        );

        $inserted = $this->db->insert('booking', $data);

        header('Content-Type: application/json');
        if ($inserted) {
            $this->session->set_userdata('reservation_complete', $studentID);
            $this->session->unset_userdata('srcode');

            echo json_encode([
                'success' => true,
                'redirect' => base_url('Reservation/onlineVerification')
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to reserve the seat. Please try again.'
            ]);
        }
    }

    public function testSubmit(){
        $studentID = $this->input->post('srcode');
        $user = $this->Reservation_model->getUserInfoBySID($studentID)->row_array();
        // print_r(json_encode($user['id']));
        $area = $this->input->post('floor');
        $room = $this->input->post('room');
        $duration = $this->input->post('duration');
        $time = $this->input->post('time');
        $time = intval($time);
        $result = $duration + $time;
        $device = 0;
        $user_id = $user['id'];
        $code_type = 'RFID';
        $code = $user['qrcode'];
        $seat = $this->input->post("seat");
        $date = $this->input->post('date');

        
        $data = array(
            'device' => $device,
            'user_id' => $user_id,
            'code_type' => $code_type,
            'code' => $code,
            'floor' => $area,
            'room' => $room,
            'slot_id' => $seat,
            'date' => $date,
            'start_time' => $time,
            'end_time' => $result,
            'at_time' => date("Y-m-d H:i:s", strtotime("today"))
        );
        print_r($data);
    }
    public function userExist()
    {
        $studentID = '03';
        $userInfo = $this->Reservation_model->getUserInfoBySID($studentID)->row_array();
        if($userInfo){
            echo 'User Exists';
            print_r($userInfo);
        } else {
            echo 'User Does not exists';
        }
    }
}