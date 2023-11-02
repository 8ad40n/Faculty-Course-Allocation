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
}
else if(isset($_GET['edit']))
{
  echo $_GET['edit'];
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
</form>
</body>
</html>