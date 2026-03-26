<?php 
    include('head.php');

    require('db.php');

    $sql = "SELECT * FROM stats";

    $results = $conn->query($sql);
    
    if ($results->num_rows > 0) {
        $stats = $results->fetch_assoc();
    } else {
        $stats = [
            'completedmissions' => 000,
            'boosterlandings' => 000,
            'boostersreused' => 000
        ];
        
    }
?>

<title>Home | Accelerate Space</title>

<!-- <img class="full-bg" src="/images/Kerbal_Space_Program_Screenshot_2026.02.18_-_20.27.23.30.png" alt="Kerbal Space Program Screenshot"> -->

<script type="module" src="https://cdn.jsdelivr.net/gh/lekoala/formidable-elements@master/dist/count-up.min.js"></script>

<div class="video-background">    
    <video autoplay muted loop playsinline>
        <source src="/assets/images/Duna.mp4" type="video/mp4" >
        Your browser does not support the video tag.
    </video>
    <div class="content" style="left: 1%;">
        <p class="mission-title">OUR MISSION</p>
        <p class="mission-text">"Our mission is to enable timely access to space and<br>to build the systems that help safeguard the orbital domain for the future. "</p>
        <a href="mission" class="btn" role="button" style="background: transparent; color: white; gap: 8px;">EXPLORE <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-narrow-right"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M15 16l4 -4" /><path d="M15 8l4 4" /></svg></a>
    </div>
</div>
<div class="background">
    <img src="/assets/images/Untitled224.png" alt="Mission Image" class="bgimg">
    <div class="content" style="text-align: right; right: 5%;">
        <p class="mission-title" style="color: rgb(48, 48, 48);">OSPREY VEHICLE</p>
        <p class="mission-text" style="color: rgb(48, 48, 48);">OSPREY is our small-lift launch vehicle built to deliver<br>dedicated and rideshare payloads to orbit with<br>precision,reliability, and streamlined mission integration. </p>
        <a href="osprey" class="btn" role="button" style="background: transparent; color: rgb(48, 48, 48); gap: 8px; border-color: rgb(48,48,48)"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-narrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l4 4" /><path d="M5 12l4 -4" /></svg>LEARN MORE</a>
    </div>
</div>

<div style=" position:relative;  background:black; padding: 1.5rem;">
    <div class="container">
        <div class="row row-deck justify-content-center">
            <div class="col-md-4">
                <div class="card" style="background:rgba(0,0,0,0.0); box-shadow:none; color:white; border:none;">
                    <div class="card-body text-center">
                        <h2 style="font-size:5rem; margin-bottom:2.5rem; margin-top: 1rem;"><count-up><?php echo $stats["completedmissions"]?></count-up></h2>
                        <p style="margin-bottom: 0; font-size: 1rem;">COMPLETED MISSIONS</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="background:rgba(0,0,0,0.0); box-shadow:none; color:white; border:none;">
                    <div class="card-body text-center">
                        <h2 style="font-size:5rem; margin-bottom:2.5rem; margin-top: 1rem;"><count-up><?php echo $stats["boosterlandings"]?></count-up></h2>
                        <p style="margin-bottom: 0; font-size: 1rem;">BOOSTERS LANDED</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="background:rgba(0,0,0,0.0); box-shadow:none; color:white; border:none;">
                    <div class="card-body text-center">
                        <h2 style="font-size:5rem; margin-bottom:2.5rem; margin-top: 1rem;"><count-up><?php echo $stats["boostersreused"]?></count-up></h2>
                        <p style="margin-bottom: 0; font-size: 1rem;">BOOSTERS REFLOWN</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="background">
    <img src="/assets/images/image (1).png" alt="Mission Image" class="bgimg">
    <div class="content">
        <p class="mission-title">LAUNCH WITH US</p>
        <p class="mission-text">Launch with us to access reliable, precision small-lift missions designed to<br>place your payload exactly where it needs to be efficiently, <br>affordably and on schedule. </p>
        <a href="launch-with-us" class="btn" role="button" style="background: transparent; color: white; gap: 8px;">BOOK NOW <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-narrow-right"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M15 16l4 -4" /><path d="M15 8l4 4" /></svg></a>
    </div>
</div>
<div class="background">
    <img src="/assets/images/cubesat.png" alt="Mission Image" class="bgimg">
    <div class="content" style="text-align: right; right: 5%;">
        <p class="mission-title">SPACE SYSTEMS</p>
        <p class="mission-text">We design and manufacture high-performance spaceflight<br>components for our own missions and for partners seeking reliable, <br>flight-proven hardware for use in orbit.</p>
        <a href="space_systems" class="btn" role="button" style="background: transparent; color: white; gap: 8px;"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-narrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l4 4" /><path d="M5 12l4 -4" /></svg>EXPLORE</a>
    </div>
</div>


