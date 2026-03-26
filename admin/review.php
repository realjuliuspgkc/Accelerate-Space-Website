<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/head.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');

    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit();
    }
?>

<title>Review Payload Submissions</title>

<div style="padding: 75px; background-color: black;">
    <div class="table-responsive">
        <table class="table table-vcenter table-hover" style="border-color: white; table-layout: fixed; width: 100%;">
            <thead>
                <tr>
                    <td>Discord Username</td>
                    <td>Company</td>
                    <td>Country of Origin</td>
                    <td>Email <br>(FIRST POINT OF CONTACT BEFORE DISCORD)</td>
                    <td>Target Date</td>
                    <td>Payload Readiness Date</td>
                    <td>Payload Mass</td>
                    <td>Inclination</td>
                    <td>Altitude</td>
                    <td>Launch Details</td>
                    <td>Craft File</td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody style="color: white; text-decoration: none;">
                <?php
                    require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');

                    $query = "SELECT * FROM launch_orders WHERE confirmed = 0";

                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td><?= htmlspecialchars($row["name"])?></td>
                        <td><?= htmlspecialchars($row["company"])?></td>
                        <td><?= htmlspecialchars($row["origincountry"])?></td>
                        <td><?= htmlspecialchars($row["email"])?></td>
                        <td><?= htmlspecialchars($row["targetdate"])?></td>
                        <td><?= htmlspecialchars($row["payloadreadydate"])?></td>
                        <td><?= htmlspecialchars($row["payloadmass"])?></td>
                        <td><?= htmlspecialchars($row["inclination"])?></td>
                        <td><?= htmlspecialchars($row["altitude"])?></td>
                        <td><a href="/admin/download-details?orderId=<?php echo $row["orderId"]?>">Launch Details txt file</a></td>
                        <td><a href="<?= htmlspecialchars($row["craftFile"])?>">Craft file</td>
                        <td><a href="/admin/confirm-booking?orderId=<?php echo $row["orderId"]?>&confirm=TRUE">Confirm Booking</a></td>
                        <td><a href="/admin/confirm-booking?orderId=<?php echo $row["orderId"]?>&confirm=FALSE">Decline Booking</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<div style="padding: 75px; background-color: black;">
    <div class="table-responsive">
        <table class="table table-vcenter table-hover" style="border-color: white; table-layout: fixed; width: 100%;">
            <thead>
                <tr>
                    <td>Discord Username</td>
                    <td>Company</td>
                    <td>Email <br>(FIRST POINT OF CONTACT BEFORE DISCORD)</td>
                    <td></td>
                </tr>
            </thead>
            <tbody style="color: white; text-decoration: none;">
                <?php
                    require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');

                    $query = "SELECT * FROM launch_orders WHERE confirmed = 1";

                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td><?= htmlspecialchars($row["name"])?></td>
                        <td><?= htmlspecialchars($row["company"])?></td>
                        <td><?= htmlspecialchars($row["email"])?></td>
                        <td><a href="/admin/download-information?orderId=<?php echo $row["orderId"]?>">Launch Information Download</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>