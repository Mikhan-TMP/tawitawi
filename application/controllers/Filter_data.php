<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Filter_data extends CI_Controller {

  public function __construct(){

    parent::__construct();
    $this->load->helper('url');

    // Load model
    $this->load->model('filter_model');

  }

  public function index(){

    $cities = $this->filter_model->getCities();
    print_r($cities);

    $data['cities'] = $cities;
    
    // load view
    $this->load->view('/admin/student_operator/filter_student',$data);

  }

  public function userList(){

    // POST data
    $postData = $this->input->post();

    // Get data
    $data = $this->filter_model->getUsers($postData);

    echo json_encode($data);
  }

}