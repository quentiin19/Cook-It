<?php
session_start();
require '../../functions.php';
require '../../ressources/fpdf184/fpdf.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $pdf = new FPDF('P', 'mm', array(210, 297));
    $pdf->AddPage();

    $pdo = connectDB();

    $queryPrepared = $pdo->prepare("SELECT * FROM USER WHERE ID=:id;");
    $queryPrepared->execute(['id'=>$id]);
    $result = $queryPrepared->fetch();



    //header
    //nom
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(50, 20, 'Nom : ', 0, 0, 'L');
    $pdf->SetFont('Arial', '',15);
    $pdf->Cell(100, 20, $result['LASTNAME'], 0, 1, 'L');

    //prénom
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(50, 20, 'Prénom : ', 0, 0, 'L');
    $pdf->SetFont('Arial', '',15);
    $pdf->Cell(100, 20, $result['FIRSTNAME'], 0, 1, 'L');

    //Pseudo
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(50, 20, 'Pseudo : ', 0, 0, 'L');
    $pdf->SetFont('Arial', '',15);
    $pdf->Cell(100, 20, $result['PSEUDO'], 0, 1, 'L');

    //prénom
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(50, 20, 'Email : ', 0, 0, 'L');
    $pdf->SetFont('Arial', '',15);
    $pdf->Cell(100, 20, $result['MAIL'], 0, 1, 'L');





    //table
    $pdf->SetFont('Arial', 'B', 15);

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