<?php

session_start();

include_once __DIR__ . "/../../model/RecruiterModel.php";


$name = "";
$email = "";
$password = "";
$phone = "";
$agencyName = "";

$nameErr = "";
$emailErr = "";
$passwordErr = "";
$agencyErr = "";
$phoneErr = "";

$success = "";


if($_SERVER["REQUEST_METHOD"] == "POST")
{

    // NAME
    if(empty($_POST["name"]))
    {
        $nameErr = "Name is required";
    }
    else
    {
        $name = trim($_POST["name"]);

        if(!preg_match("/^[a-zA-Z ]*$/", $name))
        {
            $nameErr = "Only letters allowed";
        }
    }


    // EMAIL
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
        else if(emailExists($email))
        {
            $emailErr = "Email already exists";
        }
    }


    // PASSWORD
    if(empty($_POST["password"]))
    {
        $passwordErr = "Password is required";
    }
    else
    {
        $password = trim($_POST["password"]);

        if(strlen($password) < 6)
        {
            $passwordErr =
            "Minimum 6 characters required";
        }
    }


    // PHONE
    if(!empty($_POST["phone"]))
    {
        $phone = trim($_POST["phone"]);

        if(!preg_match("/^[0-9]{11}$/", $phone))
        {
            $phoneErr =
            "Phone must be 11 digits";
        }
    }


    // AGENCY
    if(empty($_POST["agency_name"]))
    {
        $agencyErr =
        "Agency name is required";
    }
    else
    {
        $agencyName =
        trim($_POST["agency_name"]);
    }



    // INSERT
    if(
        $nameErr == "" &&
        $emailErr == "" &&
        $passwordErr == "" &&
        $phoneErr == "" &&
        $agencyErr == ""
    )
    {

        $id = registerRecruiter(
            $name,
            $email,
            $password,
            $phone,
            $agencyName
        );

        if($id)
        {
            $success =
            "Registration successful";
        }
        else
        {
            $emailErr =
            "Database error";
        }
    }
}

?>