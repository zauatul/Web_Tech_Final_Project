<?php

$navSelf =
basename($_SERVER["PHP_SELF"]);

?>

<ul class="dashboard-links seeker-nav">

<li>
<a href="dashboard.php"<?php echo $navSelf === "dashboard.php" ? ' class="active"' : ""; ?>>
Dashboard
</a>
</li>

<li>
<a href="jobs.php"<?php echo $navSelf === "jobs.php" ? ' class="active"' : ""; ?>>
Jobs
</a>
</li>

<li>
<a href="applications.php"<?php echo $navSelf === "applications.php" ? ' class="active"' : ""; ?>>
Applied jobs
</a>
</li>

<li>
<a href="saved_jobs.php"<?php echo $navSelf === "saved_jobs.php" ? ' class="active"' : ""; ?>>
Saved jobs
</a>
</li>

<li>
<a href="profile.php"<?php echo $navSelf === "profile.php" ? ' class="active"' : ""; ?>>
Profile
</a>
</li>

<li>
<a href="../../controller/seeker/SeekerLogoutController.php">
Logout
</a>
</li>

</ul>
