<?php

session_start();

include_once "../../controller/recruiter/RecruiterOutreachController.php";

if(isset($_SESSION["role"]))
{
    if($_SESSION["role"] != "recruiter")
    {
        header("location: login.php");
    }
}

$seekerId = 0;

if(isset($_GET["id"]))
{
    $seekerId = (int)$_GET["id"];
}

$row = getSeekerProfile($seekerId);

if(!$row)
{
    header("location:search_seekers.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">

<title>Seeker Profile</title>

<link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body class="employer-body">

<div class="employer-shell">

<?php include __DIR__ . "/recruiter_nav.php"; ?>

<div class="employer-main wide">

<h1>Seeker Profile</h1>

<h2><?php echo $row["name"]; ?></h2>

<p><?php echo $row["email"]; ?> | <?php echo $row["phone"]; ?></p>

<div class="card">

<p><strong>Headline:</strong> <?php echo $row["headline"]; ?></p>

<p><strong>Summary:</strong> <?php echo nl2br($row["summary"]); ?></p>

<p><strong>Skills:</strong> <?php echo $row["skills"]; ?></p>

<p><strong>Experience:</strong> <?php echo $row["years_experience"]; ?> years</p>

<p><strong>Education:</strong> <?php echo $row["education_level"]; ?></p>

<p><strong>Preferred Location:</strong> <?php echo $row["preferred_location"]; ?></p>

</div>

<h2>Send Outreach</h2>

<form method="post">

<input type="hidden" name="seeker_id" value="<?php echo $row["id"]; ?>">

<label>Subject</label>

<input type="text" name="subject" value="<?php echo $subject; ?>">

<span class="msg err"><?php echo $subjectErr; ?></span>

<label>Message</label>

<textarea name="message" rows="5"><?php echo $message; ?></textarea>

<span class="msg err"><?php echo $messageErr; ?></span>

<input type="submit" value="Send Message">

</form>

<?php

if($success != "")
{
    echo "<p class='msg ok'>$success</p>";
}

?>

<?php

if($outreachErr != "")
{
    echo "<p class='msg err'>$outreachErr</p>";
}

?>

<p><a href="search_seekers.php">Back to Search</a></p>

</div>

</div>

</body>

</html>