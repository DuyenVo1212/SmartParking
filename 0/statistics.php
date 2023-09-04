<?php
	include('../inc/connect.php');
	include('../inc/adminhead.php');
	
	$current_year = date('Y');

	$month = isset($_POST['month']) ? $_POST['month'] : date('m');
	$year = isset($_POST['year']) ? $_POST['year'] : $current_year;

	// Kiểm tra năm nhập vào có phải là số và không được nhỏ hơn năm hiện tại
	if (!is_numeric($year) || $year < $current_year) {
		$year = $current_year;
	}
	$txtsearch = $year .'-'. $month . '%';
	$query = "SELECT * FROM `reserved-list` WHERE timein LIKE '{$txtsearch}%'";
	$result = mysqli_query($connect, $query);
	$total = mysqli_affected_rows($connect);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Parking Management Statistics</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>

<body>
    <section id="container">
        <?php
			include('../inc/adminheader.php');						
	?>

        <section id="content">
            <div>
                <p class="phead">Statistics</p>
                <div style="width:660px;background:white;padding:10px;margin:auto;">
                    <form method="post" action="">
                        <input type="text" name="year" require placeholder="<?php echo date("Y"); ?>"
                            value="<?php echo $year ?>" style="width: 50px; height: 30px;">
                        <select name="month" style="width: 110px;">
                            <option value="01" <?php if ($month == '01') echo 'selected' ?>>January</option>
                            <option value="02" <?php if ($month == '02') echo 'selected' ?>>February</option>
                            <option value="03" <?php if ($month == '03') echo 'selected' ?>>March</option>
                            <option value="04" <?php if ($month == '04') echo 'selected' ?>>April</option>
                            <option value="05" <?php if ($month == '05') echo 'selected' ?>>May</option>
                            <option value="06" <?php if ($month == '06') echo 'selected' ?>>June</option>
                            <option value="07" <?php if ($month == '07') echo 'selected' ?>>July</option>
                            <option value="08" <?php if ($month == '08') echo 'selected' ?>>August</option>
                            <option value="09" <?php if ($month == '09') echo 'selected' ?>>September</option>
                            <option value="10" <?php if ($month == '10') echo 'selected' ?>>October</option>
                            <option value="11" <?php if ($month == '11') echo 'selected' ?>>November</option>
                            <option value="12" <?php if ($month == '12') echo 'selected' ?>>December</option>
                        </select>
                        <input class="btn btn-info" type="submit" value="Search" style="margin-top: -11px;">
                        <span class="btn btn-success"
                            style="padding: 3.8px 5px;border:1px solid black;margin-top: -11px;"><?php echo " $month";echo "/"; echo "$year ";?></span>
                    </form>
                    <hr>
                    <h5 style="width:640px; margin: auto;">Statistics of the number of reservations by
                        <?php echo " $month";echo "/"; echo "$year ";?> is :<?php echo " $total "; ?> bookings/month.
                    </h5>
                    <hr>
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered"
                        id="example">
                        <thead>
                            <tr>
                                <th style="width:120px;">Time In</th>
                                <th style="width:120px;">Time Out</th>
                                <th style="width:90px;">Slot</th>
                                <th style="width:90px;">Plate</th>
                                <th style="width:90px;">Phone</th>
                                <th style="width:90px;">Charge</th>
                                <th>Reserved</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
								while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
								$id=$row['id'];
							?>
                            <tr>
                                <td><?php echo $row['timein'] ?></td>
                                <td><?php echo $row['timeout'] ?></td>
                                <td><?php echo $row['slot'] ?></td>
                                <td><?php echo $row['plate'] ?></td>
                                <td><?php echo $row['phone'] ?></td>
                                <td><?php echo $row['charge'] ?></td>
                                <td><?php echo $row['reserved'] ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </section>
</body>

</html>