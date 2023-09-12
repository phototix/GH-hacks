<?php  
// Then some JavaScript in the browser:
var conn = new WebSocket('ws://localhost:8080/echo');
conn.onmessage = function(e) { console.log(e.data); };
conn.onopen = function(e) { conn.send('Hello Me!'); };
?>