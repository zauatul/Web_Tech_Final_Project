<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "job_portal";

$conn = mysqli_connect($host,$user,$password,$database);

if(!$conn)
{
    die("Connection Failed");
}

?>
