<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_Faculty extends CI_Model {

	public function add_new($first_name,$last_name,$srcode,$gender,$qrcode,$rfid,$course) {
		$d_t_d = array(
			'first_name' => $first_name,
			'last_name'  => $last_name,
			'srcode' 	 =>$srcode,
			'gender' 	 =>$gender,
			'qrcode' 	 =>$qrcode,
			'rfid' 		 =>$rfid,
			'course' 	 =>$course,

		);
		$this->db->insert('faculty', $d_t_d);
		$this->session->set_flashdata('msg_alert', 'Data faculty berhasil ditambahkan');
	}

	public function update($id,$first_name,$last_name,$srcode,$gender,$qrcode,$rfid,$course) {
		$d_t_d = array(
			'id' 				=>$id,
			'first_name' 		=> $first_name,
			'last_name' 		=>$last_name,
			'srcode' 			=>$srcode,
			'gender' 			=>$gender,
			'qrcode' 			=>$qrcode,
			'rfid' 				=>$rfid,
			'course' 			=>$course,
		);
		$this->db->where('id', $id)->update('faculty', $d_t_d);
		$this->session->set_flashdata('msg_alert', '<h4><span class="badge badge-info">'.$id.'</span></h4>'.' Data faculty Updated');
	}

	public function delete($id) {
		$q=$this->db->select('*')->from('faculty')->where('id', $id)->limit(1)->get();
		if( $q->num_rows() < 1 ) {
			redirect( base_url('/') );
		}
		$this->db->delete('faculty', array('id' => $id));
	}

	public function get_data($id) {
		$q=$this->db->select('*')->from('faculty')->where('id', $id)->limit(1)->get();
		if( $q->num_rows() < 1 ) {
			redirect( base_url('/') );
		}
		return $q->row();
	}

	public function list_all() {
		$q=$this->db->select('*')->get('faculty');
		return $q->result();
	}

}

/* End of file DataMaster_faculty.php */
/* Location: ./application/models/DataMaster_faculty.php */