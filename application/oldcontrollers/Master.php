<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    is_logged_in();
    $this->load->library('form_validation');
    $this->load->model('Public_model');
    $this->load->model('Admin_model');    
  }
  public function index()
  {
    // Department Data
    $d['title'] = 'Department';
    $d['department'] = $this->db->get('department')->result_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $this->load->view('templates/table_header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/department/index', $d); // Department Page
    $this->load->view('templates/table_footer');
  }

/*************************************   Area *********************************************/
public function area()
  {    
    $d['title'] = 'Library Area Information';
    $d['room'] = $this->db->get('area')->result_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/area/index', $d); // Add Department Page
      $this->load->view('templates/footer');
   
  }
  public function a_area()
  {
    // Add Department
    $d['title'] = 'Library Area Add';
    $d['room'] = $this->db->get('area')->result_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    // Form Validation    
    $this->form_validation->set_rules('d_floor', 'Area floor', 'required');
    $this->form_validation->set_rules('d_name', 'Area name', 'required');
    $this->form_validation->set_rules('d_seat', 'Number', 'required');
    $this->form_validation->set_rules('open_time', 'OPEN TIME', 'required');
    $this->form_validation->set_rules('close_time', 'CLOSE TIME', 'required');
    $this->form_validation->set_rules('min_slot', 'MIN HOUR', 'required');
    $this->form_validation->set_rules('max_slot', 'MAX HOUR', 'required');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/area/a_area', $d); 
      $this->load->view('templates/footer');
    } else {
      $data = [        
        'floor' => $this->input->post('d_floor'),
        'room' => $this->input->post('d_name'),
        'slotnumber' => $this->input->post('d_seat'),
        'opentime' => $this->input->post('open_time'),
        'closetime' => $this->input->post('close_time'),
        'min_slot' => $this->input->post('min_slot'),
        'max_slot' => $this->input->post('max_slot')
      ];

      $this->db->insert('area', $data);
      $rows = $this->db->affected_rows();
      if ($rows > 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Area has been added Successfully!</div>');
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
          Failed to add an Area!</div>');
      }
      redirect('master/area');
    }

  }
  public function e_area($d_id)
  {
    // Edit Department
    $d['title'] = 'Area';
    $d['d_old'] = $this->db->get_where('area', ['id' => $d_id])->row_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    // Form Validation
    $this->form_validation->set_rules('d_floor', 'Area floor', 'required');
    $this->form_validation->set_rules('d_name', 'Area name', 'required');
    $this->form_validation->set_rules('d_seat', 'Number', 'required');
    $this->form_validation->set_rules('open_time', 'OPEN TIME', 'required');
    $this->form_validation->set_rules('close_time', 'CLOSE TIME', 'required');
    $this->form_validation->set_rules('min_slot', 'MIN HOUR', 'required');
    $this->form_validation->set_rules('max_slot', 'MAX HOUR', 'required');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/area/e_area', $d); // Edit Department Page
      $this->load->view('templates/footer');
    } 
    else {      
      $data = [
        'floor' => $this->input->post('d_floor'),
        'room' => $this->input->post('d_name'),
        'slotnumber' => $this->input->post('d_seat'),
        'opentime' => $this->input->post('open_time'),
        'closetime' => $this->input->post('close_time'),
        'min_slot' => $this->input->post('min_slot'),
        'max_slot' => $this->input->post('max_slot')
      ];
      $this->db->update('area', $data, ['id' => $d_id]);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
      Area has been Updated Successfully!</div>');
      redirect('master/area');
    }
  }
  
  public function d_area($d_id)
  {
    $this->db->delete('area', ['id' => $d_id]);
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Area has been Removed!</div>');
    redirect('master/area');
  }
  /*************************************   Room  *********************************************/
  public function room()
  {    
    $d['title'] = 'Library Room Information';
    $d['room'] = $this->db->get('room')->result_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/room/index', $d); // Add Department Page
      $this->load->view('templates/footer');
   
  }
  public function a_room()
  {
    // Add Department
    $d['title'] = 'Add Room';
    $d['room'] = $this->db->get('room')->result_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    // Form Validation
    
    $this->form_validation->set_rules('d_floor', 'Room Floor', 'required');
    $this->form_validation->set_rules('d_name', 'Room Name', 'required');
    $this->form_validation->set_rules('d_seat', 'seat', 'required');
    $this->form_validation->set_rules('open_time', 'OPEN TIME', 'required');
    $this->form_validation->set_rules('close_time', 'CLOSE TIME', 'required');
    $this->form_validation->set_rules('min_slot', 'MIN HOUR', 'required');
    $this->form_validation->set_rules('max_slot', 'MAX HOUR', 'required');


    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/room/a_room', $d); // Add Department Page
      $this->load->view('templates/footer');
    } else {
      $data = [        
        'floor' => $this->input->post('d_floor'),
        'room' => $this->input->post('d_name'),
        'slotnumber' => $this->input->post('d_seat'),
        'opentime' => $this->input->post('open_time'),
        'closetime' => $this->input->post('close_time'),
        'min_slot' => $this->input->post('min_slot'),
        'max_slot' => $this->input->post('max_slot')
      ];
      $this->db->insert('room', $data);
      $rows = $this->db->affected_rows();
      if ($rows > 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Room has been added Successfully!</div>');
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
          Failed to add Room!</div>');
      }      
      redirect('master/room');      
  }
    
  }
  public function e_room($d_id)
  {
    // Edit Department
    $d['title'] = 'Edit Room Information';
    $d['d_old'] = $this->db->get_where('room', ['id' => $d_id])->row_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    // Form Validation
    
    $this->form_validation->set_rules('d_floor', 'Room Name', 'required');
    $this->form_validation->set_rules('d_name', 'Room Name', 'required');
    $this->form_validation->set_rules('d_seat', 'Room Name', 'required');
    $this->form_validation->set_rules('open_time', 'OPEN TIME', 'required');
    $this->form_validation->set_rules('close_time', 'CLOSE TIME', 'required');
    $this->form_validation->set_rules('min_slot', 'MIN HOUR', 'required');
    $this->form_validation->set_rules('max_slot', 'MAX HOUR', 'required');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/room/e_room', $d); // Edit Department Page
      $this->load->view('templates/footer');
    } 
    else {      
      $data = [
        'id' => $this->input->post('d_id'),
        'floor' => $this->input->post('d_floor'),
        'room' => $this->input->post('d_name'),
        'slotnumber' => $this->input->post('d_seat'),
        'opentime' => $this->input->post('open_time'),
        'closetime' => $this->input->post('close_time'),
        'min_slot' => $this->input->post('min_slot'),
        'max_slot' => $this->input->post('max_slot')
      ];
      $this->db->update('room', $data, ['id' => $d_id]);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
      Room has been Updated Successfully!</div>');
      redirect('master/room');
    }
    
  }
  
  public function d_room($d_id)
  {
    $this->db->delete('room', ['id' => $d_id]);
    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Room has been Removed!</div>');
    redirect('master/room');
  }
/********************************************************************************************/

/********************************************************************************************/
  public function student()
  {    
    $d['title'] = 'Student';
    
    // $this->db->limit(200);
    $d['studentList'] = $this->db->get('student')->result_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $this->load->view('templates/table_header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/student/index', $d); // Student Page
    $this->load->view('templates/table_footer');
  }

  public function add_student()
  {

    $this->form_validation->set_rules('f_name', 'first name', 'required|trim');
    $this->form_validation->set_rules('m_name', 'middle name', 'required|trim');
    $this->form_validation->set_rules('l_name', 'last name', 'required|trim');
    //srcode = studentid
    $this->form_validation->set_rules('srcode', 'sr code ', 'required|trim');
    // $this->form_validation->set_rules('rfid', 'RF id', 'required|trim');
    $this->form_validation->set_rules('year', 'Year', 'required|trim');
    $this->form_validation->set_rules('course', 'course', 'required|trim');
    $this->form_validation->set_rules('college', 'college', 'required|trim');

    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
      Empty Data !</div>');
      redirect('master/student');
    }
    else{
      $data = [
        'first_name' => $this->input->post('f_name'),
        'middle_name' => $this->input->post('m_name'),
        'last_name' => $this->input->post('l_name'),
        'srcode' => $this->input->post('srcode'),
        'gender' => $this->input->post('e_gender'),
        // 'qrcode' => $this->input->post('qrcode'),
        'email' => $this->input->post('email'),
        // 'rfid' => $this->input->post('rfid'),
        'pin' => $this->input->post('pin'), 
        'schoolyear' => $this->input->post('year'),
        'course' => $this->input->post('course'),
        'college' => $this->input->post('college')
        // 'password' => $this->input->post('srcode') . $this->input->post('l_name')
      ];
      print_r($data);
      $this->db->insert('student', $data);
      $rows = $this->db->affected_rows();
      if ($rows > 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
          Successfully added a New student! </div>');
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
          Failed to add data!</div>');
      }
      redirect('master/student');
    }
  }
  public function edit_student()
  {
      $e_id = $this->input->post('e_id');   
      $data = [
          'first_name' => $this->input->post('f_name'),
          'middle_name' => $this->input->post('m_name'),
          'last_name' => $this->input->post('l_name'),
          'srcode' => $this->input->post('srcode'),
          'gender' => $this->input->post('e_gender'),
          'pin' => $this->input->post('pin'),
          'schoolyear' => $this->input->post('year'),
          'course' => $this->input->post('course'),
          'college' => $this->input->post('college')
      ];
  
      $this->db->update('student', $data, ['id' => $e_id]);
      $rows = $this->db->affected_rows();
      
      if ($rows > 0) {
          $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Successfully Updated Student Data!</div>');
      } elseif ($rows === 0) {
          $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">
            No changes were made to the student data.</div>');
      } else {
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Failed to Update Student Data!</div>');
      }
      redirect('master/student');
  }
  


  public function a_student()
  {
    $d['title'] = 'Student';
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);   
    
    $this->load->view('templates/header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/student/a_student', $d); // Add Employee Page
    $this->load->view('templates/footer');
    
  }

  

  public function e_student($e_id)
  {
    $d['title'] = 'Student';
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);   
    $d['student'] = $this->db->get_where('student', ['id' => $e_id])->row_array();
    
    $this->form_validation->set_rules('f_name', 'first name', 'required|trim');
    $this->form_validation->set_rules('l_name', 'last name', 'required|trim');
    $this->form_validation->set_rules('srcode', 'sr code ', 'required|trim');
    // $this->form_validation->set_rules('rfid', 'RF id', 'required|trim');
    $this->form_validation->set_rules('year', 'Year', 'required|trim');
    $this->form_validation->set_rules('course', 'course', 'required|trim');
    

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/student/e_student', $d); // Edit student Page
      $this->load->view('templates/footer');
    } else {
      $first_name = $this->input->post('first_name');
      $last_name = $this->input->post('last_name');
      $srcode = $this->input->post('srcode');      
      // $rfid = $this->input->post('rfid');
      // $qrcode = $this->input->post('qrcode');
      $pin = $this->input->post('pin');
      $gender = $this->input->post('gender');
      $course = $this->input->post('course');
      $schoolyear = $this->input->post('year');
      
      $data = [
        'first_name'  => $first_name,
        'last_name'   => $last_name,
        'srcode'      => $srcode,      
        // 'rfid'        => $rfid,
        // 'qrcode'      => $qrcode,
        'pin'         => $pin,
        'gender'      => $gender,
        'course'      => $course,
        'schoolyear'  => $schoolyear
      ];      
      $this->db->update('student', $data, ['id' => $e_id]); 
      $upd1 = $this->db->affected_rows(); 
      if ($upd1 > 0 ) {
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Successfully Updated Sudent Data!</div>');
        redirect('master/student');
      } 
      else{
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
          Failed to Update Data!</div>');

          redirect('master/student');
      } 
      
    }
  }
  
  public function d_student($e_id)
  {
    $this->db->delete('student', ['id' => $e_id]);
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Successfully Removed Student Data!</div>');
    redirect('master/student');
  }
  /************************ Location or Kiosk ****************** */
  public function location()
  {
    $d['title'] = 'Location';
    $d['location'] = $this->db->get('location')->result_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $this->load->view('templates/table_header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/location/index', $d);
    $this->load->view('templates/table_footer');
  }
  public function a_location()
  {
    $d['title'] = 'Location';
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $this->form_validation->set_rules('l_name', 'Location Name', 'required|trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/location/a_location', $d);
      $this->load->view('templates/footer');
    } else {
      $data['name'] = $this->input->post('l_name');
      $this->_addLocation($data);
    }
  }
  private function _addLocation($data)
  {
    $this->db->insert('location', $data);
    $rows = $this->db->affected_rows();

    if ($rows > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Successfully added a new location!</div>');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Failed to add data!</div>');
    }
    redirect('master/location');
  }
  
  public function e_location($l_id)
  {
    // Edit Location
    $d['title'] = 'Location';
    $d['l_old'] = $this->db->get_where('location', ['id' => $l_id])->row_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    // Form Validation
    $this->form_validation->set_rules('l_name', 'Location Name', 'required|trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/Location/e_location', $d); // Edit Location Page
      $this->load->view('templates/footer');
    } else {
      $name = $this->input->post('l_name');
      $this->_editLocation($l_id, $name);
    }
  }
  private function _editLocation($l_id, $name)
  {
    $data = ['name' => $name];
    $this->db->update('location', $data, ['id' => $l_id]);
    $rows = $this->db->affected_rows();

    if ($rows > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
          Successfully edited a location!</div>');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Failed to edit data!</div>');
    }

    redirect('master/location');
  }
  public function d_location($l_id)
  {
    $query = 'ALTER TABLE `location` AUTO_INCREMENT = 1';
    $this->db->query($query);
    $this->db->delete('location', ['id' => $l_id]);
    $rows = $this->db->affected_rows();

    if ($rows > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Successfully deleted a location!</div>');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Failed to delete a data!</div>');
    }

    redirect('master/employee');
  }
  // end of location
  
  /**********************   Kiosk                    ************************** */
  public function kiosk()
  {
    
    $d['title'] = 'KIOSK';
    $query = "SELECT users.id AS e_id,users.username AS u_username,location.name AS e_name, users.floor AS e_floor FROM users   LEFT JOIN location  ON users.id = location.id WHERE users.role_id =3 ";
    $d['data'] = $this->db->query($query)->result_array();   
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $this->load->view('templates/table_header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/kiosk/index', $d);
    $this->load->view('templates/table_footer');
  }

  public function a_kiosk()
  {
    $d['title'] = 'Kiosk  Add';          
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $this->form_validation->set_rules('u_username', 'Username', 'required|trim|min_length[6]');
    $this->form_validation->set_rules('u_password', 'Password', 'required|trim|min_length[6]');
    $this->form_validation->set_rules('u_floor', 'Floor', 'required');
    

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/kiosk/a_kiosk', $d);
      $this->load->view('templates/footer');
    } 
    else {
      $username = $this->input->post('u_username');
      if($this->input->post('u_password')!=$this->input->post('c_password'))
      {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Password not match!</div>');
        redirect('master/a_kiosk');
      }
      else{
        $data = [
          'floor' => $this->input->post('u_floor'),
          'username' => $username,
          'password' => password_hash($this->input->post('u_password'), PASSWORD_DEFAULT),          
          'employee_id' => 010,
          'role_id' => 3     // this is kiosk role ID 
        ];        
        $this->_addKiosk($data);
      }
    }

  }
  public function e_kiosk($id)
  {
    $d['title'] = 'Update Kiosk data';
    $d['users'] = $this->db->get_where('users', ['id' => $id])->row_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $this->form_validation->set_rules('floor', 'floor', 'required');    
    $this->form_validation->set_rules('username', 'username', 'required');    
    $this->form_validation->set_rules('password', 'Password', 'required');    

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      echo "validation error";
      $this->load->view('master/kiosk/e_kiosk', $d);
      $this->load->view('templates/footer');
    } else {
      $data = [
        'floor' => $this->input->post('floor'),
        'username' => $this->input->post('username'),    
        'role_id' => 3, // this is kiosk role ID     
        'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
      ];
      $this->db->update('users', $data, ['id' => $id]);
      $rows = $this->db->affected_rows();
      if ($rows > 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Successfully edited an account!</div>');
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
          Failed to edit account!</div>');
      }
      redirect('master/kiosk');
    }
    
  }
  public function d_kiosk($id)
  {
    $this->db->delete('users', ['id' => $id]);
    $rows = $this->db->affected_rows();
    if ($rows > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
          Successfully deleted an account!</div>');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Failed to delete account!</div>');
    }
    redirect('master/kiosk');
  }
  private function _addKiosk($data)
  {    
    
    $this->db->insert('users', $data);
    $rows = $this->db->affected_rows();
    if ($rows > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
          Successfully created an account!</div>');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Failed to create account!</div>');
    }
    redirect('master/kiosk');
  }
/**********************   Librian              ************************** */

/**************************************************************************/

public function users()
  {
    // $query = "SELECT location.id AS e_id, users.id AS d_id,users.username AS u_username,location.name AS e_name, users.floor AS e_floor FROM location  LEFT JOIN users  ON location.id = users.id ";
    $query = "SELECT 
    users.id AS e_id,
    users.username AS u_username,
    users.fname AS u_fname,
    users.lname AS u_lname,
    users.email AS u_email,
    location.name AS e_name, 
    users.floor AS e_floor 
    FROM users  LEFT JOIN location  ON users.id = location.id 
    WHERE users.role_id =2  ";
    
    $d['title'] = 'Librarian';
    $d['data'] = $this->db->query($query)->result_array();    
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $this->load->view('templates/table_header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/users/index', $d);
    $this->load->view('templates/table_footer');
  }
  public function a_users()
  {
    $d['title'] = 'Librarian Add';          
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $this->form_validation->set_rules('u_username', 'Username', 'required|trim|min_length[6]');
    $this->form_validation->set_rules('u_password', 'Password', 'required|trim|min_length[6]');
    $this->form_validation->set_rules('u_floor', 'Floor', 'required');
    

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/users/a_users', $d);
      $this->load->view('templates/footer');
    } 
    else {
      $username = $this->input->post('u_username');
      if($this->input->post('u_password')!=$this->input->post('c_password'))
      {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Password not match!</div>');
        redirect('master/a_users');
      }
      else{
        $data = [
          'floor' => $this->input->post('u_floor'),
          'username' => $username,
          'password' => password_hash($this->input->post('u_password'), PASSWORD_DEFAULT),
          'fname' => $this->input->post('u_fname'),
          'lname' => $this->input->post('u_lname'),
          'email' => $this->input->post('u_email'),                  
          'role_id' => 2,
          'is_verified' => 1,
          'permision' => json_encode([
            'My Profile' => 1,
            'Dashboard' => 0,
            'Room' => 0,
            'Area' => 0,
            'Faculty' => 0,
            'Student' => 0,
            'Librarian' => 0,
            'CMS' => 0,
            'Attendance' => 0,
            'Attend Seat' => 0,
            'Attend Room' => 0,
            'Reservation Seat' => 0,
            'Reservation Room' => 0,
            'Transaction Report' => 0,
            'Seat Status' => 0,
            'Room Status' => 0,
            'Room Reservation' => 0,
            'Live Monitoring' => 0,
          ]),
        ];
        // print_r($data);
        $this->_addUsers($data);
      }
    }

  }
  private function _addUsers($data)
  {    
    
    $this->db->insert('users', $data);
    $rows = $this->db->affected_rows();
    if ($rows > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
          Successfully Added a New Librarian!</div>');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Failed to Add New Librarian!</div>');
    }
    redirect('master/users');
  }

  public function e_users($id)
  {
    $d['title'] = 'Update Librarian';
    $d['titles'] = 'Librarian Access Setup';
    $d['users'] = $this->db->get_where('users', ['id' => $id])->row_array();
    $d['user_access'] = $this->db->get_where('user_access')->result_array(); 
    $d['user_role'] = $this->db->get_where('user_role')->result_array();
    $d['user_menu'] = $this->db->get_where('user_submenu')->result_array();

    // $query = "SELECT permision FROM users where id = 2 ";
    // $sample = $this->db->query($query)->row_array();   
    // $dec = json_decode($sample['permision'], true);
    // foreach  ($d['user_menu'] as $permisionata)  :
    //   echo ($dec[$permisionata['title']]);
    //   endforeach ;
    // echo json_encode ($sample['permision'],JSON_PRETTY_PRINT);
    


    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    
    $this->form_validation->set_rules('u_username', 'Username', 'required|trim|min_length[6]');
    $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');
    $this->form_validation->set_rules('u_floor', 'Floor', 'required');
    if (!isset($_POST['submit'])) {
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/users/e_users', $d);
      $this->load->view('templates/footer');
    } 
    else {
      $menucount= sizeof($d['user_menu']);
           
      for ($id=0 ; $id<$menucount; $id++){
        $data= $this->input->post('access'.$user_menu[$id]['id']);
        echo($data);
      }
    }

    
  }
  public function edit_user_access()
  {
    $d['title'] = 'Librarian Access Setup';
    $id = $this->input->post('u_id');
    $users = $this->db->get_where('users', ['id' => $id])->row_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    
    $d['user_menu']= $user_menu = $this->db->get_where('user_submenu')->result_array();   
    
    $menucount= sizeof($d['user_menu']);    
    $permission= json_decode($users['permision'], true); 

    for ($i=0 ; $i<$menucount; $i++){
      $data= $this->input->post('access'.$user_menu[$i]['id']);
      if ($data == "ON") {
         // echo ('access'.$user_menu[$i]['id'].'status:'.$permission[$user_menu[$i]['title']].'</br>');   
         $permission[$user_menu[$i]['title']]=1;     
      }
      else{
        // echo ('access'.$user_menu[$i]['id'].'status:'.$permission[$user_menu[$i]['title']].'</br>');
        $permission[$user_menu[$i]['title']]=0;
      }
    }    
    $jsonpermission =  json_encode($permission);
    $data = [
      'floor' => $this->input->post('u_floor'),
      'username' => $this->input->post('u_username'),
      'fname' => $this->input->post('u_fname'),
      'lname' => $this->input->post('u_lname'),
      'email' => $this->input->post('u_email'),
      'permision' => json_encode($permission)
    ];     
    $this->db->update('users',$data , ['id' => $id]);
    $rows = $this->db->affected_rows();
    if ($rows > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Successfully edited an account!</div>');
      // echo ("success");
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Failed to edit account!</div>');
      // echo ("fail to update");
    }
    redirect('master/users'); 
    
  }
  private function _editUsers($data, $id)
  {    
    $this->db->update('users', $data, ['id' => $id]);
    $rows = $this->db->affected_rows();
    if ($rows > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
          Successfully edited an account!</div>');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Failed to edit account!</div>');
    }
    redirect('master/users');
  }

  public function d_users($id)
  {
    $this->db->delete('users', ['id' => $id]);
    $rows = $this->db->affected_rows();
    if ($rows > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
          Successfully deleted an account!</div>');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Failed to delete account!</div>');
    }
    redirect('master/users');
  }

  public function user_access()
  {
    $d['title'] = 'Librarian Access Setup';
    $d['users'] = $this->db->get_where('users')->row_array();    
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    
    $query = "SELECT `menu_id` FROM `user_access`   where `role_id`=2";    
    $user_access = $this->db->query($query)->result_array();  
    
    $d['user_role'] = $this->db->get_where('user_role')->result_array();   
    $d['user_menu']= $user_menu = $this->db->get_where('user_submenu')->result_array();   
    
    if (!isset($_POST['submit'])) {
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');   
      $this->load->view('master/users/user_access', $d);
      $this->load->view('templates/footer');
    }
    else{            
      $menucount= sizeof($d['user_menu']);
            
      for ($id=0 ; $id<$menucount; $id++){
        $data= $this->input->post('access'.$user_menu[$id]['id']);
        if ($data == "ON") {
          $this->db->update('user_submenu', ['permit' =>'Yes'] , ['id' => $user_menu[$id]['id']]);
          // echo ('access'.$user_menu[$id]['id'].'status:'.$data.'</br>');        
        }
        else{
          $this->db->update('user_submenu', ['permit' =>'No'] , ['id' => $user_menu[$id]['id']]);
          // echo ('access'.$user_menu[$id]['id'].'status:'.$data.'</br>');
        }
      }
     redirect('master/users'); 
    } 
    
  }
  private function _editUserAccess($data, $id)
  {    
    $this->db->update('users', $data, ['id' => $id]);
    $rows = $this->db->affected_rows();
    if ($rows > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
          Successfully Edited an Account!</div>');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Failed to Edit Account!</div>');
    }
    redirect('master/users');
  }

/******************  faculty   ****************************************** */

/************************************************************************ */
  public function faculty()
  {
    // Employee Data
    $d['title'] = 'Faculty';
    $d['faculty'] = $this->db->get('faculty')->result_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    $this->load->view('templates/table_header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/faculty/index', $d); 
    $this->load->view('templates/table_footer');
  }

  public function a_faculty()
  {
    // Add Employee
    $d['title'] = 'Faculty';
    $d['department'] = $this->db->get('department')->result_array();
    $d['shift'] = $this->db->get('shift')->result_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    // Form Validation    
    $this->form_validation->set_rules('e_name', 'Faculty Name', 'required|trim');
    
    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/faculty/a_faculty', $d); // Add Employee Page
      $this->load->view('templates/footer');
    } else {
      $this->_addEmployee();
    }
  }

  
  public function add_faculty()
  {
    
    $this->form_validation->set_rules('f_name', 'first name', 'required|trim');
    $this->form_validation->set_rules('l_name', 'last name', 'required|trim');
    $this->form_validation->set_rules('srcode', 'sr code ', 'required|trim');
    // $this->form_validation->set_rules('rfid', 'RF id', 'required|trim');
    $this->form_validation->set_rules('pin', 'pin' , 'required|trim');
    $this->form_validation->set_rules('course', 'course', 'required|trim');
    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
      Empty Data!</div>');
      redirect('master/faculty');
    }
    else{     
      $data = [
        'first_name' => $this->input->post('f_name'),
        'middle_name' => $this->input->post('m_name'),
        'last_name' => $this->input->post('l_name'),
        'srcode' => $this->input->post('srcode'),
        'gender' => $this->input->post('e_gender'),
        // 'qrcode' => $this->input->post('qrcode'),
        // 'rfid' => $this->input->post('rfid'),
        'pin' => $this->input->post('pin'),
        'course' => $this->input->post('course')
      ];
      
      $this->db->insert('faculty', $data);
      $rows = $this->db->affected_rows();
      if ($rows > 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
          New Faculty has been added!</div>');
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
          Failed to Add New Faculty!</div>');
      }
      redirect('master/faculty');
    }
  }
  public function e_faculty($e_id)
  {
    $d['title'] = 'Faculty';
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);   
    $d['employee'] = $this->db->get_where('faculty', ['id' => $e_id])->row_array();
    
    $this->form_validation->set_rules('f_name', 'first name', 'required|trim');
    $this->form_validation->set_rules('l_name', 'last name', 'required|trim');
    $this->form_validation->set_rules('srcode', 'sr code ', 'required|trim');
    // $this->form_validation->set_rules('rfid', 'RF id', 'required|trim');    
    // $this->form_validation->set_rules('course', 'course', 'required|trim');
    // for pin
    $this->form_validation->set_rules('pin', 'pin' , 'required|trim');

    $this->load->view('templates/header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/faculty/e_faculty', $d); 
    $this->load->view('templates/footer');

  }
  
  public function edit_faculty()
  {
    $e_id = $this->input->post('e_id');   
    $data = [
      'first_name' => $this->input->post('f_name'),
      'middle_name' => $this->input->post('m_name'),
      'last_name' => $this->input->post('l_name'),
      'srcode' => $this->input->post('srcode'),
      'gender' => $this->input->post('e_gender'),
      // 'qrcode' => $this->input->post('qrcode'),
      // 'rfid' => $this->input->post('rfid'),
      'pin' => $this->input->post('pin'),
      'course' => $this->input->post('college')
    ];

    $this->db->update('faculty', $data, ['id' => $e_id]);
    $rows = $this->db->affected_rows();
    if ($rows > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Faculty Information has been Updated!</div>');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Failed to Update Faculty!</div>');
    }
    redirect('master/faculty');
  }


  public function d_faculty($e_id)
  {
    $this->db->delete('faculty', ['id' => $e_id]);
    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Faculty has been Removed!</div>');
    redirect('master/faculty');
  }
  public function import_faculty()
	{
		if(isset($_FILES["file"]["name"]))
		{
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for($row=2; $row<=$highestRow; $row++)
				{
					$first_name = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$last_name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$srcode = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$gender = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$qrcode = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
					$rfid = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$course = $worksheet->getCellByColumnAndRow(6, $row)->getValue();				

					$data[] = array(
						'first_name'	=>	$first_name,
						'last_name'		=>	$last_name,
						'srcode'		=>	$srcode,						
						'gender'		=>	$gender,						
						'qrcode'		=>	$qrcode,
						'rfid'			=>	$rfid,
						'course'		=>	$course,
						
					);
				}
			}
			$return = $this->faculty_import_model->insert($data);
      if($return== TRUE)
      {
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Successfully Imported an Faculty!</div>');
        redirect('master/faculty');
      }
      else{
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Failed to import faculty\'s data!</div>');
        redirect('master/faculty');
      }
			echo 'Data Imported successfully';
		}	
	}



  public function visitor()
  {    
    $d['title'] = 'Visitor';
    
    $d['visitor'] = $this->db->get('visitor')->result_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);


    $this->load->view('templates/table_header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/visitor/index', $d);
    $this->load->view('templates/table_footer');
  }
  public function a_visitor()
    {
      // Add Department
      $d['title'] = 'Visitor';
      $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
      // Form Validation
      $this->form_validation->set_rules('e_id', 'visitor ID', 'required|trim');
      $this->form_validation->set_rules('qrcode', 'QR code', 'required|trim');
  
      if ($this->form_validation->run() == false) {
        $this->load->view('templates/header', $d);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('master/visitor/a_visitor', $d); // Add Department Page
        $this->load->view('templates/footer');
      } else {
        $this->_add_visitor();
      }
    }
  public function add_visitor()
  {
    $this->form_validation->set_rules('e_name', 'visitor name', 'required|trim');
    $this->form_validation->set_rules('qrcode', 'QR code', 'required|trim');
    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
      empty data !</div>');
      redirect('master/visitor');
    }
    else{     
      $data = [
        'name' => $this->input->post('e_name'),
        'qrcode' => $this->input->post('qrcode'),
        'rfid' => $this->input->post('rfid'),
        'gender' => $this->input->post('gender')        
      ];
      print_r($data);      
      $this->db->insert('visitor', $data);
      $rows = $this->db->affected_rows();
      if ($rows > 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
          Successfully added a new visitor!</div>');
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
          Failed to add data!</div>');
      }
      redirect('master/visitor');
    }
  }
  public function e_visitor($e_id)
  {
    $d['title'] = 'Visitor';
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);   
    $d['visitor'] = $this->db->get_where('visitor', ['id' => $e_id])->row_array();
    
    $this->form_validation->set_rules('e_name', 'name', 'required|trim');    
    $this->form_validation->set_rules('qrcode', 'qr code ', 'required|trim');
    

    $this->load->view('templates/header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/visitor/e_visitor', $d); 
    $this->load->view('templates/footer');

  }
  
  public function edit_visitor()
  {
    $e_id = $this->input->post('e_id');   
    $data = [
      'name' => $this->input->post('e_name'),            
      'gender' => $this->input->post('e_gender'),
      'qrcode' => $this->input->post('qrcode'),
      'rfid' => $this->input->post('rfid')      
    ];

    $this->db->update('visitor', $data, ['id' => $e_id]);
    $rows = $this->db->affected_rows();
    if ($rows > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Successfully update a new visitor!</div>');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Failed to update data!</div>');
    }
    redirect('master/visitor');
  }
  public function d_visitor($e_id)
  {
    $this->db->delete('visitor', ['id' => $e_id]);
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Successfully deleted an visitor!</div>');
    redirect('master/visitor');
  }
  public function ban_list()
  {    
    $d['title'] = 'Ban List';
    
    $d['ban'] = $this->db->get('ban_list')->result_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);


    $this->load->view('templates/table_header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/ban/index', $d);
    $this->load->view('templates/table_footer');
  }
  public function a_ban()
    {
      // Add Department
      $d['title'] = 'Ban List';
      $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
      // Form Validation
      $this->form_validation->set_rules('e_id', 'visitor ID', 'required|trim');
      $this->form_validation->set_rules('qrcode', 'QR code', 'required|trim');
  
      if ($this->form_validation->run() == false) {
        $this->load->view('templates/header', $d);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('master/ban/a_ban', $d); // Add Department Page
        $this->load->view('templates/footer');
      } else {
        $this->_add_ban();
      }
    }
  public function add_ban()
  {
    $this->form_validation->set_rules('e_name', 'ban name', 'required|trim');
    $this->form_validation->set_rules('qrcode', 'QR code', 'required|trim');
    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
      empty data !</div>');
      redirect('master/ban_list');
    }
    else{     
      $data = [
        'name' => $this->input->post('e_name'),
        'qrcode' => $this->input->post('qrcode'),
        'rfid' => $this->input->post('rfid'),
        'gender' => $this->input->post('gender')        
      ];
      print_r($data);      
      $this->db->insert('ban_list', $data);
      $rows = $this->db->affected_rows();
      if ($rows > 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
          Successfully added a new ban!</div>');
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
          Failed to add data!</div>');
      }
      redirect('master/ban_list');
    }
  }
  public function e_ban($e_id)
  {
    $d['title'] = 'ban Update';
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);   
    $d['ban'] = $this->db->get_where('ban_list', ['id' => $e_id])->row_array();
    
    $this->form_validation->set_rules('e_name', 'name', 'required|trim');    
    $this->form_validation->set_rules('qrcode', 'qr code ', 'required|trim');
    

    $this->load->view('templates/header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/ban/e_ban', $d); 
    $this->load->view('templates/footer');

  }
  
  public function edit_ban()
  {
    $e_id = $this->input->post('e_id');   
    $data = [
      'name' => $this->input->post('e_name'),            
      'gender' => $this->input->post('e_gender'),
      'qrcode' => $this->input->post('qrcode'),
      'rfid' => $this->input->post('rfid')      
    ];

    $this->db->update('ban_list', $data, ['id' => $e_id]);
    $rows = $this->db->affected_rows();
    if ($rows > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Successfully update a new ban List!</div>');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Failed to update data!</div>');
    }
    redirect('master/visitor');
  }
  public function d_ban($e_id)
  {
    $this->db->delete('ban_list', ['id' => $e_id]);
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Successfully deleted an ban list!</div>');
    redirect('master/ban');
  }
  /******     ***************************************************************/
  public function ScheduleContol()
  {

    // Department Data
    $d['title'] = 'Schedule Set';
    $d['department'] = $this->db->get('department')->result_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    $d['open_schedule'] = $this->db->get_where('schedule', ['category' => 'open'])->result_array(); 
    $d['close_schedule'] = $this->db->get_where('schedule', ['category' => 'close'])->result_array(); 


    $this->load->view('templates/table_header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/elib_status', $d); // Department Page
    $this->load->view('templates/table_footer');
  }

  public function d_schedule($e_id)
  {
    $this->db->delete('schedule', ['id' => $e_id]);
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Successfully deleted an schedule!</div>');
    redirect('master/ScheduleContol');
  }
  public function add_schedule()
  {
    $this->form_validation->set_rules('date', 'date', 'required|trim');
    $this->form_validation->set_rules('title', 'title', 'required|trim');
    $this->form_validation->set_rules('category', 'category', 'required|trim');
    
    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
      emplty data !</div>');
      redirect('master/ScheduleContol');
    }
    else{     
      $data = [
        'date' => $this->input->post('date'),
        'title' => $this->input->post('title'),
        'category' => $this->input->post('category')        
      ];
      print_r($data);
      $this->db->insert('schedule', $data);
      $rows = $this->db->affected_rows();
      if ($rows > 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
          Successfully added a new schedule!</div>');
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
          Failed to add data!</div>');
      }
      redirect('master/ScheduleContol');
    }
  }
  public function e_schedule()
  {

    $e_id = $this->input->post('e_id');  
    $this->form_validation->set_rules('date', 'date', 'required|trim');
    $this->form_validation->set_rules('title', 'title', 'required|trim');
    $this->form_validation->set_rules('category', 'category', 'required|trim');
    
    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
      emplty data !</div>');
      redirect('master/ScheduleContol');
    }
    else{     
      $data = [
        'date' => $this->input->post('date'),
        'title' => $this->input->post('title'),
        'category' => $this->input->post('category')        
      ];
      print_r($data);
      $this->db->update('schedule', $data, ['id' => $e_id]);
      
      $rows = $this->db->affected_rows();
      if ($rows > 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
          Successfully update a new schedule!</div>');
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
          Failed to update data!</div>');
      }
      redirect('master/ScheduleContol');
    }
  }
    /************************ department   ************************************
    public function a_dept()
    {
      // Add Department
      $d['title'] = 'Department';
      $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
      // Form Validation
      $this->form_validation->set_rules('d_id', 'Department ID', 'required|trim|exact_length[3]|alpha');
      $this->form_validation->set_rules('d_name', 'Department Name', 'required|trim');
  
      if ($this->form_validation->run() == false) {
        $this->load->view('templates/header', $d);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('master/department/a_dept', $d); // Add Department Page
        $this->load->view('templates/footer');
      } else {
        $this->_addDept();
      }
    }
    
    private function _addDept()
    {
      $data = [
        'id' => $this->input->post('d_id'),
        'name' => $this->input->post('d_name')
      ];
  
      $checkId = $this->db->get_where('department', ['id' => $data['id']])->num_rows();
      if ($checkId > 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Failed to add, ID used!</div>');
      } else {
        $this->db->insert('department', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
          Successfully added a new department!</div>');
      }
      redirect('master');
    }
  
    public function e_dept($d_id)
    {
      // Edit Department
      $d['title'] = 'Department';
      $d['d_old'] = $this->db->get_where('department', ['id' => $d_id])->row_array();
      $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
      // Form Validation
      $this->form_validation->set_rules('d_name', 'Department Name', 'required|trim');
  
      if ($this->form_validation->run() == false) {
        $this->load->view('templates/header', $d);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('master/department/e_dept', $d); // Edit Department Page
        $this->load->view('templates/footer');
      } else {
        $name = $this->input->post('d_name');
        $this->_editDept($d_id, $name);
      }
    }
    private function _editDept($d_id, $name)
    {
      $data = ['name' => $name];
      $this->db->update('department', $data, ['id' => $d_id]);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
          Successfully edited a department!</div>');
      redirect('master');
    }
    public function d_dept($d_id)
    {
      $this->db->delete('department', ['id' => $d_id]);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
          Successfully deleted a department!</div>');
      redirect('master');
    }
    //  End of department    */
    /*
    public function shift()
    {
      // Shift Data
      $d['title'] = 'Shift';
      $d['shift'] = $this->db->get('shift')->result_array();
      $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
  
      $this->load->view('templates/table_header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/shift/index', $d); // shift Page
      $this->load->view('templates/table_footer');
    }
    public function a_shift()
    {
      $generateID = $this->db->get('shift')->num_rows();
      $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
      // Add shift
      $d['title'] = 'Shift';
      $d['s_id'] = $generateID + 1;
  
      // Form Validation
      $this->form_validation->set_rules('s_start_h', 'Hour', 'required|trim');
      $this->form_validation->set_rules('s_start_m', 'Minutes', 'required|trim');
      $this->form_validation->set_rules('s_start_s', 'Seconds', 'required|trim');
      $this->form_validation->set_rules('s_end_h', 'Hour', 'required|trim');
      $this->form_validation->set_rules('s_end_m', 'Minutes', 'required|trim');
      $this->form_validation->set_rules('s_end_s', 'Seconds', 'required|trim');
  
      if ($this->form_validation->run() == false) {
        $this->load->view('templates/header', $d);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('master/shift/a_shift', $d); // Add shift Page
        $this->load->view('templates/footer');
      } else {
        $this->_addShift();
      }
    }
    private function _addShift()
    {
      // Start Time
      $sHour = $this->input->post('s_start_h');
      $sMinutes = $this->input->post('s_start_m');
      $sSeconds = $this->input->post('s_start_s');
  
      // End Time
      $eHour = $this->input->post('s_end_h');
      $eMinutes = $this->input->post('s_end_m');
      $eSeconds = $this->input->post('s_end_s');
  
      $data = [
        'start' => $sHour . ':' . $sMinutes . ':' . $sSeconds,
        'end' => $eHour . ':' . $eMinutes . ':' . $eSeconds,
      ];
  
      $this->db->insert('shift', $data);
      $affectedRow = $this->db->affected_rows();
      if ($affectedRow > 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
          Successfully added a new shift!</div>');
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Failed to add new shift!</div>');
      }
      redirect('master/shift');
    }
  
    public function e_shift($s_id)
    {
      $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
  
      $data = $this->db->get_where('shift', ['id' => $s_id])->row_array();
      $start = explode(':', $data['start']);
      $end = explode(':', $data['end']);
  
      // Edit shift
      $d['title'] = 'Shift';
      $d['s_id'] = $data['id'];
      $d['s_sh'] = $start[0];
      $d['s_sm'] = $start[1];
      $d['s_ss'] = $start[2];
      $d['s_eh'] = $end[0];
      $d['s_em'] = $end[1];
      $d['s_es'] = $end[2];
  
      // Form Validation
      $this->form_validation->set_rules('s_start_h', 'Shift Start Hour', 'required|trim');
      $this->form_validation->set_rules('s_start_m', 'Shift Start Minutes', 'required|trim');
      $this->form_validation->set_rules('s_start_s', 'Shift Start Seconds', 'required|trim');
      $this->form_validation->set_rules('s_end_h', 'Shift End Hour', 'required|trim');
      $this->form_validation->set_rules('s_end_m', 'Shift End Minutes', 'required|trim');
      $this->form_validation->set_rules('s_end_s', 'Shift End Seconds', 'required|trim');
  
      if ($this->form_validation->run() == false) {
        $this->load->view('templates/header', $d);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('master/shift/e_shift', $d); // Edit shift Page
        $this->load->view('templates/footer');
      } else {
        // Start Time
        $sHour = $this->input->post('s_start_h');
        $sMinutes = $this->input->post('s_start_m');
        $sSeconds = $this->input->post('s_start_s');
  
        // End Time
        $eHour = $this->input->post('s_end_h');
        $eMinutes = $this->input->post('s_end_m');
        $eSeconds = $this->input->post('s_end_s');
  
        $set = [
          'start' => $sHour . ':' . $sMinutes . ':' . $sSeconds,
          'end' => $eHour . ':' . $eMinutes . ':' . $eSeconds,
        ];
        $this->_editShift($s_id, $set);
      }
    }
    private function _editShift($s_id, $set)
    {
      $this->db->where('id', $s_id);
      $this->db->update('shift', $set, ['id' => $s_id]);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
          Successfully edited a shift!</div>');
      redirect('master/shift');
    }
  
    public function d_shift($s_id)
    {
      $query = 'ALTER TABLE `shift` AUTO_INCREMENT = 1';
      $this->db->delete('shift', ['id' => $s_id]);
      $this->db->query($query);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
          Successfully deleted a shift!</div>');
      redirect('master/shift');
    }
    // End of Shift */
  
}
