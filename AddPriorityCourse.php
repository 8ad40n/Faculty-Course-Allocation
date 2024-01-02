<?php
include("dbConnect.php");
include("AdminDashboard.php");
echo "<center><h1> Add Priority Courses</h1></center>";
if (isset($_POST['del'])) {
    $facultyID = $_POST["facultyID"];
    $courseID = $_POST['del'];

    $sql3 = "DELETE FROM prioritycourses WHERE FacultyID='$facultyID' and CourseID = '$courseID'";
    mysqli_query($conn, $sql3);

    echo "<script>alert('The priority course: $courseID of $facultyID has been deleted.');</script>";

}

if (isset($_POST['submit'])) {
    if (isset($_POST['selectedCourses']) && !empty($_POST['selectedCourses']) && !empty($_POST['selectedFaculty'])) {
        $facultyID = $_POST["selectedFaculty"];

        
        foreach ($_POST['selectedCourses'] as $selectedCourseID) {
            // Check if the combination of FacultyID and CourseID already exists
            $checkQuery = "SELECT * FROM prioritycourses WHERE FacultyID='$facultyID' AND CourseID='$selectedCourseID'";
            $checkResult = mysqli_query($conn, $checkQuery);

            if (mysqli_num_rows($checkResult) == 0) {
                $s= "Select * from prioritycourses where FacultyID = '$facultyID'";

                $r= mysqli_query($conn, $s);

                $data= mysqli_fetch_assoc($r);
                
                if(mysqli_num_rows($r) < 2)
                {
                    // If not exists, then insert it
                    $insertQuery = "INSERT INTO prioritycourses (FacultyID, CourseID) VALUES ('$facultyID', '$selectedCourseID')";
                    $insertResult = mysqli_query($conn, $insertQuery);

                    echo "<script>alert('The priority course: $selectedCourseID for $facultyID has been added.');</script>";


                }
                else
                {
                    echo "<script>alert('Faculty has already 2 priority course.');</script>";

                }
                   
            }
        }

    } else {
        echo "<script>alert('Try again!');</script>";
    }
}


?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Selection</title>
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>
    <script src="bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>
    <div class="main">
        <div class="container">
            <form method="post">

            <?php
            include("dbConnect.php");

            echo "<fieldset>
            <h3>Faculty:</h3>";
            $sql1 = "SELECT FacultyID, FacultyName FROM faculty";
            $result1 = mysqli_query($conn, $sql1);

            if (mysqli_num_rows($result1) > 0) {
            while ($row1 = mysqli_fetch_assoc($result1)) {
                $facultyID = $row1['FacultyID'];
                $facultyName = $row1['FacultyName'];
                // Create a checkbox for each course name with CourseID as the value
                echo '<label><input type="radio" name="selectedFaculty" value="' . $facultyID . '">' . $facultyName . '</label><br>';
            }
            } else {
            echo "No faculty found.";
            }
            ?>
            <br>
            </fieldset>

            <?php

            echo "<fieldset>
                <h3>Select Courses:</h3>";

            // Fetch course names and CourseID from the course table
            $sql = "SELECT CourseID, CourseName FROM course";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
            $courseID = $row['CourseID'];
            $courseName = $row['CourseName'];
            // Create a checkbox for each course name with CourseID as the value
            echo '<label><input type="checkbox" name="selectedCourses[]" value="' . $courseID . '">' . $courseName .
                '</label><br>';
            }
            } else {
            echo "No courses found.";
            }
            ?>
            <br>
            <input type="submit" class="btn btn-primary" name="submit" value="Submit">
            </fieldset>
            </form>
            <br><br>

            <table class="table table-bordered">
            <tr>
                <th>Faculty ID</th>
                <th>Course ID</th>
                <th>Course Name</th>
                <th><center>Actions</center></th>

            </tr>
            <?php
            $sql = "SELECT prioritycourses.*, course.CourseName FROM prioritycourses 
            JOIN course ON prioritycourses.CourseID = course.CourseID;";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res) > 0) {
            while ($r = mysqli_fetch_assoc($res)) {
                echo "<tr>";
                echo "<td>" . $r["FacultyID"] . "</td>";
                echo "<td>" . $r["CourseID"] . "</td>";
                echo "<td>" . $r["CourseName"] . "</td>";
                echo '<td>
                    <form method="post">
                        <input type="hidden" name = "facultyID" value="'.$r["FacultyID"].'">
                        <center><button type="submit" class="btn btn-danger" name="del" value="' . $r["CourseID"] . '">Delete</button></center>
                    </form>
                </td>';
                echo "</tr>";
            }
            } else {
            echo "<tr><td colspan='4'>No priority Courses found.</td></tr>";
            }


            ?>
            </table>
            
        </div>
    </div>

</body>

</html>