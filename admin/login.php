<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["username"];
    $pass = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if (password_verify($pass, $hashed_password)) {
            $_SESSION["user_id"] = $id;
            $_SESSION["username"] = $user;
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }

    $stmt->close();
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/head.php');
?>

<div style="display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            background-color: #000;">

    <form method="POST" style="background: #111; padding: 40px; border-radius: 8px; text-align: center; width: 300px;">
        <h2 style="color: white;">Login</h2>

        <input type="text" name="username" placeholder="Username" required 
               style="width: 100%; padding: 10px; margin-bottom: 15px;"><br>

        <input type="password" name="password" placeholder="Password" required 
               style="width: 100%; padding: 10px; margin-bottom: 20px;"><br>

        <button type="submit" style="width: 100%; padding: 10px;">Login</button>
    </form>

</div>