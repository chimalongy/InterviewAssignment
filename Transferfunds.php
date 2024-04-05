<?php
//ENDPOINT 4: Send money from one wallet to another.
// ASSUMPTION: 1. The sender and reciever walletIDs are known and used in the request.
        //     2. Amount is know.
        //     3. Request body in is JSON format

require_once 'cors.php';                                    // Cross origin resource sharing
require_once 'utils.php';                                   // Contains neccesary functions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestBody = file_get_contents('php://input');        //  Read the request body
    $data = json_decode($requestBody, true);                //  Parse the request body
    if ($data !== null) {

        // Confirm that all parameters are in the request body
        if (isset($data['walletFrom'])&&isset($data['walletTo'])&&isset($data['amount'])) {
            $senderWalletID = $data['walletFrom'];
            $recieverWalletID = $data['walletTo'];
            $amount = intval($data['amount']);                //convert amount to integer (precautionary)

            if ($senderWalletID!== $recieverWalletID){

                $senderWallet = getWalletDetails($senderWalletID); // Get sender wallet details
                $recieverWallet = getWalletDetails($recieverWalletID); // Get reciever wallet details
               
                $senderwalletBalance =  intval($senderWallet['balance']);       // Extract current sender balance
                
                $reciverwalletBalance =  intval($recieverWallet['balance']);    // Extract current reciver balance
               
    
                if ( $senderwalletBalance >=  $amount){                  // Confirm that sender has enough funds
                    $newSenderWalletBalance = $senderwalletBalance - $amount; // Deduct amount from the senderwallet
                    $newreciverWalletBalance = $reciverwalletBalance + $amount; // Add amount to the reciverwallet
    
                    $senderUpdateValue =updateWalletBalance($senderWalletID,$newSenderWalletBalance); // update sender wallet balance
                    if ($senderUpdateValue){
                            $reciverUpdateValue = updateWalletBalance($recieverWalletID,$newreciverWalletBalance); // update reciver wallet balance
                        if ( $reciverUpdateValue){
                            echo "Transfer succesfull";                 // Expected endpoint response 1
                        }
                        else{
                           echo json_encode($reciverUpdateValue);       // Error response
                           
                        }
                    }
                    else{
                        echo json_encode($senderUpdateValue);           // Error response
                        
                    }
                   
                }
                else{
                    echo 'insufficient amount';                         // Expected endpoint response 2
                }
            }
            else{
                echo 'sender wallet cannot send to the same wallet';
            }

        }
        else{
                    echo "Error: Transfer Parameters incompelete";      
         }
        }
        else{
            echo "Body required";
        }

}
else{
    echo "Error: Only POST method is allowed";
}
?>