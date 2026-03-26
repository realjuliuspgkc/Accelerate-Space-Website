<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/head.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');

    $launch = $_GET['launch'] ?? 'launches';

    $stmt = $conn->prepare("SELECT * FROM launches WHERE redirectPath = ?");
    $stmt->bind_param("s", $launch);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $launchName = $row["launchName"];
            $vehicleType = $row["vehicleType"];
            $description = $row["description"];
            $overview = $row["overview"];
            $streamLink = $row["streamLink"];
            $launchDate = $row["launchDate"];
            $missionPatch = $row["missionPatch"];
            $launchSite = $row["launchSite"];
            $payload = $row["payload"];
        }
    }

    $rawDate = $launchDate;

    if (is_numeric($rawDate)) {
        // Epoch time
        $formattedDate = date('d F Y H:i:s', (int)$rawDate) . " UTC";
    } else {
        // Plain string like "TBD"
        $formattedDate = htmlspecialchars($rawDate);
    }
?>

<title><?php echo $launchName;?> </title>


<div class="background">
    <img src="/assets/images/Untitled224.png" alt="Mission Image" class="bgimg">
    <div class="content" style="text-align: right; right: 5%;">
        <p class="mission-title" style="color: rgb(48, 48, 48); max-width: 350px;"><?php echo $launchName; ?></p>
    </div>
</div>

<div class="background">
    <img src=<?php echo $missionPatch; ?> alt="Mission Patch" class="bgimg" style="top:25%; left:37%; width: 500px; height: 500px;">
</div>

<div style="padding: 75px; background-color: black;">
    <div class="table-responsive">
        <table class="table table-vcenter table-hover" style="border-color: white; table-layout: fixed; width: 100%;">
            <thead>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody style="color: white; text-decoration: none;">
                    <tr>
                        <td>MISSION NAME</td>
                        <td><?php echo $launchName; ?></td>
                    </tr>
                    <tr>
                        <td>VEHICLE </td>
                        <td><?php echo $vehicleType; ?></td>
                    </tr>
                    <tr>
                        <td>LAUNCH DATE</td>
                        <td><?php echo $formattedDate; ?></td>
                    </tr>
                    <tr>
                        <td> LAUNCH SITE</td>
                        <td><?php echo $launchSite;?></td>
                    </tr>
                    <tr>
                        <td> OVERVIEW</td>
                        <td><?php echo $overview;?></td>
                    </tr>
                    <tr>
                        <td> PAYLOAD</td>
                        <td><?php echo $payload; ?></td>
                    </tr>
            </tbody>
        </table>
    </div>
    <div style="color: white; padding-top: 100px;">
        <p><?php echo nl2br($description); ?></p>
    </div>
</div>
