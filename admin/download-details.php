<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');
    
    $orderId = $_GET['orderId'];
    $stmt = $conn->prepare("SELECT launchdetails FROM launch_orders WHERE orderId = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    $launch = $result->fetch_assoc();

    $text = $launch["launchdetails"];

    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="launch-'.$orderId.'.txt"');

    echo $text;
    exit;
?>