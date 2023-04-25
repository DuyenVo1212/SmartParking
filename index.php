<!DOCTYPE html>
<html>

<head>
    <title>Reserve Your Parking Spot Today</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <?php
			include('inc/head.php');
	?>
    <style>
    .galeri {
        display: flex;
        height: 400px;
        gap: 5px;
        margin-bottom: 20px;
    }

    .galeri>div {
        flex: 1;
        border-radius: 10px;
        background-position: center;
        background-repeat: no-repeat;
        background-size: auto 100%;
        transition: all .8s cubic-bezier(.25, .4, .45, .1.4);
    }

    .galeri>div:hover {
        flex: 8;
    }
    </style>
</head>

<body>
    <section id="container">
        <?php
			include('inc/header.php');
						
	?>

        <section id="content">
            <section id="index-content">
                <h1>SMART PARKING</h1>
                <pre
                    style="color: #2c3e50;">Welcome to our smart parking project, the perfect solution for all your car parking needs!</pre>

                <h2>Sign up for our newsletter now</h2>
                <form>
                    <!--   <label for="email">Your email:</label> -->
                    <input type="email" id="email" placeholder="Enter your email" required>
                    <input type="submit" value="Sign up">
                </form>
                <div class="galeri">
                    <div style="background-image: url('src/parking.jpg');"></div>
                    <div style="background-image: url('src/parking1.jpg');"></div>
                    <div style="background-image: url('src/parking2.jpg');"></div>
                    <div style="background-image: url('src/parking3.jpg');"></div>
                </div>

            </section>

        </section>
        <?php
			include('inc/footer.php');
	?>
    </section>

</body>

</html>