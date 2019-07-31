import pandas as pd 
import numpy as np 

from bs4 import BeautifulSoup
import re

from seleniumrequests import Chrome
from selenium.webdriver.chrome.options import Options
from pandas import DataFrame

def openDriver():
    global driver
    options = Options()
    options.add_argument('--headless')
    options.add_argument('--no-sandbox')
    options.add_argument('--incognito')
    driver = Chrome(chrome_options=options)

openDriver()


df = pd.read_csv("champion_names.csv")
arr = np.array(df)
champion_names = [x[0].lower() for x in arr]
champion_names.insert(0, 'Aatrox')

roles = ('top', 'jungle', 'middle', 'adc', 'support')

def get_stats(soup):
    win_rate = soup.find_all('div', {'class': 'win-rate okay-tier'})
    win_rate = [x.find_all('div', {'class': "value"}) for x in win_rate]
    win_rate = [str(x).split(">")[1].split('<')[0] for x in win_rate]  

    pick = soup.find_all('div', {'class': 'pick-rate'})
    pick = [x.find_all('div', {'class': "value"}) for x in pick]
    pick = [str(x).split(">")[1].split('<')[0] for x in pick]  

    ban = soup.find_all('div', {'class': 'ban-rate'})
    ban = [x.find_all('div', {'class': "value"}) for x in ban]
    ban = [str(x).split(">")[1].split('<')[0] for x in ban]  

    matches = soup.find_all('div', {'class': 'matches'})
    matches = [x.find_all('div', {'class': "value"}) for x in matches]
    matches = str(matches[0][0]).split('>')[1].split('<')[0] 

    return  [win_rate[0], pick[0], ban[0], matches]    

#to_save = []
#
#for name in champion_names:
#    for role in roles:
#        url = "https://u.gg/lol/champions/" + name + "/build?role=" + role + "&rank=overall"
#        driver.get(url)
#        html_source = driver.page_source
#        soup = BeautifulSoup(html_source)
#        stats = get_stats(soup)
#        stats.insert(0, name)
#        to_save.append(stats)

champion_stats = {'Name': [], 'Win rate':[], 'Pick rate':[], 'Ban rate': [], 'Role':[]}    

for champion_name in champion_names:
    for role in roles:
        print(champion_name)
        print(role)
        url = "https://u.gg/lol/champions/"+champion_name.lower()+"/build?rank=overall&role="+role
        driver.get(url)
        stats = driver.find_elements_by_class_name("value")
        champion_stats['Name'].append(champion_name.lower())
        champion_stats['Win rate'].append(stats[0].text)
        champion_stats['Pick rate'].append(stats[2].text)
        champion_stats['Ban rate'].append(stats[3].text)
        champion_stats['Role'].append(role)
        print(stats[0].text)
        print(stats[2].text)
        print(stats[3].text)

DF = DataFrame(champion_stats, columns=['Name', 'Win rate', 'Pick rate', 'Ban rate', 'Role'])
DF.to_csv('single_champion_stats.csv', index=False, header=True)

        
        
        
