<?php
session_start();
require_once('vendor/autoload.php');
\Stripe\Stripe::setApiKey('sk_test_dqDBmL1pdqt34eGeKGoqxv8h00Tdy9uCbK');
$token = $_POST['stripeToken'];
$amount = $_POST["amountOfSnacks"];
$phone = $_POST["phone"];
$stripped = str_replace(' ', '', $phone);
$stripped = str_replace('-', '', $stripped);
$stripped = str_replace('(', '', $stripped);
$stripped = str_replace(')', '', $stripped);
$phone = $stripped;
$snackPrice = 1.00;
if($amount == null){
  header("Location: https://beer-kiosk.com/generatecode.php");
}


require 'config.php';
$stmt = $mysqli->prepare("select snackPrice from general where id=1");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->execute();


$stmt->bind_result($snackPrice);



while($stmt->fetch()){
  //echo "<script>console.log( 'Snack Objects: " . $snackPrice . "' );</script>";
}
$directPrice = $snackPrice;
$price = $snackPrice;
$stmt->close();

$amountOutput = $amount." "." Tasty Snack";

if($amount != 0 && $snackPrice != 0){


$snackPrice = $snackPrice * $amount;
$stripePrecent = $snackPrice * .029;
$snackPrice = (($snackPrice + $stripePrecent) * 100) + 30;

try{
  $charge = \Stripe\Charge::create([
    'amount' => (int)$snackPrice,
    'currency' => 'usd',
    'description' => $amountOutput,
    'source' => $token
    ]);
}
catch(Stripe_CardError $e) {
  $error1 = $e->getMessage();
  echo $error1;
  exit();
} catch (Stripe_InvalidRequestError $e) {
  // Invalid parameters were supplied to Stripe's API
  $error2 = $e->getMessage();
  echo $error2;
  exit();
} catch (Stripe_AuthenticationError $e) {
  // Authentication with Stripe's API failed
  $error3 = $e->getMessage();
  echo $error3;
  exit();
} catch (Stripe_ApiConnectionError $e) {
  // Network communication with Stripe failed
  $error4 = $e->getMessage();
  echo $error4;
  exit();
} catch (Stripe_Error $e) {
  // Display a very generic error to the user, and maybe send
  // yourself an email
  $error5 = $e->getMessage();
  echo $error5;
  exit();
} catch (Exception $e) {
  // Something else happened, completely unrelated to Stripe
  $error6 = $e->getMessage();
  echo $error6;
  exit();
}
  


}



//print_r($charge);


$chargeObject = $charge->__toArray(true);
//echo $chargeObject['paid'];
$_SESSION['payment'] = false;
$amountPurchased = $chargeObject['description'];
if($chargeObject['paid'] == 1 && $chargeObject['status'] == "succeeded"){
  
  $_SESSION['payment'] = $chargeObject['id'];
  $stmt = $mysqli->prepare("insert into payment (id, phone, amount, price) values (?, ?, ?, ?)");
  if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $paymentId = $chargeObject['id'];
  $stmt->bind_param('ssss', $paymentId,$phone,$amountPurchased,$price);
  $stmt->execute();
  $stmt->close();
  header("Location: https://beer-kiosk.com/generatecode.php");
}




set_error_handler('failed');

?>