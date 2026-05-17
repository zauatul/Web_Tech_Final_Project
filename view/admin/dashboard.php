<?php

session_start();

if(!isset($_SESSION['admin_id']))
{
    header("location:login.php");
    exit();
}

include_once __DIR__ .
"/../../model/AdminModel.php";


$totalUsers =
totalUsers();

$totalJobs =
totalJobs();

$totalApplications =
totalApplications();

?>

<!DOCTYPE html>
<html>
<head>

<title>
Dashboard
</title>

<link rel="stylesheet"
href="../../assets/css/style.css">

</head>

<body>

<div class="container">

<h1>
Admin Dashboard
</h1>

<h3>
Welcome
<?php

echo $_SESSION['admin_name'];

?>
</h3>

<div class="card">
Total Users:
<?php echo $totalUsers;?>
</div>

<div class="card">
Total Jobs:
<?php echo $totalJobs;?>
</div>

<div class="card">
Total Applications:
<?php echo $totalApplications;?>
</div>

<ul class="dashboard-links">

<li>
<a href="manageUsers.php">
Manage Users
</a>
</li>

<li>
<a href="categories.php">
Manage Categories
</a>
</li>

<li>
<a href="complaints.php">
Complaints
</a>
</li>

</ul>

<a class="logout-btn"
href="logout.php">
Logout
</a>

</div>

</body>
</html>
