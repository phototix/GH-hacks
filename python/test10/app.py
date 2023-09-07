from flask import Flask, render_template
import requests

app = Flask(__name__)

# Replace these with the actual URLs or endpoints of your video doorbell API
VIDEO_FEED_URL = "http://your-doorbell-api-url/live-video-feed"
DOORBELL_STATUS_URL = "http://your-doorbell-api-url/doorbell-status"

@app.route('/')
def index():
    try:
        # Fetch the live video feed from the doorbell
        video_response = requests.get(VIDEO_FEED_URL)
        if video_response.status_code == 200:
            video_stream = video_response.content
        else:
            video_stream = None
        
        # Fetch the doorbell status
        doorbell_response = requests.get(DOORBELL_STATUS_URL)
        if doorbell_response.status_code == 200:
            doorbell_status = doorbell_response.json()
        else:
            doorbell_status = {"status": "Error fetching doorbell status"}

    except requests.exceptions.RequestException as e:
        # Handle connection errors gracefully
        video_stream = None
        doorbell_status = {"status": "Error: Could not connect to the doorbell."}

    return render_template('index.html', video_stream=video_stream, doorbell_status=doorbell_status)

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=80)
