<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');

    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit();
    }

    $launch = $_GET['launch'] ?? 'launches';

    $stmt = $conn->prepare("SELECT * FROM launches where redirectPath = ?");
    $stmt->bind_param("s", $launch);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $redirectPath1 = $row["redirectPath"];
        $launchName1  = $row["launchName"];
        $vehicleType1  = $row["vehicleType"];
        $description1  = $row["description"];
        $overview1     = $row["overview"];
        $streamLink1   = $row["streamLink"];
        $launchDate1   = $row["launchDate"];
        $missionPatch1 = $row["missionPatch"];
        $customer1     = $row["customer"];
        $launchSite1   = $row["launchSite"];
        $payload1      = $row["payload"];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Collect form values safely
        $redirectPath = strtolower(preg_replace('/[^a-zA-Z0-9\-]/', '-', $_POST['launchname']));
        $launchName   = !empty($_POST['launchname']) ? $_POST['launchname'] : $launchName1;
        $vehicleType  = !empty($_POST['vehicle']) ? $_POST['vehicle'] : $vehicleType1;
        $description  = !empty($_POST['description']) ? $_POST['description'] : $description1;
        $overview     = !empty($_POST['overview']) ? $_POST['overview'] : $overview1;
        $streamLink   = !empty($_POST['streamlink']) ? $_POST['streamlink'] :$streamLink1;
        $launchDate   = !empty($_POST['launchdate']) ? $_POST['launchdate'] : $launchDate1;
        $customer     = !empty($_POST['customer']) ? $_POST['customer'] : $customer1;
        $launchSite   = !empty($_POST['launchsite']) ? $_POST['launchsite'] : $launchSite1;
        $payload      = !empty($_POST['payload']) ? $_POST['payload'] : $payload1;

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
            $missionPatch = $missionPatch1;
        }

        // ===== DATABASE INSERT =====
        $stmt = $conn->prepare("
            UPDATE launches SET
                launchName = ?,
                vehicleType = ?,
                description = ?,
                overview = ?,
                streamLink = ?,
                launchDate = ?,
                missionPatch = ?,
                customer = ?,
                launchSite = ?,
                payload = ?
            WHERE redirectPath = ?
        ");

        $stmt->bind_param(
            "sssssssssss",
            $launchName,
            $vehicleType,
            $description,
            $overview,
            $streamLink,
            $launchDate,
            $missionPatch,
            $customer,
            $launchSite,
            $payload,
            $redirectPath1
        );

        if ($stmt->execute()) {
            $submitted = true;
        } else {
            echo "Database error: " . $stmt->error;
        }

        $stmt->close();

        if (isset($_POST['delete_launch'])) {

            $delete_id = $redirectPath1;

            $stmt = $conn->prepare("DELETE FROM launches WHERE redirectPath = ?");
            $stmt->bind_param("s", $delete_id);
            $stmt->execute();

            // Optional: redirect after delete
            header("Location: /launches/");
            exit();
        }
    }
    require_once($_SERVER['DOCUMENT_ROOT'] . '/head.php');
?>

<title>Edit Launch</title>

<?php if (!empty($submitted)): ?>
    <div class="form-success">
        <h2>Launch Updated</h2>
    </div>
    <?php else: ?>
    <form method="post" enctype="multipart/form-data" style="padding:15px;">
        <div style="padding: 15px; gap: 15px;" >
            <div class="card card-sm bg-black">
            <div class="card-body">
            <p style="color: white;">Launch name: </p><input type="text" name="launchname"  value="<?= htmlspecialchars($launchName1)?>" class="form-control">
            </div>
        </div>
        <div class="card card-sm bg-black">
            <div class="card-body">
            <p style="color: white;">Vehicle:</p> <input type="text" name="vehicle" value="<?= htmlspecialchars($vehicleType1)?>" class="form-control">
        </div>
        </div>
        <div class="card card-sm bg-black">
            <div class="card-body"> 
            <p style="color: white;">Description: <input type="text" name="description" value="<?= htmlspecialchars($description1)?>" class="form-control">
        </div>
        </div>
        <div class="card card-sm bg-black">
            <div class="card-body"> 
            <p style="color: white;">Overview: <input type="text" name="overview" value="<?= htmlspecialchars($overview1)?>" class="form-control">
        </div>
        </div>
        <div class="card card-sm bg-black">
            <div class="card-body"> 
            <p style="color: white;">Stream link: <input type="text" name="streamlink" value="<?= htmlspecialchars($streamLink1)?>" class="form-control">
        </div>
        </div>
        <div class="card card-sm bg-black">
            <div class="card-body"> 
            <p style="color: white;">Launch Date (EPOCH ONLY PLS OTHERWISE I BREAK): <input type="text" name="launchdate" value="<?= htmlspecialchars($launchDate1)?>" class="form-control">
        </div>
        <div class="card card-sm bg-black">
            <div class="card-body"> 
            <p style="color: white;">Mission Patch: 
            <?php if (!empty($missionPatch1)): ?>
                <img src="<?= htmlspecialchars($missionPatch1) ?>" 
                    style="max-width:150px; display:block; margin-bottom:10px;">
            <?php endif; ?>    
            <input type="file" name="missionpatch" id="missionpatch" class="form-control">
            </div>
        </div>
        <div class="card card-sm bg-black">
            <div class="card-body"> 
            <p style="color: white;">Customer: <input type="text" name="customer" value="<?= htmlspecialchars($customer1)?>" class="form-control">
        </div>
        </div>
        <div class="card card-sm bg-black">
            <div class="card-body"> 
            <p style="color: white;">Launch Site: <input type="text" name="launchsite" value="<?= htmlspecialchars($launchSite1)?>" class="form-control">
        </div>
        </div>
        <div class="card card-sm bg-black">
            <div class="card-body"> 
            <p style="color: white;">Payload: <input type="text" name="payload" value="<?= htmlspecialchars($payload1)?>" class="form-control">
        </div>
        </div>
            <input type="submit" class="btn btn-success" value="Submit">
            <button type="submit" name="delete_launch" class="btn btn-danger">
                Delete
            </button>
            <label for="delete_launch" style="color: white;">ARE YOU SURE ABOUT THAT?</label>
        </div>
    </form>
<?php endif; ?>