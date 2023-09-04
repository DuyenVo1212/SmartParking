<?php
   $connection=mysqli_connect("localhost", "root", "", "cpms") or die(mysqli_connect_error());
   $name = $_POST['name']; //get posted data
    $phone = $_POST['phone'];  //escape string 

    $sql = "UPDATE users SET name = '$name' WHERE phone = '$phone'";
       // $sql = "UPDATE content SET text = '$content' WHERE element_id = '2' ";


    if (mysqli_query($connection, $sql))
    {
        echo 1;
    }

?>