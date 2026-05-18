<?php

session_start();

include_once __DIR__ . "/../../config/EmployerAuth.php";
include_once __DIR__ . "/../../model/EmployerModel.php";

requireEmployer("../../view/employee/login.php");

if($_SERVER["REQUEST_METHOD"] !== "POST")
{
    header("location:../../view/employee/dashboard.php");
    exit();
}

$userId = (int)$_SESSION["user_id"];
$m = new EmployerModel();

$action = $_POST["action"] ?? "";

if($action === "delete")
{

    $jobId = (int)($_POST["job_id"] ?? 0);
    $m->deleteJob($jobId, $userId);
    header("location:../../view/employee/dashboard.php");
    exit();

}

if($action === "repost" || $action === "close")
{

    $jobId = (int)($_POST["job_id"] ?? 0);
    $status = $action === "repost" ? "active" : "closed";
    $m->setJobStatus($jobId, $userId, $status);
    header("location:../../view/employee/dashboard.php");
    exit();

}

$jobId = (int)($_POST["job_id"] ?? 0);
$categoryId = (int)($_POST["category_id"] ?? 0);
$title = trim($_POST["title"] ?? "");
$description = trim($_POST["description"] ?? "");
$requirements = trim($_POST["requirements"] ?? "");
$benefits = trim($_POST["benefits"] ?? "");
$salaryMin = (int)($_POST["salary_min"] ?? 0);
$salaryMax = (int)($_POST["salary_max"] ?? 0);
$location = trim($_POST["location"] ?? "");
$jobType = trim($_POST["job_type"] ?? "full-time");
$experienceLevel = trim($_POST["experience_level"] ?? "entry");
$deadline = trim($_POST["deadline"] ?? "");
$publish = isset($_POST["publish"]);
$draft = isset($_POST["draft"]);

if(
    $title === ""
    || $categoryId <= 0
    || $deadline === ""
)
{

    if($jobId > 0)
    {
        header("location:../../view/employee/job_form.php?id=" . $jobId . "&err=missing");
    }
    else
    {
        header("location:../../view/employee/job_form.php?err=missing");
    }

    exit();

}

$status = "draft";
if($publish)
{
    $status = "active";
}
elseif($draft)
{
    $status = "draft";
}

if($jobId > 0)
{

    $m->updateJob(
        $jobId,
        $userId,
        $categoryId,
        $title,
        $description,
        $requirements,
        $benefits,
        $salaryMin,
        $salaryMax,
        $location,
        $jobType,
        $experienceLevel,
        $deadline,
        $status
    );
    header("location:../../view/employee/dashboard.php?updated=1");
    exit();

}

$newId = $m->createJob(
    $userId,
    $categoryId,
    $title,
    $description,
    $requirements,
    $benefits,
    $salaryMin,
    $salaryMax,
    $location,
    $jobType,
    $experienceLevel,
    $deadline,
    $status
);

if($newId > 0)
{
    header("location:../../view/employee/dashboard.php?created=1");
}
else
{
    header("location:../../view/employee/job_form.php?err=db");
}

exit();
