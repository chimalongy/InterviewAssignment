<?php
// THIS MODULE CONTAINS FUNCTIONS INTERACT WITH THE DATA BASE and ENDPOINTS

require_once 'database_connect.php';


function getAllUsers() {
    global $conn;
    $users = [];
                                                // Query to select all users
    $sql = "SELECT * FROM users";
                                               // Execute the query
    $result = $conn->query($sql);
    
                                               // Check if the query was successful
    if ($result === false) {
        echo "Error: " . $conn->error;
    } else {
                                                // Check if there are any users found
        if ($result->num_rows > 0) {
            // Fetch all rows from the result set
            while ($row = $result->fetch_assoc()) {
               
                array_push($users, $row);
                
            }
            return $users;
        } else {
            return "No users found in the database.";
        }
    }
}

function getAllWallets() {
    $wallets = [];
    global $conn;
                                                // Query to select all wallets
    $sql = "SELECT * FROM wallets";

                                                // Execute the query
    $result = $conn->query($sql);

                                                // Check if the query was successful
    if ($result === false) {
        return "Error: " . $conn->error;
    } else {
                                                // Check if there are any wallets found
        if ($result->num_rows > 0) {
                                                 // Fetch all rows from the result set
            while ($row = $result->fetch_assoc()) {
                array_push($wallets, $row);
            }
            return $wallets;
        } else {
            return "No wallets found in the database.";
        }
    }
}

function getWalletOwner($id) {
    global $conn;                       // Access the $conn object defined in database_connection.php
    $id = intval($id);
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = $conn->query($sql);

                                        // Check if the query was successful
    if ($result === false) {
        return "Error: " . $conn->error;
    } else {
                                        // Check if the user was found
        if ($result->num_rows > 0) {
                                         // Fetch the user's data
            $user = $result->fetch_assoc();
            return $user['userName'];   // Return the user's details
        } else {
            return "User not found.";
        }
    }
}

function getWalletDetails($id){
    global $conn;
    $sql = "SELECT * FROM wallets WHERE walletID = " . intval($id);
    $result = $conn->query($sql);
    if ($result === false) {
        return "Error: " . $conn->error;
    } 
    else {
        if ($result->num_rows > 0) {
            $wallet = $result->fetch_assoc();
            return $wallet;
        } else {
            return "Error: Wallet not found.";
        }
    }
}

function updateWalletBalance($id, $newBalance) {
    global $conn;

    $id = intval($id);
    $newBalance = intval($newBalance);

    
    // Prepare the SQL statement
    $sql = "UPDATE wallets SET balance=$newBalance WHERE walletID=$id";
    
    
    // Execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return "Error updating balance: " . $conn->error;
    }
}



?>