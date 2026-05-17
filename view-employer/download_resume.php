<?php

require_once __DIR__ . "/../../config/EmployerAuth.php";
require_once __DIR__ . "/../../model/EmployerModel.php";

requireEmployer();

$applicationId = isset($_GET["application_id"]) ? (int)$_GET["application_id"] : 0;

if($applicationId <= 0)
{
    http_response_code(400);
    echo "Invalid request.";
    exit();
}

$m = new EmployerModel();
$userId = (int)$_SESSION["user_id"];
$row = $m->getApplicationDetail($applicationId, $userId);

if(!$row)
{
    http_response_code(403);
    echo "Forbidden.";
    exit();
}

$rel = ($row["resume_path"] ?? "") ?: ($row["seeker_resume_path"] ?? "");

if($rel === "" || $rel === null)
{
    http_response_code(404);
    echo "No resume.";
    exit();
}

$rel = str_replace(["\\", "\0"], "", $rel);
$base = realpath(__DIR__ . "/../../uploads");

if($base === false)
{
    http_response_code(500);
    echo "Uploads folder missing.";
    exit();
}

$full = realpath(__DIR__ . "/../../" . $rel);

if(
    $full === false
    || strpos($full, $base) !== 0
)
{
    http_response_code(403);
    echo "Invalid file path.";
    exit();
}

if(!is_file($full))
{
    http_response_code(404);
    echo "File not found.";
    exit();
}

$mime = "application/octet-stream";
$ext = strtolower(pathinfo($full, PATHINFO_EXTENSION));

if($ext === "pdf")
{
    $mime = "application/pdf";
}

header("Content-Type: " . $mime);
header(
    "Content-Disposition: attachment; filename=\"resume_" . (int)$applicationId . "." . $ext . "\""
);

header("Content-Length: " . filesize($full));
readfile($full);
exit();
