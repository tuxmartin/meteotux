#!/bin/sh

# cd /tmp || exit
# if the first command succeed the second will never be executed
# If the exit status of the first command (cd /tmp) is not 0, then execute the second command (exit).
# It's the opposite of '&&', where the second command is executed only if the exit status of the preceding command is 0.

sleep 30

while true; do                                   
  ping -c 4 www.google.com || reboot
  sleep 30
done
  
    
#KE SPUSTENI: /bin/sh /etc/config/watchdog.sh >> /dev/null 2>&1 &




