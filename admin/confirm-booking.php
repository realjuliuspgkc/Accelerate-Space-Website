<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$orderId = $_GET['orderId'] ?? null;
$confirm = $_GET['confirm'] ?? null;

if ($confirm == 'TRUE') {

    $stmt = $conn->prepare("UPDATE launch_orders SET confirmed = 1 WHERE orderId = ?");
    $stmt->bind_param("s", $orderId);

    if ($stmt->execute()) {

        // Get booking details to email user
        $getOrder = $conn->prepare("SELECT name, email FROM launch_orders WHERE orderId = ?");
        $getOrder->bind_param("s", $orderId);
        $getOrder->execute();
        $result = $getOrder->get_result();
        $order = $result->fetch_assoc();

        $name = $order['name'];
        $email = $order['email'];

        // Load PHPMailer
        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Exception.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/src/PHPMailer.php.filepart';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/src/SMTP.php';
        $mail = new PHPMailer(true);

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
            $mail->Subject = 'Launch Booking Confirmed';
            $mail->Body    = "Hi $name,\n\nYour launch booking has been confirmed.\n\nBest regards,\nThe Accelerate Space Team";

            $mail->send();

            require_once($_SERVER['DOCUMENT_ROOT'] . '/head.php');
        } catch (Exception $e) {
            echo "Mailer Error: {$mail->ErrorInfo}";
        }

        $submitted = true;

    } else {
        echo "Database error: " . $stmt->error;
    }

} elseif ($confirm == 'FALSE') {

    $stmt = $conn->prepare("DELETE FROM launch_orders WHERE orderId = ?");
    $stmt->bind_param("s", $orderId);
    $stmt->execute();

    header("Location: /admin/review");
    exit();
}
?>

<title>Confirm Booking</title>

<?php if (!empty($submitted)) : ?>
<div class="form-success">
    <h2>Booking has been marked as confirmed.</h2>
</div>
<?php endif; ?>