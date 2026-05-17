<?php

include_once __DIR__ . "/../../config/RecruiterAuth.php";
include_once __DIR__ . "/../../model/RecruiterModel.php";

requireRecruiterJson();

header("Content-Type: application/json; charset=utf-8");

if($_SERVER["REQUEST_METHOD"] != "POST")
{
    echo json_encode(
        [
            "ok" => false,
            "error" => "Method"
        ]
    );

    exit();
}


$action = "";

if(isset($_POST["action"]))
{
    $action = $_POST["action"];
}


if($action == "search_seekers")
{
    $keyword = "";

    if(isset($_POST["keyword"]))
    {
        $keyword = trim($_POST["keyword"]);
    }

    $result = searchSeekers($keyword);

    $rows = [];

    while($row = mysqli_fetch_assoc($result))
    {
        $rows[] = $row;
    }

    echo json_encode(
        [
            "ok" => true,
            "rows" => $rows
        ]
    );

    exit();
}


echo json_encode(
    [
        "ok" => false,
        "error" => "Unknown action"
    ]
);

exit();

?>