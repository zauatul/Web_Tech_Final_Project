<?php

include_once __DIR__ .
"/../../config/SeekerAuth.php";

include_once __DIR__ .
"/../../model/SeekerModel.php";

requireSeeker();

$applied =
listAppliedJobs((int)$_SESSION["user_id"]);

$saved =
listSavedJobs((int)$_SESSION["user_id"]);

?>

<!DOCTYPE html>
<html>
<head>

<title>
Seeker Dashboard
</title>

<link rel="stylesheet"
href="../../assets/css/style.css">

</head>

<body>

<div class="container">

<h1>
Seeker Dashboard
</h1>

<h3>
Welcome
<?php echo htmlspecialchars($_SESSION["user_name"] ?? ""); ?>
</h3>

<div class="card">
Applied jobs:
<?php echo (int)$applied->num_rows; ?>
</div>

<div class="card">
Saved jobs:
<?php echo (int)$saved->num_rows; ?>
</div>

<?php include __DIR__ . "/seeker_nav.php"; ?>

<ul class="dashboard-links">

<li>
<a href="jobs.php">
View active jobs
</a>
</li>

<li>
<a href="profile.php">
Update profile and resume
</a>
</li>

</ul>

</div>

</body>
</html>
