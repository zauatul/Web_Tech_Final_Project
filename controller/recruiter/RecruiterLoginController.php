<?php

session_start();

include_once __DIR__ . "/../../model/RecruiterModel.php";

$email = "";
$password = "";

$emailErr = "";
$passwordErr = "";
$loginErr = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(empty($_POST["email"]))
    {
        $emailErr = "Email is required";
    }
    else
    {
        $email = trim($_POST["email"]);

        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $emailErr = "Invalid email";
        }
    }

    if(empty($_POST["password"]))
    {
        $passwordErr = "Password is required";
    }
    else
    {
        $password = trim($_POST["password"]);
    }

    if($emailErr == "" && $passwordErr == "")
    {
        $row = loginRecruiter($email, $password);

        if(!$row)
        {
            $loginErr = "Invalid email or password";
        }
        else if($row["is_active"] != 1)
        {
            $loginErr = "This account is disabled";
        }
        else
        {
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["role"] = "recruiter";
            $_SESSION["user_name"] = $row["name"];

            header("location:../../view/recruiter/dashboard.php");

            exit();
        }
    }
}

?>