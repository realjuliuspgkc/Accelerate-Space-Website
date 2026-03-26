<?php 
include('head.php');
require('db.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$nameErr = $emailErr = $companyErr = $countryErr = $targetErr = $readyErr = $massErr = $incErr = $altErr = $craftfileErr = $tcErr ="";

$name = $company = $origincountry = $email = $targetdate = $payloadreadydate = $payloadmass = $inclination = $altitude = $launchdetail = $craftfile = $termsConds ="";

$submitted = false;

function test_input($data) {
  return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $hasError = false;

  // --- anti-spam checks ---
  $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
  $now = time();

  // honeypot: should be empty
  if (!empty($_POST['hp'] ?? '')) {
    $hasError = true;
    $craftfileErr = 'Spam detected (honeypot)';
  }

  // minimum fill time: require at least 5 seconds between render and submit
  $form_ts = (int)($_POST['form_ts'] ?? 0);
  if ($form_ts > 0 && ($now - $form_ts) < 5) {
    $hasError = true;
    $craftfileErr = 'Form submitted too quickly; please try again.';
  }

  // simple per-IP throttle (30s)
  $tmpfile = sys_get_temp_dir() . '/launch_submissions.json';
  $submissions = [];
  if (file_exists($tmpfile)) {
    $raw = @file_get_contents($tmpfile);
    $submissions = $raw ? json_decode($raw, true) : [];
    if (!is_array($submissions)) $submissions = [];
  }
  $last = isset($submissions[$ip]) ? (int)$submissions[$ip] : 0;
  if ($last && ($now - $last) < 30) {
    $hasError = true;
    $craftfileErr = 'You are submitting too frequently; please wait before trying again.';
  }

  $name = test_input($_POST['name'] ?? '');
  if ($name === '') { $nameErr = 'Name is required'; $hasError = true; }

  $company = test_input($_POST['company'] ?? '');
  if ($company === '') { $companyErr = 'Company is required'; $hasError = true; }

  $origincountry = test_input($_POST['origincountry'] ?? '');
  if ($origincountry === '') { $countryErr = 'Country of Origin is required'; $hasError = true; }

  $email = test_input($_POST['email'] ?? '');
  if ($email === '') { $emailErr = 'Email is required'; $hasError = true; }
  elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $emailErr = 'Invalid email format'; $hasError = true; }

  $targetdate = test_input($_POST['targetdate'] ?? '');
  if ($targetdate === '') { $targetErr = 'Target Launch date is required'; $hasError = true; }

  $payloadreadydate = test_input($_POST['payloadreadydate'] ?? '');
  if ($payloadreadydate === '') { $readyErr = 'Payload Readiness Date is required'; $hasError = true; }

  $payloadmass = test_input($_POST['payloadmass'] ?? '');
  if ($payloadmass === '') { $massErr = 'Payload mass is required'; $hasError = true; }

  $inclination = test_input($_POST['inclination'] ?? '');
  if ($inclination === '') { $incErr = 'Inclination is required'; $hasError = true; }

  $altitude = test_input($_POST['altitude'] ?? '');
  if ($altitude === '') { $altErr = 'Altitude is required'; $hasError = true; }

  $launchdetail = test_input($_POST['launchdetail'] ?? '');

  $craftfile = test_input($_POST['craftfile'] ?? '');
  if ($craftfile === '') { $craftfileErr = 'Craft File is required'; $hasError = true; }

  $termsConds = test_input($_POST['termsConds'] ?? '');
  if ($termsConds === '') { $tcErr = 'Terms and Conditions are required'; $hasError = true; }

  if (! $hasError) {
    // record throttle timestamp (will be updated on successful insert below as well)
    $submissions[$ip] = $now;
    @file_put_contents($tmpfile, json_encode($submissions));
    $stmt = $conn->prepare("INSERT INTO launch_orders (name, company, origincountry, email, targetdate, payloadreadydate, payloadmass, inclination, altitude, launchdetails, craftfile) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
      echo 'Prepare failed: ' . htmlspecialchars($conn->error);
    } else {
      $stmt->bind_param('sssssssssss', $name, $company, $origincountry, $email, $targetdate, $payloadreadydate, $payloadmass, $inclination, $altitude, $launchdetail, $craftfile);
      if ($stmt->execute()) {
        $submissions[$ip] = time();
        @file_put_contents($tmpfile, json_encode($submissions));
        $submitted = true;

        $message = "New launch booking submission:\n \nYou must reply to this email for your booking to be confirmed.\n\nName: $name\nCompany: $company\nCountry of Origin: $origincountry\nEmail: $email\nTarget Date: $targetdate\nPayload Readiness Date: $payloadreadydate\nPayload Mass: $payloadmass\nInclination: $inclination\nAltitude: $altitude\nLaunch Details:\n$launchdetail\nCraft File: $craftfile \n\nBest regards,\nThe Accelerate Space Team";
        require 'src/Exception.php';
        require 'src/PHPMailer.php.filepart';
        require 'src/SMTP.php';

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.livemail.co.uk';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'noreply@acceleratespace.org';
            $mail->Password   = 'nwXQpWssmu2YzH';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('noreply@acceleratespace.org', 'Accelerate Space');
            $mail->addAddress($email);
            $mail->addReplyTo('enquiries@acceleratespace.org');

            $mail->isHTML(false);
            $mail->Subject = 'New Launch Booking Submission';
            $mail->Body    = "Name: $name\nEmail: $email\n\nMessage:\n$message";

            $mail->send();

        } catch (Exception $e) {
            echo "Mailer Error: {$mail->ErrorInfo}";
        }

      } else {
        echo 'Execute failed: ' . htmlspecialchars($stmt->error);
      }
      $stmt->close();
    }
  }
}
?>



<title>Launch with us | Accelerate Space</title>


<?php if (!empty($submitted) && $submitted): ?>
  <div class="form-success">
    <h2>Thank you — your launch request has been received.</h2>
    <p>We will contact you at <?php echo htmlspecialchars($email); ?> with next steps.</p>
  </div>
<?php else: ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" style="padding: 15px;">
  <div style="padding: 15px; gap: 15px;" >
    <div class="card card-sm bg-black">
    <div class="card-body">
      <p style="color: white;">Discord username: </p><input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" class="form-control">
      <span class="error">* <?php echo $nameErr;?></span><br>
    </div>
  </div>
  <div class="card card-sm bg-black">
    <div class="card-body">
    <p style="color: white;">Company:</p> <input type="text" name="company" value="<?php echo htmlspecialchars($company); ?>" class="form-control">
    <span class="error">* <?php echo $companyErr;?></span><br>
  </div>
</div>
  <div class="card card-sm bg-black">
    <div class="card-body"> 
    <p style="color: white;">Country of Origin: <input type="text" name="origincountry" value="<?php echo htmlspecialchars($origincountry); ?>" class="form-control">
    <span class="error">* <?php echo $countryErr;?></span><br>
  </div>
</div>
  <div class="card card-sm bg-black">
    <div class="card-body"> 
    <p style="color: white;">E-mail: <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>" class="form-control">
    <span class="error">* <?php echo $emailErr;?></span><br>
  </div>
</div>
  <div class="card card-sm bg-black">
    <div class="card-body"> 
    <p style="color: white;">Target Date: <input type="text" name="targetdate" value="<?php echo htmlspecialchars($targetdate); ?>" class="form-control">
    <span class="error">* <?php echo $targetErr;?></span><br>
  </div>
</div>
  <div class="card card-sm bg-black">
    <div class="card-body"> 
    <p style="color: white;">Payload Readiness Date: <input type="text" name="payloadreadydate" value="<?php echo htmlspecialchars($payloadreadydate); ?>" class="form-control">
    <span class="error">* <?php echo $readyErr;?></span><br>
  </div>
</div>
  <div class="card card-sm bg-black">
    <div class="card-body"> 
    <p style="color: white;">Payload Mass: <input type="text" name="payloadmass" value="<?php echo htmlspecialchars($payloadmass); ?>" class="form-control">
    <span class="error">* <?php echo $massErr;?></span><br>
  </div>
</div>
  <div class="card card-sm bg-black">
    <div class="card-body"> 
    <p style="color: white;">Inclination (°): <input type="text" name="inclination" value="<?php echo htmlspecialchars($inclination); ?>" class="form-control">
    <span class="error">* <?php echo $incErr;?></span><br>
  </div>
</div>
  <div class="card card-sm bg-black">
    <div class="card-body"> 
    <p style="color: white;">Altitude (km): <input type="text" name="altitude" value="<?php echo htmlspecialchars($altitude); ?>" class="form-control">
    <span class="error">* <?php echo $altErr;?></span><br>
  </div>
</div>
  <div class="card card-sm bg-black">
    <div class="card-body"> 
    <p style="color: white;">Launch Details: <textarea name="launchdetail" rows="5" cols="40" class="form-control"><?php echo htmlspecialchars($launchdetail); ?></textarea><br>
  </div>
  </div>
  <div class="card card-sm bg-black">
    <div class="card-body"> 
    <p style="color: white;">Craft File (Google Drive Link only): <input type="text" name="craftfile" value="<?php echo htmlspecialchars($craftfile); ?>" class="form-control">
    <span class="error">* <?php echo $craftfileErr;?></span><br>
    <label for="craftfile">Non google drive links will not be accepted and will be rejected. Only stock crafts or crafts made using <a href="/assets/AcceleratePayload.ckan" download>Accelerate Payload CKAN file</a> will be accepted.</label><br>
  </div>
</div>
  <div class="card card-sm bg-black">
    <div class="card-body"> 
    <label class="form-check">
      <input type="checkbox" class="form-check-input" name="termsConds" />
      <p style="color: white;">I agree to the <a href="/assets/Accelerate Space Payload Submission Terms.pdf" target="_blank" rel="noopener noreferrer" style="text-decoration: underline;" style="color: white;">Terms & Conditions</a></p><span class="error">* <?php echo $tcErr;?></span><br>
    </label>
</div>
</div>
    <input type="submit" class="btn" value="Submit">
</div>
</form>
<?php endif; ?>
