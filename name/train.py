# Training a logistic regression classifier to recognise if a string is a nem

from features import identify, csv2list
from sklearn.linear_model import LogisticRegression
from sklearn.externals import joblib

import numpy as np

training = csv2list('data/training.csv')
results = csv2list('data/results.csv')

y = [int(result[0]) for result in results]

for i in range(len(training)):
    if len(training[i]) == 0:
        training[i].append(' ')

X = [identify(data[0]) for data in training]

logistic = LogisticRegression()
logistic.fit(X, y)

filename = 'name/lr_model.sav'
joblib.dump(logistic, filename)