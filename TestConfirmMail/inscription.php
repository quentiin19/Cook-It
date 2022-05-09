<?php 
require "PHPMailer/PHPMailerAutoload.php";
session_start();
//$bdd = new PDO('mysql:host=localhost;dbname=confirmation_email;','root','root');

$email = "oussoumane.bathilyy@gmail.com";
$cle = rand(1000000,9000000);
        
//  if(isset($_POST['valider'])){

//      $insertUser = $bdd -> prepare('INSERT INTO users(email,cle,confirme) VALUES(?,?,?)');
//      $insertUser->execute(array($email, $cle, 0));        
//      $getUser = $bdd ->prepare('SELECT * FROM users WHERE email = ?');
//      $getUser->execute(array($email));

//  }  

            
            
function smtpmailer($to, $from, $from_name, $subject, $body)
    {
        $mail = new PHPMailer();
        
        $mail->IsSMTP();
        $mail->SMTPAuth = true; 
 
        $mail->SMTPSecure = 'tls'; 
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;  
        $mail->Username = 'projann2022@gmail.com';
        $mail->Password = 'ProjAnn2022!.';   
   
   //   $path = 'reseller.pdf';
   //   $mail->AddAttachment($path);
   
        $mail->IsHTML(true);
        $mail->From="projann2022@gmail.com";
        $mail->FromName=$from_name;
        $mail->Sender=$from;
        $mail->AddReplyTo($from, $from_name);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AddAddress($to);
        
        $mail->send();
        
     if(!$mail->Send())
    {
        $error ="Essaye après chef ça bug";
        return $error; 
    }    
    else 
    {
        $error = "Email envoyé";  
        return $error;
    }

    }
    
    $to   = $email;
    $from = 'projann2022@gmail.com';
    $name = 'Cook\'it';
    $subj = 'test Mail conf';
    $msg = 'http://localhost:3306/TestConfirmMail/verif.php?id='.$_SESSION['id'].'&cle='.$cle.'<h1>je suis ton père</h1>';
    
    $error=smtpmailer($to,$from, $name ,$subj, $msg);


?>

<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <meta method="POST" action="">
</head>
<body>

    <input type="submit" name="valider">

</body>
    
</html>