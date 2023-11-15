<?php
include("dbConnect.php");
include("AdminDashboard.php");

if (isset($_POST["btnAddFaculty"])) {
    $facultyID = $_POST["facultyId"];
    $name = $_POST["name"];
    $email = $_POST["mail"];
    $password = $_POST["pass"];

    $file_name = $_FILES["pic"]["name"];
    $tempname = $_FILES["pic"]["tmp_name"];
    $folder = 'Images/'.$file_name;


    if (empty($facultyID) || empty($name) || empty($email) || empty($password) || empty($file_name)) {
        echo "Please fill in all the fields.";
    } else {
        // Check if the faculty ID already exists
        $verifyQuery = "SELECT FacultyID FROM faculty WHERE FacultyID = '$facultyID'";
        $verifyResult = mysqli_query($conn, $verifyQuery);

        if (mysqli_num_rows($verifyResult) == 0) {
            // Insert faculty information
            $addFacultyQuery = "INSERT INTO faculty (FacultyID, FacultyName, Email, Picture)
            VALUES ('$facultyID', '$name', '$email', '$file_name')";
            $addFacultyResult = mysqli_query($conn, $addFacultyQuery);

            $addFacultyPassQuery = "INSERT INTO userinfo (ID, Password, Type)
            VALUES ('$facultyID', '$password', 'Faculty')";
            $addFacultyPassResult = mysqli_query($conn, $addFacultyPassQuery);

            if ($addFacultyResult && $addFacultyPassResult) {
                echo "Faculty added successfully.";
            } 
        } else {
            echo "Faculty ID already exists.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Faculty</title>
    <link rel="stylesheet" href="CSS/AddFaculty.css">
</head>
<body>

    <div class="container">
        <div class="login">
            
            <div class="content">
                <img src="Images/AddFacutly.jpg" alt="Faculty Image">
            </div>

            <div class="loginform">
                <h1>Add Faculty</h1>
                <br>
                <form method="post" enctype="multipart/form-data">
                    <script>
                        function togglePassword() {
                            var passwordInput = document.getElementById("pass");
                            if (passwordInput.type == "password") {
                                passwordInput.type = "text";
                            } else {
                                passwordInput.type = "password";
                            }
                        }
                    </script>
                    <label><b> Faculty ID:<br><input type="text" name="facultyId"></b></label><br> 
                    <label><b>Faculty Name:<br><input type="text" name="name"></b></label><br>
                    <label><b>Email:<br><input type="email" name="mail"></b></label><br>
                    <label><b>Password:<br><input type="password" name="pass" id="pass"></b></label><br>
                    <input type="checkbox" id="showPassword" onclick="togglePassword()">
                    <label for="showPassword">Show Password</label><br>
                    <label for="picture">Upload Your Picture:</label>
                    <input type="file" name="pic" accept="image/*"><br>  
                    <button type="submit" name="btnAddFaculty">Add</button>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>