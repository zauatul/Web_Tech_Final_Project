<?php

session_start();

if(!isset($_SESSION['admin_id']))
{
    header("location:login.php");
    exit();
}

include_once __DIR__ .
"/../../model/AdminModel.php";


$complaints =
getComplaints();

?>

<!DOCTYPE html>
<html>
<head>

<title>
Complaints
</title>

<link rel="stylesheet"
href="../../assets/css/style.css">

</head>

<body>

<div class="table-container">

<h2>
Complaints
</h2>

<table>

<tr>
<th>ID</th>
<th>Description</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php

while($row =
$complaints->fetch_assoc())
{

?>

<tr>

<td>
<?php echo $row['id'];?>
</td>

<td>
<?php echo $row['description'];?>
</td>

<td>
<?php echo $row['status'];?>
</td>

<td>

<a href="../../controller/admin/AdminController.php?resolveComplaint=<?php echo $row['id'];?>">
Resolve
</a>

</td>

</tr>

<?php

}

?>

</table>

</div>

</body>
</html>
