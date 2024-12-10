<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_Faculty extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
  //  $this->load->library('pdf');
    $this->load->model('Public_model');
    $this->load->model('Admin_model');
  }
  public function index()
  {
    if ($this->session->userdata('role_id') != 1 ){
      
       return ;
    }

    $d['title'] = 'Attendance';
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    $d['location'] = $this->db->get('location')->result_array();
    $d['start'] = $this->input->get('start');
    
    $d['end'] = $this->input->get('end');
    
    $d['dept_code'] = $this->input->get('dept');
    $dept = $this->input->get('dept');
    $type = $this->input->get('submit');
   
    $d['attendance'] = $this->_attendfacultyDetails($d['start'], $d['end'], $d['dept_code']);

    // $d['attendance'] = $this->Public_model->get_attend_all($dept);  //  $this->_attendanceDetails($d['start'], $d['end'], $d['dept_code']);

    
    if($type =='Print'){
        $this->load->view('report/facultyprint', $d);
    }
    else if($type =='Export') {
         $this->facultyexport($d['attendance']);
    }
    else {
        $this->load->view('templates/table_header', $d);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('report/facultyview', $d);
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
  private function _attendfacultyDetails($start, $end, $dept)
  {
    if ($start == '' || $end == '') {
      return $this->Public_model->get_attendfaculty_all();
    } 
    else {
      return $this->Public_model->get_attendfaculty($start, $end, $dept);    
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
      // $d= $this->Public_model->get_print_all();
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

  
  public function  facultyexport($d)
  {
   
      $filename = "bsu".date('Ymd') . ".xls";			
      header("Content-Type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=\"$filename\"");	
      $show_coloumn = false;
      // echo "Faculty Attendance Report";
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
  }
}
