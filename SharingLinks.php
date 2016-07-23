<!DOCTYPE HTML>  
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Sharing Links using Bootstrap</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
 
<div class="navbar navbar-inverse navbar-fixed-top fontcolor" id="footer">
	<a href="/Project/sharing_info/SharingLinks.php" class="navbar-brand active bold">Home</a>
	<a href="/Project/sharing_info/SharingLinksInsert.php" class="navbar-brand active bold">Insert</a>
	<a href="/Project/sharing_info/SharingLinksUpdate.php" class="navbar-brand active bold">Update</a>
	<a href="/Project/sharing_info/SharingLinksDelete.php" class="navbar-brand bold active">Delete</a>
	<a href="/Project/sharing_info/SharingLinksLookup.php" class="navbar-brand active bold">LookUp</a>
	
<div class="container">
	<div class="navbar-header">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span> 
	</div>
</div>
			

<?php
if(isset($_POST['insert']))
{
	$SharingLinks = new SharingLinks();
	$token = $_POST['url'];
	$url = $_POST['url'];
	$SharingLinks->create($token,$url);
} 
else if(isset($_POST['update'])){
	$SharingLinks = new SharingLinks();
	$token = $_POST['token'];
	$url = $_POST['url'];
	$active = $_POST['active'];
	$SharingLinks->update($token, $url, $active);
} 
else if (isset($_POST['delete'])){
	$SharingLinks = new SharingLinks();
	$token = $_POST['token'];
	$SharingLinks->delete($token);
}
else if (isset($_POST['lookup'])){
	$SharingLinks = new SharingLinks();
	$token = $_POST['token'];
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$SharingLinks->lookup($token, $ip_address);
}
?>
<div class="container marginBottom bold" id="topRow">
	<div class="col-md-10 marginTop">
		<p> 
<?php
class SharingLinks {
	
	// generates a token and enters token, url, and active flag into the database
	function create($token,$url) {
			
		$mysqli = new mysqli("localhost", "root", "Manchester09", "sharing_info");
				
		$token = sha1(uniqid($url, true));
		$active = $_POST['active'];
		$subscriber_id = $mysqli->query("SELECT 'subscriber_id' FROM sharing_links");
		
		if ($subscriber_id->num_rows > 0) {
		 	// output data of each row
			while($row = $subscriber_id->fetch_assoc()) {
			 $subscriber_id = $row['subscriber_id'];
			}
		} 

		/* if(($mysqli->query("SELECT count('subscriber_id') FROM sharing_links;")) == 1)
		{
		$subscriber_id = $mysqli->query("SELECT count('subscriber_id') FROM sharing_links") + 1;
		} */
		
		if ($mysqli->connect_errno) {
			echo "<h3 class='bold center'>Failed to connect to MySQL: (" . $mysqli->connect_errno . ") </h3>" . $mysqli->connect_error;
		}

		if (!($mysqli->query("CALL sharing_links_create ('$token','$url','$subscriber_id','$active')"))) {
			echo "CALL failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		else{
			//echo "<h3 class='bold center'>Below values are inserted into table sharing_links:<br></h3>"."<h4 class='center'>Token:" .$token. "<br> URL: " .$url. "<br> Subscriber ID: " .$subscriber_id. "<br> Active: " .$active . "</h4>";
			echo "<h3 class='bold center'>Below values are inserted into table sharing_links:<br></h3>"."<h4 class='center'>Token:" .$token. "<br> URL: " .$url. "<br> Active: " .$active . "</h4>";
		}
	}
		
	// updates an existing token’s URL and active flag
	function update($token, $url, $active) { 
		$mysqli = new mysqli("localhost", "root", "Manchester09", "sharing_info");
		
		if ($mysqli->connect_errno) {
			echo "<h3 class='bold center'>Failed to connect to MySQL: (" . $mysqli->connect_errno . ") </h3>" . $mysqli->connect_error;
		}

		if (!$mysqli->query("CALL sharing_links_update ('$token','$url','$active')")) {
			echo "CALL failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		else{
			echo "<h3 class='bold center'>Below values are updated in table sharing_links: <br></h3>"."<h4 class='center'>URL: " .$url. "<br> Active: " .$active. "</h4>";
		}
	}
	
	// deletes a link using a token
	function delete($token) { 		
		$mysqli = new mysqli("localhost", "root", "Manchester09", "sharing_info");
		
		if ($mysqli->connect_errno) {
			echo "<h3 class='bold center'>Failed to connect to MySQL: (" . $mysqli->connect_errno . ") </h3>" . $mysqli->connect_error;
		}

		if (!$mysqli->query("CALL sharing_links_delete ('$token')")) {
			echo "<h3 class='bold center'>CALL failed: (" . $mysqli->errno . ") </h3>" . $mysqli->error;
		}
		else{
			echo "<h3 class='bold center'>Token and its respective row details are deleted from table sharing_links:<br></h3>"."<h4 class='center'>Token:" .$token."</h4>";
		}
	}

	// looks up and returns sharing_links data using a token
	// inserts token, ip, and current date into sharing_links_actions table
	function lookup($token,$ip_address) { 
		$date = $_SERVER['REQUEST_TIME'];
		$date = date('Y-m-d H:i:s');
		
		$mysqli = new mysqli("localhost", "root", "Manchester09", "sharing_info");
		$stmt = $mysqli->query("SELECT * FROM sharing_links;");
		
		while($row = $stmt->fetch_assoc()){
				echo "<h3 class='bold center'>Below are values from sharing_links table:<br></h3>"
				."<h4 class='center'>Token: " .$row['token']. "<br> URL: " .$row['url']. 
				"<br> Subscriber ID: " .$row['subscriber_id']. "<br> Active: " .$row['active']."</h4>";
		}
		
		if ($mysqli->connect_errno) {
			echo "<h3 class='bold center'>Failed to connect to MySQL: (" . $mysqli->connect_errno . ") </h3>" . $mysqli->connect_error;
		}
		
		if (!$mysqli->query("CALL sharing_links_lookup ('$token','$ip_address','$date')")) {
			echo "<h3 class='bold center'>CALL failed: (" . $mysqli->errno . ") </h3>" . $mysqli->error;
		}
		else{
			echo "<h3 class='bold center'>Below values are inserted into table sharing_links_actions:<br></h3>"."<h4>IP Address: " .$ip_address. "<br> Date: " .$date."</h4>";
		}
	}	
}
?>
		</p>
		</div>
	</div>
</div>
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	
	<script type="text/javascript">
	$(".contentContainer").css("min-height",$(window).height());
	</script>

<?php
	error_reporting(E_ALL);
	ini_set('display_errors','On');
?>

<style>
	.error {color: #FF0000;}
	.b{
		font-size:1.4em;
	}
	span.glyphicon-star{
		margin-left:-15px;
	}
	#business{
		margin-left:-190px;
	}
	.fontcolor{
		color: blue;
	}
	#topContainer{
		background-image:url("Background.jpg");
		height:500px;
		width:100%;
		background-size:cover;
		padding-top: 20px;
	}
	#topRow{
		margin-top:30px;
		text-align:center;
	}
	#topRow h1{
		font-size:300%;
	}
	.navbar .navbar-nav {
		display: inline-block;
		float: none;
	}
	.navbar-brand{
		font-size:1.8em;
	}
	.navbar .navbar-collapse {
		text-align: center;
	}
	.bold{
		font-weight:bold;
	}
	.marginTop{
		margin-top:10px;
	}
	.center{
		text-align:center;
	}
	.title {
		margin-top:100px;
		font-size:300%;
	}
	#footer {
		<!--background-color:#B0D1FB;-->
		padding-top:-10px;
		height:850px;
		width:100%;
		background-image:url("insertdata.jpg");
		background-size:cover;
	}
	.marginBottom {
		margin-bottom:30px;
	}
	.c-select{
		width:100%;
	}
</style>
</head>
</body>
</html>