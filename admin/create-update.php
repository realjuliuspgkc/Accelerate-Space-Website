<?php
    session_start();
    require_once($_SERVER['DOCUMENT_ROOT'] . '/head.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');

    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Collect form values safely
        $redirectPath = strtolower(preg_replace('/[^a-zA-Z0-9\-]/', '-', $_POST['title']));
        $publisher   = $_SESSION["username"] ? $_SESSION["username"] : "N/A";
        $title  = $_POST['title'] ? $_POST['title'] : "Coming Soon";
        $contents  = $_POST['contents'] ? $_POST['contents'] : "Coming Soon";

        // ===== FILE UPLOAD =====
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/assets/uploads/";
        $fileName = time() . "_" . basename($_FILES["missionpatch"]["name"]);
        $target_file = $target_dir . $fileName;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $missionPatch = "/assets/uploads/" . $fileName;

        $uploadOk = 1;

        if (!empty($_FILES["missionpatch"]["tmp_name"])) {

            $check = getimagesize($_FILES["missionpatch"]["tmp_name"]);
            if ($check === false) {
                $uploadOk = 0;
            }

            if ($_FILES["missionpatch"]["size"] > 2000000) {
                $uploadOk = 0;
            }

            if (!in_array($imageFileType, ['jpg','jpeg','png'])) {
                $uploadOk = 0;
            }

            if ($uploadOk && move_uploaded_file($_FILES["missionpatch"]["tmp_name"], $target_file)) {
                // uploaded successfully
            } else {
                echo "Image upload failed.";
                exit();
            }
        } else {
            $missionPatch = "";
        }

        // ===== DATABASE INSERT =====
        $stmt = $conn->prepare("INSERT INTO update_posts (redirect, publisher, title, contents, image) VALUES (?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "sssss",
            $redirectPath,
            $publisher,
            $title,
            $contents,
            $missionPatch
        );

        if ($stmt->execute()) {
            $submitted = true;

            $options = [
                "http" => [
                    "header" => "Content-Type: application/json\r\n",
                    "method" => "POST"
                ]
            ];

            $context = stream_context_create($options);
            file_get_contents("http://170.64.214.35:9900/news_post", false, $context);
        } else {
            echo "Database error: " . $stmt->error;
        }

        $stmt->close();
    }
?>

<?php if (!empty($submitted)): ?>
    <div class="form-success">
        <h2>Post Created</h2>
    </div>
    <?php else: ?>
    <form method="post" enctype="multipart/form-data" style="padding:15px;">
        <div style="padding: 15px; gap: 15px;" >
            <div class="card card-sm bg-black">
                <div class="card-body">
                <p style="color: white;">Title: </p><input type="text" name="title" class="form-control">
                </div>
            </div>
            <div class="card card-sm bg-black">
                <div class="card-body">
                <p style="color: white;">Contents:</p> <textarea rows="5" cols="40" name="contents" class="form-control"></textarea>
                </div>
            </div>
            <div class="card card-sm bg-black">
                <div class="card-body"> 
                <p style="color: white;">Post Banner: <input type="file" name="missionpatch" id="missionpatch" class="form-control">
                </div>
            </div>
            <input type="submit" class="btn" value="Submit">
        </div>
    </form>
<?php endif; ?>