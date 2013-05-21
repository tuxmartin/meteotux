#!/usr/bin/python
# -*- coding: utf-8 -*-
# bez definovani utf-8 nejde tisknout znak stupnu: "°"

'''
Created on 21.5.2013

@author: tuxmartin
'''

import serial, httplib
from time import gmtime, strftime, sleep

# ---------------------------------------
def httpOdeslat(teplota, vlhkost):
    httpServ = httplib.HTTPConnection("localhost", 80)
    httpServ.connect()

    # http://localhost/martin/TMEP-6.1/app/index.php?tempV=+21.50&humV=50.45
    httpServ.request('GET', '/martin/TMEP-6.1/app/index.php?tempV=' + teplota +'&humV=' + vlhkost)

    response = httpServ.getresponse()
    if response.status == httplib.OK:
        #print "Output from HTTP request"
        print  response.read()

    httpServ.close()
 # ---------------------------------------
 
    
 # ---------------------------------------   
def zpracujDataZPortu(text):
    text = text.replace('C', '')
    text = text.replace('%', '')
    text = text.replace('\r\n', '')    
    
    textRozdeleno = text.split(' ')
    teplota = textRozdeleno[0]
    vlhkost = textRozdeleno[1]
    print strftime("%d.%m.%Y %H:%M:%S", gmtime()) + " " + teplota + "°C " + vlhkost + "%"
    httpOdeslat(teplota, vlhkost)
# ---------------------------------------

ser = serial.Serial(
    port='/dev/ttyUSB0',
    baudrate=9600,
    parity=serial.PARITY_NONE,
    stopbits=serial.STOPBITS_ONE,
    bytesize=serial.EIGHTBITS
)

ser.timeout = 7		#arduino posila data kazdych 5s
#timeout = None: wait forever
#timeout = 0: non-blocking mode (return immediately on read)
#timeout = x: set timeout to x seconds (float allowed

ser.writeTimeout = 2

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
            
            #time.sleep(0.5)     #give the serial port sometime to receive the data
        
            response = ser.readline()
            #print("read data: " + response)
            if response != '':
                zpracujDataZPortu(response)       
        
    except Exception, e1:
        print "error communicating...: " + str(e1) 
    finally:
        ser.close()        
else:
    print "cannot open serial port "
