<?php
class Faculty_import_model extends CI_Model
{
	function select()
	{
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get('faculty');
		return $query;
	}

	function insert($data)
	{
		$this->db->insert_batch('faculty', $data);
	}
}
