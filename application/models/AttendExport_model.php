<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');
class AttendExport_model extends CI_Model {
	public function StudentList() {
		$this->db->select(array('qrcode', 'RFID', 'username', 'srcode', 'building', 'in_time','date'));
		$this->db->from('attend');
		$this->db->limit(500);  
		$query = $this->db->get();
		return $query->result_array();
	}
}
?>