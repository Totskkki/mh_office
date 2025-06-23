function checkConnection() {
    if (navigator.onLine) {
        console.log("You are connected to the internet");
        
        // Execute the sync PHP script via AJAX
        fetch("http://localhost/websitedeployed/sync_local_to_remote.php")
            .then(response => response.text())
            .then(data => console.log(data))
            .catch(error => console.error("Sync failed:", error));
    } else {
        alert("You are offline");
    }
}

setInterval(checkConnection, 30000); // Check every 2 minutes
