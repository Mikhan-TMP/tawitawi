<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_student extends CI_Model {

	public function add_new($first_name,$last_name,$srcode,
	$program,
	$rfid,$qrcode, $gender, $course,
	$schoolyear
	) {
		$d_t_d = array(
			'first_name' => $first_name,
			'last_name'  => $last_name,
			'srcode' 	 =>$srcode,
			'program' 	 =>$program,
			'rfid' 		 =>$rfid,
			'qrcode' 	 =>$qrcode,
			'gender' 	 =>$gender,
			'course' 	 =>$course,
			'schoolyear' 		=>$schoolyear

		);
		$this->db->insert('student', $d_t_d);
		$this->session->set_flashdata('msg_alert', 'Data student berhasil ditambahkan');
	}

	public function update($id,$first_name,$last_name,$srcode,$program,$rfid,$qrcode,$gender,$course,$schoolyear) {
		$d_t_d = array(
			'id' 				=>$id,
			'first_name' 		=> $first_name,
			'last_name' 		=>$last_name,
			'srcode' 			=>$srcode,
			'program' 			=>$program,
			'rfid' 				=>$rfid,
			'qrcode' 			=>$qrcode,
			'gender' 			=>$gender,
			'course' 			=>$course,
			'schoolyear' 		=>$schoolyear
		);
		$this->db->where('id', $id)->update('student', $d_t_d);
		$this->session->set_flashdata('msg_alert', '<h4><span class="badge badge-info">'.$id.'</span></h4>'.' Data Student Updated');
	}

	public function delete($id) {
		$q=$this->db->select('*')->from('student')->where('id', $id)->limit(1)->get();
		if( $q->num_rows() < 1 ) {
			redirect( base_url('/') );
		}
		$this->db->delete('student', array('id' => $id));
	}

	public function get_data($id) {
		$q=$this->db->select('*')->from('student')->where('id', $id)->limit(1)->get();
		if( $q->num_rows() < 1 ) {
			redirect( base_url('/') );
		}
		return $q->row();
	}

	public function list_all() {
		$q=$this->db->select('*')->get('student');
		return $q->result();
	}



	// Get DataTable data
	function getStudent_Search($postData=null){

		$response = array();
  
		## Read value
		$draw = $postData['draw'];
		$start = $postData['start'];
		$rowperpage = $postData['length']; // Rows display per page
		$columnIndex = $postData['order'][0]['column']; // Column index
		$columnName = $postData['columns'][$columnIndex]['data']; // Column name
		$columnSortOrder = $postData['order'][0]['dir']; // asc or desc
		$searchValue = $postData['search']['value']; // Search value
  
		// Custom search filter 
		$searchCourse = $postData['searchCourse'];
		$searchGender = $postData['searchGender'];
		$searchRFID = $postData['searchRFID'];
  
		## Search 
		$search_arr = array();
		$searchQuery = "";
		if($searchValue != ''){
			$search_arr[] = " (rfid like '%".$searchValue."%' or 
				  last_name like '%".$searchValue."%' or 
				  course like'%".$searchValue."%' ) ";
		}
		if($searchCourse != ''){
			$search_arr[] = " course='".$searchCourse."' ";
		}
		if($searchGender != ''){
			$search_arr[] = " gender='".$searchGender."' ";
		}
		if($searchRFID != ''){
			$search_arr[] = " rfid like '%".$searchRFID."%' ";
		}
		if(count($search_arr) > 0){
			$searchQuery = implode(" and ",$search_arr);
		}
  
		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$records = $this->db->get('student')->result();
		$totalRecords = $records[0]->allcount;
  
		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		if($searchQuery != '')
		$this->db->where($searchQuery);
		$records = $this->db->get('student')->result();
		$totalRecordwithFilter = $records[0]->allcount;
  
		## Fetch records
		$this->db->select('*');
		if($searchQuery != '')
		$this->db->where($searchQuery);
		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('student')->result();
  
		$data = array();
  
		foreach($records as $record ){
		   
			$data[] = array( 
				"first_name"=>$record->first_name,
				"last_name"=>$record->last_name,
				"srcode"=>$record->srcode,
				"program"=>$record->program,
				"rfid"=>$record->rfid,
				"qrcode"=>$record->qrcode,
				"gender"=>$record->gender,
				"course"=>$record->course,
				"schoolyear"=>$record->schoolyear
			); 
		}
  
		## Response
		$response = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecords,
			"iTotalDisplayRecords" => $totalRecordwithFilter,
			"aaData" => $data
		);
  
		return $response; 
	}
  
	// Get cities array
	public function getCourses(){
  
		## Fetch records
		$this->db->distinct();
		$this->db->select('course');
		$this->db->order_by('course','asc');
		$records = $this->db->get('student')->result();
  
		$data = array();
  
		foreach($records as $record ){
		   
			$data[] = $record->course;
		}
  
		return $data;
	}

}

/* End of file DataMaster_student.php */
/* Location: ./application/models/DataMaster_student.php */