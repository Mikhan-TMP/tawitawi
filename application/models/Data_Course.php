<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_course extends CI_Model {

	public function add_new($name) {
		$d_t_d = array(
			'name_course' => $name
		);
		$this->db->insert('course', $d_t_d);
		$this->session->set_flashdata('msg_alert', 'Data course added');
	}

	public function update($id,$name) {
		$d_t_d = array(
			'name_course' => $name
		);
		$this->db->where('id_course', $id)->update('course', $d_t_d);
		$this->session->set_flashdata('msg_alert', 'Data course updated');
	}

	public function delete($id) {
		$this->db->delete('course', array('id_course' => $id));
	}

	public function get_data($id) {
		$q=$this->db->select('*')->from('course')->where('id_course', $id)->limit(1)->get();
		if( $q->num_rows() < 1 ) {
			redirect( base_url('/') );
		}
		return $q->row();
	}

	public function list_all() {
		$q=$this->db->select('*')->get('course');
		return $q->result();
	}

}

/* End of file DataMaster_course.php */
/* Location: ./application/models/DataMaster_course.php */