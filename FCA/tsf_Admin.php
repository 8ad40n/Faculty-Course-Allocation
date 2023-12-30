<?php
include("dbConnect.php");
include("AdminDashboard.php"); 
?>





<!DOCTYPE html>
<html>

<head>
    <title>TSF</title>
    <!-- <link rel="stylesheet" href="CSS/TryAgain.css"> -->
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>
    <script src="bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>

<body>
    <div class="main">
        <div class="container">
        <form method="POST">
            <br><center><h2>Faculty TSF</h2></center>

            <?php
            include('dbConnect.php');

            echo "
            <input type='text' class='form-control' name='search' placeholder='Search by faculty name'><br>";
            //echo "<button name='btnSearch'>Search</button>";
            echo '<button name="btnSearch" class="btn btn-primary">Search
                 </button>';

            ?>
            
            </form>
        </div>
    </div>
</body>

</html>



<?php
include("dbConnect.php");
if (isset($_POST["btnSearch"])) {
    $facultyName = $_POST["search"];

    $sql = "SELECT * FROM faculty WHERE FacultyName='$facultyName'";
    $result = mysqli_query($conn, $sql);

    if (!empty($facultyName) && mysqli_num_rows($result) > 0) {
        echo "<div class='main'>";
        echo '<div class="container">';
        echo "<center><h2>Data for Faculty Name:</h2> $facultyName </center>";

        echo '<table class="table table-bordered">
                <tr>
                    <th>Time</th>
                    <th>Sunday</th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                </tr>';

        $timeSlots = [
            "08:00:00-08:30:00", "08:30:00-09:00:00", "09:00:00-09:30:00", "09:30:00-10:00:00",
            "10:00:00-10:30:00", "10:30:00-11:00:00", "11:00:00-11:30:00", "11:30:00-12:00:00",
            "12:00:00-12:30:00", "12:30:00-13:00:00", "13:00:00-13:30:00", "13:30:00-14:00:00",
            "14:00:00-14:30:00", "14:30:00-15:00:00", "15:00:00-15:30:00", "15:30:00-16:00:00",
            "16:00:00-16:30:00", "16:30:00-17:00:00",
        ];
        // $time = [
        //     "08:00 AM", "08:30 AM", "09:00 AM", "09:30 AM",
        //     "10:00 AM", "10:30 AM", "11:00 AM", "11:30 AM",
        //     "12:00 PM", "12:30 PM", "01:00 PM", "01:30 PM",
        //     "02:00 PM", "02:30 PM", "03:00 PM", "03:30 PM",
        //     "04:00 PM", "04:30 PM",
        // ];

        foreach ($timeSlots as $timeSlot) {
            echo "<tr><th>$timeSlot</th>";

            $days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday"];

            foreach ($days as $day) {
                

                $query = "SELECT c.CourseName, s.Sec, s.startTime, s.endTime
                          FROM section s
                          JOIN course c ON s.CourseID = c.CourseID
                          JOIN faculty f ON s.FacultyID = f.FacultyID
                          WHERE s.Day = '$day' 
                          AND ('$timeSlot' BETWEEN s.startTime AND s.endTime)
                          AND f.FacultyName = '$facultyName'";
                $result = mysqli_query($conn, $query);

                echo "<td>";
                
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $courseName = $row['CourseName'];
                        $section = $row['Sec'];
                        $classTime = $row['startTime'] . '-' . $row['endTime'];
                        echo "$courseName [$section]<br>[Time: $classTime]";
                    }
                }

                echo "</td>";
            }

            echo "</tr>";
        }

        echo '</table>';
        echo '</div></div>';
    }
}

?>