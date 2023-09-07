document.addEventListener("DOMContentLoaded", () => {
    const audio = document.getElementById("audio");
    const trackTitle = document.getElementById("track-title");
    const artist = document.getElementById("artist");
    const album = document.getElementById("album");

    // Function to load and play the MP3 file from a URL
    function playMusic(mp3Url) {
        audio.src = mp3Url;
        audio.play();
    }

    // Function to fetch and display track details from fileinfo.json
    async function fetchTrackDetails(jsonUrl) {
        try {
            const response = await fetch(jsonUrl);
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            const data = await response.json();
            trackTitle.textContent = data.title;
            artist.textContent = "Artist: " + data.artist;
            album.textContent = "Album: " + data.album;
        } catch (error) {
            console.error("Error fetching track details:", error);
        }
    }

    // Input your MP3 file URL and fileinfo.json URL here
    const mp3Url = "YOUR_MP3_FILE_URL_HERE";
    const jsonUrl = "YOUR_FILEINFO_JSON_URL_HERE";

    // Play the music and fetch track details
    playMusic(mp3Url);
    fetchTrackDetails(jsonUrl);
});
