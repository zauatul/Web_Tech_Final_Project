<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Search Seekers</title>
<link rel="stylesheet" href="../../assets/css/recruiter.css">
<script src="../../assets/js/recruiter.js"></script>
</head>

<body >

<div class="dash_container">

    <?php require "recruiter_nav.php"; ?>
    
        <div class>
            <h1>Search Seekers</h1>
            <div >
                <label>Keyword</label>
                <input type="text" id="keyword" placeholder="name, skill, location">
                <button type="button" onclick="recruiterSearchSeekers()">Search</button>

            </div>

        <div id="search-results"></div>

    </div>

</div>

</body>
</html>