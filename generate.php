<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}




// Query to get all faculty members
$facultyQuery = "SELECT FacultyID, FacultyName FROM faculty";
$facultyResult = mysqli_query($conn, $facultyQuery);

if ($facultyResult) {
    echo '<table border="1">
            <tr>
                <th>Faculty ID</th>
                <th>Faculty Name</th>
                <th>Total Hours Per Week</th>
            </tr>';

    while ($faculty = mysqli_fetch_assoc($facultyResult)) {
        $facultyID = $faculty['FacultyID'];
        $facultyName = $faculty['FacultyName'];

        // Query to calculate the total hours for the faculty per week
        $totalHoursQuery = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(EndTime, StartTime))) AS TotalHours 
                            FROM section 
                            WHERE FacultyID = '$facultyID'";

        $totalHoursResult = mysqli_query($conn, $totalHoursQuery);

        if ($totalHoursResult) {
            $row = mysqli_fetch_assoc($totalHoursResult);
            $totalHours = $row['TotalHours'];

            // Convert the total hours from seconds to hours
            $totalHoursInHours = $totalHours / 3600;

            echo '<tr>';
            echo "<td>$facultyID</td>";
            echo "<td>$facultyName</td>";
            echo "<td>$totalHoursInHours hours</td>";
            echo '</tr>';
        }
    }

    echo '</table>';
} else {
    echo "Error fetching faculty data.";
}




if (isset($_POST['btnGenerate'])) {
    $resetAssignmentsQuery = "UPDATE section SET FacultyID = NULL";
    mysqli_query($conn, $resetAssignmentsQuery);

    $facultyPriorityCoursesQuery = "SELECT FacultyID, CourseID FROM prioritycourses";
    $facultyPriorityCoursesResult = mysqli_query($conn, $facultyPriorityCoursesQuery);

    if ($facultyPriorityCoursesResult) {
        $facultyPriorityCourses = [];
        while ($row = mysqli_fetch_assoc($facultyPriorityCoursesResult)) {
            $facultyID = $row['FacultyID'];
            $courseID = $row['CourseID'];
            $facultyPriorityCourses[$courseID] = $facultyID;
        }

        // Get the list of all faculty members
        $facultyQuery = "SELECT FacultyID FROM faculty";
        $facultyResult = mysqli_query($conn, $facultyQuery);

        if ($facultyResult) {
            $facultyMembers = [];
            while ($row = mysqli_fetch_assoc($facultyResult)) {
                $facultyMembers[] = $row['FacultyID'];
            }

            // Get the list of unassigned sections
            $unassignedSectionsQuery = "SELECT SectionID, CourseID, Day, StartTime, EndTime FROM section WHERE FacultyID IS NULL";
            $unassignedSectionsResult = mysqli_query($conn, $unassignedSectionsQuery);

            if ($unassignedSectionsResult) {
                while ($section = mysqli_fetch_assoc($unassignedSectionsResult)) {
                    $sectionID = $section['SectionID'];
                    $courseID = $section['CourseID'];

                    // Step 3: Check if faculty exceeds 16 hours
                    $totalHoursQuery = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(EndTime, StartTime))) AS TotalHours FROM section WHERE FacultyID = '$facultyID'";
                    $totalHoursResult = mysqli_query($conn, $totalHoursQuery);
                    $totalHours = 0;

                    if ($totalHoursResult && $row = mysqli_fetch_assoc($totalHoursResult)) {
                        $totalHours = (int) $row['TotalHours'];
                    }
                    
                    $sectionStartTime = $section['StartTime'];
                    $sectionEndTime = $section['EndTime'];
                    $sectionDuration = (int) strtotime($sectionEndTime) - (int) strtotime($sectionStartTime);

                    if ($totalHours + $sectionDuration > 16 * 3600) {
                        continue; 
                    } 
                    else {
                        // Check priority time
                        $sectionDay = $section['Day'];
                        $facultyPriorityDayQuery = "SELECT FacultyID, Day, startTime, endTime FROM prioritytime 
                                            WHERE FacultyID IN (" . implode(',', $facultyMembers) . ") 
                                            AND Day = '$sectionDay'";
                        $facultyPriorityDayResult = mysqli_query($conn, $facultyPriorityDayQuery);

                        if ($facultyPriorityDayResult) {
                            while ($priorityTime = mysqli_fetch_assoc($facultyPriorityDayResult)) {
                                $facultyID = $priorityTime['FacultyID'];
                                $facultyStartTime = $priorityTime['startTime'];
                                $facultyEndTime = $priorityTime['endTime'];

                                // Check if the section course is a priority for this faculty
                                if (isset($facultyPriorityCourses[$courseID])) {
                                    if ($facultyPriorityCourses[$courseID] == $facultyID) {
                                        // Check for time clashes with the faculty's other assignments
                                        $clashQuery = "SELECT * FROM section 
                                        WHERE FacultyID = '$facultyID'
                                        AND Day = '$sectionDay'
                                        AND ((StartTime < '$sectionEndTime' AND EndTime > '$sectionStartTime'))";
                                        $clashResult = mysqli_query($conn, $clashQuery);

                                        if (!$clashResult || mysqli_num_rows($clashResult) === 0) {
                                            // No time clashes, assign faculty
                                            $assignQuery = "UPDATE section SET FacultyID = '$facultyID' WHERE SectionID = '$sectionID'";
                                            mysqli_query($conn, $assignQuery);
                                            break; // Faculty assigned, exit loop
                                        }
                                    }
                                }
                            }
                        }
                        else{
                            
                        }

                        // If no time priority or not matching priority course, assign faculty randomly
                        if (empty($facultyPriorityDayResult) || !mysqli_fetch_assoc($facultyPriorityDayResult)) {
                            $facultyID = $facultyMembers[array_rand($facultyMembers)];
                            $clashQuery = "SELECT * FROM section 
                            WHERE FacultyID = '$facultyID'
                            AND Day = '$sectionDay'
                            AND ((StartTime < '$sectionEndTime' AND EndTime > '$sectionStartTime'))";
                            $clashResult = mysqli_query($conn, $clashQuery);

                            if (!$clashResult || mysqli_num_rows($clashResult) === 0) {
                                // No time clashes, assign faculty randomly
                                $assignQuery = "UPDATE section SET FacultyID = '$facultyID' WHERE SectionID = '$sectionID'";
                                mysqli_query($conn, $assignQuery);
                            }
                        }
                    }
                }
            }
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>


<!DOCTYPE html>
<html>

<head>
    <title>Course Assignment</title>
</head>

<body>
    <form method="POST">
        <button type="submit" name="btnGenerate">Generate</button>
    </form>

    <?php
    if (isset($_POST['btnGenerate'])) {
        echo '<table border="1">
            <tr>
                <th>Course ID</th>
                <th>Course Name</th>
                <th>Department</th>
                <th>Section</th>
                <th>Day</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Faculty Name</th>
            </tr>';
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "project";

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT
            section.CourseID,
            course.CourseName,
            course.DepartmentName,
            section.Sec,
            section.Day,
            section.startTime,
            section.endTime,
            faculty.FacultyName
        FROM
            section
        JOIN
            faculty ON section.FacultyID = faculty.FacultyID
        JOIN
            course ON section.CourseID = course.CourseID ORDER BY course.CourseName ASC";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["CourseID"] . "</td>";
                echo "<td>" . $row["CourseName"] . "</td>";
                echo "<td>" . $row["DepartmentName"] . "</td>";
                echo "<td>" . $row["Sec"] . "</td>";
                echo "<td>" . $row["Day"] . "</td>";
                echo "<td>" . $row["startTime"] . "</td>";
                echo "<td>" . $row["endTime"] . "</td>";
                echo "<td>" . $row["FacultyName"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No assignments found.</td></tr>";
        }

        mysqli_close($conn);
        echo '</table>';
    }
    ?>

</body>

</html>
