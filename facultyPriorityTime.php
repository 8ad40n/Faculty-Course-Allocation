<?php
include("dbConnect.php");
include("FacultyDashboard.php");

session_start();
$id = $_SESSION['id'];

if (isset($_GET["add"])) {
    $day = $_GET["day"];
    $start = $_GET["start"];
    $end = $_GET["end"];

    if (empty($start) || empty($end)) {
        echo "Please fill in all the fields.";
    } else {
        $sql = "SELECT Day FROM prioritytime WHERE FacultyID='$id'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) == 0) {
            $addSectionQuery = "INSERT INTO prioritytime (FacultyID, Day, startTime, endTime) VALUES ('$id', '$day', '$start', '$end')";
            $addSectionResult = mysqli_query($conn, $addSectionQuery);
            
            if ($addSectionResult) {
                echo "Priority Time has been added!";
            } else {
                echo "Invalid!";
            }
        } else {
            echo "You already have a priority time set on this day.";
        }
    }
}

$sql3="SELECT * FROM prioritytime WHERE FacultyID='$id";
$r= mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Priority Time</title>
</head>
<body>
    <form method="get">
        <fieldset>
            <legend><h1>Set Priority Time</h1></legend>
            Day:<br>
            <select name="day">
                <option value="Sunday">Sunday</option>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
            </select><br><br>
            Start Time: <br><input type="text" name="start"><br><br>
            End Time: <br><input type="text" name="end"><br>
            <small>Time Format = hh:mm:ss</small><br><br>
            <button type="submit" name="add">Add</button>
        </fieldset>


    <table border="1" >
    <tr>
      <th>Day</th>
      <th>Start Time</th>
      <th>End Time</th>
    </tr>
    <?php while($r= mysqli_fetch_assoc($res)){ ?>
    <tr>
      <td><?php echo $r["Day"] ; ?></td>
      <td><?php echo $r["startTime"] ; ?></td>
      <td><?php echo $r["endTime"] ; ?></td>
      <td><button type="submit" name="del" value="<?php echo $r["FacultyID"] ; ?>">Delete</button>   </td>
    </tr>
  <?php } ?>
  </table>

    </form>
</body>
</html>
