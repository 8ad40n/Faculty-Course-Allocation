<?php
include("dbConnect.php");
include("AdminDashboard.php");
echo "<center><h1>Edit Section:</h1></center><br>";

if (isset($_POST['del'])) {
    $sectionID = $_POST['del'];
    $sql1 = "DELETE FROM section WHERE SectionID = '$sectionID'";
    $result = mysqli_query($conn, $sql1);

    if ($result) {
        echo "<script>alert('$sectionID has been deleted!');</script>";
    } else {
        echo "<script>alert('Try Again!');</script>";

    }
} elseif (isset($_POST['edit'])) {
    $sectionID = $_POST['edit_section_id'];
    $day = $_POST['edit_day'];
    $sql1 = "SELECT section.*, course.CourseName 
             FROM section 
             JOIN course ON section.CourseID = course.CourseID
             WHERE section.SectionID = '$sectionID'";
    $result = mysqli_query($conn, $sql1);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $courseID = $row["CourseID"];
        $courseName = $row["CourseName"];
        $section = $row["Sec"];
        
        $start = $row["startTime"];
        $end = $row["endTime"];
        
        echo "<div class='container'><form method='post'>";
        echo "<br><br>";
        echo "Section ID: <br><input type='text' class='form-control' name='sectionID' value='$sectionID' readonly><br>";
        echo "Course ID: <br><input type='text' class='form-control' name='courseID' value='$courseID' readonly><br>";
        echo "Course Name: <br><input type='text' class='form-control' name='courseName' value='$courseName' readonly><br>";
        echo "Section: <br><input type='text' class='form-control' name='sec' value='$section' readonly><br>";
        echo "Day:<br> <input type='text' class='form-control' name='day' value='$day'><br>";
        echo "Start Time:<br> <input type='text' class='form-control' name='startTime' value='$start'><br>";
        echo "End Time: <br><input type='text' class='form-control' name='endTime' value='$end'><br>";
        echo '<td><button type="submit" class="btn btn-success" name="EditSubmit" value="' . $sectionID . '">Submit</button></td>';

        echo "</form></div>";
    }
} elseif (isset($_POST['EditSubmit'])) {
    $sectionID = $_POST['EditSubmit'];
    $day = $_POST['day'];
    $start = $_POST['startTime'];
    $end = $_POST['endTime'];

    $sql = "select * from section where SectionID = '$sectionID'";
    $res = mysqli_query($conn, $sql);
    $r= mysqli_fetch_assoc($res);
    $startDB= $r["startTime"];
    $endDB= $r["endTime"];
    $dayDB = $r["Day"];

    $updateSectionQuery ="UPDATE section 
                          SET Day = '$day', startTime = '$start', endTime = '$end'
                          WHERE SectionID = '$sectionID' and startTime= '$startDB' and endTime='$endDB'";
    $result = mysqli_query($conn, $updateSectionQuery);

    if ($result) {
        echo "<script>alert('$sectionID has been updated');</script>";

    } else {
        echo "<script>alert('Invalid Section ID');</script>";

    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Section</title>
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>
    <script src="bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>
    <br>
    <div class="main">
        <div class="container">
            <form method="post">
                <table class="table table-bordered">
                    <tr>
                        <th>Section ID</th>
                        <th>Course ID</th>
                        <th>Course Name</th>
                        <th>Section</th>
                        <th>Day</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th colspan="2"><center>Operations</center></th>
                        <!-- <th>Credit</th> -->
                    </tr>

                    <?php
                $sql = "SELECT section.*, course.CourseName 
                        FROM section 
                        JOIN course ON section.CourseID = course.CourseID
                        ORDER BY section.SectionID ASC;";
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
                        echo '<td>
                        <input type="hidden" name="edit_section_id" value="' . $row["SectionID"] . '">
                        <input type="hidden" name="edit_day" value="' . $row["Day"] . '">
                        <center><button type="submit" class="btn btn-success" name="edit" value="' . $row["SectionID"] . '">Edit</button></center>
                        </td>';

                        echo '<td><center><button type="submit" class="btn btn-danger" name="del" value="' . $row["SectionID"] . '">Delete</button></center></td>';
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No assignments found.</td></tr>";
                }
                ?>
                </table>
            </form>
        </div>
    </div>
</body>

</html>