<?php
//ENDPOINT 3: Get a wallet's details including its owner, type and available balance.
// ASSUMPTION: 1. The walletID is known and used in the request.
        //     2. Request body in is JSON format

// DATABASE WAS DESIGNED SO THAT USER ID WOULD BE A FOREIGN KEY FOR IN WALLETS

require_once 'cors.php';                                    // Cross origin resource sharing
require_once 'utils.php';                                   // Contains neccesary functions

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestBody = file_get_contents('php://input');        //  Read the request body
    
    $data = json_decode($requestBody, true);                //  Parse the request body
    
    if ($data !== null) {
       
        if (isset($data['walletID'])) {                     // Checks for the ID
           
           $walletDetails = [                               // Wallet Details blueprint (object) to be returned
                'owner' => "",
                'type' => "",
                'balance'=>""
            ];
            
             $wallet= getWalletDetails($data['walletID']);  // Get Wallet Details
             if ($wallet!="Error: Wallet not found."){
                $walletDetails['type']= $wallet['type'];    // Update wallet BluePrint( object) with the necessary properties
                $walletDetails['balance']= $wallet['balance'];
                $walletowner= getWalletOwner($wallet['userID']);
                $walletDetails['owner']= $walletowner;
                echo json_encode($walletDetails);           // Expected endpoint response
             }
             else{
                echo $wallet;                               // Error response
             }

             
          
          
                
            
        } else {
            echo "no wallet id found in request";           // Error response
        }
        
    } else {
        // If JSON decoding failed
        echo "Error: Unable to decode JSON data";              // Error response
    }
    
} else {
   
    echo "Error: Only POST method is allowed";               // Control Response
}
?>
