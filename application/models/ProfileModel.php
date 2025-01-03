<?php 
class ProfileModel extends CI_Model
{
    public function update_profile_image($data)
    {
        $this->db->where('id', $data['id']);
        return $this->db->update('users', ['image' => $data['image']]);
    }
    public function get_image($id)
    {
        $this->db->select('image');
        $this->db->from('users');
        $this->db->where('id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return false;
    }

}

?>