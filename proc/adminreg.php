<?php
	include('../inc/connect.php');
	if (isset($_POST['Submit'])) {
		$phone=$_POST['phone'];
		$fname=$_POST['fname'];
		$lname=$_POST['lname'];
		$password=$_POST['password'];
		$name = $fname ." ". $lname;
		$sql = "insert into users (email,phone,name,password,access) values (' ','$phone','$name','$password',1)";
		if (mysqli_query($conn, $sql)) {
			echo "New admin created successfully";
		  } else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		  }
		  
		header("Location: ../index.php");
	}
?>