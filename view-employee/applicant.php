<?php

require_once __DIR__ . "/../../config/EmployerAuth.php";
require_once __DIR__ . "/../../model/EmployerModel.php";

requireEmployer();

$appId = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

if($appId <= 0)
{
    header("location:dashboard.php");
    exit();
}

$m = new EmployerModel();
$userId = (int)$_SESSION["user_id"];
$row = $m->getApplicationDetail($appId, $userId);

if(!$row)
{
    header("location:dashboard.php");
    exit();
}

$resumePath = ($row["resume_path"] ?? "") ?: ($row["seeker_resume_path"] ?? "");

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
<title>
Applicant —
<?php echo htmlspecialchars($row["seeker_name"]); ?>
</title>

<link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body class="employer-body">

<div class="employer-shell">

<?php include __DIR__ . "/employer_nav.php"; ?>

<div class="employer-main wide">

<h1>
Applicant
</h1>

<p class="sub">
Job:
<?php echo htmlspecialchars($row["job_title"]); ?>

</p>

<h2>
<?php echo htmlspecialchars($row["seeker_name"]); ?>

</h2>

<p>
<?php echo htmlspecialchars($row["seeker_email"]); ?>

·
<?php echo htmlspecialchars($row["seeker_phone"] ?? ""); ?>

</p>

<h3>
Seeker profile
</h3>

<p>
<strong>Headline:</strong>

<?php echo htmlspecialchars($row["headline"] ?? ""); ?>

</p>

<p>
<strong>Summary:</strong>

<?php echo nl2br(htmlspecialchars($row["summary"] ?? "")); ?>

</p>

<p>
<strong>Skills:</strong>

<?php echo htmlspecialchars($row["skills"] ?? ""); ?>

</p>

<p>
<strong>Years experience:</strong>

<?php echo (int)($row["years_experience"] ?? 0); ?>

·
<strong>Education:</strong>

<?php echo htmlspecialchars($row["education_level"] ?? ""); ?>

</p>

<h3>
Cover letter
</h3>

<div class="cover-box">
<?php echo nl2br(htmlspecialchars($row["cover_letter"] ?? "")); ?>
</div>

<h3>
Resume
</h3>

<?php

if($resumePath)
{
    echo "<p><a class=\"btn-link\" href=\"download_resume.php?application_id=" . (int)$appId . "\">Download resume</a></p>";
}
else
{
    echo "<p class=\"hint\">No resume on file.</p>";
}

?>

<p>
<a href="applications.php?job_id=<?php echo (int)$row["job_id"]; ?>">
Back to applications
</a>
</p>

</div>

</div>

</body>
</html>
