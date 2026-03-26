<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/head.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');

    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit();
    }
?>


<title>User Management</title>

<div style="padding: 75px; background-color: black;">
    <div class="table-responsive">
        <table class="table table-vcenter table-hover" style="border-color: white; table-layout: fixed; width: 100%;">
            <thead>
                <tr>
                    <td>User ID</td>
                    <td>Username</td>
                    <td></td>
                </tr>
            </thead>
            <tbody style="color: white; text-decoration: none;">
                <?php
                    require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');

                    $query = "SELECT * FROM users";

                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td><?= htmlspecialchars($row["id"])?></td>
                        <td><?= htmlspecialchars($row["username"])?></td>
                        <td><a href="password-reset?userId=<?= htmlspecialchars($row["id"])?>">Reset Password</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
