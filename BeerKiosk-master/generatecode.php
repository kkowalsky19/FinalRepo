<?php
session_start();
use Twilio\Rest\Client;
require_once "vendor/twilio/sdk/Twilio/autoload.php";
$phone = 0;
$amount = -1;
$paymentId = $_SESSION["payment"];
$totalCodes = "Generated Codes:";
$totalCodesPhone = "Thank you for purchasing! Your codes are: | ";



if($paymentId == false){
    echo "Access Denied";
}
else{


    require 'config.php';
$stmt = $mysqli->prepare("select amount, used, phone, price from payment where id=?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('s', $paymentId);

$stmt->execute();


$stmt->bind_result($amount,$used,$phone,$price);



while($stmt->fetch()){
  echo "<script>console.log( 'Snack Objects: " . $snackPrice . "' );</script>";
}
$stmt->close();

if($used == null){
    //Payment ID was not found in the database throwing this error
    echo "Access Denied Error Code: 1313";
}
else if($used == -1){
    //then gen code
    

        //Changes code to used
    $stmt = $mysqli->prepare("update payment SET used = 1 WHERE id=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('s', $paymentId);
    
    $stmt->execute();
    
    while($stmt->fetch()){
      //echo "<script>console.log( 'Snack Objects: " . $snackPrice . "' );</script>";
    }
    $stmt->close();

    for($i = 0; $i<$amount; $i++){


                            //Statement to generate code and check if it's in the database
                        $tempCode = mt_rand(100000,999999);
                        require 'config.php';
                        $stmt = $mysqli->prepare("select code from codes where code=?");
                    if(!$stmt){
                        printf("Query Prep Failed: %s\n", $mysqli->error);
                        exit;
                    }
                        $stmt->bind_param('s', $tempCode);

                        $stmt->execute();


                        $stmt->bind_result($code);



                        while($stmt->fetch()){
                        //echo "<script>console.log( 'Snack Objects: " . $snackPrice . "' );</script>";
                        }
                            $stmt->close();
                            if($code == NULL){
                                                //No overlapping codes, so place it in the database!
                                                    require 'config.php';
                                                    $stmt = $mysqli->prepare("insert into codes (id, code, phone, price) values (?, ?, ?, ?)");
                                                if(!$stmt){
                                                printf("Query Prep Failed: %s\n", $mysqli->error);
                                                exit;
                                                }
                                                
                                                $stmt->bind_param('ssss', $paymentId, $tempCode, $phone, $price);
                                                $stmt->execute();
                                                $stmt->close();
                                                $totalCodes = $totalCodes . "<br>" . $tempCode;
                                                $totalCodesPhone = $totalCodesPhone . $tempCode . " | ";
                            }
                            else{
                                                    //Overlapping codes, need to regenerate the code!
                                                    $i = $i -1;
                            }


    }
    echo $totalCodes;
    //echo $totalCodesPhone;
    
    $phone = "1" . $phone;
    
    

    // Your Account SID and Auth Token from twilio.com/console
    $account_sid = 'ACb33613893ad773affbeaa5d4e1ef3864';
    $auth_token = 'dc72a7de924dd27ab323c76bd8a5ca68';
    // In production, these should be environment variables. E.g.:
    // $auth_token = $_ENV["TWILIO_ACCOUNT_SID"]

    // A Twilio number you own with SMS capabilities
    $twilio_number = "+15165482117";

    $client = new Client($account_sid, $auth_token);
    $client->messages->create(
        // Where to send a text message (your cell phone?)
        $phone,
        array(
            'from' => $twilio_number,
            'body' => $totalCodesPhone
        )
    );
    


    
}
else if($used == 1){
    //throw codes already recieved
    $stmt = $mysqli->prepare("select code from codes where id = ? AND used = -1");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}


$stmt->bind_param('s',$paymentId);



$stmt->execute();
$stmt->bind_result($existingCodes);



while($stmt->fetch()){
    printf("\t<div><li>Code: %s </li>\n",
           ($existingCodes));
    echo "<br><hr><br>";
}

$stmt->close();


}

    
}
?>