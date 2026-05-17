<?php

session_start();

include_once __DIR__ .
"/../../model/AdminModel.php";

if(isset($_POST['login']))
{

    $email =
    trim($_POST['email']);

    $password =
    trim($_POST['password']);

    //$obj = new AdminModel();

    $result =adminLogin(
    $email,
    $password
    );

    if($result->num_rows > 0)
    {

        $row =
        $result->fetch_assoc();

        $_SESSION['admin_id'] =
        $row['id'];

        $_SESSION['admin_name'] =
        $row['name'];

        header(
        "location:../../view/admin/dashboard.php"
        );

        exit();

    }
    else
    {

        echo "Invalid Login";

    }

}
else
{

    echo "Unauthorized Access";

}

?>
