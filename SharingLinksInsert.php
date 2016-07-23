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
 
<div class="navbar navbar-inverse navbar-fixed-top">
	<a href="/Project/sharing_info/SharingLinks.php" class="navbar-brand active bold">Home</a>
	<a href="/Project/sharing_info/SharingLinksInsert.php" class="navbar-brand active bold">Insert</a>
	<a href="/Project/sharing_info/SharingLinksUpdate.php" class="navbar-brand active bold">Update</a>
	<a href="/Project/sharing_info/SharingLinksDelete.php" class="navbar-brand bold active">Delete</a>
	<a href="/Project/sharing_info/SharingLinksLookup.php" class="navbar-brand active bold">LookUp</a>
	
</div>
<div class="container">
	<div class="navbar-header">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span> 
	</div>
</div>			

<?php
session_start();
$json = file_get_contents('http://test.localfeedbackloop.com/api?apiKey=61067f81f8cf7e4a1f673cd230216112&noOfReviews=10&internal=1&yelp=1&google=1&offset=50&threshold=1');
$obj = json_decode($json,true);
      // Dump all data of the Object
	
?>

<body>  

<?php
// define variables and set to empty values
$tokenErr = $urlErr = $subscriberErr = $activeErr = "";
$token = $url = $subscriber_id = $active = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["token"])) {
	$tokenErr1 = "Enter valid Token";
    $tokenErr = "Token is required";
  } else {
    $token = test_input($_POST["token"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ][0-9]*$/",$token)) {
      //$tokenErr = "Only letters, numbers, and white space allowed"; 
    }
  }
     
  if (empty($_POST["url"])) {
    $url = "";
  } else {
    $url = test_input($_POST["url"]);
    // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$url)) {
      $urlErr = "Invalid URL"; 
    }
  }

 /* if (empty($_POST["subscriber_id"])) {
    $subscriberErr = "Subscriber id is required";
  } else {
    $subscriber_id = test_input($_POST["subscriber_id"]); 
    }
  */
  if (empty($_POST["active"])) {
    $activeErr = "Select One";
  } else {
    $active = test_input($_POST["active"]);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

			
<form method="post" action="SharingLinks.php">  
	<div class="container contentContainer fontcolor" id="footer">
		<div class="col-md-6 col-md-offset-3" id="topRow">
			<h1 class="marginTop" id="div1">Welcome!!</h1>
		<p class="center title bold"><span class="glyphicon glyphicon-star">Insert Details</span></p>

<fieldset class="form-group">
  
  <label for="url">URL</label> 
		<input type="text"  class="form-control" name="url" value="<?php echo $url;?>" placeholder="Enter URL" required="required">
		<span class="error">*<?php echo $urlErr;?></span>
		<br><br>
  
  <!--<label for="text">Subscriber ID</label>
		<input type="text" class="form-control" name="subscriber_id" value="<?php echo $subscriber_id;?>" placeholder="Enter Subscriber ID">
		<span class="error">* 
		 <?php //echo $subscriberErr;?> 
		</span>
		<br><br>-->
		
  <label for="active">Active</label>
		<input type="radio" class="form-control" name="active" <?php if (isset($active) && $active=="1") echo "checked";?> value="1" required="required">1
		<input type="radio" class="form-control" name="active" <?php if (isset($active) && $active=="0") echo "checked";?> value="0">0
		<span class="error">* <?php echo $activeErr;?></span>
		<br><br>
  
		  <input type="submit" name="insert" value="Insert" class="btn btn-success btn-lg marginTop"><br><br>
		  
	</fieldset>
		</div>
	</div>  
</div>	
</form>



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
		margin-top:80px;
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