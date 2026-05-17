<?php

session_start();
session_destroy();
header("location:../../view/employer/login.php");
exit();