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
    $this->load->model('Student_model');
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
    // $d['title'] = 'Library Area Information';
    $d['title'] = 'Area';
    $d['room'] = $this->db->get('area')->result_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/area/index', $d); // Add Department Page
      $this->load->view('templates/footer');
   
  }

  // validations
  public function check_slots($max_slot)
  {
      $min_slot = $this->input->post('min_slot');

      if ($min_slot && $max_slot < $min_slot) {
          $this->form_validation->set_message('check_slots', 'The {field} must be greater than or equal to the MIN HOUR.');
          return false;
      }

      return true; // Validation passed
  }

  public function a_area()
  {
    $d['title'] = 'Area';
    $d['room'] = $this->db->get('area')->result_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    // Form Validation    
    $this->form_validation->set_rules('d_floor', 'Area floor', 'required');
    // $this->form_validation->set_rules('d_name', 'Area name', 'required');
    $this->form_validation->set_rules('d_name', 'Area name', 'required|regex_match[/^[a-zA-Z\s]+(?:\s[0-9]+)?$/]');
    $this->form_validation->set_rules('d_seat', 'Number', 'required|numeric');
    $this->form_validation->set_rules('open_time', 'OPEN TIME', 'required');
    $this->form_validation->set_rules('close_time', 'CLOSE TIME', 'required');
    $this->form_validation->set_rules('min_slot', 'MIN HOUR', 'required|numeric');
    $this->form_validation->set_rules('max_slot', 'MAX HOUR', 'required|numeric');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/area/a_area', $d); 
      $this->load->view('templates/footer');
    } else {
      if($this->input->post('min_slot') > $this->input->post('max_slot')){
        $this->session->set_flashdata('warning', 'The minimum hour cannot be greater than the maximum hour.');
        echo "<script>window.history.back();</script>";
        exit;
      }
      $data = [        
        'floor' => $this->input->post('d_floor'),
        'room' => $this->input->post('d_name'),
        'slotnumber' => $this->input->post('d_seat'),
        'opentime' => $this->input->post('open_time'),
        'closetime' => $this->input->post('close_time'),
        'min_slot' => $this->input->post('min_slot'),
        'max_slot' => $this->input->post('max_slot'),
        'availability' => 1 //means avaiable always cuz why add if not
      ];

      $this->db->insert('area', $data);
      $rows = $this->db->affected_rows();
      if ($rows > 0) {
        $this->session->set_flashdata('area_scs', 'Area has been Added Successfully!');
      }  else {
        $this->session->set_flashdata('area_err', 'Failed to add an Area!');
      }

      // $this->notifications('add area', $data);
      // $this->load->model('Notif_model');
      // $this->Notif_model->notifications('add area', $data);
      
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
    // $this->form_validation->set_rules('d_floor', 'Area floor', 'required');
    // $this->form_validation->set_rules('d_name', 'Area name', 'required');
    // $this->form_validation->set_rules('d_seat', 'Number', 'required');
    // $this->form_validation->set_rules('open_time', 'OPEN TIME', 'required');
    // $this->form_validation->set_rules('close_time', 'CLOSE TIME', 'required');
    // $this->form_validation->set_rules('min_slot', 'MIN HOUR', 'required');
    // $this->form_validation->set_rules('max_slot', 'MAX HOUR', 'required');
    $this->form_validation->set_rules('d_floor', 'Area floor', 'required');
    // $this->form_validation->set_rules('d_name', 'Area name', 'required');
    $this->form_validation->set_rules('d_name', 'Area name', 'required|regex_match[/^[a-zA-Z\s]+(?:\s[0-9]+)?$/]');
    $this->form_validation->set_rules('d_seat', 'Number', 'required|numeric');
    $this->form_validation->set_rules('open_time', 'OPEN TIME', 'required');
    $this->form_validation->set_rules('close_time', 'CLOSE TIME', 'required');
    $this->form_validation->set_rules('min_slot', 'MIN HOUR', 'required|numeric|greater_than[0]|less_than[3]');
    $this->form_validation->set_rules('max_slot', 'MAX HOUR', 'required|numeric|greater_than_equal_to[1]|less_than_equal_to[8]|callback_check_slots');


    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/area/e_area', $d); // Edit Area Page
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
        // Initialize the needed variables.
        $seat_number = $this->input->post('d_seat');
        $area_floor = $this->input->post('d_floor');
        $area_name = $this->input->post('d_name');
        $old_seat_number = $d['d_old']['slotnumber'];

        //since we need the status as well, get the open time and close time of the area
        $open_time = $this->input->post('open_time');
        $close_time = $this->input->post('close_time');
        //generate the time range from open time to close time
        $start_hour = (int)date('H', strtotime($open_time)); // 8
        $end_hour = (int)date('H', strtotime($close_time)); // 17
        
        // Create the range of hours
        $hour_ranges = [];
        $hour_blocks = [];
        
        // Generate the hourly ranges and fill the array with zeros
        for ($i = $start_hour; $i < $end_hour; $i++) {
            $hour_ranges[] = "$i-" . ($i + 1); // Example: "8-9", "9-10"
            $hour_blocks[] = 0;                // Add 0 for each hour block
        }
        

        //convert hourblocks to string.
        $hour_blocks_string = '[' . implode(',', $hour_blocks) . ']';
        // echo "<br>";
        // echo $hour_blocks_string;
        // echo "<br>";


        date_default_timezone_set('Asia/Manila');
        $current_date = date('Y-m-d');
        
        // Fetch the minimum date greater than or equal to the current date
        $min_date_query = $this->db->select_min('date')
            ->from('slot')
            ->where('Floor', $area_floor)
            ->where('Room', $area_name)
            ->where('date >=', $current_date)
            ->get();
        $min_date = $min_date_query->row()->date ?? null; // Handle null if no result
        
        // Fetch the maximum date greater than or equal to the current date
        $max_date_query = $this->db->select_max('date')
            ->from('slot')
            ->where('Floor', $area_floor)
            ->where('Room', $area_name)
            ->where('date >=', $current_date)
            ->get();
        $max_date = $max_date_query->row()->date ?? null; // Handle null if no result

        // Ensure min_date and max_date are valid
        if ($min_date && $max_date) {
            // Fetch all distinct dates in the range
            $dates_query = $this->db->select('DISTINCT date', false) // Use DISTINCT for unique values
            ->from('slot')
            ->where('Floor', $area_floor)
            ->where('Room', $area_name)
            ->where('date >=', $min_date)
            ->where('date <=', $max_date)
            ->order_by('date', 'ASC')
            ->get();
          $dates = $dates_query->result_array();
        
            // Iterate over each date
            foreach ($dates as $date_row) {
                $current_loop_date = $date_row['date'];
        
                // If old_seat_number > new_seat_number, delete records
                if ($old_seat_number > $seat_number) {
                    for ($i = $seat_number + 1; $i <= $old_seat_number; $i++) {
                        $this->db->where('date', $current_loop_date)
                            ->where('Slot', $i)
                            ->where('Floor', $area_floor)
                            ->where('Room', $area_name)
                            ->delete('slot');
                    }
                }
        
                // If old_seat_number < new_seat_number, add records
                elseif ($old_seat_number < $seat_number) {
                  for ($i = $old_seat_number + 1; $i <= $seat_number; $i++) {
                    $query = "
                    INSERT INTO slot (`date`, `Slot`, `Floor`, `status`, `Room`)
                    VALUES ('" . $current_loop_date . "', " . $i . ", '" . $area_floor . "', '" . $hour_blocks_string . "', '" . $area_name . "')
                    ";
                    $this->db->query($query);
                  }
                }
              
              
            }
        }

      $this->db->update('area', $data, ['id' => $d_id]);
      $rows = $this->db->affected_rows();
      if ($rows > 0) {
        $this->session->set_flashdata('area_scs', 'Area has been Edited Successfully!');
      }elseif ($rows == 0) {
        $this->session->set_flashdata('area_neutral', 'No changes were made.');
      }else {
        $this->session->set_flashdata('area_fail', 'Failed to Edit an Area!');
      }

      redirect('master/area');
    }
  }
  
  public function d_area($d_id)
  {
    $this->db->delete('area', ['id' => $d_id]);
    $rows = $this->db->affected_rows();
    if ($rows > 0) {
      $this->session->set_flashdata('area_scs', 'Area has been Deleted Successfully!');
    } else {
      $this->session->set_flashdata('area_fail', 'Failed to Delete an Area!');
    }
    redirect('master/area');
  }
  /*************************************   Room  *********************************************/
  public function room()
  {    
    // $d['title'] = 'Library Room Information';
    $d['title'] = 'Room';
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
    // Add Departments
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
        $this->session->set_flashdata('room_scs', 'Room has been added Successfully.');
      } else {
        $this->session->set_flashdata('room_fail', 'Failed to add Room. Please try again.');
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
      $rows = $this->db->affected_rows();
      if ($rows > 0) {
        $this->session->set_flashdata('room_scs', 'Room has been Updated Successfully!');
      } else {
        $this->session->set_flashdata('room_fail', 'Failed to Update Room. Please try again.');
      }
      // $this->session->set_flashdata('room_scs', 'Room has been Updated Successfully!');
      redirect('master/room');
    }
    
  }
  
  public function d_room($d_id)
  {
    $this->db->delete('room', ['id' => $d_id]);
    $rows = $this->db->affected_rows();
    if ($rows > 0) {
      $this->session->set_flashdata('room_scs', 'Room has been deleted Successfully!');
    } else {
      $this->session->set_flashdata('room_fail', 'Failed to delete Room. Please try again.');
    }
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

    $this->form_validation->set_rules('f_name', 'first name', 'required|trim|regex_match[/^[a-zA-Z ]+$/]');
    $this->form_validation->set_rules('m_name', 'middle name', 'trim|alpha');
    $this->form_validation->set_rules('l_name', 'last name', 'required|trim|regex_match[/^[a-zA-Z ]+$/]');
    $this->form_validation->set_rules('srcode', 'Student ID ', 'required|trim|is_unique[student.srcode] ', [
      'is_unique' => 'This Student ID already exists. Please try again.'
    ]);
    // $this->form_validation->set_rules('rfid', 'RF id', 'required|trim');
    // $this->form_validation->set_rules('qrcode', 'QR code', 'required|trim');
    // $this->form_validation->set_rules('pin', 'PIN', 'required|trim|numeric|is_unique[student.pin]', [
    //   'is_unique' => 'This PIN already exists. Please try again.'
    // ]);
    $this->form_validation->set_rules('year', 'Year', 'required|trim');
    $this->form_validation->set_rules('course', 'course', 'required|trim');
    $this->form_validation->set_rules('college', 'college', 'required|trim');
    //for birthdate
    $this->form_validation->set_rules('birthdate', 'birthdate', 'required');

    $pin = date('mdY', strtotime($this->input->post('birthdate')));
    
    // Assign the calculated PIN to the input value for validation
    $this->form_validation->set_value('pin', $pin);

    // Set the 'pin' as the field to validate
    $this->form_validation->set_rules('pin', 'PIN', 'is_unique[student.pin]', [
      'is_unique' => 'This PIN already exists. Please try again.'
    ]);


    
    if ($this->form_validation->run() == false) {
      $error = validation_errors();

      $this->session->set_flashdata('student_validation', $error);
      // $this->session->set_flashdata('student_fail', 'Failed to add Student. Please try again.');
      redirect('master/student/a_student');
    }
  
    else{
      $data = [
        'first_name' => $this->input->post('f_name'),
        'middle_name' => (empty($this->input->post('m_name')) ? "" : $this->input->post('m_name')),
        'last_name' => $this->input->post('l_name'),
        'srcode' => $this->input->post('srcode'),
        'gender' => $this->input->post('e_gender'),
        // 'qrcode' => $this->input->post('qrcode'),
        'email' => $this->input->post('email'),
        // 'rfid' => $this->input->post('rfid'),
        'pin' => $pin,
        'schoolyear' => $this->input->post('year'),
        'course' => $this->input->post('course'),
        'college' => $this->input->post('college'),
        'birthdate' => date('Y-m-d', strtotime($this->input->post('birthdate'))),
        // 'password' => $this->input->post('srcode') . $this->input->post('l_name')
      ];
      print_r($data);
      $this->db->insert('student', $data);
      $rows = $this->db->affected_rows();
      if ($rows > 0) {
        $this->session->set_flashdata('student_scs', 'Student has been Added Successfully!');
      } else {
        $this->session->set_flashdata('student_fail', 'Failed to add Student. Please try again.');
      }

      //send to notification function
      $this->load->model('Notif_model');
      $this->Notif_model->notifications('add student', $data);

      redirect('master/student');
    }
  }
  public function edit_student()
  {
    $this->form_validation->set_rules('f_name', 'first name', 'required|trim|regex_match[/^[a-zA-Z ]+$/]');
    $this->form_validation->set_rules('m_name','middle name', 'trim|regex_match[/^[a-zA-Z ]+$/]');
    $this->form_validation->set_rules('l_name', 'last name', 'required|trim|regex_match[/^[a-zA-Z ]+$/]');
    $this->form_validation->set_rules('srcode', 'sr code ', 'required|trim');
    $this->form_validation->set_rules('birthdate', 'birthdate', 'required');
    // $this->form_validation->set_rules('qrcode', 'QR code', 'required|trim');
    // $this->form_validation->set_rules('pin', 'PIN', 'required|trim|numeric');
    // $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
    // $this->form_validation->set_rules('rfid', 'RF id', 'required|trim');
    $this->form_validation->set_rules('year', 'Year', 'required|trim');
    $this->form_validation->set_rules('course', 'course', 'required|trim');
    $this->form_validation->set_rules('college', 'college', 'required|trim');

    $pin = date('mdY', strtotime($this->input->post('birthdate')));

    if ($this->form_validation->run() == false) {
      $errors = validation_errors();
      $this->session->set_flashdata('student_validation', $errors);
      // $this->session->set_flashdata('student_fail', 'Failed to Update Student. Please try again.');
      redirect('master/student/e_student');
    }
    else{
        $e_id = $this->input->post('e_id');   
        $data = [
            'first_name' => $this->input->post('f_name'),
            'middle_name' => (empty($this->input->post('m_name')) ? "" : $this->input->post('m_name')),
            'last_name' => $this->input->post('l_name'),
            'srcode' => $this->input->post('srcode'),
            'gender' => $this->input->post('e_gender'),
            // 'qrcode' => $this->input->post('qrcode'),
            // email
            'email' => $this->input->post('email'),
            // rfid
            // 'rfid' => $this->input->post('rfid'),
            'pin' => $pin,
            'schoolyear' => $this->input->post('year'),
            'course' => $this->input->post('course'),
            'college' => $this->input->post('college'),
            'birthdate' => date('Y-m-d', strtotime($this->input->post('birthdate'))),

        ];
    
        $this->db->update('student', $data, ['id' => $e_id]);
        $rows = $this->db->affected_rows();
        
        if ($rows > 0) {
            $this->session->set_flashdata('student_scs', 'Student has been Updated Successfully!');
        } elseif ($rows === 0) {
          //no changes
            $this->session->set_flashdata('student_neutral', 'No changes has been made.');
        } else {
            $this->session->set_flashdata('student_fail', 'Failed to Update Student. Please try again.');
        }
        redirect('master/student');
      }
  }
  


  public function a_student()
  {
    $d['title'] = 'Student';
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);   
    
    $this->load->view('templates/header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/student/a_student', $d);
    $this->load->view('templates/footer');
  }

  

  public function e_student($e_id)
  {
    $d['title'] = 'Student';
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);   
    $d['student'] = $this->db->get_where('student', ['id' => $e_id])->row_array();
    
    $this->form_validation->set_rules('f_name', 'first name', 'required|trim|regex_match[/^[a-zA-Z ]+$/]');
    $this->form_validation->set_rules('m_name','middle name', 'required|trim|regex_match[/^[a-zA-Z ]+$/]');
    $this->form_validation->set_rules('l_name', 'last name', 'required|trim|regex_match[/^[a-zA-Z ]+$/]');
    $this->form_validation->set_rules('srcode', 'Student ID ', 'required|trim|numeric');
    $this->form_validation->set_rules('qrcode', 'QR code', 'required|trim');
    // $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
    $this->form_validation->set_rules('rfid', 'RF id', 'required|trim');
    $this->form_validation->set_rules('year', 'Year', 'required|trim');
    $this->form_validation->set_rules('course', 'course', 'required|trim');
    $this->form_validation->set_rules('college', 'college', 'required|trim');
    

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
        $this->session->set_flashdata('student_scs', 'Student has been Updated Successfully!');
        redirect('master/student');
      } 
      else{
        $this->session->set_flashdata('student_fail', 'Failed to Update Student. Please try again.');
        redirect('master/student');
      } 
      
    }
  }
  
  public function d_student($e_id)
  {
    $this->db->delete('student', ['id' => $e_id]);
    $rows = $this->db->affected_rows();
    if ($rows > 0) {
      $this->session->set_flashdata('student_scs', 'Student has been Deleted Successfully!');
    } else {
      $this->session->set_flashdata('student_fail', 'Failed to delete Student. Please try again.');
    }
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
    $d['title'] = 'Librarian';          
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $this->form_validation->set_rules('u_username', 'Username', 'required|trim|min_length[6]');
    $this->form_validation->set_rules('u_fname', 'First name', 'required|trim|regex_match[/^[a-zA-Z ]+$/]');
    $this->form_validation->set_rules('u_lname', 'Last name', 'required|trim|regex_match[/^[a-zA-Z ]+$/]');
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
        $this->session->set_flashdata('users_fail', "Password do not match.");
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
      $this->session->set_flashdata('users_scs', 'Successfully Added New Librarian!');
    } else {
      $this->session->set_flashdata('users_fail', 'Failed to Add New Librarian!');
    }
    $this->load->model('Notif_model');
    $this->Notif_model->notifications('add users', $data);
    redirect('master/users');
  }

  public function e_users($id)
  {
    // $d['title'] = 'Update Librarian';
    $d['title'] = 'Librarian';

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
    // $d['title'] = 'Librarian Access Setup';
    $d['title'] = 'Librarian';

    $id = $this->input->post('u_id');
    $users = $this->db->get_where('users', ['id' => $id])->row_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    $d['user_menu']= $user_menu = $this->db->get_where('user_submenu')->result_array();   
    
    $menucount= sizeof($d['user_menu']);    
    $permission= json_decode($users['permision'], true); 


    $this->form_validation->set_rules('u_username', 'Username', 'required|trim|min_length[6]');
    $this->form_validation->set_rules('u_fname', 'First name', 'required|trim|regex_match[/^[a-zA-Z ]+$/]');
    $this->form_validation->set_rules('u_lname', 'Last name', 'required|trim|regex_match[/^[a-zA-Z ]+$/]');
    // $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');
    $this->form_validation->set_rules('u_floor', 'Floor', 'required');


    if ($this->form_validation->run() == false) {
      $error = validation_errors();
      $this->session->set_flashdata('users_validation', $error);
      // $this->session->set_flashdata('users_fail', 'Failed to add Student. Please try again.');
      redirect('master/users');
    }

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
      $this->session->set_flashdata('users_scs', 'Successfully edited an account.');
      // echo ("success");
    } 
    // else if(  $rows == 0) {
    //   $this->session->set_flashdata('users_neutral', 'No changes were made.');
    // }
    else {
      $this->session->set_flashdata('users_fail', 'Failed to edit account.');
      // echo ("fail to update");
    }
    redirect('master/users'); 
    
  }
  private function _editUsers($data, $id)
  {    
    $this->db->update('users', $data, ['id' => $id]);
    $rows = $this->db->affected_rows();
    if ($rows > 0) {
      $this->session->set_flashdata('users_scs', 'Successfully edited an account!');
    
    }
    else if($rows == 0) {
      $this->session->set_flashdata('users_neutral', 'No changes were made!');
    }
    else {
      $this->session->set_flashdata('users_fail', 'Failed to edit an account!');
    }
    redirect('master/users');
  }

  public function d_users($id)
  {
    $this->db->delete('users', ['id' => $id]);
    $rows = $this->db->affected_rows();
    if ($rows > 0) {
      $this->session->set_flashdata('users_scs', 'Successfully deleted an account!');
    } else {
      $this->session->set_flashdata('users_fail', 'Failed to delete account!');
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
    
    $this->form_validation->set_rules('f_name', 'first name', 'required|trim|regex_match[/^[a-zA-Z ]+$/]');
    $this->form_validation->set_rules('m_name','middle name', 'required|trim|regex_match[/^[a-zA-Z ]+$/]');
    $this->form_validation->set_rules('l_name', 'last name', 'required|trim|regex_match[/^[a-zA-Z ]+$/]');
    // Faculty ID not sure yet if this should accept letters and special chars
    $this->form_validation->set_rules('srcode', 'Faculty ID ', 'required|trim|is_unique[faculty.srcode]');
    $this->form_validation->set_rules('pin', 'PIN', 'required|trim|numeric');
    // $this->form_validation->set_rules('qrcode', 'QR code', 'required|trim|numeric');
    // $this->form_validation->set_rules('qrcode', 'QR code', 'required|trim|numeric');

    $this->form_validation->set_rules('course', 'course', 'required|trim');
    $this->form_validation->set_rules('e_gender', 'gender', 'required|trim');

    if ($this->form_validation->run() == false) {
        $errors = validation_errors();

        // Set errors in flashdata
        $this->session->set_flashdata('faculty_fail', $errors);
        redirect('master/faculty/a_faculty/'.$e_id);
      // $this->session->set_flashdata('faculty_fail', 'Please fill out the form correctly!');
      // redirect('master/faculty');
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
        $this->session->set_flashdata('faculty_scs', "Successfully added a faculty!");
      } else {
        $this->session->set_flashdata('faculty_fail', "Failed to add a faculty!");
      }
      $this->load->model('Notif_model');
      $this->Notif_model->notifications('add faculty', $data);
      redirect('master/faculty');
    }
  }
  public function e_faculty($e_id)
  {
    $d['title'] = 'Faculty';
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);   
    $d['employee'] = $this->db->get_where('faculty', ['id' => $e_id])->row_array();
    

    $this->load->view('templates/header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/faculty/e_faculty', $d); 
    $this->load->view('templates/footer');

  }
  
  public function edit_faculty()
  {
    $this->form_validation->set_rules('f_name', 'first name', 'required|trim|regex_match[/^[a-zA-Z ]+$/]');
    $this->form_validation->set_rules('m_name','middle name', 'required|trim|regex_match[/^[a-zA-Z ]+$/]');
    $this->form_validation->set_rules('l_name', 'last name', 'required|trim|regex_match[/^[a-zA-Z ]+$/]');
    $this->form_validation->set_rules('srcode', 'sr code ', 'required|trim');
    // $this->form_validation->set_rules('rfid', 'RF id', 'required|trim');
    // $this->form_validation->set_rules('qrcode', 'QR code', 'required|trim');
    $this->form_validation->set_rules('pin', 'PIN', 'required|trim|numeric');
    // $this->form_validation->set_rules('course', 'course', 'required|trim');
    $this->form_validation->set_rules('college', 'college', 'required|trim');
    $this->form_validation->set_rules('e_gender', 'gender', 'required|trim');
    

    if ($this->form_validation->run() == false) {
       // Retrieve all validation errors
        $errors = validation_errors();

        // Set errors in flashdata
        $this->session->set_flashdata('faculty_fail', $errors);
        redirect('master/faculty/e_faculty/'.$e_id);

      // $this->session->set_flashdata('faculty_fail', 'Please fill out the form correctly!');
      // redirect('master/faculty');
    }else{
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
        $this->session->set_flashdata('faculty_scs', "Successfully updated a faculty!");
      }
      else if ($rows == 0) {
        $this->session->set_flashdata('faculty_neutral', "No changes were made to a faculty!");
      }
      else {
        $this->session->set_flashdata('faculty_fail', "Failed to update a faculty!");
      }

      redirect('master/faculty');
    }

  }


  public function d_faculty($e_id)
  {
    $this->db->delete('faculty', ['id' => $e_id]);
    $rows = $this->db->affected_rows();
    if ($rows > 0) {
      $this->session->set_flashdata('faculty_scs', "Successfully deleted a faculty!");
      } else {
        $this->session->set_flashdata('faculty_fail', "Failed to delete a faculty!");
    }
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


  /**************************** notifications ***************************************/
public function notifications($type, $data){
  date_default_timezone_set('Asia/Manila');

  if ($type === 'add student'){
    $notificationData = [
      'message' => 'Student ' . $data['srcode'] . ' was added to the database.', 
      'type'    => $type ,
      'status'  => 'unread',
      'created_at' => date('Y-m-d H:i:s'),
      'url' => 'master/student',
    ];
  }

  if ($type === 'add area'){
    $notificationData = [
      'message' => 'Area ' . $data['room']. ' on floor ' . $data['floor'] .' was added to the database.', 
      'type'    => $type,
      'status'  => 'unread',
      'created_at' => date('Y-m-d H:i:s'),
      'url' => 'master/area',
    ];
  }

  if($type === 'add faculty'){
    $notificationData = [
      'message' => 'Faculty ' . $data['first_name']. ' ' . $data['last_name'] . ' was added to the database.', 
      'type'    => $type,
      'status'  => 'unread',
      'created_at' => date('Y-m-d H:i:s'),
      'url' => 'master/faculty',
    ];
  }

  if($type === 'add users'){
    $notificationData = [
      'message' => 'Librarian ' . $data['f_name']. ' ' . $data['l_name'] . ' was added to the database.', 
      'type'    => $type,
      'status'  => 'unread',
      'created_at' => date('Y-m-d H:i:s'),
      'url' => 'master/users',
    ];
  }

  if($type === 'stud_timein'){
    $notificationData = [
      'message' => 'Student '. $data['srcode'].'has checked in at kisok '. $data['kiosk'], 
      'type'    => $type,
      'status'  => 'unread',
      'created_at' => date('Y-m-d H:i:s'),
      'url' => 'attendance',
    ]; 
  }
  
  $this->db->insert('notifications', $notificationData);
}
public function getNotifications() {
  // Fetch all notifications, regardless of status
  $this->db->order_by('created_at', 'DESC');
  $notifications = $this->db->get('notifications')->result_array(); // Fetch as array
  //put it in session
  echo json_encode($notifications);
  exit;
}
public function getUnreadNotifications() {
  $this->db->where('status', 'unread');
  $this->db->order_by('created_at', 'DESC');
  $this->db->limit(99);
  
  $notifications = $this->db->get('notifications')->result_array(); // Fetch as array
  echo json_encode($notifications);
  exit;
}

public function markAsRead() {
  $notificationId = $this->input->post('id'); // Get the notification ID from the request

  if ($notificationId) {
      // Update the notification's status to 'read' in the database
      $this->db->where('id', $notificationId);
      $this->db->update('notifications', ['status' => 'read']);

      // Optionally, send a success response
      echo json_encode(['status' => 'success']);
  } else {
      // Handle error if no ID is provided
      echo json_encode(['status' => 'error']);
  }
}
public function markAllAsRead() {
  $data = ['status' => 'read'];
  $this->db->where('status', 'unread');  // Only mark unread notifications
  $result = $this->db->update('notifications', $data);

  if ($result) {
    // Optionally, send a success response
    echo json_encode(['status' => 'success']);
  } else {
    echo json_encode(['status' => 'error']);
  }
}
// public function markAllAsRead() {
//   // Update notifications where the status is 'unread'
//   $data = ['status' => 'read'];
//   $this->db->where('status', 'unread');
//   $result = $this->db->update('notifications', $data);

//   if ($result) {
//       // Fetch updated notifications to return
//       $this->db->order_by('created_at', 'desc');  // Optionally order them
//       $notifications = $this->db->get('notifications')->result_array(); // Fetch all notifications
      
//       // Return the updated list of notifications as JSON
//       echo json_encode($notifications);
//   } else {
//       echo json_encode(['status' => 'error']);
//   }
// }


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


    
  public function cancelBooking(){
    date_default_timezone_set('Asia/Manila');
    $book_id = $this->input->get('book_id');
    $start_time = $this->input->get('start');
    $end_time = $this->input->get('end');

    $start_time_format = date('H:i', strtotime($start_time));
    $end_time_format = date('H:i', strtotime($end_time));
    // print_r($end_time_format);
    $data  =$this->db->get_where('booking', ['id' => $book_id])->row_array();
    // echo "<pre>";
    //   print_r($data);
    // echo "<pre>";
    $data_date_format = date('Y-m-d', strtotime(trim($data['date'])));
    $current_date_format = date('Y-m-d', strtotime(trim($current_date)));
    if(!$data){
      $this->session->set_flashdata('error', 'No booking data found.');
      redirect('report/attend_seat');
    }
    else{
        //check the current date
        $current_date = date('Y-m-d');
        //get the current time.
        $current_time = date('H:i:s');
        //compare the current date 
        if($data['date'] < $current_date){
          $this->db->where('id', $book_id);
          $this->db->update('booking', [
            'in_status' => 'cancelled',
            'out_status' => 'cancelled', 
            // 'in_status' => 'occupied',
            // 'out_status' => 'exit',
            'in_time' => $start_time_format, 
            'out_time' => $end_time_format]);
          $this->session->set_flashdata('success', 'Booking Succesfully Cancelled.');
          redirect('report/attend_seat');
        }
        else if ($data['date'] > $current_date){
          $area_info_floor = $data['floor'];
          $area_info_room = $data['room'];
          $area_info_seat = $data['slot_id'];
          $area_info_date =  $data['date'];
          $area_details = $this->db->get_where('area', array('Floor' => $area_info_floor, 'Room' => $area_info_room))->row_array();

          if (!$area_details) {
            $this->session->set_flashdata('error', 'Area not found.');
            redirect('report/attend_seat');
          }

          //compare the three to get the data from the slot table
          $slots_data = $this->db->get_where('slot', [
              'Floor' => $area_info_floor,
              'Room' => $area_info_room,
              'Slot' => $area_info_seat,
              'date' => $area_info_date
          ])->row_array();
          
          $data_date = date('Y-m-d', strtotime(trim($data['date'])));
          $slots_date = date('Y-m-d', strtotime(trim($slots_data['date'])));
          
            if ($data_date === $slots_date) {
              $open_time = strtotime($area_details['opentime']);
              $close_time = strtotime($area_details['closetime']);
              echo "Open Time: " . $open_time . "<br>";
              echo "Close Time: ". $close_time;
              $times = array();

              // Generate the time slots
                $counter = 0; // Initialize counter
                for ($time = $open_time; $time <= $close_time; $time = strtotime('+1 hour', $time)) {
                  $times[$counter] = date('H:i', $time);
                  // echo $times[$counter];
                  $counter++;
                }

                if (!is_array($slots_data['status'])) {
                  $slots_data['status'] = explode(',', trim($slots_data['status'], '[]')); // Clean up potential extra brackets
                }

              $start_index = array_search($start_time_format, $times);
              $end_index = array_search($end_time_format, $times);

                if ($start_index !== false && $end_index !== false) {
                    // Loop through the indices to mark the slots as available (0)
                  for ($i = $start_index; $i < $end_index; $i++) {
                      if (isset($slots_data['status'][$i])) {
                          if ($slots_data['status'][$i] == 1) {
                              $slots_data['status'][$i] = 0;
                              echo "Index $i updated to 0<br>";
                          } else {
                              echo "Index $i was not updated (value: " . $slots_data['status'][$i] . ")<br>";
                          }
                      } else {
                          echo "Index $i does not exist in slots_data['status']<br>";
                      }
                  }

                    // Update the slots in the database
                    $this->db->where('Floor', $area_info_floor);
                    $this->db->where('Room', $area_info_room);
                    $this->db->where('Slot', $area_info_seat);
                    $this->db->where('date', $area_info_date);

                    // echo "<br>";
                    // echo $area_info_floor;
                    // echo "<br>";
                    // echo $area_info_room;
                    // echo "<br>";
                    // echo $area_info_date;
                    // echo "<br>";
                    // echo $area_info_seat;
                    // echo "<br>";
                    // echo "After: " ;
                    // print_r($slots_data['status']);
                    // echo "<br>";

                    // Convert the array back to the string format
                    $updated_slots = implode(',', $slots_data['status']);
                    // To ensure the format is [0,0,0,0,0,0,0,0,1,0,0], wrap the result with square brackets
                    $updated_slots = '[' . $updated_slots . ']';
                    // Print the updated string
                    echo "Updated Slots: " . $updated_slots;
                    $this->db->update('slot', ['status' => $updated_slots]);
                    $this->db->where('id', $book_id);
                    $this->db->update('booking', [
                      'in_status' => 'cancelled',
                      'out_status' => 'cancelled', 
                      // 'in_status' => 'occupied',
                      // 'out_status' => 'exit',
                      'in_time' => $start_time_format, 
                      'out_time' => $end_time_format]);
                    $this->session->set_flashdata('success', 'Booking Successfully Cancelled.');
                    redirect('report/attend_seat');
                }
              else {
                $this->session->set_flashdata('error', 'Invalid time range.');
                redirect('report/attend_seat');
              }
            }else{
              $this->session->set_flashdata('error', 'Error while canceling booking.');
              redirect('report/attend_seat');
            }
        }
        else{
          $start_time_obj = DateTime::createFromFormat('H:i', $start_time);
          $current_time_obj = DateTime::createFromFormat('H:i:s', $current_time);

          if ($start_time_obj > $current_time_obj) {
            $area_info_floor = $data['floor'];
            $area_info_room = $data['room'];
            $area_info_seat = $data['slot_id'];
            $area_info_date =  $data['date'];
            $area_details = $this->db->get_where('area', array('Floor' => $area_info_floor, 'Room' => $area_info_room))->row_array();
  
            if (!$area_details) {
              $this->session->set_flashdata('error', 'Area not found.');
              redirect('report/attend_seat');
            }
  
            //compare the three to get the data from the slot table
            $slots_data = $this->db->get_where('slot', [
                'Floor' => $area_info_floor,
                'Room' => $area_info_room,
                'Slot' => $area_info_seat,
                'date' => $area_info_date
            ])->row_array();
            
            $data_date = date('Y-m-d', strtotime(trim($data['date'])));
            $slots_date = date('Y-m-d', strtotime(trim($slots_data['date'])));
            
              if ($data_date === $slots_date) {
                $open_time = strtotime($area_details['opentime']);
                $close_time = strtotime($area_details['closetime']);
                echo "Open Time: " . $open_time . "<br>";
                echo "Close Time: ". $close_time;
                $times = array();
  
                // Generate the time slots
                  $counter = 0; // Initialize counter
                  for ($time = $open_time; $time <= $close_time; $time = strtotime('+1 hour', $time)) {
                    $times[$counter] = date('H:i', $time);
                    // echo $times[$counter];
                    $counter++;
                  }
  
                  if (!is_array($slots_data['status'])) {
                    $slots_data['status'] = explode(',', trim($slots_data['status'], '[]')); // Clean up potential extra brackets
                  }
  
                $start_index = array_search($start_time_format, $times);
                $end_index = array_search($end_time_format, $times);
  
                  if ($start_index !== false && $end_index !== false) {
                      // Loop through the indices to mark the slots as available (0)
                    for ($i = $start_index; $i < $end_index; $i++) {
                        if (isset($slots_data['status'][$i])) {
                            if ($slots_data['status'][$i] == 1) {
                                $slots_data['status'][$i] = 0;
                                echo "Index $i updated to 0<br>";
                            } else {
                                echo "Index $i was not updated (value: " . $slots_data['status'][$i] . ")<br>";
                            }
                        } else {
                            echo "Index $i does not exist in slots_data['status']<br>";
                        }
                    }
  
                      // Update the slots in the database
                      $this->db->where('Floor', $area_info_floor);
                      $this->db->where('Room', $area_info_room);
                      $this->db->where('Slot', $area_info_seat);
                      $this->db->where('date', $area_info_date);
  
                      // echo "<br>";
                      // echo $area_info_floor;
                      // echo "<br>";
                      // echo $area_info_room;
                      // echo "<br>";
                      // echo $area_info_date;
                      // echo "<br>";
                      // echo $area_info_seat;
                      // echo "<br>";
                      // echo "After: " ;
                      // print_r($slots_data['status']);
                      // echo "<br>";
  
                      // Convert the array back to the string format
                      $updated_slots = implode(',', $slots_data['status']);
                      // To ensure the format is [0,0,0,0,0,0,0,0,1,0,0], wrap the result with square brackets
                      $updated_slots = '[' . $updated_slots . ']';
                      // Print the updated string
                      echo "Updated Slots: " . $updated_slots;
                      $this->db->update('slot', ['status' => $updated_slots]);
                      $this->db->where('id', $book_id);
                      $this->db->update('booking', [
                        'in_status' => 'cancelled',
                        'out_status' => 'cancelled', 
                        // 'in_status' => 'occupied',
                        // 'out_status' => 'exit',
                        'in_time' => $start_time_format, 
                        'out_time' => $end_time_format]);
                      $this->session->set_flashdata('success', 'Booking Successfully Cancelled.');
                      redirect('report/attend_seat');
                  }
                else {
                  $this->session->set_flashdata('error', 'Invalid time range.');
                  redirect('report/attend_seat');
                }
              }else{
                $this->session->set_flashdata('error', 'Error while canceling booking.');
                redirect('report/attend_seat');
              }
          }else{
            $this->db->where('id', $book_id);
            $this->db->update('booking', [
              'in_status' => 'cancelled',
              'out_status' => 'cancelled',
              // 'in_status' => 'occupied',
              // 'out_status' => 'exit',
              'in_time' => $start_time_format, 
              'out_time' => $end_time_format]);
            $this->session->set_flashdata('success', 'Booking Succesfully Cancelled.');
            redirect('report/attend_seat');
          }
          $this->session->set_flashdata('error', 'Error while canceling booking.');
          redirect('report/attend_seat');
        }
    }
  }

  public function timeoutForce(){
    date_default_timezone_set('Asia/Manila');
    $book_id = $this->input->get('book_id');
    // $start_time = $this->input->get('start');
    $end_time = $this->input->get('end');

    // $start_time_format = date('H:i', strtotime($start_time));
    $end_time_format = date('H:i', strtotime($end_time));

    $data  =$this->db->get_where('booking', ['id' => $book_id])->row_array();
    if(!$data){
      $this->session->set_flashdata('error', 'No booking data found.');
      redirect('report/attend_seat');
    }
    else{
      //get the current time
      $current_time = date('H:i:s');
      $current_time_format = date('H:i', strtotime($current_time));
      //if the current_time < end_time

      $end_time = new DateTime($end_time_format);
      $current_time = new DateTime($current_time_format);
      // Output the values for debugging
      echo $end_time_format;
      echo "<br>";
      echo $current_time_format;

      // Compare the two times
      if ($current_time < $end_time) {
        $area_info_floor = $data['floor'];
        $area_info_room = $data['room'];
        $area_info_seat = $data['slot_id'];
        $area_info_date =  $data['date'];
        $area_details = $this->db->get_where('area', array('Floor' => $area_info_floor, 'Room' => $area_info_room))->row_array();

        if (!$area_details) {
          $this->session->set_flashdata('error', 'Area not found.');
          redirect('report/attend_seat');
        }
        //compare the three to get the data from the slot table
        $slots_data = $this->db->get_where('slot', [
            'Floor' => $area_info_floor,
            'Room' => $area_info_room,
            'Slot' => $area_info_seat,
            'date' => $area_info_date
        ])->row_array();
        
        $data_date = date('Y-m-d', strtotime(trim($data['date'])));
        $slots_date = date('Y-m-d', strtotime(trim($slots_data['date'])));
        if ($data_date === $slots_date) {
          $open_time = strtotime($area_details['opentime']);
          $close_time = strtotime($area_details['closetime']);
          echo "Open Time: " . $open_time . "<br>";
          echo "Close Time: ". $close_time;
          $times = array();

          // Generate the time slots
            $counter = 0; // Initialize counter
            for ($time = $open_time; $time <= $close_time; $time = strtotime('+1 hour', $time)) {
              $times[$counter] = date('H:i', $time);
              // echo $times[$counter];
              $counter++;
            }

              if (!is_array($slots_data['status'])) {
                $slots_data['status'] = explode(',', trim($slots_data['status'], '[]')); // Clean up potential extra brackets
              }

              //convert back to the last hour
              $datetime = new DateTime($current_time_format);
              $datetime->setTime($datetime->format('H'), 0, 0);
              $rounded_time = $datetime->format('H:i');
              $start_index = array_search($rounded_time, $times);
              // $start_index = array_search($start_time_format, $times);
              $end_index = array_search($end_time_format, $times);

                if ($start_index !== false && $end_index !== false) {
                    // Loop through the indices to mark the slots as available (0)
                  for ($i = $start_index; $i < $end_index; $i++) {
                      if (isset($slots_data['status'][$i])) {
                          if ($slots_data['status'][$i] == 1) {
                              $slots_data['status'][$i] = 0;
                              echo "Index $i updated to 0<br>";
                          } else {
                              echo "Index $i was not updated (value: " . $slots_data['status'][$i] . ")<br>";
                          }
                      } else {
                          echo "Index $i does not exist in slots_data['status']<br>";
                      }
                  }
                    // Update the slots in the database
                    $this->db->where('Floor', $area_info_floor);
                    $this->db->where('Room', $area_info_room);
                    $this->db->where('Slot', $area_info_seat);
                    $this->db->where('date', $area_info_date);
                    // Convert the array back to the string format
                    $updated_slots = implode(',', $slots_data['status']);
                    // To ensure the format is [0,0,0,0,0,0,0,0,1,0,0], wrap the result with square brackets
                    $updated_slots = '[' . $updated_slots . ']';
                    // Print the updated string
                    echo "Updated Slots: " . $updated_slots;
                    $this->db->update('slot', ['status' => $updated_slots]);
                    $this->db->where('id', $book_id);
                    $this->db->update('booking', [
                      // 'out_status' => 'exit',
                      'out_status' => 'f-timeout',
                      'out_time' => $current_time_format]);
                    // echo "<br>RAWR";
                    $this->session->set_flashdata('success', 'Booking Successfully Timed-out.');
                    redirect('report/attend_seat');
                }
                else {
                  $this->session->set_flashdata('error', 'Invalid time range.');
                  redirect('report/attend_seat');
                }
              } 

        }else if($current_time >= $end_time){
          $this->db->where('id', $book_id);
          $this->db->update('booking', [
            'out_status' => 'exit',
            'out_time' => $end_time_format]);
          $this->session->set_flashdata('success', 'Booking Successfully Timed-out.');
          redirect('report/attend_seat');
        // echo "just time out";
      }

    }
    // $this->session->set_flashdata('success', 'Timeout successfull.');
    // redirect('report/attend_seat');
  }

  public function prefillBookingDataMaster(){
    date_default_timezone_set('Asia/Manila');

    $book_id = $this->input->get('book_id');
    $data  =$this->db->get_where('booking', ['id' => $book_id])->row_array();

    if(!$data){
      $this->session->set_flashdata('error', 'No booking data found.');
      redirect('report/attend_seat');
    }
    else{
      $start_time = $data['start_time'];
      $end_time = $data['end_time'];

      if ($start_time >= 1 && $start_time <= 6) {
        $start_time_format = $start_time. ':00 PM';
      }else if($start_time >= 7 && $start_time <= 12){
        $start_time_format = $start_time. ':00 AM';
      }else if($start_time == 0){
        $start_time_format = '12:00 PM';
      }
      if ($end_time >= 1 && $end_time <= 6) {
        $end_time_format = $end_time . ':00 PM';
      } else if ($end_time >= 7 && $end_time <= 12) {
        $end_time_format = $end_time . ':00 AM';
      }else if($end_time == 0){
        $end_time_format = '12:00 PM';
      }
      $this->db->where('id', $book_id);
      $this->db->update('booking', [
        'in_status' => 'occupied',
        'out_status' => 'exit',
        'in_time' => $start_time_format, 
        'out_time' => $end_time_format]);

        $this->session->set_flashdata('success', 'Booking Succesfully Cancelled.');
        redirect('report/attend_seat');
    }

  }

  public function excel_export() {
    $d['title'] = 'Attendance';
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $startDate = $this->input->get('startDate');
    $endDate = $this->input->get('endDate');
    $course = $this->input->get('course');
    $college = $this->input->get('college');
    $countOnly = $this->input->get('countOnly');

    if (!$startDate || !$endDate || !$course || !$college) {
      $this->session->set_flashdata('error', 'Invalid Parameters.');
      redirect('attendance');
    }

    $this->load->model('Excel');

    // Fetch count data if 'countOnly' is true
    if ($countOnly == 'true') {
        $excel_data = $this->Excel->get_filtered_count_data($startDate, $endDate, $course, $college, true);
        if (!$excel_data) {
            $this->session->set_flashdata('error', 'No count data found for the given parameters.');
            redirect('attendance');
        }
        //add count_only = true to the excel_data
        $excel_data['count_only'] = true;
        // Print the count data and exit immediately
        // echo "<pre>";
        // print_r($excel_data); // This will show the count data
        // echo "</pre>";
        $this->session->set_flashdata('success', 'Data successfully extracted. Wait for a moment to download the excel.');
        $this->session->set_userdata('excel_data', $excel_data);
        redirect('attendance');
    }else{
    // Fetch regular data if 'countOnly' is not set to true
    $excel_data = $this->Excel->get_filtered_data($startDate, $endDate, $course, $college, false);

    if ($excel_data) {
        $this->session->set_flashdata('success', 'Data successfully extracted. Wait for a moment to download the excel.');
        $this->session->set_userdata('excel_data', $excel_data);
        redirect('attendance');
    } else {
        $this->session->set_flashdata('error', 'No data found for the given parameters.');
        redirect('attendance');
    }
    }
}

  public function unset_excel_data() {
    $this->session->unset_userdata('excel_data');
    echo json_encode(['status' => 'success']);
}

  public function lockArea(){
    // $area_id = $this->input->get('area_id'); // Use get() for query parameters
    $area_id = $this->input->get('area_id');

    if (!$area_id) {
        // If no area_id is provided, you can redirect back or show an error message
        redirect('master/area');
    }

    // Get the data from the area database
    $area_data = $this->db->get_where('area', ['id' => $area_id])->row_array();

    if ($area_data) {
        if ($area_data['availability'] == 0) {
            $this->db->where('id', $area_id);
            $this->db->update('area', ['availability' => 1]);
            $this->session->set_flashdata('success', 'The area has been made available.');
        } else {
            $this->db->where('id', $area_id);
            $this->db->update('area', ['availability' => 0]);
            $this->session->set_flashdata('warning', 'The area has been locked.');
        }
    } else {
        // If the area doesn't exist, handle it appropriately
        $this->session->set_flashdata('error', 'Area not found.');
    }

    redirect('master/area');
}


  public function cancelAllbookings(){
    //default date manila
    date_default_timezone_set('Asia/Manila');
    //validation of admin.
    //get the session id  and username. verify it.
    $username = $this->session->userdata('username');
    $admin_id = $this->session->userdata('role_id');
    $from_date = $this->input->post('from_date');
    $to_date = $this->input->post('to_date');
    $room = $this->input->post('room');
    $cancel = $this->input->post('cancel');
    $password = $this->input->post('password');
    
    //check the users table if it matches the username and password.
    $this->db->where('username', $username);
    $admin_data = $this->db->get('users')->row_array();
    $current_date = date('Y-m-d');
    $tomorrow_date = date('Y-m-d', strtotime($current_date . ' +1 days'));
    $current_time = date('H:i:s');
    $current_time_format = date('H:i', strtotime($current_time));

    // Check if the user exists and then verify the password
    if ($admin_data && password_verify($password, $admin_data['password'])) {
      if ($from_date == "" && $to_date == "" || $from_date == null && $to_date == null) {
        if($cancel != null && $cancel === "today"){
          //today all
          if ($room != null && $room == "all") {
            //get all the booking id in the booking table that has null time in and time outs with the current date.
            $this->db->where('date', $current_date);
            $this->db->where('in_time IS NULL', NULL, FALSE);
            $this->db->where('out_time IS NULL', NULL, FALSE);
            $bookings = $this->db->get('booking')->result_array();
            if(!$bookings){
              echo "No booking found";
              return;
            }
            foreach ($bookings as $booking) {
              // //update the booking table with the out_time and out_status.
              // $this->db->where('id', $booking['id']);
              // $this->db->update('booking', [
              //   'in_time' => date('H:i:s'), 
              //   'in_status' => 'occupied',
              //   'out_status' => 'exit',
              //   'out_time' => date('H:i:s')]);
              $area_floor = $booking['floor'];
              $area_name = $booking['room'];
              $seat_slot = $booking['slot_id'];
              $slots_data = $this->db->get_where('slot', [
                'Floor' => $area_floor,
                'Room' => $area_name,
                'Slot' => $seat_slot,
                'date' => $current_date
              ])->row_array();
              if (!$slots_data) {
                echo "No slot record";
                return;
              }
              $area_info = $this->db->get_where('area', array('floor' => $area_floor, 'room' => $area_name, ))->row_array();
              $open_time = strtotime($area_info['opentime']);
              $close_time = strtotime($area_info['closetime']);
              $endtime_index = $booking['end_time'];
              $starttime_index = $booking['start_time'];
              $timesIndex = array();
              $counter = 0;
              for ($time = $open_time; $time <= $close_time; $time = strtotime('+1 hour', $time)) {
                $timesIndex[$counter] = date('H:i', $time);
                $counter++;
              }
              $end_time = $timesIndex[$endtime_index];
              $start_time = $timesIndex[$starttime_index];
              $datetime = new DateTime($current_time_format);
              $datetime->setTime($datetime->format('H'), 0, 0);
              $rounded_time = $datetime->format('H:i');
              $start_index = array_search($rounded_time, $timesIndex);
              $end_time = new DateTime($end_time);
              $start_time = new DateTime($start_time);
              $current_time = new DateTime($current_time_format);

              if ($current_time < $end_time) {
                $slot_status = $slots_data['status'];
                $slot_status = substr($slot_status, 1, -1);
                $slot_status = explode(',', $slot_status);
                //now that slot status is an array, change the value of the index to 0, starting from start_index to endtime_index
                foreach ($slot_status as $key => $value) {
                  if ($key >= $start_index && $key <= $endtime_index) {
                    $slot_status[$key] = 0;
                  }
                }
                $slot_status = '['. implode(',', $slot_status). ']';
                // echo $slot_status;
                //apply
                $this->db->where('Floor', $area_floor);
                $this->db->where('Room', $area_name);
                $this->db->where('Slot', $seat_slot);
                $this->db->where('date', $current_date);
                $this->db->update('slot', ['status' => $slot_status]);
              }
              else if ($current_time > $start_time){
                $slot_status = $slots_data['status'];
                $slot_status = substr($slot_status, 1, -1);
                $slot_status = explode(',', $slot_status);
                foreach ($slot_status as &$status) {
                  $status = 0;
                }
                //make it back to string and add [] in the beginning and the end
                $slot_status = '['. implode(',', $slot_status). ']';
                //save it in the slot table with the slotsdata
                $this->db->where('Floor', $area_floor);
                $this->db->where('Room', $area_name);
                $this->db->where('Slot', $seat_slot);
                $this->db->where('date', $current_date);
                $this->db->update('slot', ['status' => $slot_status]);
              }
              else if ($current_time > $end_time){
                //still today pero lagpas na sa reservation time.
                //fill lang to so. just proceed sa baba
              }
              $this->db->where('id', $booking['id']);
              $this->db->update('booking', [
                'in_time' => date('H:i:s'),
                'in_status' => 'cancelled',
                'out_status' => 'cancelled', 
                // 'in_status' => 'occupied',
                // 'out_status' => 'exit',
                'out_time' => date('H:i:s')]);
            }
            echo "success";
          }
          //today specific
          else if ($room != null && $room != "all") {
            // echo $room;
            //$room is initialized already just get it.
            $this->db->where('room', $room);
            //get all the bookings in the room within this day.
            $this->db->where('date', $current_date);
            $this->db->where('in_time IS NULL', NULL, FALSE);
            $this->db->where('out_time IS NULL', NULL, FALSE);
            $bookings = $this->db->get('booking')->result_array();
            if (!$bookings){
              echo 'No Bookings Found';
              return;
            }
            // echo '<pre>';
            // print_r($bookings);
            // echo '<pre>';
            foreach ($bookings as $booking) {
              $area_floor = $booking['floor'];
              $area_name = $booking['room'];
              $seat_slot = $booking['slot_id'];
              // echo "<br>";
              // echo "area_floor: ". $area_floor. ", area_name: ". $area_name. ", seat_slot: ". $seat_slot;
              $slots_data = $this->db->get_where('slot', [
                'Floor' => $area_floor,
                'Room' => $area_name,
                'Slot' => $seat_slot,
                'date' => $current_date
              ])->row_array();

              if (!$slots_data) {
                echo "No slot record";
                return;
              }
              $area_info = $this->db->get_where('area', array('floor' => $area_floor, 'room' => $area_name, ))->row_array();
              // echo '<pre>';
              // print_r($area_info);
              // echo '<pre>';
              $open_time = strtotime($area_info['opentime']);
              $close_time = strtotime($area_info['closetime']);
              // echo "<br>";
              // echo $open_time;
              // echo "<br>";
              // echo $close_time;

              $endtime_index = $booking['end_time'];
              $starttime_index = $booking['start_time'];
              $timesIndex = array();
              $counter = 0;
              for ($time = $open_time; $time <= $close_time; $time = strtotime('+1 hour', $time)) {
                $timesIndex[$counter] = date('H:i', $time);
                $counter++;
              }
              $end_time = $timesIndex[$endtime_index];
              $start_time = $timesIndex[$starttime_index];
              $datetime = new DateTime($current_time_format);
              $datetime->setTime($datetime->format('H'), 0, 0);
              $rounded_time = $datetime->format('H:i');
              $start_index = array_search($rounded_time, $timesIndex);
              // echo "<br>";
              // echo $start_index;
              //if current time is is less than the end time free the seat.
              $end_time = new DateTime($end_time);
              $start_time = new DateTime($start_time);
              $current_time = new DateTime($current_time_format);

              if ($current_time < $end_time) {
                $slot_status = $slots_data['status'];
                // echo $slot_status;
                // echo "<br>";
                $slot_status = substr($slot_status, 1, -1);
                // echo $slot_status;
                // echo "<br>";
                $slot_status = explode(',', $slot_status);
                // print_r($slot_status);
                // echo "<br>";
                //now that slot status is an array, change the value of the index to 0, starting from start_index to endtime_index
                foreach ($slot_status as $key => $value) {
                  if ($key >= $start_index && $key <= $endtime_index) {
                    $slot_status[$key] = 0;
                  }
                }
                $slot_status = '['. implode(',', $slot_status). ']';
                // echo $slot_status;
                //apply
                $this->db->where('Floor', $area_floor);
                $this->db->where('Room', $area_name);
                $this->db->where('Slot', $seat_slot);
                $this->db->where('date', $current_date);
                $this->db->update('slot', ['status' => $slot_status]);

              }
              else if ($current_time > $start_time){
                //today pero earlier than reservation time.
                //get the status and set all indeces to 0
                $slot_status = $slots_data['status'];
                //transform               $slot_status = $slots_data['status']; into an array and remove the [] at the beggining and the end first
                $slot_status = substr($slot_status, 1, -1);
                $slot_status = explode(',', $slot_status);
                //set all the elements of the slots data status to 0

                foreach ($slot_status as &$status) {
                  $status = 0;
                }

                //make it back to string and add [] in the beginning and the end
                $slot_status = '['. implode(',', $slot_status). ']';
                //save it in the slot table with the slotsdata
                $this->db->where('Floor', $area_floor);
                $this->db->where('Room', $area_name);
                $this->db->where('Slot', $seat_slot);
                $this->db->where('date', $current_date);
                $this->db->update('slot', ['status' => $slot_status]);
              }
              else if ($current_time > $end_time){
                //still today pero lagpas na sa reservation time.
                //fill lang to so. just proceed sa baba
              }
              //update the booking table with the out_time and out_status.
              $this->db->where('id', $booking['id']);
              $this->db->update('booking', [
                'in_time' => date('H:i:s'),
                'in_status' => 'cancelled',
                'out_status' => 'cancelled', 
                // 'in_status' => 'occupied',
                // 'out_status' => 'exit',
                'out_time' => date('H:i:s')]);
            }
            echo "success";
          }
        }
        else if ($cancel != null && $cancel == "tomorrow"){
          //tomorrow all
          if ($room != null && $room == "all") {
            //get all the booking id in the booking table that has null time in and time outs with the current date.
            $this->db->where('date', $tomorrow_date);
            $this->db->where('in_time IS NULL', NULL, FALSE);
            $this->db->where('out_time IS NULL', NULL, FALSE);
            $bookings = $this->db->get('booking')->result();
            // echo '<pre>';
            // print_r($bookings);
            // echo '</pre>';
            if (!$bookings){
              echo 'No Bookings Found';
              return;
            }

            foreach ($bookings as $booking) {
              $area_floor = $booking->floor;
              $area_name = $booking->room;
              $seat_slot = $booking->slot_id;
              $slots_data = $this->db->get_where('slot', [
                'Floor' => $area_floor,
                'Room' => $area_name,
                'Slot' => $seat_slot,
                'date' => $tomorrow_date,])->row_array();
                if (!$slots_data) {
                  echo "No slot record";
                  return;
                }
                $slot_status = $slots_data['status'];
                $slot_status = substr($slot_status, 1, -1);
                $slot_status = explode(',', $slot_status);
                //set all the elements of the slots data status to 0
    
                foreach ($slot_status as &$status) {
                  $status = 0;
                }
    
                //make it back to string and add [] in the beginning and the end
                $slot_status = '['. implode(',', $slot_status). ']';
                //save it in the slot table with the slotsdata
                $this->db->where('Floor', $area_floor);
                $this->db->where('Room', $area_name);
                $this->db->where('Slot', $seat_slot);
                $this->db->where('date', $tomorrow_date);
                $this->db->update('slot', ['status' => $slot_status]);

              //update the booking table with the out_time and out_status.
              $this->db->where('id', $booking->id);
              $this->db->update('booking', [
                'in_time' => date('H:i:s'),
                'in_status' => 'cancelled',
                'out_status' => 'cancelled', 
                // 'in_status' => 'occupied',
                // 'out_status' => 'exit',
                'out_time' => date('H:i:s')]);
            }
            echo "success";
          }
          //tomorrow specific
          else if ($room != null && $room != "all") {
            //$room is initialized already just get it.
            $this->db->where('room', $room);
            //get all the bookings in the room within this day.
            $this->db->where('date', $tomorrow_date);
            $this->db->where('in_time IS NULL', NULL, FALSE);
            $this->db->where('out_time IS NULL', NULL, FALSE);
            $bookings = $this->db->get('booking')->result_array();
            if (!$bookings){
              echo 'No Bookings Found';
              return;
            }
            foreach ($bookings as $booking) {
              $area_floor = $booking['floor'];
              $area_name = $booking['room'];
              $seat_slot = $booking['slot_id'];
              $slots_data = $this->db->get_where('slot', [
                'Floor' => $area_floor,
                'Room' => $area_name,
                'Slot' => $seat_slot,
                'date' => $tomorrow_date
              ])->row_array();

              if (!$slots_data) {
                echo "no slot record";
                return;
              }
              //check with time pa dapat pero bukas na.
              //get the status and set all indeces to 0
              $slot_status = $slots_data['status'];
              // echo $slot_status;
              //transform               $slot_status = $slots_data['status']; into an array and remove the [] at the beggining and the end first
              $slot_status = substr($slot_status, 1, -1);
              $slot_status = explode(',', $slot_status);
              //set all the elements of the slots data status to 0
              foreach ($slot_status as &$status) {
                $status = 0;
              }
              //make it back to string and add [] in the beginning and the end
              $slot_status = '['. implode(',', $slot_status). ']';
              // echo'<br>';
              // echo $slot_status;
              //save it in the slot table with the slotsdata
              $this->db->where('Floor', $area_floor);
              $this->db->where('Room', $area_name);
              $this->db->where('Slot', $seat_slot);
              $this->db->where('date', $tomorrow_date);
              $this->db->update('slot', ['status' => $slot_status]);
              //update the booking table with the out_time and out_status.
              $this->db->where('id', $booking['id']);
              $this->db->update('booking', [
                'in_time' => date('H:i:s'), 
                'in_status' => 'cancelled',
                'out_status' => 'cancelled', 
                // 'in_status' => 'occupied',
                // 'out_status' => 'exit',
                'out_time' => date('H:i:s')]);
            }
            // print_r($timesIndex);
            echo "success";
          }
        }
      }
      else if ($from_date != null && $to_date != null || $from_date != "" && $to_date != "") {
        //date range all
        if ($room != null && $room == "all"){
          //get all the booking id in the booking table that has null time in and time outs within the given date range.
          $this->db->where('date >=', $from_date);
          $this->db->where('date <=', $to_date);
          $this->db->where('in_time IS NULL', NULL, FALSE);
          $this->db->where('out_time IS NULL', NULL, FALSE);
          $bookings = $this->db->get('booking')->result();
          if (!$bookings) {
            echo "No Bookings Found.";
            return;
          }
          foreach ($bookings as $booking) {
            $area_floor = $booking->floor;
            $area_name = $booking->room;
            $seat_slot = $booking->slot_id;
            $slots_data = $this->db->get_where('slot', [
              'Floor' => $area_floor,
              'Room' => $area_name,
              'Slot' => $seat_slot,
              'date >=' => $from_date,
              'date <=' => $to_date
            ])->row_array();
              if (!$slots_data) {
              echo "No slot record";
              return;
            }
            $slot_status = $slots_data['status'];
            $slot_status = substr($slot_status, 1, -1);
            $slot_status = explode(',', $slot_status);
            //set all the elements of the slots data status to 0

            foreach ($slot_status as &$status) {
              $status = 0;
            }

            //make it back to string and add [] in the beginning and the end
            $slot_status = '['. implode(',', $slot_status). ']';
            //save it in the slot table with the slotsdata
            $this->db->where('Floor', $area_floor);
            $this->db->where('Room', $area_name);
            $this->db->where('Slot', $seat_slot);
            $this->db->where('date >=', $from_date);
            $this->db->where('date <=', $to_date);
            $this->db->update('slot', ['status' => $slot_status]);

            //update the booking table with the out_time and out_status.
            $this->db->where('id', $booking->id);
            $this->db->update('booking', [
              'in_time' => date('H:i:s'),
              'in_status' => 'cancelled',
              'out_status' => 'cancelled',
              // 'in_status' => 'occupied',
              // 'out_status' => 'exit',
              'out_time' => date('H:i:s')]);
          }
          echo "success";
        }
        //date range specific
        else if ($room != null && $room != "all"){
          $this->db->where('room', $room);
          //get all the bookings in the room within this day.
          $this->db->where('date >=', $from_date);
          $this->db->where('date <=', $to_date);
          $this->db->where('in_time IS NULL', NULL, FALSE);
          $this->db->where('out_time IS NULL', NULL, FALSE);
          $bookings = $this->db->get('booking')->result_array();

          if (!$bookings) {
            echo "No Bookings Found.";
            return;
          }

          foreach ($bookings as $booking) {
            $area_floor = $booking['floor'];
            $area_name = $booking['room'];
            $seat_slot = $booking['slot_id'];
            $slots_data = $this->db->get_where('slot', [
              'Floor' => $area_floor,
              'Room' => $area_name,
              'Slot' => $seat_slot,
              'date >=' => $from_date,
              'date <=' => $to_date
            ])->row_array();
              if (!$slots_data) {
              echo "No slot record";
              return;
            }
            $slot_status = $slots_data['status'];
            $slot_status = substr($slot_status, 1, -1);
            $slot_status = explode(',', $slot_status);
            //set all the elements of the slots data status to 0

            foreach ($slot_status as &$status) {
              $status = 0;
            }

            //make it back to string and add [] in the beginning and the end
            $slot_status = '['. implode(',', $slot_status). ']';
            //save it in the slot table with the slotsdata
            $this->db->where('Floor', $area_floor);
            $this->db->where('Room', $area_name);
            $this->db->where('Slot', $seat_slot);
            $this->db->where('date >=', $from_date);
            $this->db->where('date <=', $to_date);
            $this->db->update('slot', ['status' => $slot_status]);

            //update the booking table with the out_time and out_status.
            $this->db->where('id', $booking['id']);
            $this->db->update('booking', [
              'in_time' => date('H:i:s'),
              'in_status' => 'cancelled',
              'out_status' => 'cancelled', 
              // 'in_status' => 'occupied',
              // 'out_status' => 'exit',
              'out_time' => date('H:i:s')]);
          }
          echo "success";
        }
      }
    }
    else {
      echo "Incorrect Password. Please Try again.";
    }
  }

  public function import_database(){
    // API endpoint
    $url = $this->config->item('api_endpoint');
    
    $token = $this->HttpGetTokenToTawi();
        if (!$token) {
            $this->session->set_flashdata('student_neutral', 'Unauthorized: Failed to get token.');
            redirect('master/student');
        }

    // Initialize cURL
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ]
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Get the HTTP response code
    if (curl_errno($ch)) {
      $error = curl_error($ch);
      curl_close($ch);
      $this->session->set_flashdata('student_neutral', 'Error: ' . $error);
      redirect('master/student');
    }
    curl_close($ch);

    $data = json_decode($response, true);

    if ( !$data) {
      $this->session->set_flashdata('student_neutral', 'API Error: Failed to fetch data.');
      redirect('master/student');
    }
    $studentCounter = 0;
    $addCounter = 0;
    $editCounter = 0;
    $failedAddCounter = 0;
    $failedEditCounter = 0;
    $neutralEditCounter = 0;

    //NOTE: CURRENTLY, BATCH UPDATE AND INSERT SHOULD BE IMPLEMENTED HERE It is actually implemented on the commented code but i encountered an error. nonethless,  this is good for demos. not for datas up to 10k plus
    foreach ($data['data']['rows'] as $student) {
      $studentCounter++;
      // Check if srcode or rfid already exists
      $this->db->where('srcode', $student['id_number']);
      // $this->db->or_where('rfid', $student['rfid']);
      $existing_student = $this->db->get('student')->row_array();


      $data = array_filter([
        'first_name' => $student['first_name'] ?? null,
        'middle_name' => $student['middle_name'] ?? null,
        'last_name' => $student['last_name'] ?? null,
        'gender' => $student['gender'] ?? null,
        'course' => $student['department'] ?? null,
        'schoolyear' => $student['school_year'] ?? null,
        'birthdate' => date('Y-m-d', strtotime($student['birthdate'])) ?? null,
        'srcode' => $student['id_number'] ?? null,
        'college' => $student['college'] ?? null,
        'rfid' => $student['rfid'] ?? null,
        // 'pin' => substr($student['id_number'], -6) . str_replace(['-', ' '], '', $student['birthdate']) ?? null
        'pin' => date('mdY', strtotime($student['birthdate'])) ?? null
      ]);
      
      //IF THE STUDENT IS EXISTING, UPDATE
      if ($existing_student) {
        $this->db->where('srcode', $student['id_number']);
        $this->db->update('student', $data);
        if ($this->db->affected_rows() > 0) {
          $editCounter++;
        } elseif ($this->db->affected_rows() === 0) {
          $neutralEditCounter++;
        } else {
          $failedEditCounter++;
        }
        continue;
      }
      // IF THE STUDENT IS NEW, ADD
      if (!$this->db->insert('student', $data)) {
        $failedAddCounter++;
        continue;
      }else{
        $addCounter++;
        continue;
      }
    }
    $this->session->set_flashdata('student_neutral', 
        "<i class='fas fa-check-circle text-success'></i> Succesfully imported $studentCounter student records." . PHP_EOL .
        "---------------------------------" . PHP_EOL .
        "<i class='fas fa-plus-circle text-primary'></i> Added $addCounter new student records." . PHP_EOL .
        "---------------------------------" . PHP_EOL .
        "<i class='fas fa-edit text-warning'></i> Updated $editCounter existing student records." . PHP_EOL .
        "---------------------------------" . PHP_EOL .
        "<i class='fas fa-times-circle text-danger'></i> $failedAddCounter student records failed to be added." . PHP_EOL .
        "---------------------------------" . PHP_EOL .
        "<i class='fas fa-times-circle text-danger'></i> $failedEditCounter student records failed to be updated."
    );
    redirect('master/student');
    }
//   public function import_database() {
//     // API endpoint
//     $url = $this->config->item('api_endpoint');
    
//     $token = $this->HttpGetTokenToTawi();
//     if (!$token){
//       $this->session->set_flashdata('student_neutral', 'Unauthorized: Failed to get token.');
//       redirect('master/student');
//     }
    
//     // if (!$token) {
//     //     $response = [
//     //         'status' => 401,
//     //         'message' => 'Unauthorized: Failed to get token.'
//     //     ];
//     //     $this->output
//     //         ->set_content_type('application/json')
//     //         ->set_status_header(401)
//     //         ->set_output(json_encode($response));
//     //     return;
//     // }

//     // Initialize cURL
//     $ch = curl_init($url);
//     curl_setopt_array($ch, [
//         CURLOPT_RETURNTRANSFER => true,
//         CURLOPT_HTTPHEADER => [
//             'Authorization: Bearer ' . $token,
//             'Content-Type: application/json'
//         ]
//     ]);
    
//     $response = curl_exec($ch);
//     $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Get the HTTP response code
//     if (curl_errno($ch)) {
//         $error = curl_error($ch);
//         curl_close($ch);
//         $this->session->set_flashdata('student_neutral', 'Error: ' . $error);
//         redirect('master/student');
//     }
//     curl_close($ch);

//     $data = json_decode($response, true);

//     if (!$data) {
//         $this->session->set_flashdata('student_neutral', 'API Error: Failed to fetch data.');
//         // $this->session->set_flashdata('student_neutral', 'Error: ' . $error);
//         redirect('master/student');
//         // echo 'Failed to fetch data. HTTP Code: ' . $httpCode;
//         // return;
//     }

//     $studentCounter = 0;
//     $addCounter = 0;
//     $editCounter = 0;
//     $failedAddCounter = 0;
//     $failedEditCounter = 0;
//     $neutralEditCounter = 0;
    
//     $batchSize = 500; // Set batch size for insert/update operations
//     $students = $data['data']['rows']; // Get the full list of students
//     $totalRecords = count($students);
    
//     // Process students in batches
//     $insertData = [];
//     $updateData = [];
    
//     for ($i = 0; $i < $totalRecords; $i++) {
//         $student = $students[$i];
//         $studentCounter++;

//         // Check if srcode or rfid already exists
//         $this->db->where('srcode', $student['id_number']);
//         $existing_student = $this->db->get('student')->row_array();

//         // // Handle missing birthdate
//         // if (empty($student['birthdate'])) {
//         //     $student['birthdate'] = '2000-01-01';
//         // }

//         $data = array_filter([
//             'first_name' => $student['first_name'] ?? null,
//             'middle_name' => $student['middle_name'] ?? null,
//             'last_name' => $student['last_name'] ?? null,
//             'gender' => $student['gender'] ?? null,
//             'course' => $student['department'] ?? null,
//             'schoolyear' => $student['school_year'] ?? null,
//             'birthdate' => date('Y-m-d', strtotime($student['birthdate'])) ?? null,
//             'srcode' => $student['id_number'] ?? null,
//             'college' => $student['college'] ?? null,
//             'rfid' => $student['rfid'] ?? null,
//             // 'pin' => substr($student['id_number'], -6) . str_replace(['-', ' '], '', $student['birthdate']) ?? null
//             'pin' => ltrim(date('njY', strtotime($student['birthdate'])), '0') ?? null
//         ]);

//         // If the student exists, update
//         if ($existing_student) {
//             $updateData[] = [
//                 'first_name' => $student['first_name'],
//                 'middle_name' => $student['middle_name'],
//                 'last_name' => $student['last_name'],
//                 'gender' => $student['gender'],
//                 'course' => $student['department'],
//                 'schoolyear' => $student['school_year'],
//                 'birthdate' => date('Y-m-d', strtotime($student['birthdate'])),
//                 'college' => $student['college'],
//                 'rfid' => $student['rfid'],
//                 'srcode' => $student['id_number'],
//                 'pin' => str_replace(['-', ' '], '', $student['birthdate'])
//             ];

//             // Check if the batch size is reached for updates
//             if (count($updateData) >= $batchSize) {
//                 $this->db->update_batch('student', $updateData, 'srcode');
//                 $editCounter += count($updateData);
//                 $updateData = []; // Clear after bulk update
//             }
//         } else {
//             // If the student is new, add
//             $insertData[] = $data;

//             // Check if the batch size is reached for insert
//             if (count($insertData) >= $batchSize) {
//                 if (!$this->db->insert_batch('student', $insertData)) {
//                     $failedAddCounter += count($insertData);
//                 } else {
//                     $addCounter += count($insertData);
//                 }
//                 $insertData = []; // Clear after batch insert
//             }
//         }
//     }

//     // Final batch insert/update if there are remaining records
//     if (count($insertData) > 0) {
//         if (!$this->db->insert_batch('student', $insertData)) {
//             $failedAddCounter += count($insertData);
//         } else {
//             $addCounter += count($insertData);
//         }
//     }

//     if (count($updateData) > 0) {
//         $this->db->update_batch('student', $updateData, 'srcode');
//         $editCounter += count($updateData);
//     }

//     // Set flash data to display results
//     $this->session->set_flashdata('student_neutral', 
//         "<i class='fas fa-check-circle text-success'></i> Successfully imported $studentCounter student records." . PHP_EOL .
//         "---------------------------------" . PHP_EOL .
//         "<i class='fas fa-plus-circle text-primary'></i> Added $addCounter new student records." . PHP_EOL .
//         "---------------------------------" . PHP_EOL .
//         "<i class='fas fa-edit text-warning'></i> Updated $editCounter existing student records." . PHP_EOL .
//         "---------------------------------" . PHP_EOL .
//         "<i class='fas fa-times-circle text-danger'></i> $failedAddCounter student records failed to be added." . PHP_EOL .
//         "---------------------------------" . PHP_EOL .
//         "<i class='fas fa-times-circle text-danger'></i> $failedEditCounter student records failed to be updated."
//     );
//     redirect('master/student');
// }


  public function HttpGetTokenToTawi(){
    $authURL = $this->config->item('auth_url');
      //please hide this in env or config.
        $postData = [
                "username" => $this->config->item('username'),
                "secret" => $this->config->item('password')
        ];

        $ch = curl_init($authURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            echo 'Error: ' . $error;
            return;
        }

        curl_close($ch);

        if ($httpCode == 200) {
            $data = json_decode($response, true);
            $token = $data['data']['token'];

            return $token;
        } else {
            echo 'Failed to authenticate. HTTP Code: ' . $httpCode;
        }
  }

  public function upload_image()
  {
      // Load the helper for file uploads
      $this->load->helper(['form', 'url']);
      $this->load->library('upload');
  
      // Configure upload options
      $config['upload_path']          = './assets/img';
      $config['allowed_types'] = 'jpg|jpeg|png|gif'; // Allowed file types
      $config['max_size']      = 12048; // Maximum file size in KB (2MB)
      $config['encrypt_name']  = true; // To prevent file name conflicts
  
      $this->upload->initialize($config);
  
      if (!$this->upload->do_upload('imageFile')) {
          // Handle upload error
          $response = ['status' => 'error', 'message' => $this->upload->display_errors()];
      } else {
          // File uploaded successfully
          $fileData = $this->upload->data();
          $filePath = $fileData['full_path'];
  
          // Convert image to blob
          $imageBlob = file_get_contents($filePath);
  
          // Save to database
          $data = [
              'id' => $this->input->post('id'), // Assuming the user ID is passed
              'image' => $imageBlob,
          ];
  
          $this->load->model('ProfileModel');
          $result = $this->ProfileModel->update_profile_image($data);
  
          if ($result) {
              $response = ['status' => 'success', 'message' => 'Image uploaded and saved successfully.'];
          } else {
              $response = ['status' => 'error', 'message' => 'Failed to save image to the database.'];
          }
  
          // Delete the temporary file after saving it to the database
          unlink($filePath);
      }
  
      echo json_encode($response);
  }

  // public function export_to_koha(){
  //   //get the student model and fetch all the students
  //   $students = $this->Student_model->get_students();
  //   // echo '<pre>';
  //   // print_r($students);
  //   // echo '<pre>';
  //   //get the koha api for adding patrons from the config
  //   $add_patrons_koha_url = $this->config->item('add_patrons');
  //   $get_patrons_koha_url = $this->config->item('get_patrons');

  //   //check if the patron already exists in the koha library use the api
  //   $ch = curl_init($get_patrons_koha_url);
  //   curl_setopt_array($ch, [
  //       CURLOPT_RETURNTRANSFER => true,
  //       CURLOPT_HTTPHEADER => [
  //           'Content-Type: application/json'
  //       ],
  //       CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
  //       CURLOPT_USERNAME => $this->config->item('koha_username'),
  //       CURLOPT_PASSWORD => $this->config->item('koha_password')
  //   ]);

  //   $koha_students_response = curl_exec($ch);
  //   $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Get the HTTP response code
  //   if (curl_errno($ch)) {
  //     $error = curl_error($ch);
  //     curl_close($ch);
  //     $this->session->set_flashdata('student_neutral', 'Error: ' . $error);
  //     redirect('master/student');
  //   }
  //   curl_close($ch);

  //   $response = json_decode($koha_students_response, true);

  //   if(!is_array($response)){
  //     $this->session->set_flashdata('student_neutral', 'Invalid Koha Response. Please try again.');
  //     redirect('master/student');
  //   }
  //   // echo '<pre>';
  //   // print_r($response);
  //   // echo '<pre>';

  //   // Extract Koha card numbers
  //   $koha_cardnumbers = array_column($response, 'cardnumber');

  //   //if the scrode of the student, matches with the koha library cardnumber, don't include it in the payload.
  //   foreach ($students as $student) {
  //       $studentnumber = preg_replace('/[^0-9]/', '', $student['srcode']);
  //       if (!in_array($studentnumber, $koha_cardnumbers)) {
  //           $students_to_add[] = [
  //             'cardnumber' => $studentnumber,
  //             'firstname' => $student['first_name'],
  //             'middle_name' => $student['middle_name'] ?? null,
  //             'surname' => $student['last_name'],
  //             'gender' => $student['gender'],
  //             'email' => $student['email'] ?? null,
  //             'library_id' => 'TTL',
  //             'category_id' => 'S',
  //             'user_id' => $student['first_name'] . $student['last_name']
  //           ];
  //       }
  //   }

  //   print_r($students_to_add);

  //   if (!empty($students_to_add)) {
  //       $ch = curl_init($add_patrons_koha_url);
  //       curl_setopt_array($ch, [
  //           CURLOPT_RETURNTRANSFER => true,
  //           CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
  //           CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
  //           CURLOPT_USERNAME => $this->config->item('koha_username'),
  //           CURLOPT_PASSWORD => $this->config->item('koha_password'),
  //           CURLOPT_POST => true,
  //           CURLOPT_POSTFIELDS => json_encode($students_to_add)
  //       ]);
    
  //       $add_response = curl_exec($ch);
  //       $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  //       curl_close($ch);
  //       print_r($add_response);
  //       if ($httpCode === 201) {
  //           $this->session->set_flashdata('student_scs', 'Students added successfully to Koha.');
  //       } else {
  //           $this->session->set_flashdata('student_fail', $add_response);
  //       }
  //       // redirect('master/student');
  //   } else {
  //       $this->session->set_flashdata('student_neutral', 'All students may already exist in Koha.');
  //       // redirect('master/student');
  //   }

  // }
  // public function export_to_koha(){
  //     // Get students
  //     $students = $this->Student_model->get_students();

  //     // Get Koha API URLs
  //     $add_patrons_koha_url = $this->config->item('add_patrons');
  //     //fetch patrons from koha
  //     $response = $this->get_patrons_from_koha();
  //     // $response = json_decode($koha_students_response, true);
  //     if (empty($response) || !is_array($response)) {
  //         // log_message('error', 'Invalid response from Koha: ' . $koha_students_response);
  //         $this->session->set_flashdata('student_neutral', 'Invalid Koha Response. Please try again.');
  //         redirect('master/student');
  //         return;
  //     }

  //     // Extract Koha card numbers
  //     $koha_cardnumbers = array_column($response, 'cardnumber');

  //     // Initialize counters
  //     $added_count = 0;
  //     $failed_count = 0;
  //     $passerror_count = 0;

  //     foreach ($students as $student) {
  //         $studentnumber = preg_replace('/[^0-9]/', '', $student['srcode']);
          
  //         if (!in_array($studentnumber, $koha_cardnumbers)) {
  //             $student_data = [
  //                 'cardnumber' => $studentnumber,
  //                 'firstname' => $student['first_name'],
  //                 'middle_name' => $student['middle_name'] ?? null,
  //                 'surname' => $student['last_name'],
  //                 'gender' => $student['gender'],
  //                 'email' => $student['email'] ?? null,
  //                 'library_id' => 'TTL',
  //                 'category_id' => 'ST', //(S) STAFF, (B) Board, (ST) Student
  //                 'userid' => $student['first_name'] . $student['last_name']
  //             ];

  //             // Send each student individually
  //             $ch = curl_init($add_patrons_koha_url);
  //             curl_setopt_array($ch, [
  //                 CURLOPT_RETURNTRANSFER => true,
  //                 CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
  //                 CURLOPT_USERPWD => $this->config->item('koha_username') . ":" . $this->config->item('koha_password'),
  //                 CURLOPT_POST => true,
  //                 CURLOPT_POSTFIELDS => json_encode($student_data)
  //             ]);

  //             $add_response = curl_exec($ch);
  //             $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

  //             //POST PASS
  //             //get the student's patronid from koha that matches the cardnumber and studentID
  //             $koharesponse = $this->get_patrons_from_koha();
  //             // echo "\nRESPONSE: ";
  //             // echo "<pre>";
  //             // print_r($koharesponse);
  //             // echo "<pre>";

  //             $cardnumbers = array_column($koharesponse, 'cardnumber');
  //             // echo "\ncard numbers: ";
  //             // echo "<pre>";
  //             // print_r($cardnumbers);
  //             // echo "<pre>";
  //             $koha_patronid = (array_column($koharesponse, 'patron_id'));

  //             $patron_id = $koha_patronid[array_search($studentnumber, $cardnumbers)];
  //             // echo "\nPatron ID: ";
  //             // echo "<pre>";
  //             // print_r($patron_id);
  //             // echo "<pre>";
              
  //             $change_pass_url = 'http://192.168.1.68:8080/api/v1/patrons/' . $patron_id . '/password';
  //             $ch = curl_init($change_pass_url);
  //             $passwordStudent = ucfirst(substr($student['first_name'], 0, 1)) . 
  //             lcfirst(substr($student['last_name'], 0, 1)) . '@' . $student['pin'];
  //             $student_password = [
  //                 'password' => $passwordStudent,
  //                 'password_2' => $passwordStudent
  //             ];
  //             curl_setopt_array($ch, [
  //                 CURLOPT_RETURNTRANSFER => true,
  //                 CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
  //                 CURLOPT_USERPWD => $this->config->item('koha_username') . ":" . $this->config->item('koha_password'),
  //                 CURLOPT_POST => true,
  //                 CURLOPT_POSTFIELDS => json_encode($student_password)
  //             ]);

  //             $pass_response = curl_exec($ch);
  //             $httpCodePass = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  //             curl_close($ch);

  //             if ($httpCode === 201 && $httpCodePass === 200) {
  //               $added_count++;
  //             }
  //             else if ($httpCode === 201 && $httpCodePass !== 200) {
  //               $failed_count++;
  //               $passerror_count++;
  //             }
  //             else if (!$httpCodePass === 200 && !$httpCode === 201) {
  //               $failed_count++;
  //             }
  //         }
  //     }
      
  //     // Flash messages
  //     if ($added_count > 0 && $passerror_count === 0) {
  //         $this->session->set_flashdata('student_scs', "$added_count student(s) added successfully to Koha Library!");
  //     } 
  //     if ($failed_count > 0) {
  //         $this->session->set_flashdata('student_fail', "$failed_count students failed to be added to Koha.");
  //     }
  //     if ($added_count === 0 && $failed_count === 0) {
  //         $this->session->set_flashdata('student_neutral', 'All students may already exist in Koha. Please check the the Koha server.');
  //     }
  //     redirect('master/student');
  // }
//one by one
  // public function export_to_koha()
  // {
  //     // Get students from the local system
  //     $students = $this->Student_model->get_students();
  //     if (empty($students)) {
  //         $this->session->set_flashdata('student_neutral', 'No students to process.');
  //         redirect('master/student');
  //         return;
  //     }
  
  //     // Get Koha API URLs
  //     $add_patrons_koha_url = $this->config->item('add_patrons');
  
  //     // Fetch existing Koha patrons **once**
  //     $response = $this->get_patrons_from_koha();
  //     if (empty($response) || !is_array($response)) {
  //         $this->session->set_flashdata('student_neutral', 'Invalid Koha Response. Please try again.');
  //         redirect('master/student');
  //         return;
  //     }
  
  //     // Extract Koha card numbers into a set for fast lookup
  //     $koha_cardnumbers = array_column($response, 'cardnumber');
  //     $koha_patron_ids = array_column($response, 'patron_id', 'cardnumber');
  
  //     // **Filter only students who are NOT in Koha**
  //     $new_students = array_filter($students, function ($student) use ($koha_cardnumbers) {
  //         $studentnumber = preg_replace('/[^0-9]/', '', $student['srcode']);
  //         return !in_array($studentnumber, $koha_cardnumbers);
  //     });
  
  //     if (empty($new_students)) {
  //         $this->session->set_flashdata('student_neutral', 'All students already exist in Koha.');
  //         redirect('master/student');
  //         return;
  //     }
  
  //     // Initialize counters
  //     $added_count = 0;
  //     $failed_count = 0;
  //     $passerror_count = 0;
  
  //     // Prepare cURL session
  //     $ch = curl_init();
  //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //     curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
  //     curl_setopt($ch, CURLOPT_USERPWD, $this->config->item('koha_username') . ":" . $this->config->item('koha_password'));
  //     curl_setopt($ch, CURLOPT_POST, true);
  
  //     foreach ($new_students as $student) {
  //         $studentnumber = preg_replace('/[^0-9]/', '', $student['srcode']);
  
  //         // Prepare student data
  //         $student_data = [
  //             'cardnumber'  => $studentnumber,
  //             'firstname'   => $student['first_name'],
  //             'middle_name' => $student['middle_name'] ?? null,
  //             'surname'     => $student['last_name'],
  //             'gender'      => $student['gender'],
  //             'email'       => $student['email'] ?? null,
  //             'library_id'  => 'TTL',
  //             'category_id' => 'ST', // (S) STAFF, (B) Board, (ST) Student
  //             'userid'      => $student['first_name'] . $student['last_name']
  //         ];
  
  //         // Send student to Koha
  //         curl_setopt($ch, CURLOPT_URL, $add_patrons_koha_url);
  //         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($student_data));
  //         $add_response = curl_exec($ch);
  //         $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  
  //         if ($httpCode !== 201) {
  //             $failed_count++;
  //             continue;
  //         }
  
  //         // Fetch updated Koha patron list **once after adding students**
  //         $koharesponse = $this->get_patrons_from_koha();
  //         $koha_cardnumbers = array_column($koharesponse, 'cardnumber');
  //         $koha_patron_ids = array_column($koharesponse, 'patron_id', 'cardnumber');
  
  //         if (!isset($koha_patron_ids[$studentnumber])) {
  //             $failed_count++;
  //             continue;
  //         }
  
  //         $patron_id = $koha_patron_ids[$studentnumber];
  
  //         // Generate student password
  //         $passwordStudent = ucfirst(substr($student['first_name'], 0, 1)) . 
  //             lcfirst(substr($student['last_name'], 0, 1)) . '@' . ($student['pin'] ?? '1234');
  
  //         $student_password = [
  //             'password'   => $passwordStudent,
  //             'password_2' => $passwordStudent
  //         ];
  
  //         // Send password update
  //         curl_setopt($ch, CURLOPT_URL, "http://192.168.1.68:8080/api/v1/patrons/$patron_id/password");
  //         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($student_password));
  //         $pass_response = curl_exec($ch);
  //         $httpCodePass = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  
  //         if ($httpCodePass === 200) {
  //             $added_count++;
  //         } else {
  //             $failed_count++;
  //             $passerror_count++;
  //         }
  //     }
  
  //     curl_close($ch);
  
  //     // Flash messages
  //     if ($added_count > 0 && $passerror_count === 0) {
  //         $this->session->set_flashdata('student_scs', "$added_count student(s) added successfully to Koha Library!");
  //     }
  //     if ($failed_count > 0) {
  //         $this->session->set_flashdata('student_fail', "$failed_count students failed to be added to Koha.");
  //     }
  //     if ($added_count === 0 && $failed_count === 0) {
  //         $this->session->set_flashdata('student_neutral', 'All students already exist in Koha.');
  //     }
  
  //     redirect('master/student');
  // }

  //parallel
  public function export_to_koha()
{
    // Get students
    $students = $this->Student_model->get_students();
    if (empty($students)) {
        $this->session->set_flashdata('student_neutral', 'No students to process.');
        redirect('master/student');
        return;
    }

    // Get Koha existing patrons
    $response = $this->get_patrons_from_koha();
    if (empty($response) || !is_array($response)) {
        $this->session->set_flashdata('student_neutral', 'Invalid Koha Response. Please try again.');
        redirect('master/student');
        return;
    }

    // Extract existing Koha card numbers
    $koha_cardnumbers = array_column($response, 'cardnumber');

    // Filter only students who are NOT in Koha
    $new_students = array_filter($students, function ($student) use ($koha_cardnumbers) {
        return !in_array(preg_replace('/[^0-9]/', '', $student['srcode']), $koha_cardnumbers);
    });

    if (empty($new_students)) {
        $this->session->set_flashdata('student_neutral', 'All students already exist in Koha.');
        redirect('master/student');
        return;
    }

    $add_patrons_koha_url = $this->config->item('add_patrons');
    $koha_username = $this->config->item('koha_username');
    $koha_password = $this->config->item('koha_password');

    // Initialize Multi Curl
    $multiCurl = curl_multi_init();
    $handles = [];

    foreach ($new_students as $student) {
        $studentnumber = preg_replace('/[^0-9]/', '', $student['srcode']);
        $student_data = [
            'cardnumber'  => $studentnumber,
            'firstname'   => $student['first_name'],
            'middle_name' => $student['middle_name'] ?? null,
            'surname'     => $student['last_name'],
            'gender'      => $student['gender'],
            'email'       => $student['email'] ?? null,
            'library_id'  => 'TTL',
            'category_id' => 'ST',
            'userid'      => $student['first_name'] . $student['last_name']
        ];

        // Create individual cURL handle
        $ch = curl_init($add_patrons_koha_url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
            CURLOPT_USERPWD        => "$koha_username:$koha_password",
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($student_data)
        ]);

        // Add handle to multi-curl
        curl_multi_add_handle($multiCurl, $ch);
        $handles[] = $ch;
    }

    // Execute multi-curl requests
    $running = null;
    do {
        curl_multi_exec($multiCurl, $running);
        curl_multi_select($multiCurl);
    } while ($running > 0);

    // Collect results
    $added_count = 0;
    $failed_count = 0;
    foreach ($handles as $ch) {
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode === 201) {
            $added_count++;
        } else {
            $failed_count++;
        }
        curl_multi_remove_handle($multiCurl, $ch);
        curl_close($ch);
    }

    curl_multi_close($multiCurl);

    // Flash messages
    if ($added_count > 0) {
        $this->session->set_flashdata('student_scs', "$added_count student(s) added successfully to Koha Library!");
    }
    if ($failed_count > 0) {
        $this->session->set_flashdata('student_fail', "$failed_count students failed to be added to Koha.");
    }

    redirect('master/student');
}
  public function get_patrons_from_koha(){
      // Fetch existing patrons from Koha
      $get_patrons_koha_url = $this->config->item('get_patrons');

      $ch = curl_init($get_patrons_koha_url);
      
      curl_setopt_array($ch, [
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
          CURLOPT_USERPWD => $this->config->item('koha_username') . ":" . $this->config->item('koha_password')
      ]);

      $koha_students_response = curl_exec($ch);
      curl_close($ch);

      $response = json_decode($koha_students_response, true);

      return $response;
  }

}
