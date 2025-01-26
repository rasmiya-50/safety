<?php
// Example using Twilio for SMS and SendGrid for email

// Get data from POST request (lat, lon)
$data = json_decode(file_get_contents('php://input'), true);
$lat = $data['lat'];
$lon = $data['lon'];

// Your Twilio API credentials (for sending SMS)
$sid = 'your_twilio_sid';
$token = 'your_twilio_token';
$twilio_phone = 'your_twilio_phone_number';

// Send SMS using Twilio
require_once 'vendor/autoload.php';  // Make sure to install Twilio SDK using Composer

$client = new \Twilio\Rest\Client($sid, $token);

// Example: Get contacts from database (simplified)
$contacts = getContactsFromDatabase(); // Function to retrieve trusted contacts

foreach ($contacts as $contact) {
    $message = "Emergency! Help needed at my location: https://www.google.com/maps?q=$lat,$lon";

    $client->messages->create(
        $contact['phone'],
        [
            'from' => $twilio_phone,
            'body' => $message
        ]
    );
}

// Example using SendGrid for email
require 'vendor/autoload.php';  // Make sure to install SendGrid SDK using Composer

$sendgrid = new \SendGrid('your_sendgrid_api_key');
$email = new \SendGrid\Mail\Mail();

$email->setFrom('your_email@example.com', "SOS Alert");
$email->setSubject("Emergency SOS - Immediate Attention Required");
$email->addContent("text/plain", "Emergency! Help needed at my location: https://www.google.com/maps?q=$lat,$lon");

foreach ($contacts as $contact) {
    $email->addTo($contact['email']);
}

// Send the email
$response = $sendgrid->send($email);

// Respond with success message
echo json_encode(['status' => 'success']);
?>
