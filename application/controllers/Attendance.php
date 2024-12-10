<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Attendance extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();    
    is_logged_in();
    is_weekends();
    is_checked_in();    
    is_checked_out();
    $this->load->library('form_validation');
    $this->load->model('Public_model');
    $this->load->model('Admin_model');
  }
  public function index()
  {

    // Attendance Form
    $d['title'] = 'Attendance';
    $d['account'] = $this->Public_model->getAccount($this->session->userdata['username']);
   
    $d['kiosk'] = $this->Public_model->getKiosk();
    $d['course'] = $this->Public_model->getCourse();
    $d['college'] = $this->Public_model->getCollege();
    $d['location'] = $this->db->get('location')->result_array();
    $d['in'] = false;
    $d['weekends'] = false;  
    
    if(isset($_POST['sel_course'])){
      $course = $this->input->post('sel_course');      
      $d['attendance'] = $this->Public_model->get_attend_course($course);      
    }
    else{
      $course ="";
      $d['attendance'] = $this->Public_model->get_attend();    
    }
    

    /*
    if(isset($_POST['sname'])){
      $sname = $this->input->post('sname');      
      $d['attendance'] = $this->Public_model->get_attend_name($sname);      
    }
    elseif(isset($_POST['srcode'])){
      $srcode = $this->input->post('srcode');      
      $d['attendance'] = $this->Public_model->get_attend_srcode($srcode);      

    }
    elseif(isset($_POST['sel_course'])){
      $course = $this->input->post('sel_course');      
      $d['attendance'] = $this->Public_model->get_attend_course($course);      
    }
    else{      
      $d['attendance'] = $this->Public_model->get_attend();    
    }
    */
    $this->load->view('templates/header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');    
    $this->load->view('attendance/index', $d); 
    $this->load->view('templates/footer');

    return;

      
    
    /*
    if (is_weekends() != true) {
      $d['weekends'] = true;
      echo "weekends";
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('attendance/index', $d); 
      $this->load->view('templates/footer');
    } 
    else {
      $d['in'] = false;
      $d['weekends'] = false;                  
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');

      if(isset($_POST['srcode']) || isset($_POST['qrcode']) ){          
        $srcode = $this->input->post('srcode');
        $qrcode = $this->input->post('qrcode');
        $d['srcode']=$srcode;
        $d['reservation'] = $this->Admin_model->get_sr_book($srcode);
        $this->load->view('attendance/index', $d); 
      }
      else{
        $srcode ="";
        $qrcode ="";        
        $this->load->view('attendance/index', $d); 
      }      
      $this->load->view('templates/footer');
    }
    */
      
  }

/*
  // Check Check IN
  private function Set_checkIn($id)
  {
    $date = date('Y-m-d', time());
    $queryUpdate = "UPDATE `booking`
                    SET `in_time` = '" . $date . "', `in_status` = "occupied"  WHERE  `id` = '$id' AND  FROM_UNIXTIME(`in_time`, '%Y-%m-%d') = '$today'";

    $this->db->query($queryUpdate);
    redirect('attendance');
  }
*/
  // Check Check Out
  public function checkOut()
  {
    $username = $this->session->userdata['username'];
    $today = date('Y-m-d', time());
    $querySelect = "SELECT  attendance.username AS `username`,
                            attendance.employee_id AS `employee_id`,
                            attendance.shift_id AS `shift_id`,
                            attendance.in_time AS `in_time`,
                            shift.start AS `start`,
                            shift.end AS `end`
                      FROM  `attendance`
                INNER JOIN  `shift`
                        ON  attendance.shift_id = shift.id
                     WHERE  `username` = '$username'
                       AND  FROM_UNIXTIME(`in_time`, '%Y-%m-%d') = '$today'";
    $checkOut = $this->db->query($querySelect)->row_array();

    $oTime = time();

    // Check Out Time
    if (date('H:i:s', $oTime) >= $checkOut['end']) {
      $outStatus = 'Over Time';
    } else {
      $outStatus = 'Early';
    };

    $value = [
      'out_time' => $oTime,
      'out_status' => $outStatus
    ];

    $queryUpdate = "UPDATE `attendance`
                       SET `out_time` ='" . $value['out_time'] . "', `out_status` ='" . $value['out_status'] . "' WHERE  `username` = '$username' AND  FROM_UNIXTIME(`in_time`, '%Y-%m-%d') = '$today'";
    $this->db->query($queryUpdate);
    redirect('attendance');
  }

  public function stats()
  {
    $d['title'] = 'Statistics';
    $d['account'] = $this->Public_model->getAccount($this->session->userdata['username']);
    $d['e_id'] = $d['account']['id'];
    $d['data'] = $this->attendance_details_data($d['e_id']);

    $this->load->view('templates/table_header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('attendance/stats', $d);
    $this->load->view('templates/table_footer');
  }

  public function time_in2()
  {
     date_default_timezone_set("Asia/Manila");
     $date = date("Y-m-d");
     $time = date("h:i:sa");
     
     $device = $this->input->post("type");
     if($device=='QR'){
        $Qrcode = $this->input->post("qrcode");
        $Srcode = ""; 
        $Rfid="0";        
     } else {
        $Rfid = $this->input->post("RFID");
        $Srcode = ""; 
        $Qrcode="0";
     }
      $value = [
        'qrcode'  =>$Qrcode,
        'RFID' =>$Rfid,
        'username' => "student name", 
        'srcode' => $Srcode,
        'building' =>$this->input->post("building"),
        'in_time' => $date   
      ];
      $this->db->insert('attend', $value);
      echo "pass";           
  }


  public function time_in()
  {

    date_default_timezone_set("Asia/Manila");
    $date = date("Y-m-d");
    $time = date("h:i:sa");

    $type = $this->input->post('type');
    $qrcode = $this->input->post('qrcode');
    $rfid = $this->input->post('rfid');
    $building = $this->input->post('building');

    if($type == 'qrcode' ) {
      $student = $this->db->get_where('student', ['qrcode' => $qrcode])->row_array();
      if($student) {      
        // $verify = $this->Public_model->get_attend_verify($date,$student['srcode']); 
       $verify =0; 
        if($verify==0){
          $value = [
            'first_name'  => $student['first_name'],
            'last_name'  => $student['last_name'],
            'srcode'  => $student['srcode'],
            'verified' => 'success'          
          ];
          echo json_encode($value);
  
          $record = [
            'qrcode'  =>  $student['qrcode'],
            'RFID' => $student['rfid'],
            'username' => $student['first_name'].' '.$student['last_name'], 
            'srcode' => $student['srcode'],
            'building' => $building,
            'in_time' => $time,
            'date' => $date  
          ];
          $this->db->insert('attend', $record);

        }
        else {
          echo 'duplicate access';
         
        }
        
      }
      else {
        $faculty = $this->db->get_where('faculty', ['qrcode' => $qrcode])->row_array();
        if($faculty) {      
           // $verify = $this->Public_model->get_attendfaculty_verify($date,$faculty['srcode']); 
           $verify =0; 
          if($verify ==0){
            $value = [
              'first_name'  => $faculty['first_name'],
              'last_name'  => $faculty['last_name'],
              'srcode'  => $faculty['srcode'],
              'verified' => 'success'          
            ];
            echo json_encode($value);
    
            $record = [
              'qrcode'  =>  $faculty['qrcode'],
              'RFID' => $faculty['rfid'],
              'username' => $faculty['first_name'].' '.$faculty['last_name'], 
              'srcode' => $faculty['srcode'],
              'building' => $building,
              'in_time' => $time,
              'date' => $date  
            ];
            $this->db->insert('attend_faculty', $record);
          }
          else{
            echo 'duplicate access';
          }
        }
        else 
          echo 'no such qrcode';
      }
    } else if($type == 'rfid') {
      $student = $this->db->get_where('student', ['rfid' => $rfid])->row_array();      
      if($student) {        
        // $verify = $this->Public_model->get_attend_verify($date,$student['srcode']); 
         $verify =0; 
        if($verify ==0){
              $value = [
                'first_name'  => $student['first_name'],
                'last_name'  => $student['last_name'],
                'srcode'  => $student['srcode'],          
                'verified' => 'success'  
              ];
              echo json_encode($value);

              $record = [
                'qrcode'  =>  $student['qrcode'],
                'RFID' => $student['rfid'],
                'username' => $student['first_name'].' '.$student['last_name'], 
                'srcode' => $student['srcode'],
                'building' => $building,
                'in_time' => $time,
                'date' => $date  
              ];
              $this->db->insert('attend', $record);
         }
          else{
            echo 'duplicate access';
          }
        
      }else {
        $faculty = $this->db->get_where('faculty', ['rfid' => $qrcode])->row_array();
        if($faculty) {      
          // $verify = $this->Public_model->get_attendfaculty_verify($date,$faculty['srcode']); 
          $verify =0; 
          if($verify == 0){
              $value = [
                'first_name'  => $faculty['first_name'],
                'last_name'  => $faculty['last_name'],
                'srcode'  => $faculty['srcode'],
                'verified' => 'success'          
              ];
              echo json_encode($value);
      
              $record = [
                'qrcode'  =>  $faculty['qrcode'],
                'RFID' => $faculty['rfid'],
                'username' => $faculty['first_name'].' '.$faculty['last_name'], 
                'srcode' => $faculty['srcode'],
                'building' => $building,
                'in_time' => $time,
                'date' => $date  
              ];
              $this->db->insert('attend_faculty', $record);
          }
          else{
            echo 'duplicate access';
          }
        }
        else 
          echo 'no such rfid';
      }
    }         
  }
  
  
  private function attendance_details_data($e_id)
  {
    $start = $this->input->get('start');
    $end = $this->input->get('end');

   //  $d['attendance'] = $this->Public_model->get_attendance($e_id, $start, $end);
     $d['attendance'] = $this->Public_model->get_attendance_all();

    $d['start'] = $start;
    $d['end'] = $end;

    return $d;
  }
}
