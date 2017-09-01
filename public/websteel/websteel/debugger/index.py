# -*- coding:utf-8 -*-  
import scrapy
from scrapy.http import Request
import datetime
import httplib, urllib
import json
import time
import pdb
import os
import re
import sys
# reload(sys)
# sys.setdefaultencoding( "utf-8" )

# def byteify(input):
#     if isinstance(input, dict):
#         return {byteify(key): byteify(value) for key, value in input.iteritems()}
#     elif isinstance(input, list):
#         return [byteify(element) for element in input]
#     elif isinstance(input, unicode):
#         return input.encode('utf-8')
#     else:
#         return input

# postData = json.load(open('./updateData.json', 'r'), encoding="UTF-8")
# msgDate = 123

# postParams = { "mydata" : [] }
# for data in postData:
#     postParams["mydata"].append({
#         "date": msgDate,
#         "product": data[0],
#         "type": data[1],
#         "material": data[2],
#         "brands": data[3],
#         "web_price": data[4],
#         "price_change": data[5],
#         "source_states": data[6]
#     })
# params = urllib.urlencode(postParams)
# # params = json.dumps(postParams)
# headers = {"Content-type": "application/x-www-form-urlencoded", "Accept": "text/plain", "charset": "UTF-8"}

# httpClient = httplib.HTTPConnection("www.gangerp.com", 80, timeout=30)
# httpClient.request("GET", "/api/updateCatchData")

# response = httpClient.getresponse()
# # print response.status
# # print response.reason
# print response.read()
# # print params

# fp = open("./debugger.html", 'w')
# fp.write(json.dumps(response.read(), ensure_ascii=False))

print time.mktime(time.strptime("2017-1-1 00:00:00",'%Y-%m-%d %H:%M:%S'))