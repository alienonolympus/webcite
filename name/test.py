from name.features import identify
from sklearn.linear_model import LogisticRegression
from sklearn.externals import joblib

import numpy as np

filename = 'name/lr_model.sav'
logistic = joblib.load(filename)

def name_prob(string):
    return logistic.predict_proba(np.array(identify(string)).reshape(1, -1))[0][1]