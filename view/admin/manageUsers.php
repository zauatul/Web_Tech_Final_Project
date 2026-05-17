<?php

session_start();

if(!isset($_SESSION['admin_id']))
{
    header("location:login.php");
    exit();
}

include_once __DIR__ .
"/../../model/AdminModel.php";


$users = getAllUsers();

?>

<!DOCTYPE html>
<html>
<head>

<title>
Manage Users
</title>

<link rel="stylesheet"
href="../../assets/css/style.css">

<script src="../../assets/js/admin.js">
</script>

</head>

<body>

<div class="table-container">

<h2>
Manage Users
</h2>

<table>

<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Role</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php

while($row =
$users->fetch_assoc())
{

?>

<tr>

<td>
<?php echo $row['id'];?>
</td>

<td>
<?php echo $row['name'];?>
</td>

<td>
<?php echo $row['email'];?>
</td>

<td>
<?php echo $row['role'];?>
</td>

<td id="status<?php echo $row['id'];?>">

<?php

if($row['is_active'] == 1)
{
    echo "Active";
}
else
{
    echo "Disabled";
}

?>

</td>

<td>

<button
onclick="updateStatus(
<?php echo $row['id'];?>,
1
)">
Approve
</button>

<button
onclick="updateStatus(
<?php echo $row['id'];?>,
0
)">
Disable
</button>

</td>

</tr>

<?php

}

?>

</table>

</div>

</body>
</html>
