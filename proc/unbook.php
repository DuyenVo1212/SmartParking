 <?php 
 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
	$id = $_GET['id'];
	$connection = mysqli_connect("localhost", "root", "", "cpms");
	$phone=$_SESSION['phone'];
	$query = mysqli_query($connection, "select * from users where  phone='$phone' and id = '$id'");
	$rows = mysqli_num_rows($query);
	//echo $rows;
	$row=mysqli_fetch_array($query);
	//if ($rows == 1) {
	
	$sql = "DELETE FROM zones WHERE id = '$id' AND phone = '$phone'";
	mysqli_query($connection, $sql);
	 header("Location: ../mybookings.php");
	//}
		
}