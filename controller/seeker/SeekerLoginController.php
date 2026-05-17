<?php

session_start();

include_once __DIR__ .
"/../../model/SeekerModel.php";

if($_SERVER['REQUEST_METHOD'] !== 'POST')
{
    header(
    "location:../../view/seeker/login.php"
    );
    exit();
}

$email =
trim($_POST['email'] ?? "");

$password =
trim($_POST['password'] ?? "");

if($email === ""
|| $password === "")
{
    header(
    "location:../../view/seeker/login.php?err=missing"
    );
    exit();
}

$row =
loginSeeker(
$email,
$password
);

if($row === null)
{
    header(
    "location:../../view/seeker/login.php?err=credentials"
    );
    exit();
}

if((int)$row['is_active'] !== 1)
{
    header(
    "location:../../view/seeker/login.php?err=disabled"
    );
    exit();
}

$_SESSION['user_id'] =
(int)$row['id'];

$_SESSION['role'] =
"seeker";

$_SESSION['user_name'] =
$row['name'];

header(
"location:../../view/seeker/dashboard.php"
);
exit();

?>
