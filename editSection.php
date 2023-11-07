<?php
include("dbConnect.php");
include("AdminDashboard.php"); 

?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Section</title>
</head>


    <form method="POST">

<?php
include('dbConnect.php');

if(isset($_POST['del'])) {
    $SectionID = $_POST['del'];
    $sql1 = "DELETE from section where SectionID ='$SectionID'";
    $d = mysqli_query($conn, $sql1);
    if($d)
    {
        echo $SectionID." has been deleted!";
    }
    else
    {
        echo "Try Again!";
    }
    
}

elseif (isset($_POST['edit'])) {
    $SectionID = $_POST['edit'];
    $sql1 = "SELECT * FROM section WHERE SectionID = '$SectionID'";
    $d = mysqli_query($conn, $sql1);

    $r = mysqli_fetch_assoc($d);
    $courseID = $r["CourseID"];
    $section = $r["Sec"];
    $day = $r["Day"];
    $start= $r["startTime"];
    $end= $r["endTime"];

    $sql2 = "SELECT * FROM course WHERE CourseID = '$courseID'";
    $d1 = mysqli_query($conn, $sql2);

    $r1 = mysqli_fetch_assoc($d1);
    $courseName = $r1["CourseName"];


    echo "<form method='post'>";
    echo "<br><br><br>";
    echo "Section ID: <br><input type='text' name='sectionID' value='$SectionID' readonly><br><br>";
    echo "Course ID: <br><input type='text' name='courseID' value='$courseID' readonly><br><br>";
    echo "Course Name: <br><input type='text' name='courseName' value='$courseName' readonly><br><br>";
    echo "Section: <br><input type='text' name='sec' value='$section' readonly><br><br>";
    echo "Day:<br> <input type='text' name='day' value='$day'><br><br>";
    echo "Start Time:<br> <input type='text' name='startTime' value='$start'><br><br>";
    echo "End Time: <br><input type='text' name='endTime' value='$end'><br><br>";
    echo '<td><button type="submit" name="EditSubmit" value="' . $SectionID . '">Submit</button></td>'; 

    echo "</form>";
} 
elseif (isset($_POST['EditSubmit'])) {
    $sectionID = $_POST['EditSubmit']; 
    $courseID = $_POST['courseID'];
    $courseName = $_POST['courseName'];
    $section = $_POST['sec'];
    $day = $_POST['day'];
    $start= $_POST['startTime'];
    $end= $_POST['endTime'];


    $assignSectionQuery = "UPDATE section SET Day = '$day',startTime='$start', endTime= '$end' WHERE SectionID = '$sectionID' and Day = '$day'";
    $a = mysqli_query($conn, $assignSectionQuery);
    if ($a) {
        echo $sectionID . " has been Updated";
    }
    else{
        echo "Invalid FacultyID";
    }
}


        echo '<table border="1">
            <tr>
                <th>Section ID</th>
                <th>Course ID</th>
                <th>Course Name</th>
                <th>Section</th>
                <th>Day</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Credit</th>

            </tr>';

        $sql = "SELECT section.*, course.*
                FROM section
                JOIN course ON section.CourseID = course.CourseID ORDER BY course.CourseName ASC;";

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
                echo "<td>" . $row["Credit"] . "</td>";
 
                echo '<td><button type="submit" name="edit" value="' . $row["SectionID"] . '">Edit</button></td>'; 
                echo '<td><button type="submit" name="del" value="' . $row["SectionID"] . '">Delete</button></td>'; 

                
            }
        } else {
            echo "<tr><td colspan='8'>No assignments found.</td></tr>";
        }
        echo '</table>';
    ?>
</form>
</body>

</html>