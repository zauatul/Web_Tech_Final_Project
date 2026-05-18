<?php

include_once __DIR__ .
"/../../config/SeekerAuth.php";

include_once __DIR__ .
"/../../model/SeekerModel.php";

requireSeeker();

$keyword =
trim($_GET["q"] ?? "");

$jobs =
listActiveJobs($keyword);

$profile =
getProfile((int)$_SESSION["user_id"]);

?>

<!DOCTYPE html>
<html>
<head>

<title>
Active Jobs
</title>

<link rel="stylesheet"
href="../../assets/css/style.css">

<script src="../../assets/js/seeker.js">
</script>

</head>

<body>

<div class="table-container">

<h1>
Active Jobs
</h1>

<?php include __DIR__ . "/seeker_nav.php"; ?>

<?php

if(!empty($_GET["err"]) && $_GET["err"] === "applied")
{
    echo "<p class=\"msg err\">You have already applied for this job.</p>";
}

?>

<form method="GET">

<label>
Search
</label>

<input type="text"
name="q"
value="<?php echo htmlspecialchars($keyword); ?>"
placeholder="title, location">

<input type="submit"
value="Search">

</form>

<table>

<tr>
<th>Job</th>
<th>Company</th>
<th>Location</th>
<th>Type</th>
<th>Deadline</th>
<th>Actions</th>
</tr>

<?php

while($j =
$jobs->fetch_assoc())
{

?>

<tr>

<td>
<?php echo htmlspecialchars($j["title"]); ?>
</td>

<td>
<?php echo htmlspecialchars($j["employer_name"]); ?>
</td>

<td>
<?php echo htmlspecialchars($j["location"] ?? ""); ?>
</td>

<td>
<?php echo htmlspecialchars($j["job_type"] ?? ""); ?>
</td>

<td>
<?php echo htmlspecialchars(substr($j["deadline"] ?? "", 0, 10)); ?>
</td>

<td>

<button type="button"
id="save-job-<?php echo (int)$j["id"]; ?>"
onclick="seekerSaveJob(<?php echo (int)$j["id"]; ?>)">
<?php echo isSaved((int)$_SESSION["user_id"], (int)$j["id"]) ? "Saved" : "Save job"; ?>
</button>

<form
method="POST"
action="../../controller/seeker/SeekerApplicationController.php"
enctype="multipart/form-data">

<input type="hidden"
name="job_id"
value="<?php echo (int)$j["id"]; ?>">

<input type="hidden"
name="old_resume"
value="<?php echo htmlspecialchars($profile["resume_path"] ?? ""); ?>">

<textarea
name="cover_letter"
rows="2"
placeholder="Cover letter"></textarea>

<input type="file"
name="resume">

<input type="submit"
value="Apply">

</form>

</td>

</tr>

<?php

}

?>

</table>

</div>

</body>
</html>
