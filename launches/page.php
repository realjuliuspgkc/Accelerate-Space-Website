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
$formattedDate = is_numeric($rawDate) 
    ? date('d F Y H:i:s', (int)$rawDate) . " UTC" 
    : htmlspecialchars($rawDate);
?>

<title><?php echo $launchName; ?></title>

<style>
    /* Table Styles */
    .launch-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        color: white;
    }
    .launch-table th, .launch-table td {
        border: 1px solid white;
        padding: 10px;
        text-align: left;
        vertical-align: top;
        white-space: normal;       /* Wrap text */
        word-break: break-word;    /* Break long words */
        overflow-wrap: break-word; /* Modern equivalent */
    }
    .launch-table th {
        background-color: #333;
    }
    .launch-table td:first-child {
        width: 30%; /* Label column */
        font-weight: bold;
    }
    .launch-table td:last-child {
        width: 70%; /* Data column */
    }
    .table-responsive {
        overflow-x: auto; /* Scroll on small screens */
    }
    /* General Content Styles */
    body {
        background-color: black;
        color: white;
        font-family: Arial, sans-serif;
    }
    .background {
        position: relative;
        text-align: center;
        margin-bottom: 50px;
        display: flex;
    }
    .bgimg {
        width: 100%;
        height: auto;
        object-fit: cover;
    }
    .mission-title {
        z-index: 1;
        font-size: 2em;
        font-weight: bold;
        color: rgb(48, 48, 48);
        position: absolute;
        top: 10%;
        right: 5%;
        max-width: 350px;
        display: block;
    }
    .description-section {
        padding: 75px;
        background-color: black;
    }
    .description-section p {
        line-height: 1.6;
    }
</style>

<div class="background">
    <img src="/assets/images/Untitled224.png" alt="Mission Image" class="bgimg">
    <div class="mission-title"><?= htmlspecialchars($launchName); ?></div>
</div>

<div class="background">
    <img src="<?php echo $missionPatch; ?>" alt="Mission Patch" class="bgimg" style="top:25%; left:37%; width:50vw; height:50vh;">
</div>

<div class="description-section">
    <div class="table-responsive">
        <table class="launch-table">
            <tbody>
                <tr>
                    <td>MISSION NAME</td>
                    <td><?php echo $launchName; ?></td>
                </tr>
                <tr>
                    <td>VEHICLE</td>
                    <td><?php echo $vehicleType; ?></td>
                </tr>
                <tr>
                    <td>LAUNCH DATE</td>
                    <td><?php echo $formattedDate; ?></td>
                </tr>
                <tr>
                    <td>LAUNCH SITE</td>
                    <td><?php echo $launchSite; ?></td>
                </tr>
                <tr>
                    <td>OVERVIEW</td>
                    <td><?php echo $overview; ?></td>
                </tr>
                <tr>
                    <td>PAYLOAD</td>
                    <td><?php echo $payload; ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div style="padding-top: 50px;">
        <p><?php echo $description; ?></p>
    </div>
</div>
