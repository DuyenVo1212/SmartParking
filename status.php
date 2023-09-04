<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>View My Booking and Status </title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <?php
		include('inc/head.php');
		include('inc/connect.php');
	?>
    <script>
    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";

        if (tabName === 'Reserved') {
            document.getElementById('notReserved').style.display = 'none';
        } else if (tabName === 'InUse') {
            document.getElementById('notBooked').style.display = 'none';
        }
    }
    </script>

    <style>
    .tab {
        display: flex;
        margin-top: 30px;
        justify-content: center;
    }

    .tablinks {
        background-color: #f2f2f2;
        color: #2C3E50;
        border: none;
        outline: none;
        padding: 10px 20px;
        cursor: pointer;
        transition: background-color 0.3s;
        font-weight: bold;
        border-radius: 5px;

    }

    .tablinks.active {
        background-color: #2C3E50;
        color: #fff;
    }

    .tab-content {
        display: none;
        padding: 20px;
        border: 2px solid #ccc;
    }

    .tab-content.show {
        display: block;
    }
    </style>
</head>

<body>
    <section id="container">
        <?php
			include('inc/header.php');
		?>
        <section id="content">
            <div class="tab">
                <button class="tablinks active" onclick="openTab(event, 'Reserved')">Reserved</button>
                <button class="tablinks" onclick="openTab(event, 'InUse')">In Use</button>
            </div>
            <div id="Reserved" class="tab-content" style="display:block">
                <?php
					$phone = $_SESSION["phone"];
					$query = "select * from zones where phone = '$phone' and status ='RESERVED' 
					and (timebegin <= NOW() or timein <= NOW())";
					$result = $conn->query($query);
					if ($result->num_rows > 0) {
						echo '<table class="tb-mbk animated fadeIn">';
						echo '<thead>';
						echo '<tr>';
						echo '<th>ID</th>';
						echo '<th>Slot</th>';
						echo '<th>Status</th>';
						echo '<th>Time Begin</th>';
						echo '<th>Time End</th>';
						echo '<th>Action</th>';
						echo '</tr>';
						echo '</thead>';
						echo '<tbody>';
						while($row = $result->fetch_assoc()) {
							echo "<tr>";
							echo "<td>".$row["id"]."</td>";
							echo "<td>".$row["slot"]."</td>";
							echo "<td>".$row["status"]."</td>";
							echo "<td>".$row["timebegin"]."</td>";
							echo "<td>".$row["timeend"]."</td>";
							
                            echo "<td><a href='viewbook.php?id=".$row['id']."'";
						    echo " class='mbtn view'>View</a>"; 
						    echo "<a href='proc/unbook.php?id=".$row['id']."'";
						    echo " class='mbtn unbook'>Unbooking</a></td>";
							
							echo "</tr>";
						}
						echo "<tr><td colspan = '6'></td></tr>";
						echo "<tr><td colspan = '6'></td></tr>";
						echo "<tr><td colspan = '6'>Note: If the time for parking reservation on the website is 15 minutes and you arrive later than that, the system will automatically cancel your previous reservation. Please make sure to arrive on time. Another important note is that once you have parked, you must follow the general regulations and only park within the allowed time frame. If you exceed that time frame, we will not be responsible for handling your vehicle </td></tr>";
						echo '</tbody>';
						echo '</table>';
					} else {
						echo "<h1 style='width:100%;text-align:center;margin-top:30px;font-size:24px;'>You haven't reserved any zone yet!</h1>";
					}
				?>
            </div>
            <div id="InUse" class="tab-content" style="display:none">
                <?php
					$phone = $_SESSION["phone"];
					$query = "select * from zones where phone = '$phone' and status ='INUSE' and (timebegin <= NOW() or timein <= NOW())";
					$result = $conn->query($query);
					if ($result->num_rows ==0) {
						echo "<h1 style='width:100%;text-align:center;margin-top:30px;font-size:24px;'>You haven't booked yet!</h1>";
                    } else {
                        echo '<table class="tb-mbk animated fadeIn">';
						echo '<thead>';
						echo '<tr>';

						echo '<th>ID</th>';
						echo '<th>Slot</th>';
						echo '<th>Status</th>';
						echo '<th>Time Begin</th>';
						echo '<th>Time Out</th>';
						echo '<th>Time End</th>';
						echo '<th>Refund</th>';
						echo '<th>Action</th>';
						
						echo '</tr>';
						echo '</thead>';
						echo '<tbody>';

						while($row = $result->fetch_assoc()) {
							if(isset($row["timebegin"]) && isset($row["timeend"])) {
								$timebegin = strtotime($row["timebegin"]);
								$timeend = strtotime($row["timeend"]);
								$now = time();
								if($timebegin && $timeend && $timebegin < $timeend && $now < $timeend) {
									$time = $timeend - $now;
									if($time > 0) {
										$money = $time * 100;
										$refund = $money." VND";
									}
								}
							}
							echo "<tr>";
							echo "<td>".$row["id"]."</td>";
							echo "<td>".$row["slot"]."</td>";
							echo "<td>".$row["status"]."</td>";
							echo "<td>".$row["timebegin"]."</td>";
							echo "<td>".$row["timeout"]."</td>";
							echo "<td>".$row["timeend"]."</td>";
							echo "<td>".$refund."</td>";
                            echo "<td><a href='viewbook.php?id=".$row['id']."'";
						    echo " class='mbtn view'>View</a>"; 
			

                echo "</tr>";
                }
                echo '</tbody>';
                echo '</table>';
                }
                ?>
            </div>
        </section>
        <?php
	include('inc/footer.php');
?>
    </section>
</body>

</html>