<?php
$timestamp = time();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bridge Camera</title>
    <meta http-equiv="refresh" content="20">
    <style>
        body {
            margin: 0;
            background: #000;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>
<body>
    <img src="https://www.awdcomp.net/bridge.jpg?t=<?php echo $timestamp; ?>" alt="Bridge Camera">
</body>
</html>