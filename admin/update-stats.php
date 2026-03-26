<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $completed = $_POST['completedmissions'] ?? 0;
    $landings  = $_POST['boosterlandings'] ?? 0;
    $reused    = $_POST['boostersreused'] ?? 0;
    $backlog   = $_POST['backlog'] ?? 0;
    $launched  = $_POST['launched'] ?? 0;
    $components = $_POST['components'] ?? 0;

    $stmt = $conn->prepare("
        UPDATE stats 
        SET completedmissions = ?, 
            boosterlandings = ?, 
            boostersreused = ?, 
            backlog = ?, 
            spacecraftlaunched = ?, 
            spacecraftwithcomponents = ?
        WHERE id = 1
    ");

    $stmt->bind_param("iiiiii",
        $completed,
        $landings,
        $reused,
        $backlog,
        $launched,
        $components
    );

    $stmt->execute();

    header("Location: dashboard"); // or wherever you want
    exit();
}