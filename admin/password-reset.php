<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/head.php');

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$userId = $_GET['userId'] ?? 'users';

?>