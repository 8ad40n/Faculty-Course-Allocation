<?php
include("dbConnect.php");
include("AdminDashboard.php");

if (isset($_POST["add"])) {
    $facultyID = $_POST["selectedFaculty"];
    $day = $_POST["day"];
    $start = $_POST["start"];
    $end = $_POST["end"];

    if (empty($start) || empty($end) || empty($_POST['selectedFaculty'])) {
        echo "<script>alert('Please fill in all the fields.');</script>";
    } else {
        $sql = "SELECT Day FROM prioritytime WHERE FacultyID='$facultyID' and Day ='$day'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 0) {
            $addSectionQuery = "INSERT INTO prioritytime (FacultyID, Day, startTime, endTime) VALUES ('$facultyID', '$day', '$start', '$end')";
            $addSectionResult = mysqli_query($conn, $addSectionQuery);

            if ($addSectionResult) {
                echo "<script>alert('Priority Time for $facultyID has been added!');</script>";
            } else {
                echo "<script>alert('Invalid!');</script>";
            }
        } else {
            echo "<script>alert('Invalid!');</script>";
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
    <!-- <link rel="stylesheet" href="CSS/AdminDashboard.css"> -->
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>
    <script src="bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>
    <div class="main">
        <div class="container">
        <form method="post">
            <center><h1>Add Priority Time</h1></center>
            <?php
            include("dbConnect.php");

            echo "<fieldset>
        <legend><h3>Faculty:</h3></legend>";
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
                    <h3>Set Priority Time:</h3>
                </legend>
                Day:<br>
                <select name="day" class="form-select form-select-sm" aria-label=".form-select-sm example">
                    <option value="Sunday">Sunday</option>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                </select><br>
                Start Time: <br><input type="text" class='form-control' name="start"><br>
                End Time: <br><input type="text" class='form-control' name="end">
                <small>Time Format = hh:mm:ss</small><br><br>
                <button type="submit" class="btn btn-primary" name="add">Add</button>
            </fieldset><br>

            <table class="table table-bordered">
                <tr>
                    <th>Faculty ID</th>
                    <th>Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th><center>Actions</center></th>
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
                            <input type="hidden" name = "facultyID" value="' . $r["FacultyID"] . '">
                            <center><button type="submit" class="btn btn-danger" name="del" value="' . $r["Day"] . '">Delete</button></center>
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
    </div>
</body>

</html>