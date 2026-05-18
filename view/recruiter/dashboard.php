<?php
session_start();

require_once "../../model/RecruiterModel.php";

$recruiterId = $_SESSION["user_id"];

$clients = listClients($recruiterId);
$jobs = listPostedJobs($recruiterId);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Recruiter Dashboard</title>
<link rel="stylesheet" href="../../assets/css/recruiter.css">
</head>
<body >

    <div class="dash_container">

        <?php require "recruiter_nav.php"; ?>

        <div>

        <h1>Recruiter Dashboard</h1>

        <div class="stat-grid">

        <div class="stat-card">
        <div class="num"><?php echo mysqli_num_rows($clients); ?></div>
        <div class="lbl">Clients</div>
        </div>

        <div class="stat-card">
        <div class="num"><?php echo mysqli_num_rows($jobs); ?></div>
        <div class="lbl">Posted Jobs</div>
        </div>

        </div>

        <h2>Recent Jobs</h2>

        <table class="re_table">

        <tr>
        <th>Job</th>
        <th>Client</th>
        <th>Status</th>
        <th>Created</th>
        </tr>

        <?php

        while($j = mysqli_fetch_assoc($jobs))
        {

        ?>

        <tr>
        <td><?php echo htmlspecialchars($j["title"]); ?></td>
        <td><?php echo htmlspecialchars($j["company_name"]); ?></td>
        <td><?php echo htmlspecialchars($j["status"]); ?></td>
        <td><?php echo htmlspecialchars($j["created_at"]); ?></td>
        </tr>

        <?php

        }

        ?>

        </table>

        </div>

    </div>

</body>
</html>