<?php

session_start();

include_once __DIR__ .
"/../../model/SeekerModel.php";

if($_SERVER['REQUEST_METHOD'] !== 'POST')
{
    header(
    "location:../../view/seeker/register.php"
    );
    exit();
}

$name =
trim($_POST['name'] ?? "");

$email =
trim($_POST['email'] ?? "");

$password =
trim($_POST['password'] ?? "");

$phone =
trim($_POST['phone'] ?? "");

$headline =
trim($_POST['headline'] ?? "");

if($name === ""
|| $email === ""
|| $password === "")
{
    header(
    "location:../../view/seeker/register.php?err=missing"
    );
    exit();
}

if(emailExists($email))
{
    header(
    "location:../../view/seeker/register.php?err=email"
    );
    exit();
}

$id =
registerSeeker(
$name,
$email,
$password,
$phone,
$headline
);

if($id === false)
{
    header(
    "location:../../view/seeker/register.php?err=db"
    );
    exit();
}

header(
"location:../../view/seeker/login.php?ok=1"
);
exit();

?>
