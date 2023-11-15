<?php
include("dbConnect.php");
include("AdminDashboard.php");

if (isset($_POST['del'])) {
    $sectionID = $_POST['del'];
    $sql1 = "DELETE FROM section WHERE SectionID = '$sectionID'";
    $result = mysqli_query($conn, $sql1);

    if ($result) {
        echo $sectionID . " has been deleted!";
    } else {
        echo "Try Again!";
    }
} elseif (isset($_POST['edit'])) {
    $sectionID = $_POST['edit'];
    $sql1 = "SELECT section.*, course.CourseName 
             FROM section 
             JOIN course ON section.CourseID = course.CourseID
             WHERE SectionID = '$sectionID'";
    $result = mysqli_query($conn, $sql1);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $courseID = $row["CourseID"];
        $courseName = $row["CourseName"];
        $section = $row["Sec"];
        $day = $row["Day"];
        $start = $row["startTime"];
        $end = $row["endTime"];
        
        echo "<form method='post'>";
        echo "<br><br><br>";
        echo "Section ID: <br><input type='text' name='sectionID' value='$sectionID' readonly><br><br>";
        echo "Course ID: <br><input type='text' name='courseID' value='$courseID' readonly><br><br>";
        echo "Course Name: <br><input type='text' name='courseName' value='$courseName' readonly><br><br>";
        echo "Section: <br><input type='text' name='sec' value='$section'><br><br>";
        echo "Day:<br> <input type='text' name='day' value='$day'><br><br>";
        echo "Start Time:<br> <input type='text' name='startTime' value='$start'><br><br>";
        echo "End Time: <br><input type='text' name='endTime' value='$end'><br><br>";
        echo '<td><button type="submit" name="EditSubmit" value="' . $sectionID . '">Submit</button></td>';

        echo "</form>";
    }
} elseif (isset($_POST['EditSubmit'])) {
    $sectionID = $_POST['EditSubmit'];
    $day = $_POST['day'];
    $start = $_POST['startTime'];
    $end = $_POST['endTime'];

    $updateSectionQuery = "UPDATE section 
                          SET Day = '$day', startTime = '$start', endTime = '$end'
                          WHERE SectionID = '$sectionID'";
    $result = mysqli_query($conn, $updateSectionQuery);

    if ($result) {
        echo $sectionID . " has been updated";
    } else {
        echo "Invalid Section ID";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Section</title>
</head>
<body>
    <form method="POST">
        <table border="1">
            <tr>
                <th>Section ID</th>
                <th>Course ID</th>
                <th>Course Name</th>
                <th>Section</th>
                <th>Day</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th colspan="2">Operations</th>
                <!-- <th>Credit</th> -->
            </tr>

            <?php
            $sql = "SELECT section.*, course.CourseName 
                    FROM section 
                    JOIN course ON section.CourseID = course.CourseID
                    ORDER BY course.CourseName ASC;";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["SectionID"] . "</td>";
                    echo "<td>" . $row["CourseID"] . "</td>";
                    echo "<td>" . $row["CourseName"] . "</td>";
                    echo "<td>" . $row["Sec"] . "</td>";
                    echo "<td>" . $row["Day"] . "</td>";
                    echo "<td>" . $row["startTime"] . "</td>";
                    echo "<td>" . $row["endTime"] . "</td>";
                    //echo "<td>" . $row["Credit"] . "</td>";
                    echo '<td><button type="submit" name="edit" value="' . $row["SectionID"] . '">Edit</button></td>';
                    echo '<td><button type="submit" name="del" value="' . $row["SectionID"] . '">Delete</button></td>';
                }
            } else {
                echo "<tr><td colspan='8'>No assignments found.</td></tr>";
            }
            ?>
        </table>
    </form>
</body>
</html>
