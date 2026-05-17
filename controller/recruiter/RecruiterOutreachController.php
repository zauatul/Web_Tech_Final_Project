<?php

include_once __DIR__ . "/../../model/RecruiterModel.php";

$subject = "";
$message = "";

$subjectErr = "";
$messageErr = "";
$outreachErr = "";

$success = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $recruiterId = $_SESSION["user_id"];

    $seekerId = 0;

    if(isset($_POST["seeker_id"]))
    {
        $seekerId = (int)$_POST["seeker_id"];
    }

    if(empty($_POST["subject"]))
    {
        $subjectErr = "Subject is required";
    }
    else
    {
        $subject = trim($_POST["subject"]);
    }

    if(empty($_POST["message"]))
    {
        $messageErr = "Message is required";
    }
    else
    {
        $message = trim($_POST["message"]);
    }

    if($subjectErr == "" && $messageErr == "")
    {
        $ok = sendOutreach(
            $recruiterId,
            $seekerId,
            $subject,
            $message
        );

        if($ok)
        {
            $success = "Message sent successfully";
        }
        else
        {
            $outreachErr = "Failed to send message";
        }
    }
}

?>