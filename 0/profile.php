<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>My Profile</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <?php
			include('../inc/adminhead.php');
	?>
</head>

<body>
    <section id="container">
        <?php
			include('../inc/adminheader.php');
			include('../inc/connect.php');
						
	?>
        <section id="content">
            <div class="profile">
                <div class="avatar">
                    <span>Change Avatar</span>
                    <input type="file" accept="image/*" style="display:none" onchange="previewImage(event)">
                </div>
                <?php
			
			$password=$_SESSION['password'];
			$phone=$_SESSION['phone'];
			$query = "select * from users where password='$password' AND phone='$phone'";
			$result = $conn->query($query);
			while($rows = $result->fetch_assoc()) {
			
		?>
                <div class="dt name">NAME: <span><?php  echo $rows['name'];  ?></span></div>
                <div class="dt phone">PHONE: <span><?php  echo $rows['phone'];  ?></span></div>

                <?php  } ?>
            </div>
        </section>

    </section>
</body>

</html>