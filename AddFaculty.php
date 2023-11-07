<?php
include("dbConnect.php");
include("AdminDashboard.php");

if (isset($_POST["btnAddFaculty"])) {
    $facultyID = $_POST["facultyId"];
    $name = $_POST["name"];
    $email = $_POST["mail"];
    $password = $_POST["pass"];

    if (empty($facultyID) || empty($name) || empty($email) || empty($password)) {
        echo "Please fill in all the fields.";
    } else {
        // Check if the faculty ID already exists
        $verifyQuery = "SELECT FacultyID FROM faculty WHERE FacultyID = '$facultyID'";
        $verifyResult = mysqli_query($conn, $verifyQuery);

        if (mysqli_num_rows($verifyResult) == 0) {
            // Insert faculty information
            $addFacultyQuery = "INSERT INTO faculty (FacultyID, FacultyName, Email)
            VALUES ('$facultyID', '$name', '$email')";
            $addFacultyResult = mysqli_query($conn, $addFacultyQuery);

            $addFacultyPassQuery = "INSERT INTO userinfo (ID, Password, Type)
            VALUES ('$facultyID', '$password', 'Faculty')";
            $addFacultyPassResult = mysqli_query($conn, $addFacultyPassQuery);

            if ($addFacultyResult && $addFacultyPassResult) {
                echo "Faculty added successfully.";
            } else {
                echo "Error adding faculty.";
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
</head>
<body>
    <fieldset>
        <legend><h1>Add Faculty:</h1></legend>
        <form method="post">
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

            Faculty ID:<br><input type="text" name="facultyId"><br><br>
            Faculty Name:<br><input type="text" name="name"><br><br>
            Email:<br><input type="email" name="mail"><br><br>
            Password:<br><input type="password" name="pass" id="pass"><br>
            <input type="checkbox" id="showPassword" onclick="togglePassword()">
            <label for="showPassword">Show Password</label><br><br>
            <button type="submit" name="btnAddFaculty">Add</button>
        </form>
    </fieldset>
</body>
</html>
