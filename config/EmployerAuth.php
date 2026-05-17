<?php

function requireEmployer($loginPath = "login.php")
{

    if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }

    if(
        empty($_SESSION["user_id"])
        || ($_SESSION["role"] ?? "") !== "employer"
    )
    {
        header("location:" . $loginPath);
        exit();
    }

}

function requireEmployerJson()
{

    if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }

    if(
        empty($_SESSION["user_id"])
        || ($_SESSION["role"] ?? "") !== "employer"
    )
    {
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode(["ok" => false, "error" => "Unauthorized"]);
        exit();
    }

}

?>
