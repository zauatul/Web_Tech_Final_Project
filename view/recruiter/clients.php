<?php

session_start();

include_once "../../controller/recruiter/RecruiterClientController.php";

$recruiterId = $_SESSION["user_id"];

$clients = listClients($recruiterId);
$employers = listAvailableEmployers($recruiterId);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">

<title>Recruiter Clients</title>

<link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body class="employer-body">

<div class="employer-shell">

<?php include "recruiter_nav.php"; ?>

<div class="employer-main wide">

<h1>Recruiter Clients</h1>

<h2>Add Client</h2>

<?php

if(mysqli_num_rows($employers) == 0)
{
    echo "<p class='hint'>No employer available to add.</p>";
}
else
{

?>

<form method="post">

<label>Employer</label>

<select name="employer_id">

<option value="">Select Employer</option>

<?php

while($e = mysqli_fetch_assoc($employers))
{
    $name = $e["company_name"];

    echo "<option value='" . $e["id"] . "'>";

    echo $name . " - " . $e["email"];

    echo "</option>";
}

?>

</select>

<span class="msg err"><?php echo $employerErr; ?></span>

<label>Company Name Override</label>

<input type="text" name="company_name_override" value="<?php echo $companyNameOverride; ?>">

<input type="submit" value="Add Client">

</form>

<?php

}

?>

<?php

if($success != "")
{
    echo "<p class='msg ok'>$success</p>";
}

?>

<h2>My Clients</h2>

<table class="employer-table">

<tr>
<th>Company</th>
<th>Contact</th>
<th>Email</th>
<th>Override Name</th>
<th>Added</th>
</tr>

<?php

while($c = mysqli_fetch_assoc($clients))
{

?>

<tr>
<td><?php echo $c["company_name"]; ?></td>
<td><?php echo $c["employer_name"]; ?></td>
<td><?php echo $c["employer_email"]; ?></td>
<td><?php echo $c["company_name_override"]; ?></td>
<td><?php echo $c["added_at"]; ?></td>
</tr>

<?php

}

?>

</table>

</div>

</div>

</body>
</html>