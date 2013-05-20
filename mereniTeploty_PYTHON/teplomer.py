#!/usr/bin/python

'''
Created on 21.5.2013

@author: tuxmartin
'''

import serial, time, httplib

# ---------------------------------------
def httpOdeslat(teplota, vlhkost):
    httpServ = httplib.HTTPConnection("localhost", 80)
    httpServ.connect()

    # http://localhost/martin/TMEP-6.1/app/index.php?tempV=+21.50&humV=50.45
    httpServ.request('GET', '/martin/TMEP-6.1/app/index.php?tempV=' + teplota +'&humV=' + vlhkost)

    response = httpServ.getresponse()
    if response.status == httplib.OK:
        print "Output from HTTP request"
        print  response.read()

    httpServ.close()
 # ---------------------------------------
 
    
 # ---------------------------------------   
def zpracujDataZPortu(text):
    '''
    nacteno = nacteno.replace("C", "");
    nacteno = nacteno.replace("%", "");                    
    String[] namereneHodnoty = nacteno.split(" "); // index 0 = teplota, index 1 = vlhkost
    teplota = namereneHodnoty[0];
    vlhkost = namereneHodnoty[1];
    '''
    text = text.replace('C', '')
    text = text.replace('%', '')
    
    textRozdeleno = text.split(' ')
    teplota = textRozdeleno[0]
    vlhkost = textRozdeleno[1]
    httpOdeslat(teplota, vlhkost)
# ---------------------------------------

ser = serial.Serial(
    port='/dev/ttyUSB0',
    baudrate=9600,
    parity=serial.PARITY_NONE,
    stopbits=serial.STOPBITS_ONE,
    bytesize=serial.EIGHTBITS
)

ser.timeout = 1		#non-block read
#ser.timeout = 2	#timeout block read

ser.writeTimeout = 2     #timeout for write

try: 
    ser.open()
except Exception, e:
    print "error open serial port: " + str(e)
    exit()
    
    
if ser.isOpen():
    try:
        while True:
            ser.flushInput()    #flush input buffer, discarding all its contents            
            ser.flushOutput()   #flush output buffer, aborting current output 
        
            time.sleep(0.5)     #give the serial port sometime to receive the data
        
            response = ser.readline()
            print("read data: " + response)
            zpracujDataZPortu(response)       
        
    except Exception, e1:
        print "error communicating...: " + str(e1) 
    finally:
        ser.close()        
else:
    print "cannot open serial port "

