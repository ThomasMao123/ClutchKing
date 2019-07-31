import numpy as np
import json
import sys
import mysql.connector
import build_graph 

import pandas as pd
import os
import networkx as nx

def build_graph():
    # store the synergy information in the graph structure
    G = nx.Graph()
    # top jungle table
    df = pd.read_csv('/home/clutchkingtest/virtualenv/graph/top_jungle_new.csv')
    synergy_raw = df[' synergy'].tolist()
    synergy_list = [float(x.strip('%')) for x in synergy_raw]
    top_list = df['# top'].tolist()
    jungle_list = df[' jungle'].tolist()
    for top_node, jungle_node, synergy_score in zip(top_list, jungle_list, synergy_list):
        G.add_edge(top_node, jungle_node, weight=synergy_score)
    # middle jungle table
    df = pd.read_csv('/home/clutchkingtest/virtualenv/graph/middle_jungle_new.csv')
    synergy_raw = df[' synergy'].tolist()
    synergy_list = [float(x.strip('%')) for x in synergy_raw]
    middle_list = df['# middle'].tolist()
    jungle_list = df[' jungle'].tolist()
    for middle_node, jungle_node, synergy_score in zip(middle_list, jungle_list, synergy_list):
        G.add_edge(middle_node, jungle_node, weight=synergy_score)
    # adc support table
    df = pd.read_csv('/home/clutchkingtest/virtualenv/graph/adc_support_new.csv')
    synergy_raw = df[' synergy'].tolist()
    synergy_list = [float(x.strip('%')) for x in synergy_raw]
    adc_list = df['# adc'].tolist()
    support_list = df[' support'].tolist()
    for adc_node, support_node, synergy_score in zip(adc_list, support_list, synergy_list):
        G.add_edge(adc_node, support_node, weight=synergy_score)
    return G

start_champion_name = sys.argv[-1].lower()

if start_champion_name not in ['illaoi', 'ahri', 'vi', 'ashe', 'janna']:
    print('top  :', start_champion_name)
    print('jungle :  master yi')
    print('middle :  malzahar')
    print('adc :  caitlyn')
    print('support :  lux')
    sys.exit()


champion_list = []
role_list = []

mydb = mysql.connector.connect(
    host="localhost",
    user="clutchkingtest_root",
    passwd="clutchking.gg",
    database="clutchkingtest_users"
)

mycursor = mydb.cursor()
query = (   'SELECT name, role ' 
            'FROM single_champion_stats '
            'WHERE name=\'' + start_champion_name + '\' AND '
                            'winrate = (SELECT max(winrate) '
                            'FROM single_champion_stats as scs '
                            'WHERE scs.name=single_champion_stats.name) '
                            )
mycursor.execute(query)
user_selected_champion, best_role = mycursor.fetchall()[0]
champion_list.append(user_selected_champion)
role_list.append(best_role)

# First stage selection
if role_list[0] in ['top', 'middle', 'jungle']:
    if role_list[0] == 'top':
        # select the 2nd based on the 1st: jungle
        query = (   'SELECT top, jungle, max(winrate) '
                    'FROM top_jungle_matchups_new '
                    'WHERE top = \'' + champion_list[0] + '\' '
                    'GROUP BY top'
                    )
        mycursor.execute(query)
        _, jungle_champion, _ = mycursor.fetchall()[0]
        champion_list.append(jungle_champion)
        role_list.append('jungle')
        # select the 3rd based on the 2nd: middle
        query = (   'SELECT middle, jungle, max(winrate) '
                    'FROM middle_jungle_matchups_new '
                    'WHERE jungle = \'' + champion_list[1] + '\' '
                    'GROUP BY jungle'
                    )
        mycursor.execute(query)
        middle_champion, _, _ = mycursor.fetchall()[0]
        champion_list.append(middle_champion)
        role_list.append('middle')

    elif role_list[0] == 'middle':
        # select the 2nd based on the 1st: jungle
        query = (   'SELECT middle, jungle, max(winrate) '
                    'FROM middle_jungle_matchups_new '
                    'WHERE middle = \'' + champion_list[0] + '\' '
                    'GROUP BY middle'
                    )
        mycursor.execute(query)
        _, jungle_champion, _ = mycursor.fetchall()[0]
        champion_list.append(jungle_champion)
        role_list.append('jungle')
        # select the 3rd based on the 2nd: top
        query = (   'SELECT top, jungle, max(winrate) '
                    'FROM top_jungle_matchups_new '
                    'WHERE jungle = \'' + champion_list[1] + '\' '
                    'GROUP BY jungle'
                    )
        mycursor.execute(query)
        top_champion, _, _ = mycursor.fetchall()[0]
        champion_list.append(top_champion)
        role_list.append('top')
    elif role_list[0] == 'jungle':
        # select the 2nd based on the 1st: middle
        query = (   'SELECT middle, jungle, max(winrate) '
                    'FROM middle_jungle_matchups_new '
                    'WHERE jungle = \'' + champion_list[0] + '\' '
                    'GROUP BY jungle'
                    )
        mycursor.execute(query)
        middle_champion, _, _ = mycursor.fetchall()[0]
        champion_list.append(middle_champion)
        role_list.append('middle')
        # select the 3rd based on the 1st: top
        query = (   'SELECT top, jungle, max(winrate) '
                    'FROM top_jungle_matchups_new '
                    'WHERE jungle = \'' + champion_list[0] + '\' '
                    'GROUP BY jungle'
                    )
        mycursor.execute(query)
        top_champion, _, _ = mycursor.fetchall()[0]
        champion_list.append(top_champion)
        role_list.append('top')
elif role_list[0] in ['adc', 'support']:
    if role_list[0] == 'adc':
        # select the 2nd based on the 1st: support
        query = (   'SELECT adc, support, max(winrate) '
                    'FROM adc_support_matchups_new '
                    'WHERE adc = \'' + champion_list[0] + '\' '
                    'GROUP BY adc')
        mycursor.execute(query)
        _, support_champion, _ = mycursor.fetchall()[0]
        champion_list.append(support_champion)
        role_list.append('support')
    elif role_list[0] == 'support':
        # select the 2nd based on the 1st: adc
        query = (   'SELECT adc, support, max(winrate) '
                    'FROM adc_support_matchups_new '
                    'WHERE support = \'' + champion_list[0] + '\' '
                    'GROUP BY support'
                    )
        mycursor.execute(query)
        adc_champion, _, _ = mycursor.fetchall()[0]
        champion_list.append(adc_champion)
        role_list.append('adc')
# print(champion_list)
# print(role_list)

G = build_graph()

# stage 2 select, if jungle, top, middle have been selected, we select adc, support 
if 'jungle' in role_list:
    adc_list = []
    support_list = []
    query = (   'SELECT name, role ' 
                'FROM single_champion_stats '
                'WHERE role IN (\'adc\',\'support\') AND '
                            'winrate = (SELECT max(winrate) '
                            'FROM single_champion_stats as scs '
                            'WHERE scs.name=single_champion_stats.name) '
                            )
    mycursor.execute(query)
    for champion, role in mycursor.fetchall():
        if role=='adc':
            adc_list.append(champion)
        elif role=='support':
            support_list.append(champion)
    # print(adc_list, support_list)
    
    curr_best_adc_support_candidate = []
    curr_best_synergy = 0
    # print(adc_list)
    for adc_champion in adc_list:
        # For each adc, search for the best adc/support pair from adc_support table
        # For the query with string that has "'", make it "''" to avoid error
        if "'" in adc_champion:
            query = (   'SELECT adc, support, max(winrate), synergy '
                        'FROM adc_support_matchups_new '
                        'WHERE adc = \'' + adc_champion.replace("'","''") + '\' '
                        'GROUP BY adc')
        else:
            query = (   'SELECT adc, support, max(winrate), synergy '
                        'FROM adc_support_matchups_new '
                        'WHERE adc = \'' + adc_champion + '\' '
                        'GROUP BY adc')
        mycursor.execute(query)
        try:
            _, support_champion, _, adc_support_synergy = mycursor.fetchall()[0]
        except:
            continue
        # print('query:', adc_champion, support_champion)
        bipartite_synergy = 0
        bipartite_synergy += G.get_edge_data(adc_champion, support_champion)['weight']
        for candidate_node in [adc_champion, support_champion]:
            for existing_node in champion_list:
                try:
                    bipartite_synergy += G.get_edge_data(candidate_node, existing_node)['weight']
                except:
                    pass
        # print(bipartite_synergy)
        if not bipartite_synergy < curr_best_synergy:
            curr_best_adc_support_candidate = [adc_champion, support_champion]
            curr_best_synergy = bipartite_synergy
        # print('current best:', curr_best_adc_support_candidate, bipartite_synergy)
    for support_champion in support_list:
        if "'" in support_champion:
            query = (   'SELECT adc, support, max(winrate), synergy '
                        'FROM adc_support_matchups_new '
                        'WHERE support = \'' + support_champion.replace("'","''") + '\' '
                        'GROUP BY support')
        else:
            query = (   'SELECT adc, support, max(winrate), synergy '
                        'FROM adc_support_matchups_new '
                        'WHERE support = \'' + support_champion + '\' '
                        'GROUP BY support')
        mycursor.execute(query)
        try:
            adc_champion, _, _, adc_support_synergy = mycursor.fetchall()[0]
        except:
            continue
        # print('query:', adc_champion, support_champion)
        bipartite_synergy = 0
        bipartite_synergy += G.get_edge_data(adc_champion, support_champion)['weight']
        for candidate_node in [adc_champion, support_champion]:
            for existing_node in champion_list:
                try:
                    bipartite_synergy += G.get_edge_data(candidate_node, existing_node)['weight']
                except:
                    pass
        # print(bipartite_synergy)
        if not bipartite_synergy < curr_best_synergy:
            curr_best_adc_support_candidate = [adc_champion, support_champion]
            curr_best_synergy = bipartite_synergy
        # print('current best:', curr_best_adc_support_candidate, bipartite_synergy)
    # append the best adc/support selected and get the final list
    champion_list += curr_best_adc_support_candidate
    role_list += ['adc', 'support']
    # calculate sum of synergy of existing champions in the list
    synergy_sum = 0
    jungle_idx = role_list.index('jungle')
    top_idx = role_list.index('top')
    middle_idx = role_list.index('middle')
    synergy_sum += G.get_edge_data(champion_list[jungle_idx], champion_list[top_idx], default=0)['weight']
    synergy_sum += G.get_edge_data(champion_list[jungle_idx], champion_list[middle_idx], default=0)['weight']
    # get the total by adding the best between group synergy to synergy between existing champions in the list
    synergy_sum += curr_best_synergy
else:
    jungle_list = []
    top_list = []
    middle_list = []
    query = (   'SELECT name, role ' 
                'FROM single_champion_stats '
                'WHERE role IN (\'jungle\',\'top\',\'middle\') AND '
                            'winrate = (SELECT max(winrate) '
                            'FROM single_champion_stats as scs '
                            'WHERE scs.name=single_champion_stats.name) '
                            )
    mycursor.execute(query)
    for champion, role in mycursor.fetchall():
        if role=='jungle':
            jungle_list.append(champion)
        elif role=='top':
            top_list.append(champion)
        elif role=='middle':
            middle_list.append(champion)
    curr_best_jungle_top_champion_candidate = []
    curr_best_synergy = 0
    for jungle_champion in jungle_list:
        # for each jungle champion, search for corresponding best top and middle
        if "'" in jungle_champion:
            query = (   'SELECT top, jungle, max(winrate) '
                        'FROM top_jungle_matchups_new '
                        'WHERE jungle = \'' + jungle_champion.replace("'","''") + '\' '
                        'GROUP BY jungle'
                    )
        else:
            query = (   'SELECT top, jungle, max(winrate) '
                        'FROM top_jungle_matchups_new '
                        'WHERE jungle = \'' + jungle_champion + '\' '
                        'GROUP BY jungle'
                        )
        mycursor.execute(query)
        try:
            top_champion, _, _ = mycursor.fetchall()[0]
        except:
            continue
        
        if "'" in jungle_champion:
            query = (   'SELECT middle, jungle, max(winrate) '
                    'FROM middle_jungle_matchups_new '
                    'WHERE jungle = \'' + jungle_champion.replace("'","''") + '\' '
                    'GROUP BY jungle'
                    )
        else:
            query = (   'SELECT middle, jungle, max(winrate) '
                    'FROM middle_jungle_matchups_new '
                    'WHERE jungle = \'' + jungle_champion + '\' '
                    'GROUP BY jungle'
                    )
        mycursor.execute(query)
        try:
            middle_champion, _, _ = mycursor.fetchall()[0]
        except:
            continue
        # print('query:', jungle_champion, top_champion, middle_champion)
        bipartite_synergy = 0
        bipartite_synergy += G.get_edge_data(jungle_champion, top_champion)['weight']
        bipartite_synergy += G.get_edge_data(jungle_champion, middle_champion)['weight']
        
        for candidate_node in [jungle_champion, top_champion, middle_champion]:
            for existing_node in champion_list:
                try:
                    bipartite_synergy += G.get_edge_data(candidate_node, existing_node)['weight']
                except:
                    pass
        # print(bipartite_synergy)
        if not bipartite_synergy < curr_best_synergy:
            curr_best_jungle_top_champion_candidate = [jungle_champion, top_champion, middle_champion]
            curr_best_synergy = bipartite_synergy
        # print('current best:', curr_best_jungle_top_champion_candidate, bipartite_synergy)
    # append the best jungle/top/middle selected and get the final list
    champion_list += curr_best_jungle_top_champion_candidate
    role_list += ['jungle', 'top', 'middle']
    # get the total by adding the best between group synergy to synergy between existing adc/support
    synergy_sum = curr_best_synergy+G.get_edge_data(champion_list[0], champion_list[1])['weight']

for role, champion in zip(role_list, champion_list):
    print(role, ': ', champion)
print('synergy score: ', synergy_sum)

# php_output = {}
#     php_output[role] = champion
# php_output['synergy score'] = synergy_sum
# print(json.dumps(php_output)) 
# print(champion_list)
# print(role_list)
# print(synergy_sum)