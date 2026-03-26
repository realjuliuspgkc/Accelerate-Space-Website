<?php 
        $email = "ab";
        $message = "Test";
        $name = "Test";
        
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        require 'src/Exception.php';
        require 'src/PHPMailer.php.filepart';
        require 'src/SMTP.php';


        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html';

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.livemail.co.uk';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'noreply@acceleratespace.org';
            $mail->Password   = 'nwXQpWssmu2YzH';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('noreply@acceleratespace.org', 'Accelerate Space');
            $mail->addAddress($email);
            $mail->addReplyTo('enquiries@acceleratespace.org');

            $mail->isHTML(false);
            $mail->Subject = 'New Launch Booking Submission';
            $mail->Body    = "Name: $name\nEmail: $email\n\nMessage:\n$message";

            $mail->send();

            echo "Thank you for contacting us, $name. We will get back to you shortly.";

        } catch (Exception $e) {
            echo "Mailer Error: {$mail->ErrorInfo}";
        }
?>