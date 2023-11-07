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

        echo '<h2>Select Courses:</h2>';
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

    <?php
    include("dbConnect.php");
    session_start();
    $id = $_SESSION['id'];

    if (isset($_POST['submit'])) {
        if (isset($_POST['selectedCourses']) && !empty($_POST['selectedCourses'])) {
            
            $facultyID = $id; // Change this to the actual FacultyID

            foreach ($_POST['selectedCourses'] as $selectedCourseID) {
                $insertQuery = "INSERT INTO prioritycourses (FacultyID, CourseID) VALUES ('$facultyID', '$selectedCourseID')";
                $insertResult = mysqli_query($conn, $insertQuery);
            }

            echo "<h3>Selected Courses have been added to the faculty.</h3>";
        } else {
            echo "No courses selected.";
        }
    }
    ?>
</body>
</html>
