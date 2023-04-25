<?php  
if (session_status() == PHP_SESSION_NONE) {
    session_start();
		if(isset($_SESSION['phone']))
			{
				
				
				} 
			else
			{
				//header("Location: index.php");
			}
}
 ?>

<header>
    <div id="logo">
        <img src="src/logoSP-rs.png" style="position:absolute; top: 0; width: 190px;" />
    </div>


    <?php 
			if(isset($_SESSION['phone']))
			{
			?>
    <div class="logged-in">
        <div>User: <?php echo $_SESSION['phone']; ?> </div>
        <div><a href="profile.php">My Profile</a></div>
        <div><a href="proc/logout.php">Sign Out</a></div>
    </div>

    <?php
			} 
			else
			{
			?>
    <button class="create_account">Create Account</button>
    <section class="log-form">
        <form class="log-in" action="proc/login.php" method="POST">
            <input type="text" name="phone" value="" />
            <input type="password" name="password" value="" />
            <input type="Submit" name="Submit" value="Log In" />
            <br />
            <p>Phone No</p>
            <p>Password</p>
        </form>
    </section>
    <?php	
			}  
			?>


    <nav>
        <ul>
            <li class="hor"><a href="index.php" class="home">Home</a></li>
            <li class="hor dropdown"><a href="map.php" class="map">Parking Slot Map</a> </li>
            <li class="hor dropdown"><a href="zones.php" class="zones">Parking Zones</a> </li>
            <?php
				if(isset($_SESSION['phone']))
				{
				?>
            <li class="hor dropdown"><a href="booking.php" class="book">Book Parking Lot</a>
            </li>
            <li class="hor dropdown"><a href="mybookings.php" class="view">My Bookings</a>
            </li>
            <?php } ?>
            <li class="hor dropdown"><a href="contact.php" class="contact">Contact Us</a>
            </li>

        </ul>
    </nav>
</header>