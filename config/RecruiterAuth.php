<?php

function requireRecruiter($loginPath = "login.php")
{

    if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }

    if(
        empty($_SESSION["user_id"])
        || ($_SESSION["role"] ?? "") !== "recruiter"
    )
    {
        header("location:" . $loginPath);
        exit();
    }

}

function requireRecruiterJson()
{

    if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }

    if(
        empty($_SESSION["user_id"])
        || ($_SESSION["role"] ?? "") !== "recruiter"
    )
    {
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode(["ok" => false, "error" => "Unauthorized"]);
        exit();
    }

}

?>
