<?php 
    require_once($_SERVER['DOCUMENT_ROOT'] . '/head.php');
    
?>

<title>Updates | Accelerate Space</title>

<div class="background">
    <img src="/assets/images/Kerbal_Space_Program_Screenshot_2026.02.18_-_20.27.23.30.png" alt="Mission Image" class="bgimg" style="filter:brightness(0.5);">
    <div class="content">
        <p class="mission-title">UPDATES</p>
        <p class="mission-text">Join our Discord for realtime updates </p>
        <a href="https://discord.com/invite/9Sjf5sjJ64" class="btn" role="button" style="background: transparent; color: white; gap: 8px;">JOIN NOW</a>
    </div>
</div>

<div style="padding: 75px; background-color: black;">
    <p style="color: white; font-size: 2rem; font-weight: bold;">NEWS</p>
    <div class="table-responsive">
        <table class="table table-vcenter table-hover" style="border-color: white; table-layout: fixed; width: 100%;">
            <tbody style="color: white; text-decoration: none;">
                <?php
                    require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');

                    $query = "SELECT * FROM update_posts ORDER BY created_at DESC";

                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                ?> 
                    <tr>
                        <td><?= htmlspecialchars($row["title"])?></td>
                        <td><?= htmlspecialchars($row["created_at"])?></td>
                        <td><a href="/updates/page?post=<?= htmlspecialchars($row["redirect"])?>" style="color: red;"> Read More </a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>