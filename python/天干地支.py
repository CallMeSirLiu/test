#! /usr/bin/env python3
# coding=utf-8

from datetime import datetime

def getYear(year=None):
   if year is None:
      year = int(datetime.now().strftime('%Y'))

   tiangan =  tuple('T甲乙丙丁午己庚辛壬癸')
   dizhi =    tuple('D子丑寅卯辰巳午未申酉戌亥')
   shuxiang = tuple('S鼠牛虎兔龙蛇马羊猴鸡狗猪')
   shuxiang2 =tuple('S🐭🐂🐯🐰🐲🐍🐴🐑🐒🐓🐶🐽')

   if year%10 >= 3:
      tiangan_year = year%10 - 3
   else:
      tiangan_year = year%10 - 3 + 10

   if 1900 <= year <= 1999:
      dizhi_year = (year%100 - 11)%12
   elif year >= 2000:
      dizhi_year = (year%100 + 5)%12
   else:
       return '不支持计算'

   return tiangan[tiangan_year] +  dizhi[dizhi_year], shuxiang[dizhi_year] , shuxiang2[dizhi_year]

print(getYear())

