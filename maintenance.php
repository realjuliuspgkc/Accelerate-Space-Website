<?php
session_start();

// 🔒 CHANGE THIS PASSWORD
$access_password = "6sJuXLQAyCRFrk";

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: maintenance.php");
    exit;
}

// Handle login attempt
if (isset($_POST['password'])) {
    if ($_POST['password'] === $access_password) {
        $_SESSION['authorized'] = true;
        header("Location: index");
    } else {
        $error = "Incorrect password.";
    }
}

// Check authorization
$authorized = isset($_SESSION['authorized']) && $_SESSION['authorized'] === true;

// Send 503 if not authorized
if (!$authorized) {
    // http_response_code(503);
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");
} else {
    header("Location: index");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Work In Progress</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #111;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .container {
            max-width: 400px;
            width: 90%;
        }

        h1 {
            margin-bottom: 15px;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 4px;
        }

        button {
            margin-top: 10px;
            padding: 10px 20px;
            border: none;
            background: #ff6600;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background: #ff8533;
        }

        .error {
            color: #ff4d4d;
            margin-top: 10px;
        }

        .logout {
            margin-top: 20px;
            display: inline-block;
            color: #ccc;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!$authorized): ?>
            <h1>🚧 Work In Progress</h1>
            <p>This website is currently under development.</p>
            <p>Enter password for access:</p>

            <form method="POST">
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Enter</button>
            </form>

            <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>

        <?php else: ?>
            <h1>Access Granted</h1>
            <p>The site is currently in development mode.</p>
            <p>You now have access.</p>
            <a class="logout" href="?logout=true">Logout</a>
        <?php endif; ?>
    </div>
</body>
</html>