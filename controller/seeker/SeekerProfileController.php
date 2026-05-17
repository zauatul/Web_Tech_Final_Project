<?php

include_once __DIR__ .
"/../../config/SeekerAuth.php";

include_once __DIR__ .
"/../../model/SeekerModel.php";

requireSeeker(
"../../view/seeker/login.php"
);

if($_SERVER['REQUEST_METHOD'] !== 'POST')
{
    header(
    "location:../../view/seeker/profile.php"
    );
    exit();
}

$userId =
(int)$_SESSION['user_id'];

$name =
trim($_POST['name'] ?? "");

$phone =
trim($_POST['phone'] ?? "");

$headline =
trim($_POST['headline'] ?? "");

$summary =
trim($_POST['summary'] ?? "");

$skills =
trim($_POST['skills'] ?? "");

$yearsExperience =
(int)($_POST['years_experience'] ?? 0);

$educationLevel =
trim($_POST['education_level'] ?? "");

$currentSalary =
(float)($_POST['current_salary'] ?? 0);

$expectedSalary =
(float)($_POST['expected_salary'] ?? 0);

$preferredLocation =
trim($_POST['preferred_location'] ?? "");

$resumePath =
"";

if($name === "")
{
    header(
    "location:../../view/seeker/profile.php?err=missing"
    );
    exit();
}

if(!empty($_FILES['resume']['name']))
{

    $fileName =
    time() . "_" . basename($_FILES['resume']['name']);

    $target =
    __DIR__ . "/../../uploads/" . $fileName;

    if(move_uploaded_file(
    $_FILES['resume']['tmp_name'],
    $target
    ))
    {
        $resumePath =
        "uploads/" . $fileName;
    }

}

$ok =
updateProfile(
$userId,
$name,
$phone,
$headline,
$summary,
$skills,
$yearsExperience,
$educationLevel,
$currentSalary,
$expectedSalary,
$preferredLocation,
$resumePath
);

if($ok)
{
    $_SESSION['user_name'] =
    $name;

    header(
    "location:../../view/seeker/profile.php?ok=1"
    );
}
else
{
    header(
    "location:../../view/seeker/profile.php?err=db"
    );
}

exit();

?>
