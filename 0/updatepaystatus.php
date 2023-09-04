<?php
include('../inc/connect.php');


if (isset($_POST['updatepays'])){

$id=$_POST['id'];
mysqli_query($connect,"UPDATE zones SET pays='paid' WHERE id='$id'");
header("location: bookings.php");

}
?>