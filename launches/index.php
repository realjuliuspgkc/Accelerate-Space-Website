<?php 
    require_once($_SERVER['DOCUMENT_ROOT'] . '/head.php');

    date_default_timezone_set("Universal");
?>

<title>Launches | Accelerate Space</title>

<script type="module" src="https://cdn.jsdelivr.net/gh/lekoala/formidable-elements@master/dist/count-down.min.js"></script>

<div class="background">
    <img src="/assets/images/launches.png" alt="Mission Image" class="bgimg">
    <div class="missions__hero-callout">
        <?php
            require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');

            $query = "SELECT launchName, redirectPath, launchDate FROM launches WHERE completed = 0 ORDER BY launchOrder ASC LIMIT 1";

            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <?php
                $rawDate = $row['launchDate'];

                if (is_numeric($rawDate)) {
                    // Epoch time
                    $formattedDate = date('d F Y H:i:s', (int)$rawDate) . " UTC";
                } else {
                    // Plain string like "TBD"
                    $formattedDate = htmlspecialchars($rawDate);
                }
            ?>
            <div class="missions__hero-callout-wrapper">
                <div class="missions__hero-callout-subtitle">Next Launch</div>
                <h2 class="missions__hero-callout-title">
                    <?= $row['launchName']?><br>
                    <?php if (is_numeric($rawDate)) : ?>
                        <span style="font-size: 0.8rem;">
                            <count-down data-end="<?= htmlspecialchars($formattedDate) ?>"></count-down>
                        </span>
                        <?php else : ?>
                        <span style="font-size: 0.8rem;"><?=htmlspecialchars($rawDate)?></span>
                    <?php endif; ?>

                </h2>
                <a href="/launches/page?launch=<?= urlencode($row['redirectPath']); ?>" class="missions__hero-callout-link">
                    Read more
                </a>
            </div>
        <?php } ?>
    </div>
</div>



<div style="padding: 75px; background-color: black;" class="launch-desktop">
    <p style="color: white; font-size: 2rem; font-weight: bold;">LAUNCHES</p>
    <p style="color: rgb(179, 179, 179); font-size: 2rem; font-weight: bold; padding-bottom: 15px;">UPCOMING LAUNCHES</p>
    <div class="table-responsive">
        <table class="table table-vcenter table-hover" style="border-color: white; table-layout: fixed; width: 100%;">
            <thead>
                <tr>
                    <th style="background-color: black; color: white; font-weight: bold; font-size: 1rem;">Mission</th>
                    <th style="background-color: black; color: white; font-weight: bold; font-size: 1rem;">Launch Date</th>
                    <th style="background-color: black; color: white; font-weight: bold; font-size: 1rem;">Rocket</th>
                    <th style="background-color: black; color: white; font-weight: bold; font-size: 1rem;">Customer</th>
                    <th style="background-color: black; color: white; font-weight: bold; font-size: 1rem;">Launch Site</th>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <th style="background-color: black; color: white; font-weight: bold; font-size: 1rem;"></th>
                        <th style="background-color: black; color: white; font-weight: bold; font-size: 1rem;"></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody style="color: white; text-decoration: none;">
                <?php
                    require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');

                    $query = "SELECT * FROM launches WHERE completed = 0 ORDER BY launchOrder ASC";

                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <?php
                        $rawDate = $row['launchDate'];

                        if (is_numeric($rawDate)) {
                            // Epoch time
                            $formattedDate = date('d F Y H:i:s', (int)$rawDate) . " UTC";
                        } else {
                            // Plain string like "TBD"
                            $formattedDate = htmlspecialchars($rawDate);
                        }
                    ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="<?= htmlspecialchars($row['missionPatch']); ?>" 
                                    width="100" height="100" 
                                    class="flex-shrink-0">

                                <a href="/launches/page?launch=<?= urlencode($row['redirectPath']); ?>" 
                                class="text-white">
                                    <?= htmlspecialchars($row['launchName']); ?>
                                </a>
                            </div>
                        </td>

                        <td><?= $formattedDate; ?> </td>
                        <td><?= htmlspecialchars($row['vehicleType']); ?></td>
                        <td><?= htmlspecialchars($row['customer']); ?></td>
                        <td><?= htmlspecialchars($row['launchSite']); ?></td>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <td><a href="/admin/edit-launch?launch=<?= htmlspecialchars($row["redirectPath"])?>">Edit</a></td>
                            <td><a href="/admin/complete-launch?launch=<?= htmlspecialchars($row["redirectPath"])?>">Complete launch</a></td>
                        <?php endif; ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div style="padding: 75px; background-color: black;" class="launch-desktop">
    <p style="color: white; font-size: 2rem; font-weight: bold;">LAUNCHES</p>
    <p style="color: rgb(179, 179, 179); font-size: 2rem; font-weight: bold;">COMPLETED LAUNCHES</p>
    <div class="table-responsive">
        <table class="table table-vcenter table-hover" style="border-color: white; table-layout: fixed; width: 100%;">
            <thead>
                <tr>
                    <th style="background-color: black; color: white; font-weight: bold; font-size: 1rem;">Mission</th>
                    <th style="background-color: black; color: white; font-weight: bold; font-size: 1rem;">Launch Date</th>
                    <th style="background-color: black; color: white; font-weight: bold; font-size: 1rem;">Rocket</th>
                    <th style="background-color: black; color: white; font-weight: bold; font-size: 1rem;">Customer</th>
                    <th style="background-color: black; color: white; font-weight: bold; font-size: 1rem;">Launch Site</th>
                </tr>
            </thead>
            <tbody style="color: white; text-decoration: none;">
                <?php
                require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');

                $query = "SELECT * FROM launches 
                        WHERE completed = 1
                        ORDER BY launchDate DESC";


                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <?php
                    $rawDate = $row['launchDate'];

                    if (is_numeric($rawDate)) {
                        // Epoch time
                        $formattedDate = date('d F Y H:i:s', (int)$rawDate) . " UTC";
                    } else {
                        // Plain string like "TBD"
                        $formattedDate = htmlspecialchars($rawDate);
                    }
                    ?>
                    <tr>
                        <td>
                            <img src="<?= htmlspecialchars($row['missionPatch']); ?>" width="100" height="100">
                            <a href="/launches/page?launch=<?= urlencode($row['redirectPath']); ?>" style="color: white;">
                                <?= htmlspecialchars($row['launchName']); ?>
                            </a>
                        </td>

                        <td><?= $formattedDate ?></td>
                        <td><?= htmlspecialchars($row['vehicleType']); ?></td>
                        <td><?= htmlspecialchars($row['customer']); ?></td>
                        <td><?= htmlspecialchars($row['launchSite']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div style="padding: 75px; background-color: black;" class="launch-mobile">
    <p style="color: white; font-size: 2rem; font-weight: bold;">LAUNCHES</p>
    <p style="color: rgb(179, 179, 179); font-size: 2rem; font-weight: bold; padding-bottom: 15px;">UPCOMING LAUNCHES</p>
    <div class="table-responsive">
        <table class="table table-vcenter table-hover" style="border-color: white; table-layout: fixed; width: 100%;">
            <thead>
                <tr>
                    <th style="background-color: black; color: white; font-weight: bold; font-size: 1rem;">Mission</th>
                    <th style="background-color: black; color: white; font-weight: bold; font-size: 1rem;">Launch Date</th>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <th style="background-color: black; color: white; font-weight: bold; font-size: 1rem;"></th>
                        <th style="background-color: black; color: white; font-weight: bold; font-size: 1rem;"></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody style="color: white; text-decoration: none;">
                <?php
                    require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');

                    $query = "SELECT * FROM launches WHERE completed = 0 ORDER BY launchDate ASC";

                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <?php
                        $rawDate = $row['launchDate'];

                        if (is_numeric($rawDate)) {
                            // Epoch time
                            $formattedDate = date('d F Y H:i:s', (int)$rawDate) . " UTC";
                        } else {
                            // Plain string like "TBD"
                            $formattedDate = htmlspecialchars($rawDate);
                        }
                    ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="<?= htmlspecialchars($row['missionPatch']); ?>" 
                                    width="100" height="100" 
                                    class="flex-shrink-0">

                                <a href="/launches/page?launch=<?= urlencode($row['redirectPath']); ?>" 
                                class="text-white">
                                    <?= htmlspecialchars($row['launchName']); ?>
                                </a>
                            </div>
                        </td>

                        <td><?= $formattedDate; ?> </td>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <td><a href="/admin/edit-launch?launch=<?= htmlspecialchars($row["redirectPath"])?>">Edit</a></td>
                            <td><a href="/admin/complete-launch?launch=<?= htmlspecialchars($row["redirectPath"])?>">Complete launch</a></td>
                        <?php endif; ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div style="padding: 75px; background-color: black;" class="launch-mobile">
    <p style="color: white; font-size: 2rem; font-weight: bold;">LAUNCHES</p>
    <p style="color: rgb(179, 179, 179); font-size: 2rem; font-weight: bold;">COMPLETED LAUNCHES</p>
    <div class="table-responsive">
        <table class="table table-vcenter table-hover" style="border-color: white; table-layout: fixed; width: 100%;">
            <thead>
                <tr>
                    <th style="background-color: black; color: white; font-weight: bold; font-size: 1rem;">Mission</th>
                    <th style="background-color: black; color: white; font-weight: bold; font-size: 1rem;">Launch Date</th>
                </tr>
            </thead>
            <tbody style="color: white; text-decoration: none;">
                <?php
                require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');

                $query = "SELECT * FROM launches 
                        WHERE completed = 1
                        ORDER BY launchDate DESC";


                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <?php
                    $rawDate = $row['launchDate'];

                    if (is_numeric($rawDate)) {
                        // Epoch time
                        $formattedDate = date('d F Y H:i:s', (int)$rawDate) . " UTC";
                    } else {
                        // Plain string like "TBD"
                        $formattedDate = htmlspecialchars($rawDate);
                    }
                    ?>
                    <tr>
                        <td>
                            <a href="/launches/page?launch=<?= urlencode($row['redirectPath']); ?>" style="color: white;">
                                <?= htmlspecialchars($row['launchName']); ?>
                            </a>
                        </td>

                        <td><?= $formattedDate ?></td>
                        <td><?= htmlspecialchars($row['vehicleType']); ?></td>
                        <td><?= htmlspecialchars($row['customer']); ?></td>
                        <td><?= htmlspecialchars($row['launchSite']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>