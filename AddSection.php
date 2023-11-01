<?php
include("dbConnect.php");

if (isset($_POST['btnAdd']))
{
    $sectionID = $_POST["SectionID"];
    $courseID = $_POST["CourseID"];
    $section = $_POST["Section"];
    $day1 = $_POST["Day1"];
    $startTime1 = $_POST["StartTime1"];
    $endTime1 = $_POST["EndTime1"];
    $day2 = $_POST["Day2"];
    $startTime2 = $_POST["StartTime2"];
    $endTime2 = $_POST["EndTime2"];

    $varifyQuery= "SELECT CourseID from course WHERE CourseID= '$courseID'";
    $varifyResult= mysqli_query($conn, $varifyQuery);

    if(mysqli_num_rows($varifyResult) > 0)
    {
        echo "YES";
    }
    else{
        echo "NO";
    }

    // $addSectionQuery = "INSERT INTO section (SectionID, CourseID, Sec, Day, startTime, endTime)
    // VALUES ('$sectionID','$courseID','$section','$day1','$startTime1','$endTime1');";
    // $addSectionResult= mysqli_query($conn, $addSectionQuery);

    // $addSectionQuery1 = "INSERT INTO section (SectionID, CourseID, Sec, Day, startTime, endTime)
    // VALUES ('$sectionID','$courseID','$section','$day2','$startTime2','$endTime2');";
    // $addSectionResult1= mysqli_query($conn, $addSectionQuery1);

}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="post">

    <h1>Add Section:</h1>
    Section ID: <input type="text" name="SectionID"><br><br>
    Course ID: <input type="text" name="CourseID"><br><br>
    Section: <input type="text" name="Section"><br><br>
    <hr>
    First Day:
    <select name="Day1">
    <option value="sunday">Sunday</option>
    <option value="monday">Monday</option>
    <option value="tuesday">Tuesday</option>
    <option value="wednesday">Wednesday</option>
    <option value="thursday">Thursday</option>
    </select><br><br>
    Start Time: <input type="text" name="StartTime1"><br><br>
    End Time: <input type="text" name="EndTime1"><br>
    <small>Time Format:(hh:mm:ss)</small><br><br>
    <hr>
    Second Day:
    <select name="Day2">
    <option value="sunday">Sunday</option>
    <option value="monday">Monday</option>
    <option value="tuesday">Tuesday</option>
    <option value="wednesday">Wednesday</option>
    <option value="thursday">Thursday</option>
    </select><br><br>
    Start Time: <input type="text" name="StartTime2"><br><br>
    End Time: <input type="text" name="EndTime2"><br>
    <small>Time Format:(hh:mm:ss)</small><br><br>
    <hr>

    <button name="btnAdd">Add</button>

    </form>


</body>
</html>