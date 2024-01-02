<?php
include("AdminDashboard.php");

use SimpleExcel\SimpleExcel;

if (isset($_POST['import'])) {
    if (move_uploaded_file($_FILES['excel_file']['tmp_name'], $_FILES['excel_file']['name'])) {
        require_once('SimpleExcel/SimpleExcel.php');
        $excel = new SimpleExcel('csv');

        $excel->parser->loadFile($_FILES['excel_file']['name']);

        $foo = $excel->parser->getField();
        $bar = $excel->parser->getRow(3);
        $baz = $excel->parser->getColumn(4);
        $qux = $excel->parser->getCell(2, 1);

        // echo '<pre>';
        // print_r($foo);                                      
        // echo '</pre>';

        $count = 1;
        $insertionFailed = false;
        while (count($foo) > $count) {
            $SectionID = $foo[$count][0];
            $CourseID = $foo[$count][1];
            $Sec = $foo[$count][2];
            $Day = $foo[$count][3];
            $startTime = $foo[$count][4];
            $endTime = $foo[$count][5];

            include("dbConnect.php");
            $query = "insert into section (SectionID, CourseID, Sec, Day, startTime, endTime)";
            $query .= "values ('$SectionID', '$CourseID', '$Sec', '$Day', '$startTime', '$endTime')";

            if (mysqli_query($conn, $query)) {
                $count++;
                // echo "<script>alert('Insertion Successful!')</script>";
            } else {
                $insertionFailed = true;
                echo "<script>alert('Insertion Failed! Please Try Again.')</script>";
            }
        }
        if (!$insertionFailed) {
            echo "<script>alert('Insertion Successful!')</script>";
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
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>
    <script src="bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>
    <div class="main">
        <div class="container">
            <h2>Add sections by importing .csv file:</h2><br>
            <form method="post" enctype="multipart/form-data">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupFile01">Upload</label>
                    <input type="file" class="form-control" id="inputGroupFile01" name="excel_file" accept=".csv">
                    <br>
                    <!-- <input type="submit" name="import" value="Import"> -->
                    <button name="import" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>