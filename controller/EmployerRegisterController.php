<?php

session_start();

include_once __DIR__ . "/../../model/EmployerModel.php";

if($_SERVER["REQUEST_METHOD"] !== "POST")
{
    header("location:../../view/employer/register.php");
    exit();
}

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = trim($_POST["password"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$companyName = trim($_POST["company_name"] ?? "");
$industry = trim($_POST["industry"] ?? "");
$companySize = trim($_POST["company_size"] ?? "");
$description = trim($_POST["description"] ?? "");
$website = trim($_POST["website"] ?? "");
$address = trim($_POST["address"] ?? "");

if(
    $name === ""
    || $email === ""
    || $password === ""
    || $companyName === ""
)
{
    header("location:../../view/employer/register.php?err=missing");
    exit();
}

$m = new EmployerModel();

if($m->emailExists($email))
{
    header("location:../../view/employer/register.php?err=email");
    exit();
}

$uid = $m->registerEmployer(
    $name,
    $email,
    $password,
    $phone,
    $companyName,
    $industry,
    $companySize,
    $description,
    $website,
    $address
);

if($uid === false)
{
    header("location:../../view/employee/register.php?err=db");
    exit();
}

header("location:../../view/employee/register.php?ok=1");
exit();
