from scrape import scrape
import requests
import json
import sys

def load_json():
    return json.load(open('bib.json', 'r'))

def write_json(bib):
    with open('bib.json', 'w') as outfile:  
        json.dump(bib, outfile)

def new_user(username, password): # nu
    bib = load_json()
    if username in bib:
        print(0)
        return False
    else:
        bib.update({username: {}})
        bib[username].update({'password': password})
        write_json(bib)
        print(1)
        return True

def login(username, password): # nu
    bib = load_json()
    if username in bib:
        if bib[username]['password'] == password:
            print(1)
            return True
        else:
            print(0)
            return False
    else:
        print(0)
        return False

def new_bib(username, bib_name): # nb
    bib = load_json()
    try:
        if bib_name in bib[username]:
            print(0)
            return False
        else:
            bib[username].update({bib_name: {}})
            write_json(bib)
            print(1)
            return True
    except KeyError:
        print(0)
        return False

def delete_bib(username, bib_name): # db
    bib = load_json()
    try:
        bib[username].pop(bib_name)
        write_json(bib)
        return True
    except KeyError:
        return False

def new_entry(username, bib_name, url): # ne
    bib = load_json()

    try:
        page = requests.get(url)
    except requests.exceptions.MissingSchema:
        return False

    title, flag_author, surname, firstname, flag_sitename, sitename, flag_datetime, datetime, accessed, url = scrape(url, page)

    if surname:
        try:
            index = surname[0] + firstname[0]
        except IndexError:
            index = surname[0]
    else:
        index = title

    try:
        if index in bib[username][bib_name]:
            return False
        bib[username][bib_name].update({
            index: {
                'title': title,
                'flag_author': flag_author,
                'surname': surname,
                'firstname': firstname,
                'flag_sitename': flag_sitename,
                'sitename': sitename,
                'flag_datetime': flag_datetime,
                'datetime': datetime,
                'accessed': accessed,
                'url': url,
            }
        })
        write_json(bib)
        return True
    except KeyError:
        return False

def falsify(string):
    if string == 'false' or string == '':
        return False
    else:
        return True

def update_entry(username, bib_name, index_original, title, flag_author, surname, firstname, flag_sitename, sitename, flag_datetime, datetime, accessed, url): # ue
    bib = load_json()
    surname = surname.split(',')
    firstname = firstname.split(',')

    flag_author = falsify(flag_author)
    flag_sitename = falsify(flag_sitename)
    flag_datetime = falsify(flag_datetime)

    try:
        if not index_original in bib[username][bib_name]:
            return False

        if surname and surname[0] != '':
            index = surname[0]
        else:
            index = title

        if index_original != index:
            bib[username][bib_name].pop(index_original)

        bib[username][bib_name].update({
            index: {
                'title': title,
                'flag_author': flag_author,
                'surname': surname,
                'firstname': firstname,
                'flag_sitename': flag_sitename,
                'sitename': sitename,
                'flag_datetime': flag_datetime,
                'datetime': datetime,
                'accessed': accessed,
                'url': url,
            }
        })
        write_json(bib)
        return True
    except KeyError:
        return False

def delete_entry(username, bib_name, index): # de
    bib = load_json()
    try:
        bib[username][bib_name].pop(index)
        write_json(bib)
        return True
    except KeyError:
        return False


msg = sys.argv[1]
arg = sys.argv[2:]

if msg == 'nu':
    new_user(arg[0], arg[1])
elif msg == 'login':
    login(arg[0], arg[1])
elif msg == 'nb':
    new_bib(arg[0], arg[1])
elif msg == 'db':
    delete_bib(arg[0], arg[1])
elif msg == 'ne':
    new_entry(arg[0], arg[1], arg[2])
elif msg == 'ue':
    update_entry(arg[0], arg[1], arg[2], arg[3], arg[4], arg[5], arg[6], arg[7], arg[8], arg[9], arg[10], arg[11], arg[12])
elif msg == 'de':
    delete_entry(arg[0], arg[1], arg[2])