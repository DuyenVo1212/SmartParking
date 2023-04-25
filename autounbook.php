<?php 
     $connection = mysqli_connect("localhost", "root", "", "cpms");
    $query = "select * from zones where status = 'RESERVED' and timebegin < NOW() - INTERVAL 3 MINUTE";
    $rs = mysqli_query($connection, $query);
    $rows=mysqli_fetch_assoc($rs);
    if($rows) {
        foreach ($rows as $row => $id) {
            $sql = "DELETE FROM zones WHERE id = '$id'";
            mysqli_query($connection, $sql);
        }
    }
         