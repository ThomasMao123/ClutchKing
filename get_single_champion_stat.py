import pandas as pd 
import numpy as np 

df = pd.read_csv("champion_names.csv")
arr = np.array(df)
champion_names = [x[0] for x in arr]

roles = ('top', 'jungle', 'middle', 'adc', 'support')
