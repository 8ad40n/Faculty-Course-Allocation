<!DOCTYPE html>
<html>

<head>
    <title>Edit Faculty</title>
    <style>
    .imgFaculty {
        height: 80px;
        width: 80px;
    }
    </style>
    <!-- <link rel="stylesheet" href="CSS/AdminDashboard.css"> -->
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>
    <script src="bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>

    <?php 
    include("dbConnect.php");
    include("AdminDashboard.php");
    echo '<div class="main"><div class="container">';

    echo "<center><h1>Faculty Info:</h1></center>";

    if (isset($_GET['del'])) {
        $FacultyID = $_GET['del'];
        $sql1 = "DELETE FROM faculty WHERE FacultyID='$FacultyID'";
        mysqli_query($conn, $sql1);

        $sql2 = "DELETE FROM userinfo WHERE ID='$FacultyID'";
        mysqli_query($conn, $sql2);

        $sql3 = "DELETE FROM prioritytime WHERE FacultyID='$FacultyID'";
        mysqli_query($conn, $sql3);

        $sql4 = "DELETE FROM prioritycourses WHERE FacultyID='$FacultyID'";
        mysqli_query($conn, $sql4);

        echo "<script>alert('Faculty: $FacultyID has been deleted successfully');</script>";

    }

    if (isset($_POST['edit'])) {
        $FacultyID = $_POST['edit'];
        $sql1 = "SELECT FacultyName, Email FROM faculty WHERE FacultyID = '$FacultyID'";
        $d = mysqli_query($conn, $sql1);
        $r = mysqli_fetch_assoc($d);
        $facultyName = $r["FacultyName"];
        $email = $r["Email"];

        echo "<form method='post' enctype='multipart/form-data'>";
        echo "<br><br><br>";
        echo "Faculty ID: <br><input type='text' class='form-control' name='facultyID' value='$FacultyID' readonly><br>";
        echo "Faculty Name:<br> <input type='text' class='form-control' name='facultyName' value='$facultyName'><br>";
        echo "Email:<br> <input type='email' class='form-control' name='email' value='$email'><br>";
        echo "<label for='picture'>Upload Your Picture:</label><br>";
        echo "<input type='file' class='form-control' name='pic' accept='image/*'><br> ";
        echo '<button type="submit" class="btn btn-primary" name="EditSubmit" value="' . $FacultyID . '">Submit</button><br>';
        

        echo "</form>";
    } elseif (isset($_POST['EditSubmit'])) {
        $FacultyID = $_POST['EditSubmit'];
        $facultyName = $_POST['facultyName']; 
        $email = $_POST['email'];


        $file_name = $_FILES["pic"]["name"];
        $tempname = $_FILES["pic"]["tmp_name"];
        $folder = 'Images/'.$file_name;

        $Query = "UPDATE faculty SET FacultyName = '$facultyName', Email = '$email', Picture = '$file_name' WHERE FacultyID = '$FacultyID'";
        $a = mysqli_query($conn, $Query);
        if ($a) {
            echo "<script>alert('$FacultyID has been Updated');</script>";

        } else {
            echo "<script>alert('Invalid');</script>";

        }
    }
    ?>
    <br><br>
    <table class="table table-bordered">
        <tr>
            <th>Faculty ID</th>
            <th>Faculty Name</th>
            <th>Email</th>
            <th>Image</th>
            <th colspan="2"><center>Action</center></th>
        </tr>
        <?php
        $sql = "SELECT * FROM faculty;";
        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) > 0) {
            while ($r = mysqli_fetch_assoc($res)) {
                echo "<tr>";
                echo "<td>" . $r["FacultyID"] . "</td>";
                echo "<td>" . $r["FacultyName"] . "</td>";
                echo "<td>" . $r["Email"] . "</td>";
                ?>
        <td><img class="imgFaculty" src="Images/<?php echo $r["Picture"] ?>"><br></td>
        <?php
                echo '<td>
                        <form method="post">
                            <center><button type="submit" class="btn btn-success" name="edit" value="' . $r["FacultyID"] . '">Edit</button></center>
                        </form>
                     </td>';
                echo '<td>
                        <form method="get">
                            <center><button type="submit" class="btn btn-danger" name="del" value="' . $r["FacultyID"] . '">Delete</button></center>
                        </form>
                     </td>';
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No faculty members found.</td></tr>";
        }
        ?>
    </table>
    </div></div>
</body>

</html>