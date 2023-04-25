<?php
    $conn = mysqli_connect("localhost", "admin", "123", "cpms");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $idno = $_POST['idno'];
    $plate = $_POST['plate'];

    $sql = "UPDATE users SET name=?, id_no=?, plate_no=? WHERE phone=?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $name, $idno, $plate, $phone);

    if (mysqli_stmt_execute($stmt)) {
        echo "1";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    mysqli_close($conn);
?>