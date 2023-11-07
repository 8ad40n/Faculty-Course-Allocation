<?php 
include("dbConnect.php");
include("AdminDashboard.php");

if(isset($_GET['del']))
{
    $FacultyID= $_GET['del'];
    $sql1="Delete from faculty where FacultyID='$FacultyID'";
    mysqli_query($conn,$sql1);

    $sql2="Delete from userinfo where ID='$FacultyID'";
    mysqli_query($conn,$sql2);

    $sql3="Delete from prioritytime where FacultyID='$FacultyID'";
    mysqli_query($conn,$sql3);

    $sql4="Delete from prioritycourses where FacultyID='$FacultyID'";
    mysqli_query($conn,$sql4);
}


$sql="SELECT *
    FROM faculty
    INNER JOIN userinfo ON faculty.FacultyID = userinfo.ID;";
$res= mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form method="get">
  <table border="1" >
    <tr>
      <th>Faculty ID</th>
      <th>Faculty Name</th>
      <th>Email</th>
    </tr>
    <?php while($r= mysqli_fetch_assoc($res)){ ?>
    <tr>
      <td><?php echo $r["FacultyID"] ; ?></td>
      <td><?php echo $r["FacultyName"] ; ?></td>
      <td><?php echo $r["Email"] ; ?></td>
      <td><button type="submit" name="edit" value="<?php echo $r["FacultyID"] ; ?>">Edit</button>   </td>
      <td><button type="submit" name="del" value="<?php echo $r["FacultyID"] ; ?>">Delete</button>   </td>
    </tr>
  <?php } ?>
  </table>

  <?php
include("dbConnect.php");

if (isset($_POST['edit'])) {
    $FacultyID = $_POST['edit'];
    $sql1 = "SELECT FacultyName, Email FROM faculty WHERE FacultyID = '$FacultyID'";
    $d = mysqli_query($conn, $sql1);
    $r = mysqli_fetch_assoc($d);
    $facultyName = $r["FacultyName"];
    $email = $r["Email"];

    echo "<form method='post'>";
    echo "<br><br><br>";
    echo "Faculty ID: <input type='text' name='facultyID' value='$FacultyID' readonly>";
    echo "Faculty Name: <input type='text' name='facultyName' value='$facultyName'>";
    echo "Email: <input type='email' name='email' value='$email'>";

    echo '<td><button type="submit" name="EditSubmit" value="' . $FacultyID . '">Submit</button></td>';

    echo "</form>";

} elseif (isset($_POST['EditSubmit'])) {
    $FacultyID = $_POST['EditSubmit'];
    $facultyName = $_POST['facultyName']; 
    $email = $_POST['email'];

    $Query = "UPDATE faculty SET FacultyName = '$facultyName', Email= '$email' WHERE FacultyID = '$FacultyID'";
    $a = mysqli_query($conn, $Query);
    if ($a) {
        echo $FacultyID . " has been Updated";
    } else {
       echo "Invalid";
    }
}
?>

</form>
</body>
</html>


