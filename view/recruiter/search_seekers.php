<?php

// include_once __DIR__ . "/../../config/RecruiterAuth.php";
// requireRecruiter();

?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<title>Search Seekers</title>
<link rel="stylesheet" href="../../assets/css/style.css">
<script src="../../assets/js/recruiter.js"></script>
</head>

<body class="employer-body">

<div class="employer-shell">

    <?php include __DIR__ . "/recruiter_nav.php"; ?>
    
        <div class="employer-main wide">
            <h1>Search Seekers</h1>
            <div class="filter-bar">
                <label>Keyword</label>
                <input type="text" id="keyword" placeholder="name, skill, location">
                <button type="button" onclick="recruiterSearchSeekers()">Search</button>

            </div>

        <div id="search-results"></div>

    </div>

</div>

</body>
</html>