<?php

require_once __DIR__ . "/../../config/EmployerAuth.php";
require_once __DIR__ . "/../../model/EmployerModel.php";

requireEmployer();

$m = new EmployerModel();
$profile = $m->getProfileByUserId((int)$_SESSION["user_id"]);

if(!$profile)
{
    echo "Missing employer_profiles row for this user.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
<title>
Company profile
</title>

<link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body class="employer-body">

<div class="employer-shell">

<?php include __DIR__ . "/employer_nav.php"; ?>

<div class="employer-main wide">

<h1>
Company profile
</h1>

<?php

if(!empty($_GET["saved"]))
{
    echo "<p class=\"msg ok\">Profile saved.</p>";
}

if(!empty($_GET["err"]))
{
    echo "<p class=\"msg err\">Company name is required.</p>";
}

?>

<form method="post" action="../../controller/employee/EmployerProfileController.php" enctype="multipart/form-data">

<label>
Company name
</label>
<input type="text" name="company_name" required value="<?php echo htmlspecialchars($profile["company_name"] ?? ""); ?>">

<label>
Industry
</label>
<input type="text" name="industry" value="<?php echo htmlspecialchars($profile["industry"] ?? ""); ?>">

<label>
Company size
</label>
<input type="text" name="company_size" value="<?php echo htmlspecialchars($profile["company_size"] ?? ""); ?>">

<label>
Description
</label>
<textarea name="description" rows="5"><?php echo htmlspecialchars($profile["description"] ?? ""); ?></textarea>

<label>
Website
</label>
<input type="url" name="website" value="<?php echo htmlspecialchars($profile["website"] ?? ""); ?>">

<label>
Address
</label>
<textarea name="address" rows="2"><?php echo htmlspecialchars($profile["address"] ?? ""); ?></textarea>

<label>
Logo (JPG, PNG, GIF, WebP)
</label>
<input type="file" name="logo" accept="image/*">

<?php

if(!empty($profile["logo_path"]))
{

?>

<p class="hint">
Current logo:
<img src="../../<?php echo htmlspecialchars($profile["logo_path"]); ?>" alt="Logo" class="logo-preview">
</p>

<?php

}

?>

<input type="submit" value="Save profile">

</form>

</div>

</div>

</body>
</html>
