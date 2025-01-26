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
            alert("User denied the request for Geolocation.");
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
