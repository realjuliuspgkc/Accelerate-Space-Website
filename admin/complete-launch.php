<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/head.php');

    $launch = $_GET['launch'] ?? 'launches';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $missioncomp  = isset($_POST["missioncomp"]) ? 1 : 0;
        $boosterland  = isset($_POST["boosterland"]) ? 1 : 0;
        $boosterreuse = isset($_POST["boosterreuse"]) ? 1 : 0;

        $stmt = $conn->prepare("UPDATE launches SET completed = 1 WHERE redirectPath = ?");
        $stmt->bind_param(
            "s",
            $launch
        );

        if ($stmt->execute()) {
            $submitted = true;
        } else {
            echo "Database error: " . $stmt->error;
        }

        $stmt2 = $conn->prepare("SELECT * FROM stats");
        $stmt2->execute();
        $result = $stmt2->get_result();

        while ($row = $result->fetch_assoc()) {
            $completedMissions = $row["completedmissions"];
            $boosterLandings = $row["boosterlandings"];
            $boostersReused = $row["boostersreused"];
        }

        $completedmissions = $completedMissions + $missioncomp;
        $boosterlandings   = $boosterLandings + $boosterland;
        $boostersreused    = $boostersReused + $boosterreuse;
        
        $stmt1 = $conn->prepare("UPDATE stats SET completedmissions = ?, boosterlandings = ?, boostersreused = ?");
        $stmt1->bind_param(
            "sss",
            $completedmissions,
            $boosterlandings,
            $boostersreused
        );

        if ($stmt1->execute()) {
            $submitted = true;
        } else {
            echo "Database error: " . $stmt1->error;
        }
    }
?>

<title>Complete Launch</title>
<?php if (!empty($submitted)): ?>
    <div class="form-success">
        <h2>Launch has been marked as complete.</h2>
    </div>
    <?php else: ?>
    <form method="post" style="padding:15px;">
        <div class="mb-3">
            <div>
                <label class="form-check">
                    <input class="form-check-input" type="checkbox" name="missioncomp"/>
                    <span class="form-check-label">Was the mission completed?</span>
                </label>
                <label class="form-check">
                    <input class="form-check-input" type="checkbox" name="boosterland"/>
                    <span class="form-check-label">Was the booster landed?</span>
                </label>
                <label class="form-check">
                    <input class="form-check-input" type="checkbox" name="boosterreuse"/>
                    <span class="form-check-label">Was the booster a reused one?</span>
                </label>
            </div>
        </div>
        <input type="submit" class="btn" value="Submit">
    </form>
<?php endif; ?>