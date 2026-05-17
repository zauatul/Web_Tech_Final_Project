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

$funnel = $m->funnelCountsForJob($jobId, $userId);
$timelineRes = $m->applicationsOverTimeForJob($jobId, $userId);
$timelineRows = [];

while($t = $timelineRes->fetch_assoc())
{
    $timelineRows[] = $t;
}

$submitted = (int)($funnel["submitted"] ?? 0);
$reviewed = (int)($funnel["reviewed"] ?? 0);
$shortlisted = (int)($funnel["shortlisted"] ?? 0);
$interview = (int)($funnel["interview"] ?? 0);
$rejected = (int)($funnel["rejected"] ?? 0);
$withdrawn = (int)($funnel["withdrawn"] ?? 0);

$total = array_sum($funnel) ?: 1;

function pct($n, $d)
{

    return round(100 * $n / $d, 1);

}

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
<title>
Job analytics
</title>

<link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body class="employer-body">

<div class="employer-shell">

<?php include __DIR__ . "/employer_nav.php"; ?>

<div class="employer-main wide">

<h1>
Hiring analytics
</h1>

<p class="sub">
<?php echo htmlspecialchars($job["title"]); ?>
</p>

<h2>
Application funnel
</h2>

<p class="hint">
Counts by current application status.
</p>

<table class="employer-table funnel">

<tr>
<th>Stage</th>
<th>Count</th>
<th>% of all applications</th>
</tr>

<tr>
<td>Submitted</td>
<td><?php echo $submitted; ?></td>
<td><?php echo pct($submitted, $total); ?>%</td>
</tr>

<tr>
<td>Reviewed</td>
<td><?php echo $reviewed; ?></td>
<td><?php echo pct($reviewed, $total); ?>%</td>
</tr>

<tr>
<td>Shortlisted</td>
<td><?php echo $shortlisted; ?></td>
<td><?php echo pct($shortlisted, $total); ?>%</td>
</tr>

<tr>
<td>Interview</td>
<td><?php echo $interview; ?></td>
<td><?php echo pct($interview, $total); ?>%</td>
</tr>

<tr>
<td>Rejected</td>
<td><?php echo $rejected; ?></td>
<td><?php echo pct($rejected, $total); ?>%</td>
</tr>

<tr>
<td>Withdrawn</td>
<td><?php echo $withdrawn; ?></td>
<td><?php echo pct($withdrawn, $total); ?>%</td>
</tr>

</table>

<h2>
Conversion (approx.)
</h2>

<p class="hint">
Using submitted count as baseline when available.
</p>

<ul class="stat-list">

<li>
Submitted → reviewed:
<?php echo $submitted ? pct($reviewed, max(1, $submitted + $reviewed)) : "—"; ?>%
</li>

<li>
Reviewed → shortlisted:
<?php echo ($reviewed + $shortlisted) ? pct($shortlisted, max(1, $reviewed + $shortlisted)) : "—"; ?>%
</li>

<li>
Shortlisted → interview:
<?php echo ($shortlisted + $interview) ? pct($interview, max(1, $shortlisted + $interview)) : "—"; ?>%
</li>

</ul>

<h2>
Applications over time
</h2>

<table class="employer-table">

<tr>
<th>Date</th>
<th>Applications</th>
<th>Bar</th>
</tr>

<?php

$maxBar = 1;

foreach($timelineRows as $t)
{

    if((int)$t["c"] > $maxBar)
    {
        $maxBar = (int)$t["c"];
    }

}

foreach($timelineRows as $t)
{

    $w = (int)round(100 * (int)$t["c"] / $maxBar);

?>

<tr>

<td>
<?php echo htmlspecialchars($t["d"]); ?>
</td>

<td>
<?php echo (int)$t["c"]; ?>
</td>

<td class="bar-cell">
<div class="bar" style="width:<?php echo $w; ?>%"></div>
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
