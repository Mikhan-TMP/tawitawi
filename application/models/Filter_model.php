<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Filter_model extends CI_Model {

  // Get DataTable data
  function getUsers($postData=null){

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
      $searchCity = $postData['searchCity'];
      $searchGender = $postData['searchGender'];
      $searchName = $postData['searchName'];

      ## Search 
      $search_arr = array();
      $searchQuery = "";
      if($searchValue != ''){
          $search_arr[] = " (first_name like '%".$searchValue."%' or 
          last_name like '%".$searchValue."%' or 
          srcode like'%".$searchValue."%' or 
          program like '%".$searchValue."%' or 
          rfid like'%".$searchValue."%' or 
          qrcode like '%".$searchValue."%' or 
          gender like'%".$searchValue."%' or 
          course like '%".$searchValue."%' or 
          schoolyear like'%".$searchValue."%'
                
                
                ) ";
      }
      if($searchCity != ''){
          $search_arr[] = " course='".$searchCity."' ";
      }
      if($searchGender != ''){
          $search_arr[] = " gender='".$searchGender."' ";
      }
      if($searchName != ''){
          $search_arr[] = " rfid like '%".$searchName."%' ";
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
  public function getCities(){

    $query = "SELECT DISTINCT `course` FROM `student` WHERE 1 ";
    return $this->db->query($query)->result_array();
  }

}