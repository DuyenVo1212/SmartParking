<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>View and Respond to User Messages</title>
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
        <style>
        .table td,
        .table th {
            text-align: center;
        }
        </style>

        <section id="content">
            <p class="phead">User Messages</p>
            <div style="width:660px;background:white;padding:10px;margin:auto;">

                <form method="post" action="deletemsg.php">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered"
                        id="example">

                        <thead>
                            <tr>
                                <th>CHK</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th style="width:180px;">Message</th>
                                <th style="width:100px;">Date & Time</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php 
   			 $query=mysqli_query($connect,"select * from messages")or die(mysqli_error($connect));
    		  while($row=mysqli_fetch_array($query)){
        		$id=$row['id'];
							?>

                            <tr>
                                <td>
                                    <input name="selector[]" type="checkbox" value="<?php echo $id; ?>">
                                </td>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['phone'] ?></td>
                                <td style="width:180px text-align:left;"><?php echo $row['msg'] ?></td>
                                <td><?php echo $row['msgdate'] ?></td>

                            </tr>

                            <?php } ?>
                        </tbody>
                    </table>
                    <input type="submit" class="btn btn-danger" value="Delete" name="delete">

                </form>
            </div>
            </div>
        </section>
    </section>
</body>

</html>