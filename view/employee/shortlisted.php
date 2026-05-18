<?php

require_once __DIR__ . "/../../config/EmployerAuth.php";
require_once __DIR__ . "/../../model/EmployerModel.php";

requireEmployer();

$m = new EmployerModel();
$rows = $m->listShortlistedAllJobs((int)$_SESSION["user_id"]);

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
<title>
Shortlisted candidates
</title>

<link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body class="employer-body">

<div class="employer-shell">

<?php include __DIR__ . "/employer_nav.php"; ?>

<div class="employer-main wide">

<h1>
Shortlisted &amp; interview pipeline
</h1>

<p class="hint">
Candidates marked shortlisted or interview across all your jobs.
</p>

<table class="employer-table">

<tr>
<th>Candidate</th>
<th>Job</th>
<th>Status</th>
<th>Applied</th>
<th></th>
</tr>

<?php

while($r = $rows->fetch_assoc())
{

?>

<tr>

<td>
<?php echo htmlspecialchars($r["seeker_name"]); ?>

<br>
<span class="muted">
<?php echo htmlspecialchars($r["headline"] ?? ""); ?>
</span>

</td>

<td>
<?php echo htmlspecialchars($r["job_title"]); ?>
</td>

<td>
<?php echo htmlspecialchars($r["status"]); ?>
</td>

<td>
<?php echo htmlspecialchars($r["applied_at"]); ?>
</td>

<td>

<a href="applicant.php?id=<?php echo (int)$r["application_id"]; ?>">
Profile
</a>

<a href="messages.php?application_id=<?php echo (int)$r["application_id"]; ?>">
Messages
</a>

<a href="applications.php?job_id=<?php echo (int)$r["job_id"]; ?>">
Job applications
</a>

</td>

</tr>

<?php

}

?>

</table>

</div>

</div>

</body>
</html>
