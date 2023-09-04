<!DOCTYPE html>
<html>

<head>
    <title>Find Available Parking Slots</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <?php
        include('inc/head.php');
        include('inc/connect.php');
        include('autounbook.php');
    ?>
    <style>
    .slotstat:hover::before {
        content: attr(data-timebegin) " - "attr(data-timeend);
        display: block;
        position: absolute;
        top: -30px;
        background-color: #2c3e50;
        color: #f16529;
        font-size: 18px;
        padding: 5px;
        border-radius: 5px;
        width: 100px;
        height: 50px;
    }
    </style>
</head>
<script>
function selectSlot(event) {
    // Prevent the default behavior of the anchor tag
    event.preventDefault();

    // Redirect the user to the correct URL for the selected parking slot
    window.location.href = event.target.href;
}
</script>
<?php 
    function getSlotDetailsUrl($slot) {
        // Replace this with the actual URL of the page that displays the detailed information for the parking slot
        return "detailslot.php";
    }
?>

<body>
    <section id="container">
        <?php
            include('inc/header.php');
                        
        ?>

        <section id="content">
            <img style="position:absolute; z-index:-1; margin:0;" />
            <p class="phead">VIEW PARKING LOT STATUS HERE!</p>

            <div class="strt zone">
                <p><a href="detailslot.php">*Click to view details </a> </p>
                <table class="gridtable" style="border-spacing: 100px 10px;width:100%;">
                    <tr>
                        <td
                            style="width: 33.34%; text-align: center;border: 5px solid #2c3e50;border-bottom-right-radius: 25px;">
                            A1</td>
                        <td
                            style="width: 33.33%; text-align: center;border: 5px solid #2c3e50;border-bottom-right-radius: 25px;">
                            A2</td>
                        <td
                            style="width: 33.33%; text-align: center;border: 5px solid #2c3e50;border-bottom-right-radius: 25px;">
                            A3</td>
                    </tr>
                    <tr style="background-color: rgb(233, 233, 42);">
                        <?php 
                            // $current_time = date('Y-m-d H:i:s');
                            $sql = "SELECT * FROM zones WHERE slot='A1' and (timebegin <= NOW() or timein <= NOW())";
                $result=mysqli_query($connect, $sql);
                $count=mysqli_num_rows($result);
                if($count){    
                    $row=mysqli_fetch_assoc($result);
                    $timebegin = $row['timebegin'];
                    $timeend = $row['timeend'];
                    $status = $row['status'];
                    if ($status == 'INUSE') {
                        echo "<td class='slotstat' style='background: #f16529;' title='From $timebegin to $timeend'></td>";
                    }elseif ($status == 'EXITED') {
                        echo "<td class='slotstat' style='background: #e9e92a;' title='From $timebegin to undefine'></td>";
                    }else {
                        echo "<td class='slotstat' style='background: green;' title='From $timebegin to $timeend'></td>";
                    }
                } else {
                    echo "<td class='slotstat' title='Click to reserve this slot'></td>";
                }
                                
                $sql = "SELECT * FROM zones WHERE slot='A2' and (timebegin <= NOW() or timein <= NOW())";
                $result=mysqli_query($connect, $sql);
                $count=mysqli_num_rows($result);
                if($count){    
                    $row=mysqli_fetch_assoc($result);
                    $timebegin = $row['timebegin'];
                    $timeend = $row['timeend'];
                    $status = $row['status'];
                    if ($status == 'INUSE') {
                        echo "<td class='slotstat' style='background: #f16529;' title='From $timebegin to $timeend'></td>";
                    }elseif ($status == 'EXITED') {
                        echo "<td class='slotstat' style='background: #e9e92a;' title='From $timebegin to undefine'></td>";
                    }else {
                        echo "<td class='slotstat' style='background: green;' title='From $timebegin to $timeend'></td>";
                    }
                } else {
                    echo "<td class='slotstat' title='Click to reserve this slot'></td>";
                }
                                
                $sql = "SELECT * FROM zones WHERE slot='A3' and (timebegin <= NOW() or timein <= NOW())";
                $result=mysqli_query($connect, $sql);
                $count=mysqli_num_rows($result);
                if($count){    
                    $row=mysqli_fetch_assoc($result);
                    $timebegin = $row['timebegin'];
                    $timeend = $row['timeend'];
                    $status = $row['status'];
                    if ($status == 'INUSE') {
                        echo "<td class='slotstat' style='background: #f16529;' title='From $timebegin to $timeend'></td>";
                    }elseif ($status == 'EXITED') {
                        echo "<td class='slotstat' style='background: #e9e92a;' title='From $timebegin to undefine'></td>";
                    }else {
                        echo "<td class='slotstat' style='background: green;' title='From $timebegin to $timeend'></td>";
                    }
                } else {
                    echo "<td class='slotstat' title='Click to reserve this slot'></td>";
                }
            ?>
                    </tr>
                </table>

            </div>
            <div class="status-blocks">
                <div class="status-block reserved">Reserved</div>
                <div class="status-block available">Available</div>
                <div class="status-block in-use">In-use</div>
            </div>
        </section>
        <?php
			include('inc/footer.php');
	?>
    </section>

</body>

</html>