<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/head.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM stats";

    $results = $conn->query($sql);
    
    if ($results->num_rows > 0) {
        $stats = $results->fetch_assoc();
    } else {
        $stats = [
            'completedmissions' => 000,
            'boosterlandings' => 000,
            'boostersreused' => 000,
            'backlog' => 000,
            'spacecraftlaunched' => 000,
            'spacecraftwithcomponents' => 000
        ];
        
    }
?>
<title>Admin Dashboard | Accelerate Space</title>

<div class="content" style="text-align: center; top: 5%; left: 40%;"> 
    <h2 style="color: white;">Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h2>
</div>

<div style="position:relative; background:black; padding: 1.5rem; margin-top: 5rem;">
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
            <div class="col-md-4">
                <div class="card" style="background:rgba(0,0,0,0.0); box-shadow:none; color:white; border:none;">
                    <div class="card-body text-center">
                        <h2 style="font-size:5rem; margin-bottom:2.5rem; margin-top: 1rem;"><count-up><?=htmlspecialchars($stats["backlog"])?></count-up></h2>
                        <p style="margin-bottom: 0; font-size: 1rem;">SPACECRAFT IN <br>BACKLOG</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="background:rgba(0,0,0,0.0); box-shadow:none; color:white; border:none;">
                    <div class="card-body text-center">
                        <h2 style="font-size:5rem; margin-bottom:2.5rem; margin-top: 1rem;"><count-up><?=htmlspecialchars($stats["spacecraftlaunched"])?></count-up></h2>
                        <p style="margin-bottom: 0; font-size: 1rem;">ACCELERATE SPACE <br>SPACECRAFT LAUNCHED</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="background:rgba(0,0,0,0.0); box-shadow:none; color:white; border:none;">
                    <div class="card-body text-center">
                        <h2 style="font-size:5rem; margin-bottom:2.5rem; margin-top: 1rem;"><count-up><?=htmlspecialchars($stats["spacecraftwithcomponents"])?></count-up></h2>
                        <p style="margin-bottom: 0; font-size: 1rem;">SPACECRAFT FEATURING <br>ACCELERATE SPACE <br>SATELLITE COMPONENTS</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content" style="text-align: center; top: 50%; left: 45%;"> 
    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
        data-bs-target="#exampleModal">
        Edit Stats
    </button>
</div>

<div class="modal" id="exampleModal" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <form method="POST" action="update-stats.php">

        <div class="modal-header">
          <h5 class="modal-title">Edit Stats</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <div class="mb-3">
            <label class="form-label">Completed Missions</label>
            <input type="number" class="form-control" name="completedmissions" value=<?=htmlspecialchars($stats["completedmissions"])?>>
          </div>

          <div class="mb-3">
            <label class="form-label">Boosters Landed</label>
            <input type="number" class="form-control" name="boosterlandings" value=<?=htmlspecialchars($stats["boosterlandings"])?>>
          </div>

          <div class="mb-3">
            <label class="form-label">Boosters Reflown</label>
            <input type="number" class="form-control" name="boostersreused" value=<?=htmlspecialchars($stats["boostersreused"])?>>
          </div>

          <div class="mb-3">
            <label class="form-label">Spacecraft in backlog</label>
            <input type="number" class="form-control" name="backlog" value=<?=htmlspecialchars($stats["backlog"])?>>
          </div>

          <div class="mb-3">
            <label class="form-label">Accelerate Space Spacecraft Launched</label>
            <input type="number" class="form-control" name="launched" value=<?=htmlspecialchars($stats["spacecraftlaunched"])?>>
          </div>

          <div class="mb-3">
            <label class="form-label">
              Spacecraft featuring Accelerate Space satellite components
            </label>
            <input type="number" class="form-control" name="components" value=<?=htmlspecialchars($stats["spacecraftwithcomponents"])?>>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">
            Cancel
          </button>

          <button type="submit" class="btn btn-primary ms-auto">
            Update stats
          </button>
        </div>

      </form>

    </div>
  </div>
</div>