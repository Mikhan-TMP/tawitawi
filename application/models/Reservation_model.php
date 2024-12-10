<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reservation_model extends CI_Model
{
  public function getUserInfo()
  {
    $this->db->select('*');
    $this->db->from('student');

    $query = $this->db->get();
    return $query;
  }
  public function getUserInfoBySname($last_name, $studentID)
  {
    $this->db->select('*');
    $this->db->from('student');
    $this->db->where('last_name', $last_name);
    $this->db->where('srcode', $studentID);

    $query = $this->db->get();
    return $query;
  }
  public function getUserInfoBySID($studentID)
  {
    $this->db->select('*');
    $this->db->from('student');
    $this->db->where('srcode', $studentID);

    $query = $this->db->get();
    return $query;
  }
  public function getBooking($srcode)
  {
      $this->db->select('*');
      $this->db->from('booking');
      $this->db->where('code', $srcode);
      $this->db->order_by('id', 'DESC'); 
      $this->db->limit(1); 

      $query = $this->db->get();
      return $query;
  }
  public function getUserInfoByCode($srcode)
  {
    $this->db->select('*');
    $this->db->from('student');
    $this->db->where('srcode', $srcode);

    $query = $this->db->get();
    if($query -> num_rows > 0){
      return $query->row_array();
    } else {
      return false;
    }
    
  }

  public function getUserByCode($code){
    $this->db->select('*');
    $this->db->from('student');
    $this->db->where('srcode', $code);
    $queryGet = $this->db->get();

    if($queryGet->num_rows() > 0){
      return $queryGet->row_array();
    }else{
      return false;
    }
  }
}