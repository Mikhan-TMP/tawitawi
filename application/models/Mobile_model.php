<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mobile_model extends CI_Model
{
    public function info_request($username, $email)
    {
        $this->db->select('*');
        $this->db->where('username', $username);
        $this->db->where('email', $email);
        $this->db->from('users');

        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->row_array();
        }else
        {
            return False;
        }
    }
}