<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
include("FacultyDashboard.php");
?>
<fieldset>
<legend><h1>Welcome</h1></legend>
<?php
include("dbConnect.php");

session_start();
$id = $_SESSION['id'];

$sql = "select * from faculty where FacultyID='$id'";
$res= mysqli_query($conn,$sql);
$data = mysqli_fetch_assoc($res);
    $name = $data['FacultyID'];
    $email = $data['Email'];
    

    echo "<fieldset>
    
    <b>Name:</b>.$name.<br>
    <b>ID:</b>.$id.<br>
    <b>Email:</b>.$email.<br>"

?>
</fieldset>
</body>
</html>

