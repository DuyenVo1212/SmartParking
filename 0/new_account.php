<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Create Account</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<?php
			include('../inc/adminhead.php');
	?>
</head>
<body>
	<section id="container">
	<?php
			include('../inc/adminheader.php');
	?>
	
	<section id="content">
		<!-- <div class="left-signup">
		</div> -->
		<div class="left-signup">
		<p class="head">New Admin Registration</p>
		<form id="registration" action="../proc/adminreg.php" method="post">
		<input type="text" name="fname" value="" placeholder="First Name"/>
		<input type="text" name="lname" value="" placeholder="Last Name"/>
		<input type="text" name="phone" value="" placeholder="Phone Number"/>
		<input type="password" name="password"value="" placeholder="Password"/>
		<input type="Submit" name="Submit" value="Create Account"/>
				
		</form>
		</div>
	</section>
	</section>
</body>
</html>