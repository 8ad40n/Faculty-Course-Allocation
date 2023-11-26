<?php
include("dbConnect.php");
include("AdminDashboard.php");

if (isset($_POST["add"])) {
    $facultyID = $_POST["selectedFaculty"]; 
    $day = $_POST["day"];
    $start = $_POST["start"];
    $end = $_POST["end"];

    if (empty($start) || empty($end) || empty($_POST['selectedFaculty'])) {
        echo "Please fill in all the fields.";
    } else {
        $sql = "SELECT Day FROM prioritytime WHERE FacultyID='$facultyID' and Day ='$day'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) == 0) {
            $addSectionQuery = "INSERT INTO prioritytime (FacultyID, Day, startTime, endTime) VALUES ('$facultyID', '$day', '$start', '$end')";
            $addSectionResult = mysqli_query($conn, $addSectionQuery);
            
            if ($addSectionResult) {
                echo "Priority Time has been added!";
            } else {
                echo "Invalid!";
            }
        } else {
            echo "You already have a priority time set.";
        }
    }
}

if (isset($_POST['del'])) {
    $facultyID = $_POST["facultyID"];
    $day = $_POST['del'];

    $sql3 = "DELETE FROM prioritytime WHERE FacultyID='$facultyID' and Day = '$day'";
    mysqli_query($conn, $sql3);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Priority Time</title>
    <link rel="stylesheet" href="CSS/AdminDashboard.css">
</head>

<body>
    <div class="main">
        <form method="post">
            <?php
        include("dbConnect.php");

        echo "<fieldset>
        <legend><h2>Faculty:</h2></legend>";
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

            <fieldset>
                <legend>
                    <h2>Set Priority Time</h2>
                </legend>
                Day:<br>
                <select name="day">
                    <option value="Sunday">Sunday</option>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                </select><br><br>
                Start Time: <br><input type="text" name="start"><br><br>
                End Time: <br><input type="text" name="end"><br>
                <small>Time Format = hh:mm:ss</small><br><br>
                <button type="submit" name="add">Add</button>
            </fieldset><br><br>

            <table border="1">
                <tr>
                    <th>Faculty ID</th>
                    <th>Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Actions</th>
                </tr>
                <?php
            $sql = "SELECT * FROM prioritytime;";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res) > 0) {
                while ($r = mysqli_fetch_assoc($res)) {
                    echo "<tr>";
                    echo "<td>" . $r["FacultyID"] . "</td>";
                    echo "<td>" . $r["Day"] . "</td>";
                    echo "<td>" . $r["startTime"] . "</td>";
                    echo "<td>" . $r["endTime"] . "</td>";
                    echo '<td>      
                            <form method="post">
                            <input type="hidden" name = "facultyID" value="'.$r["FacultyID"].'">
                            <button type="submit" name="del" value="' . $r["Day"] . '">Delete</button>
                            </form>
                         </td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No priority time found.</td></tr>";
            }
            ?>
            </table>
        </form>
    </div>
</body>

</html>