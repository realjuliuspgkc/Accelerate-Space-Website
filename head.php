<?php
session_start();

$authorized = isset($_SESSION['authorized']) && $_SESSION['authorized'] === true;

if (!$authorized) {
    // http_response_code(503);
    // header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    // header("Pragma: no-cache");
    // header("Expires: 0");
    header("Location: /maintenance");
}

register_shutdown_function(function() {
?>
    </main>
    <footer class="footer d-print-none" style="background-color: black; border: 0;">
        <div class="container-xl">
            <div class="row text-center align-items-center flex-row-reverse">
            <div class="col-lg-auto ms-lg-auto">
                <ul class="list-inline list-inline-dots mb-0">
                <li class="list-inline-item"><a href="/assets/Accelerate Space Privacy Policy.pdf" class="link-secondary">Privacy Policy</a></li>
                <li class="list-inline-item"><a href="updates" class="link-secondary">Updates</a></li>
                <li class="list-inline-item"><a href="https://discord.com/invite/9Sjf5sjJ64" class="link-secondary">Discord</a></li>
                <lt class="list-inline-item"><a href="mailto:enquiries@acceleratespace.org" class="link-secondary">Contact</a></li>
                </ul>
            </div>
            <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                <ul class="list-inline list-inline-dots mb-0">
                <li class="list-inline-item">
                    Copyright &copy; 2026
                    <a href="/admin/login" class="link-secondary">Accelerate Space.</a>
                    All rights reserved.
                </li>
                <li class="list-inline-item">
                    Made with
                    <a href="https://tabler.io/admin-template" class="link-secondary">Tabler</a>.
                    All rights reserved.
                </li>
                </ul>
            </div>
            </div>
        </div>
    </footer>

    <script
        src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/js/tabler.min.js">
    </script>
</body>
</html>
<?php
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler.min.css" />

    <link rel="icon" type="image/x-icon" href="/assets/images/accelerate500x500.png?v=<?php echo filemtime(dirname(__FILE__).'/accelerate500x500.png'); ?>">
    <link rel="stylesheet" href="/style.css?v=<?php echo filemtime(dirname(__FILE__).'/style.css'); ?>">
    <link rel="stylesheet" href="/custom-tabler-overrides.css?v=<?php echo filemtime(dirname(__FILE__).'/custom-tabler-overrides.css'); ?>">

    <style>
        .navbar { 
            transition: background-color 250ms ease, box-shadow 250ms ease; 
            background-color: black !important; 
            width: 100%;
        } 
        .navbar.transparent { 
            background-color: transparent !important; 
            box-shadow: none !important; 
            -webkit-backdrop-filter: blur(6px); 
            backdrop-filter: blur(6px); 
        } 
        .navbar.solid { 
            background-color: black !important; 
            box-shadow: 0 1px 8px rgba(0,0,0,0.08) !important; 
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function(){ 
            const nav = document.querySelector('.navbar'); 
            
            if(!nav) return; 
            
            function updateNav(){ 
                if(window.scrollY > 0){ 
                    nav.classList.add('transparent'); 
                    nav.classList.remove('solid'); 
                } else { 
                    nav.classList.add('solid'); 
                    nav.classList.remove('transparent'); 
                    } 
            } 
            updateNav(); 
            window.addEventListener('scroll', updateNav, {passive:true}); 
        }); 
    </script>
</head>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const elements = document.querySelectorAll(".local-time");

        elements.forEach(el => {
            const timestamp = parseInt(el.dataset.ts) * 1000;
            const date = new Date(timestamp);

            // Format date exactly like: March 7, 2026 20:28
            const datePart = date.toLocaleDateString(undefined, {
                month: 'long',
                day: 'numeric',
                year: 'numeric'
            });

            const timePart = date.toLocaleTimeString(undefined, {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            });

            // Get user's timezone name
            const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            const shortTZ = date.toLocaleTimeString(undefined, {
                timeZoneName: 'short'
            }).split(' ').pop();

            el.textContent = `${datePart} ${timePart} ${shortTZ}`;
        });
    });
</script>
<body>
    <header class="navbar navbar-expand-md d-print-none sticky-top">
        <div class="container-fluid">
            <a href="/" class="navbar-brand">
                <img src="/assets/images/accelerate-space.png" alt="Accelerate Space Logo" class="navbar-brand-image">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="/" class="nav-link" style="color: white;">HOME</a></li>
                    <li class="nav-item"><a href="/osprey" class="nav-link" style="color: white;">OSPREY</a></li>
                    <li class="nav-item"><a href="/space_systems" class="nav-link" style="color: white;">SPACE SYSTEMS</a></li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" style="color: white;">COMPANY</a>
                        <div class="dropdown-menu" style="background-color: black; color: white;">
                            <a href="/mission" class="dropdown-item">MISSION</a>
                            <a href="/updates" class="dropdown-item">UPDATES</a>
                            <a href="/team" class="dropdown-item">MEET THE TEAM</a>
                        </div>
                    </li>
                    <li class="nav-item"><a href="/launch-with-us" class="nav-link launchBook" style="color: white;">LAUNCH WITH US</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" style="color: white;">ADMIN</a>
                            <div class="dropdown-menu" style="background-color: black; color: white;">
                                <a href="/admin/dashboard" class="dropdown-item">ADMIN DASHBOARD</a>
                                <a href="/admin/users" class="dropdown-item">USER MANAGEMENT</a>
                                <a href="/admin/create-launch" class="dropdown-item">CREATE LAUNCH</a>
                                <a href="/admin/create-update" class="dropdown-item">CREATE UPDATE POST</a>
                                <a href="/admin/review" class="dropdown-item">REVIEW PAYLOAD SUBMISSIONS</a>
                                <a href="/admin/logout" class="dropdown-item">LOGOUT</a>
                            </div>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item dropdown dropdown-launches">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" style="color: white; border: 1px solid white;">UPCOMING LAUNCHES</a>
                        <div class="dropdown-menu launches-dropdown" style="background-color: black; color: white;">
                            <?php
                                require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');

                                $query = "SELECT launchName, redirectPath, missionPatch, launchDate FROM launches WHERE completed = 0 ORDER BY launchDate ASC LIMIT 2";

                                $result = mysqli_query($conn, $query);

                                while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <?php
                                    $rawDate = $row['launchDate'];

                                    if (is_numeric($rawDate)) {
                                        // Epoch time
                                        // $formattedDate = date('d F Y H:i:s', (int)$rawDate) . " UTC";
                                        $formattedDate = date('m d Y H:i:s', (int)$rawDate) . " UTC";
                                    } else {
                                        // Plain string like "TBD"
                                        $formattedDate = htmlspecialchars($rawDate);
                                    }
                                ?>
                                <a href="/launches/page?launch=<?= urlencode($row['redirectPath']); ?>" 
                                class="launch-entry">
                                    <div class="launch-content">
                                        <img src="<?= htmlspecialchars($row['missionPatch']); ?>" 
                                            width="75" height="75">
                                        <div class="launch-text">
                                            <span class="launch-title">
                                                <?= $row['launchName'] ?>
                                            </span>
                                            <?php if (is_numeric($rawDate)) : ?>
                                                <span class="local-time" data-ts="<?= $rawDate ?>"></span>
                                            <?php else : ?>
                                                <span style="font-size: 0.8rem;"><?=htmlspecialchars($rawDate)?></span>
                                            <?php endif; ?>
                                        </div>
                                        <!-- Arrow -->
                                        <div class="launch-arrow">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24H0z" fill="none"/>
                                                <path d="M5 12l14 0"/>
                                                <path d="M15 16l4 -4"/>
                                                <path d="M15 8l4 4"/>
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                            <?php } ?>
                            <a href="/launches" class="nav-link" style="color: white; font-size: 0.8rem;">All Upcoming Launches</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <main>