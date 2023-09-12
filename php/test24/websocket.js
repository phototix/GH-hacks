// Create a WebSocket connection to the PHP server
const socket = new WebSocket('ws://your-php-server-address');

// Capture Leap Motion data and send it to the server
Leap.loop(function(frame) {
    // Extract hand tracking data from the 'frame' object
    const handData = frame.hands; // Replace with actual Leap Motion SDK code

    // Send the hand data to the PHP server
    socket.send(JSON.stringify(handData));
});
