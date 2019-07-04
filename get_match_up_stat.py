
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
header = 'name, winrate, gold, xp, kills, cs, jungle, matches'

def get_names(bs_tag):
    tmp = str(bs_tag)
    tmp_ = tmp.split('strong>')
    return tmp_[1][:-2]

def get_winRate(bs_tag):
    tmp = str(bs_tag)
    tmp_ = tmp.split('<b>')
    tmp__ = tmp_[1].split('%')
    return tmp__[0]

def get_columns(bs_tag):
    
    tag2string = str(bs_tag)
    string_splitted = tag2string.split('rt-td')
    
    name = get_names(bs_tag)
    winrate = get_winRate(bs_tag)    
    gold = string_splitted[4].split('</div')[0].split('>')[-1]
    xp = string_splitted[5].split('</div')[0].split('>')[-1]
    kills = string_splitted[6].split('<span>')[1].split('</span>')[0]
    cs = string_splitted[7].split('<span>')[1].split('</span>')[0]
    jungle = string_splitted[8].split('<span>')[1].split('</span>')[0]
    matches = string_splitted[9].split('<span>')[1].split('</span>')[0].replace(',','')    
    return [name, winrate, gold, xp, kills, cs, jungle, matches]

def get_all_names():
    
    url0 = "https://u.gg/lol/champions"
    driver.get(url0)
    html_source0 = driver.page_source
    soup0 = BeautifulSoup(html_source0)    
    match_up_names = soup0.find_all('div', {'class' : 'champion-name'})
    name_list = [get_names(X) for X in match_up_names]
    return name_list
    
def save_csv(champion_name):
    url = "https://u.gg/lol/champions/"+champion_name+"/matchups?allChampions=true&rank=overall"
    
    driver.get(url)
    html_source = driver.page_source
    soup = BeautifulSoup(html_source)
    
    odd_rows = soup.find_all('div', {'class' : 'rt-tr -odd'})
    even_rows = soup.find_all('div', {'class' : 'rt-tr -even'})
    
    stat_list_odd = [get_columns(X) for X in odd_rows]    
    stat_list_even = [get_columns(X) for X in even_rows]    
        
    array_odd = np.asarray(stat_list_odd)
    array_even = np.asarray(stat_list_even)
    
    array_save = np.concatenate((array_odd, array_even), axis = 0)
    np.savetxt(champion_name+'.csv', array_save, delimiter=',', fmt='%s', header = header)
    time.sleep(2)
    return


champion_name_list = get_all_names()

import time
for champion_name in champion_name_list:
    save_csv(champion_name)
    time.sleep(5)

