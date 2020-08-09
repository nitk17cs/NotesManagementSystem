<?php 
	
	error_reporting(0);

	session_start();
	
	include("connection.php");
	
	$userid_st = 0;
	$password_st = 0;
	
	if(isset($_POST['logged'])==1){
		$password = mysqli_real_escape_string($dbc, $_POST['password']);
		
		$q1 = "SELECT * FROM admin WHERE id='$_POST[userid]'";
		$q2 = "SELECT * FROM admin WHERE id='$_POST[userid]' AND pwd=('$password')";
				
		if(mysqli_num_rows(mysqli_query($dbc, $q1))==1){
			$userid_st = 1;
			if(mysqli_num_rows(mysqli_query($dbc, $q2))==1){
				$password_st = 1;
				$_SESSION['username'] = $_POST['userid'];
				header("Location: admin_home.php");
			}
			else{
				$password_st = -1;
			}
		}
		else{
			$userid_st = -1;
			$password_st = -1;
		}
	}
	 
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>LogIn/Register | Notes+</title>
	
	<?php include("css.php"); ?>
	<?php include("js.php"); ?>

</head>
<body>
	
	<nav class="navbar navbar-default navbar-static-top">
	<button onclick="location.href='index.html'" class="btn"><i class="fa fa-home"></i></button>
		<div class="container">
			<ul class="nav navbar-nav">
				<li class="heading" style="margin-left: -140px;"><img src="images/book.png" width="100px" />&nbsp;<strong>Notes</strong> <i class="fa fa-plus-circle" aria-hidden="true"></i></li>
			</ul>
		</div>
	</nav>
	
	<div class="container">
<div class="col-md-4">
			</div>
			<div class="col-md-3" style="padding-top: 80px;">

				<legend class="form-heading">Sign in</legend>
				<br />

				<form action="" method="post">
	        		<div class="form-group<?php if($userid_st==1){echo " has-success has-feedback";}elseif($userid_st==-1){echo " has-error has-feedback";} ?>">
	          			<input type="text" id="userid" name="userid" class="form-control" placeholder="UserID" value="<?php if(isset($_COOKIE['username'])) { echo $_COOKIE['username']; } ?>" required>
					    <?php if($userid_st==1){ ?>
					    	<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
					    <?php }elseif($userid_st==-1){ ?>
					    	<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
					    <?php } ?>
	        		</div>
	        		<br />
	        		<div class="form-group<?php if($password_st==1){echo " has-success has-feedback";}elseif($password_st==-1){echo " has-error has-feedback";} ?>">
	          			<input type="password" id="password" name="password" class="form-control" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>" placeholder="Password" required>
					    <?php if($password_st==1){ ?>
					    	<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
					    <?php }elseif($password_st==-1){ ?>
					    	<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
					    <?php } ?>
	        		</div>
	        		<br />
	        		<div class="form-group">
	        			<input type="submit" class="btn btn-primary" name="logged" value="Sign In"></input>
	        		</div>
	      		</form>
				
			</div>

			<div class="footer">
  				<p>&copy: Copyright CMRIT</p>
			</div>
			
</body>
</html>