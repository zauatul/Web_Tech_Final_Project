<?php

session_start();

include_once __DIR__ . "/../../model/RecruiterModel.php";

$recruiterId = $_SESSION["user_id"];

$employerId = "";
$categoryId = "";
$title = "";
$description = "";
$requirements = "";
$benefits = "";
$salaryMin = "";
$salaryMax = "";
$location = "";
$jobType = "full-time";
$experienceLevel = "entry";
$deadline = "";

$employerErr = "";
$categoryErr = "";
$titleErr = "";
$deadlineErr = "";

$jobErr = "";
$success = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(empty($_POST["employer_id"]))
    {
        $employerErr = "Select employer";
    }
    else
    {
        $employerId = $_POST["employer_id"];
    }

    if(empty($_POST["category_id"]))
    {
        $categoryErr = "Select category";
    }
    else
    {
        $categoryId = $_POST["category_id"];
    }

    if(empty($_POST["title"]))
    {
        $titleErr = "Title required";
    }
    else
    {
        $title = trim($_POST["title"]);
    }

    if(empty($_POST["deadline"]))
    {
        $deadlineErr = "Deadline required";
    }
    else
    {
        $deadline = $_POST["deadline"];
    }

    if(isset($_POST["description"]))
    {
        $description = trim($_POST["description"]);
    }

    if(isset($_POST["requirements"]))
    {
        $requirements = trim($_POST["requirements"]);
    }

    if(isset($_POST["benefits"]))
    {
        $benefits = trim($_POST["benefits"]);
    }

    if(isset($_POST["salary_min"]))
    {
        $salaryMin = $_POST["salary_min"];
    }

    if(isset($_POST["salary_max"]))
    {
        $salaryMax = $_POST["salary_max"];
    }

    if(isset($_POST["location"]))
    {
        $location = trim($_POST["location"]);
    }

    if(isset($_POST["job_type"]))
    {
        $jobType = $_POST["job_type"];
    }

    if(isset($_POST["experience_level"]))
    {
        $experienceLevel = $_POST["experience_level"];
    }

    if(
        $employerErr == "" &&
        $categoryErr == "" &&
        $titleErr == "" &&
        $deadlineErr == ""
    )
    {
        $ok = createJobForClient(
            $recruiterId,
            $employerId,
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
            "active"
        );

        if($ok)
        {
            $success = "Job posted successfully";
        }
        else
        {
            $jobErr = "Database error";
        }
    }
}

?>