<?php 
    include('head.php'); 

    require('db.php');

    $sql = "SELECT completedmissions, boosterlandings, boostersreused FROM stats";

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

<title>Osprey | Accelerate Space</title>

<!-- <img class="full-bg" src="/assets/images/Kerbal_Space_Program_Screenshot_2026.02.18_-_18.45.34.87.png" alt="Kerbal Space Program Screenshot"> -->
<script type="module" src="https://cdn.jsdelivr.net/gh/lekoala/formidable-elements@master/dist/count-up.min.js"></script>

<div class="background">
    <img src="/assets/images/osprey_main.png" alt="Mission Image" class="bgimg">
    <div class="content" style="text-align: center; left: 7%;">
        <p class="mission-title" style="color: rgb(29, 29, 29); font-weight: bold; font-size: 4rem;">OSPREY</p>
        <p class="mission-text" style="color: rgb(29, 29, 29);  font-size: 0.8rem;">OUR SMALL SATELLITE LAUNCHER.</p>
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
    <img src="/assets/images/unnamed.png" alt="Mission Image" class="bgimg" style="left: 11%;">
</div>

<div class="background">
    <img src="/assets/images/Kerbal_Space_Program_Screenshot_2026.02.18_-_19.00.23.15.png" alt="Mission Image" class="bgimg">
    <div class="content" style="text-align: right; right: 5%;">
        <p class="mission-title" style="color: rgb(255, 255, 255);">PAYLOAD PROGRAM</p>
        <p class="mission-text" style="color: rgb(255, 255, 255);">Launch with us to access reliable, precision small-lift missions<br>designed to place your payload exactly where it needs to be efficiently, <br>affordably and on schedule.</p>
        <a href="launch-with-us" class="btn" role="button" style="background: transparent; color: rgb(255, 255, 255); gap: 8px; border-color: rgb(255, 255, 255)"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-narrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l4 4" /><path d="M5 12l4 -4" /></svg>LEARN MORE</a>
    </div>
</div>

<div style=" position:relative;  background:black; padding: 1.5rem;">
    <div class="container">
        <div class="row row-deck justify-content-center">
        </div>
    </div>
</div>

<div style="text-align: center;">
    <iframe width="1280" height="720"
        src="https://www.youtube.com/embed/HrBzr0vosW0?si=XBVWV49hkD4TVMK3"
        frameborder="0"
        allowfullscreen>
    </iframe>
</div>

<div style=" position:relative;  background:black; padding: 1.5rem;">
    <div class="container">
        <div class="row row-deck justify-content-center">
        </div>
    </div>
</div>


<div id="carousel-sample" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="0"
        class="active"></button>
        <button type="button" data-bs-target="#carousel-sample"
        data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#carousel-sample"
        data-bs-slide-to="2"></button>
        <button type="button" data-bs-target="#carousel-sample"
        data-bs-slide-to="3"></button>
        <button type="button" data-bs-target="#carousel-sample"
        data-bs-slide-to="4"></button>
        <button type="button" data-bs-target="#carousel-sample"
        data-bs-slide-to="5"></button>
        <button type="button" data-bs-target="#carousel-sample"
        data-bs-slide-to="6"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" alt=""
                src="/assets/images/osprey-gallery/KSP_x64_8CJowORKXR.png" />
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" alt=""
                src="/assets/images/osprey-gallery/KSP_x64_34vnQ9wpeG.png" />
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" alt=""
                src="/assets/images/osprey-gallery/KSP_x64_36auIfWbm8.png" />
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" alt=""
                src="/assets/images/osprey-gallery/KSP_x64_cncFVj4FB2.png" />
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" alt=""
                src="/assets/images/osprey-gallery/KSP_x64_gnRwvstHMU.png" />
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" alt=""
                src="/assets/images/osprey-gallery/KSP_x64_kwMJdqiZQb.png" />
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" alt=""
                src="/assets/images/osprey-gallery/KSP_x64_PA29tjlBMl.png" />
        </div>
    </div>
    <a class="carousel-control-prev" data-bs-target="#carousel-sample"
        role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </a>
    <a class="carousel-control-next" data-bs-target="#carousel-sample"
        role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </a>
</div>