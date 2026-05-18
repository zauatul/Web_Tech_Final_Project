<?php

include_once __DIR__ .
"/../../config/SeekerAuth.php";

include_once __DIR__ .
"/../../model/SeekerModel.php";

requireSeeker();

$list =
listAppliedJobs((int)$_SESSION["user_id"]);

?>

<!DOCTYPE html>
<html>
<head>

<title>
Applied Jobs
</title>

<link rel="stylesheet"
href="../../assets/css/style.css">

</head>

<body>

<div class="table-container">

<h1>
Applied Jobs
</h1>

<?php include __DIR__ . "/seeker_nav.php"; ?>

<?php

if(!empty($_GET["ok"]))
{
    echo "<p class=\"msg ok\">Application submitted.</p>";
}

?>

<table>

<tr>
<th>Job</th>
<th>Company</th>
<th>Location</th>
<th>Applied</th>
<th>Status</th>
</tr>

<?php

while($a =
$list->fetch_assoc())
{

?>

<tr>
<td>
<?php echo htmlspecialchars($a["title"]); ?>
</td>

<td>
<?php echo htmlspecialchars($a["employer_name"]); ?>
</td>

<td>
<?php echo htmlspecialchars($a["location"] ?? ""); ?>
</td>

<td>
<?php echo htmlspecialchars($a["applied_at"] ?? ""); ?>
</td>

<td>
<?php echo htmlspecialchars($a["status"]); ?>
</td>
</tr>

<?php

}

?>

</table>

</div>

</body>
</html>
