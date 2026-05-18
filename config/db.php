<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "job_portal";

$conn = new mysqli(
$host,
$user,
$password,
$database
);

if($conn->connect_error)
{
    die("Connection Failed");
}

?>
