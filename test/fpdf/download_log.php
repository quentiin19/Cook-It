<?php
session_start();
require '../../functions.php';
require '../../ressources/fpdf184/fpdf.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 15);

    $pdf->Cell(100, 20, 'Hello World !', 1, 1, 'C');
    $pdf->SetFont('Arial', 'I', 5);

    $pdf->Cell(100, 20, 'Hello World !', 1, 1, 'C');

    $pdf->Output('D', 'test.pdf');





    //Define header information
    /*
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: 0");
    header('Content-Disposition: attachment; filename="'.basename($filename).'"');
    header('Content-Length: ' . filesize($filename));
    */
}