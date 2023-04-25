<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Car Park Management System</title>
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
                <p class="phead">Manage Admins</p>
                <div style="width:660px;background:white;padding:10px;margin:auto;">

                    <form method="post" action="deleteadmin.php">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered"
                            id="example">

                            <thead>

                                <tr>
                                    <th style="width:30px;">CHK</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th style="width:100px;">Password</th>
                                    <!--   <th>Id No</th> -->

                                </tr>
                            </thead>
                            <tbody>
                                <?php 
							$query=mysqli_query($connect,"select * from users where access=1")or die(mysqli_error($connect));
							while($row=mysqli_fetch_array($query)){
							$id=$row['id'];
							?>

                                <tr>
                                    <td>
                                        <input name="selector[]" type="checkbox" value="<?php echo $id; ?>">
                                    </td>
                                    <td><?php echo $row['name'] ?></td>
                                    <td><?php echo $row['phone'] ?></td>
                                    <td style="text-align:left;"><?php echo $row['password'] ?></td>
                                    <!--  <td><?php echo $row['id_no'] ?></td> -->

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