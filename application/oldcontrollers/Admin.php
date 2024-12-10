<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
  // Constructor
  public function __construct()
  {
    parent::__construct();
    is_weekends();
    is_logged_in();
    is_checked_in();
    is_checked_out();
    $this->load->library('form_validation');
    $this->load->model('Public_model');
    $this->load->model('Admin_model');
  }

  // Dashboard
  public function index()
  {
    $dquery = "SELECT department_id AS d_id, COUNT(employee_id) AS qty FROM employee_department GROUP BY d_id";
    $d['d_list'] = $this->db->query($dquery)->result_array();
    $squery = "SELECT shift_id AS s_id, COUNT(id) AS qty FROM employee GROUP BY s_id";
    $d['s_list'] = $this->db->query($squery)->result_array();

    $aquery = $this->db->query("SELECT SUM(slotnumber) AS sum FROM area");
    $d['area_slot'] = $aquery->row()->sum;    
    $d['room_list'] = $this->db->get('room')->num_rows();
    $d['student_list'] = $this->db->get('student')->num_rows();
    $d['kios_list'] = $this->db->get('users')->num_rows();
    $d['location'] = $this->db->get('location')->result_array();
    $d['attend'] = $this->db->get('attend')->result_array();

    date_default_timezone_set("Asia/Manila");
    $date = date("Y-m-d");
    $yesterday = date("Y-m-d", strtotime("yesterday"));
    
    // Dashboard
    $d['title'] = 'Dashboard';
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    $d['display'] = $this->Admin_model->getDataForDashboard();
    
    $d['accesscount']= array(0,0,0,0,0,0);
    $d['accesscount'][0] = $this->Public_model->get_attendcount($yesterday,$date,0);
    $d['accesscount'][1] = $this->Public_model->get_attendcount($yesterday,$date,1);
    $d['accesscount'][2]= $this->Public_model->get_attendcount($yesterday,$date,2);
    $d['accesscount'][3]= $this->Public_model->get_attendcount($yesterday,$date,3);
    $d['accesscount'][4]= $this->Public_model->get_attendcount($yesterday,$date,4);
    $d['accesscount'][5]= $this->Public_model->get_attendcount($yesterday,$date,5);

    $d['facultycount']= array(0,0,0,0,0,0);
    $d['facultycount'][0] = $this->Public_model->get_facultycount($yesterday,$date,0);
    $d['facultycount'][1] = $this->Public_model->get_facultycount($yesterday,$date,1);
    $d['facultycount'][2]= $this->Public_model->get_facultycount($yesterday,$date,2);
    $d['facultycount'][3]= $this->Public_model->get_facultycount($yesterday,$date,3);
    $d['facultycount'][4]= $this->Public_model->get_facultycount($yesterday,$date,4);
    $d['facultycount'][5]= $this->Public_model->get_facultycount($yesterday,$date,5);

    $d['bookingdaily'] = array(
      array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
      array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0), 
      array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
      array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
      array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0), 
      array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0), 
      array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0), 
    );

    
    $day = date_create("today"); 
    $d['date_list'] = array(); 
    for ($i=0,$j=0;$i<31;$i++,$j++){      
      date_modify($day,"-1 days");
      $daily = date_format($day,"y-m-d");
      $d['date_list'][$j] =$daily; 
      $d['bookingdaily'][0][$j]=$this->Public_model->get_bookingdaycount($daily,0);
      $d['bookingdaily'][1][$j]=$this->Public_model->get_bookingdaycount($daily,'GF');
      $d['bookingdaily'][2][$j]=$this->Public_model->get_bookingdaycount($daily,'2F');
      $d['bookingdaily'][3][$j]=$this->Public_model->get_bookingdaycount($daily,'3F');
      $d['bookingdaily'][4][$j]=$this->Public_model->get_bookingdaycount($daily,'4F');
      $d['bookingdaily'][5][$j]=$this->Public_model->get_bookingdaycount($daily,'5F');
      $d['bookingdaily'][6][$j]=$this->Public_model->get_bookingdaycount($daily,'6F');
      $d['bookingdaily'][7][$j]=$this->Public_model->get_bookingdaycount($daily,'7F');      
    }    
    
    $d['attenddaily'] = array(
      array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
      array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0), 
      array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
      array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
      array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0), 
    );
        
    $day = date_create("today"); 
    $d['Sdate_list'] = array(); 
    for ($i=0,$j=0;$i<31;$i++,$j++){      
      date_modify($day,"-1 days");
      $daily = date_format($day,"y-m-d");
      $d['Sdate_list'][$j] =$daily; 
      $d['attenddaily'][0][$j]=$this->Public_model->get_attenddaycount($daily,0);
      $d['attenddaily'][1][$j]=$this->Public_model->get_attenddaycount($daily,1);
      $d['attenddaily'][2][$j]=$this->Public_model->get_attenddaycount($daily,2);
      $d['attenddaily'][3][$j]=$this->Public_model->get_attenddaycount($daily,3);
      $d['attenddaily'][4][$j]=$this->Public_model->get_attenddaycount($daily,4);
      $d['attenddaily'][5][$j]=$this->Public_model->get_attenddaycount($daily,5);
      $d['attenddaily'][6][$j]=$this->Public_model->get_attenddaycount($daily,5);
      $d['attenddaily'][7][$j]=$this->Public_model->get_attenddaycount($daily,5);     
    }   
    
   
    $this->load->view('templates/dashboard_header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('admin/index', $d); // Dashboard Page
    $this->load->view('templates/dashboard_footer');
  }

  public function cms()
  {
    /*
    $dquery = "SELECT department_id AS d_id, COUNT(employee_id) AS qty FROM attendance GROUP BY d_id";
    $d['d_list'] = $this->db->query($dquery)->result_array();
    $squery = "SELECT shift_id AS s_id, COUNT(id) AS qty FROM employee GROUP BY s_id";
    $d['s_list'] = $this->db->query($squery)->result_array();
    */
    $d['title'] = 'CMS';
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    // $d['display'] = $this->Admin_model->getDataForDashboard();

    $this->load->view('templates/dashboard_header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('admin/cms'); 
    $this->load->view('templates/dashboard_footer');
  }
  function do_upload_L(){ //IMAGE UPLOAD
    $config['upload_path']          = './assets/images_L';
    $config['allowed_types']        = 'gif|jpg|png|jpeg|mp4';
    $config['max_size']             = 204800;
    $config['max_width']            = 1024;
    $config['max_height']           = 768;

    $this->load->library('upload', $config);

    if ( ! $this->upload->do_upload('customFile'))
    {
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">You did not select a file to upload.</div>');
            redirect('/admin/cms');
            // print_r($error); die();
            // $this->load->view('upload_form', $error);
    }
    else
    {
            $data = array('upload_data' => $this->upload->data());
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Image Uploaded</div>');
            redirect('/admin/cms');
    }
}
function do_upload_S(){  // small image 
  $config['upload_path']          = './assets/images_S';
  $config['allowed_types']        = 'gif|jpg|png|jpeg|mp4';
  $config['max_size']             = 204800;
  $config['max_width']            = 1024;
  $config['max_height']           = 768;

  $this->load->library('upload', $config);

  if ( ! $this->upload->do_upload('customFile'))
  {
          $error = array('error' => $this->upload->display_errors());
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">You did not select a file to upload.</div>');
          redirect('/admin/cms');
          // print_r($error); die();
          // $this->load->view('upload_form', $error);
  }
  else
  {
          $data = array('upload_data' => $this->upload->data());
          $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Image Uploaded</div>');
          redirect('/admin/cms');
  }
}

function vid_upload(){ //VIDEO UPLOAD
    $config['upload_path']          = './assets/videos';
    $config['allowed_types']        = 'mp4';
    $config['max_size']             = 58142592;
    $config['max_width']            = 1024;
    $config['max_height']           = 768;

    $this->load->library('upload', $config);

    if ( ! $this->upload->do_upload('videoFile'))
    {
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">You did not select a file to upload.</div>');
            redirect('/admin/cms');
    }
    else
    {       
            $data = array('upload_data' => $this->upload->data());
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Video Uploaded, Set the Image for thumbnail.</div>');
            redirect('/admin/cms');
    }
}

  
}
