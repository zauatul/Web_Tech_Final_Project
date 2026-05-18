<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
<title>
Employer login
</title>

<link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body>

<div class="container employer-auth">

<h2>
Employer login
</h2>

<?php

if(!empty($_GET["err"]))
{

    $e = $_GET["err"];

    if($e === "missing")
    {
        echo "<p class=\"msg err\">Email and password required.</p>";
    }
    elseif($e === "credentials")
    {
        echo "<p class=\"msg err\">Invalid email or password.</p>";
    }
    elseif($e === "pending")
    {
        echo "<p class=\"msg err\">Account not approved yet, or it has been disabled by admin.</p>";
    }
    elseif($e === "disabled")
    {
        echo "<p class=\"msg err\">This account is disabled.</p>";
    }

}

?>

<form method="post" action="../../controller/employee/EmployerLoginController.php">

<label>
Email
</label>
<input type="email" name="email" required>

<label>
Password
</label>
<input type="password" name="password" required>

<input type="submit" value="Log in">

</form>

<p class="hint">
<a href="register.php">Create company account</a>
</p>

<p class="hint">
<a href="../../index.php">Portal home</a>
</p>

</div>

</body>
</html>
