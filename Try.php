<?php
include("dbConnect.php");
include("AdminDashboard.php"); 

function getFacultyTotalHours($conn, $facultyID) {
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

function isPriorityTimeAvailable($conn, $facultyID, $day, $startTime, $endTime) {
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

function hasPriorityCourse($conn, $facultyID, $courseID) {
    $priorityCourseQuery = "SELECT * FROM prioritycourses WHERE FacultyID = '$facultyID' AND CourseID = '$courseID'";
    $priorityCourseResult = mysqli_query($conn, $priorityCourseQuery);

    return ($priorityCourseResult && mysqli_num_rows($priorityCourseResult) > 0);
}

function hasCourseClashes($conn, $facultyID, $startTime, $endTime) {
    $clashQuery = "SELECT SectionID FROM section WHERE FacultyID = '$facultyID' 
                    AND ((startTime >= '$startTime' AND startTime < '$endTime') 
                    OR (endTime > '$startTime' AND endTime <= '$endTime'))";
    $clashResult = mysqli_query($conn, $clashQuery);

    return (mysqli_num_rows($clashResult) > 0);
}

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

            // Check the available courses where FacultyID is null in the section table
            $availableCoursesQuery = "SELECT * FROM section WHERE FacultyID IS NULL";
            $availableCoursesResult = mysqli_query($conn, $availableCoursesQuery);

            if ($availableCoursesResult && mysqli_num_rows($availableCoursesResult) > 0) {
                while ($course = mysqli_fetch_assoc($availableCoursesResult)) {
                    $sectionID = $course['SectionID'];
                    $courseID = $course['CourseID'];
                    $day = $course['Day'];
                    $startTime = $course['startTime'];
                    $endTime = $course['endTime'];

                    // Check the priority time of the faculty
                    if (isPriorityTimeAvailable($conn, $facultyID, $day, $startTime, $endTime)) {
                        // Check the priority course of the faculty
                        if (hasPriorityCourse($conn, $facultyID, $courseID)) {
                            // Check if the faculty is assigned to the course
                            if (!hasCourseClashes($conn, $facultyID, $startTime, $endTime)) {
                                // Check if the total hours per week for the faculty will be <= 16
                                $totalHours = getFacultyTotalHours($conn, $facultyID);
                                if ($totalHours <= 16) {
                                    // Assign this section to the faculty
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

    $facultyQuery1 = "SELECT FacultyID, FacultyName FROM faculty";
    $facultyResult1 = mysqli_query($conn, $facultyQuery1);

    if ($facultyResult1) {
        while ($faculty = mysqli_fetch_assoc($facultyResult1)) {
            $facultyID = $faculty['FacultyID'];

            // Check the available courses where FacultyID is null in the section table
            $availableCoursesQuery = "SELECT * FROM section WHERE FacultyID IS NULL";
            $availableCoursesResult = mysqli_query($conn, $availableCoursesQuery);

            if ($availableCoursesResult && mysqli_num_rows($availableCoursesResult) > 0) {
                while ($course = mysqli_fetch_assoc($availableCoursesResult)) {
                    $sectionID = $course['SectionID'];
                    $courseID = $course['CourseID'];
                    $day = $course['Day'];
                    $startTime = $course['startTime'];
                    $endTime = $course['endTime'];

                    
                    // Check the priority course of the faculty
                    if (hasPriorityCourse($conn, $facultyID, $courseID)) {
                        // Check if the faculty is assigned to the course
                        if (!hasCourseClashes($conn, $facultyID, $startTime, $endTime)) {
                            // Check if the total hours per week for the faculty will be <= 16
                            $totalHours = getFacultyTotalHours($conn, $facultyID);
                            if ($totalHours <= 16) {
                                // Assign this section to the faculty
                                $assignSectionQuery = "UPDATE section SET FacultyID = '$facultyID' WHERE SectionID = '$sectionID'";
                                mysqli_query($conn, $assignSectionQuery);
                            }
                        }
                    }
                
                }
            }
        }
    }

    $facultyQuery2 = "SELECT FacultyID, FacultyName FROM faculty";
    $facultyResult2 = mysqli_query($conn, $facultyQuery2);

    if ($facultyResult2) {
        while ($faculty = mysqli_fetch_assoc($facultyResult2)) {
            $facultyID = $faculty['FacultyID'];

            // Check the available courses where FacultyID is null in the section table
            $availableCoursesQuery = "SELECT * FROM section WHERE FacultyID IS NULL";
            $availableCoursesResult = mysqli_query($conn, $availableCoursesQuery);

            if ($availableCoursesResult && mysqli_num_rows($availableCoursesResult) > 0) {
                while ($course = mysqli_fetch_assoc($availableCoursesResult)) {
                    $sectionID = $course['SectionID'];
                    $courseID = $course['CourseID'];
                    $day = $course['Day'];
                    $startTime = $course['startTime'];
                    $endTime = $course['endTime'];

                    // Check if the faculty is assigned to the course
                    if (!hasCourseClashes($conn, $facultyID, $startTime, $endTime)) {
                        // Check if the total hours per week for the faculty will be <= 16
                        $totalHours = getFacultyTotalHours($conn, $facultyID);
                        if ($totalHours <= 16) {
                            // Assign this section to the faculty
                            $assignSectionQuery = "UPDATE section SET FacultyID = '$facultyID' WHERE SectionID = '$sectionID'";
                            mysqli_query($conn, $assignSectionQuery);
                        }
                    }
                    
                
                }
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
            course ON section.CourseID = course.CourseID ORDER BY faculty.FacultyName,section.Day DESC";

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

    if(isset($_POST['del'])) {
        $SectionID = $_POST['del'];
        $sql1 = "UPDATE section SET FacultyID = NULL WHERE SectionID = '$SectionID'";
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
        $dept = $r1["DepartmentName"];
    
        echo "<form method='post'>";
        echo "<br><br><br>";
        echo "Course ID: <input type='text' name='courseID' value='$courseID' readonly>";
        echo "Course Name: <input type='text' name='courseName' value='$courseName' readonly>";
        echo "Department: <input type='text' name='dept' value='$dept' readonly>";
        echo "Section: <input type='text' name='sec' value='$section' readonly>";
        echo "Faculty ID: <input type='text' name='facultyID' value='$facultyID'><br>";
        echo '<td><button type="submit" name="EditSubmit" value="' . $SectionID . '">Submit</button></td>'; 
    
        echo "</form>";
    } 
    // elseif (isset($_POST['EditSubmit'])) {
    //     $facultyID = $_POST["facultyID"];
    //     $sectionID = $_POST['EditSubmit']; 

    //     $checkFacultyID= "Select FacultyID from faculty where FacultyID='$facultyID'";
    //     $checkFacultyIDVerify= mysqli_query($conn, $checkFacultyID);

       

    //     if(mysqli_num_rows($checkFacultyIDVerify)== 1) {
    //         $assignSectionQuery = "UPDATE section SET FacultyID = '$facultyID' WHERE SectionID = '$sectionID'";
    //         $a = mysqli_query($conn, $assignSectionQuery);
    //         if ($a) {
    //             echo $sectionID . " has been Updated";
    //         }
    //     }
    //     else{
    //         echo "Invalid FacultyID";
    //     }
    // }

    elseif (isset($_POST['EditSubmit'])) {
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
                ($clashSection['endTime'] > $start && $clashSection['endTime'] <= $end))) {
                $hasClashes = true;
                break;
            }
        }
    
        if ($hasClashes) {
            echo "Time clash! Faculty cannot be assigned.";
        } else {
            $assignSectionQuery = "UPDATE section SET FacultyID = '$facultyID' WHERE SectionID = '$sectionID'";
            $a = mysqli_query($conn, $assignSectionQuery);
            if ($a) {
                echo $sectionID . " has been updated.";
            }
        }
    }
    
    
    
    
    
    ?>
</form>
</body>

</html>