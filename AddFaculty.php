<?php
include("dbConnect.php");
include("AdminDashboard.php");

if(isset($_POST["btnAddFaculty"]))
{
    $facultyID=$_POST["facultyId"];
    $name=$_POST["name"];
    $email=$_POST["mail"];
    $password=$_POST["pass"];

    if (empty($facultyID) || empty($name) || empty($email) || empty($password))
    {
        echo "Please fill in all the fields.";
    }
    else{
        
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    
</head>
<body>
    <fieldset>
        <legend><h1>Add Faculty:</h1></legend>
        <form action="post">
            
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

            Faculty ID:<input type="text" name="facultyId"><br><br>
            Faculty Name:<input type="text" name="name"><br><br>
            Email:<input type="email" name="mail"><br><br>
            Password:<input type="password" name="pass" id="pass"><br>
            <input type="checkbox" id="showPassword" onclick="togglePassword()">
            <label for="showPassword">Show Password</label><br><br>
            <button name="btnAddFaculty">Add</button>


        </form>
    </fieldset>
</body>
</html>