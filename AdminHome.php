<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <link rel="stylesheet" href="CSS/AdminHome.css">

</head>
<body>
<?php
include("AdminDashboard.php");
?>
<form method="post">

<label for="Welcome"><h1>Welcome!</h1></label>
<?php
include("dbConnect.php");

session_start();
$id = $_SESSION['id'];

$sql = "select * from admin where AdminID='$id'";
$res= mysqli_query($conn,$sql);
$data = mysqli_fetch_assoc($res);
    $name = $data['AdminName'];
    $email = $data['Email'];
    
    $image = $data['Picture'];

    echo "<fieldset>";
    ?>
    <div class="content">
    <img src="Images/<?php echo $image ?>"><br>
    </div>

    <?php
    echo "
    <label><b>Name:</b>$name<br>
    <label><b>ID:</b>$id<br>
   <label> <b>Email:</b>$email<br></label>" 
    

?>

<br>
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
