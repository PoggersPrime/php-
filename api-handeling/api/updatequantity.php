<?php
$hostName = "localhost";
$userName = "root";
$password = "";
$dbName = "prod_manage";
$conn = new mysqli($hostName, $userName, $password, $dbName);
// if ($conn == TRUE) {
//     echo "Good";
// }

// Get the raw POST data

$data = file_get_contents('php://input');
$decodeData = json_decode($data, true);

if ($decodeData) {
    $id = $decodeData['id'];
    $quantity = $decodeData['quantity'];
    $update_query = "UPDATE product SET quantity='$quantity' where id ='$id'";
    $update_result = $conn->query($update_query);
    if ($update_result) {
        // Prepare a response
        $response = [
            'status' => 'success',
            'message' => 'Quantity updated successfully'
        ];
        // Send JSON response
        echo json_encode($response);
    } else {
        // Prepare an error response
        $response = [
            'status' => 'error',
            'message' => 'Failed to update quantity'
        ];
        // Send JSON response
        echo json_encode($response);
    }
} else {
    // Handle invalid JSON data
    $response = [
        'status' => 'error',
        'message' => 'Invalid JSON data'
    ];
    echo json_encode($response);
}

// Close the connection
$conn->close();
