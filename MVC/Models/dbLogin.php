<?php
include('dbConnect.php');

function validateUser($id, $pass)
{
	$conn = getConnection();
	$sql = "SELECT * FROM userinfo WHERE ID='$id' AND Password='$pass'";
	$result = mysqli_query($conn, $sql);

	return $result;
}
?>
