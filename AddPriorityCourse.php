<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Selection</title>
</head>
<body>

    <form method="post">
        <?php
        include("dbConnect.php");
        include("FacultyDashboard.php");

        echo "<fieldset>
        <legend><h2>Select Courses:</h2></legend>";
        
        session_start();
        $id = $_SESSION['id'];

        // Fetch course names and CourseID from the course table
        $sql = "SELECT CourseID, CourseName FROM course";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $courseID = $row['CourseID'];
                $courseName = $row['CourseName'];
                // Create a checkbox for each course name with CourseID as the value
                echo '<label><input type="checkbox" name="selectedCourses[]" value="' . $courseID . '">' . $courseName . '</label><br>';
            }
        } else {
            echo "No courses found.";
        }
        ?>
        <br>
        <input type="submit" name="submit" value="Submit">
    </form>

    <table border="1">
        <tr>
            <th>Faculty ID</th>
            <th>Course ID</th>
            <th>Course Name</th>

        </tr>
        <?php
        $sql = "SELECT prioritycourses.*, course.CourseName FROM prioritycourses 
        JOIN course ON prioritycourses.CourseID = course.CourseID
        WHERE prioritycourses.FacultyID = '$id';";
        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) > 0) {
            while ($r = mysqli_fetch_assoc($res)) {
                echo "<tr>";
                echo "<td>" . $r["FacultyID"] . "</td>";
                echo "<td>" . $r["CourseID"] . "</td>";
                echo "<td>" . $r["CourseName"] . "</td>";
                echo '<td>
                    <form method="post">
                        <button type="submit" name="del" value="' . $r["CourseID"] . '">Delete</button>
                    </form>
                </td>';
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No priority Courses found.</td></tr>";
        }

        if (isset($_POST['del'])) {
            $FacultyID = $id;
            $courseID = $_POST['del'];
    
            $sql3 = "DELETE FROM prioritycourses WHERE FacultyID='$FacultyID' and CourseID = '$courseID'";
            mysqli_query($conn, $sql3);
        }
        ?>
    </table>

    <?php
    include("dbConnect.php");
    
    if (isset($_POST['submit'])) {
        if (isset($_POST['selectedCourses']) && !empty($_POST['selectedCourses'])) {
            $facultyID = $id;
            
            foreach ($_POST['selectedCourses'] as $selectedCourseID) {
                // Check if the combination of FacultyID and CourseID already exists
                $checkQuery = "SELECT * FROM prioritycourses WHERE FacultyID='$facultyID' AND CourseID='$selectedCourseID'";
                $checkResult = mysqli_query($conn, $checkQuery);

                if (mysqli_num_rows($checkResult) == 0) {
                    // If not exists, then insert it
                    $insertQuery = "INSERT INTO prioritycourses (FacultyID, CourseID) VALUES ('$facultyID', '$selectedCourseID')";
                    $insertResult = mysqli_query($conn, $insertQuery);
                }
            }

            
        } else {
            echo "Try Again!";
        }
    }
    ?>
    </fieldset>
</body>
</html>
