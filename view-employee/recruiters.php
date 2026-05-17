<?php

require_once __DIR__ . "/../../config/EmployerAuth.php";
require_once __DIR__ . "/../../model/EmployerModel.php";

requireEmployer();

$m = new EmployerModel();
$userId = (int)$_SESSION["user_id"];
$clients = $m->listRecruitersForCompany($userId);
$recruiterJobs = $m->listJobsPostedByRecruiters($userId);

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
<title>
Recruiter relationships
</title>

<link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body class="employer-body">

<div class="employer-shell">

<?php include __DIR__ . "/employer_nav.php"; ?>

<div class="employer-main wide">

<h1>
Recruiter agencies
</h1>

<p class="hint">
Recruiters linked to your company (from
<code>
recruiter_clients
</code>
) and jobs they posted on your behalf (
<code>
jobs.recruiter_id
</code>
).
</p>

<h2>
Linked recruiters
</h2>

<table class="employer-table">

<tr>
<th>Agency / contact</th>
<th>Email</th>
<th>Company override</th>
<th>Linked since
</th>
</tr>

<?php

while($c = $clients->fetch_assoc())
{

?>

<tr>

<td>
<?php echo htmlspecialchars($c["agency_name"] ?: $c["name"]); ?>
</td>

<td>
<?php echo htmlspecialchars($c["email"]); ?>
</td>

<td>
<?php echo htmlspecialchars($c["company_name_override"] ?? ""); ?>
</td>

<td>
<?php echo htmlspecialchars($c["added_at"] ?? ""); ?>
</td>

</tr>

<?php

}

?>

</table>

<h2>
Jobs posted by recruiters for you
</h2>

<table class="employer-table">

<tr>
<th>Job</th>
<th>Recruiter</th>
<th>Agency</th>
<th>Status</th>
<th>Created
</th>
</tr>

<?php

while($j = $recruiterJobs->fetch_assoc())
{

?>

<tr>

<td>
<?php echo htmlspecialchars($j["title"]); ?>
</td>

<td>
<?php echo htmlspecialchars($j["recruiter_name"]); ?>
</td>

<td>
<?php echo htmlspecialchars($j["agency_name"] ?? ""); ?>
</td>

<td>
<?php echo htmlspecialchars($j["status"]); ?>
</td>

<td>
<?php echo htmlspecialchars($j["created_at"]); ?>
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
