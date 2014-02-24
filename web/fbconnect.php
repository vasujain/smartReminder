<?php
include 'header.php';
?>
<head>
	<style>
		a {
			color: #c75f3e;
		}

		#mytable {
			width: 700px;
			padding: 0;
			margin: 0;
		}

		caption {
			padding: 0 0 5px 0;
			width: 700px;
			font: italic 11px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
			text-align: right;
		}

		th {
			font: bold 11px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
			color: #4f6b72;
			border-right: 1px solid #C1DAD7;
			border-bottom: 1px solid #C1DAD7;
			border-top: 1px solid #C1DAD7;
			letter-spacing: 2px;
			text-transform: uppercase;
			text-align: left;
			padding: 6px 6px 6px 12px;
			background: #CAE8EA url(images/bg_header.jpg) no-repeat;
		}

		th.nobg {
			border-top: 0;
			border-left: 0;
			border-right: 1px solid #C1DAD7;
			background: none;
		}

		td {
			border-right: 1px solid #C1DAD7;
			border-bottom: 1px solid #C1DAD7;
			background: #fff;
			padding: 6px 6px 6px 12px;
			color: #4f6b72;
			vertical-align: middle;
		}


		td.alt {
			background: #F5FAFA;
			color: #797268;
		}

		th.spec {
			border-left: 1px solid #C1DAD7;
			border-top: 0;
			background: #fff url(images/bullet1.gif) no-repeat;
			font: bold 10px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
		}

		th.specalt {
			border-left: 1px solid #C1DAD7;
			border-top: 0;
			background: #f5fafa url(images/bullet2.gif) no-repeat;
			font: bold 10px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
			color: #797268;
		}
	</style>
</head>
<body>
<div class="main">
	  <div class="wrap">
		  <div class="header">
			  <div class="header_top">
				  <div class="menu">
					  <a class="toggleMenu" href="#"><img src="images/nav.png" alt="" /></a>
					  <ul class="nav">
						  <li><a href="index.php"><i><img src="images/settings.png" alt="" /></i>Smart Shopper (Powered by Macy's, Bitpay)</a></li>
						  <li><a href="fbconnect.php"><i><img src="images/favourite.png" alt="" /></i>Facebook Connect</a></li>
						  <div class="clear"></div>
					  </ul>
					  <script type="text/javascript" src="js/responsive-nav.js"></script>
				  </div>
				  <div class="clear"></div>
			  </div>
		  </div>
	  </div>
	  <div class="wrap">
		<div class="column_middle">
			<div class="social_networks">
				<ul>
					<li>
						<?php
						// Remember to copy files from the SDK's src/ directory to a
						// directory in your application on the server, such as php-sdk/
						require_once('../php-sdk/facebook.php');
						error_reporting(0);
						$config = array(
							'appId' => '1456937381189643',
							'secret' => '34ccdd889dfa456c2a8e1856fd3eab55',
						);

						$facebook = new Facebook($config);
						$user_id = $facebook->getUser();
						$access_token = $facebook->getAccessToken();
						$access_token = "CAAUtE6sQ2AsBAEETWTP7vfrpNmY3EhpHhUboHakbVnjPKPjcIlljSI0n0B7euPIZAxqdD4ZCZBxEN1ZBV1XtZAlcucgjZBdpbfjjN5fYaRVM7AZBeMvZCPac4nJegqvvwVtSkeam7ZAGNoleDoKZAZANuqi95aUX47gZA1cUSHsThf25sO2DlQb21H5lvMKF4YMsgd1wCxUU7xZBKRAZDZD";
						?>

						<?php
						session_start();
						if($user_id) {

							// We have a user ID, so probably a logged in user.
							// If not, we'll get an exception, which we handle below.
							try {
//									$fql = 'SELECT name from user where uid = ' . $user_id;
								$fql = 'SELECT name, birthday, pic_big, birthday_date, current_location, sex, username, uid, hometown_location.city
										FROM user
										WHERE uid in (SELECT uid2 FROM friend WHERE uid1 = me())';
								$ret_obj = $facebook->api(array(
									'method' => 'fql.query',
									'query' => $fql,
									'access_token' => $access_token,
								));

								$object =  array();

								$res .= "<table class='table-fb' id='mytable'>";
								for ($i=0;$i<100;$i++){
									//Check if birthday/location is not null
									if($ret_obj[$i]['birthday_date'] && $ret_obj[$i]['current_location']['city']){
										//get all likes for the user
										$fqlLikes = "SELECT name, type FROM page WHERE page_id IN (SELECT page_id FROM page_fan WHERE uid=".$ret_obj[$i]['uid'].") AND type != 'APPLICATION'";
										$ret_obj_likes = $facebook->api(array(
											'method' => 'fql.query',
											'query' => $fqlLikes,
											'access_token' => $access_token,
										));



										$object[$i]->fbid = $ret_obj[$i]['uid'];
										$object[$i]->name = $ret_obj[$i]['name'];
										$object[$i]->birthday= $ret_obj[$i]['birthday_date'];
										//$object[$i]->age;
										//$object[$i]->$nextBirthdayInDays;
										$object[$i]->gender = $ret_obj[$i]['sex'];
										$object[$i]->currentCity = $ret_obj[$i]['current_location']['city'];
										$object[$i]->homeCity = $ret_obj[$i]['hometown_location.city'];
										$object[$i]->pic = $ret_obj[$i]['pic_big'];
										$object[$i]->likes = $ret_obj_likes;
										$_SESSION['p13n_' . $i] = $object[$i];



										//explode the date to get month, day and year
										$birthDate = explode("/", $object[$i]->birthday);
										//get age from date or birthdate
										if($birthDate[2]){
											$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
												? ((date("Y") - $birthDate[2]) - 1)
												: (date("Y") - $birthDate[2]));
											$object[$i]->age = $age;
										}
										$phpDate = strtotime($birthDate[0]. "/" . $birthDate[1]. "/" . date("Y"));//Converted to a PHP date (a second count)
										$diff=time()-$phpDate;//time returns current time in seconds
										$nextBirthdayInDays=abs(floor($diff/(60*60*24)));
										$object[$i]->nextBirthdayInDays = $nextBirthdayInDays;



										$res .= "<tr>";
										$res .= "<td><img src=" . $object[$i]->pic . "></td>";
										$res .= "<td><a href='personalize.php?p13nid=$i'>" . $ret_obj[$i]['name'] . "</a></td>";
										$res .= "<td>" . $ret_obj[$i]['birthday_date'] . "</td>";
										$res .= "<td>" . $object[$i]->age . "</td>";
										$res .= "<td>" . $object[$i]->$nextBirthdayInDays . "</td>";
										$res .= "<td>" . $ret_obj[$i]['current_location']['city'] . ", " . $ret_obj[$i]['current_location']['state'] . "</td>";
										$res .= "<td>" . $ret_obj[$i]['sex'] . "</td>";
										$res .= "<td>" . $ret_obj[$i]['uid'] . "</td>";
										$res .= "<td><a href='personalize.php?p13nid=$i'>Shop for them</a></td>";
										$res .= "</tr>";
									}
								}
								$res .= "</table>";
								echo $res;
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
	<div class="clear"></div>
 </div>
</div>
<?php
include 'footer.php';
?>
</body>
</html>
