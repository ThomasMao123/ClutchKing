import numpy as np
import json
import sys
import mysql.connector
from sklearn.neighbors import KDTree

target_champion_name = sys.argv[-1]

mydb = mysql.connector.connect(
    host="localhost",
    user="clutchkingtest_root",
    passwd="clutchking.gg",
    database="clutchkingtest_users"
)

mycursor = mydb.cursor()
mycursor.execute("SELECT * FROM match_up_stats_new")
myresult = mycursor.fetchall()
champion_names = []
winrate_list = []

for x in myresult:
    x = tuple('50.0' if val == '' else val for val in x)
    champion_names.append(x[0])
    winrate_list.append(np.asarray(x[1:], dtype = np.float))
    
winrate_matrix = np.asarray(winrate_list)
target_champion_index = champion_names.index(target_champion_name)
tree = KDTree(winrate_matrix, leaf_size=2)              
dist, ind = tree.query(winrate_matrix[target_champion_index,:].reshape(1,-1), k=3)
nearest_neighbor_ind = ind[0]
nearest_neighbor_names = [champion_names[x] for x in nearest_neighbor_ind]
print(nearest_neighbor_names[1:])