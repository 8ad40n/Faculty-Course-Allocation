<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- <link rel="stylesheet" href="CSS/AdminHome.css"> -->
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>
    <script src="bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="CSS/style.css">

</head>

<body>
    <?php
include("AdminDashboard.php");
?>
    <div class="main">

        <form method="post">

            <center><label for="Welcome">
                <h1>Welcome!</h1>
            </label></center><fieldset>
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

    ?>
        <div class="span4"><img class="center-block" src="Images/<?php echo $image ?>" /></div>

    <?php
    echo "<center>
    <label><b>Name:</b>$name<br></label><br>
    <label><b>ID:</b>$id<br></label><br>
    <label> <b>Email:</b>$email<br></label><br>
    <label><b>Role:</b>Admin</label></center>"; 
    

?>

            <br>
            <center><button class="btn btn-danger" name="logout">Logout</button></center></fieldset>
        </form>
    </div>
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