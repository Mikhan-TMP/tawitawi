<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Public_model extends CI_Model
{
  public function getAccount($username)
  {
    $account = $this->db->get_where('users', ['username' => $username])->row_array();
    $e_id = $account['id'];
   /* 
    $query = "SELECT  users.id AS `id`,
                      users.username AS `name`,
                      users.image AS 'image', 
                      location.id AS `department_id`
                FROM  users
          INNER JOIN  location ON users.id = location.id
               WHERE `users`.`id` = '$e_id'";
    */
    $query = "SELECT  users.id AS `id`,
                      users.username AS `name`,
                      users.image AS 'image'
                FROM  users
               WHERE `users`.`id` = '$e_id'";
    
    return $this->db->query($query)->row_array();

  }

  public function getAccount2($username)
  {
    $account = $this->db->get_where('users', ['username' => $username])->row_array();
    $e_id = $account['employee_id'];
    $query = "SELECT  user.id AS `id`,
                      employee.name AS `name`,
                      employee.gender AS `gender`,   
                      employee.shift_id AS `shift`,
                      employee.image AS `image`,
                      employee.birth_date AS `birth_date`,
                      employee.hire_date AS `hire_date`,
                      department.id AS `department_id`
                FROM  user
          INNER JOIN  employee_department ON employee.id = employee_department.employee_id
          INNER JOIN  department ON employee_department.department_id = department.id
               WHERE `employee`.`id` = '$e_id'";
    return $this->db->query($query)->row_array();
  }

  public function getSrcodeQ($id)
  {
      // $query = "SELECT srcode FROM  student WHERE qrcode='$id'";   
      $query = $this->db->query("SELECT srcode FROM student WHERE qrcode = '".$id."' ");       
      $row= $query->row();            
      if($row != NULL){
        return($row->srcode); 
      }else{
        return(NULL);
      }
  }
  public function getSrcodeR($id)
  {
      // $query = "SELECT srcode FROM  student WHERE rfid ='$id' "; 
      $query = $this->db->query("SELECT srcode FROM student WHERE rfid = '".$id."' "); 
      $row= $query->row();            
      $Srcode=$row->srcode; 
      if($row != NULL){
        return($row->srcode); 
      }else{
        return(NULL);
      }
  }

  public function get_attendance($start, $end, $dept)
  {
    $query = "SELECT  attendance.in_time AS date,
                      attendance.shift_id AS shift,
                      employee.name AS name,
                      attendance.notes AS notes,
                      attendance.image AS image,
                      attendance.lack_of AS lack_of,
                      attendance.in_status AS in_status,
                      attendance.out_time AS out_time,
                      attendance.out_status AS out_status,
                      attendance.employee_id AS e_id
                FROM  attendance
          INNER JOIN  employee_department
                  ON  attendance.employee_id = employee_department.employee_id
          INNER JOIN  employee
                  ON  attendance.employee_id = employee.id
                WHERE  employee_department.department_id = '$dept'
                  AND  (DATE(FROM_UNIXTIME(in_time)) BETWEEN '$start' AND '$end')
            ORDER BY  `date` ASC";

    return $this->db->query($query)->result_array();
  }
  
  public function get_attendance_all()
  {
       
    $query = "SELECT  attend.qrcode, 
                attend.RFID, 
                attend.srcode, 
                attend.building, 
                attend.in_time,
                attend.date,
                student.first_name AS 'fname',
                student.last_name AS 'lname'    
    FROM  attend
    INNER JOIN  student
    ON  attend.srcode = student.srcode
    WHERE  1 
    ORDER BY attend.date DESC 
    LIMIT  200";

    return $this->db->query($query)->result_array();
  }
  public function get_attendfaculty_all()
  {
       
    $query = "SELECT  attend_faculty.qrcode, 
                attend_faculty.RFID, 
                attend_faculty.srcode, 
                attend_faculty.building, 
                attend_faculty.in_time,
                attend_faculty.date,
                faculty.first_name AS 'fname',
                faculty.last_name AS 'lname'    
    FROM  attend_faculty
    INNER JOIN  faculty
    WHERE  1 
    ORDER BY attend_faculty.date DESC 
    LIMIT  200";

    return $this->db->query($query)->result_array();
  }
  
  public function get_attend_verify($date,$srcode)
  {
    
      $query = "SELECT  *  
                FROM  attend
                WHERE srcode = '$srcode' AND date = '$date'  ";
    
    return $this->db->query($query)->num_rows();
       
  }
  public function get_attendfaculty_verify($date,$srcode)
  {
    
      $query = "SELECT  *  
                FROM  attend_faculty
                WHERE srcode = '$srcode' AND date = '$date'  ";
    
    return $this->db->query($query)->num_rows();
       
  }
  public function  get_attend()  
  {
    
    $query = "SELECT  attend.category, 
      attend.username AS 'username', 
      attend.srcode, 
      attend.floor, 
      attend.kiosk AS 'kiosk', 
      attend.in_time,
      attend.out_time,
      attend.date,
      student.college AS 'college',
      student.course AS 'course',
      student.gender AS 'gender'    
      FROM  attend
      INNER JOIN  student
      ON  attend.srcode = student.srcode
      WHERE  1
      ORDER BY  `date` DESC";

    return $this->db->query($query)->result_array();
    /*   
    $query = "SELECT  *  FROM  attend WHERE 1 ORDER BY  `date` DESC ";    
    return $this->db->query($query)->result_array();    
    */
  }
  public function  get_attend_course($course)  
  {
    
    $query = "SELECT  attend.category, 
      attend.username AS 'username', 
      attend.srcode, 
      attend.floor, 
      attend.kiosk AS 'kiosk', 
      attend.in_time,
      attend.out_time,
      attend.date,
      student.college AS 'college',
      student.course AS 'course',
      student.gender AS 'gender'    
      FROM  attend
      INNER JOIN  student
      ON  attend.srcode = student.srcode 
      WHERE  student.course = '$course'
      ORDER BY  `date` DESC";

    return $this->db->query($query)->result_array();    
  }
  public function  get_attend_name($name)  
  {
    
    $query = "SELECT  attend.category, 
      attend.username, 
      attend.srcode, 
      attend.floor, 
      attend.kiosk, 
      attend.in_time,
      attend.out_time,
      attend.date,
      student.course AS 'course',
      student.gender AS 'gender'    
      FROM  attend
      INNER JOIN  student
      ON  attend.srcode = student.srcode 
      WHERE   attend.username = '$name'
      ORDER BY  `date` DESC";

    return $this->db->query($query)->result_array();    
  }
  public function  get_attend_srcode($srcode)  
  {
    
    $query = "SELECT  attend.category, 
      attend.username, 
      attend.srcode, 
      attend.floor, 
      attend.kiosk, 
      attend.in_time,
      attend.out_time,
      attend.date,
      student.course AS 'course',
      student.gender AS 'gender'    
      FROM  attend
      INNER JOIN  student
      ON  attend.srcode = student.srcode 
      WHERE  attend.srcode = $srcode
      ORDER BY  `date` DESC";

    return $this->db->query($query)->result_array();    
  }




  public function get_attend_filter($start, $end, $dept)
  {
    if($dept == '0'){
      $query = "SELECT  attend.qrcode, 
          attend.RFID, 
          attend.srcode, 
          attend.building, 
          attend.in_time,
          attend.date,
          student.first_name AS 'fname',
          student.last_name AS 'lname'    
      FROM  attend
      INNER JOIN  student
      ON  attend.srcode = student.srcode
      WHERE  (attend.date  BETWEEN '$start' AND '$end')
      ORDER BY  `date` DESC";
    }
    else{
      $query = "SELECT  attend.qrcode, 
                  attend.RFID, 
                  attend.srcode, 
                  attend.building, 
                  attend.in_time,
                  attend.date,
                  student.first_name AS 'fname',
                  student.last_name AS 'lname'    
      FROM  attend
      INNER JOIN  student
      ON  attend.srcode = student.srcode
      WHERE  attend.building = '$dept'   
      AND (attend.date  BETWEEN '$start' AND '$end')
      ORDER BY  `date` DESC";
    }      
      
    return $this->db->query($query)->result_array();
  }
  public function get_attendcount($start, $end, $dept)
  {
    if($dept == '0'){
        $query = "SELECT  '*'
                FROM  attend                
                WHERE  (attend.date  BETWEEN '$start' AND '$end') ";
    }
    else{
      $query = "SELECT  '*'
                FROM  attend
                WHERE  attend.building = '$dept'   
                AND (attend.date  BETWEEN '$start' AND '$end') ";
    }      
      
    return $this->db->query($query)->num_rows();
  }
  public function get_studentdaycount($start,$dept)
  {
    if($dept == '0'){
      $query = "SELECT  *  
                FROM  attend
                WHERE  attend.date = '$start'  ";
    }
    else{
      $query = "SELECT * 
                FROM  attend
                WHERE  attend.building = '$dept'   
                AND attend.date = '$start'  ";
    }          
    return $this->db->query($query)->num_rows();
  }
  public function get_attendfaculty($start, $end, $dept)
  {
    if($dept == '0'){
      $query = "SELECT  attend_faculty.qrcode, 
          attend_faculty.RFID, 
          attend_faculty.srcode, 
          attend_faculty.building, 
          attend_faculty.in_time,
          attend_faculty.date,
          faculty.first_name AS 'fname',
          faculty.last_name AS 'lname'    
      FROM  attend_faculty
      INNER JOIN  faculty
      ON  attend_faculty.srcode = faculty.srcode
      WHERE  (attend_faculty.date  BETWEEN '$start' AND '$end')
      ORDER BY  `date` DESC";
    }
    else{
      $query = "SELECT  attend_faculty.qrcode, 
                  attend_faculty.RFID, 
                  attend_faculty.srcode, 
                  attend_faculty.building, 
                  attend_faculty.in_time,
                  attend_faculty.date,
                  faculty.first_name AS 'fname',
                  faculty.last_name AS 'lname'    
      FROM  attend_faculty
      INNER JOIN  faculty
      ON  attend_faculty.srcode = faculty.srcode
      WHERE  attend_faculty.building = '$dept'   
      AND (attend_faculty.date  BETWEEN '$start' AND '$end')
      ORDER BY  `date` DESC ";
    }      
      
    return $this->db->query($query)->result_array();
  }
  public function get_facultycount($start, $end, $dept)
  {
    if($dept == '0'){
      $query = "SELECT  *  
                FROM  attend_faculty
                WHERE  (attend_faculty.date  BETWEEN '$start' AND '$end') ";
    }
    else{
      $query = "SELECT * 
                FROM  attend_faculty
                WHERE  attend_faculty.building = '$dept'   
                AND (attend_faculty.date  BETWEEN '$start' AND '$end') ";
              }      
      
    return $this->db->query($query)->num_rows();
  
  }
  public function get_attenddaycount($start,$floor)
  {
    if($floor ==  null){
      $query = "SELECT  *  
                FROM  attend
                WHERE  attend.date = '$start'  ";
    }
    else{
      $query = "SELECT * 
                FROM  attend
                WHERE  attend.floor = '$floor'   
                AND attend.date = '$start'  ";
    }          
    return $this->db->query($query)->num_rows();
  }
  public function get_bookingdaycount($start,$floor)
  {
    if($floor == NULL){
      $query = "SELECT  *  
                FROM  booking
                WHERE  booking.date = '$start'  ";
    }
    else{
      $query = "SELECT * 
                FROM  booking
                WHERE  booking.floor = '$floor'   
                AND booking.date = '$start'  ";
    }          
    return $this->db->query($query)->num_rows();
  }
  public function get_facultydaycount($start,$dept)
  {
    if($dept == '0'){
      $query = "SELECT  *  
                FROM  attend_faculty
                WHERE  attend_faculty.date = '$start'  ";
    }
    else{
      $query = "SELECT * 
                FROM  attend_faculty
                WHERE  attend_faculty.building = '$dept'   
                AND attend_faculty.date = '$start'  ";
    }          
    return $this->db->query($query)->num_rows();
  }
  public function get_print_all()
  {
   
    
      $query = "SELECT  attend.qrcode, 
                  attend.RFID, 
                  attend.srcode, 
                  attend.building, 
                  attend.in_time,
                  student.first_name AS 'fname',
                  student.last_name AS 'lname'    
      FROM  attend
      INNER JOIN  student
      ON  attend.srcode = student.rfid
      WHERE  1 ";

    return $this->db->query($query)->result_array();
  }
  public function getAllEmployeeData($username)
  {
    // get employee id from users table
    $data = $this->db->get_where('users', ['username' => $username])->row_array();
    $e_id = $data['id'];
    $query = "SELECT  users.id AS `id`,
          users.username AS `name`,
          users.image AS `image`
      FROM  users
      WHERE  username = '$username'";
    // Join Query
    /*
    $query = "SELECT  employee.id AS `id`,
                      employee.name AS `name`,
                      employee.gender AS `gender`,
                      employee.image AS `image`,
                      employee.birth_date AS `birth_date`,
                      employee.hire_date AS `hire_date`,
                      department.name AS `department`
                FROM  employee
          INNER JOIN  employee_department ON employee.id = employee_department.employee_id
          INNER JOIN  department ON employee_department.department_id = department.id
               WHERE `employee`.`id` = $e_id";
    // get employee data from employee table using employee id and return the row
    */
    return $this->db->query($query)->row_array();
  }
  public function get_book_room_all()
  {
       
    $query = "SELECT * FROM  roombooklog WHERE  1 ORDER BY date DESC LIMIT 400";
    return $this->db->query($query)->result_array();
  }
  public function get_book_room($start, $end)
  {
    $query = "SELECT * FROM  roombooklog  
      WHERE  (roombooklog.date  BETWEEN '$start' AND '$end')
      ORDER BY  `date` DESC ";
      
    return $this->db->query($query)->result_array();
  }
  public function get_room_book_room($start, $end, $room)
  {
    
    $query = "SELECT * FROM  roombooklog   
      WHERE  (roombooklog.date  BETWEEN '$start' AND '$end') AND (roombooklog.room ='$room')
      ORDER BY  `date` DESC ";      
    return $this->db->query($query)->result_array();
  }


  public function get_book_all()
  {
       
    $query = "SELECT  booking.code, 
                student.first_name AS 'fname',
                student.last_name AS 'lname', 
                booking.id AS 'id',   
                booking.floor, 
                booking.room, 
                booking.slot_id, 
                booking.date,
                booking.in_status,
                booking.out_status,
                booking.start_time,
                booking.end_time,
                booking.in_time,
                booking.out_time
    FROM  booking
    INNER JOIN  student
    ON  booking.code = student.rfid OR booking.code = student.qrcode
    WHERE  1 
    ORDER BY booking.date DESC 
    LIMIT  400 ";

    return $this->db->query($query)->result_array();
  }
  public function get_room_atd($room)
  {
    
      $query = "SELECT  booking.code, 
                student.first_name AS 'fname',
                student.last_name AS 'lname' ,
                booking.id AS 'id',    
                booking.floor, 
                booking.room, 
                booking.slot_id, 
                booking.date,
                booking.start_time,
                booking.end_time,
                booking.in_status,
                booking.out_status,
                booking.in_time,
                booking.out_time  
      FROM  booking
      INNER JOIN  student
      ON booking.code = student.rfid OR booking.code = student.qrcode
      WHERE  (booking.room ='$room')
      ORDER BY  `date` DESC ";
      
    return $this->db->query($query)->result_array();
  }
  public function get_book($start, $end)
  {
    
      $query = "SELECT  booking.code, 
                student.first_name AS 'fname',
                student.last_name AS 'lname' , 
                booking.id AS 'id',   
                booking.floor, 
                booking.room, 
                booking.slot_id, 
                booking.date,
                booking.start_time,
                booking.in_status,
                booking.out_status,
                booking.end_time,
                booking.in_time,
                booking.out_time  
      FROM  booking
      INNER JOIN  student
      ON booking.code = student.rfid OR booking.code = student.qrcode
      WHERE  (booking.date  BETWEEN '$start' AND '$end')
      ORDER BY  `date` DESC ";
      
    return $this->db->query($query)->result_array();
  }
  public function get_room_book($start, $end, $room)
  {
    
      $query = "SELECT  booking.code, 
                student.first_name AS 'fname',
                student.last_name AS 'lname' ,  
                booking.id AS 'id',  
                booking.floor, 
                booking.room, 
                booking.slot_id, 
                booking.date,
                booking.start_time,
                booking.end_time,
                booking.in_status,
                booking.out_status,
                booking.in_time,
                booking.out_time  
      FROM  booking
      INNER JOIN  student
      ON booking.code = student.rfid OR booking.code = student.qrcode
      WHERE  (booking.date  BETWEEN '$start' AND '$end') AND (booking.room ='$room')
      ORDER BY  `date` DESC ";      
    return $this->db->query($query)->result_array();
  }
  public function get_monthbook($year)
  {
    
    if($year >2022){
      for ($month =1 ; $month <13;$month++){
          for($floor=0;$floor<7; $floor++){          
            $query = "SELECT * FROM booking WHERE YEAR(`date`) = $year AND MONTH(`date`) = $month AND floor= $floor+1 ";  
            echo '<br>'.$month.$floor.': ';                    
            $tractdata[$month][$floor]=$this->db->query($query)->num_rows();
            echo $tractdata[$month][$floor];
          }
      }
      return $tractdata;

    }    
    else 
      return null;
  }
  public function get_daybook($year,$month)
  {
    
    if($year >2022 && $month >0 ){
      for ($day =1 ; $day <31;$day++){
          for($floor=0;$floor<7; $floor++){          
            $query = "SELECT * FROM booking WHERE YEAR(`date`) = $year AND MONTH(`date`) = $month AND DAY(`date`) = $day  AND floor= $floor+1 ";  
            echo '<br>'.$day.$floor.': ';                    
            $tractdata[$day][$floor]=$this->db->query($query)->num_rows();
            echo $tractdata[$day][$floor];
          }
      }
      return $tractdata;
    }    
    else 
      return null;
  }
  public function get_timebook($year,$month,$day)
  {    
    if($year >2022 && $month >0 && $day >0 ){      
          for($floor=0;$floor<7; $floor++){          
            $query = "SELECT * FROM booking WHERE YEAR(`date`) = $year AND MONTH(`date`) = $month AND DAY(`date`) = $day  AND floor= $floor+1 ";  
            echo '<br>'.$floor.': ';                    
            $tractdata[$floor]=$this->db->query($query)->num_rows();
            echo $tractdata[$floor];
          }      
      return $tractdata;
    }    
    else 
      return null;
  }
  public function getCourse()
  {
    $query = "SELECT DISTINCT `course` FROM `student` WHERE 1 ";
    return $this->db->query($query)->result_array();    
  }
  public function getCollege()
  {
    $query = "SELECT DISTINCT `college` FROM `student` WHERE 1 ";
    return $this->db->query($query)->result_array();    
  }
  public function getKiosk()
  {
    $query = "SELECT DISTINCT `kiosk` FROM `attend` WHERE 1 ";
    return $this->db->query($query)->result_array();    
  }


  public function getTransaction($start, $end, $room){
    $query = $this->db->select('booking.id, booking.room, booking.floor, booking.slot_id, booking.date, booking.in_time, booking.out_time, booking.start_time, booking.end_time, booking.code, booking.in_status, booking.out_status')
                  ->from('booking');
    if ($room == null || $room == "" && $start == null || $start == "" && $end == null || $end == "") {
      return $query->get()->result_array();
    }
    else if ($room != null && $start == null && $end == null) {
      $this->db->where('booking.room', $room);
      return $query->get()->result_array();
    }
    else if ($room !=null && $start != null && $end != null) {
      $this->db->where('booking.room', $room);
      $this->db->where('booking.date >=', $start);
      $this->db->where('booking.date <=', $end);
      return $query->get()->result_array();
    }
 
  }
}
