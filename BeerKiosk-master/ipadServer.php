<?php
    
    //$code = "defaultData";
    $code = $_GET["code"];
    //$code = $_POST["checkCode"];
    
    
    require 'config.php';
                        $stmt = $mysqli->prepare("select code from codes where code=? AND used = -1");
                        if(!$stmt){
                            printf("Query Prep Failed: %s\n", $mysqli->error);
                            exit;
                        }
                            $stmt->bind_param('s', $code);

                            $stmt->execute();


                            $stmt->bind_result($result);



                            while($stmt->fetch()){
                            //echo "<script>console.log( 'Snack Objects: " . $snackPrice . "' );</script>";
                            }
                                $stmt->close();




                                if($result == NULL){
                                    echo json_encode([
                                            "Message" => "Invalid Code",
                                            "Status" => "Error",
                                            "Code" => $code
                                        ]);
                                }
                                else{
                                    $valid = true;
                                    
                                    echo json_encode([
                                           "Message" => "Valid Code",
                                           "Status" => "Ok"
                                       ]);
                                    
                                    
                                    $stmt = $mysqli->prepare("update codes SET used = 1 WHERE code=?");
                                    if(!$stmt){
                                        printf("Query Prep Failed: %s\n", $mysqli->error);
                                        exit;
                                    }
                                    $stmt->bind_param('s', $result);
                                    $stmt->execute();
                                    
                                    while($stmt->fetch()){
                                    
                                    }
                                    
                                    $stmt->close();



                                }
    
    
    
    
//    // Create connection
//    $con=mysqli_connect('localhost', 'beerkios_froggs', 'Froggies123!', 'beerkios_froggs');
//
//    // Check connection
//    if (mysqli_connect_errno())
//    {
//      echo "Failed to connect to MySQL: " . mysqli_connect_error();
//    }
//// This SQL statement selects ALL from the table 'Locations'
//$sql = "SELECT * FROM code WHERE code = ";
//
//// Check if there are results
//if ($result = mysqli_query($con, $sql))
//{
//    // If so, then create a results array and a temporary one
//    // to hold the data
//    $resultArray = array();
//    $tempArray = array();
//
//    // Loop through each row in the result set
//    while($row = $result->fetch_object())
//    {
//        // Add each row into our results array
//        $tempArray = $row;
//        array_push($resultArray, $tempArray);
//    }
//
//    // Finally, encode the array to JSON and output the results
//    echo json_encode($resultArray);
//}
//
//// Close connections
//mysqli_close($con);
?>
