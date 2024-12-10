<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Import extends CI_Controller {
    public function __construct() {
        parent::__construct();
        // load model
        $this->load->model('Import_model', 'import');
        $this->load->helper(array('url','html','form'));
        $this->load->library('PHPExcel.php');
        $this->load->library('form_validation');
        $this->load->model('Public_model');
        $this->load->model('Admin_model');    
    }    
 
    public function index() {
    }
 
    public function import_Student_File(){
  
      if ($this->input->post('submit')) {
                 
                $path = 'assets/uploads/studentUploads/';
                require_once APPPATH . "/libraries/PHPExcel.php";
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'xlsx|xls|csv';
                $config['remove_spaces'] = TRUE;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);            
                if (!$this->upload->do_upload('uploadFile')) {
                    $error = array('error' => $this->upload->display_errors());
                } else {
                    $data = array('upload_data' => $this->upload->data());
                }
                if(empty($error)){
                  if (!empty($data['upload_data']['file_name'])) {
                    $import_xls_file = $data['upload_data']['file_name'];
                } else {
                    $import_xls_file = 0;
                }
                $inputFileName = $path . $import_xls_file;
                 
                try {
                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                    $flag = true;
                    $i=0;
                    foreach ($allDataInSheet as $value) {
                      if($flag){
                        $flag =false;
                        continue;
                      }
                      $inserdata[$i]['srcode'] = $value['A'];
                      $inserdata[$i]['last_name'] = $value['B'];
                      $inserdata[$i]['first_name'] = $value['C'];
                      $inserdata[$i]['middle_name'] = $value['D'];
                      $inserdata[$i]['college'] = $value['E'];
                      $inserdata[$i]['course'] = $value['F'];
                      $inserdata[$i]['email'] = $value['G'];
                      $inserdata[$i]['photo'] = $value['H'];
                      $inserdata[$i]['campus'] = $value['I'];
                      $inserdata[$i]['gender'] = $value['J'];
                      // $inserdata[$i]['qrcode'] = $value['J'];
                      // $inserdata[$i]['rfid'] = $value['K'];
                      // $inserdata[$i]['gender'] = $value['L'];
                      // $inserdata[$i]['schoolyear'] = $value['M'];
                      $i++;
                    }               
                    $result = $this->import->importData($inserdata);   
                    if($result){
                      $this->session->set_flashdata('success_message', 'Student Files Uploaded Successfully!');
                        redirect('master/student');
                    }else{
                      $this->session->set_flashdata('failed_message', 'Student Files Upload Failed!');
                      redirect('master/student');
                    }             
      
              } catch (Exception $e) {
                   die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                            . '": ' .$e->getMessage());
                }
              }else{
                  echo $error['error'];
                }
                 
                 
        }
        
    }
    public function import_Faculty_File(){
  
      if ($this->input->post('submit')) {
                 
                $path = 'assets/uploads/facultyUploads/';
                require_once APPPATH . "/libraries/PHPExcel.php";
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'xlsx|xls|csv';
                $config['remove_spaces'] = TRUE;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);            
                if (!$this->upload->do_upload('uploadFile')) {
                    $error = array('error' => $this->upload->display_errors());
                } else {
                    $data = array('upload_data' => $this->upload->data());
                }
                if(empty($error)){
                  if (!empty($data['upload_data']['file_name'])) {
                    $import_xls_file = $data['upload_data']['file_name'];
                } else {
                    $import_xls_file = 0;
                }
                $inputFileName = $path . $import_xls_file;
                 
                try {
                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                    $flag = true;
                    $i=0;
                    foreach ($allDataInSheet as $value) {
                      if($flag){
                        $flag =false;
                        continue;
                      }
                      $inserdata[$i]['first_name'] = $value['A'];
                      $inserdata[$i]['last_name'] = $value['B'];
                      $inserdata[$i]['middle_name'] = $value['C'];
                      $inserdata[$i]['srcode'] = $value['D'];
                      $inserdata[$i]['course'] = $value['E'];
                      $inserdata[$i]['rfid'] = $value['F'];
                      $inserdata[$i]['qrcode'] = $value['G'];
                      $inserdata[$i]['gender'] = $value['H'];
                      $inserdata[$i]['college'] = $value['I'];
                      $inserdata[$i]['campus'] = $value['J'];
                      $i++;
                    }               
                    $result = $this->import->importFacultyData($inserdata);   
                    if($result){
                      $this->session->set_flashdata('success_message', 'Faculty Files Uploaded Successfully!');
                        redirect('master/faculty');
                    }else{
                      $this->session->set_flashdata('failed_message', 'Faculty Files Upload Failed!');
                      redirect('master/faculty');
                    }             
      
              } catch (Exception $e) {
                   die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                            . '": ' .$e->getMessage());
                }
              }else{
                  echo $error['error'];
                }
                 
                 
        }
        
    }
     
}
?>