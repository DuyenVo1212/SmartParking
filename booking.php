<?php
    date_default_timezone_set("Asia/Ho_Chi_Minh");
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Book Your Parking Spot</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <?php
			include('inc/head.php');
	?>
    <link href="Source/datepicker_bootstrap/datepicker_bootstrap.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/mootools/1.6.0/mootools.min.js"></script>
    <script src="Source/datepicker_bootstrap/datepicker_bootstrap.js"></script>
    <script>
    window.addEvent('domready', function() {
        new Picker.Date($$('----'), {
            timePicker: true,
            positionOffset: {
                x: 5,
                y: 0
            },
            pickerClass: 'datepicker_bootstrap',
            useFadeInOut: !Browser.ie
        });
    });


    // JavaScript code to validate the date and time
    window.addEventListener("load", function() {
        var fromInput = document.getElementById("from");
        var toInput = document.getElementById("to");
        var now = new Date();

        fromInput.addEventListener("change", function() {
            var from = new Date(this.value);
            if (from < now) {
                alert("Please choose a date and time after the current time.");
                this.value = "";
            } else if (toInput.value !== "" && new Date(toInput.value) < from) {
                alert("Please choose a 'To' date and time after the 'From' date and time.");
                toInput.value = "";
            }
        });

        toInput.addEventListener("change", function() {
            var to = new Date(this.value);
            if (to < now || to < fromInput.value) {
                alert(
                    "Please choose a date and time after the current time and after the 'From' time."
                );
                this.value = "";
            } else if (new Date(fromInput.value) > to) {
                alert("Please choose a 'To' date and time after the 'From' date and time.");
                this.value = "";
            }
        });
    });
    </script>
</head>

<body>
    <section id="container">
        <?php
			include('inc/header.php');
						
	?>

        <section id="content">
            <form class="box login" action="process-book.php" method="post">
                <fieldset class="boxBody">
                    <label><strong>Booking Form</strong></label>
                    <hr />
                    <label style="text-align:left;">Slot</label>
                    <select name="slot" class="cjComboBox">
                        <option value="A1">A1</option>
                        <option value="A2">A2</option>
                        <option value="A3">A3</option>

                    </select>
                    <label style="text-align:left;">Plate Number</label>
                    <input type="text" tabindex="3" name="plateno" placeholder="eg. KAC 123" required>
                    <label><Strong>Specify Date and time to book</Strong></label>



                    <label for="from" style="text-align:left;">From</label>
                    <input id="from" type="datetime-local" name="from" min="<?php echo date('Y-m-d\TH:i'); ?>"
                        required />
                    <label for="to" style="text-align:left;">To</label>
                    <input id="to" type="datetime-local" name="to" min="<?php echo date('Y-m-d\TH:i'); ?>" required />



                    <label><strong>Payment Information</strong></label>
                    <hr />
                    <label style="text-align:left;">Enter Paypal Confirmation Number:</label>
                    <input type="text" name="paynum" placeholder="Card Number" required title="Credit card number"
                        maxlength="14" />
                    <label style="text-align:left;">Paid:</label>
                    <input type="text" id="paid" name="paid" value="" required maxlength="14" readonly />
                    <script>
                    const fromInput = document.getElementById("from");
                    const toInput = document.getElementById("to");
                    const paidInput = document.getElementById("paid");

                    // Calculate parking fees based on from and to dates
                    const calculateFees = () => {
                        const fromDate = new Date(fromInput.value);
                        const toDate = new Date(toInput.value);
                        const duration = (toDate.getTime() - fromDate.getTime()) / 1000; // in seconds
                        const fees = Math.ceil(duration * 100); // 100 VND per second
                        paidInput.value = fees;
                    }

                    fromInput.addEventListener("input", calculateFees);
                    toInput.addEventListener("input", calculateFees);
                    </script>
                    <label>Note: Parking Fees: 5000VND/hour</label>
                </fieldset>
                <footer>
                    <input type="submit" class="btnLogin" value="Booking now" tabindex="4">
                </footer>
            </form>

        </section>
        <?php
			include('inc/footer.php');
	?>
    </section>

</body>

</html>