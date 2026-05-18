<!DOCTYPE html>
<html>
<head>

<title>
Seeker Login
</title>

<link rel="stylesheet"
href="../../assets/css/style.css">

</head>

<body>

<div class="container">

<h2>
Job Seeker Login
</h2>

<?php

if(!empty($_GET["ok"]))
{
    echo "<p class=\"msg ok\">Registration complete. Please log in.</p>";
}

if(!empty($_GET["err"]))
{
    if($_GET["err"] === "missing")
    {
        echo "<p class=\"msg err\">Email and password required.</p>";
    }
    elseif($_GET["err"] === "credentials")
    {
        echo "<p class=\"msg err\">Invalid email or password.</p>";
    }
    elseif($_GET["err"] === "disabled")
    {
        echo "<p class=\"msg err\">This account is disabled.</p>";
    }
}

?>

<form
method="POST"
action="../../controller/seeker/SeekerLoginController.php">

<label>
Email
</label>
<input type="email"
name="email"
required>

<label>
Password
</label>
<input type="password"
name="password"
required>

<input type="submit"
value="Log in">

</form>

<p class="hint">
<a href="register.php">Create seeker account</a>
</p>

<p class="hint">
<a href="../../index.php">Portal home</a>
</p>

</div>

</body>
</html>
