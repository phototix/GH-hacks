import socket
import struct

def wake_on_lan(macaddress, ip_address='192.168.1.1'):
    """ Switches on remote computers using WOL. """

    # Check macaddress format and try to compensate.
    if len(macaddress) == 12:
        pass
    elif len(macaddress) == 12 + 5:
        sep = macaddress[2]
        macaddress = macaddress.replace(sep, '')
    else:
        raise ValueError('Incorrect MAC address format')

    # Pad the synchronization stream.
    data = b'FFFFFFFFFFFF' + (macaddress * 16).encode()
    send_data = b''

    # Split up the hex values and pack.
    for i in range(0, len(data), 2):
        send_data += struct.pack(b'B', int(data[i: i + 2], 16))

    # Broadcast it to the LAN.
    sock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
    sock.setsockopt(socket.SOL_SOCKET, socket.SO_BROADCAST, 1)
    sock.sendto(send_data, (ip_address, 9))

# Replace 'FFAAFFAAFFAA' with your target computer's MAC address.
wake_on_lan('FFAAFFAAFFAA')
