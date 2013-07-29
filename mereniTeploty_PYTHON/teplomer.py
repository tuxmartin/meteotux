#!/usr/bin/python
# -*- coding: utf-8 -*-

# bez definovani utf-8 nejde tisknout znak stupnu: "°"


'''
Created on 21.5.2013

@author: tuxmartin

'''

import serial, httplib, datetime, time, syslog
from threading import Thread


# # # # # # # # # # NASTAVENI # # # # # # # # # # 
webHeslo =          'sbTmdp12wS'
frekvenceMereni =   60 # [s]
urlWeb =            'pocasi.vancl.eu'
portRS232 =         '/dev/ttyS0'
# # # # # # # # # # NASTAVENI # # # # # # # # # # 

syslog.syslog('meteotux Teplomer spusten')
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
    text = text.replace('#015', '') 
    text = text.replace(chr(15), '') # http://mail.python.org/pipermail/python-win32/2005-April/003100.html
    
    textRozdeleno = text.split(' ')
    teplota = textRozdeleno[0]
    vlhkost = textRozdeleno[1]
    if teplota != '' and vlhkost != '':
	syslog.syslog("meteotux " + datetime.datetime.now().strftime('%d.%m.%Y %H:%M:%S') + " " + teplota + "C " + vlhkost + "%")
        print datetime.datetime.now().strftime('%d.%m.%Y %H:%M:%S') + " " + teplota + "C " + vlhkost + "%"
        httpOdeslat(teplota, vlhkost)
# ---------------------------------------
ser = serial.Serial(
    port=portRS232,
    baudrate=9600,
    parity=serial.PARITY_NONE,
    stopbits=serial.STOPBITS_ONE,
    bytesize=serial.EIGHTBITS
)

ser.timeout = None		#arduino posila data kazdych 5s
#timeout = None: wait forever
#timeout = 0: non-blocking mode (return immediately on read)
#timeout = x: set timeout to x seconds (float allowed

ser.writeTimeout = 9

try: 
    ser.open()
    ser.flushInput()
    ser.flushOutput()
except Exception, e:
    syslog.syslog("meteotux error open serial port: " + str(e))
    print "error open serial port: " + str(e)
    exit()

if ser.isOpen():
    try:
        while True:
            #http://stackoverflow.com/questions/7266558/pyserial-buffer-wont-flush :
            ser.flushInput()    #flush input buffer, discarding all its contents            
            ser.flushOutput()   #flush output buffer, aborting current output 
            time.sleep(0.1)	#100ms

            response = ser.readline()
            response.strip() # http://stackoverflow.com/questions/761804/trimming-a-string-in-python
            print("read data: " + response)
            syslog.syslog("meteotux RS-232 response: " + response )
            if response != '':           
                vlakno = Thread(target=zpracujDataZPortu, args=(response,))
                vlakno.start()       
#            ser.flushInput()
#            ser.flushOutput()

            time.sleep(frekvenceMereni)
    except Exception, e1:
        syslog.syslog("meteotux error communicating...: " + str(e1))
        print "error communicating...: " + str(e1) 
    finally:
        ser.close()        
else:
    syslog.syslog("meteotux cannot open serial port ")
    print "cannot open serial port "
    
