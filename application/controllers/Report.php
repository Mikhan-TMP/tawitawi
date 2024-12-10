<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
     is_logged_in();
    is_checked_in();
    is_checked_out();
    $this->load->library('form_validation');
    $this->load->model('Public_model');
    $this->load->model('Admin_model');
  }
  public function index()
  {
    /*
    if ($this->session->userdata('role_id') != 1 ){      
      redirect('Auth');
    }
    */
    $d['title'] = 'Library Reservation History';
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    $d['location'] = $this->db->get('location')->result_array();
    $d['start'] = $this->input->get('start');    
    $d['end'] = $this->input->get('end');    
    $d['dept_code'] = $this->input->get('dept');
    $dept = $this->input->get('dept');
    
    $type = $this->input->get('submit');
    $d['attendance'] = $this->_attendanceDetails($d['start'], $d['end'], $d['dept_code']);
    

    // $d['attendance'] = $this->Public_model->get_attend_all($dept);  
    //  $this->_attendanceDetails($d['start'], $d['end'], $d['dept_code']);

    
    if($type =='Print'){
        $this->load->view('report/print', $d);
    }
    else if($type =='Export') {
         $this->export($d['attendance']);
    }
    else {
        $this->load->view('templates/table_header', $d);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('report/booklogdata', $d);
        $this->load->view('templates/table_footer');
    }
  }

  public function attend_seat()
  {
   /*  if ($this->session->userdata('role_id') != 1 ){      
      redirect('Auth');
    } */

    // $d['title'] = 'Library Seat Attendance History';
    $d['title'] = 'Attend Seat';
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    $d['roomlist'] = $this->db->get('area')->result_array();
    if(isset($_GET['start'])){
      $d['start'] = $this->input->get('start');    
    }
    else {
      $d['start'] = "";    
    }
    if(isset($_GET['end'])){
      $d['end'] = $this->input->get('end');    
    }
    else {
      $d['end'] = "";
    }
    if(isset($_GET['end'])){
      $d['room'] = $this->input->get('roomName');    
    }
    else {
      $d['room'] = "";    
    }
    
    $type = $this->input->get('submit');
    $d['attendance'] = $this->Booklists($d['start'], $d['end'],$d['room']);   

    if($type =='Print'){
      $this->load->view('report/print', $d);
    }
    else if($type =='Export') {
        $this->export($d['attendance']);
    }
    else {
        $this->load->view('templates/table_header', $d);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');        
        $this->load->view('report/attend_seat_view', $d);
        $this->load->view('templates/table_footer');
    }

  }
  private function Attendlists($start, $end, $room) 
  {
    if ($start == '' || $end == '') {
      return $this->Public_model->get_attend();
    } 
    else {
      if($room =='')
        return $this->Public_model->get_attend($start, $end);    
      else 
        return $this->Public_model->get_room_attend($start, $end,$room);    
    }
  }
  public function attend_room()
  {
    /* if ($this->session->userdata('role_id') != 1 ){      
      redirect('Auth');
    } */

    // $d['title'] = 'Library Room Attendance History';
    $d['title'] = 'Attend Room';

    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    $d['roomlist'] = $this->db->get('room')->result_array();
    $d['start'] = $this->input->get('start');    
    $d['end'] = $this->input->get('end');    
    $d['room'] = $this->input->get('room');   

    $type = $this->input->get('submit');

    $d['book'] = $this->BookRoomlists($d['start'], $d['end'],$d['room']);
   

    if($type =='Print'){
      $this->load->view('report/print_room', $d);
    }
    else if($type =='Export') {
        $this->export($d['attendance']);
    }
    else {
        $this->load->view('templates/table_header', $d);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');        
        $this->load->view('report/attend_room_view', $d);
        $this->load->view('templates/table_footer');
    }

  }
  
  public function book_seat_view()
  {
    /* if ($this->session->userdata('role_id') != 1 ){      
      redirect('Auth');
    } */

    // $d['title'] = 'Library Seat Reservation History';
    $d['title'] = 'Reservation Seat';

    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    $d['roomlist'] = $this->db->get('area')->result_array();
    $d['start'] = $this->input->get('start');    
    $d['end'] = $this->input->get('end');    
    $d['room'] = $this->input->get('room');   

    $type = $this->input->get('submit');

    $d['book'] = $this->Booklists($d['start'], $d['end'],$d['room']);
   

    if($type =='Print'){
      $this->load->view('report/print_book_seat', $d);
    }
    else if($type =='Export') {
        $this->export($d['attendance']);
    }
    else {
        $this->load->view('templates/table_header', $d);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');        
        $this->load->view('report/book_seat_view', $d);
        $this->load->view('templates/table_footer');
    }

  }
  public function book_room_view()
  {
   /*  if ($this->session->userdata('role_id') != 1 ){      
      redirect('Auth');
    } */

    // $d['title'] = 'Library Room Reservation History';
    $d['title'] = 'Reservation Room';

    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    $d['roomlist'] = $this->db->get('room')->result_array();
    $d['start'] = $this->input->get('start');    
    $d['end'] = $this->input->get('end');    
    $d['room'] = $this->input->get('room');   

    $type = $this->input->get('submit');

    $d['book'] = $this->BookRoomlists($d['start'], $d['end'],$d['room']);
   

    if($type =='Print'){
      $this->load->view('report/print_book_room', $d);
    }
    else if($type =='Export') {
        $this->export($d['attendance']);
    }
    else {
        $this->load->view('templates/table_header', $d);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');        
        $this->load->view('report/book_room_view', $d);
        $this->load->view('templates/table_footer');
    }

  }
  private function Booklists($start, $end, $room) 
  {
    if ($start == '' || $end == '') {
      if ($room == '')
        return $this->Public_model->get_book_all();
      else 
        return $this->Public_model->get_room_atd($room);      
    } 
    else {
      if($room =='')
        return $this->Public_model->get_book($start, $end);    
      else {
        return $this->Public_model->get_room_book($start, $end,$room);    
      }
    }
  }
  private function PrintTransaction($start, $end, $room) 
  {
    if ($start == '' || $end == '') {
      if ($room == '')
        return $this->Public_model->getTransaction($start, $end, $room);
      else 
        return $this->Public_model->getTransaction($start, $end, $room);
  
    } 
    else {
      if($room =='')
        return $this->Public_model->getTransaction($start, $end, $room);
 
      else {
        return $this->Public_model->getTransaction($start, $end, $room);
   
      }
    }
  }
  private function BookRoomlists($start, $end, $room) 
  {
    if ($start == '' || $end == '') {
      return $this->Public_model->get_book_room_all();
    } 
    else {
      if($room =='')
        return $this->Public_model->get_book_room($start, $end);    
      else 
        return $this->Public_model->get_room_book_room($start, $end,$room);    
    }
  }
  public function transaction_room()
  {
    /* if ($this->session->userdata('role_id') != 1 ){      
      redirect('Auth');
    } */

    // $d['title'] = 'Library Room Transaction';
    $d['title'] = 'Transaction Report';

    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    $d['roomlist'] = $this->db->get('area')->result_array();
    $d['start'] = $this->input->get('start');    
    $d['end'] = $this->input->get('end');    
    $d['room'] = $this->input->get('room');   
    $type = $this->input->get('submit');

    // $d['transactions'] = $this->Public_model->getTransaction($d['start'], $d['end'],$d['room']);
    $d['book'] = $this->Booklists($d['start'], $d['end'],$d['room']);
    // $d['transactions'] = $this->printTransaction($d['start'], $d['end'],$d['room']);

    if($type =='Print'){
      $this->load->view('report/print_transaction', $d);
    }
    else if($type =='Export') {
        $this->export($d['attendance']);
    }
    else {
        $this->load->view('templates/table_header', $d);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');        
        $this->load->view('report/transaction_room_view', $d);
        $this->load->view('templates/table_footer');
    }

  }
  
  private function _attendanceDetails($start, $end, $dept)
  {
    if ($start == '' || $end == '') {
      return $this->Public_model->get_attendance_all();
    } 
    else {
      return $this->Public_model->get_attend($start, $end, $dept);    
    }
  }
  public function attend_print()
  {
    $d = $this->Public_model->get_attendance_all();
    $this->load->view('report/print', $d);
   //  $html = $this->load->view('report/print.php', [], true);
   // $this->pdf->createPDF($html, 'mypdf', false);
   
  }
  public function print($start, $end, $dept)
  {
    $d['start'] = $start;
    $d['end'] = $end;
    $d['attendance'] = $this->Public_model->get_attendance($start, $end, $dept);
    $d['dept'] = $dept;

    $this->load->view('report/print', $d);
  }

  public function  export($d)
  {
   
      $filename = "bsu".date('Ymd') . ".xls";			
      header("Content-Type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=\"$filename\"");	
      $show_coloumn = false;      
      if(!empty($d)) {
        foreach($d as $atd) {
          if(!$show_coloumn) {
            // display field/column names in first row
            echo implode("\t", array_keys($atd)) . "\n";
            $show_coloumn = true;
          }
          echo implode("\t", array_values($atd)) . "\n";
        }
      }
    if(isset($_POST["export_data"])) {	
      exit;  
    }
  }
  
  public function YearTransact()
  {
    /* if ($this->session->userdata('role_id') != 1 ){      
      return ;
   } */
   $d['title'] = 'Library Reservation Year Transaction';
   $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
   $d['location'] = $this->db->get('location')->result_array();
   $year =2023;
   $d['transactcount']= $this->Public_model->get_monthbook($year);

   // print_r($this->Public_model->get_monthbook($year));
   
   $this->load->view('templates/table_header', $d);
   $this->load->view('templates/sidebar');
   $this->load->view('templates/topbar');
   $this->load->view('report/yearreport', $d);
   $this->load->view('templates/table_footer');
   

  }
  public function MonthTransact()
  {
   /*  if ($this->session->userdata('role_id') != 1 ){      
      return ;
   } */
   $d['title'] = 'Library Reservation Year Transaction';
   $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
   // $d['location'] = $this->db->get('location')->result_array();
   $year =2023; $month=9; 
   $d['transactcount']= $this->Public_model->get_daybook($year,$month);

   // print_r($this->Public_model->get_monthbook($year));
   /*
   $this->load->view('templates/table_header', $d);
   $this->load->view('templates/sidebar');
   $this->load->view('templates/topbar');
   $this->load->view('report/yearreport', $d);
   $this->load->view('templates/table_footer');
   */

  }
  public function DayTransact()
  {
   /*  if ($this->session->userdata('role_id') != 1 ){      
      return ;
   } */
   $d['title'] = 'Library Reservation Year Transaction';
   $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
   // $d['location'] = $this->db->get('location')->result_array();
   $year =2023; $month=9; $day = 2;
   $d['transactcount']= $this->Public_model->get_timebook($year,$month,$day);

   print_r($d['transactcount']);
   /*
   $this->load->view('templates/table_header', $d);
   $this->load->view('templates/sidebar');
   $this->load->view('templates/topbar');
   $this->load->view('report/yearreport', $d);
   $this->load->view('templates/table_footer');
   */

  }
  public function getTransaction($start, $end, $room){
    $query = $this->db->select('booking.id, booking.room, booking.floor, booking.slot_id, booking.date, booking.in_time, booking.out_time, booking.start_time, booking.end_time, booking.code, booking.in_status, booking.out_status')
                  ->from('booking');
    if ($room == null || $room == "" && $start == null || $start == "" && $end == null || $end == "") {
      return $query->get()->result_array();
    }
    else if ($room != null && $start == null && $end == null) {
      $this->db->where('booking.room', $room);
      return $query->get()->result_array();
    }
    else if ($room !=null && $start != null && $end != null) {
      $this->db->where('booking.room', $room);
      $this->db->where('booking.date >=', $start);
      $this->db->where('booking.date <=', $end);
      return $query->get()->result_array();
    }
 
  }
  

}
