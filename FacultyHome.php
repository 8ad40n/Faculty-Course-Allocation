<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        img
        {
            height: 100px;
            width: 100px;
        }
    </style>
</head>
<body>
<form method="post">
<?php
include("FacultyDashboard.php");
?>
<fieldset>
<legend><h1>Welcome</h1></legend>
<?php
include("dbConnect.php");

session_start();
$id = $_SESSION['id'];

$sql = "SELECT * FROM faculty WHERE FacultyID='$id'";
$res = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($res);

$name = $data['FacultyName']; // Fix the column name
$email = $data['Email'];
$image = $data['Picture'];

echo "<fieldset>";
?>
<img src="Images/<?php echo $image ?>"><br>

<?php
echo "
    <b>Name:</b>$name<br>
    <b>ID:</b>$id<br>
    <b>Email:</b>$email<br>";

?>
</fieldset>
<br><br>
<button name="logout">Logout</button>
</form>
</body>
</html>


<?php
include("dbConnect.php");

if(!isset($_SESSION['id'])) 
{
		header('location: login.php');
}
else{
	if(isset($_POST['logout']))
    {
	session_destroy();
	header('location: login.php');

    }
}

?>