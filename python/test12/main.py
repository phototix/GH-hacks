import subprocess

def check_device_status(ip_address):
    try:
        # Run the ping command
        result = subprocess.run(['ping', '-c', '1', ip_address], stdout=subprocess.PIPE, stderr=subprocess.PIPE, timeout=5, text=True)
        
        # Check the return code to determine the status
        if result.returncode == 0:
            return f"Device at {ip_address} is online."
        else:
            return f"Device at {ip_address} is offline."
    except subprocess.TimeoutExpired:
        return f"Timeout: Device at {ip_address} did not respond."

if __name__ == "__main__":
    ip_address = "192.168.1.1"  # Replace with the IP address of the device you want to check
    status = check_device_status(ip_address)
    print(status)
