<?php
	include('../inc/connect.php');
	if (isset($_POST['Submit'])) {
		$phone=$_POST['phone'];
		$fname=$_POST['fname'];
		$lname=$_POST['lname'];
		$password=$_POST['password'];
		$plate=$_POST['plate'];
		$email=$_POST['email'];
		$name = $fname ." ". $lname;
		echo $phone." ".$fname." ".$lname." ".$plate." ".$email."<br> ";
		$sql = "insert into users (email,phone,name,password) values ('$email','$phone','$name','$password')";
		if (mysqli_query($conn, $sql)) {
			echo "New user created successfully";
		  } else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		  }
		  
		header("Location: ../index.php");
	}
?>