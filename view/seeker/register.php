<!DOCTYPE html>
<html>
<head>

<title>
Seeker Register
</title>

<link rel="stylesheet"
href="../../assets/css/style.css">

<script src="../../assets/js/seeker.js">
</script>

</head>

<body>

<div class="container">

<h2>
Job Seeker Registration
</h2>

<?php

if(!empty($_GET["err"]))
{
    if($_GET["err"] === "missing")
    {
        echo "<p class=\"msg err\">Please fill required fields.</p>";
    }
    elseif($_GET["err"] === "email")
    {
        echo "<p class=\"msg err\">That email is already registered.</p>";
    }
    elseif($_GET["err"] === "db")
    {
        echo "<p class=\"msg err\">Could not save information.</p>";
    }
}

?>

<form
method="POST"
action="../../controller/seeker/SeekerRegisterController.php"
onsubmit="return seekerRegisterValidate();">

<label>
Full name
</label>
<input type="text"
name="name"
id="name"
required>

<label>
Email
</label>
<input type="email"
name="email"
id="email"
required>

<label>
Password
</label>
<input type="password"
name="password"
id="password"
required>

<label>
Phone
</label>
<input type="text"
name="phone">

<label>
Headline
</label>
<input type="text"
name="headline"
placeholder="e.g. Junior PHP Developer">

<input type="submit"
value="Register">

</form>

<p class="hint">
<a href="login.php">Already registered? Log in</a>
</p>

</div>

</body>
</html>
