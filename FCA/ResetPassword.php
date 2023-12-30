<?php 
include("dbConnect.php");
session_start();

if(isset($_POST["change"])) {

    $id = $_SESSION["facultyid"];

    $new = $_POST["newPass"];
    $con = $_POST["conPass"];
 
    $sql = "SELECT Password from userinfo where ID = '$id'";
    $res = mysqli_query($conn, $sql);

    if(mysqli_num_rows($res) == 1 && ($new == $con)) {
        $sql1 = "UPDATE userinfo SET Password = '$con' where ID = '$id'";
        $res1 = mysqli_query($conn, $sql1);
        if($res1) {
            echo "<script>alert('Password has been recovered!')</script>";
            header("location: login.php");
        } else {
            echo "<script>alert('Invalid! Try Again.')</script>";
            
        }
    }
    else {
        echo "<script>alert('Invalid! Try Again.')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <!-- <link rel="stylesheet" href="CSS/AdminDashboard.css"> -->
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>
    <script src="bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <div class="container">
    <form method="post">
        <fieldset>
            <br><br><center><legend><h1>Reset Password</h1></legend> </center>

            <script>
            function togglePassword1() 
            {
            var passwordInput = document.getElementById("newPass");
            if (passwordInput.type == "password") 
            {
            passwordInput.type = "text";
            } 
            else 
            {
            passwordInput.type = "password";
            }
            }
            </script>

            <script>
            function togglePassword2() 
            {
            var passwordInput = document.getElementById("conPass");
            if (passwordInput.type == "password") 
            {
            passwordInput.type = "text";
            } 
            else 
            {
            passwordInput.type = "password";
            }
            }
            </script>

            New Password: <br> <input class="form-control" type="password" name="newPass" id="newPass">
            <input type="checkbox" id="showPassword1" onclick="togglePassword1()">
            <small>Show Password</small><br><br>
            Confirm Password: <br> <input type="password" class="form-control" name="conPass" id="conPass">
            <input type="checkbox" id="showPassword2" onclick="togglePassword2()">
            <small>Show Password</small><br><br>
            <button type="submit" class="btn btn-success" name="change">Confirm</button>
        </fieldset>
    </form>
    </div>
    
</body>
</html>
