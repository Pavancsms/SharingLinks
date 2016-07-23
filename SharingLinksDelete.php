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
// define variables and set to empty values
$tokenErr = "";
$token = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["token"])) {
	$tokenErr1 = "Enter valid Token";
    $tokenErr = "Token is required";
  } 
  else {
		$token = test_input($_POST["token"]);
	// check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ][0-9]*$/",$token)) {
		//$tokenErr = "Only letters, numbers, and white space allowed"; 
    }
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
		<p class="center title bold"><span class="glyphicon glyphicon-star">Delete Records</span></p>  
	<fieldset class="form-group">
		<label for="name">Token</label>
			<input type="text" class="form-control" name="token" value="<?php echo $token;?>" placeholder="Enter Token" required="required">
			<span class="error">* <?php echo $tokenErr;?></span>
			<br><br>
			<input type="submit" class="btn btn-success btn-lg marginTop" name="delete" value="Delete"><br><br>
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