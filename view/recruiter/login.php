<?php

include_once "../../controller/recruiter/RecruiterLoginController.php";

if(isset($_SESSION["role"])){
    if($_SESSION["role"] == "recruiter"){
        header("location: dashboard.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">

<title>Recruiter Login</title>

<link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body>

<div class="container employer-auth">

<h2>Recruiter Login</h2>

<form method="post">

<label>Email</label>

<input type="email" name="email" value="<?php echo $email; ?>">

<span class="msg err"><?php echo $emailErr; ?></span>

<label>Password</label>

<input type="password" name="password">

<span class="msg err"><?php echo $passwordErr; ?></span>

<input type="submit" value="Log In">

</form>

<p class="hint">
<a href="register.php">Create recruiter account</a>
</p>

<p class="hint">
<a href="../../index.php">Portal home</a>
</p>

<?php

if($loginErr != "")
{
    echo "<p class='msg err'>$loginErr</p>";
}

?>

</div>

</body>
</html>