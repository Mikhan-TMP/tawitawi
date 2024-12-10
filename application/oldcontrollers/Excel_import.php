<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Excel_import extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('excel_import_model');		
		$this->load->library('excel');		
	}

	function index()
	{
		$this->load->view('excel_import');		
	}
	
	function fetch()
	{
		$data = $this->excel_import_model->select();
		$output = '
		<h3 align="center">Total Data - '.$data->num_rows().'</h3>
		<table class="table table-striped table-bordered">
			<tr>
				<th>id</th>
				<th>first name</th>
				<th>middle name</th>
				<th>last name</th>
				<th>srcode</th>				
				<th>rfid</th>
				<th>qrcode</th>                      
				<th>gender</th>
				<th>course</th>
				<th>school year</th>
			</tr>
		';
		foreach($data->result() as $row)
		{
			$output .= '
			<tr>
				<td>'.$row->id.'</td>
				<td>'.$row->first_name.'</td>
				<td>'.$row->middle_name.'</td>
				<td>'.$row->last_name.'</td>
				<td>'.$row->srcode.'</td>				
				<td>'.$row->rfid.'</td>
				<td>'.$row->qrcode.'</td>
				<td>'.$row->gender.'</td>
				<td>'.$row->course.'</td>
				<td>'.$row->schoolyear.'</td>
			</tr>
			';
		}
		$output .= '</table>';
		echo $output;
	}

	public function import_student()	{
		
		if(isset($_FILES["file"]["name"]))
		{
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for($row=3; $row<=$highestRow; $row++)
				{
					$first_name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$last_name = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$middle_name = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$srcode = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
					$course = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$rfid = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
					$qrcode = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
					$gender = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
					$college = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
					$campus = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
					$schoolyear = $worksheet->getCellByColumnAndRow(11, $row)->getValue();

					$data[] = array(
						'first_name'	=>	$first_name,
						'last_name'		=>	$last_name,
						'middle_name'	=>  $middle_name,
						'srcode'		=>	$srcode,
						'course'		=>	$course,
						'rfid'			=>	$rfid,
						'qrcode'		=>	$qrcode,
						'gender'		=>	$gender,						
						'college'		=>	$college,						
						'campus'		=>	$campus,						
						'schoolyear'	=>	$schoolyear
					);
				}
			}
			$return= $this->excel_import_model->insert_student($data);
			if($return==TRUE)
				echo 'Data Imported successfully';
			else
				echo 'Data not Imported successfully';	
			
		}	
	}

	/*
	public function import_faculty()
	{
		if(isset($_FILES["file"]["name"]))
		{
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for($row=2; $row<=$highestRow; $row++)
				{
					$first_name = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$last_name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$srcode = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$gender = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$qrcode = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
					$rfid = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$course = $worksheet->getCellByColumnAndRow(6, $row)->getValue();				

					$data[] = array(
						'first_name'	=>	$first_name,
						'last_name'		=>	$last_name,
						'srcode'		=>	$srcode,						
						'gender'		=>	$gender,						
						'qrcode'		=>	$qrcode,
						'rfid'			=>	$rfid,
						'course'		=>	$course,
						
					);
				}
			}
			$this->faculty_import_model->insert($data);
			echo 'Data Imported successfully';
		}	
	}
	*/
	function import_faculty()
	{
		if(isset($_FILES["file"]["name"]))
		{
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for($row=3; $row<=$highestRow; $row++)
				{
					$first_name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$last_name = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$middle_name = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$srcode = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
					$course = $worksheet->getCellByColumnAndRow(5, $row)->getValue();					
					$rfid = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
					$qrcode = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
					$gender = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
					$college = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
					$campus = $worksheet->getCellByColumnAndRow(10, $row)->getValue();

					$data[] = array(
						'first_name'	=>	$first_name,
						'last_name'		=>	$last_name,
						'middle_name'		=>	$middle_name,
						'srcode'		=>	$srcode,
						'course'		=>	$course,						
						'rfid'			=>	$rfid,
						'qrcode'		=>	$qrcode,
						'gender'		=>	$gender,
						'college'		=>	$college,
						'campus'		=>	$campus
					);
				}
			}
			$return= $this->excel_import_model->insert_faculty($data);
			if($return==TRUE)
				echo 'Data Imported successfully';
			else
				echo 'Data not Imported successfully';	
			
			
		}	
	}
}
