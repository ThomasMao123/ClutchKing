from bs4 import BeautifulSoup
import urllib3
from seleniumrequests import Chrome
from selenium.webdriver.chrome.options import Options

#https = urllib3.PoolManager()
#
#url = "https://u.gg/lol/champions/xayah/matchups?allChampions=true&rank=overall"
#
#content = https.request('GET', url)
#
#soup = BeautifulSoup(content.data, 'lxml')
#
##for i in soup.find_all(class='rt-tr-group'):
##    print(i)
##    
#    
##print(soup.findAll('div', {'class': 'rt-tr-group'}))
##
##for i in soup.findAll("div", {'class': 'rt-tr-group'}):
##    print(i)
#print(soup.prettify())

def openDriver():
    global driver
    options = Options()
    options.add_argument('--headless')
    options.add_argument('--no-sandbox')
    options.add_argument('--incognito')
    driver = Chrome(chrome_options=options)
    
openDriver()
driver.get("https://u.gg/lol/champions/xayah/matchups?allChampions=true&rank=overall")
for i in driver.find_elements_by_class_name('rt-tr-group'):
    print(i.text)
    
