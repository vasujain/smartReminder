<?php
include 'header.php';
?>
<body>
<style>
	body {
		background: none !important;
	}
</style>
<div class="main">
	<div class="wrap">
		<h1>Smart Shopper</h1>
		<div class="header">
			  <div class="header_top">
					  <div class="menu">
						  <a class="toggleMenu" href="#"><img src="images/nav.png" alt="" /></a>
							<ul class="nav">
								<li><a href="#"><i><img src="images/settings.png" alt="" /></i>Settings</a></li>
								<li class="active"><a href="#"><i><img src="images/user.png" alt="" /></i>Account</a></li>
								<li><a href="#"><i><img src="images/mail.png" alt="" /></i>Messages <span class="messages">5</span></a></li>
								<li><a href="#"><i><img src="images/favourite.png" alt="" /></i>Favorites</a></li>
							<div class="clear"></div>
						    </ul>
							<script type="text/javascript" src="js/responsive-nav.js"></script>
				        </div>	
					  <div class="profile_details">
				    		   <div id="loginContainer">
				                  <a id="loginButton" class=""><span>Me</span></a>   
				                    <div id="loginBox">                
				                      <form id="loginForm">
				                        <fieldset id="body">
				                            <div class="user-info">
							        			<h4>Hello,<a href="#"> Username</a></h4>
							        			<ul>
							        				<li class="profile active"><a href="#">Profile </a></li>
							        				<li class="logout"><a href="#"> Logout</a></li>
							        				<div class="clear"></div>		
							        			</ul>
							        		</div>			                            
				                        </fieldset>
				                    </form>
				                </div>
				            </div>
				             <div class="profile_img">
								 <?php
								 session_start();
								 $p13nid = $_GET['p13nid'];
								 $_SESSION['p13n_' . $p13nid]->pic;
								 ?>
				             	<a href="#"><img src="<?php echo $_SESSION['p13n_' . $p13nid]->pic ?>" alt="" height="40px" width="40px"/>	</a>
				             </div>		
				             <div class="clear"></div>		  	
					    </div>	
		 		      <div class="clear"></div>				 
			   </div>
		</div>
</div>
	<div class="wrap">
			<div>
				<div class="social_networks">
					<ul>
						<li>
							<?php
							$user = new stdClass();
							$user->fbid = $_SESSION['p13n_' . $p13nid]->fbid;
							$user->name = $_SESSION['p13n_' . $p13nid]->name;
							$user->gender = $_SESSION['p13n_' . $p13nid]->gender;
							$user->currentCity = $_SESSION['p13n_' . $p13nid]->gender;
							$user->homeCity = $_SESSION['p13n_' . $p13nid]->gender;
							$user->birthday = $_SESSION['p13n_' . $p13nid]->birthday;
								//explode the date to get month, day and year
								$birthDate = explode("/", $user->birthday);
								//get age from date or birthdate
								if($birthDate[2]){
									$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
										? ((date("Y") - $birthDate[2]) - 1)
										: (date("Y") - $birthDate[2]));
									$user->age = $age;
								}



							$phpDate = strtotime($birthDate[0]. "/" . $birthDate[1]. "/" . date("Y"));//Converted to a PHP date (a second count)
							$diff=time()-$phpDate;//time returns current time in seconds
							$nextBirthdayInDays=abs(floor($diff/(60*60*24)));
							$user->nextBirthdayInDays = $nextBirthdayInDays;


							$user->likes = $_SESSION['p13n_' . $p13nid]->likes;
							$user->pic = $_SESSION['p13n_' . $p13nid]->pic;

							$irrelevantInterests = array("RESTAURANT/CAFE", "COMMUNITY", "EDUCATION", "NON-PROFIT ORGANIZATION","ACTOR/DIRECTOR", "EVENT PLANNING/EVENT SERVICES", "COMMUNITY ORGANIZATION", "SCIENCE WEBSITE", "PERSONAL BLOG");
							$relevantInterests = array("SHOPPING/RETAIL","RETAIL AND CONSUMER MERCHANDISE","BOOK","MAGAZINE","APPLIANCES","BABY GOODS/KIDS GOODS","BAGS/LUGGAGE","BUILDING MATERIALS","CLOTHING","COMMERCIAL EQUIPMENT","COMPUTERS","DRUGS","ELECTRONICS","FOOD/BEVERAGES","FURNITURE","GAMES/TOYS","HEALTH/BEAUTY","HOME DECOR","HOUSEHOLD SUPPLIES","JEWELRY/WATCHES","KITCHEN/COOKING","OFFICE SUPPLIES","OUTDOOR GEAR/SPORTING GOODS","SOFTWARE","TOOLS/EQUIPMENT","VIDEO GAME","VITAMINS/SUPPLEMENTS","WINE/SPIRITS");
							$notSureInterests = array("CAMERA/PHOTO", "BOOK", "MOVIE", "ARTIST", "INTEREST", "AUTHOR", "TV SHOW", "FICTIONAL CHARACTER"	 );
							$commonProducts = array("converse","blackberry","levis","dove","nutella","nike","Frappuccino","Snickers","monster");

							echo "<div align='center'><img src='" .  $_SESSION['p13n_' . $p13nid]->pic . "'></div><br/>";
							echo "<div align='center'>". $user->name . "'s Birthday is arriving in <b>" . $user->nextBirthdayInDays . " days</b></div><br/>";

							$interestList = array();
							if($user->likes) {
								foreach($user->likes as $key=>$value) {
									if (in_array($value['type'], $relevantInterests)) {
										array_push($interestList, $value['name']);
									}
								}
							} else {
								echo "<div align='center'><img src='" .  $_SESSION['p13n_' . $p13nid]->pic . "'></div><br/>";
								echo "User Interests can not be loaded.<br/>";
								echo "Recommending most common products.<br/><br/>";
								array_push($interestList,$commonProducts);
							}

							echo "<div align='center'>As per our recommendation engine  ". $user->name . " likes: </div><br/>";
							//foreach($interestList as $key=>$value) {
							foreach($commonProducts as $key=>$value) {
								echo "<div align='center'>" . $value . "</div>";
							}
							echo "<br/><div align='center'>Give a present to ". $user->name . " using Macy's</div><br/>";

							//foreach($interestList as $key=>$searchKeyword) {
							foreach($commonProducts as $key=>$searchKeyword) {
								$httpGetCallUrl = "https://api.macys.com/v4/catalog/search?searchphrase=$searchKeyword";
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
								curl_setopt($ch, CURLOPT_URL, $httpGetCallUrl);
								curl_setopt($ch,CURLOPT_HTTPHEADER,array('Accept: application/json','x-macys-webservice-client-id: hackathon'));
								$result = curl_exec($ch);
								$json = json_decode($result, true);
								$numberOfItems = $json['limit'];
								for($i=0; $i<3; $i++) {
									print_r($json['searchresultgroups']['0']['products']);

//									?>
<!--									<a href= "--><?php //echo($json['searchresultgroups']['0']['products']['product'][$i]['image']['0']['imageurl']); ?><!-- ">-->
<!--										<img src="--><?php //echo($json['searchresultgroups']['0']['products']['product'][$i]['image']['0']['imageurl']); ?><!-- ">-->
<!--									</a>-->
<!--								--><?php
								}
							}
							curl_close($ch);
							?>
						</li>
					</ul>
				</div>
			</div>
    	<div class="clear"></div>
 	 </div>
<?php
	include 'footer.php';
?>
</div>

</body>
</html>





<!--



Category Lists: FB
{
"1301":"Author",
"1300":"Book",
"1309":"Book Series",
"1305":"Book Store",
"1306":"Library",
"1308":"Literary Editor",
"1307":"Magazine",
"1304":"Publisher",
"2301":"App Page",
"2215":"Appliances",
"2232":"Baby Goods/Kids Goods",
"2206":"Bags/Luggage",
"2303":"Board Game",
"2216":"Building Materials",
"2208":"Camera/Photo",
"2205":"Cars",
"2209":"Clothing",
"2217":"Commercial Equipment",
"2210":"Computers",
"2263":"Drugs",
"2213":"Electronics",
"2252":"Food/Beverages",
"2219":"Furniture",
"2300":"Games/Toys",
"2214":"Health/Beauty",
"2218":"Home Decor",
"2220":"Household Supplies",
"2226":"Jewelry/Watches",
"2221":"Kitchen/Cooking",
"2212":"Office Supplies",
"2231":"Outdoor Gear/Sporting Goods",
"2222":"Patio/Garden",
"2230":"Pet Supplies",
"2265":"Phone/Tablet",
"2201":"Product/Service",
"2211":"Software",
"2223":"Tools/Equipment",
"2302":"Video Game",
"2262":"Vitamins/Supplements",
"2202":"Website",
"2224":"Wine/Spirits",
"2244":"Aerospace/Defense",
"2240":"Automobiles and Parts",
"2234":"Bank/Financial Institution",
"2254":"Biotechnology",
"2606":"Cause",
"2247":"Chemicals",
"2264":"Church/Religious Organization",
"2260":"Community Organization",
"2200":"Company",
"2255":"Computers/Technology",
"2248":"Consulting/Business Services",
"2250":"Education",
"2238":"Energy/Utility",
"2251":"Engineering/Construction",
"2246":"Farming/Agriculture",
"2252":"Food/Beverages",
"2604":"Government Organization",
"2214":"Health/Beauty",
"2243":"Health/Medical/Pharmaceuticals",
"2241":"Industrials",
"2236":"Insurance Company",
"2256":"Internet/Software",
"2249":"Legal/Law",
"2233":"Media/News/Publishing",
"2245":"Mining/Materials",
"2235":"Non-Governmental Organization (NGO)",
"2603":"Non-Profit Organization",
"2600":"Organization",
"2261":"Political Organization",
"2618":"Political Party",
"2239":"Retail and Consumer Merchandise",
"2601":"School",
"2237":"Small Business",
"2253":"Telecommunication",
"2242":"Transport/Freight",
"2258":"Travel/Leisure",
"2602":"University",
"2506":"Airport",
"2508":"Arts/Entertainment/Nightlife",
"2523":"Attractions/Things to Do",
"2509":"Automotive",
"2512":"Bank/Financial Services",
"2100":"Bar",
"1305":"Book Store",
"2518":"Business Services",
"2264":"Church/Religious Organization",
"2101":"Club",
"2519":"Community/Government",
"1209":"Concert Venue",
"1608":"Doctor",
"2250":"Education",
"2511":"Event Planning/Event Services",
"2513":"Food/Grocery",
"2514":"Health/Medical/Pharmacy",
"2515":"Home Improvement",
"2527":"Hospital/Clinic",
"2501":"Hotel",
"2503":"Landmark",
"1607":"Lawyer",
"1306":"Library",
"2500":"Local Business",
"1111":"Movie Theater",
"2528":"Museum/Art Gallery",
"2231":"Outdoor Gear/Sporting Goods",
"2516":"Pet Services",
"2517":"Professional Services",
"2522":"Public Places",
"2520":"Real Estate",
"1900":"Restaurant/Cafe",
"2601":"School",
"2521":"Shopping/Retail",
"2510":"Spas/Beauty/Personal Care",
"2507":"Sports Venue",
"2524":"Sports/Recreation/Activities",
"2525":"Tours/Sightseeing",
"2526":"Transportation",
"2602":"University",
"1103":"Actor/Director",
"1113":"Fictional Character",
"1105":"Movie",
"1114":"Movie Character",
"1111":"Movie Theater",
"1108":"Producer",
"1110":"Studio",
"1112":"TV/Movie Award",
"1109":"Writer",
"1200":"Album",
"1208":"Concert Tour",
"1209":"Concert Venue",
"1212":"Music Award",
"1213":"Music Chart",
"1207":"Music Video",
"1202":"Musician/Band",
"1210":"Radio Station",
"1211":"Record Label",
"1201":"Song",
"2612":"Community",
"2631":"Just For Fun",
"1103":"Actor/Director",
"1601":"Artist",
"1600":"Athlete",
"1301":"Author",
"1609":"Business Person",
"1606":"Chef",
"1802":"Coach",
"1610":"Comedian",
"1614":"Dancer",
"1611":"Entertainer",
"1113":"Fictional Character",
"1701":"Government Official",
"1604":"Journalist",
"1612":"Monarch",
"1114":"Movie Character",
"1202":"Musician/Band",
"1605":"News Personality",
"2632":"Pet",
"1700":"Politician",
"1108":"Producer",
"1602":"Public Figure",
"1613":"Teacher",
"1109":"Writer",
"1803":"Amateur Sports Team",
"1600":"Athlete",
"1802":"Coach",
"1801":"Professional Sports Team",
"1804":"School Sports Team",
"1805":"Sports Event",
"1800":"Sports League",
"2507":"Sports Venue",
"1103":"Actor/Director",
"1405":"Episode",
"1113":"Fictional Character",
"1114":"Movie Character",
"1110":"Studio",
"1404":"TV Channel",
"1402":"TV Network",
"1400":"TV Show",
"1112":"TV/Movie Award",
"1109":"Writer",
"2701":"Arts/Humanities Website",
"2702":"Business/Economy Website",
"2703":"Computers/Internet Website",
"2704":"Education Website",
"2705":"Entertainment Website",
"2706":"Government Website",
"2707":"Health/Wellness Website",
"2708":"Home/Garden Website",
"2715":"Local/Travel Website",
"2709":"News/Media Website",
"2700":"Personal Blog",
"2717":"Personal Website",
"2710":"Recreation/Sports Website",
"2711":"Reference Website",
"2712":"Regional Website",
"2713":"Science Website",
"2714":"Society/Culture Website",
"2716":"Teens/Kids Website"
}

