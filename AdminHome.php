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
<?php
include("AdminDashboard.php");
?>
<fieldset>
<legend><h1>Welcome</h1></legend>
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
    <img src="Images/<?php echo $image ?>"><br>

    <?php
    echo "
    <b>Name:</b>$name<br>
    <b>ID:</b>$id<br>
    <b>Email:</b>$email<br>"

?>
</fieldset>
</body>
</html>

