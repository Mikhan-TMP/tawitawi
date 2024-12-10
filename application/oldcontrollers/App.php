<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App extends CI_Controller 
{
        public function __construct()
        {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->load->model('mobile_model');
        }

        public function index()
        {
                echo 'Hello World!';
        }

        public function mobile_register()
        {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('fname', 'First Name', 'required');
            $this->form_validation->set_rules('lname', 'Last Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');
            
            if($this->form_validation->run() == FALSE)
            {
            echo 'ERROR';
            }
            else
            {
            $data = array(
                'username' => $this->input->post('username'),
                'fname' => $this->input->post('fname'),
                'lname' => $this->input->post('lname'),
                'email' => $this->input->post('email'),
                'role_id' => 2, 
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
            );
            
            
            $this->db->insert('users', $data);
            }
            
        }

        public function mobile_login()
        {
            $username = $this->input->get('username');
            $password = $this->input->get('password');

            $user = $this->db->get_where('users', ['username' => $username])->row_array();

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    // $response = ['status' => 'success'];
                    echo 'success';
                } else {
                    // $response = ['status' => 'failed'];
                    echo 'failed';
                }
            } else {
                // $response = ['status' => 'no_data'];
                echo 'no data';
            }
            
        }

        public function forgot_password()
        {
            $username = $this->input->get('username');
            $email = $this->input->get('email');
            $data = $this->mobile_model->info_request($username, $email);
            if($data == NULL){
                $udata = array(
                    'status' => 'No data.',
                    'message'   => 'Please check your credentials'
                );
                echo json_encode($udata);
            }else{

                $this->session->set_userdata('user_id', $data['id']); 

                $udata = array(
                    'status' => 'success',
                    'id'    => $data['id'],
                    'username'  => $data['username'],
                    'email' => $data['email']
                );

                echo json_encode($udata);
            }
        }

        public function updatePass()
        {
            $user_id = $this->session->userdata('user_id');
            if ($user_id) {
                $password = $this->input->post('password');
                $data = array('password' => password_hash($password, PASSWORD_DEFAULT));
                $this->db->where('id', $user_id);
                $update = $this->db->update('users', $data);
        
                if ($update == true) {
                    echo 'Success';
                } else {
                    echo 'Failed';
                }
            } else {
                echo 'User ID not found';
            }
        }

}