document.addEventListener("DOMContentLoaded", () => {
    const locationDropdown = document.getElementById("location");
    const coordinatesDisplay = document.getElementById("coordinates");

    locationDropdown.addEventListener("change", () => {
        const selectedCoordinates = locationDropdown.value;
        coordinatesDisplay.textContent = selectedCoordinates;
    });
});


// Replace 'YOUR_API_KEY_HERE' with your OneMap API key
const apiKey = 'YOUR_API_KEY_HERE';

locationDropdown.addEventListener("change", async () => {
    const selectedCoordinates = locationDropdown.value;

    // Fetch additional information using OneMap API
    const apiUrl = `https://developers.onemap.sg/commonapi/convert/4326to3414?latitude=${selectedCoordinates.split(',')[0]}&longitude=${selectedCoordinates.split(',')[1]}&apiKey=${apiKey}`;

    try {
        const response = await fetch(apiUrl);
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        const data = await response.json();
        // Use 'data' to display additional information or map
    } catch (error) {
        console.error("Error fetching location information:", error);
    }

    coordinatesDisplay.textContent = selectedCoordinates;
});
