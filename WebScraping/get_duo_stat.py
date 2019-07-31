# -*- coding: utf-8 -*-
"""
Created on Thu Jul  4 18:18:14 2019

@author: yliu258
"""

from bs4 import BeautifulSoup
import re
import numpy as np

from seleniumrequests import Chrome
from selenium.webdriver.chrome.options import Options

def openDriver():
    global driver
    options = Options()
    options.add_argument('--headless')
    options.add_argument('--no-sandbox')
    options.add_argument('--incognito')
    driver = Chrome(chrome_options=options)

openDriver()

header1 = 'adc, support, winrate, synergy, pick, ban, matches'
header2 = 'middle, jungle, winrate, synergy, pick, ban, matches'
header3 = 'top, jungle, winrate, synergy, pick, ban, matches'
header = [header1, header2, header3]

filename = ['adc_support', 'middle_jungle', 'top_jungle']
duo_config = ['', '&duo=middle_jungle', '&duo=top_jungle']

# read from local html files
"""
f = open("adc_support.html", 'r')
contents = f.read()
f.close()
soup = BeautifulSoup(contents)
"""

url_base = "https://u.gg/lol/duo-tier-list/?rank=overall"

for ind in range(len(duo_config)):
    url = url_base + duo_config[ind]
    driver.get(url)
    html_source = driver.page_source
    soup = BeautifulSoup(html_source)
    
    champions = soup.find_all('strong', {'class': 'champion-name'})
    win_rate = soup.find_all('div', {'class': 'rt-td winrate'})
    pick_rate = soup.find_all('div', {'class': 'rt-td pickrate'})
    ban_rate = soup.find_all('div', {'class': 'rt-td banrate'})
    synergy_match = soup.find_all(lambda tag: tag.name == 'div' and tag.get('class')== 
                            ['rt-td'])
    
    champion1 = champions[::2]
    champion2 = champions[1::2]
    synergy = synergy_match[1::3]
    match = synergy_match[2::3]
    
    champion1 = [str(x).split(">")[1].split("</")[0] for x in champion1]
    champion2 = [str(x).split(">")[1].split("</")[0] for x in champion2]
    synergy = [str(x).split("<span>")[1].split("</span>")[0] for x in synergy]
    win_rate = [str(x).split("<b>")[1].split("</b>")[0] for x in win_rate]
    pick_rate = [str(x).split("<span>")[1].split("</span>")[0] for x in pick_rate]
    ban_rate = [str(x).split("<span>")[1].split("</span>")[0] for x in ban_rate]
    match = [str(x).split("<span>")[1].split("</span>")[0].replace(',','')   for x in match]
    
    to_save = list(zip(champion1, champion2, win_rate, synergy, pick_rate, ban_rate, match))

    np.savetxt(filename[ind]+'.csv', to_save, delimiter=',', fmt='%s', header = header[ind])