#!/usr/bin/python
# -*- coding: utf-8 -*-

import httplib

httpServ = httplib.HTTPConnection('pocasi.vancl.eu', 80)
httpServ.connect()

# http://pocasi.vancl.eu/index.php?pass=PYSbafdjjRE&tempV=11.22&humV=33.44

httpServ.request('GET', '/index.php' +
                 '?pass=PYSbafdjjRE' +
                 '&tempV=43.21' +
                 '&humV=56.78'
                )

response = httpServ.getresponse()
if response.status == httplib.OK:
	print "Output from HTTP request"
	print response.read()
	pass

httpServ.close()

