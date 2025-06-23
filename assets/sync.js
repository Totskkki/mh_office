function checkConnection() {
    if (navigator.onLine) {
        console.log("You are connected to the internet, starting synchronization.");
        syncData();
    } else {
        console.log("You are offline, synchronization paused.");
    }
}

function syncData() {
    fetch("sync.php")
    .then(response => {
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        return response.text();
    })
    .then(data => {
        console.log("Synchronization complete:", data);
    })
    .catch(error => console.error("Sync failed:", error));
}

// Check connection every 2 minutes (120000 ms)
setInterval(checkConnection, 300000);
