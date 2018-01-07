#  Scrapes webpage for contents

# Import necessary libraries
import re
import sys
from bs4 import BeautifulSoup
from datetime import date
import arrow

from name.test import name_prob

# Returns [title, flag_author, surname, firstname, flag_sitename, sitename, flag_datetime, datetime, accessed, url]

def scrape(url, page):

    # Soup & Data

    soup = BeautifulSoup(page.content, 'html.parser')
    data = soup.findAll(text = True)

    # Title

    title = soup.find('title').get_text().strip()

    # Author - Firstname and Surname

    authors = soup.find_all('meta', attrs={'name':'author'})
    flag_author = False

    def visible(element): # Retrieve all links (most author names are in links)
        if element.parent.name in ['a']:
            return True

    def if_no_author(): # When no author is explicitly stated in a meta tag
        text = list(filter(visible, data))

        possible_names = []

        for name in text:
            if 2 <= len(name.split()) <= 4:
                possible_names.append(name)

        author_name = ''
        probability = 0

        for name in possible_names:
            name_probability = name_prob(name)
            value = name_probability * possible_names.count(name)

            if (value > probability) & (name_probability > 0.6):
                author_name = name
                probability = value

        return author_name

    if authors:
        authors = [author['content'] for author in authors]
    else:
        authors = [if_no_author()]
        flag_author = True

    surname = []
    firstname = []

    if authors != ['']:
        author_split = [author.split() for author in authors]
        surname = [author.pop() for author in author_split]
        firstname = [' '.join(author) for author in author_split]

    # Publishing Organisation or Website Name

    sitename = soup.find('meta', attrs={'property':'og:site_name'})
    flag_sitename = False

    if sitename:
        sitename = sitename['content']
    else:
        sitename = ''
        flag_sitename = True

    # Last Modified Date 

    datetime = ''
    flag_datetime = False

    try:
        date_modified = soup.find(itemprop='dateModified')['content']
        datetime = arrow.get(date_modified).datetime.date().strftime('%b %d, %Y')
    except KeyError:
        try:
            date_modified = soup.find(itemprop='dateModified')['datetime']
            datetime = arrow.get(date_modified).datetime.date().strftime('%b %d, %Y')
        except KeyError:
            flag_datetime = True
    except TypeError:
        flag_datetime = True

    # Access Date (Assumed to be today)

    accessed = date.today().strftime('%b %d, %Y').replace(" 0", " ")


    return [title, flag_author, surname, firstname, flag_sitename, sitename, flag_datetime, datetime, accessed, url]
