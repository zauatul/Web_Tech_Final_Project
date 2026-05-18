<?php

require_once __DIR__ . "/../../config/EmployerAuth.php";
require_once __DIR__ . "/../../model/EmployerModel.php";

requireEmployer();

$m = new EmployerModel();
$userId = (int)$_SESSION["user_id"];
$editId = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
$job = null;

if($editId > 0)
{
    $job = $m->getJobForEmployer($editId, $userId);
}

$cats = $m->listCategories();

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
<title>
<?php echo $job ? "Edit job" : "New job"; ?>
</title>

<link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body class="employer-body">

<div class="employer-shell">

<?php include __DIR__ . "/employer_nav.php"; ?>

<div class="employer-main wide">

<h1>
<?php echo $job ? "Edit job posting" : "New job posting"; ?>
</h1>

<?php

if(!empty($_GET["err"]))
{
    echo "<p class=\"msg err\">Please complete required fields.</p>";
}

?>

<form method="post" action="../../controller/employee/EmployerJobController.php">

<?php

if($job)
{
    echo "<input type=\"hidden\" name=\"job_id\" value=\"" . (int)$job["id"] . "\">";
}

?>

<label>
Title
</label>
<input type="text" name="title" required value="<?php echo htmlspecialchars($job["title"] ?? ""); ?>">

<label>
Category
</label>
<select name="category_id" required>

<option value="">
Select category
</option>

<?php

while($c = $cats->fetch_assoc())
{

    $sel = $job && (int)$job["category_id"] === (int)$c["id"]
        ? " selected"
        : "";

    echo "<option value=\"" . (int)$c["id"] . "\"" . $sel . ">";
    echo htmlspecialchars($c["name"]);
    echo "</option>";

}

?>

</select>

<label>
Description
</label>
<textarea name="description" rows="6" required><?php echo htmlspecialchars($job["description"] ?? ""); ?></textarea>

<label>
Requirements
</label>
<textarea name="requirements" rows="4"><?php echo htmlspecialchars($job["requirements"] ?? ""); ?></textarea>

<label>
Benefits
</label>
<textarea name="benefits" rows="3"><?php echo htmlspecialchars($job["benefits"] ?? ""); ?></textarea>

<div class="grid-2">

<div>

<label>
Salary min
</label>
<input type="number" name="salary_min" value="<?php echo (int)($job["salary_min"] ?? 0); ?>">

</div>

<div>

<label>
Salary max
</label>
<input type="number" name="salary_max" value="<?php echo (int)($job["salary_max"] ?? 0); ?>">

</div>

</div>

<label>
Location
</label>
<input type="text" name="location" value="<?php echo htmlspecialchars($job["location"] ?? ""); ?>">

<label>
Job type
</label>

<select name="job_type">

<?php

$types =
[
    "full-time",
    "part-time",
    "remote",
    "contract"
];

foreach($types as $t)
{

    $sel = ($job["job_type"] ?? "full-time") === $t ? " selected" : "";
    echo "<option value=\"" . htmlspecialchars($t) . "\"" . $sel . ">" . htmlspecialchars($t) . "</option>";

}

?>

</select>

<label>
Experience level
</label>

<select name="experience_level">

<?php

$levels = ["entry", "mid", "senior"];

foreach($levels as $lv)
{

    $sel = ($job["experience_level"] ?? "entry") === $lv ? " selected" : "";
    echo "<option value=\"" . htmlspecialchars($lv) . "\"" . $sel . ">" . htmlspecialchars($lv) . "</option>";

}

?>

</select>

<label>
Application deadline
</label>
<input type="date" name="deadline" required value="<?php echo htmlspecialchars(substr($job["deadline"] ?? "", 0, 10)); ?>">

<div class="form-actions">

<input type="submit" name="draft" value="Save as draft">
<input type="submit" name="publish" value="Publish (active)">

</div>

</form>

<p>
<a href="dashboard.php">Back to dashboard</a>
</p>

</div>

</div>

</body>
</html>
