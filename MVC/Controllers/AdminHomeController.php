<?php
session_start();
include('../Models/dbAdminHome.php');


function AdminHome()
{
    $id = $_SESSION['id'];
    $result = Home($id);

    if ($result) {
    
        $data = mysqli_fetch_assoc($result);
        $name = $data['AdminName'];
        $email = $data['Email'];
    
        $image = $data['Picture'];
    
    }
    
    
    echo "<fieldset>";
    ?>
    <div class="content">
        <img src="Images/<?php echo $image ?>"><br>
    </div>
    
    <?php
    echo "
        <label><b>Name:</b>$name<br></label>
        <label><b>ID:</b>$id<br></label>
        <label> <b>Email:</b>$email<br></label>
        <label><b>Role:</b>Admin<br></label>";
    
}


if (!isset($_SESSION['id'])) {
    header('location: ../Views/login.php');
} else {
    if (isset($_POST['logout'])) {
        session_destroy();
        header('location: ../Views/login.php');
    }
}
?>