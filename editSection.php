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
        
        echo '<table border="1">
            <tr>
                <th>Section ID</th>
                <th>Course ID</th>
                <th>Course Name</th>
                <th>Section</th>
                <th>Day</th>
                <th>Start Time</th>
                <th>End Time</th>
            </tr>';

        $sql = "SELECT * from section";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["SectionID"] . "</td>";
                echo "<td>" . $row["CourseID"] . "</td>";
                echo "<td>" . $row["Sec"] . "</td>";
                echo "<td>" . $row["Day"] . "</td>";
                echo "<td>" . $row["startTime"] . "</td>";
                echo "<td>" . $row["endTime"] . "</td>";
                echo "<td>" . $row["FacultyID"] . "</td>";
                echo '<td><button type="submit" name="edit" value="' . $row["SectionID"] . '">Edit</button></td>'; 
                echo '<td><button type="submit" name="del" value="' . $row["SectionID"] . '">Cancel</button></td>'; 

                
            }
        } else {
            echo "<tr><td colspan='8'>No assignments found.</td></tr>";
        }
        echo '</table>';

    if(isset($_POST['del'])) {
        $SectionID = $_POST['del'];
        $sql1 = "DELETE from section where SectionID ='$SectionID'";
        $d = mysqli_query($conn, $sql1);
        
    }

    elseif (isset($_POST['edit'])) {
        $SectionID = $_POST['edit'];
        $sql1 = "SELECT * FROM section WHERE SectionID = '$SectionID'";
        $d = mysqli_query($conn, $sql1);
    
        $r = mysqli_fetch_assoc($d);
        $courseID = $r["CourseID"];
        $section = $r["Sec"];
        $facultyID = $r["FacultyID"];
    
        $sql2 = "SELECT * FROM course WHERE CourseID = '$courseID'";
        $d1 = mysqli_query($conn, $sql2);
    
        $r1 = mysqli_fetch_assoc($d1);
        $courseName = $r1["CourseName"];

    
        echo "<form method='post'>";
        echo "<br><br><br>";
        echo "Section ID: <input type='text' name='sectionID' value='$courseID' readonly>";
        echo "Course ID: <input type='text' name='courseID' value='$courseID' readonly>";
        echo "Section: <input type='text' name='sec' value='$section' readonly>";
        echo "Day: <input type='text' name='facultyID' value='$facultyID'><br>";
        echo '<td><button type="submit" name="EditSubmit" value="' . $SectionID . '">Submit</button></td>'; 
    
        echo "</form>";
    } elseif (isset($_POST['EditSubmit'])) {
        $facultyID = $_POST["facultyID"];
        $sectionID = $_POST['EditSubmit']; 

        $checkFacultyID= "Select FacultyID from faculty where FacultyID='$facultyID'";
        $checkFacultyIDVerify= mysqli_query($conn, $checkFacultyID);

        if(mysqli_num_rows($checkFacultyIDVerify)== 1) {
            $assignSectionQuery = "UPDATE section SET FacultyID = '$facultyID' WHERE SectionID = '$sectionID'";
            $a = mysqli_query($conn, $assignSectionQuery);
            if ($a) {
                echo $sectionID . " has been Updated";
            }
        }
        else{
            echo "Invalid FacultyID";
        }
    }
    
    
    
    ?>
</form>
</body>

</html>