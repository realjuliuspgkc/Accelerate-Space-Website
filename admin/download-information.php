<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');
    
    $orderId = $_GET['orderId'];
    $stmt = $conn->prepare("SELECT * FROM launch_orders WHERE orderId = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    $launch = $result->fetch_assoc();

    $text = $launch["name"] . "\n";
    $text .= $launch["company"] . "\n";
    $text .= $launch["origincountry"] . "\n";
    $text .= $launch["email"] . "\n";
    $text .= $launch["targetdate"] . "\n";
    $text .= $launch["payloadreadydate"] . "\n";
    $text .= $launch["payloadmass"] . "\n";
    $text .= $launch["inclination"] . "\n";
    $text .= $launch["altitude"] . "\n";
    $text .= $launch["launchdetails"] . "\n";
    $text .= $launch["craftFile"];

    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="launch-'.$orderId.'.txt"');

    echo $text;
    exit;
?>