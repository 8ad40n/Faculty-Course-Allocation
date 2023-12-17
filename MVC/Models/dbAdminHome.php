<?php
include('dbConnect.php');

function Home($id)
{
	$conn = getConnection();
	$sql = "select * from admin where AdminID='$id'";
	$result = mysqli_query($conn, $sql);

	return $result;
}
?>
