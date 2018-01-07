import re
import sys
import requests
from bs4 import BeautifulSoup

page = requests.get('http://edition.cnn.com/2017/12/25/europe/meghan-markle-prince-harry-christmas-intl/index.html')
soup = BeautifulSoup(page.content, 'html.parser')

