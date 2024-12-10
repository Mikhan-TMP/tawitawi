<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notif_model extends CI_Model {
    public function notifications($type, $data){
        date_default_timezone_set('Asia/Manila');
      
        if ($type === 'add student'){
          $notificationData = [
            'message' => 'Student ' . $data['srcode'] . ' was added to the database.', 
            'type'    => $type ,
            'status'  => 'unread',
            'created_at' => date('Y-m-d H:i:s'),
            'url' => 'master/student',
          ];
        }
      
        if ($type === 'add area'){
          $notificationData = [
            'message' => 'Area ' . $data['room']. ' on floor ' . $data['floor'] .' was added to the database.', 
            'type'    => $type,
            'status'  => 'unread',
            'created_at' => date('Y-m-d H:i:s'),
            'url' => 'master/area',
          ];
        }
      
        if($type === 'add faculty'){
          $notificationData = [
            'message' => 'Faculty ' . $data['first_name']. ' ' . $data['last_name'] . ' was added to the database.', 
            'type'    => $type,
            'status'  => 'unread',
            'created_at' => date('Y-m-d H:i:s'),
            'url' => 'master/faculty',
          ];
        }
      
        if($type === 'add users'){
          $notificationData = [
            'message' => 'Librarian ' . $data['f_name']. ' ' . $data['l_name'] . ' was added to the database.', 
            'type'    => $type,
            'status'  => 'unread',
            'created_at' => date('Y-m-d H:i:s'),
            'url' => 'master/users',
          ];
        }
      
        if($type === 'stud_timein'){
          $notificationData = [
            'message' => 'Student '. $data['username'].' has checked in at kisok '. $data['kiosk'], 
            'type'    => $type,
            'status'  => 'unread',
            'created_at' => date('Y-m-d H:i:s'),
            'url' => 'attendance',
          ]; 
        }
              
        if($type === 'stud_timeout'){
            $notificationData = [
              'message' => 'Student '. $data['username'].' has checked out at kisok '. $data['kiosk'], 
              'type'    => $type,
              'status'  => 'unread',
              'created_at' => date('Y-m-d H:i:s'),
              'url' => 'attendance',
            ]; 
          }
        
        $this->db->insert('notifications', $notificationData);
      }
      public function getNotifications() {
        // Fetch all notifications, regardless of status
        $this->db->order_by('created_at', 'DESC');
        $notifications = $this->db->get('notifications')->result_array(); // Fetch as array
        echo json_encode($notifications);
        exit;
      }
      public function getUnreadNotifications() {
        $this->db->where('status', 'unread');
        $this->db->order_by('created_at', 'DESC');
        $notifications = $this->db->get('notifications')->result_array(); // Fetch as array
        echo json_encode($notifications);
        exit;
      }
      
      public function markAsRead() {
        $notificationId = $this->input->post('id'); // Get the notification ID from the request
      
        if ($notificationId) {
            // Update the notification's status to 'read' in the database
            $this->db->where('id', $notificationId);
            $this->db->update('notifications', ['status' => 'read']);

            // Optionally, send a success response
            echo json_encode(['status' => 'success']);
        } else {
            // Handle error if no ID is provided
            echo json_encode(['status' => 'error']);
        }
      }
}