# -*- coding: utf-8 -*-
"""
Created on Thu Jul 25 19:20:18 2019

@author: 13015
"""
import sys
import mysql.connector
import kdtree

tier_to_int = {"IRON":50, "BRONZE":100, "SILVER":150, "GOLD":200, "PLATINUM":250, "DIAMOND":300, "MASTER":350, "GRANDMASTER":400, "CHALLENGER":450}
rank_to_int = {"IV":20, "III":40, "II":60, "I":80}
int_to_tier = {"50": "IRON", "100": "BRONZE", "150": "SILVER", "200": "GOLD", "250": "PLATINUM", "300": "DIAMOND", "350": "MASTER", "400": "GRANDMASTER", "450": "CHALLENGER"}
int_to_rank = {"20": "IV", "40": "III", "60": "II", "80": "I"}
output =""

target_summoner_name = sys.argv[-1]

def to_int_list(summoner):
    ret = []
    ret.append(tier_to_int[summoner[1]])
    ret.append(summoner[2])
    ret.append(summoner[3])
    ret.append(rank_to_int[summoner[4]])
    test = summoner[2] + summoner[3]
    return ret
def to_original_list(summoner_stats):
    ret = []
    if summoner_stats[0] == 50:
        ret.append("IRON")
    elif summoner_stats[0] == 100:
        ret.append("BRONZE")
    elif summoner_stats[0] == 150:
        ret.append("SILVER")
    elif summoner_stats[0] == 200:
        ret.append("GOLD")
    elif summoner_stats[0] == 250:
        ret.append("PLATINUM")
    elif summoner_stats[0] == 300:
        ret.append("DIAMOND")
    elif summoner_stats[0] == 350:
        ret.append("MASTER")
    elif summoner_stats[0] == 400:
        ret.append("GRANDMASTER")
    else:
        ret.append("CHALLENGER")
        
    ret.append(summoner_stats[1])
    ret.append(summoner_stats[2])
    
    if summoner_stats[3] == 20:
        ret.append("IV")
    elif summoner_stats[3] == 40:
        ret.append("III")
    elif summoner_stats[3] == 60:
        ret.append("II")
    else:
        ret.append("I")
        
    return ret
mydb = mysql.connector.connect(
    host="localhost",
    user="clutchkingtest_root",
    passwd="clutchking.gg",
    database="clutchkingtest_users"
)

mycursor = mydb.cursor()

sql = "SELECT * FROM summoner_stats WHERE NOT SummonerName='" + target_summoner_name +"'"
mycursor.execute(sql)
possible_teammates = mycursor.fetchall()
list_of_points=[]
for i in possible_teammates:
    list_of_points.append(to_int_list(i))
    

sql = "SELECT * FROM summoner_stats WHERE SummonerName='" + target_summoner_name +"'"
mycursor.execute(sql)
res = mycursor.fetchall()

target_summoner_stats_org = res[0]
target_summoner_stats = to_int_list(res[0])

tree = kdtree.create(point_list=list_of_points, dimension=4, axis=0)

best_teammate = kdtree.findNearestNeighbor(query=target_summoner_stats, current=tree, currentDim=0)
best_teammate_origin = to_original_list(best_teammate)

sql = "SELECT * FROM summoner_stats WHERE Tier='" + best_teammate_origin[0] + "' AND Wins=" + str(best_teammate_origin[1]) + " AND Losses=" + str(best_teammate_origin[2]) + " AND RANK='" + best_teammate_origin[3] + "';"

mycursor.execute(sql)
res = mycursor.fetchall()
print("Best match among all players:")
print("Name: " + res[0][0])
print("Tier: " + res[0][1])
print("Wins: " + str(res[0][2]))
print("Losses: " + str(res[0][3]))
print("Rank: " + res[0][4])
print("")

sql = "SELECT * FROM summoner_stats WHERE Tier='" + target_summoner_stats_org[1] + "';"

mycursor.execute(sql)
possible_teammates_same_rank = mycursor.fetchall()

list_of_points_same_rank = []
for i in possible_teammates_same_rank:
    list_of_points_same_rank.append(to_int_list(i))
    
tree_same_rank = kdtree.create(point_list=list_of_points_same_rank, dimension=4, axis=0)
best_teammate_same_rank = kdtree.findNearestNeighbor(query=target_summoner_stats, current=tree_same_rank, currentDim=0)
best_teammate_same_rank_origin = to_original_list(best_teammate_same_rank)

sql = "SELECT * FROM summoner_stats WHERE Tier='" + best_teammate_same_rank_origin[0] + "' AND Wins=" + str(best_teammate_same_rank_origin[1]) + " AND Losses=" + str(best_teammate_same_rank_origin[2]) + " AND RANK='" + best_teammate_same_rank_origin[3] + "';"
mycursor.execute(sql) 
res = mycursor.fetchall()
print("Best match in your tier:")
print("Name: " + res[0][0])
print("Tier: " + res[0][1])
print("Wins: " + str(res[0][2]))
print("Losses: " + str(res[0][3]))
print("Rank: " + res[0][4])
print("")

print("Best match in nearby tier:")
if target_summoner_stats_org[1] != "IRON":
    sql = "SELECT * FROM summoner_stats WHERE Tier='" + int_to_tier[str(tier_to_int[target_summoner_stats_org[1]] - 50)] + "';"
    
    mycursor.execute(sql)
    possible_teammates_lower_rank = mycursor.fetchall()
    
    if len(possible_teammates_lower_rank) != 0:
        list_of_points_lower_rank = []
        for i in possible_teammates_lower_rank:
            list_of_points_lower_rank.append(to_int_list(i))
            
        tree_lower_rank = kdtree.create(point_list=list_of_points_lower_rank, dimension=4, axis=0)
        best_teammate_lower_rank = kdtree.findNearestNeighbor(query=target_summoner_stats, current=tree_lower_rank, currentDim=0)
        
        best_teammate_lower_rank_origin = to_original_list(best_teammate_lower_rank)
    
        sql = "SELECT * FROM summoner_stats WHERE Tier='" + best_teammate_lower_rank_origin[0] + "' AND Wins=" + str(best_teammate_lower_rank_origin[1]) + " AND Losses=" + str(best_teammate_lower_rank_origin[2]) + " AND RANK='" + best_teammate_lower_rank_origin[3] + "';"
        mycursor.execute(sql) 
        res = mycursor.fetchall()
        
        print("Name: " + res[0][0])
        print("Tier: " + res[0][1])
        print("Wins: " + str(res[0][2]))
        print("Losses: " + str(res[0][3]))
        print("Rank: " + res[0][4])
        print("")


if target_summoner_stats_org[1] != "CHALLENGER":
    sql = "SELECT * FROM summoner_stats WHERE Tier ='" + int_to_tier[str(tier_to_int[target_summoner_stats_org[1]] + 50)] + "';"
    
    mycursor.execute(sql)
    possible_teammates_higher_rank = mycursor.fetchall()
    if len(possible_teammates_higher_rank) != 0:
        list_of_points_higher_rank = []
        for i in possible_teammates_higher_rank:
            list_of_points_higher_rank.append(to_int_list(i))
            
        tree_higher_rank = kdtree.create(point_list=list_of_points_higher_rank, dimension=4, axis=0)
        best_teammate_higher_rank = kdtree.findNearestNeighbor(query=target_summoner_stats, current=tree_higher_rank, currentDim=0)
        
        best_teammate_higher_rank_origin = to_original_list(best_teammate_higher_rank)
    
        sql = "SELECT * FROM summoner_stats WHERE Tier='" + best_teammate_higher_rank_origin[0] + "' AND Wins=" + str(best_teammate_higher_rank_origin[1]) + " AND Losses=" + str(best_teammate_higher_rank_origin[2]) + " AND RANK='" + best_teammate_higher_rank_origin[3] + "';"
        mycursor.execute(sql) 
        res = mycursor.fetchall()
        
        print("Name: " + res[0][0])
        print("Tier: " + res[0][1])
        print("Wins: " + str(res[0][2]))
        print("Losses: " + str(res[0][3]))
        print("Rank: " + res[0][4])
        print("")