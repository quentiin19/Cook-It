
<?php
require 'PHPMailer/PHPMailerAutoload.php';


function smtpmailer($to, $from, $from_name, $subject, $body)
    {
        $cle = rand(1000000,9000000);
        $mail = new PHPMailer();
        $mail->SMTPDebug = SMTP::DEBUG_CONNECTION;
        $mail->IsSMTP();
        $mail->SMTPAuth = true; 
        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
            );
        $mail->SMTPSecure = 'tls'; 
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;  
        $mail->Username = 'projann20222@gmail.com';
        $mail->Password = 'ProjAnn2022!.';   
   
   //   $path = 'reseller.pdf';
   //   $mail->AddAttachment($path);
   
        $mail->IsHTML(true);
        $mail->From="projann20222@gmail.com";
        $mail->FromName=$from_name;
        $mail->Sender=$from;
        $mail->AddReplyTo($from, $from_name);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AddAddress($to);
        $mail->send();
        
        if(!$mail->Send())
        {
            $error ="Please try Later, Error Occured while Processing...";
            echo $error;
            return $error; 
        }
        else 
        {
            $error = "Thanks You !! Your email is sent."; 
            echo $error;
            return $error;
        }
    }
    
    // $to   = 'oussoumane.bathilyy@gmail.com';
    // $from = 'projann20222@gmail.com';
    // $name = 'Cook\'it';
    // $subj = 'test Mail conf';
    // $msg = 'http://localhost:3306/TestConfirmMail/verif.php?id='.$_SESSION['id'].'&cle='.$cle.'<h1>je suis ton père</h1>';
    
    // smtpmailer($to,$from, $name ,$subj, $msg);
    
    ?>
