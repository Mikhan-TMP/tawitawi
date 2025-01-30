<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TestController extends CI_Controller
{
    public function index()
    {
        $this->load->view('testing');
        $this->load->model('Student_model');

    }
}