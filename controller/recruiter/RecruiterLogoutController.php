<?php

session_start();
session_destroy();

header("location:../../view/recruiter/login.php");
exit();

?>
