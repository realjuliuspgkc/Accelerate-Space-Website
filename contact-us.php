<?php 
    include('head.php');
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $submitted = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $message = $_POST['message'];
        $name = $_POST['name'];
	$to = "enquiries@acceleratespace.org";
        
        require 'src/Exception.php';
        require 'src/PHPMailer.php.filepart';
        require 'src/SMTP.php';

        $mail = new PHPMailer(true);

        try {
            $submitted = true;
            $mail->isSMTP();
            $mail->Host       = 'smtp.livemail.co.uk';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'noreply@acceleratespace.org';
            $mail->Password   = 'nwXQpWssmu2YzH';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom('noreply@acceleratespace.org', 'Accelerate Space');
            $mail->addAddress('enquiries@acceleratespace.org');
            $mail->addReplyTo($email);

            $mail->isHTML(false);
            $mail->Subject = 'New Contact Us Submission';
            $mail->Body    = "Name: $name\nEmail: $email\n\nMessage:\n$message";

            $mail->send();

        } catch (Exception $e) {
            echo "Mailer Error: {$mail->ErrorInfo}";
        }
    }
?>

<title>Contact Us | Accelerate Space</title>

<?php if (!empty($submitted) && $submitted): ?>
    <div class="form-success">
        <h2>Thank you - your contact request has been received.</h2>
        <p>We will contact you at <?php echo htmlspecialchars($email); ?> as soon as we can.</p>
    </div>
<?php else: ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" style="padding: 15px;">
        <div style="padding: 15px; gap: 15px;" >
            <div class="card card-sm bg-black">
                <div class="card-body">
                    <p style="color: white;">Name: </p><input type="text" name="name" class="form-control">
                </div>
            </div>
            <div class="card card-sm bg-black">
                <div class="card-body">
                    <p style="color: white;">Email:</p> <input type="text" name="email" class="form-control">
                </div>
            </div>
            <div class="card card-sm bg-black">
                <div class="card-body"> 
                    <p style="color: white;">Message: <input type="text" name="message" class="form-control">
                </div>
            </div>
            <input type="submit" class="btn" value="Submit">
        </div>
    </form>
<?php endif; ?>