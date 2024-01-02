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
    <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>
    <script src="bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="CSS/style.css">
   
</head>

<body>
    <div class="main">
        <div class="container">
        <div class="addCourse">
        <center><h2>Add Courses:</h2></center>
        <div class="row">
            <div class="col-sm-6">
                <img style="height: 500px; width: 500px" src="Images/addCourse.jpg" alt="Course Image">
            </div>
            <div class="col-sm-6">
                <br><br><br>
                <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Course ID:</label><br><input type="text" class="form-control" name="courseID"><br>
                </div>
                <div class="form-group">
                    <label>Course Name:</label><br><input type="text" class="form-control" name="name"><br>
                </div>
                    <label>Department:<br>
                            <select name="dept" class="form-select form-select-sm" aria-label=".form-select-sm example">
                                <option value="CSE">CSE</option>
                            </select><br>
                            <label>Credit:<br>
                                    <select name="credit" class="form-select form-select-sm" aria-label=".form-select-sm example">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select><br>
                            <label>Type:<br>
                                    <select name="type" class="form-select form-select-sm" aria-label=".form-select-sm example">
                                        <option value="Theory">Theory</option>
                                        <option value="LAB">LAB</option>
                                        <option value="Theory+LAB">Theory+LAB</option>
                                    </select><br>
                            <button type="submit" class="btn btn-primary" name="btnAdd">Add</button>
                </form>
            </div>
        </div>
        </div>
    </div>
    </div>
</body>

</html>