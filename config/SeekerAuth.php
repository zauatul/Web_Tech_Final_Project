<?php

function requireSeeker($loginPath = "login.php")
{

    if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }

    if(
        empty($_SESSION["user_id"])
        || ($_SESSION["role"] ?? "") !== "seeker"
    )
    {
        header("location:" . $loginPath);
        exit();
    }

}

function requireSeekerJson()
{

    if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }

    if(
        empty($_SESSION["user_id"])
        || ($_SESSION["role"] ?? "") !== "seeker"
    )
    {
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode(["ok" => false, "error" => "Unauthorized"]);
        exit();
    }

}

?>
