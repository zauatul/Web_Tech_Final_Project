<?php

session_start();

include_once __DIR__ . "/../../config/EmployerAuth.php";
include_once __DIR__ . "/../../model/EmployerModel.php";

requireEmployer("../../view/employee/login.php");

if($_SERVER["REQUEST_METHOD"] !== "POST")
{
    header("location:../../view/employee/profile.php");
    exit();
}

$userId = (int)$_SESSION["user_id"];

$companyName = trim($_POST["company_name"] ?? "");
$industry = trim($_POST["industry"] ?? "");
$companySize = trim($_POST["company_size"] ?? "");
$description = trim($_POST["description"] ?? "");
$website = trim($_POST["website"] ?? "");
$address = trim($_POST["address"] ?? "");

if($companyName === "")
{
    header("location:../../view/employee/profile.php?err=missing");
    exit();
}

$logoPath = null;

if(
    !empty($_FILES["logo"]["name"])
    && is_uploaded_file($_FILES["logo"]["tmp_name"])
)
{

    $ext = strtolower(pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION));
    $allowed = ["jpg", "jpeg", "png", "gif", "webp"];

    if(in_array($ext, $allowed, true))
    {

        $dir = __DIR__ . "/../../uploads/employer_logos";

        if(!is_dir($dir))
        {
            mkdir($dir, 0755, true);
        }

        $fname = "logo_" . $userId . "_" . time() . "." . $ext;
        $dest = $dir . "/" . $fname;

        if(move_uploaded_file($_FILES["logo"]["tmp_name"], $dest))
        {
            $logoPath = "uploads/employer_logos/" . $fname;
        }

    }

}

$m = new EmployerModel();

if($logoPath !== null)
{
    $m->updateEmployerProfile(
        $userId,
        $companyName,
        $industry,
        $companySize,
        $description,
        $website,
        $address,
        $logoPath
    );
}
else
{
    $m->updateEmployerProfile(
        $userId,
        $companyName,
        $industry,
        $companySize,
        $description,
        $website,
        $address,
        null
    );
}

header("location:../../view/employee/profile.php?saved=1");
exit();
