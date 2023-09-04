<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>View Your Booking</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <?php
			include('inc/head.php');
			include('inc/connect.php');
	?>
</head>

<body>
    <section id="container">
        <?php
			include('inc/header.php');
						
	?>

        <section id="content">
            <p class="phead">View your booking</p>
            <?php
			$id = $_GET['id'];
			$phone = $_SESSION["phone"];
			$query = "select * from zones where id= '$id' AND phone = '$phone' and (status ='RESERVED' OR status ='INUSE')";
			$result = $conn->query($query);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					echo "<table class='viewtb'><tr><td>Phone:</td><td>";
					echo $row["phone"];
					echo "</td><tr><td>Slot:</td><td>";
					echo $row["slot"];
					echo "</td></tr><tr><td>Plate:</td><td>";
					echo $row["plateno"];
					echo "</td></tr><tr><td>Status:</td><td>";
					echo $row["status"];
					echo "</td></tr><tr><td>From:</td><td>";
					echo $row["timebegin"];
					echo "</td></tr><tr><td>To:</td><td>";
					echo $row["timeend"];
					echo "</td></tr><tr><td>Payment Number:</td><td>";
					echo $row["paynum"];
					echo "</td></tr><tr><td>Paid:</td><td>";
					$time_begin = strtotime($row["timebegin"]);
					$time_end = strtotime($row["timeend"]);
					$hours = $time_end - $time_begin;
					$cost = $hours * 100;
        			$formatted_cost = number_format($cost, 0, ',', ',');
					echo $formatted_cost . " VND";
					echo "</td></tr>";
					$time_end = strtotime($row["timeend"]);
					$now = time();
					$time = $time_end - $now;
					if($time > 0) {
						$money = $time * 100;
						$formatted_cost = number_format($money, 0, ',', ',');
						$refund = $formatted_cost." VND";
					}
					echo "</td></tr><tr><td>Refund:</td><td>";
					echo $refund;
					echo "</td></tr>";
				}
				echo "</table> </section>";
				include('inc/footer.php');

			}
			?>

        </section>

</body>

</html>