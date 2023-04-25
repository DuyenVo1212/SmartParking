<?php
require('inc/connect.php');

$plateno = $_POST['plateno'];
$slot = $_POST['slot'];
$from = $_POST['from'];
$to = $_POST['to'];
$paynum = $_POST['paynum'];

session_start();
$status = "RESERVED";
$time_begin = strtotime($from);
$time_end = strtotime($to);
$diff = $time_end - $time_begin;
$hours = round($diff / (60 * 60));
if($hours<12) {
    $cost = $hours * 5000;
}elseif ($hours>=12 && $hours<48) {
    $cost = 12 * 5000 + ($hours-12)*10000;
} else {
    $cost = 300000;
}

$formatted_cost = number_format($cost, 0, ',', ',');
$charge = $formatted_cost . " VND";
$phone = $_SESSION["phone"];
$restime = substr( $from,  0, 10);

// Check if the slot is available
$existing_bookings = mysqli_query($connect, "SELECT * FROM zones WHERE slot='$slot' AND (status ='RESERVED' OR status ='INUSE')");
while ($booking = mysqli_fetch_assoc($existing_bookings)) {
    $existing_start_time = strtotime($booking['timebegin']);
    $existing_end_time = strtotime($booking['timeend']);
    if (($time_begin >= $existing_start_time && $time_begin <= $existing_end_time) || ($time_end >= $existing_start_time && $time_end <= $existing_end_time)) {
        $_SESSION['error'] = 'Sorry, this reservation period has already been booked. Please choose another time period.';
        header('location:error-book.php');
        exit();
    }
        
}
// Add the new reservation to the database
$query = "INSERT INTO zones (phone, `status`, slot, plateno, paynum, charge, timebegin, timeend,pays) VALUES ('$phone','$status', '$slot', '$plateno', '$paynum', '$charge', '$from', '$to','paid')";
$result = mysqli_query($connect, $query);

if (!$result) {
    // Redirect to the booking page
    $_SESSION['error'] = 'error insert zones : '. mysqli_error($connect);
    header('location:error-book.php');
    exit();
}

$sql = "INSERT INTO `reserved-list` ( restime, slot, plate, phone,charge) VALUES ('$restime','$slot', '$plateno', '$phone', '$charge')";
$rs = mysqli_query($connect, $sql);

if(!$rs){
    // Insert failed, display error message
    $_SESSION['error'] = 'error insert reslist: '. mysqli_error($connect);
    header('location:error-book.php');
    exit();
}

header('location:mybookings.php');
exit();

