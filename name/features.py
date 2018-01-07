# Identifies features of a string

# Import all data
import csv

def csv2list(filename):
    with open(filename, 'r', encoding='utf-8', newline='') as f:
        reader = csv.reader(f)
        csvlist = list(reader)
        csvlist.pop(0)
        return csvlist

first = csv2list('data/first.csv')
last = csv2list('data/last.csv')
common = csv2list('data/common.csv')


# Appearance of word in a list

def appearance(words, listname):
    count = 0
    for word in words:
        for element in listname:
            if element[0] == word.lower():
                count += 1
    return count

def identify(string):
    # Numbers, Alphabets, First, Last, Common, Length, Capitalised
    words = string.split()
    array = [0, 0, 0, 0, 0, 0, 0]

    for word in words:
        if word.isdigit():
            array[0] += 1
        if word.isalpha():
            array[1] += 1
        if word.istitle():
            array[6] += 1

    array[2] = appearance(words, first)
    array[3] = appearance(words, last)
    array[4] = appearance(words, common)
    array[5] = len(words)

    return array