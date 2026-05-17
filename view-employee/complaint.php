<?php

require_once __DIR__ . "/../../config/EmployerAuth.php";

requireEmployer();

?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
<title>
Submit complaint
</title>

<link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body class="employer-body">

<div class="employer-shell">

<?php include __DIR__ . "/employer_nav.php"; ?>

<div class="employer-main wide">

<h1>
Complaint to admin
</h1>

<p class="hint">
Enter the user ID of the recruiter or seeker you are reporting (your admin can match IDs in the users table).
</p>

<?php

if(!empty($_GET["sent"]))
{
    echo "<p class=\"msg ok\">Complaint submitted.</p>";
}

if(!empty($_GET["err"]))
{
    echo "<p class=\"msg err\">Subject user ID and description are required.</p>";
}

?>

<form method="post" action="../../controller/employee/EmployerComplaintController.php">

<label>
Subject user ID
</label>
<input type="number" name="subject_id" min="1" required>

<label>
Description
</label>
<textarea name="description" rows="6" required></textarea>

<input type="submit" value="Submit complaint">

</form>

</div>

</div>

</body>
</html>
