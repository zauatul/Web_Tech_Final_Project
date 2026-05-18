<?php

session_start();

include_once __DIR__ . "/../../config/EmployerAuth.php";
include_once __DIR__ . "/../../model/EmployerModel.php";

requireEmployer("../../view/employee/login.php");

if($_SERVER["REQUEST_METHOD"] !== "POST")
{
    header("location:../../view/employee/complaint.php");
    exit();
}

$userId = (int)$_SESSION["user_id"];
$subjectId = (int)($_POST["subject_id"] ?? 0);
$description = trim($_POST["description"] ?? "");

if($subjectId <= 0 || $description === "")
{
    header("location:../../view/employee/complaint.php?err=missing");
    exit();
}

$m = new EmployerModel();

if($m->insertComplaint($userId, $subjectId, $description))
{
    header("location:../../view/employee/complaint.php?sent=1");
}
else
{
    header("location:../../view/employee/complaint.php?err=db");
}

exit();
