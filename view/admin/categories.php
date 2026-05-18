<?php

session_start();

if(!isset($_SESSION['admin_id']))
{
    header("location:login.php");
    exit();
}

include_once __DIR__ .
"/../../model/AdminModel.php";


$categories =
getCategories();

?>

<!DOCTYPE html>
<html>
<head>

<title>
Categories
</title>

<link rel="stylesheet"
href="../../assets/css/style.css">

</head>

<body>

<div class="container">

<h2>
Manage Categories
</h2>

<form
action="../../controller/admin/AdminController.php"
method="POST">

<input type="text"
name="name"
placeholder="Category Name"
required>

<textarea
name="description"
placeholder="Description">
</textarea>

<input type="submit"
name="addCategory"
value="Add Category">

</form>

<table>

<tr>
<th>ID</th>
<th>Name</th>
<th>Description</th>
<th>Action</th>
</tr>

<?php

while($row =
$categories->fetch_assoc())
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
<?php echo $row['description'];?>
</td>

<td>

<a href="../../controller/admin/AdminController.php?deleteCategory=<?php echo $row['id'];?>">
Delete
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
