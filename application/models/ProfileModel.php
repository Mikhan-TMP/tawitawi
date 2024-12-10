<?php 
class ProfileModel extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    // Method to update profile image in database
    public function update_image($fileContent) {
        $data = array(
            'profile_image' => $fileContent
        );
    
        // Check if this is actually updating
        $this->db->where('id', 1);  // Make sure to replace this with dynamic user ID
        if ($this->db->update('users', $data)) {
            return true;
        } else {
            // Log error or debug
            log_message('error', 'Failed to update profile image.');
            return false;
        }
    }
    public function get_image_by_user_id($userId) {
        // Query to get the image for the given user ID
        $this->db->select('profile_image');
        $this->db->from('users');  // Assuming you have a `users` table where the image is stored
        $this->db->where('id', $userId);  // Make sure to use the correct column name for the user ID
    
        $query = $this->db->get();
    
        // Check if any row is returned
        if ($query->num_rows() > 0) {
            return $query->row_array();  // Return the image data (as an array)
        } else {
            return null;  // No image found for the given user ID
        }
    }
    
}
?>