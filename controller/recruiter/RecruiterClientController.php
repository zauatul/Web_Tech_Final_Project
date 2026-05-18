<?php

require_once "../../model/RecruiterModel.php";

$companyNameOverride = "";

$employerErr = "";
$success = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $recruiterId = $_SESSION["user_id"];

    if(empty($_POST["employer_id"]))
    {
        $employerErr = "Employer is required";
    }
    else
    {
        $employerId = $_POST["employer_id"];
    }

    if(isset($_POST["company_name_override"]))
    {
        $companyNameOverride = trim($_POST["company_name_override"]);
    }

    if($employerErr == "")
    {
        $ok = addClient( $recruiterId, $employerId, $companyNameOverride );

        if($ok)
        {
            $success = "Client added successfully";
        }
        else
        {
            $employerErr = "Could not add client";
        }
    }
}

?>