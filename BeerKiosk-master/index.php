<?php
require 'config.php';
$stmt = $mysqli->prepare("select snackPrice, status, snackName from general where id=1");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->execute();

$stmt->bind_result($snackPrice,$status,$typeSnack);

while($stmt->fetch()){
  echo "<script>console.log( 'Snack Objects: " . $snackPrice . "' );</script>";
}
$stmt->close();

if($status == 0){
  echo "Kiosk is currently closed! Please contact a manager to bring it back up!";
  echo "<title>Currently Closed!</title></head>";
  exit();
}
?>

<html>
<head>
  <!-- The Styling File -->
  <link rel="stylesheet" href="./style.css"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Snack Kiosk!</title>
  <script type = "text/javascript" src = "functional.js"> </script>
</head>

<body>
  <form action="./charge.php" method="post" id="payment-form">
    <h1>Beer Kiosk</h1>

    <div class="center-items">
      <div class="price_info">
        <?php
          echo "<div class=\"cost-div\" id=\"testDiv\">Currently Serving: {$typeSnack} </div>";
          echo "<div class=\"cost-div\" id =\"amountDiv\">Cost Per Beer: {$snackPrice} </div>";
          echo "<div class=\"cost-div\" id =\"flatDiv\"></div>";
          echo "<div class=\"cost-div\" id =\"taxDiv\"></div>";
          echo "<div class=\"cost-div\" id =\"totalCost\">{$snackPrice}</div>";
        ?>
      </div>

        <div id="paymentDiv">
          <div id="inputDiv">
            <div style="display: flex; flex-direction: column">
              <input type="number" name="amountOfSnacks" id="amountOfSnacks"/>
              <div style="display: flex; min-width: min-content">

                <button id="minus">-</button>
                <button id="plus">+</button>
              </div>
            </div>
          </div>

          <div id="credit-info">
            <div class="form-row">
              <label for="card-element">Credit or debit card</label>

              <!-- a Stripe Element will be inserted here. -->
              <div id="card-element"></div>

              <!-- Used to display form errors -->
              <div id="card-errors"></div>
            </div>
            <button>Submit Payment</button>
          </div>

        </div>
    </div>

    <label class="phone">
      Phone Number <br />
      <input class="phone" type="tel" id="phone" name="phone" />
    </label>

    <button id="purchaseButton">Next</button>


    <div class="info" id="extraInfo">
       <button onclick='window.location.href = "about.html"'>About</button>
       <button onclick='window.location.href = "help.html"'>Help</button>
       <button onclick='window.location.href = "faq.html"'>FAQ</button>
   </div>
  </form>

  <!-- The needed JS files -->
  <!-- JQUERY File -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!-- Stripe JS -->
  <script src="https://js.stripe.com/v3/"></script>
  <!-- Your JS File -->
  <script src="./charge.js"></script>

</body>
</html>
