<?php

include_once "../../controller/recruiter/RecruiterJobController.php";

$clients = listClients($_SESSION["user_id"]);
$cats = listCategories();

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">

<title>Post Job</title>

<link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body class="employer-body">

<div class="employer-shell">

<?php include "recruiter_nav.php"; ?>

<div class="employer-main wide">

<h1>Post Job For Client</h1>

<?php

if($jobErr != "")
{
    echo "<p class='msg err'>$jobErr</p>";
}

?>

<form method="post">

<label>Client</label>

<select name="employer_id">

<option value="">Select client</option>

<?php

while($c = mysqli_fetch_assoc($clients))
{
    $name = $c["company_name"];

    if($name == "")
    {
        $name = $c["employer_name"];
    }

    echo "<option value='" . $c["employer_id"] . "'>$name</option>";
}

?>

</select>

<span class="msg err"><?php echo $employerErr; ?></span>

<label>Category</label>

<select name="category_id">

<option value="">Select category</option>

<?php

while($cat = mysqli_fetch_assoc($cats))
{
    echo "<option value='" . $cat["id"] . "'>" . $cat["name"] . "</option>";
}

?>

</select>

<span class="msg err"><?php echo $categoryErr; ?></span>

<label>Title</label>

<input type="text" name="title" value="<?php echo $title; ?>">

<span class="msg err"><?php echo $titleErr; ?></span>

<label>Description</label>

<textarea name="description" rows="6"><?php echo $description; ?></textarea>

<label>Requirements</label>

<textarea name="requirements" rows="4"><?php echo $requirements; ?></textarea>

<label>Benefits</label>

<textarea name="benefits" rows="3"><?php echo $benefits; ?></textarea>

<label>Salary Min</label>

<input type="number" name="salary_min" value="<?php echo $salaryMin; ?>">

<label>Salary Max</label>

<input type="number" name="salary_max" value="<?php echo $salaryMax; ?>">

<label>Location</label>

<input type="text" name="location" value="<?php echo $location; ?>">

<label>Job Type</label>

<select name="job_type">

<option value="full-time">full-time</option>

<option value="part-time">part-time</option>

<option value="remote">remote</option>

<option value="contract">contract</option>

</select>

<label>Experience Level</label>

<select name="experience_level">

<option value="entry">entry</option>

<option value="mid">mid</option>

<option value="senior">senior</option>

</select>

<label>Deadline</label>

<input type="date" name="deadline" value="<?php echo $deadline; ?>">

<span class="msg err"><?php echo $deadlineErr; ?></span>

<input type="submit" value="Publish">

<?php
if($success != "")
{
    echo "<p class='msg ok'>$success</p>";
}
?>
</form>

</div>




</div>

</body>
</html>