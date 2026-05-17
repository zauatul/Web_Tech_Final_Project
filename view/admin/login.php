<!DOCTYPE html>
<html>
<head>

<title>
Admin Login
</title>

<link rel="stylesheet"
href="../../assets/css/style.css">

<script>

function validateForm()
{

var email =
document.getElementById("email").value;

var password =
document.getElementById("password").value;

if(email == "6")
{
   alert("Email Required");
   return false;
}

if(password == "")
{
   alert("Password Required");
   return false;
}

return true;

}

</script>

</head>

<body>

<div class="container">

<h2>
Admin Login
</h2>

<form
action="../../controller/admin/AdminLoginController.php"
method="POST"
onsubmit="return validateForm()"
>

<input type="text"
name="email"
id="email"
placeholder="Enter Email">

<input type="password"
name="password"
id="password"
placeholder="Enter Password">

<input
type="submit"
name="login"
value="Login">

</form>

<p class="hint">
<a href="../../index.php">Portal home</a>
</p>

</div>

</body>
</html>
