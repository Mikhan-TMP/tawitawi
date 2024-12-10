<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_value extends CI_Model {

	public function add_new($id_student,$id_course,$value) {
		$d_t_d = array(
			'id_student' => $id_student,
			'id_course' => $id_course,
			'value' => $value
		);
		$this->db->insert('value', $d_t_d);
		$this->session->set_flashdata('msg_alert', 'value berhasil ditambahkan');
	}

	public function update($id_value,$id_student,$id_course,$value) {
		$d_t_d = array(
			'id_student' => $id_student,
			'id_course' => $id_course,
			'value' => $value
		);
		$this->db->where('id_value', $id_value)->update('value', $d_t_d);
		$this->session->set_flashdata('msg_alert', 'Data value berhasil diubah');
	}

	public function delete($id) {
		$this->db->delete('value', array('id_value' => $id));
	}

	public function get_data($id) {
		$q=$this->db->select('*')->from('value')->where('id_value', $id)->limit(1)->get();
		if( $q->num_rows() < 1 ) {
			redirect( base_url('/') );
		}
		return $q->row();
	}

	public function list_all() {
		$q=$this->db->select('n.value, n.id_value, mhs.nama_student, mk.nama_course')
				->from('value as n')
				->join('student as mhs', 'n.id_student = mhs.id_student', 'LEFT')
				->join('course as mk', 'n.id_course = mk.id_course', 'LEFT')
				->get();
		return $q->result();
	}

}

/* End of file DataMaster_value.php */
/* Location: ./application/models/DataMaster_value.php */