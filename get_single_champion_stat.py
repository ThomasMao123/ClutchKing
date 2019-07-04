import pandas as pd 
import numpy as np 

df = pd.read_csv("champion_names.csv")
arr = np.array(df)
champion_names = [x[0] for x in arr]

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

url = " "
driver.get(url)
html_source = driver.page_source
soup = BeautifulSoup(html_source)
stats = get_stats(soup)
