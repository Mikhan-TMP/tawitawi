<?php 
defined('BASEPATH') or exit('No direct script access allowed');
class ProfileController extends CI_Controller {
    public function __construct() {
        parent::__construct();
        // Load required libraries and models
        $this->load->library('form_validation');
        $this->load->model('ProfileModel');  // Load the model to handle DB insertions
    }

    public function upload_image() {
        // Check if a file is uploaded
        if (isset($_FILES['imageFile']) && $_FILES['imageFile']['error'] == 0) {
            // Get the file content
            $fileContent = file_get_contents($_FILES['imageFile']['tmp_name']);
    
            // Call the model to insert the image as BLOB
            $result = $this->ProfileModel->update_image($fileContent);
    
            if ($result) {
                // Image uploaded successfully
                echo json_encode(['status' => 'success', 'message' => 'Image uploaded successfully!']);
            } else {
                // Failed to upload image
                echo json_encode(['status' => 'error', 'message' => 'Failed to upload image.']);
            }
        } else {
            // No file uploaded or error in upload
            echo json_encode(['status' => 'error', 'message' => 'No file uploaded or upload error.']);
        }
    }
    
    public function get_image($userId) {
        // Load the model
        $this->load->model('ProfileModel');
    
        // Get the image from the database (assuming the column name is `profile_image` and it's stored as BLOB)
        $imageData = $this->ProfileModel->get_image_by_user_id($userId);
    
        if ($imageData) {
            // Set the content type header based on the image type (e.g., jpeg, png)
            header("Content-Type: image/jpeg"); // Or image/png depending on your image format
            echo $imageData['profile_image']; // Output the image binary data
        } else {
            // If no image is found, return the default avatar
            redirect(base_url('images/default-avatar.png')); // Default avatar image
        }
    }
    

}

?>