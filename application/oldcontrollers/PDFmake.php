<?php


class PDFmake extends CI_Controller {

    function index()
    {
        //$this->load->library('pdf');
        $html = $this->load->view('report/print.php', [], true);
        $this->pdf->createPDF($html, 'mypdf', false);
        // echo 'hi';
    }
}
?>