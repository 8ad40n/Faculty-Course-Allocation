<?php
include("dbConnect.php");
include("FacultyDashboard.php");

session_start();
$id = $_SESSION['id'];

if (isset($_GET["add"])) {
    $facultyID = $id; 
    $day = $_GET["day"];
    $start = $_GET["start"];
    $end = $_GET["end"];

    if (empty($start) || empty($end)) {
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Priority Time</title>
</head>
<body>
    <form method="get">
        <fieldset>
            <legend><h1>Set Priority Time</h1></legend>
            Faculty ID: <br><input type="text" name="facultyID" value="<?php echo $id; ?>" readonly><br><br>
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
        </tr>
        <?php
        $sql = "SELECT * FROM prioritytime where FacultyID='$id';";
        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) > 0) {
            while ($r = mysqli_fetch_assoc($res)) {
                echo "<tr>";
                echo "<td>" . $r["FacultyID"] . "</td>";
                echo "<td>" . $r["Day"] . "</td>";
                echo "<td>" . $r["startTime"] . "</td>";
                echo "<td>" . $r["endTime"] . "</td>";
                echo '<td>
                            <button type="submit" name="del" value="' . $r["Day"] . '">Delete</button>
                     </td>';
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No priority time found.</td></tr>";
        }

        if (isset($_GET['del'])) {
            $FacultyID = $id;
            $day= $_GET['del'];
    
            $sql3 = "DELETE FROM prioritytime WHERE FacultyID='$FacultyID' and Day = '$day'";
            mysqli_query($conn, $sql3);
        }
        ?>
    </table>
    </form>
</body>
</html>
