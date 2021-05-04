<?php
    require 'config.php';

    if(isset($_GET["codeVal"])) {
        $code = htmlspecialchars($_GET["codeVal"]);
        $stmt = $mysqli->prepare("update codes SET used = -1 WHERE code=?");
                                if(!$stmt){
                                    printf("Query Prep Failed: %s\n", $mysqli->error);
                                    exit;
                                }
                                $stmt->bind_param('s', $code);
                                echo "Code Refunded for code: ";
                                echo $code;
                                $stmt->execute();
                                
                                while($stmt->fetch()){
                                
                                }
                                $stmt->close();
    }
?>