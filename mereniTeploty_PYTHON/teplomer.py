#!/usr/bin/python
# -*- coding: utf-8 -*-

# bez definovani utf-8 nejde tisknout znak stupnu: "°"

'''
Created on 21.5.2013

@author: tuxmartin
'''

import serial, httplib, datetime, time


# # # # # # # # # # NASTAVENI # # # # # # # # # # 
webHeslo =          'heslo123'
frekvenceMereni =   60 # [s]
urlWeb =              'localhost'
portRS232 =         '/dev/ttyUSB0'
# # # # # # # # # # NASTAVENI # # # # # # # # # # 


# ---------------------------------------
def httpOdeslat(teplota, vlhkost):
    httpServ = httplib.HTTPConnection(urlWeb, 80)
    httpServ.connect()

    # pro TMEP:
    # http://localhost/martin/TMEP-6.1/app/index.php?tempV=+21.50&humV=50.45
    #httpServ.request('GET', '/martin/TMEP-6.1/app/index.php?tempV=' + teplota +'&humV=' + vlhkost)
    
    # http://localhost/martin/teplota/teplota.php?h=heslo123&t=20.90&v=50.50&d=23.02.2013_00.00.24
    httpServ.request('GET', '/app/teplota.php' +
                     '?h=' + webHeslo +
                     '&t=' + teplota +
                     '&v=' + vlhkost +
                     '&d=' + datetime.datetime.now().strftime('%d.%m.%Y_%H.%M.%S')                     
                     )

    response = httpServ.getresponse()
    if response.status == httplib.OK:
        #print "Output from HTTP request"
        #print response.read()
        pass

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
    if teplota != '' and vlhkost != '':
        print datetime.datetime.now().strftime('%d.%m.%Y %H:%M:%S') + " " + teplota + "°C " + vlhkost + "%"
        httpOdeslat(teplota, vlhkost)
# ---------------------------------------

ser = serial.Serial(
    port=portRS232,
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
                    
            response = ser.readline()
            #print("read data: " + response)
            if response != '':
                zpracujDataZPortu(response)       
                
            time.sleep(frekvenceMereni-1) # -1 kvuli potrebne dobe na zmereni a zpracovani hodnot)
### TODO: cas se postupne o 1s prodluzuje - opravit !!!!!!!!!!!!!!!!!!!            
    except Exception, e1:
        print "error communicating...: " + str(e1) 
    finally:
        ser.close()        
else:
    print "cannot open serial port "
