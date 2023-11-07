<?php
include("dbConnect.php");
include("AdminDashboard.php");
if (isset($_POST['btnAdd'])) {
    
    $sectionID = $_POST["SectionID"];
    $courseID = $_POST["CourseID"];
    $section = $_POST["Section"];
    $day1 = $_POST["Day1"];
    $startTime1 = $_POST["StartTime1"];
    $endTime1 = $_POST["EndTime1"];
    $day2 = $_POST["Day2"];
    $startTime2 = $_POST["StartTime2"];
    $endTime2 = $_POST["EndTime2"];


    if (empty($sectionID) || empty($courseID) || empty($section) || empty($day1) || empty($startTime1) || empty($endTime1))
    {
        echo "Please fill in all the fields.";
    }
    else
    {
        // Verify if the CourseID exists in the database
        $verifyQuery = "SELECT CourseID FROM course WHERE CourseID = '$courseID'";
        $verifyResult = mysqli_query($conn, $verifyQuery);

        $varifySection= "SELECT * FROM section WHERE CourseID = '$courseID' AND Sec='$section' AND SectionID='$sectionID'";
        $verifySectionResult = mysqli_query($conn, $varifySection);

        if (mysqli_num_rows($verifyResult) > 0 && mysqli_num_rows($verifySectionResult)==0) {

            $addSectionQuery = "INSERT INTO section (SectionID, CourseID, Sec, Day, startTime, endTime)
            VALUES ('$sectionID', '$courseID', '$section', '$day1', '$startTime1', '$endTime1');";
            $addSectionResult = mysqli_query($conn, $addSectionQuery);
        
            $addSectionQuery1 = "INSERT INTO section (SectionID, CourseID, Sec, Day, startTime, endTime)
            VALUES ('$sectionID', '$courseID', '$section', '$day2', '$startTime2', '$endTime2');";
            $addSectionResult1 = mysqli_query($conn, $addSectionQuery1);
    
            if($addSectionResult || $addSectionResult1)
            {
                echo "The section ".$section." for ".$courseID. " has been added sucessfully"; 
    
            }
        } else {
            echo "Invalid.";
        }
    }
    
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
    <fieldset>
        <legend><h1>Add Section:</h1></legend>

        <form action="" method="POST">
        
        Section ID:<br> <input type="text" name="SectionID"><br><br>
        Course ID: <br><input type="text" name="CourseID"><br><br>
        Section:<br> <input type="text" name="Section"><br><br>
        <hr>
        First Day:
        <select name="Day1">
            <option value="Sunday">Sunday</option>
            <option value="Monday">Monday</option>
            <option value="Tuesday">Tuesday</option>
            <option value="Wednesday">Wednesday</option>
            <option value="Thursday">Thursday</option>
        </select><br><br>
        Start Time:<br> <input type="text" name="StartTime1"><br><br>
        End Time: <br><input type="text" name="EndTime1"><br>
        <small>Time Format: (hh:mm:ss)</small><br><br>
        <hr>
        Second Day:
        <select name="Day2">
            <option value="Sunday">Sunday</option>
            <option value="Monday">Monday</option>
            <option value="Tuesday">Tuesday</option>
            <option value="Wednesday">Wednesday</option>
            <option value="Thursday">Thursday</option>
        </select><br><br>
        Start Time:<br> <input type="text" name="StartTime2"><br><br>
        End Time: <br><input type="text" name="EndTime2"><br>
        <small>Time Format: (hh:mm:ss)</small><br><br>
        <hr>

        <button name="btnAdd">Add</button>
    </form>
    </fieldset>
</body>
</html>
