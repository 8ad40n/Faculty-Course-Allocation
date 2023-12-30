<?php
include("dbConnect.php");
include("AdminDashboard.php");

if (isset($_POST["btnAdd"])) {
    $courseID = $_POST["courseID"];
    $name = $_POST["name"];
    $dept = $_POST["dept"];
    $credit = $_POST["credit"];
    $type = $_POST["type"];

    if (empty($courseID) || empty($name) || empty($dept) || empty($credit) || empty($type)) {
        echo "<script>alert('Please fill in all the fields.');</script>";

        
    } else {
        $verifyQuery = "SELECT * FROM course WHERE CourseID = '$courseID'";
        $res = mysqli_query($conn, $verifyQuery);

        if (mysqli_num_rows($res) == 0) {

            $addCourseQuery = "INSERT INTO course (CourseID, CourseName, DepartmentName, Credit, Type) VALUES ('$courseID','$name','$dept','$credit' ,'$type')";
            $r = mysqli_query($conn, $addCourseQuery);

            if ($r) {
                echo "<script>alert('New course added successfully.');</script>";
            } else {
                echo "Error adding course: " . mysqli_error($conn);
            }
        } else {
            echo "<script>alert('This course already exists.');</script>";
            
        }

    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Courses:</title>
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <div class="login">
            <div class="content">
                <img src="Images/addCourse.jpg" alt="Course Image">
            </div>
            <div class="loginform">
                <h1>Add Courses:</h1>
                <br>
                <form method="post" enctype="multipart/form-data">
                    <label><b> Course ID:<br><input type="text" name="courseID"></b></label><br>
                    <label><b>Course Name:<br><input type="text" name="name"></b></label><br>
                    <label><b>Department:<br>
                            <select name="dept">
                                <option value="CSE">CSE</option>
                            </select><br><br>
                            <label><b>Credit:</b><br>
                                    <select name="credit">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select><br><br>
                            <label><b>Type:</b><br>
                                    <select name="type">
                                        <option value="Theory">Theory</option>
                                        <option value="LAB">LAB</option>
                                        <option value="Theory+LAB">Theory+LAB</option>
                                    </select><br><br>
                            <button type="submit" name="btnAdd">Add</button>
                </form>
            </div>
        </div>
    </div>

    <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>
    <script src="bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>
</body>

</html>