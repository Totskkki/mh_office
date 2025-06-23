<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Define your API key
$apiKey = "u3Qi5pUhKkeaPb26gVj2AZC3K3WP8VnR";

// Check if the query parameter is provided
if (isset($_GET['query']) && !empty($_GET['query'])) {
    $query = $_GET['query'];
    error_log("Received query: " . $query);
} else {
    $query = ''; 
    error_log("No query parameter received, fetching latest news.");
}

// Properly format the query for the API request
$queryEncoded = urlencode($query);

// Define the API endpoint URL
$apiUrl = "https://api.apilayer.com/google_search?q=" . $queryEncoded;

// Initialize cURL session
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $apiUrl,
  CURLOPT_HTTPHEADER => array(
    "Content-Type: text/plain",
    "apikey: $apiKey"
  ),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET"
));

// Execute the cURL request and fetch the response
$response = curl_exec($curl);

// Close the cURL session
curl_close($curl);

// Check if the response was successful and print it
if ($response === false) {
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching data from the API.'
    ]);
    exit;
}

echo $response; 
