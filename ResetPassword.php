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
            echo "Password has been recovered!";
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
            <legend><h1>Reset Password</h1></legend> 

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
