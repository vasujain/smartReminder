<?php
include 'header.php';
?>
<body>
<style>
	body {
		background: none !important;
	}
</style>
<div class="wrap">
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
				             	<a href="#"><img src="images/profile_img40x40.jpg" alt="" />	</a>
				             </div>		
				             <div class="clear"></div>		  	
					    </div>	
		 		      <div class="clear"></div>				 
				   </div>
			</div>	  					     
	</div>
	  <div class="main">  
	    <div class="wrap">
			<div class="column_left"></div>
			<div class="column_middle">
				<div class="social_networks">
					<ul>
						<li>
							<?php
							session_start();
							$p13nid = $_GET['p13nid'];

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
								$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
									? ((date("Y") - $birthDate[2]) - 1)
									: (date("Y") - $birthDate[2]));
							$user->age = $age;
							$user->likes = $_SESSION['p13n_' . $p13nid]->likes;
							$user->pic = $_SESSION['p13n_' . $p13nid]->pic;

							$irrelevantInterests = array("NON-PROFIT ORGANIZATION", "COMMUNITY ORGANIZATION", "PERSONAL BLOG");
							$relevantInterests = array("BOOK", "MOVIE", "EVENT PLANNING/EVENT SERVICES", "ACTOR/DIRECTOR", "EDUCATION", "ARTIST", "CAMERA/PHOTO", "SHOPPING/RETAIL", "SCIENCE WEBSITE", "RESTAURANT/CAFE", "COMMUNITY", "INTEREST", "AUTHOR", "TV SHOW", "RETAIL AND CONSUMER MERCHANDISE", "FICTIONAL CHARACTER");

							foreach($user->likes as $key=>$value) {
								//echo $value['name'];
								echo $value['type'] . "#\n";
							}


							$searchKeyword = "Levis";
							$httpGetCallUrl = "https://api.macys.com/v4/catalog/search?searchphrase=$searchKeyword";
							$ch = curl_init();
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_URL, $httpGetCallUrl);
							curl_setopt($ch,CURLOPT_HTTPHEADER,array('Accept: application/json','x-macys-webservice-client-id: hackathon'));
							$result = curl_exec($ch);
							$json = json_decode($result, true);
//							print_r($json);
							$numberOfITems = $json['limit'];
							for($i=0; $i<$numberOfITems; $i++) {
								?>
								<a href= "<?php echo($json['payload']['products'][$i]['image']['url']); ?> ">
									<img src="<?php echo($json['payload']['products'][$i]['image']['url']); ?> ">
								</a>
							<?php
							}
							curl_close($ch);
							?>



						</li>
					</ul>
				</div>
			</div>
			<div class="column_right"></div>
    	<div class="clear"></div>
 	 </div>
   </div>
	<?php
	include 'footer.php';
	?>
</body>
</html>

