<?php

include_once __DIR__ .
"/../../model/AdminModel.php";

//$obj = new AdminModel();

if(isset($_POST['addCategory']))
{

    $name =
    trim($_POST['name']);

    $description =
    trim($_POST['description']);

    addCategory(
    $name,
    $description
    );

    header(
    "location:../../view/admin/categories.php"
    );
    exit();

}

if(isset($_GET['deleteCategory']))
{

    $id =
    $_GET['deleteCategory'];

    deleteCategory($id);

    header(
    "location:../../view/admin/categories.php"
    );
    exit();

}

if(isset($_GET['resolveComplaint']))
{

    $id =
    $_GET['resolveComplaint'];

    resolveComplaint($id);

    header(
    "location:../../view/admin/complaints.php"
    );
    exit();

}

if(isset($_POST['ajax']))
{

    $id = $_POST['id'];
    $status = $_POST['status'];

    updateUserStatus(
    $id,
    $status
    );

    $response = array();

    $response['success'] = true;
    $response['status'] = $status;

    echo json_encode($response);

}

?>
