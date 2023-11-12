<!DOCTYPE html>
<html>
<head>
	<title>Faculty</title>
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
echo "<h1>TSF:</h1>";
echo '<table border="1">
  <tr>
    <th>Course ID</th>
    <th>Course Name</th>
    <th>Section</th>
    <th>Day</th>
    <th>Start Time</th>
    <th>End Time</th>
  </tr>';

$sql = "SELECT
  section.SectionID,
  section.CourseID,
  course.CourseName,
  section.Sec,
  section.Day,
  section.startTime,
  section.endTime
FROM
  section
LEFT JOIN
  faculty ON section.FacultyID = faculty.FacultyID
JOIN
  course ON section.CourseID = course.CourseID
WHERE 
  section.FacultyID = '{$_SESSION['id']}'
ORDER BY
section.Day,section.startTime ASC";

$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row["CourseID"] . "</td>";
    echo "<td>" . $row["CourseName"] . "</td>";
    echo "<td>" . $row["Sec"] . "</td>";
    echo "<td>" . $row["Day"] . "</td>";
    echo "<td>" . $row["startTime"] . "</td>";
    echo "<td>" . $row["endTime"] . "</td>";
    echo "</tr>";
  }
} else {
  echo "<tr><td colspan='6'>No assignments found.</td></tr>";
}

mysqli_close($conn);
echo '</table>';

?>
