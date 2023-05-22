<?php
require('inc/connect.php');

$plateno = $_POST['plateno'];
$slot = $_POST['slot'];
$from = $_POST['from'];
$to = $_POST['to'];
$paynum = $_POST['paynum'];
$paid = $_POST['paid'];

session_start();
$status = "RESERVED";
$time_begin = strtotime($from);
$time_end = strtotime($to);
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

// Kiểm tra số lần đặt chỗ 
$today = date('Y-m-d');
$booking_count_query = "SELECT COUNT(*) AS booking_count FROM zones WHERE phone='$phone' AND DATE(timebegin) = '$today'";
$booking_count_result = mysqli_query($connect, $booking_count_query);
$row = mysqli_fetch_assoc($booking_count_result);
$booking_count = $row['booking_count'];

// Kiểm tra số lần đặt chỗ đã vượt quá giới hạn
if ($booking_count >= 5 && $restime === $today) {
    $_SESSION['error'] = 'You have reached the maximum limit of 5 bookings per day. Please cancel a previous booking before making a new one.';
    header('location:error-book.php');
    exit();
}

// Add the new reservation to the database
$query = "INSERT INTO zones (phone, `status`, slot, plateno, paynum, charge, timebegin, timeend,pays) VALUES ('$phone','$status', '$slot', '$plateno', '$paynum', '$paid', '$from', '$to','paid')";
$result = mysqli_query($connect, $query);

if (!$result) {
    // Redirect to the booking page
    $_SESSION['error'] = 'error insert zones : '. mysqli_error($connect);
    header('location:error-book.php');
    exit();
}

$sql = "INSERT INTO `reserved-list` ( restime, slot, plate, phone,charge) VALUES ('$restime','$slot', '$plateno', '$phone', '$paid')";
$rs = mysqli_query($connect, $sql);

if(!$rs){
    // Insert failed, display error message
    $_SESSION['error'] = 'error insert reslist: '. mysqli_error($connect);
    header('location:error-book.php');
    exit();
}

header('location:mybookings.php');
exit();
