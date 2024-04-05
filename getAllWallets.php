<?php
//ENDPOINT 2: Get all wallets in the system
// ASSUMPTION: This is a get request

require_once 'cors.php';                    // Cross origin resource sharing
require_once 'utils.php';                   // Contains neccesary functions
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    $allWallets = getAllWallets();          // Call the function to get all wallets

    
    if (is_array($allWallets)) {            // Confirms the return format
        echo json_encode($allWallets);      // Expected endpoint response
    } else {
        echo $allWallets;                   // Error response
    }
} else {
    
    echo "Only GET method allowed!";        // Control Response
}


?>