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

echo "<div id=\"testDiv\">Currently Serving: {$typeSnack} </div>";
echo "<div id =\"amountDiv\">Cost Per Snack: {$snackPrice}</div>";
echo "<div id =\"flatDiv\"></div>";
echo "<div id =\"taxDiv\"></div>";
echo "<div id =\"totalCost\">{$snackPrice}</div>";
?>

<html>
<head>
<!-- The Styling File -->
<link rel="stylesheet" href="./style.css"/>
<title>Snack Kiosk!</title>
<script type = "text/javascript" src = "functional.js"> </script>
</head>
<body>
    <div id="paymentDiv">
<form action="./charge.php" method="post" id="payment-form">

  <div id="inputDiv">
    </br>
    </br>
        <center>
            <h3>How many snacks would you like to purchase?</h1>
                  <button id="minus" style="background-color: #008CBA; /* Green */
                border: none;
                color: white;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 80px;border-radius: 12px;">-</button>      <input  type="number" name="amountOfSnacks" id="amountOfSnacks" style="font-size: 80px; width: 130px; color:#008CBA;"/>      <button id="plus" style="background-color: #008CBA; /* Green */
border: none;
color: white;
padding: 15px 32px;
text-align: center;
text-decoration: none;
display: inline-block;
font-size: 80px;border-radius: 12px;">+</button>
    </br>
    </br>
    </br>
    <p>Enter Phone Number (Format: Area Code and Number): </p> 
    <input type="tel" id="phone" name="phone" >
  </br>
</br>

            <button id="purchaseButton" style="background-color: #008CBA; /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 50px;border-radius: 12px;">Next</button></center>
        </div>  
  <div class="form-row">
    <label for="card-element">Credit or debit card</label>
    <div id="card-element">
      <!-- a Stripe Element will be inserted here. -->
    </div>
    <!-- Used to display form errors -->
    <div id="card-errors"></div>
  </div>
  <button>Submit Payment</button> </div>
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
