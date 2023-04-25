<?php
include('inc/head.php');
include('inc/connect.php');

$slot = isset($_POST['slot']) ? $_POST['slot'] : 'ALL'; // Default to A1

$status = isset($_POST['status']) ? $_POST['status'] : ''; // Default to all statuses
$sort_by = isset($_POST['sort_by']) ? $_POST['sort_by'] : 'timebegin_desc'; // Default to sorting by time begin (latest first)

// Build the SQL query based on the selected sorting option
switch ($sort_by) {
  case 'timebegin_asc':
    $sort_column = 'timebegin';
    $sort_direction = 'ASC';
    break;
  case 'timeend_desc':
    $sort_column = 'timeend';
    $sort_direction = 'DESC';
    break;
  case 'timeend_asc':
    $sort_column = 'timeend';
    $sort_direction = 'ASC';
    break;
  default: // timebegin_desc
    $sort_column = 'timebegin';
    $sort_direction = 'DESC';
    break;
}

if ($slot == 'ALL') {
    $sort_sql = ($sort_by == 'timebegin_asc') ? 'timebegin ASC' : 'timebegin DESC';
    if ($status != '') {
        $query = mysqli_query($conn, "SELECT * FROM zones WHERE status='$status' ORDER BY $sort_sql") or die(mysqli_error($conn));
    } else {
        $query = mysqli_query($conn, "SELECT * FROM zones ORDER BY $sort_sql") or die(mysqli_error($conn));
    }
} else {
    if ($status != '') {
        $query = mysqli_query($conn, "SELECT * FROM zones WHERE slot='$slot' AND status='$status' ORDER BY $sort_column $sort_direction") or die(mysqli_error($conn));
    } else {
        $query = mysqli_query($conn, "SELECT * FROM zones WHERE slot='$slot' ORDER BY $sort_column $sort_direction") or die(mysqli_error($conn));
    }
}

?>

<body>
    <section id="container">
        <?php
            include('inc/header.php');
        ?>
        <section id="content">
            <div class="parking-status-container">
                <p class="phead">View details parking lot status</p>
                <div>
                    <form method="post" action="">
                        <label for="slot">Select Slot:</label>
                        <select id="slot" name="slot" onchange="this.form.submit()">
                            <option value="ALL" <?php if ($slot == 'ALL') echo 'selected'; ?>>ALL</option>
                            <option value="A1" <?php if ($slot == 'A1') echo 'selected'; ?>>A1</option>
                            <option value="A2" <?php if ($slot == 'A2') echo 'selected'; ?>>A2</option>
                            <option value="A3" <?php if ($slot == 'A3') echo 'selected'; ?>>A3</option>
                        </select>
                        <label for="sort_by">Sort By:</label>
                        <select id="sort_by" name="sort_by" onchange="this.form.submit()">
                            <option value="timebegin_desc" <?php if ($sort_by == 'timebegin_desc') echo 'selected'; ?>>
                                Time Begin (Latest First)</option>
                            <option value="timebegin_asc" <?php if ($sort_by == 'timebegin_asc') echo 'selected'; ?>>
                                Time Begin (Earliest First)</option>
                            <option value="timeend_desc" <?php if ($sort_by == 'timeend_desc') echo 'selected'; ?>>Time
                                End (Latest First)</option>
                            <option value="timeend_asc" <?php if ($sort_by == 'timeend_asc') echo 'selected'; ?>>Time
                                End (Earliest First)</option>
                        </select>

                    </form>
                    <form method="post" action="">
                        <label for="status">Filter by Status:</label>
                        <button type="submit" name="status" value="reserved"
                            style="background-color: green; ">Reserved</button>
                        <button type="submit" name="status" value="inuse" style="background-color: red;">In Use</button>
                    </form>


                    <?php if(mysqli_num_rows($query) == 0) { ?>
                    <div style="color:red;text-align:center;font-weight:bold;margin-top:10px;">No bookings found for
                        this slot.</div>
                    <?php } else { ?>

                    <table cellspacing="0" class="table table-striped table-bordered" id="example">
                        <thead>
                            <tr>
                                <th>Slot</th>
                                <th>Time Begin</th>
                                <th>Time End</th>
                                <th>Car Plate No</th>
                                <!-- <th>Phone</th> -->
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row=mysqli_fetch_array($query)){ ?>
                            <tr>
                                <td><?php echo $row['slot'] ?></td>
                                <td><?php echo $row['timebegin'] ?></td>
                                <td><?php echo $row['timeend'] ?></td>
                                <td><?php echo $row['plateno'] ?></td>
                                <!-- <td><?php echo $row['phone'] ?></td> -->
                                <td><?php echo $row['status'] ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php } ?>
                </div>

                <div class="links" style="width: 100%; overflow: hidden;">
                    <a href="zones.php" style="float: left;">Back</a>
                    <a href="booking.php" style="float: right;">Go to Booking Slot</a>

                </div>
            </div>
        </section>
        <?php
			include('inc/footer.php');
	?>
    </section>

</body>