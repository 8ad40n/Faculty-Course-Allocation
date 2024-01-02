<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="CSS/AdminDashboard.css"> -->
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>
    <script src="bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">


</head>


<body>
    <a href="AdminHome.php"><img src="Images/banner.png" id="aiubBanner" alt="Header Image"></a>
    <div class="main">

        <div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:none" id="mySidebar">
            <button id="navButton" class="w3-bar-item w3-button w3-large" onclick="w3_close()">Close &times;</button>
            <a href="AdminHome.php" class="w3-bar-item w3-button">Home</a>
            <a href="Admin.php" class="w3-bar-item w3-button">Allocate Courses</a>
            <a href="tsf_Admin.php" class="w3-bar-item w3-button">Faculty TSF</a>
            <a href="addCourse.php" class="w3-bar-item w3-button">Add Course</a>
            <a href="AddSection.php" class="w3-bar-item w3-button">Add Section</a>
            <a href="excelSection.php" class="w3-bar-item w3-button">Import Section</a>
            <a href="editSection.php" class="w3-bar-item w3-button">Edit Section</a>
            <a href="AddFaculty.php" class="w3-bar-item w3-button">Add Faculty</a>
            <a href="EditFacultyInfo.php" class="w3-bar-item w3-button">Edit Faculty Information</a>
            <a href="AddPriorityCourse.php" class="w3-bar-item w3-button">Add Priority Courses</a>
            <a href="facultyPriorityTime.php" class="w3-bar-item w3-button">Set Priority Time</a>
        </div>

        <div class="w3-teal">
            <button id="openNav" class="w3-button w3-teal w3-xlarge" onclick="w3_open()">&#9776;</button>
        </div>
        <script>
            function w3_open() {
                document.getElementById("mySidebar").style.width = "25%";
                document.getElementById("mySidebar").style.display = "block";
                document.getElementById("openNav").style.display = 'none';
            }

            function w3_close() {
                document.getElementById("mySidebar").style.display = "none";
                document.getElementById("openNav").style.display = "inline-block";
            }
        </script>

    </div>

</body>

</html>