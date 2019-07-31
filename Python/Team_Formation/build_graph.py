import pandas as pd
import os
import numpy as np
import matplotlib.pyplot as plt
import networkx as nx

def build_graph():
    # store the synergy information in the graph structure
    G = nx.Graph()
    path = os.getcwd()
    # top jungle table
    df = pd.read_csv(path+'/virtualenv/graph/top_jungle_new.csv')
    synergy_raw = df[' synergy'].tolist()
    synergy_list = [float(x.strip('%')) for x in synergy_raw]
    top_list = df['# top'].tolist()
    jungle_list = df[' jungle'].tolist()
    for top_node, jungle_node, synergy_score in zip(top_list, jungle_list, synergy_list):
        G.add_edge(top_node, jungle_node, weight=synergy_score)
    # middle jungle table
    df = pd.read_csv(path+'/virtualenv/graph/middle_jungle_new.csv')
    synergy_raw = df[' synergy'].tolist()
    synergy_list = [float(x.strip('%')) for x in synergy_raw]
    middle_list = df['# middle'].tolist()
    jungle_list = df[' jungle'].tolist()
    for middle_node, jungle_node, synergy_score in zip(middle_list, jungle_list, synergy_list):
        G.add_edge(middle_node, jungle_node, weight=synergy_score)
    # adc support table
    df = pd.read_csv(path+'/virtualenv/graph/adc_support_new.csv')
    synergy_raw = df[' synergy'].tolist()
    synergy_list = [float(x.strip('%')) for x in synergy_raw]
    adc_list = df['# adc'].tolist()
    support_list = df[' support'].tolist()
    for adc_node, support_node, synergy_score in zip(adc_list, support_list, synergy_list):
        G.add_edge(adc_node, support_node, weight=synergy_score)
    return G
    # pos = nx.spring_layout(G)
    # nx.draw_networkx_labels(G, pos)
    # plt.show()
    # print(list(G.edges.data()))
# build_graph()