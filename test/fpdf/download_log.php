<?php
session_start();
require '../../functions.php';
require '../../ressources/fpdf184/fpdf.php';



if(isconnected() == $_GET['id']) {
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


    //saut de ligne
    $pdf->Cell(50, 10, ' ', 0, 1, 'C');









    //requete sur les logs

    $queryPrepared = $pdo->prepare("SELECT * FROM LOGS WHERE ID=:id;");
    $queryPrepared->execute(['id'=>$id]);
    $logs = $queryPrepared->fetchAll();



    //Logs

    $pdf->Line(10, 100, 200, 100);

    $pdf->Cell(50, 10, 'Logs', 0, 1, 'C');

    foreach ($logs as $key => $log) {
        //date
        $pdf->setFillColor(230,230,230);
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(60, 20, $log['DATE_LOGIN'], 1, 0, 'C', 1);

        //log
        if ($log['ACTION'] == 'connexion') {
            //connexion
            $pdf->setFillColor(100,230,100);
            $pdf->SetFont('Arial', '',15);
            $pdf->Cell(120, 20, $log['ACTION'], 1, 1, 'L', 1);
        }elseif ($log['ACTION'] == 'déconnexion') {
            //déconnexion
            $pdf->setFillColor(230,100,100);
            $pdf->SetFont('Arial', '',15);
            $pdf->Cell(120, 20, utf8_decode($log['ACTION']), 1, 1, 'L', 1);
        }else{
            //action sur recette
            $pdf->setFillColor(100,100,230);
            $pdf->SetFont('Arial', '',15);
            $pdf->Cell(120, 20, utf8_decode($log['ACTION']), 1, 1, 'L', 1);

        }
    }

    $pdf->Output('D', 'log_'.$result['PSEUDO'].'.pdf');





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