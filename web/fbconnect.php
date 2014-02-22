<?php
include 'header.php';
?>
<body>
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
							// Remember to copy files from the SDK's src/ directory to a
							// directory in your application on the server, such as php-sdk/
							require_once('../php-sdk/facebook.php');
							ini_set('display_errors', 1);
							$config = array(
								'appId' => '1456937381189643',
								'secret' => '34ccdd889dfa456c2a8e1856fd3eab55',
							);

							$facebook = new Facebook($config);
							$user_id = $facebook->getUser();
							$access_token = $facebook->getAccessToken();
							$access_token = "CAAUtE6sQ2AsBANpiSnCyKZBDkZBDZAsCYQ5MZBNzyjHzYRiNTl4gLdxGxLaeZCuXhatjclGrjje4SD8oQroCb73RpGE2O5ABLEo8bleTzgWcUrL4yYICbyFbbKMMOVAqjYnPNCzvJWaMcLBJCp56e79DY5dG0Xh3SfeZC7cQnOSL6cu2EwJSYJQEjZACoEQ6ZCzlmDZB0oEQaegZDZD";
							?>

							<?php
							if($user_id) {

								// We have a user ID, so probably a logged in user.
								// If not, we'll get an exception, which we handle below.
								try {
//									$fql = 'SELECT name from user where uid = ' . $user_id;
									$fql = 'SELECT name, birthday, birthday_date, current_location, sex, username, uid
											FROM user
											WHERE uid in (SELECT uid2 FROM friend WHERE uid1 = me())';
									$ret_obj = $facebook->api(array(
										'method' => 'fql.query',
										'query' => $fql,
										'access_token' => $access_token,
									));

									$res .= "<table class='table-fb'>";
									for ($i=0;$i<200;$i++){
										$res .= "<tr>";
										$res .= "<td>" . $ret_obj[$i]['name'] . "</td>";
										$res .= "<td>" . $ret_obj[$i]['birthday_date'] . "</td>";
										$res .= "<td>" . $ret_obj[$i]['current_location']['city'] . ", " . $ret_obj[$i]['current_location']['state'] . "</td>";
										$res .= "<td>" . $ret_obj[$i]['sex'] . "</td>";
										$res .= "<td>" . $ret_obj[$i]['uid'] . "</td>";
										$res .= "</tr>";
									}
									$res .= "</table>";

									echo $res;


									// Store data in web apis/sqllite



								} catch(FacebookApiException $e) {
									// If the user is logged out, you can have a
									// user ID even though the access token is invalid.
									// In this case, we'll get an exception, so we'll
									// just ask the user to login again here.
									$login_url = $facebook->getLoginUrl();
									echo 'Please <a href="' . $login_url . '">login.</a>';
									error_log($e->getType());
									error_log($e->getMessage());
								}
							} else {

								// No user, so print a link for the user to login
								$login_url = $facebook->getLoginUrl();
								echo "<a href=" . $login_url . " class='facebook'><i><img src='images/facebook_icon.png' alt='' /></i>
										<span>Please Login</span>
										<div class='clear'></div>
									 </a>";
							}

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

