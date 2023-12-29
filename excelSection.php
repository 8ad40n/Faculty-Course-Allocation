<?php
include ("AdminDashboard.php");
use SimpleExcel\SimpleExcel;
if(isset($_POST['import']))
{
    if(move_uploaded_file($_FILES['excel_file']['tmp_name'],$_FILES['excel_file']['name']))
    {
        require_once('SimpleExcel/SimpleExcel.php'); 
        $excel = new SimpleExcel('csv');                    

        $excel->parser->loadFile($_FILES['excel_file']['name']);            

        $foo = $excel->parser->getField();                 
        $bar = $excel->parser->getRow(3);                   
        $baz = $excel->parser->getColumn(4);   
        $qux = $excel->parser->getCell(2,1);                

        // echo '<pre>';
        // print_r($foo);                                      
        // echo '</pre>';
        
        $count= 1;
        while(count($foo)> $count)
        {
            $SectionID= $foo[$count][0];
            $CourseID= $foo[$count][1];
            $Sec= $foo[$count][2];
            $Day= $foo[$count][3];
            $startTime= $foo[$count][4];
            $endTime= $foo[$count][5];

            include ("dbConnect.php");
            $query= "insert into section (SectionID, CourseID, Sec, Day, startTime, endTime)";
            $query.="values ('$SectionID', '$CourseID', '$Sec', '$Day', '$startTime', '$endTime')";

            if(mysqli_query($conn, $query))
            {
                $count++;
                echo "<script>alert('Insertion Successful!')</script>";
            }
            else
            {
                echo "<script>alert('Insertion Failed! Please Try Again.')</script>";
            }
            


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
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="excel_file" accept=".csv">
        <input type="submit" name="import" value="Import">
    </form>
</body>
</html>

