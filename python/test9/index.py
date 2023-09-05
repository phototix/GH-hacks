import Adafruit_DHT
from flask import Flask, render_template
import threading

app = Flask(__name__)

sensor = Adafruit_DHT.DHT22  # DHT22 sensor
pin = 4  # GPIO pin number

# Variables to store temperature and humidity data
temperature = None
humidity = None

def read_sensor_data():
    global temperature, humidity
    while True:
        humidity, temperature = Adafruit_DHT.read_retry(sensor, pin)

# Create a separate thread to read sensor data
sensor_thread = threading.Thread(target=read_sensor_data)
sensor_thread.daemon = True
sensor_thread.start()

@app.route('/')
def index():
    if temperature is not None and humidity is not None:
        return render_template('index.html', temperature=temperature, humidity=humidity)
    else:
        return "Failed to read sensor data."

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=80)
