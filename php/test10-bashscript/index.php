<?php  
// Execute the shell script and capture the output
$output = shell_exec('bash restart_servers.sh');

// Check if the shell script executed successfully
if ($output === null) {
    echo "Server restart failed.";
} else {
    echo "Server restarted successfully.";
}
?>