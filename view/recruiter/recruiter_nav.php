<?php

$navSelf = basename($_SERVER["PHP_SELF"]);

?>

<nav class="employer-nav">

<a href="dashboard.php" <?php if($navSelf == "dashboard.php"){ echo "class='active'"; } ?>>Dashboard</a>

<a href="search_seekers.php" <?php if($navSelf == "search_seekers.php"){ echo "class='active'"; } ?>>Search Seekers</a>

<a href="clients.php" <?php if($navSelf == "clients.php"){ echo "class='active'"; } ?>>Clients</a>

<a href="job_form.php" <?php if($navSelf == "job_form.php"){ echo "class='active'"; } ?>>Post Job</a>

<a href="../../controller/recruiter/RecruiterLogoutController.php">Logout</a>

</nav>