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
        echo "<script>alert('Please fill in all the fields.');</script>";

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
                echo "<script>alert('New Faculty: $facultyID added successfully.');</script>";

            } 
        } else {
            echo "<script>alert('Faculty ID already exists.');</script>";

        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Faculty:</title>
    <!-- <link rel="stylesheet" href="CSS/AddFaculty.css"> -->
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>
    <script src="bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>
    <br><center><h1>Add Faculty</h1></center><br><br>
    <div class="container">
        <div class="row">

            <div class="col-sm-6">
                <img style="height: 400px; width: 500px" src="Images/addFacultyy.gif" alt="Faculty Image">
            </div>

            <div class="col-sm-6">
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
                    <label>Faculty ID:</label><br><input type="text" class="form-control" name="facultyId"><br>
                    <label>Faculty Name:</label><br><input type="text" class="form-control" name="name"><br>
                    <label>Email:</label><br><input type="email" class="form-control" name="mail"><br>
                    <label>Password:</label><br><input type="password" class="form-control" name="pass" id="pass">
                    <input type="checkbox" id="showPassword" onclick="togglePassword()">
                    <label for="showPassword">Show Password</label><br><br>
                    <label for="picture">Upload Your Picture:</label>
                    <input type="file" class="form-control" name="pic" accept="image/*"><br>
                    <button type="submit" class="btn btn-primary" name="btnAddFaculty">Add</button>
                </form>
                <br><br>
            </div>
        </div>
    </div>

</body>

</html>