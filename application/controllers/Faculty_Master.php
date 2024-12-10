<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faculty_Master extends CI_Controller {

	function __construct() {
		parent::__construct();
		// Admin
		// is_logged_in();
		// is_checked_in();
		// is_checked_out();
		// is_logged_in();
		$this->load->library('form_validation');
		$this->load->model('Public_model');
		$this->load->model('Admin_model');

		// $this->load->model('data_faculty');
		// $this->md_faclty = $this->data_faculty;

		$this->load->model('data_faculty');
		$this->md_faclty = $this->data_faculty;

		$this->load->model('data_course');
		$this->md_mk = $this->data_course;

		$this->load->model('data_value');
		$this->md_value = $this->data_value;
	}

	public function index()
	{
		redirect( base_url() );
	}

	// all course
	public function faculty()
	{
		$data['list_fuclty'] = $this->md_faclty->list_all();
		// Dashboard
		$d['title'] = 'Dashboard';
		$d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
		// $d['display'] = $this->Admin_model->getDataForDashboard();

		$this->load->view('templates/dashboard_header', $d);
		$this->load->view('templates/sidebar');
		$this->load->view('templates/topbar');
		$this->load->view('admin/faculty_operator/data_faculty', $data);
		$this->load->view('templates/dashboard_footer');
		
	}

	// all course
	public function course()
	{
		$data['list_mk'] = $this->md_mk->list_all();
		// Dashboard
		$d['title'] = 'Dashboard';
		$d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
		// $d['display'] = $this->Admin_model->getDataForDashboard();

		$this->load->view('templates/dashboard_header', $d);
		$this->load->view('templates/sidebar');
		$this->load->view('templates/topbar');
		$this->load->view('admin/faculty_operator/data_course', $data);
		$this->load->view('templates/dashboard_footer');
		
	}

	public function value()
	{
		$data['list_value'] = $this->md_value->list_all();
		$this->load->view('data_value', $data);
	}

	public function add_new() {

		if( empty($this->uri->segment('3'))) {
			redirect( base_url() );
		}

		$name=$this->uri->segment('3');
			
		switch ($name) {

// ADD new faculty
			case 'mhs':
				if( $_SERVER['REQUEST_METHOD'] == 'POST') {
					$first_name= $this->security->xss_clean( $this->input->post('first_name') );
					$last_name= $this->security->xss_clean( $this->input->post('last_name') );
					$srcode= $this->security->xss_clean( $this->input->post('srcode') );
					$gender= $this->security->xss_clean( $this->input->post('gender') );
					$qrcode= $this->security->xss_clean( $this->input->post('qrcode') );
					$rfid= $this->security->xss_clean( $this->input->post('rfid') );
					$course= $this->security->xss_clean( $this->input->post('course') );

					// validasi
					$this->form_validation->set_rules('first_name', 'name faculty', 'required');
					$this->form_validation->set_rules('last_name', 'name faculty', 'required');
					$this->form_validation->set_rules('srcode', 'name faculty', 'required');
					$this->form_validation->set_rules('gender', 'name faculty', 'required');
					$this->form_validation->set_rules('qrcode', 'name faculty', 'required');
					$this->form_validation->set_rules('rfid', 'name faculty', 'required');
					$this->form_validation->set_rules('course', 'name faculty', 'required');

					if(!$this->form_validation->run()) {
						$this->session->set_flashdata('msg_alert', 'Added data faculty data');
						redirect( base_url('Faculty_Master/add_new/' . $name) );
					}
					// to-do
					$this->md_faclty->add_new($first_name,$last_name,$srcode,$gender,$qrcode,$rfid,$course);
					redirect( base_url('Faculty_Master/faculty') );
				}
				break;

// ADD new Course
			case 'mk':
				if( $_SERVER['REQUEST_METHOD'] == 'POST') {
					$name_course= $this->security->xss_clean( $this->input->post('name_course') );
					// validasi
					$this->form_validation->set_rules('name_course', 'name Mata Kuliah', 'required');
					if(!$this->form_validation->run()) {
						$this->session->set_flashdata('msg_alert', 'Added data course data');
						redirect( base_url('Faculty_Master/add_new/' . $name) );
					}
					// to-do
					$this->md_mk->add_new($name_course);
					redirect( base_url('Faculty_Master/course') );
				}
				break;
			case 'value':
				if( $_SERVER['REQUEST_METHOD'] == 'POST') {
					$id= $this->security->xss_clean( $this->input->post('id') );
					$id_course= $this->security->xss_clean( $this->input->post('course') );
					$value= $this->security->xss_clean( $this->input->post('value') );
					// validasi
					$this->form_validation->set_rules('id', 'ID faculty', 'required');
					$this->form_validation->set_rules('id_course', 'ID Course', 'required');
					$this->form_validation->set_rules('value', 'value', 'required');
					if(!$this->form_validation->run()) {
						$this->session->set_flashdata('msg_alert', 'Gagal membuat data value mata kuliah');
						redirect( base_url('Faculty_Master/add_new/' . $name) );
					}
					// to-do
					$this->md_value->add_new($id,$id_course,$value);
					redirect( base_url('Faculty_Master/value') );
				}
				$data['list_fuclty'] = $this->md_faclty->list_all();
				$data['list_mk'] = $this->md_mk->list_all();
				break;
			
			default:
				redirect( base_url() );
				break;
		}

		$data['name'] = $name;
		$d['title'] = 'Dashboard';
		$d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
		// $d['display'] = $this->Admin_model->getDataForDashboard();

		$this->load->view('templates/dashboard_header', $d);
		$this->load->view('templates/sidebar');
		$this->load->view('templates/topbar');
		$this->load->view('admin/faculty_operator/data_addnew', $data);
		$this->load->view('templates/dashboard_footer');

		

	}

	public function edit() {

		if( empty($this->uri->segment('3'))) {
			redirect( base_url() );
		}

		if( empty($this->uri->segment('4'))) {
			redirect( base_url() );
		}

		$name=$this->uri->segment('3');
		$id=$this->uri->segment('4');
		
		switch ($name) {
// EDIT faculty info 
			case 'mhs':
				if( $_SERVER['REQUEST_METHOD'] == 'POST') {
					$id= $this->security->xss_clean( $this->input->post('id') );
					$first_name= $this->security->xss_clean( $this->input->post('first_name') );
					$last_name= $this->security->xss_clean( $this->input->post('last_name') );
					$srcode= $this->security->xss_clean( $this->input->post('srcode') );
					$gender= $this->security->xss_clean( $this->input->post('gender') );
					$qrcode= $this->security->xss_clean( $this->input->post('qrcode') );
					$rfid= $this->security->xss_clean( $this->input->post('rfid') );
					$course= $this->security->xss_clean( $this->input->post('course') );


					// validation
					$this->form_validation->set_rules('id', 'ID faculty', 'required');
					$this->form_validation->set_rules('first_name', 'name faculty', 'required');
					$this->form_validation->set_rules('last_name', 'name faculty', 'required');
					$this->form_validation->set_rules('srcode', 'name faculty', 'required');
					$this->form_validation->set_rules('gender', 'name faculty', 'required');
					$this->form_validation->set_rules('qrcode', 'name faculty', 'required');
					$this->form_validation->set_rules('rfid', 'name faculty', 'required');
					$this->form_validation->set_rules('course', 'name faculty', 'required');

					if(!$this->form_validation->run()) {
						$this->session->set_flashdata('msg_alert', 'Gagal mengubah data faculty');
						redirect( base_url('Faculty_Master/edit/'.$name.'/' . $id) );
					}

					// to-do
					$this->md_faclty->update($id,$first_name,$last_name,$srcode,$gender,$qrcode,$rfid,$course);
					redirect( base_url('Faculty_Master/faculty') );
				}
				$data['id'] = $this->md_faclty->get_data($id)->id;
				$data['first_name'] = $this->md_faclty->get_data($id)->first_name;
				$data['last_name'] = $this->md_faclty->get_data($id)->last_name;
				$data['srcode'] = $this->md_faclty->get_data($id)->srcode;
				$data['gender'] = $this->md_faclty->get_data($id)->gender;
				$data['qrcode'] = $this->md_faclty->get_data($id)->qrcode;
				$data['rfid'] = $this->md_faclty->get_data($id)->rfid;
				$data['course'] = $this->md_faclty->get_data($id)->course;
				break;
// EDIT Course Picker
			case 'mk':
				if( $_SERVER['REQUEST_METHOD'] == 'POST') {
					$id_course= $this->security->xss_clean( $this->input->post('id_course') );
					$name_course= $this->security->xss_clean( $this->input->post('name_course') );
					// validasi
					$this->form_validation->set_rules('id_course', 'ID Mata Kuliah', 'required');
					$this->form_validation->set_rules('name_course', 'name Mata Kuliah', 'required');
					if(!$this->form_validation->run()) {
						$this->session->set_flashdata('msg_alert', 'Gagal mengubah data mata kuliah');
						redirect( base_url('Faculty_Master/edit/'.$name.'/' . $id) );
					}
					// to-do
					$this->md_mk->update($id_course,$name_course);
					redirect( base_url('Faculty_Master/course') );
				}
				$data['id_course'] = $this->md_mk->get_data($id)->id_course;
				$data['name_course'] = $this->md_mk->get_data($id)->name_course;
				break;
// EDIT VALUE 
			case 'value':
				if( $_SERVER['REQUEST_METHOD'] == 'POST') {
					$id_value= $this->security->xss_clean( $this->input->post('id_value') );
					$id= $this->security->xss_clean( $this->input->post('id') );
					$id_course= $this->security->xss_clean( $this->input->post('id_course') );
					$value= $this->security->xss_clean( $this->input->post('value') );
					// validasi
					$this->form_validation->set_rules('id_value', 'ID value', 'required');
					$this->form_validation->set_rules('id', 'ID faculty', 'required');
					$this->form_validation->set_rules('id_course', 'ID Mata Kuliah', 'required');
					$this->form_validation->set_rules('value', 'value', 'required');
					if(!$this->form_validation->run()) {
						$this->session->set_flashdata('msg_alert', 'Gagal membuat data value mata kuliah');
						redirect( base_url('Faculty_Master/edit/'.$name.'/' . $id) );
					}
					// to-do
					$this->md_value->update($id_value,$id,$id_course,$value);
					redirect( base_url('Faculty_Master/value') );
				}
				$data['id_value'] = $this->md_value->get_data($id)->id_value;
				$data['id'] = $this->md_value->get_data($id)->id;
				$data['id_course'] = $this->md_value->get_data($id)->id_course;
				$data['value'] = $this->md_value->get_data($id)->value;
				$data['list_fuclty'] = $this->md_faclty->list_all();
				$data['list_mk'] = $this->md_mk->list_all();
				break;
			
			default:
				redirect( base_url() );
				break;
		}

		$data['id'] = $id;
		$data['name'] = $name;
		$d['title'] = 'Edit faculty';
		$d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
		// $d['display'] = $this->Admin_model->getDataForDashboard();

		$this->load->view('templates/dashboard_header', $d);
		$this->load->view('templates/sidebar');
		$this->load->view('templates/topbar');
		$this->load->view('admin/faculty_operator/data_edit', $data);
		$this->load->view('templates/dashboard_footer');

		

	}

	public function delete() {

		if( empty($this->uri->segment('3'))) {
			redirect( base_url() );
		}

		if( empty($this->uri->segment('4'))) {
			redirect( base_url() );
		}

		$name=$this->uri->segment('3');
		$id=$this->uri->segment('4');

		switch ($name) {
			case 'mhs':
				$this->md_faclty->delete($id);
				$this->session->set_flashdata('msg_alert', 'Data faculty Deleted');
				redirect( base_url('Faculty_Master/faculty') );
				break;
			case 'mk':
				$this->md_mk->delete($id);
				$this->session->set_flashdata('msg_alert', 'Data Course Deleted');
				redirect( base_url('Faculty_Master/course') );
				break;
			case 'value':
				$this->md_value->delete($id);
				$this->session->set_flashdata('msg_alert', 'Data Value Deleted');
				redirect( base_url('Faculty_Master/value') );
				break;
			
			default:
				redirect( base_url() );
				break;
		}

	}

}

/* End of file Faculty_Master.php */
/* Location: ./application/controllers/Faculty_Master.php */