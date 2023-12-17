

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="CSS/AdminHome.css">

</head>

<body>
    <?php
    include("AdminDashboard.php");
    ?>
    <div class="main">

        <form method="post" action="../Controllers/AdminHomeController.php">

            <label for="Welcome">
                <h1>Welcome!</h1>
            </label>

            <?php
            include ("../Controllers/AdminHomeController.php");
            AdminHome();
            ?>

            <br>
            <button name="logout">Logout</button>
        </form>
    </div>
</body>

</html>
