<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {

	public function index()
	{
		$this->load->view('/admin/cms.php');
                $this->load->view('./assets/videos/videos.php');
        $dir = "assets/images/"; 
        $map = directory_map($dir); 
	}

    function do_upload(){ //IMAGE UPLOAD
        $config['upload_path']          = './assets/images';
        $config['allowed_types']        = 'gif|jpg|png|jpeg|mp4';
        $config['max_size']             = 204800;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('customFile'))
        {
                $error = array('error' => $this->upload->display_errors());
                // $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">You did not select a file to upload.</div>');
                $this->session->set_flashdata('cms_fail', 'There is a problem uploading your file.');
                // redirect('/admin/cms');
                // print_r($error); die();
                // $this->load->view('upload_form', $error);
        }
        else
        {
                $data = array('upload_data' => $this->upload->data());
                $this->session->set_flashdata('cms_success', 'Image Uploaded');
                // $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Image Uploaded</div>');
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
                // iterate error to display errors
                foreach ($error as $key => $value) {
                $this->session->set_flashdata('cms_fail', $value);
                }
                redirect('/admin/cms');
        }
        else
        {       
                $data = array('upload_data' => $this->upload->data());
                $this->session->set_flashdata('cms_success', 'Video Uploaded Successfully.');
                redirect('/admin/cms');
        }
    }

}
