<?php

require_once __DIR__ . "/../../config/EmployerAuth.php";
require_once __DIR__ . "/../../model/EmployerModel.php";

requireEmployer();

$m = new EmployerModel();
$stats = $m->companyAnalytics((int)$_SESSION["user_id"]);

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
<title>
Company analytics
</title>

<link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body class="employer-body">

<div class="employer-shell">

<?php include __DIR__ . "/employer_nav.php"; ?>

<div class="employer-main wide">

<h1>
Company recruitment analytics
</h1>

<div class="stat-grid">

<div class="stat-card">
<div class="num">
<?php echo (int)$stats["total_jobs"]; ?>
</div>
<div class="lbl">
Total jobs posted
</div>
</div>

<div class="stat-card">
<div class="num">
<?php echo (int)$stats["total_applications"]; ?>
</div>
<div class="lbl">
Total applications received
</div>
</div>

<div class="stat-card">
<div class="num">
<?php

echo $stats["avg_days_to_shortlist"] !== null
    ? htmlspecialchars((string)$stats["avg_days_to_shortlist"])
    : "—";

?>
</div>
<div class="lbl">
Avg. days from application date (shortlisted)
</div>
</div>

</div>

<p class="hint">
Per-job funnels are on each job’s analytics page.
</p>

</div>

</div>

</body>
</html>
