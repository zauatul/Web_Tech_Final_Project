<?php
session_start();

// include_once __DIR__ . "/../../config/RecruiterAuth.php";
include_once __DIR__ . "/../../model/RecruiterModel.php";

//requireRecruiter();

$recruiterId = $_SESSION["user_id"];

$clients = listClients($recruiterId);
$jobs = listPostedJobs($recruiterId);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">

<title>Recruiter Dashboard</title>

<link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body class="employer-body">

<div class="employer-shell">

<?php include __DIR__ . "/recruiter_nav.php"; ?>

<div class="employer-main wide">

<h1>Recruiter Dashboard</h1>

<div class="stat-grid">

<div class="stat-card">
<div class="num"><?php echo mysqli_num_rows($clients); ?></div>
<div class="lbl">Clients</div>
</div>

<div class="stat-card">
<div class="num"><?php echo mysqli_num_rows($jobs); ?></div>
<div class="lbl">Posted Jobs</div>
</div>

</div>

<h2>Recent Jobs</h2>

<table class="employer-table">

<tr>
<th>Job</th>
<th>Client</th>
<th>Status</th>
<th>Created</th>
</tr>

<?php

while($j = mysqli_fetch_assoc($jobs))
{

?>

<tr>
<td><?php echo htmlspecialchars($j["title"]); ?></td>
<td><?php echo htmlspecialchars($j["company_name"]); ?></td>
<td><?php echo htmlspecialchars($j["status"]); ?></td>
<td><?php echo htmlspecialchars($j["created_at"]); ?></td>
</tr>

<?php

}

?>

</table>

</div>

</div>

</body>
</html>