# Install packages below to environment for this codes
# pip install boto3 Flask
# aws configure

# Start of project code.
from flask import Flask, Response
import boto3
from botocore import UNSIGNED
from botocore.config import Config

app = Flask(__name__)

# AWS S3 configuration
s3 = boto3.client('s3', config=Config(signature_version=UNSIGNED))

# Replace with your AWS S3 bucket and video file URL
bucket_name = 'your-bucket-name'
video_key = 'path/to/your/video.mp4'

@app.route('/stream')
def stream_video():
    # Get the S3 object
    s3_response = s3.get_object(Bucket=bucket_name, Key=video_key)

    # Create a generator to stream the video content
    def generate():
        for chunk in iter(lambda: s3_response['Body'].read(1024), b''):
            yield chunk

    # Set the content type for video streaming
    headers = {'Content-Type': 'video/mp4'}

    # Use the Response object to stream the video content
    return Response(generate(), headers=headers)

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=80)

# Run in environment
# The video will be available at http://your-raspberry-pi-ip/stream. Replace your-raspberry-pi-ip with the IP address of your Raspberry Pi.
# python your_flask_app.py