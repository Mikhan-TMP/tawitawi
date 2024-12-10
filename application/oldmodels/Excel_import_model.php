<?php
class Excel_import_model extends CI_Model
{
	function select_student()
	{
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get('student');
		return $query;
	}

	function insert_student($data)
	{
		$result= $this->db->insert_batch('student', $data);
		if($result)
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}
	function select_faculty()
	{
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get('faculty');
		return $query;
	}

	function insert_faculty($data)
	{
		$result= $this->db->insert_batch('faculty', $data);
		if($result)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
