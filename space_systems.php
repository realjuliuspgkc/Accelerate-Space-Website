<?php 
    include('head.php');
    require('db.php');

    $sql = "SELECT backlog, spacecraftlaunched, spacecraftwithcomponents FROM stats";

    $results = $conn->query($sql);
    
    if ($results->num_rows > 0) {
        $stats = $results->fetch_assoc();
    } else {
        $stats = [
            'backlog' => 000,
            'spacecraftlaunched' => 000,
            'spacecraftwithcomponents' => 000
        ];
        
    }
?>

<title>Space Systems | Accelerate Space</title>

<!-- <img class="full-bg" src="/assets/images/Kerbal_Space_Program_Screenshot_2026.02.18_-_18.58.36.27.png" alt="Kerbal Space Program Screenshot"> -->

<script type="module" src="https://cdn.jsdelivr.net/gh/lekoala/formidable-elements@master/dist/count-up.min.js"></script>

<div class="background" style="height: 95vh !important">
    <img src="/assets/images/Kerbal_Space_Program_Screenshot_2026.02.18_-_18.57.13.65.png" alt="Mission Image" class="bgimg" style="height: 95vh !important">
    <div class="content" style="text-align: right; right: 5%;">
        <p class="mission-title" style="color: rgb(255, 255, 255);">PAYLOADS</p>
        <p class="mission-text" style="color: rgb(255, 255, 255);">Built for Orbit. <br>Ready for Launch.</p>
        <!-- <a href="osprey" class="btn" role="button" style="background: transparent; color: rgb(48, 48, 48); gap: 8px; border-color: rgb(48,48,48)"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-narrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l4 4" /><path d="M5 12l4 -4" /></svg>LEARN MORE</a> -->
    </div>
</div>

<div class="background">
    <img src="/assets/images/ravenwatch.png" alt="Mission Image" class="bgimg">
    <div class="content" style="text-align: right; right: 5%; top: 40%">
        <p class="mission-title" style="color: rgb(255, 255, 255);">RAVENWATCH</p>
        <p class="mission-text" style="color: rgb(255, 255, 255);">RAVENWATCH is a compact, high-agility satellite <br>designed for persistent orbital awareness, <br>delivering reliable monitoring<br> and responsive coverage from Low Earth Orbit.</p>
        <!-- <a href="osprey" class="btn" role="button" style="background: transparent; color: rgb(48, 48, 48); gap: 8px; border-color: rgb(48,48,48)"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-narrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l4 4" /><path d="M5 12l4 -4" /></svg>LEARN MORE</a> -->
    </div>
</div>

<div style="position:relative;  background:black; padding: 1.5rem; border-top:2px solid white; border-bottom:2px solid white;">
    <div class="container">
        <div class="row row-deck justify-content-center">
            <div class="col-md-4">
                <div class="card" style="background:rgba(0,0,0,0.0); box-shadow:none; color:white; border:none;">
                    <div class="card-body text-center">
                        <h2 style="font-size:5rem; margin-bottom:2.5rem; margin-top: 1rem;"><count-up><?=htmlspecialchars($stats["backlog"])?></count-up></h2>
                        <p style="margin-bottom: 0; font-size: 1rem; font-family: sans-serif;">SPACECRAFT IN <br>BACKLOG</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="background:rgba(0,0,0,0.0); box-shadow:none; color:white; border:none;">
                    <div class="card-body text-center">
                        <h2 style="font-size:5rem; margin-bottom:2.5rem; margin-top: 1rem;"><count-up><?=htmlspecialchars($stats["spacecraftlaunched"])?></count-up></h2>
                        <p style="margin-bottom: 0; font-size: 1rem; font-family: sans-serif;">ACCELERATE SPACE <br>SPACECRAFT LAUNCHED</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="background:rgba(0,0,0,0.0); box-shadow:none; color:white; border:none;">
                    <div class="card-body text-center">
                        <h2 style="font-size:5rem; margin-bottom:2.5rem; margin-top: 1rem;"><count-up><?=htmlspecialchars($stats["spacecraftwithcomponents"])?></count-up></h2>
                        <p style="margin-bottom: 0; font-size: 1rem; font-family: sans-serif;">SPACECRAFT FEATURING <br>ACCELERATE SPACE <br>SATELLITE COMPONENTS</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="background">
    <div id="carousel-sample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="0"
            class="active"></button>
            <button type="button" data-bs-target="#carousel-sample"
            data-bs-slide-to="1"></button>
            <!-- <button type="button" data-bs-target="#carousel-sample"
            data-bs-slide-to="2"></button>
            <button type="button" data-bs-target="#carousel-sample"
            data-bs-slide-to="3"></button>
            <button type="button" data-bs-target="#carousel-sample"
            data-bs-slide-to="4"></button> -->
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" alt="1U Cubesat"
                    src="/assets/images/cubesat_1.png" />
                <div class="content" style="text-align: right; right: 5%; top: 15%;">
                    <p class="mission-text" style="color: rgb(255, 255, 255);">1U Cubesat</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" alt="1.5U Cubesat"
                    src="/assets/images/spacesystems_cubesats.png" />
                <div class="content" style="text-align: right; right: 5%; top: 15%;">
                    <p class="mission-text" style="color: rgb(255, 255, 255);">1.5U Cubesat</p>
                </div>
            </div>
            <!-- <div class="carousel-item">
            <img class="d-block w-100" alt=""
                src="/assets/images/Kerbal_Space_Program_Screenshot_2026.02.18_-_18.45.34.87.png" />
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" alt=""
                src="/assets/images/Kerbal_Space_Program_Screenshot_2026.02.18_-_18.57.13.65.png" />
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" alt=""
                src="/assets/images/Kerbal_Space_Program_Screenshot_2026.02.18_-_18.58.36.27.png" />
            </div> -->
        </div>
    </div>
    
    <div class="content" style="text-align: right; right: 5%;">
        <p class="mission-title" style="color: rgb(255, 255, 255);">CUBESATS</p>
        <p class="mission-text" style="color: rgb(255, 255, 255);">Our CubeSats are compact, modular satellites designed for <br>rapid integration, reliable performance, and scalable missions<br> across Earth observation, communications, and <br>technology demonstration</p>
        <!-- <a href="#" class="btn" role="button" style="background: transparent; color: rgb(255, 255, 255); gap: 8px; border-color: rgb(255, 255, 255)"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-narrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l4 4" /><path d="M5 12l4 -4" /></svg>ORDER NOW</a> -->
    </div>
</div>
