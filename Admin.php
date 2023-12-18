<?php
include("dbConnect.php");
include("AdminDashboard.php");

function getFacultyTotalHours($conn, $facultyID)
{
    $totalHoursQuery = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(endTime, startTime))) AS TotalHours 
                        FROM section 
                        WHERE FacultyID = '$facultyID'";
    $totalHoursResult = mysqli_query($conn, $totalHoursQuery);

    if ($totalHoursResult) {
        $row = mysqli_fetch_assoc($totalHoursResult);
        return $row['TotalHours'] / 3600;
    }

    return 0;
}

function isPriorityTimeAvailable($conn, $facultyID, $day, $startTime, $endTime)
{
    $priorityTimeQuery = "SELECT Day, startTime, endTime FROM prioritytime WHERE FacultyID = '$facultyID'";
    $priorityTimeResult = mysqli_query($conn, $priorityTimeQuery);

    if ($priorityTimeResult && mysqli_num_rows($priorityTimeResult) > 0) {
        $priorityTime = mysqli_fetch_assoc($priorityTimeResult);

        if ($priorityTime['Day'] == $day && $priorityTime['startTime'] <= $startTime && $priorityTime['endTime'] >= $endTime) {
            return true;
        }
    }

    return false;
}

function hasPriorityCourse($conn, $facultyID, $courseID)
{
    $priorityCourseQuery = "SELECT * FROM prioritycourses WHERE FacultyID = '$facultyID' AND CourseID = '$courseID'";
    $priorityCourseResult = mysqli_query($conn, $priorityCourseQuery);

    return ($priorityCourseResult && mysqli_num_rows($priorityCourseResult) > 0);
}

// function hasCourseClashes($conn, $facultyID, $startTime, $endTime) {
//     $clashQuery = "SELECT SectionID FROM section WHERE FacultyID = '$facultyID' 
//                     AND ((startTime >= '$startTime' AND startTime <= '$endTime') 
//                     OR (endTime > '$startTime' AND endTime < '$endTime'))";
//     $clashResult = mysqli_query($conn, $clashQuery);

//     return (mysqli_num_rows($clashResult) > 0);
// }

function hasCourseClashes($conn, $facultyID, $startTime, $endTime, $day)
{
    $clashQuery = "SELECT SectionID FROM section WHERE FacultyID = '$facultyID' 
                    AND Day = '$day' AND ((startTime >= '$startTime' AND startTime <= '$endTime') 
                    OR (endTime > '$startTime' AND endTime < '$endTime'))";
    $clashResult = mysqli_query($conn, $clashQuery);

    return (mysqli_num_rows($clashResult) > 0);
}

if (isset($_POST["btnClear"])) {
    $resetAssignmentsQuery = "UPDATE section SET FacultyID = NULL";
    mysqli_query($conn, $resetAssignmentsQuery);
} elseif (isset($_POST['btnGenerate'])) {

    $resetAssignmentsQuery = "UPDATE section SET FacultyID = NULL";
    mysqli_query($conn, $resetAssignmentsQuery);

    $facultyQuery = "SELECT FacultyID, FacultyName FROM faculty ORDER BY FacultyID ASC, TotalHours ASC";
    $facultyResult = mysqli_query($conn, $facultyQuery);

    if ($facultyResult) {
        while ($faculty = mysqli_fetch_assoc($facultyResult)) {
            $facultyID = $faculty['FacultyID'];

            $availableCoursesQuery = "SELECT * FROM section WHERE FacultyID IS NULL";
            $availableCoursesResult = mysqli_query($conn, $availableCoursesQuery);

            if ($availableCoursesResult && mysqli_num_rows($availableCoursesResult) > 0) {
                while ($course = mysqli_fetch_assoc($availableCoursesResult)) {
                    $sectionID = $course['SectionID'];
                    $courseID = $course['CourseID'];
                    $day = $course['Day'];
                    $startTime = $course['startTime'];
                    $endTime = $course['endTime'];

                    $sql = "select * from prioritytime where FacultyID ='$facultyID'";
                    $r = mysqli_query($conn, $sql);

                    while ($res = mysqli_fetch_assoc($r)) {
                        $d = $res['Day'];
                        $s = $res['startTime'];
                        $e = $res['endTime'];

                        if ($day == $d && $s <= $startTime && $e >= $endTime) {
                            if (hasPriorityCourse($conn, $facultyID, $courseID)) {

                                if (!hasCourseClashes($conn, $facultyID, $startTime, $endTime, $day)) {

                                    $totalHours = getFacultyTotalHours($conn, $facultyID);

                                    $q = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(endTime, startTime))) AS TotalHours 
                                        FROM section 
                                        WHERE SectionID = '$sectionID'";
                                    $r = mysqli_query($conn, $q);
                                    $r1 = mysqli_fetch_assoc($r);
                                    $time = $r1['TotalHours'];
                                    $hour = $time / 3600;

                                    if (($totalHours + $hour) <= 16) {

                                        $assignSectionQuery = "UPDATE section SET FacultyID = '$facultyID' WHERE SectionID = '$sectionID'";
                                        mysqli_query($conn, $assignSectionQuery);

                                        $totalHoursQuery = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(endTime, startTime))) AS TotalHours 
                                        FROM section 
                                        WHERE FacultyID = '$facultyID'";

                                        $totalHoursResult = mysqli_query($conn, $totalHoursQuery);

                                        if ($totalHoursResult) {
                                            $row = mysqli_fetch_assoc($totalHoursResult);
                                            $totalHours = $row['TotalHours'];

                                            $totalHoursInHours = $totalHours / 3600;

                                            $updateTotalHoursQuery = "UPDATE faculty SET TotalHours = '$totalHoursInHours' WHERE FacultyID = '$facultyID'";
                                            mysqli_query($conn, $updateTotalHoursQuery);
                                        }
                                    }
                                }
                            }
                        } elseif ($day != $d) {
                            if (hasPriorityCourse($conn, $facultyID, $courseID)) {

                                if (!hasCourseClashes($conn, $facultyID, $startTime, $endTime, $day)) {

                                    $totalHours = getFacultyTotalHours($conn, $facultyID);

                                    $q = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(endTime, startTime))) AS TotalHours 
                                        FROM section 
                                        WHERE SectionID = '$sectionID'";
                                    $r = mysqli_query($conn, $q);
                                    $r1 = mysqli_fetch_assoc($r);
                                    $time = $r1['TotalHours'];
                                    $hour = $time / 3600;

                                    if (($totalHours + $hour) <= 16) {

                                        $assignSectionQuery = "UPDATE section SET FacultyID = '$facultyID' WHERE SectionID = '$sectionID'";
                                        mysqli_query($conn, $assignSectionQuery);

                                        $totalHoursQuery = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(endTime, startTime))) AS TotalHours 
                                        FROM section 
                                        WHERE FacultyID = '$facultyID'";

                                        $totalHoursResult = mysqli_query($conn, $totalHoursQuery);

                                        if ($totalHoursResult) {
                                            $row = mysqli_fetch_assoc($totalHoursResult);
                                            $totalHours = $row['TotalHours'];

                                            $totalHoursInHours = $totalHours / 3600;

                                            $updateTotalHoursQuery = "UPDATE faculty SET TotalHours = '$totalHoursInHours' WHERE FacultyID = '$facultyID'";
                                            mysqli_query($conn, $updateTotalHoursQuery);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }


    $facultyQuery1 = "SELECT FacultyID, FacultyName FROM faculty ORDER BY FacultyID ASC, TotalHours ASC";
    $facultyResult1 = mysqli_query($conn, $facultyQuery1);

    if ($facultyResult1) {
        while ($faculty = mysqli_fetch_assoc($facultyResult1)) {
            $facultyID = $faculty['FacultyID'];

            $availableCoursesQuery = "SELECT * FROM section WHERE FacultyID IS NULL";
            $availableCoursesResult = mysqli_query($conn, $availableCoursesQuery);

            if ($availableCoursesResult && mysqli_num_rows($availableCoursesResult) > 0) {
                while ($course = mysqli_fetch_assoc($availableCoursesResult)) {
                    $sectionID = $course['SectionID'];
                    $courseID = $course['CourseID'];
                    $day = $course['Day'];
                    $startTime = $course['startTime'];
                    $endTime = $course['endTime'];

                    $sql = "select * from prioritytime where FacultyID ='$facultyID'";
                    $r = mysqli_query($conn, $sql);

                    while ($res = mysqli_fetch_assoc($r)) {
                        $d = $res['Day'];
                        $s = $res['startTime'];
                        $e = $res['endTime'];

                        if ($day == $d && $s <= $startTime && $e >= $endTime) {
                            $sql1 = "select * from prioritycourses where FacultyID ='$facultyID'";
                            $r1 = mysqli_query($conn, $sql1);

                            if (mysqli_num_rows($r1) == 0) {

                                if (!hasCourseClashes($conn, $facultyID, $startTime, $endTime, $day)) {

                                    $totalHours = getFacultyTotalHours($conn, $facultyID);

                                    $q = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(endTime, startTime))) AS TotalHours 
                                        FROM section 
                                        WHERE SectionID = '$sectionID'";
                                    $r = mysqli_query($conn, $q);
                                    $r1 = mysqli_fetch_assoc($r);
                                    $time = $r1['TotalHours'];
                                    $hour = $time / 3600;

                                    if (($totalHours + $hour) <= 16) {

                                        $assignSectionQuery = "UPDATE section SET FacultyID = '$facultyID' WHERE SectionID = '$sectionID'";
                                        mysqli_query($conn, $assignSectionQuery);

                                        $totalHoursQuery = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(endTime, startTime))) AS TotalHours 
                                        FROM section 
                                        WHERE FacultyID = '$facultyID'";

                                        $totalHoursResult = mysqli_query($conn, $totalHoursQuery);

                                        if ($totalHoursResult) {
                                            $row = mysqli_fetch_assoc($totalHoursResult);
                                            $totalHours = $row['TotalHours'];

                                            $totalHoursInHours = $totalHours / 3600;

                                            $updateTotalHoursQuery = "UPDATE faculty SET TotalHours = '$totalHoursInHours' WHERE FacultyID = '$facultyID'";
                                            mysqli_query($conn, $updateTotalHoursQuery);
                                        }
                                    }
                                }
                            }
                        } elseif ($day != $d) {
                            $sql1 = "select * from prioritycourses where FacultyID ='$facultyID'";
                            $r1 = mysqli_query($conn, $sql1);

                            if (mysqli_num_rows($r1) == 0) {

                                if (!hasCourseClashes($conn, $facultyID, $startTime, $endTime, $day)) {

                                    $totalHours = getFacultyTotalHours($conn, $facultyID);

                                    $q = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(endTime, startTime))) AS TotalHours 
                                        FROM section 
                                        WHERE SectionID = '$sectionID'";
                                    $r = mysqli_query($conn, $q);
                                    $r1 = mysqli_fetch_assoc($r);
                                    $time = $r1['TotalHours'];
                                    $hour = $time / 3600;

                                    if (($totalHours + $hour) <= 16) {

                                        $assignSectionQuery = "UPDATE section SET FacultyID = '$facultyID' WHERE SectionID = '$sectionID'";
                                        mysqli_query($conn, $assignSectionQuery);

                                        $totalHoursQuery = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(endTime, startTime))) AS TotalHours 
                                        FROM section 
                                        WHERE FacultyID = '$facultyID'";

                                        $totalHoursResult = mysqli_query($conn, $totalHoursQuery);

                                        if ($totalHoursResult) {
                                            $row = mysqli_fetch_assoc($totalHoursResult);
                                            $totalHours = $row['TotalHours'];

                                            $totalHoursInHours = $totalHours / 3600;

                                            $updateTotalHoursQuery = "UPDATE faculty SET TotalHours = '$totalHoursInHours' WHERE FacultyID = '$facultyID'";
                                            mysqli_query($conn, $updateTotalHoursQuery);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }



    $facultyQuery2 = "SELECT FacultyID, FacultyName FROM faculty ORDER BY FacultyID ASC, TotalHours ASC";
    $facultyResult2 = mysqli_query($conn, $facultyQuery2);

    if ($facultyResult2) {
        while ($faculty = mysqli_fetch_assoc($facultyResult2)) {
            $facultyID = $faculty['FacultyID'];

            $availableCoursesQuery = "SELECT * FROM section WHERE FacultyID IS NULL";
            $availableCoursesResult = mysqli_query($conn, $availableCoursesQuery);

            if ($availableCoursesResult && mysqli_num_rows($availableCoursesResult) > 0) {
                while ($course = mysqli_fetch_assoc($availableCoursesResult)) {
                    $sectionID = $course['SectionID'];
                    $courseID = $course['CourseID'];
                    $day = $course['Day'];
                    $startTime = $course['startTime'];
                    $endTime = $course['endTime'];

                    $sql1 = "select * from prioritytime where FacultyID ='$facultyID'";
                    $r1 = mysqli_query($conn, $sql1);

                    if (mysqli_num_rows($r1) == 0) {

                        if (hasPriorityCourse($conn, $facultyID, $courseID)) {

                            if (!hasCourseClashes($conn, $facultyID, $startTime, $endTime, $day)) {

                                $totalHours = getFacultyTotalHours($conn, $facultyID);

                                $q = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(endTime, startTime))) AS TotalHours 
                                    FROM section 
                                    WHERE SectionID = '$sectionID'";
                                $r = mysqli_query($conn, $q);
                                $r1 = mysqli_fetch_assoc($r);
                                $time = $r1['TotalHours'];
                                $hour = $time / 3600;

                                if (($totalHours + $hour) <= 16) {

                                    $assignSectionQuery = "UPDATE section SET FacultyID = '$facultyID' WHERE SectionID = '$sectionID'";
                                    mysqli_query($conn, $assignSectionQuery);

                                    $totalHoursQuery = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(endTime, startTime))) AS TotalHours 
                                    FROM section 
                                    WHERE FacultyID = '$facultyID'";

                                    $totalHoursResult = mysqli_query($conn, $totalHoursQuery);

                                    if ($totalHoursResult) {
                                        $row = mysqli_fetch_assoc($totalHoursResult);
                                        $totalHours = $row['TotalHours'];

                                        $totalHoursInHours = $totalHours / 3600;

                                        $updateTotalHoursQuery = "UPDATE faculty SET TotalHours = '$totalHoursInHours' WHERE FacultyID = '$facultyID'";
                                        mysqli_query($conn, $updateTotalHoursQuery);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }



    $facultyQuery3 = "SELECT FacultyID, FacultyName FROM faculty ORDER BY FacultyID ASC, TotalHours ASC";
    $facultyResult3 = mysqli_query($conn, $facultyQuery3);

    if ($facultyResult3) {
        while ($faculty = mysqli_fetch_assoc($facultyResult3)) {
            $facultyID = $faculty['FacultyID'];

            $availableCoursesQuery = "SELECT * FROM section WHERE FacultyID IS NULL";
            $availableCoursesResult = mysqli_query($conn, $availableCoursesQuery);

            if ($availableCoursesResult && mysqli_num_rows($availableCoursesResult) > 0) {
                while ($course = mysqli_fetch_assoc($availableCoursesResult)) {
                    $sectionID = $course['SectionID'];
                    $courseID = $course['CourseID'];
                    $day = $course['Day'];
                    $startTime = $course['startTime'];
                    $endTime = $course['endTime'];

                    $sql1 = "select * from prioritytime where FacultyID ='$facultyID'";
                    $res1 = mysqli_query($conn, $sql1);

                    if (mysqli_num_rows($res1) == 0) {

                        $sql2 = "select * from prioritycourses where FacultyID ='$facultyID'";
                        $res2 = mysqli_query($conn, $sql2);

                        if (mysqli_num_rows($res2) == 0) {

                            if (!hasCourseClashes($conn, $facultyID, $startTime, $endTime, $day)) {

                                $totalHours = getFacultyTotalHours($conn, $facultyID);

                                $q = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(endTime, startTime))) AS TotalHours 
                                    FROM section 
                                    WHERE SectionID = '$sectionID'";
                                $r = mysqli_query($conn, $q);
                                $r1 = mysqli_fetch_assoc($r);
                                $time = $r1['TotalHours'];
                                $hour = $time / 3600;

                                if (($totalHours + $hour) <= 16) {

                                    $assignSectionQuery = "UPDATE section SET FacultyID = '$facultyID' WHERE SectionID = '$sectionID'";
                                    mysqli_query($conn, $assignSectionQuery);

                                    $totalHoursQuery = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(endTime, startTime))) AS TotalHours 
                                    FROM section 
                                    WHERE FacultyID = '$facultyID'";

                                    $totalHoursResult = mysqli_query($conn, $totalHoursQuery);

                                    if ($totalHoursResult) {
                                        $row = mysqli_fetch_assoc($totalHoursResult);
                                        $totalHours = $row['TotalHours'];

                                        $totalHoursInHours = $totalHours / 3600;

                                        $updateTotalHoursQuery = "UPDATE faculty SET TotalHours = '$totalHoursInHours' WHERE FacultyID = '$facultyID'";
                                        mysqli_query($conn, $updateTotalHoursQuery);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}



if (isset($_POST['del'])) {
    $SectionID = $_POST['del'];
    $sql1 = "UPDATE section SET FacultyID = NULL WHERE SectionID = '$SectionID'";
    $d = mysqli_query($conn, $sql1);

    echo "<script>alert('The faculty of the $SectionID has been removed.');</script>";
}


if (isset($_POST['edit'])) {
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
    $dept = $r1["DepartmentName"];

    echo "<form method='post'>";

    echo "<h2>Edit Assignment:<h2>";
    echo "<br>";
    echo "<h4>Course ID: </h4><input type='text' name='courseID' value='$courseID' readonly><br>";
    echo "<h4>Course Name:</h4><input type='text' name='courseName' value='$courseName' readonly><br>";
    echo "<h4>Department:</h4><input type='text' name='dept' value='$dept' readonly><br>";
    echo "<h4>Section: </h4><input type='text' name='sec' value='$section' readonly><br>";
    echo "<h4>Faculty ID:</h4><input type='text' name='facultyID' value='$facultyID'><br>";
    echo '<button type="submit" name="EditSubmit" value="' . $SectionID . '">Submit</button><br><br>';

    echo "</form>";
} elseif (isset($_POST['EditSubmit'])) {
    $facultyID = $_POST["facultyID"];
    $sectionID = $_POST['EditSubmit'];

    // Get the details of the section you want to assign
    $sectionDetailsQuery = "SELECT * FROM section WHERE SectionID = '$sectionID'";
    $sectionDetailsResult = mysqli_query($conn, $sectionDetailsQuery);
    $sectionDetails = mysqli_fetch_assoc($sectionDetailsResult);

    $day = $sectionDetails['Day'];
    $start = $sectionDetails['startTime'];
    $end = $sectionDetails['endTime'];

    // Check if the faculty has time clashes
    $checkClashesQuery = "SELECT SectionID FROM section WHERE FacultyID = '$facultyID'";
    $clashesResult = mysqli_query($conn, $checkClashesQuery);

    // Iterate through assigned sections
    $hasClashes = false;
    while ($clash = mysqli_fetch_assoc($clashesResult)) {
        $clashSectionID = $clash['SectionID'];

        // Get the details of the assigned section
        $sectionDetailsQuery = "SELECT * FROM section WHERE SectionID = '$clashSectionID'";
        $sectionDetailsResult = mysqli_query($conn, $sectionDetailsQuery);
        $clashSection = mysqli_fetch_assoc($sectionDetailsResult);

        // Compare the timings to check for clashes
        if (($clashSection['Day'] == $day) &&
            (($clashSection['startTime'] >= $start && $clashSection['startTime'] < $end) ||
                ($clashSection['endTime'] > $start && $clashSection['endTime'] <= $end))
        ) {
            $hasClashes = true;
            break;
        }
    }

    if ($hasClashes) {
        echo "<script> alert('Time clash! Faculty cannot be assigned.');</script>";
    } else {

        $assignSectionQuery = "UPDATE section SET FacultyID = '$facultyID' WHERE SectionID = '$sectionID'";
        $a = mysqli_query($conn, $assignSectionQuery);
        if ($a) {
            echo "<script>alert('$sectionID has been updated.');</script>";
        }
    }
}
?>




<!DOCTYPE html>
<html>

<head>
    <title>Course Assignment</title>
    <link rel="stylesheet" href="CSS/TryAgain.css">

</head>

<body>
    <div class="main">

        <form method="POST">
            <button type="submit" name="btnGenerate">Generate Section</button>

            <?php
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

            echo "
        <br><br>
        <button name='btnClear'>Clear All</button><br><br>";



            echo "<h1>Data:</h1>";

            echo "<input type='text' class='form-control' placeholder='Search...' id='search_field'>";

            echo '<table id="myTable" border="1">
            <tr>
                <th>Course ID</th>
                <th>Course Name</th>
                <th>Department</th>
                <th>Section</th>
                <th>Day</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Faculty Name</th>
                <th colspan="2">Operations</th>
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
            course ON section.CourseID = course.CourseID ORDER BY faculty.FacultyName ASC,course.CourseName ASC";

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
                    echo '<td><button type="submit" name="edit" value="' . $row["SectionID"] . '">Edit</button></td>';
                    echo '<td><button type="submit" name="del" value="' . $row["SectionID"] . '">Cancel</button></td>';
                }
            } else {
                echo "<tr><td colspan='8'>No assignments found.</td></tr>";
            }
            echo '</table>';

            ?>
        </form>
    </div>

    <script src='https://code.jquery.com/jquery-1.12.4.min.js'></script>

    <script src="js/index.js"></script>


    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-36251023-1']);
        _gaq.push(['_setDomainName', 'jqueryscript.net']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') +
                '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();
    </script>
</body>

</html>