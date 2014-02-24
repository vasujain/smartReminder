Smart Reminder aka Smart Shopper
================================

Problem:

Many a times we miss birthday/anniversary of freinds/family not intentionaly but it happens
and even if we remmeber we end up giving them something irrelevant or which they may not like

Thanks 2 Facebook.. we have a lot of data and user liking/preferences
to solve the above problem, we mine the facebook information. 

and use recommendation engines to curate a list of likings 

mine the info
suitable suggestion

pre order and deliver

and cool thing is checkout via bitpay


Macy's
Capital One
Bitpay
Yammer
Tagged
ESRI
Expedia

https://www.facebook.com/dialog/oauth?client_id=1456937381189643&redirect_uri=http%3A%2F%2Fwindowsvj.com%2Fsr%2Fweb%2Ffbconnect.php&state=51e902c5c9c282c32d39bfce8be052cc&sdk=php-sdk-3.2.3

https://www.facebook.com/dialog/oauth?client_id=1456937381189643&redirect_uri=http://appery.io/app/view/d5ac9e63-9eae-422b-8384-b71fed8ad3a7/startScreen&scope=basic_info,email,user_birthday&state=ozKuOcXprSRvv70kw

http://appery.io/app/view/d5ac9e63-9eae-422b-8384-b71fed8ad3a7/startScreen.html?code=AQBXbON4hrWBpXILoKfShjv9qnc82iluqMrvkD3Hj3MVJAf-2pAdKM9weWTwsfwQU6X9bvfc-hqzVunG4rYRyEjCew2Y7xu9t-R332fip0R2UgkmJGPajyFb5H2ePEHHB76-VHTQ8x4x9P8T5aBmhPhN-RcVLWZ0BqxUBEXeiEm3bhCYBaVzXvx_FEc0O2quVFfiNBZvFW_uzacBcckPoSsyeq0eA0bnRwXQOjlQIhovLObiN5BkcQ-XRrcSunU3OL79CVwz3amAK9vXcm5IdhshVrs3vdicqZGhTwrqmXrkqxkSSBrNh5h_5kFKLZ_yD8U&state=DxDUhhfZqzS2ohc8w#_=_	

FQL
====
https://graph.facebook.com/fql?q=SELECT name, birthday, birthday_date, current_location, sex, username, uid FROM user 
WHERE uid in (SELECT uid2 FROM friend WHERE uid1 = me())

Heroku
======
Server=8f30c980-e24c-4fba-b2da-a2da00cc9f86.sqlserver.sequelizer.com;Database=db8f30c980e24c4fbab2daa2da00cc9f86;User ID=dbrprtvrwvfqtuvk;Password=M3MAHbz8ZsrqeDtwerSXEpe6gETCBru5e4U2DGTgJRTwCGLwFXJDeb3xXQudq6DH;

Recommendation Algo
===================
"SHOPPING/RETAIL","RETAIL AND CONSUMER MERCHANDISE","BOOK","MAGAZINE","APPLIANCES","BABY GOODS/KIDS GOODS","BAGS/LUGGAGE","BUILDING MATERIALS","CLOTHING","COMMERCIAL EQUIPMENT","COMPUTERS","DRUGS","ELECTRONICS","FOOD/BEVERAGES","FURNITURE","GAMES/TOYS","HEALTH/BEAUTY","HOME DECOR","HOUSEHOLD SUPPLIES","JEWELRY/WATCHES","KITCHEN/COOKING","OFFICE SUPPLIES","OUTDOOR GEAR/SPORTING GOODS","SOFTWARE","TOOLS/EQUIPMENT","VIDEO GAME","VITAMINS/SUPPLEMENTS",WINE/SPIRITS"

