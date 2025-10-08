<?php
// Step 1: Receive the JSON data Safaricom sends
$data = file_get_contents('php://input');

// Step 2: Save the data into a log file (so you can check it later)
file_put_contents("mpesa-callback-log.json", $data . PHP_EOL, FILE_APPEND);

// Step 3: Decode the JSON to read it
$response = json_decode($data, true);

// Step 4: Extract important details
$resultCode = $response['Body']['stkCallback']['ResultCode'];
$resultDesc = $response['Body']['stkCallback']['ResultDesc'];

// Step 5: If payment succeeded, you can save it to your database
if ($resultCode == 0) {
    $metadata = $response['Body']['stkCallback']['CallbackMetadata']['Item'];
    $amount = $metadata[0]['Value'];
    $receipt = $metadata[1]['Value'];
    $phone = $metadata[3]['Value'];

    // Example: Save to database (optional)
}

// Step 6: Send response back to Safaricom
http_response_code(200);
echo json_encode(["ResultCode" => 0, "ResultDesc" => "Callback received successfully"]);
?>
