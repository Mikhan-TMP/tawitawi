<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
    class Import_model extends CI_Model {
 
        public function __construct()
        {
            $this->load->database();
        }
        
        public function importData($data) {
  
            $res = $this->db->insert_batch('student',$data);
            if($res){
                return TRUE;
            }else{
                return FALSE;
            }
      
        }
        public function importFacultyData($data) {
  
            $res = $this->db->insert_batch('faculty',$data);
            if($res){
                return TRUE;
            }else{
                return FALSE;
            }
      
        }
    }
?>