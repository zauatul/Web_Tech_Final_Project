<?php

include_once "../../controller/recruiter/RecruiterRegisterController.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">

<title>
Recruiter Register
</title>

<link rel="stylesheet"
href="../../assets/css/style.css">

</head>

<body>

<div class="container employer-auth">

<h2>
Recruiter Registration
</h2>





<form method="post">

<label>
Full Name
</label>

<input type="text"
name="name"
value="<?php echo $name; ?>">

<span class="msg err">
<?php echo $nameErr; ?>
</span>


<label>
Email
</label>

<input type="email"
name="email"
value="<?php echo $email; ?>">

<span class="msg err">
<?php echo $emailErr; ?>
</span>


<label>
Password
</label>

<input type="password"
name="password">

<span class="msg err">
<?php echo $passwordErr; ?>
</span>


<label>
Phone
</label>

<input type="text"
name="phone"
value="<?php echo $phone; ?>">

<span class="msg err">
<?php echo $phoneErr; ?>
</span>


<label>
Agency Name
</label>

<input type="text"
name="agency_name"
value="<?php echo $agencyName; ?>">

<span class="msg err">
<?php echo $agencyErr; ?>
</span>


<input type="submit"
value="Register">

</form>


<p class="hint">

<a href="login.php">
Already registered? Log in
</a>

</p>
<?php

if($success != "")
{
    echo "<p class='msg ok'>
    $success
    </p>";
}

?>
</div>

</body>
</html>