<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
    $this->load->library('email');
  }

  public function index()
  {
    if ($this->session->userdata('username')) {
      switch ($this->session->userdata('role_id')) {
        case 1:
          redirect('admin');
          break;
        case 2:
          if($this->session->userdata('device') == 'desktop') {
            redirect('profile');
          }
          else {
            echo 'Trying to Login as: '.$this->session->userdata('username');
          }
          break;
      }
      
    }
    // Login Page
    $d['title'] = 'Login Page';

    // Form Validation
    $this->form_validation->set_rules('username', 'Username', 'required|trim');
    $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/auth_header', $d);
      $this->load->view('auth/index');
      $this->load->view('templates/auth_footer');
    } else {
      $this->_login();
    }
  }
  private function _login()
  {
      $username = $this->input->post('username');
      $password = $this->input->post('password');
      $device = $this->input->post('device');

      // Constants for logging purposes
      $log_succ = '00';
      $log_inc_uname = '01';
      $log_inc_pass = '02';
      $log_not_verified = '03';

      $user = $this->db->get_where('users', ['username' => $username])->row_array();

      if ($user) {
          if ($user['is_verified'] == 1 && empty($user['verification_token'])) {
              if (password_verify($password, $user['password'])) {
                  $data = [
                      'username' => $user['username'],
                      'role_id' => $user['role_id'],
                      'device' => $device
                  ];

                  $this->session->set_userdata($data);

                  switch ($user['role_id']) {
                      case 1:
                          redirect('admin');
                          break;
                      case 2:
                          if ($this->session->userdata('device') == 'desktop') {
                              redirect('profile');
                          } else {
                              echo $log_succ;
                              redirect('auth');
                          }
                          break;
                  }
              } else {
                  $this->handleLoginError($user, $log_inc_pass);
              }
          } else {
              $this->handleVerificationError($log_not_verified);
          }
      } else {
          $this->handleLoginError($user, $log_inc_uname);
      }

      if ($user) {
        } else {
        // $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong password or Invalid username!</div>');
        if($this->session->userdata('device') == 'desktop') {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong password or Invalid username!</div>');
            redirect('auth');
        }else {
            echo $log_inc_uname;
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong password or Invalid username!</div>');
            redirect('auth');
        }
        }
  }

  private function handleLoginError($user, $log_code)
  {
      switch ($user['role_id']) {
          case 1:
              $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong password!</div>');
              redirect('auth');
              break;
          case 2:
              if ($this->session->userdata('device') == 'desktop') {
                  $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong password!</div>');
                  redirect('auth');
              } else {
                  echo $log_code;
                  $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong password!</div>');
                  redirect('auth');
              }
              break;
      }
  }

  private function handleVerificationError($log_code)
  {
      if ($this->session->userdata('device') == 'desktop') {
          $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Verification is needed. Please check your email.</div>');
          redirect('auth');
      } else {
          echo $log_code;
          $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Verification is needed. Please check your email.</div>');
          redirect('auth');
      }
  }

  public function logout()
  {
    $this->session->unset_userdata('username');
    $this->session->unset_userdata('role_id');
    $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">Logged Out!</div>');
    redirect('auth');
  }

  public function changepass()
  {
    $d['title'] = 'Password Reset';

      $this->load->view('templates/auth_header', $d);
      $this->load->view('auth/changepass', $d);
      $this->load->view('templates/auth_footer');
  }

  public function forgotpassword()
  {
      $d['title'] = 'Password Reset';

      $this->load->library('email');

      $config['protocol'] = 'smtp';
      $config['smtp_host'] = 'smtp.gmail.com';
      $config['smtp_port'] = 587;
      $config['smtp_user'] = 'jmfdelarosa1@gmail.com';
      $config['smtp_pass'] = 'wnatgwkssxgawaub';
      $config['smtp_crypto'] = 'tls';
      $config['mailtype'] = 'html';
      $config['charset'] = 'utf-8';
      $config['newline'] = "\r\n";

      $this->email->initialize($config);

      $this->form_validation->set_rules('username', 'Username', 'required|trim');
      $this->form_validation->set_rules('email', 'email', 'required|trim|valid_email');

      if ($this->form_validation->run() == false) {
          $this->load->view('templates/auth_header', $d);
          $this->load->view('auth/password', $d);
          $this->load->view('templates/auth_footer');
      } else {
          $username = $this->input->post('username');
          $email = $this->input->post('email');
          $user = $this->db->get_where('users', ['username' => $username, 'email' => $email])->row_array();

          if ($user) {
              $npassword = $this->input->post('password');
              $uppercase = preg_match('@[A-Z]@', $npassword);
              $lowercase = preg_match('@[a-z]@', $npassword);
              $number    = preg_match('@[0-9]@', $npassword);
              $specialChars = preg_match('@[^\w]@', $npassword);

              if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($npassword) < 8) {
                  $this->session->set_flashdata('message', 'Please make more strong password (Combine numbers, lowercase, and uppercase letters and special characters)', TRUE);
                  redirect('auth/forgotpassword');
              }

              if ($this->input->post('password') != $this->input->post('cpassword')) {
                  $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">  Password not match!</div>');
              } else {
                  $verification_token = bin2hex(random_bytes(16));
                  $this->db->update('users', ['verification_token' => $verification_token, 'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)], ['id' => $user['id']]);
                  $rows = $this->db->affected_rows();
                  if ($rows > 0) {
                    $verification_link = base_url('auth/verification/' . $verification_token);
    
                    $this->email->from('jmfdelarosa1@gmail.com', 'Ntek Systems');
                    $this->email->to($this->input->post('email'));
                    $this->email->subject('Account Verification');
                    // $this->email->message("Please click the following link to verify your account: $verification_link");
                    $this->email->message($this->load->view('newsletter/forgot_password', array('forgot_url' => $verification_link,
                    ), true));

                    if ($this->email->send()) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert"> Password Change!, Please check your email to confirm Password Change. </div>');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert"> Error sending verification email. Please try again later. </div>');
                    }
                      // $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                      //     Successfully Update Password!</div>');
                  } else {
                      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                        Failed to edit Password!</div>');
                  }
              }
              redirect('auth');
          } else {
              $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
              Username not found!</div>');
              redirect('auth/forgotpassword');
          }
      }
  }
  public function verification($verification_token) {
    $user = $this->db->get_where('users', ['verification_token' => $verification_token])->row();

    if ($user) {
        $this->db->where('id', $user->id);
        $this->db->update('users', ['verification_token' => NULL]);

        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert"> Password Change Success! </div>');
    } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert"> Invalid verification token. </div>');
    }

    redirect('auth/index'); 
  }

  public function account()
  {
      $this->load->library('email');

      $config['protocol'] = 'smtp';
      $config['smtp_host'] = 'smtp.gmail.com';
      $config['smtp_port'] = 587;
      $config['smtp_user'] = 'jmfdelarosa1@gmail.com';
      $config['smtp_pass'] = 'wnatgwkssxgawaub';
      $config['smtp_crypto'] = 'tls';
      $config['mailtype'] = 'html';
      $config['charset'] = 'utf-8';
      $config['newline'] = "\r\n";

      $this->email->initialize($config);

      $d['title'] = 'New Account';
      $this->load->library('form_validation');

      $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]', array('is_unique' => 'The username already exists. Please choose a different one.'));
      $this->form_validation->set_rules('fname', 'First Name', 'required');
      $this->form_validation->set_rules('lname', 'Last Name', 'required');
      $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    //   $this->form_validation->set_rules(
    //     'password',
    //     'Password',
    //     'required|min_length[8]|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W)/]'
    //     );
      $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|callback_password_requirements');


      if ($this->form_validation->run() == FALSE) {
          // Form validation failed, redisplay the form
          $this->load->view('templates/auth_header', $d);
          $this->load->view('templates/auth_footer');
        //   $this->load->view('auth/account');
          $this->load->view('auth/account', ['password_errors' => $this->form_validation->error_array()]);
      } else {
          // Generate a random verification token
          $verification_token = bin2hex(random_bytes(16));

          $data = array(
              'username' => $this->input->post('username'),
              'fname' => $this->input->post('fname'),
              'lname' => $this->input->post('lname'),
              'email' => $this->input->post('email'),
              'role_id' => 2,
              'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
              'verification_token' => $verification_token,
              'is_verified' => 0,
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
                  'Seat Reservation' => 0,
              ]),
          );

          $this->db->insert('users', $data);

          $verification_link = base_url('auth/verify/' . $verification_token);

          $this->email->from('jmfdelarosa1@gmail.com', 'Ntek Systems');
          $this->email->to($this->input->post('email'));
          $this->email->subject('Account Verification');
          $this->email->message($this->load->view('newsletter/register', array('confirmation_url' => $verification_link), true));

          if ($this->email->send()) {
              $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert"> Account has been created! Please check your email to verify your account. </div>');
          } else {
              $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert"> Error sending verification email. Please try again later. </div>');
          }

          redirect('auth/index');
      }
  }

  public function password_requirements($password)
    {
        $password_errors = array();

        if (strlen($password) < 8) {
            $password_errors[] = 'The password must be at least 8 characters long.';
        }

        if (!preg_match('/\d/', $password)) {
            $password_errors[] = 'The password cannot be empty.';
        }

        if (!preg_match('/[a-z]/', $password)) {
            $password_errors[] = 'The password must contain at least one lowercase letter.';
        }

        if (!preg_match('/[A-Z]/', $password)) {
            $password_errors[] = 'The password must contain at least one uppercase letter.';
        }

        if (!preg_match('/\W/', $password)) {
            $password_errors[] = 'The password must contain at least one special character.';
        }

        if (!empty($password_errors)) {
            // Set custom error message
            $this->form_validation->set_message('password_requirements', implode('<br>', $password_errors));
            return false;
        }

        return true;
    }


  public function verify($verification_token) {
    $user = $this->db->get_where('users', ['verification_token' => $verification_token])->row();

    if ($user) {
        $this->db->where('id', $user->id);
        $this->db->update('users', ['is_verified' => 1, 'verification_token' => NULL]);

        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert"> Your account has been verified! </div>');
    } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert"> Invalid verification token. </div>');
    }

    redirect('auth/index'); 
  }
  
  public function blocked()
  {
    $d['title'] = 'Access Blocked';
    $this->load->view('auth/blocked', $d);
  }
  
}
