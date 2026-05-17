<?php

include_once __DIR__ . "/../../config/EmployerAuth.php";
include_once __DIR__ . "/../../model/EmployerModel.php";

requireEmployerJson();

header("Content-Type: application/json; charset=utf-8");

if($_SERVER["REQUEST_METHOD"] !== "POST")
{
    echo json_encode(["ok" => false, "error" => "Method"]);
    exit();
}

$action = $_POST["action"] ?? "";
$userId = (int)$_SESSION["user_id"];
$obj = new EmployerModel();

if($action === "toggle_job")
{

    $jobId = (int)($_POST["job_id"] ?? 0);

    if($jobId <= 0)
    {
        echo json_encode(["ok" => false, "error" => "Invalid job"]);
        exit();
    }

    list($ok, $status) = $obj->toggleActiveClosed($jobId, $userId);

    if(!$ok && $status === "draft")
    {
        echo json_encode(
            [
                "ok" => false,
                "error" => "Draft jobs: use edit to publish."
            ]
        );
        exit();
    }

    if(!$ok)
    {
        echo json_encode(["ok" => false, "error" => "Could not update job."]);
        exit();
    }

    echo json_encode(["ok" => true, "status" => $status]);
    exit();

}

if($action === "application_status")
{

    $applicationId = (int)($_POST["application_id"] ?? 0);
    $status = trim($_POST["status"] ?? "");

    if($applicationId <= 0 || $status === "")
    {
        echo json_encode(["ok" => false, "error" => "Invalid input"]);
        exit();
    }

    $ok = $obj->updateApplicationStatus($applicationId, $userId, $status);

    echo json_encode(["ok" => $ok, "status" => $status]);
    exit();

}

echo json_encode(["ok" => false, "error" => "Unknown action"]);
exit();

?>
