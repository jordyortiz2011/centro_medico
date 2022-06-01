<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Excel extends CI_Controller {

    public function index()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');

        $writer = new Xlsx($spreadsheet);

        $filename = 'name-of-the-generated-file.xlsx';

        $writer->save($filename); // will create and save the file in the root of the project

    }

    public function download()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');

        $writer = new Xlsx($spreadsheet);

        $filename = 'name-of-the-generated-file';
        //exit;
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet ; charset=UTF-8');
        header('Content-Disposition: attachment;filename=hola_mundo.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); // download file


    }
}