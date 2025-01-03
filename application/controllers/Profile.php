<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Public_model');
    $this->load->model('ProfileModel');
    is_logged_in();
  }
  public function index()
    {
        $data['title'] = 'My Profile';
        $username = $this->session->userdata('username');

        if (!$username) {
            redirect('auth'); // Redirect to login if session is not set
        }

        $data['account'] = $this->Public_model->getAllEmployeeData($username);

        // Ensure ID is derived correctly
        // $id = $this->input->get('id');
        // if (!$id) {
            $id = $data['account']['id']; // Fallback to account ID from session
        // }

        // Get image data
        $imageData = $this->ProfileModel->get_image($id);
        // print_r($imageData);
        // Handle the blob data
        // print_r($imageData);
        // echo "Empty -> "; 
        // print_r($imageData['image']);

        if (!empty($imageData['image'])){
            //show image data
            $imageBlob = $imageData['image']; // Adjust the key based on your database column
            $imageType = 'image/jpeg'; // Adjust to the correct MIME type
            $imageSrc = 'data:' . $imageType . ';base64,' . base64_encode($imageBlob);
        }else{
          $defaultAvatar = base_url('images/default-avatar.jpg');
          $imageSrc = $defaultAvatar; // Default to avatar
        }

        $data['imageSrc'] = $imageSrc;
        $data['imageData'] = $imageData;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('profile/index', $data);
        $this->load->view('templates/footer');

    }

}

