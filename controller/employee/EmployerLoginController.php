<?php

session_start();

include_once __DIR__ . "/../../model/EmployerModel.php";

if($_SERVER["REQUEST_METHOD"] !== "POST")
{
    header("location:../../view/employee/login.php");
    exit();
}

$email = trim($_POST["email"] ?? "");
$password = trim($_POST["password"] ?? "");

if($email === "" || $password === "")
{
    header("location:../../view/employee/login.php?err=missing");
    exit();
}

$m = new EmployerModel();
$row = $m->loginEmployer($email, $password);

if($row === null)
{
    header("location:../../view/employee/login.php?err=credentials");
    exit();
}

if((int)$row["is_active"] !== 1)
{
    header("location:../../view/employee/login.php?err=pending");
    exit();
}

$_SESSION["user_id"] = (int)$row["id"];
$_SESSION["role"] = "employer";
$_SESSION["user_name"] = $row["name"];

header("location:../../view/employee/dashboard.php");
exit();
