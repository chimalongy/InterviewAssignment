
<?php
//ENDPOINT 1: Get all users in the system.
// ASSUMPTION: This is a get request.

require_once 'cors.php';                    // Cross origin resource sharing
require_once 'utils.php';                   // Contains neccesary functions
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    $allUsers = getAllUsers($conn);
   
    if (is_array($allUsers)) {              //Confirms the return format
        echo json_encode($allUsers);        //Expected endpoint response
    } else {
        echo $allUsers;                     //Error response
    }
} else {
    
    echo "Only GET method allowed!";        //Control Response
}

?>
