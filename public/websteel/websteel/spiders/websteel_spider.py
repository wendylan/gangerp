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
reload(sys)
sys.setdefaultencoding( "utf-8" )

class WebsteelSpider(scrapy.Spider):
    name = "websteel"
    start_urls = []
    basePath = []
    mysteelFirstUrl = ['http://list1.mysteel.com/market/p-228-15584-----0--------1.html']
    cookies = {
        'jiathis_rdc' : '%7B%22http%3A//jiancai.mysteel.com/m/16/1222/17/80734C303C2E7712.html%22%3A956536671%2C%22http%3A//jiancai.mysteel.com/m/16/1223/17/1BB9D79D20C67B77.html%22%3A969772758%2C%22http%3A//jiancai.mysteel.com/m/16/1226/12/ACE073DD0C9EFD6E.html%22%3A969964055%2C%22http%3A//jiancai.mysteel.com/m/16/1226/17/815CE8D04BDEFF42.html%22%3A%220%7C1482748673240%22%7D',
        '_login_token' : '04240bb92ef688f24ed27dbf63d7b7b9',
        '_login_uid' : '1588068',
        '_login_mid' : '2432493',
        '_last_loginuname' : 'gwgylgl',
        '04240bb92ef688f24ed27dbf63d7b7b9' : '1%3D10',
        'Hm_lvt_1c4432afacfa2301369a5625795031b8' : '1482284951,1482484657,1482719826',
        'Hm_lpvt_1c4432afacfa2301369a5625795031b8' : '1482748705'
    }
    msgDate = None
    webPathData = None

    # 爬取结束 添加更新path列表
    diskWebDataPath = None
    newPath = None

    def __init__(self):
        # 更新数据路径
        self.start_urls = self.mysteelFirstUrl

    def parse(self, response):
        webPathData = []
        _webDataDate = []

        for sel in response.css('ul.nlist li'):
            webPathData.append({
                "path" : ''.join(sel.xpath('a/@href').extract()),
                "date" : ''.join(sel.xpath('span/text()').extract())
            })
            _webDataDate.append(''.join(sel.xpath('span/text()').extract()))
        self.webPathData = webPathData

        # 将Basic路径文件存入
        # fp = open('./catchData/basePath.json', 'w')
        # fp.write(json.dumps(webPathData))

        # 获取本地存储上次的路径数据
        diskWebPathData = []
        basicPath = json.load(open('/home/wwwroot/www.gangerp.com/public/websteel/websteel/catchData/basePath.json', 'r'))
        self.diskWebDataPath = basicPath
        for data in basicPath:
            diskWebPathData.append(data["date"]);


        # 判断更新数据的日期是否今天
        diffData = list(set(_webDataDate).difference(set(diskWebPathData)))
        print '------------------------ Diff Time ----------------------------'
        print diffData
        if len(diffData) != 0:
            dateHandle = datetime.datetime.now()
            nowDate = dateHandle.strftime('%Y-%m-%d')
            webDate = diffData[0].split(' ');
            webDate = webDate[0]

            # print response.css("div.info").extract()
            print nowDate+"___________"+webDate
            # if(nowDate == webDate):
            #     if(webPathData[0]["date"].find(nowDate) != -1):
            #         print webPathData[0]
            self.msgDate = diffData[0]
            self.downloadCount = 1;
            for _webPathData in webPathData:
                if _webPathData['date'] == diffData[0]:
                    self.newPath = _webPathData;
                    print self.newPath
                    yield Request(_webPathData["path"], cookies=self.cookies, callback=self.updateData)
                    break;

        else:
            print "Data was noting change..."


    def start_requests(self):
        for path in self.start_urls:
            yield Request(path, cookies=self.cookies, callback=self.parse)


    def updateData(self, response):
        # 获取table里面的网价数据
        steelPriceDatas = []
        print "--------------------Catch Success--------------------------"
        tableData = response.css("table#marketTable tr")
        for data in tableData:
            lineData = data.css("td::text").extract()
            steelPriceDatas.append(lineData)

        # 去除非必要数据的行
        count = 0
        while count<len(steelPriceDatas):
            if( len(steelPriceDatas[count])!=7 or steelPriceDatas[count][0].find(u"高线")<0 and steelPriceDatas[count][0].find(u"盘螺")<0 and steelPriceDatas[count][0].find(u"螺纹钢")<0 ):
                del steelPriceDatas[count]
            else:
                count += 1

        # 拆分规格的范围
        rex = "\d*-\d*"
        apartDatas = [];
        sleetFormat = json.load(open('./spiders/steel.json', 'r'))
        for data in steelPriceDatas:
            if(re.search(rex, data[1]) != None):
                # apartDatas.append(data)
                rangeNum =  re.search(rex, data[1]).group(0).split('-');
                steelName = data[0]
                rangeNumStart = int(rangeNum[0])
                rangeNumEnd = int(rangeNum[1])
                for _data in sleetFormat:
                    if( steelName.find(_data["name"]) != -1 ):
                        for steelSizes in _data["datas"]:
                            if(steelSizes>=rangeNumStart and steelSizes<=rangeNumEnd):
                                apartDatas.append([steelName, steelSizes, data[2], data[3], data[4], data[5], data[6]])
                        break;

        # 修正经过更变后的价格
        for data in apartDatas:
            if(data[6].find(':') != -1):
                changeSize = data[6].split(';')
                for _data in changeSize:
                    size = _data.split(':')
                    _size = filter(lambda ch: ch in '0123456789', size[0])
                    _price = int(size[1])
                    if( int(data[1]) == int(_size) ):
                        data[4] = _price

        # 整合拆分前和拆分后的数据
        count = 0
        while count<len(steelPriceDatas):
            if(steelPriceDatas[count][1].find('-') != -1):
                del steelPriceDatas[count]
            else:
                steelPriceDatas[count][1] = steelPriceDatas[count][1].replace('Ф', "")
                count += 1

        for data in steelPriceDatas:
            apartDatas.append(data);

        os.remove("./catchData/updateData.json")
        fp = open("./catchData/updateData.json", 'w')
        fp.write(json.dumps(apartDatas, ensure_ascii=False).replace("\\t","").replace("\\r","").replace("\\n",""))
        fp.close()

        # 触发web服务器控制器
        self.postDataToLarvel(apartDatas)

        # 更新Basic路径
        self.diskWebDataPath.append(self.newPath)
        fp = open('/home/wwwroot/www.gangerp.com/public/websteel/websteel/catchData/basePath.json', 'w')
        fp.write(json.dumps(self.diskWebDataPath))
        fp.close()


    def postDataToLarvel(self, postData):
        infoTime = time.mktime(time.strptime(self.msgDate,'%Y-%m-%d %H:%M'))
        print infoTime
        httpClient = httplib.HTTPConnection("www.gangerp.com", 80, timeout=30)
        httpClient.request("GET", "/api/updateCatchData?time="+str(int(infoTime)))

        response = httpClient.getresponse()
        # print response.status
        # print response.reason
        print response.read()

        fp = open("./catchData/debugger.html", 'w')
        fp.write(json.dumps(response.read(), ensure_ascii=False))
        fp.close()

    def closed(self, reason):
        print 'Ready for end ......'
        # time.sleep(5)
        # os.system('cmd.exe scrapy crawl mysteel')
