<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/head.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');

    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Collect form values safely
        $redirectPath = strtolower(preg_replace('/[^a-zA-Z0-9\-]/', '-', $_POST['launchname']));
        $launchName   = $_POST['launchname'] ? $_POST['launchname'] : "Coming Soon";
        $vehicleType  = $_POST['vehicle'] ? $_POST['vehicle'] : "Coming Soon";
        $description  = $_POST['description'] ? $_POST['description'] : "Coming Soon";
        $overview     = $_POST['overview'] ? $_POST['overview'] : "Coming Soon";
        $streamLink   = $_POST['streamlink'] ? $_POST['streamlink'] : "Coming Soon";
        $launchDate   = is_numeric($_POST['launchdate']) ? $_POST['launchdate'] : "TBC";
        $customer     = $_POST['customer'] ? $_POST['customer'] : "TBC";
        $launchSite   = $_POST['launchsite'] ? $_POST['launchsite'] : "TBC";
        $payload      = $_POST['payload'] ? $_POST['payload'] : "TBC";

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
                echo "<pre>";
                print_r($_FILES["missionpatch"]);
                echo "Target path: " . $target_file . "\n";
                echo "Upload OK: " . $uploadOk . "\n";
                echo "File exists: " . (file_exists($target_dir) ? "YES" : "NO") . "\n";
                echo "Writable: " . (is_writable($target_dir) ? "YES" : "NO") . "\n";
                echo $_FILES["missionpatch"]["error"];
                exit();
            }
        } else {
            $missionPatch = "";
        }

        // ===== DATABASE INSERT =====
        $stmt = $conn->prepare("INSERT INTO launches 
            (redirectPath, launchName, vehicleType, description, overview, streamLink, launchDate, missionPatch, customer, launchSite, payload) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "sssssssssss",
            $redirectPath,
            $launchName,
            $vehicleType,
            $description,
            $overview,
            $streamLink,
            $launchDate,
            $missionPatch,
            $customer,
            $launchSite,
            $payload
        );

        if ($stmt->execute()) {
            $submitted = true;
        } else {
            echo "Database error: " . $stmt->error;
        }

        $stmt->close();
    }
?>

<?php if (!empty($submitted)): ?>
    <div class="form-success">
        <h2>Launch Created</h2>
    </div>
    <?php else: ?>
    <form method="post" enctype="multipart/form-data" style="padding:15px;">
        <div style="padding: 15px; gap: 15px;" >
            <div class="card card-sm bg-black">
            <div class="card-body">
            <p style="color: white;">Launch name: </p><input type="text" name="launchname" class="form-control">
            </div>
        </div>
        <div class="card card-sm bg-black">
            <div class="card-body">
            <p style="color: white;">Vehicle:</p> <input type="text" name="vehicle" class="form-control">
        </div>
        </div>
        <div class="card card-sm bg-black">
            <div class="card-body"> 
            <p style="color: white;">Description: <input type="text" name="description" class="form-control">
        </div>
        </div>
        <div class="card card-sm bg-black">
            <div class="card-body"> 
            <p style="color: white;">Overview: <input type="text" name="overview" class="form-control">
        </div>
        </div>
        <div class="card card-sm bg-black">
            <div class="card-body"> 
            <p style="color: white;">Stream link: <input type="text" name="streamlink" class="form-control">
        </div>
        </div>
        <div class="card card-sm bg-black">
            <div class="card-body"> 
            <p style="color: white;">Launch Date (EPOCH ONLY PLS OTHERWISE I BREAK): <input type="text" name="launchdate" class="form-control">
        </div>
        <div class="card card-sm bg-black">
            <div class="card-body"> 
            <p style="color: white;">Mission Patch: <input type="file" name="missionpatch" id="missionpatch" class="form-control">
        </div>
        </div>
        <div class="card card-sm bg-black">
            <div class="card-body"> 
            <p style="color: white;">Customer: <input type="text" name="customer" class="form-control">
        </div>
        </div>
        <div class="card card-sm bg-black">
            <div class="card-body"> 
            <p style="color: white;">Launch Site: <input type="text" name="launchsite" class="form-control">
        </div>
        </div>
        <div class="card card-sm bg-black">
            <div class="card-body"> 
            <p style="color: white;">Payload: <input type="text" name="payload" class="form-control">
        </div>
        </div>
            <input type="submit" class="btn" value="Submit">
        </div>
    </form>
<?php endif; ?>