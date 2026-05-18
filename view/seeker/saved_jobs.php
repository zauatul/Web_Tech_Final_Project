<?php

include_once __DIR__ .
"/../../config/SeekerAuth.php";

include_once __DIR__ .
"/../../model/SeekerModel.php";

requireSeeker();

$list =
listSavedJobs((int)$_SESSION["user_id"]);

?>

<!DOCTYPE html>
<html>
<head>

<title>
Saved Jobs
</title>

<link rel="stylesheet"
href="../../assets/css/style.css">

<script src="../../assets/js/seeker.js">
</script>

</head>

<body>

<div class="table-container">

<h1>
Saved Jobs
</h1>

<?php include __DIR__ . "/seeker_nav.php"; ?>

<table>

<tr>
<th>Job</th>
<th>Company</th>
<th>Location</th>
<th>Status</th>
<th></th>
</tr>

<?php

while($s =
$list->fetch_assoc())
{

?>

<tr>
<td>
<?php echo htmlspecialchars($s["title"]); ?>
</td>

<td>
<?php echo htmlspecialchars($s["employer_name"]); ?>
</td>

<td>
<?php echo htmlspecialchars($s["location"] ?? ""); ?>
</td>

<td>
<?php echo htmlspecialchars($s["status"]); ?>
</td>

<td>

<button type="button"
id="save-job-<?php echo (int)$s["job_id"]; ?>"
onclick="seekerSaveJob(<?php echo (int)$s["job_id"]; ?>)">
Saved
</button>

</td>
</tr>

<?php

}

?>

</table>

</div>

</body>
</html>
