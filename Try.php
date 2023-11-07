<?php
include("dbConnect.php");
include("AdminDashboard.php"); 
if (isset($_POST['btnGenerate'])) {
    // Reset assignments for all sections
    $resetAssignmentsQuery = "UPDATE section SET FacultyID = NULL";
    mysqli_query($conn, $resetAssignmentsQuery);

    // Get the list of all faculty members
    $facultyQuery = "SELECT FacultyID, FacultyName FROM faculty";
    $facultyResult = mysqli_query($conn, $facultyQuery);

    if ($facultyResult) {
        while ($faculty = mysqli_fetch_assoc($facultyResult)) {
            $facultyID = $faculty['FacultyID'];

            // Check priority time for this faculty
            $priorityTimeQuery = "SELECT Day, startTime, endTime FROM prioritytime WHERE FacultyID = '$facultyID'";
            $priorityTimeResult = mysqli_query($conn, $priorityTimeQuery);

            if ($priorityTimeResult && mysqli_num_rows($priorityTimeResult) > 0) {
                $priorityTime = mysqli_fetch_assoc($priorityTimeResult);
                $day = $priorityTime['Day'];
                $startTime = $priorityTime['startTime'];
                $endTime = $priorityTime['endTime'];

                // Check total hours for this faculty
                $totalHoursQuery = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(endTime, startTime))) AS TotalHours 
                            FROM section 
                            WHERE FacultyID = '$facultyID'";
                $totalHoursResult = mysqli_query($conn, $totalHoursQuery);

                if ($totalHoursResult) {
                    $row = mysqli_fetch_assoc($totalHoursResult);
                    $totalHours = $row['TotalHours'] / 3600; // Convert to hours

                    // Check if total hours are less than or equal to 16
                    if ($totalHours <= 18) {
                        // Check available sections during the priority time
                        $checkSectionAvailabilityQuery = "SELECT SectionID, startTime, endTime, CourseID FROM section 
                            WHERE Day = '$day' 
                            AND FacultyID IS NULL";

                        $sectionAvailabilityResult = mysqli_query($conn, $checkSectionAvailabilityQuery);

                        while ($section = mysqli_fetch_assoc($sectionAvailabilityResult)) {
                            $sectionstartTime = $section['startTime'];
                            $sectionendTime = $section['endTime'];
                            $sectionCourseID = $section['CourseID'];

                            // Check if the section falls within the priority time
                            if ($sectionstartTime >= $startTime && $sectionendTime <= $endTime) {
                                // Check if this section's course is a priority course for the faculty
                                $priorityCourseQuery = "SELECT * FROM prioritycourses WHERE FacultyID = '$facultyID' AND CourseID = '$sectionCourseID'";
                                $priorityCourseResult = mysqli_query($conn, $priorityCourseQuery);

                                if ($priorityCourseResult && mysqli_num_rows($priorityCourseResult) > 0) {
                                    // Check for clashes with existing assignments
                                    $clashQuery = "SELECT SectionID FROM section WHERE FacultyID = '$facultyID' 
                                    AND ((startTime >= '$sectionstartTime' AND startTime < '$sectionendTime') 
                                    OR (endTime > '$sectionstartTime' AND endTime <= '$sectionendTime'))";
                                    $clashResult = mysqli_query($conn,$clashQuery);    

                                    if (mysqli_num_rows($clashResult) == 0) {
                                        // Assign this section to the faculty since it's a priority course, and no clashes
                                        $sectionID = $section['SectionID'];
                                        $assignSectionQuery = "UPDATE section SET FacultyID = '$facultyID' WHERE SectionID = '$sectionID'";
                                        mysqli_query($conn, $assignSectionQuery);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    // Check if there are still sections available
    $checkAvailableSectionsQuery = "SELECT SectionID FROM section WHERE FacultyID IS NULL";
    $availableSectionsResult = mysqli_query($conn, $checkAvailableSectionsQuery);

    while ($section = mysqli_fetch_assoc($availableSectionsResult)) {
        // Check priority courses of all faculty
        $facultyQuery = "SELECT FacultyID FROM faculty";
        $facultyResult = mysqli_query($conn, $facultyQuery);

        while ($faculty = mysqli_fetch_assoc($facultyResult)) {
            $facultyID = $faculty['FacultyID'];

            // Check if this section's course is a priority course for the faculty
            $sectionID = $section['SectionID'];
            $courseQuery = "SELECT CourseID FROM section WHERE SectionID = '$sectionID'";
            $courseResult = mysqli_query($conn, $courseQuery);

            if ($courseResult && mysqli_num_rows($courseResult) > 0) {
                $row = mysqli_fetch_assoc($courseResult);
                $sectionCourseID = $row['CourseID'];

                $priorityCourseQuery = "SELECT * FROM prioritycourses WHERE FacultyID = '$facultyID' AND CourseID = '$sectionCourseID'";
                $priorityCourseResult = mysqli_query($conn, $priorityCourseQuery);

                // Check total hours for the faculty
                $totalHoursQuery = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(endTime, startTime))) AS TotalHours 
                            FROM section 
                            WHERE FacultyID = '$facultyID'";
                $totalHoursResult = mysqli_query($conn, $totalHoursQuery);

                if ($priorityCourseResult && mysqli_num_rows($priorityCourseResult) > 0) {
                    $row = mysqli_fetch_assoc($totalHoursResult);
                    $totalHours = $row['TotalHours'] / 3600; // Convert to hours

                    // Check if total hours are less than or equal to 16
                    if ($totalHours <= 18) {
                        // Check for clashes with existing assignments
                        $sectionstartTimeQuery = "SELECT startTime, endTime FROM section WHERE SectionID = '$sectionID'";
                        $sectionstartTimeResult = mysqli_query($conn, $sectionstartTimeQuery);

                        if ($sectionstartTimeResult && mysqli_num_rows($sectionstartTimeResult) > 0) {
                            $row = mysqli_fetch_assoc($sectionstartTimeResult);
                            $sectionstartTime = $row['startTime'];
                            $sectionendTime = $row['endTime'];
                            // Check for clashes with existing assignments
                            $clashQuery = "SELECT SectionID FROM section WHERE FacultyID = '$facultyID' 
                                        AND ((startTime >= '$sectionstartTime' AND startTime < '$sectionendTime') 
                                        OR (endTime > '$sectionstartTime' AND endTime <= '$sectionendTime'))";
                            $clashResult = mysqli_query($conn, $clashQuery);

                            if (mysqli_num_rows($clashResult) == 0) {
                                // Assign this section to the faculty since it's a priority course, and no clashes
                                $assignSectionQuery = "UPDATE section SET FacultyID = '$facultyID' WHERE SectionID = '$sectionID'";
                                mysqli_query($conn, $assignSectionQuery);
                            }
                        }
                    }
                }
            }
        }
    }

    // Check if there are still sections available
    $checkAvailableSectionsQuery = "SELECT SectionID FROM section WHERE FacultyID IS NULL";
    $availableSectionsResult = mysqli_query($conn, $checkAvailableSectionsQuery);

    while ($section = mysqli_fetch_assoc($availableSectionsResult)) {
        // Check if this section is available
        $sectionID = $section['SectionID'];
        $checkSectionAvailabilityQuery = "SELECT startTime, endTime, CourseID FROM section 
        WHERE SectionID = '$sectionID' 
        AND FacultyID IS NULL";

        $sectionAvailabilityResult = mysqli_query($conn, $checkSectionAvailabilityQuery);

        if (mysqli_num_rows($sectionAvailabilityResult) > 0) {
            // Section is still available
            $sectionData = mysqli_fetch_assoc($sectionAvailabilityResult);
            $sectionStartTime = $sectionData['startTime'];
            $sectionEndTime = $sectionData['endTime'];
            $sectionCourseID = $sectionData['CourseID'];

            // Check total hours for faculty members
            $facultyQuery = "SELECT FacultyID FROM faculty";
            $facultyResult = mysqli_query($conn, $facultyQuery);

            $availableFaculty = array(); // Store faculty members who meet the criteria

            while ($faculty = mysqli_fetch_assoc($facultyResult)) {
                $facultyID = $faculty['FacultyID'];

                // Check if the faculty's total hours are less than or equal to 16
                $totalHoursQuery = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(EndTime, StartTime))) AS TotalHours 
                FROM section 
                WHERE FacultyID = '$facultyID'";

                $totalHoursResult = mysqli_query($conn, $totalHoursQuery);

                if ($totalHoursResult) {
                    $row = mysqli_fetch_assoc($totalHoursResult);
                    $totalHours = $row['TotalHours'] / 3600; // Convert to hours

                    // Check if total hours are less than or equal to 16
                    if ($totalHours <= 18) {
                        // Check for clashes with existing assignments
                        $clashQuery = "SELECT SectionID FROM section WHERE FacultyID = '$facultyID' 
                        AND ((startTime >= '$sectionStartTime' AND startTime < '$sectionEndTime') 
                        OR (endTime > '$sectionStartTime' AND endTime <= '$sectionEndTime'))";
                        $clashResult = mysqli_query($conn, $clashQuery);

                        if (mysqli_num_rows($clashResult) == 0) {
                            // Faculty can be assigned this section, add them to the available faculty list
                            $availableFaculty[] = $facultyID;
                        }
                    }
                }
            }

            if (!empty($availableFaculty)) {
                // Randomly select a faculty member from the available list
                $randomFacultyID = $availableFaculty[array_rand($availableFaculty)];

                // Assign this section to the randomly selected faculty
                $assignSectionQuery = "UPDATE section SET FacultyID = '$randomFacultyID' WHERE SectionID = '$sectionID'";
                mysqli_query($conn, $assignSectionQuery);
            }
        }
    }
}



?>



<!DOCTYPE html>
<html>

<head>
    <title>Course Assignment</title>
</head>


    <form method="POST">
        <button type="submit" name="btnGenerate">Generate Section</button>
        
    </form>

    <?php
    if (isset($_POST['btnGenerate'])) {

        include('dbConnect.php');

        echo "<h1>Total Hours:</h1>";
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
                $totalHoursQuery = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(endTime, startTime))) AS TotalHours 
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

        echo "<h1>Data:</h1>";
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

        $sql = "SELECT
            section.SectionID,
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
        LEFT JOIN
            faculty ON section.FacultyID = faculty.FacultyID
        JOIN
            course ON section.CourseID = course.CourseID ORDER BY faculty.FacultyName DESC";

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
















<?php
// ... Your existing code ...

if (isset($_POST['btnGenerate'])) {
    // Reset assignments for all sections
    $resetAssignmentsQuery = "UPDATE section SET FacultyID = NULL";
    mysqli_query($conn, $resetAssignmentsQuery);

    // Get the list of all faculty members
    $facultyQuery = "SELECT FacultyID, FacultyName FROM faculty";
    $facultyResult = mysqli_query($conn, $facultyQuery);

    if ($facultyResult) {
        echo '<h1>Faculty Break Times:</h1>';
        echo '<table border="1">
            <tr>
                <th>Faculty Name</th>
                <th>Break Times (Day - Start Time - End Time)</th>
            </tr>';

        while ($faculty = mysqli_fetch_assoc($facultyResult)) {
            $facultyID = $faculty['FacultyID'];
            $facultyName = $faculty['FacultyName'];

            // Fetch the sections assigned to this faculty
            $facultySectionsQuery = "SELECT Day, startTime, endTime FROM section WHERE FacultyID = '$facultyID'";
            $facultySectionsResult = mysqli_query($conn, $facultySectionsQuery);

            if ($facultySectionsResult) {
                // Convert the faculty's schedule into break times
                $breakTimes = calculateBreakTimes($facultySectionsResult);

                // Filter break times to be between 08:00:00 and 17:00:00
                $breakTimes = filterBreakTimes($breakTimes);

                // Display faculty break times in a table
                echo '<tr>';
                echo "<td>$facultyName</td>";
                echo "<td>";
                foreach ($breakTimes as $breakTime) {
                    echo $breakTime['Day'] . " - " . $breakTime['startTime'] . " - " . $breakTime['endTime'] . "<br>";
                }
                echo "</td>";
                echo '</tr>';
            }
        }

        echo '</table>';
    }
}

function calculateBreakTimes($sectionsResult) {
    $breakTimes = array();

    $currentDay = null;
    $currentStartTime = null;
    $currentEndTime = null;

    while ($section = mysqli_fetch_assoc($sectionsResult)) {
        if ($section['Day'] !== $currentDay) {
            // Found a new day, save the previous day's break time
            if ($currentDay !== null) {
                $breakTimes[] = array(
                    'Day' => $currentDay,
                    'startTime' => $currentEndTime,
                    'endTime' => $section['startTime']
                );
            }

            // Initialize for the new day
            $currentDay = $section['Day'];
            $currentStartTime = $section['startTime'];
            $currentEndTime = $section['endTime'];
        } else {
            // Extend the current day's end time
            $currentEndTime = $section['endTime'];
        }
    }

    return $breakTimes;
}

function filterBreakTimes($breakTimes) {
    $filteredBreakTimes = array();

    foreach ($breakTimes as $breakTime) {
        if ($breakTime['startTime'] >= '08:00:00' && $breakTime['endTime'] <= '17:00:00') {
            $filteredBreakTimes[] = $breakTime;
        }
    }

    return $filteredBreakTimes;
}

// ... The rest of your code ...
?>
