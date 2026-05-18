<?php

require_once __DIR__ . "/../../config/EmployerAuth.php";
require_once __DIR__ . "/../../model/EmployerModel.php";

requireEmployer();

$m = new EmployerModel();
$jobs = $m->listJobsDashboard((int)$_SESSION["user_id"]);

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
<title>
Hiring dashboard
</title>

<link rel="stylesheet" href="../../assets/css/style.css">
<script src="../../assets/js/employer.js"></script>

</head>

<body class="employer-body">

<div class="employer-shell">

<?php include __DIR__ . "/employer_nav.php"; ?>

<div class="employer-main">

<h1>
Job postings
</h1>

<p class="sub">
Signed in as
<?php echo htmlspecialchars($_SESSION["user_name"] ?? ""); ?>

<?php

if(!empty($_GET["created"]))
{
    echo "<span class=\"msg ok\">Job created.</span>";
}

if(!empty($_GET["updated"]))
{
    echo "<span class=\"msg ok\">Job updated.</span>";
}

?>

</p>

<p>
<a class="btn-link" href="job_form.php">Create new job</a>
</p>

<div class="table-scroll">

<table class="employer-table">

<tr>
<th>Title</th>
<th>Status</th>
<th>Applications</th>
<th>Days to deadline</th>
<th>Actions</th>
</tr>

<?php

$now = time();

while($row = $jobs->fetch_assoc())
{

    $deadlineTs = strtotime($row["deadline"] ?? "");
    $daysLeft = $deadlineTs
        ? (int)floor(($deadlineTs - $now) / 86400)
        : null;
    $daysLabel = $daysLeft === null
        ? "—"
        : ($daysLeft < 0 ? "Past (" . abs($daysLeft) . "d ago)" : $daysLeft . "d");

?>

<tr>

<td>
<?php echo htmlspecialchars($row["title"]); ?>
</td>

<td>
<span id="job-status-<?php echo (int)$row["id"]; ?>">
<?php echo htmlspecialchars($row["status"]); ?>
</span>
<?php

if($row["status"] !== "draft")
{

?>
<button type="button" class="btn-small" onclick="employerToggleJob(<?php echo (int)$row["id"]; ?>)">
Toggle active / closed
</button>
<?php

}

?>

</td>

<td>
<?php echo (int)$row["app_count"]; ?>
</td>

<td>
<?php echo htmlspecialchars($daysLabel); ?>
</td>

<td class="cell-actions">

<a href="applications.php?job_id=<?php echo (int)$row["id"]; ?>">
Applications
</a>

<a href="analytics_job.php?job_id=<?php echo (int)$row["id"]; ?>">
Analytics
</a>

<a href="job_form.php?id=<?php echo (int)$row["id"]; ?>">
Edit
</a>

<form method="post" action="../../controller/employee/EmployerJobController.php" class="inline-form" onsubmit="return confirm('Delete this job?');">
<input type="hidden" name="action" value="delete">
<input type="hidden" name="job_id" value="<?php echo (int)$row["id"]; ?>">
<input type="submit" class="btn-danger" value="Delete">
</form>

<?php

if($row["status"] === "closed")
{

?>

<form method="post" action="../../controller/employee/EmployerJobController.php" class="inline-form">
<input type="hidden" name="action" value="repost">
<input type="hidden" name="job_id" value="<?php echo (int)$row["id"]; ?>">
<input type="submit" value="Repost">
</form>

<?php

}

?>

<form method="post" action="../../controller/employee/EmployerJobController.php" class="inline-form">
<input type="hidden" name="action" value="close">
<input type="hidden" name="job_id" value="<?php echo (int)$row["id"]; ?>">
<input type="submit" value="Close">
</form>

</td>

</tr>

<?php

}

?>

</table>

</div>

</div>

</div>

</body>
</html>
