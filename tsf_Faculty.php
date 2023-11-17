<!DOCTYPE html>
<html>
<head>
	<title>Faculty</title>
  <link rel="stylesheet" href="CSS/AdminDashboard.css">
</head>
<body>
   <form method="post">

        
    </form>
</body>
</html>

<?php
include('dbConnect.php');
include('FacultyDashboard.php');
session_start();

//$id = $_SESSION['id'];
echo "<center><h1>TSF:</h1></center>";

$sql= "select * from faculty where FacultyID='{$_SESSION['id']}'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
    echo '<table border="1">
        <tr>
            <th>Day</th>
            <th>8AM-9:30AM</th>
            <th>8AM-10AM</th>
            <th>8AM-11AM</th>
            <th>9:30AM-11AM</th>
            <th>10AM-12PM</th>
            <th>11AM-12:30PM</th>
            <th>11AM-2PM</th>
            <th>12PM-2PM</th>
            <th>12:30PM-2PM</th>
            <th>2PM-3:30PM</th>
            <th>2PM-4PM</th>
            <th>2PM-5PM</th>
        </tr>';

    $days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday"];

    foreach ($days as $day) {
        echo "<tr><th>$day</th>";

        $timeSlots = [
            "08:00:00-09:30:00", "08:00:00-10:00:00", "08:00:00-11:00:00",
            "09:30:00-11:00:00", "10:00:00-12:00:00", "11:00:00-12:30:00",
            "11:00:00-14:00:00", "12:00:00-14:00:00", "12:30:00-14:00:00", 
            "14:00:00-15:30:00", "14:00:00-16:00:00", "14:00:00-17:00:00",
        ];

        foreach ($timeSlots as $timeSlot) {
            list($startTime, $endTime) = explode('-', $timeSlot);

            $query = "SELECT c.CourseName, s.Sec 
                    FROM section s
                    JOIN course c ON s.CourseID = c.CourseID
                    JOIN faculty f ON s.FacultyID = f.FacultyID
                    WHERE s.Day = '$day' 
                    AND s.startTime = '$startTime' 
                    AND s.endTime = '$endTime' 
                    AND f.FacultyID = '{$_SESSION['id']}'";
            $result = mysqli_query($conn, $query);

            if ($result && $row = mysqli_fetch_assoc($result)) {
                $courseName = $row['CourseName'];
                $section = $row['Sec'];
                echo "<td>$courseName [$section]</td>";
            } else {
                echo "<td></td>";
            }
        }

        echo "</tr>";
    }

    echo '</table>';
}
mysqli_close($conn);


?>
