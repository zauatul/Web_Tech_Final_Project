<?php

include_once __DIR__ .
"/../../config/SeekerAuth.php";

include_once __DIR__ .
"/../../model/SeekerModel.php";

requireSeekerJson();

header(
"Content-Type: application/json; charset=utf-8"
);

if($_SERVER['REQUEST_METHOD'] !== 'POST')
{
    echo json_encode(
    array(
    "ok" => false,
    "error" => "Method"
    )
    );
    exit();
}

$action =
$_POST['action'] ?? "";

$userId =
(int)$_SESSION['user_id'];

if($action === "save_job")
{

    $jobId =
    (int)($_POST['job_id'] ?? 0);

    if($jobId <= 0)
    {
        echo json_encode(
        array(
        "ok" => false,
        "error" => "Invalid job"
        )
        );
        exit();
    }

    list($ok, $saved) =
    toggleSavedJob(
    $userId,
    $jobId
    );

    echo json_encode(
    array(
    "ok" => $ok,
    "saved" => $saved
    )
    );
    exit();

}

echo json_encode(
array(
"ok" => false,
"error" => "Unknown action"
)
);
exit();

?>
