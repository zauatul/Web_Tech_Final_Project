<?php

require_once __DIR__ . "/../../config/EmployerAuth.php";
require_once __DIR__ . "/../../model/EmployerModel.php";

requireEmployer();

$jobId = isset($_GET["job_id"]) ? (int)$_GET["job_id"] : 0;

if($jobId <= 0)
{
    header("location:dashboard.php");
    exit();
}

$m = new EmployerModel();
$userId = (int)$_SESSION["user_id"];
$job = $m->getJobForEmployer($jobId, $userId);

if(!$job)
{
    header("location:dashboard.php");
    exit();
}

$st = $_GET["status"] ?? "";
$exp = $_GET["exp"] ?? "";
$df = $_GET["date_from"] ?? "";
$dt = $_GET["date_to"] ?? "";

$list = $m->getApplicationsForJob($jobId, $userId, $st, $exp, $df, $dt);

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
<title>
Applications —
<?php echo htmlspecialchars($job["title"]); ?>
</title>

<link rel="stylesheet" href="../../assets/css/style.css">
<script src="../../assets/js/employer.js"></script>

</head>

<body class="employer-body">

<div class="employer-shell">

<?php include __DIR__ . "/employer_nav.php"; ?>

<div class="employer-main wide">

<h1>
Applications
</h1>

<p class="sub">
Job:
<?php echo htmlspecialchars($job["title"]); ?>

</p>

<form method="get" class="filter-bar">

<input type="hidden" name="job_id" value="<?php echo $jobId; ?>">

<label>
Status
</label>

<select name="status">

<option value="">All</option>

<?php

$statuses =
[
    "submitted",
    "reviewed",
    "shortlisted",
    "interview",
    "rejected",
    "withdrawn"
];

foreach($statuses as $s)
{

    $sel = $st === $s ? " selected" : "";
    echo "<option value=\"" . htmlspecialchars($s) . "\"" . $sel . ">" . htmlspecialchars($s) . "</option>";

}

?>

</select>

<label>
Experience (years)
</label>

<select name="exp">

<option value="">All</option>
<option value="entry"<?php echo $exp === "entry" ? " selected" : ""; ?>>Entry (0–2)</option>
<option value="mid"<?php echo $exp === "mid" ? " selected" : ""; ?>>Mid (3–5)</option>
<option value="senior"<?php echo $exp === "senior" ? " selected" : ""; ?>>Senior (6+)</option>

</select>

<label>
Applied from
</label>
<input type="date" name="date_from" value="<?php echo htmlspecialchars($df); ?>">

<label>
Applied to
</label>
<input type="date" name="date_to" value="<?php echo htmlspecialchars($dt); ?>">

<input type="submit" value="Filter">

</form>

<table class="employer-table">

<tr>
<th>Applicant</th>
<th>Email</th>
<th>Years exp.</th>
<th>Applied</th>
<th>Status</th>
<th></th>
</tr>

<?php

while($a = $list->fetch_assoc())
{

?>

<tr>

<td>
<?php echo htmlspecialchars($a["seeker_name"]); ?>
</td>

<td>
<?php echo htmlspecialchars($a["seeker_email"]); ?>
</td>

<td>
<?php echo (int)$a["years_experience"]; ?>
</td>

<td>
<?php echo htmlspecialchars($a["applied_at"]); ?>
</td>

<td>

<select id="app-status-<?php echo (int)$a["id"]; ?>" onchange="employerApplicationStatus(<?php echo (int)$a["id"]; ?>, this.value)">

<?php

foreach($statuses as $s)
{

    $sel = $a["status"] === $s ? " selected" : "";
    echo "<option value=\"" . htmlspecialchars($s) . "\"" . $sel . ">" . htmlspecialchars($s) . "</option>";

}

?>

</select>

</td>

<td>

<a href="applicant.php?id=<?php echo (int)$a["id"]; ?>">
Profile
</a>

<a href="messages.php?application_id=<?php echo (int)$a["id"]; ?>">
Messages
</a>

</td>

</tr>

<?php

}

?>

</table>

<p>
<a href="dashboard.php">Back to dashboard</a>
</p>

</div>

</div>

</body>
</html>
