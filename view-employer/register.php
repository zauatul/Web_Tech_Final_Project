<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
<title>
Employer register
</title>

<link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body>

<div class="container employer-auth">

<h2>
Register company
</h2>

<p class="hint">
After you submit, an admin must approve your account before you can log in.
</p>

<?php

if(!empty($_GET["ok"]))
{
    echo "<p class=\"msg ok\">Registration received. Wait for admin approval.</p>";
}

if(!empty($_GET["err"]))
{

    $e = $_GET["err"];

    if($e === "missing")
    {
        echo "<p class=\"msg err\">Please fill required fields.</p>";
    }
    elseif($e === "email")
    {
        echo "<p class=\"msg err\">That email is already registered.</p>";
    }
    elseif($e === "db")
    {
        echo "<p class=\"msg err\">Could not save. Check database tables.</p>";
    }

}

?>

<form method="post" action="../../controller/employee/EmployerRegisterController.php">

<h3>
Your account
</h3>

<label>
Full name
</label>
<input type="text" name="name" required>

<label>
Email
</label>
<input type="email" name="email" required>

<label>
Password
</label>
<input type="password" name="password" required>

<label>
Phone
</label>
<input type="text" name="phone">

<h3>
Company details
</h3>

<label>
Company name
</label>
<input type="text" name="company_name" required>

<label>
Industry
</label>
<input type="text" name="industry">

<label>
Company size
</label>
<input type="text" name="company_size" placeholder="e.g. 11-50">

<label>
Description
</label>
<textarea name="description" rows="4"></textarea>

<label>
Website
</label>
<input type="url" name="website" placeholder="https://">

<label>
Address
</label>
<textarea name="address" rows="2"></textarea>

<input type="submit" value="Submit for verification">

</form>

<p class="hint">
<a href="login.php">Already registered? Log in</a>
</p>

</div>

</body>
</html>
