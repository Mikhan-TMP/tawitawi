<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Student_model extends CI_Model
{
   public function get_students($college = 'all', $year = 'all')
        {
            $this->db->select('*');
            $this->db->from('student');

            if ($college !== 'all') {
                $this->db->where('college', $college);
            }
            if ($year !== 'all') {
                $this->db->where('schoolyear', $year);
            }

            $query = $this->db->get();
            return $query->result_array();
        }
}
