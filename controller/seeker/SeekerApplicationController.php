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
    "location:../../view/seeker/jobs.php"
    );
    exit();
}

$userId =
(int)$_SESSION['user_id'];

$jobId =
(int)($_POST['job_id'] ?? 0);

$coverLetter =
trim($_POST['cover_letter'] ?? "");

$resumePath =
trim($_POST['old_resume'] ?? "");

if($jobId <= 0)
{
    header(
    "location:../../view/seeker/jobs.php?err=job"
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
applyJob(
$userId,
$jobId,
$coverLetter,
$resumePath
);

if($ok)
{
    header(
    "location:../../view/seeker/applications.php?ok=1"
    );
}
else
{
    header(
    "location:../../view/seeker/jobs.php?err=applied"
    );
}

exit();

?>
