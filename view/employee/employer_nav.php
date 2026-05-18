<?php

$navSelf = basename($_SERVER["PHP_SELF"]);

?>

<nav class="employer-nav">

<a href="dashboard.php"<?php echo $navSelf === "dashboard.php" ? ' class="active"' : ""; ?>>
Jobs
</a>

<a href="profile.php"<?php echo $navSelf === "profile.php" ? ' class="active"' : ""; ?>>
Company profile
</a>

<a href="shortlisted.php"<?php echo $navSelf === "shortlisted.php" ? ' class="active"' : ""; ?>>
Shortlisted
</a>

<a href="analytics_company.php"<?php echo $navSelf === "analytics_company.php" ? ' class="active"' : ""; ?>>
Company analytics
</a>

<a href="recruiters.php"<?php echo $navSelf === "recruiters.php" ? ' class="active"' : ""; ?>>
Recruiters
</a>

<a href="complaint.php"<?php echo $navSelf === "complaint.php" ? ' class="active"' : ""; ?>>
Complaint
</a>

<a href="../../controller/employee/EmployerLogoutController.php">
Logout
</a>

</nav>
