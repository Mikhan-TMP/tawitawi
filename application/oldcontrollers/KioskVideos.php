<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KioskVideos extends CI_Controller {

	public function index()
	{
		if ($this->session->userdata('username'))
		{
			switch ($this->session->userdata('role_id'))
			{
			  case 1:
				$this->session->unset_userdata('username');
    			$this->session->unset_userdata('role_id');
				redirect('auth');
				break;
			  case 2:
				if($this->session->userdata('device') == 'desktop')
				{
				 //redirect('profile');
					echo 'Error: This page is for KIOSK only';
				}
				else
				{
					$imgList = glob('assets/videos/*.mp4');
					foreach($imgList as $filename){
						if(is_file($filename)){
							echo base_url().$filename.'|';
						}   
					}
					//$this->load->view('kiosk_asset/vidfiles.php');
					break;
				}
			}
			
		}
	}
}
