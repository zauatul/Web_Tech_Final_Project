<?php

include_once __DIR__ .
"/../../config/SeekerAuth.php";

include_once __DIR__ .
"/../../model/SeekerModel.php";

requireSeeker();

$row =
getProfile((int)$_SESSION["user_id"]);

?>

<!DOCTYPE html>
<html>
<head>

<title>
Seeker Profile
</title>

<link rel="stylesheet"
href="../../assets/css/style.css">

</head>

<body>

<div class="table-container">

<h1>
Profile
</h1>

<?php include __DIR__ . "/seeker_nav.php"; ?>

<?php

if(!empty($_GET["ok"]))
{
    echo "<p class=\"msg ok\">Profile updated.</p>";
}

if(!empty($_GET["err"]))
{
    echo "<p class=\"msg err\">Could not update profile.</p>";
}

?>

<form
method="POST"
action="../../controller/seeker/SeekerProfileController.php"
enctype="multipart/form-data">

<label>
Full name
</label>

<input type="text"
name="name"
required
value="<?php echo htmlspecialchars($row["name"] ?? ""); ?>">

<label>
Phone
</label>

<input type="text"
name="phone"
value="<?php echo htmlspecialchars($row["phone"] ?? ""); ?>">

<label>
Headline
</label>

<input type="text"
name="headline"
value="<?php echo htmlspecialchars($row["headline"] ?? ""); ?>">

<label>
Summary
</label>

<textarea
name="summary"
rows="4"><?php echo htmlspecialchars($row["summary"] ?? ""); ?></textarea>

<label>
Skills
</label>

<textarea
name="skills"
rows="3"><?php echo htmlspecialchars($row["skills"] ?? ""); ?></textarea>

<label>
Years experience
</label>

<input type="number"
name="years_experience"
value="<?php echo (int)($row["years_experience"] ?? 0); ?>">

<label>
Education level
</label>

<input type="text"
name="education_level"
value="<?php echo htmlspecialchars($row["education_level"] ?? ""); ?>">

<label>
Current salary
</label>

<input type="number"
name="current_salary"
value="<?php echo (float)($row["current_salary"] ?? 0); ?>">

<label>
Expected salary
</label>

<input type="number"
name="expected_salary"
value="<?php echo (float)($row["expected_salary"] ?? 0); ?>">

<label>
Preferred location
</label>

<input type="text"
name="preferred_location"
value="<?php echo htmlspecialchars($row["preferred_location"] ?? ""); ?>">

<label>
Resume
</label>

<input type="file"
name="resume">

<?php

if(!empty($row["resume_path"]))
{
    echo "<p class=\"hint\">Current resume: " . htmlspecialchars($row["resume_path"]) . "</p>";
}

?>

<input type="submit"
value="Update profile">

</form>

</div>

</body>
</html>
