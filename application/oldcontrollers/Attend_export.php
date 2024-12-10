<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
    use PhpOffice\PhpSpreadsheet\Helper\Sample;
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Attend_export extends CI_Controller {
	public function __construct() {
        parent::__construct();
		$this->load->model('AttendExport_model');
        $this->load->model('Public_model');
    }    
	public function index() {
        $data['page'] = 'export-excel';
        $data['title'] = 'Export Excel data';

        // $data['attendance'] = $this->AttendExport_model->StudentList();
        // $d['start'] = $this->input->get('start');
        // $d['end'] = $this->input->get('end');
        // $d['dept_code'] = $this->input->get('dept');

        $dept = $this->input->get('dept');
        $d['attendance'] = $this->Public_model->get_attend_all($dept);
		
        $this->load->view('report/attendview', $data);

    }
	public function createExcel() {
		$fileName = 'Attendance.xlsx';  

        // Get result of the table
		$attendance = $this->Public_model->get_attend_all($dept);
		$spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');
		$sheet->setCellValue('A1', 'qrcode');
        $sheet->setCellValue('B1', 'RFID');
        $sheet->setCellValue('C1', 'username');
        $sheet->setCellValue('D1', 'srcode');
		$sheet->setCellValue('E1', 'building');
        $sheet->setCellValue('F1', 'in_time');  
        $sheet->setCellValue('G1', 'date'); 

        $rows = 2;
        foreach ($attendance as $val){
            $sheet->setCellValue('A' . $rows, $val['qrcode']);
            $sheet->setCellValue('B' . $rows, $val['RFID']);
            $sheet->setCellValue('C' . $rows, $val['username']);
            $sheet->setCellValue('D' . $rows, $val['srcode']);
			$sheet->setCellValue('E' . $rows, $val['building']);
            $sheet->setCellValue('F' . $rows, $val['in_time']);
            $sheet->setCellValue('G' . $rows, $val['date']);
            $rows++;
        } 
        $writer = new Xlsx($spreadsheet);
		$writer->save("upload/".$fileName);
		header("Content-Type: application/vnd.ms-excel");
        redirect(base_url()."/upload/".$fileName);              
    }    
}
?>