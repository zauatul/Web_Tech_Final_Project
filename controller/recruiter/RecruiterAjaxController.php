<?php

require_once "../../model/RecruiterModel.php";

header("Content-Type: application/json; charset=utf-8");

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
            "rows" => $rows
        ]
    );

}


?>