<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Manage Parking Bookings</title>
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
            <div>
                <p class="phead">View and Manage Parking Reservations</p>
                <div style="width:660px;background:white;padding:10px;margin:auto;">

                    <!-- <form method="post" action="deletebooking.php"> -->
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered"
                        id="example">

                        <thead>

                            <tr>
                                <th></th>
                                <th>Slot</th>
                                <th style="width:90px;">Plate No</th>
                                <th style="width:90px;">Time Begin</th>
                                <th style="width:90px;">Time End</th>
                                <th style="width:90px;">Time In</th>
                                <th style="width:80px;">Status</th>
                                <th style="width:80px;">Payment Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php 
							$query=mysqli_query($connect, "select * from zones")or die(mysqli_error($connect));
							while($row=mysqli_fetch_array($query)){
							$id=$row['id'];
                            $pays=$row['pays'];
							?>

                            <tr>
                                <td>
                                    <input name="selector[]" type="checkbox" value="<?php echo $id; ?>">
                                </td>
                                <td><?php echo $row['slot'] ?></td>
                                <td><?php echo $row['plateno'] ?></td>
                                <td><?php echo $row['timebegin'] ?></td>
                                <td><?php echo $row['timeend'] ?></td>
                                <td><?php echo $row['timein'] ?></td>
                                <td><?php echo $row['status'] ?></td>
                                <td>
                                    <?php
                                        if($pays == NULL) {
                                            // function updatepaystatus() {
                                            //     global $id, $connect;
                                            //     $sql = "UPDATE zones SET pays='paid' WHERE id=$id";
                                            //     $query=mysqli_query($connect,$sql)or die(mysqli_error($connect));
                                            //     while($row=mysqli_fetch_array($query)){
                                            //         echo "<script>alert('update successfully')</script>";
                                            //     }
                                            // }
                                            echo "<form method='post' action='updatepaystatus.php'>
                                            <input type='hidden' name='id' value='$id' >
                                            <input type='submit' class='btn btn-danger' value='updatepays' name='updatepays'>
                                            </form>";
                                        }else {
                                            echo "paid";
                                        }
                                    ?>
                                </td>
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