<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOS Alert System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        #sos-btn {
            background-color: red;
            color: white;
            font-size: 20px;
            padding: 20px 40px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        #sos-btn:hover {
            background-color: darkred;
        }
        h1 {
            color: #333;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Emergency SOS Alert</h1>
        <p>Click the button below to send an SOS to your trusted contacts.</p>
        <button id="sos-btn">Send SOS</button>
    </div>

    <script>
        document.getElementById("sos-btn").addEventListener("click", function() {
            // Get the user's geolocation (latitude and longitude)
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(sendSOS, showError);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        });

        function sendSOS(position) {
            let lat = position.coords.latitude;
            let lon = position.coords.longitude;

            // Make an AJAX request to your server to send SOS (pass location)
            fetch("/send-sos.php", {
                method: "POST",
                body: JSON.stringify({ lat: lat, lon: lon }),
                headers: { "Content-Type": "application/json" }
            })
            .then(response => response.json())
            .then(data => alert("SOS sent!"))
            .catch(error => console.error("Error sending SOS: ", error));
        }

        function showError(error) {
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    alert("User  denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    alert("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("An unknown error occurred.");
                    break;
            }
        }
    </script>
</body>
</html>