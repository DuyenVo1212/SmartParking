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
                    <hr />

                    <label style="text-align:left;">Card Number:</label>
                    <input type="text" id="card-number" name="card-number" placeholder="4242 4242 4242 4242" required
                        title="Credit card number" maxlength="19" />

                    <label style="text-align:left;">Expiry:</label>
                    <input type="text" id="card-expiry" name="card-expiry" placeholder="MM/YY" required maxlength="5" />

                    <label style="text-align:left;">CVV:</label>
                    <input type="text" id="card-cvc" name="card-cvc" placeholder="123" required maxlength="3" />
                    <label style="text-align:left;">Paid:</label>
                    <input type="text" id="paid" name="paid" value="" required maxlength="14" readonly />

                    <script>
                    const stripe = Stripe('your_stripe_public_key');

                    // Handle form submission
                    const form = document.getElementById('payment-form');
                    form.addEventListener('submit', async (event) => {
                        event.preventDefault();
                        const cardNumber = document.getElementById('card-number').value;
                        const cardExpiry = document.getElementById('card-expiry').value;
                        const cardCvc = document.getElementById('card-cvc').value;

                        // Validate card details
                        const isValidCard = Stripe.card.validateCardNumber(cardNumber);
                        const isValidExpiry = Stripe.card.validateExpiry(cardExpiry);
                        const isValidCVC = Stripe.card.validateCVC(cardCvc);

                        if (isValidCard && isValidExpiry && isValidCVC) {
                            // Simulate successful payment
                            const response = await fetch('/simulate-payment', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    amount: 5000, // amount in cents
                                    currency: 'vnd'
                                })
                            });
                            const data = await response.json();

                            // Show success message
                            const successMessage = document.createElement('p');
                            successMessage.innerText = 'Payment successful!';
                            form.appendChild(successMessage);
                        } else {
                            // Show error message
                            const errorMessage = document.createElement('p');
                            errorMessage.innerText = 'Invalid card details. Please try again.';
                            form.appendChild(errorMessage);
                        }
                    });
                    </script>

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
                    <label>Note: Parking Fees: 100VND/second</label>
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