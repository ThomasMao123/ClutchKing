# -*- coding: utf-8 -*-
"""
Created on Wed Jul 17 21:14:53 2019

@author: 13015
"""
import math
import random
def smallerDimVal(first=None, second=None, curDim=0):
    if (first[curDim] < second[curDim]):
        return True
    else:
        return False
    
def calDist(first=None, second=None):
    ret = 0;
    for i in range(0, len(first)):
        ret = ret + math.pow(first[i] - second[i], 2)
    return ret

def shouldReplace(target=None, currentBest=None, potential=None):
    dist_sqr = 0
    dist_sqr_new = 0;
    for i in range(0, len(target)):
        dist_sqr = dist_sqr + math.pow(target[i]-currentBest[i], 2)
        dist_sqr_new = dist_sqr_new + math.pow(target[i] - potential[i], 2)
    if (dist_sqr_new < dist_sqr):
        return True
    else:
        return False
    

    

class Node(object):
    def __init__(self, data=None, left=None, right=None):
        self.data=data
        self.left=left
        self.right=right
    
class KDNode(Node):
    def __init__(self, data=None, left=None, right=None, axis=None, dimension=None):
        super(KDNode, self).__init__(data, left, right)
        
        self.axis = axis
        self.dimension = dimension
        
    
    def add_node(self,point):
        pos = self
        while True:
            if pos.data is None:
                pos.data = point
                return pos
            else:
                if point[pos.axis] < pos.data[pos.axis]:
                    if pos.left is None:
                        pos.left = pos.create_subnode(point)
                        return pos.left
                    else:
                        pos = pos.left
                else:
                    if pos.right is None:
                        pos.right = pos.create_subnode(point)
                        return pos.right
                    else:
                        pos = pos.right
    
    def create_subnode(self, data):
        return self.__class__(data, axis=(self.axis+1)%self.dimension, dimension=self.dimension)
    
def findNearestNeighbor(query=None, current=None, currentDim=None):
    if current.left.data is None and current.right.data is None:
        return current.data
    if smallerDimVal(first=query, second=current.data, curDim=currentDim):
        current_best = current.data;
        if current.left.data is not None:
            newDim = (currentDim + 1) % current.dimension;
            potential = findNearestNeighbor(query, current.left, newDim);
            
            if shouldReplace(query, current_best, potential):
                    current_best = potential;
                    
        if current.right.data is None:
            return current_best;
        else:
            if calDist(current_best, query) >= ((query[currentDim] - current.data[currentDim])*(query[currentDim] - current.data[currentDim])): 
                newDim = (currentDim + 1) % current.dimension;
                potential = findNearestNeighbor(query, current.right, newDim);
                if shouldReplace(query, current_best, potential):
                    return potential
                else :
                    return current_best;
            else :
                return current_best;
    
    if smallerDimVal(current.data, query, currentDim):
        current_best = current.data
        if current.right.data is not None:
            newDim = (currentDim + 1) % current.dimension
            potential = findNearestNeighbor(query, current.right, newDim)
            if shouldReplace(query, current_best, potential):
                current_best = potential
        
        if current.left.data is None:
            return current_best
        else:
            if calDist(current_best, query) >= ((query[currentDim] - current.data[currentDim]) * (query[currentDim] - current.data[currentDim])):
                newDim = (currentDim + 1) % current.dimension
                potential = findNearestNeighbor(query, current.left, newDim)
                if (shouldReplace(query, current_best, potential)):
                    return potential
                else:
                    return current_best
        
            else:
                return current_best
      
    return current.data
    
  
      

  
def create(point_list=None, dimension=None, axis=0):
    if not point_list:
        return KDNode(axis=axis, dimension=dimension)

    # Sort point list and choose median as pivot element
    point_list = list(point_list)
    point_list.sort(key=lambda point: point[axis])
    median = len(point_list) // 2

    loc   = point_list[median]
    left  = create(point_list[:median], dimension, (axis+1)%dimension)
    right = create(point_list[median + 1:], dimension, (axis+1)%dimension)
    
    return KDNode(loc, left, right, axis=axis, dimension=dimension);

#point_list=[]
#for i in range(0,100000):
#    point=[]
#    for j in range(0, 3):
#        point.append(random.randint(0,50))
#    point_list.append(point)
#    
#kdtree=create(point_list, dimension=3, axis=0)
#print(findNearestNeighbor([7,5,4], current=kdtree, currentDim=0))
#
#




    

    
       
    