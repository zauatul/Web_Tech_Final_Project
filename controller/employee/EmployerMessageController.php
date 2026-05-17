<?php

session_start();

include_once __DIR__ . "/../../config/EmployerAuth.php";
include_once __DIR__ . "/../../model/EmployerModel.php";

requireEmployer("../../view/employer/login.php");

if($_SERVER["REQUEST_METHOD"] !== "POST")
{
    header("location:../../view/employer/dashboard.php");
    exit();
}

$userId = (int)$_SESSION["user_id"];
$applicationId = (int)($_POST["application_id"] ?? 0);
$body = trim($_POST["body"] ?? "");

if($applicationId <= 0 || $body === "")
{
    header("location:../../view/employer/messages.php?application_id=" . $applicationId . "&err=missing");
    exit();
}

$m = new EmployerModel();

$recipientId = $m->getSeekerIdForApplication($applicationId, $userId);

if($recipientId === null)
{
    header("location:../../view/employer/dashboard.php");
    exit();
}
$m->insertMessage($userId, $recipientId, $applicationId, $body);

header("location:../../view/employer/messages.php?application_id=" . $applicationId . "&sent=1");
exit();
