<?php 
include("dbConnect.php");
include("FacultyDashboard.php");
session_start();
$id = $_SESSION['id'];

if(isset($_POST["change"])) {
    $curr = $_POST["currPass"];
    $new = $_POST["newPass"];
    $con = $_POST["conPass"];
 
    $sql = "SELECT Password from userinfo where Password = '$curr' AND ID = '$id'";
    $res = mysqli_query($conn, $sql);

    if(mysqli_num_rows($res) == 1 && ($new == $con)) {
        $sql1 = "UPDATE userinfo SET Password = '$con' where ID = '$id'";
        $res1 = mysqli_query($conn, $sql1);
        if($res1) {
            echo "Password has been changed!";
        } else {
            echo "Invalid! Try Again.";
        }
    }
    else {
        echo "Invalid! Try Again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
</head>
<body>
    <form method="post">
        <fieldset>
            <legend><h1>Change Password</h1></legend>

            <script>
            function togglePassword() 
            {
            var passwordInput = document.getElementById("currPass");
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

            Current Password: <br> <input type="password" name="currPass" id="currPass"><br>
            <input type="checkbox" id="showPassword" onclick="togglePassword()">
            <small>Show Password</small><br><br>
            New Password: <br> <input type="password" name="newPass" id="newPass"><br>
            <input type="checkbox" id="showPassword1" onclick="togglePassword1()">
            <small>Show Password</small><br><br>
            Confirm Password: <br> <input type="password" name="conPass" id="conPass"><br>
            <input type="checkbox" id="showPassword2" onclick="togglePassword2()">
            <small>Show Password</small><br><br>
            <button type="submit" name="change">Confirm</button>
        </fieldset>
    </form>
</body>
</html>
