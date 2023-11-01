<?php
session_start();
$servername="localhost";
$username= "root";
$password="";
$dbname="project";
$conn= new mysqli($servername,$username,$password,$dbname);
if (!$conn) 
    {
    die("Connection failed: " . mysqli_connect_error());
    }    
if(isset($_POST['login'])) 
{
    $id=$_POST['id'];
    $pass=$_POST['pass'];
    $sql= "select * from userinfo where ID='$id' and Password='$pass'";
    $res= mysqli_query($conn,$sql);
    if (!empty($id) && !empty($pass)){
    if($res->num_rows==1)
    {
        $new=mysqli_fetch_assoc($res);
        $user=$new["Type"];
        if($user=="Admin")
        {
            header("location: Admin.php");
        }
        elseif($user=="Faculty")
        {
            header("location: Faculty.php");
        }
        while($r=mysqli_fetch_assoc($res))
        {
        $_SESSION['id']=$r["ID"];
        }
    }
    else
    {
        echo "Try Again";
    }
}
    else
    {
        echo "Please fill in all the fields.";
    }
}
if(isset($_POST['forgot'])){
     header("location: PasswordVerification.php");
} 
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Login Page</title>
</head>
<body>
    <form method="post">
    <center><h1>Login</h1></center>
    <script>
    function togglePassword() 
    {
    var passwordInput = document.getElementById("pass");
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
     ID: <input type="text" name="id" placeholder="User Name"><br>
     Password: <input type="password" name="pass" id="pass" placeholder="Password"><br>
     <input type="checkbox" id="showPassword" onclick="togglePassword()">
     <label for="showPassword">Show Password</label><br>
     <button name="login">Login</button>
     <button name="forgot">Forgot Password?</button>
    </form>
</body>
</html>