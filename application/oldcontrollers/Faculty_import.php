<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faculty_import extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('faculty_import_model');
		$this->load->library('excel');
	}

	function index()
	{
		$this->load->view('faculty_import');
	}
	
	function fetch()
	{
		$data = $this->faculty_import_model->select();
		$output = '
		<h3 align="center">Total Data - '.$data->num_rows().'</h3>
		<table class="table table-striped table-bordered">
			<tr>
				<th>id</th>
				<th>first name</th>
				<th>last name</th>
				<th>srcode</th>
				<th>gender</th>
				<th>qrcode</th> 
				<th>rfid</th>
				<th>course</th>
			</tr>
		';
		foreach($data->result() as $row)
		{
			$output .= '
			<tr>
				<td>'.$row->id.'</td>
				<td>'.$row->first_name.'</td>
				<td>'.$row->last_name.'</td>
				<td>'.$row->srcode.'</td>
				<td>'.$row->gender.'</td>
				<td>'.$row->qrcode.'</td>
				<td>'.$row->rfid.'</td>
				<td>'.$row->course.'</td>
			</tr>
			';
		}
		$output .= '</table>';
		echo $output;
	}

	function import()
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
						'course'		=>	$course
					);
				}
			}
			$this->faculty_import_model->insert($data);
			echo 'Data faclulty Imported successfully';
		}	
	}
}

?>