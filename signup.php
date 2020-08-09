<?php
include('connection.php');
if(isset($_POST['submitted'])==1){
	$id_st = 0;
	$pwd_st = 0;
	$email_st = 0;

	$id = $_POST['id'];
	$pwd = mysqli_real_escape_string($dbc, $_POST['pwd']);
	$re_pwd = mysqli_real_escape_string($dbc, $_POST['re-pwd']);
	$email = $_POST['email'];

	$q1 = "SELECT * FROM users WHERE email = '$email'";
	$q2 = "SELECT * FROM users WHERE id = '$id'";
	
	if($pwd == $re_pwd){
		$pwd_st = 1;		
		if(mysqli_num_rows(mysqli_query($dbc, $q1)) == 0){
			$email_st = 1;	
			if(mysqli_num_rows(mysqli_query($dbc, $q2)) == 0){
				$id_st = 1;
				$q = "INSERT INTO users (id, pwd, email) VALUES ('$id', SHA1('$pwd'), '$email')";
				
				$data = mysqli_query($dbc, $q);
				if($data){
					echo "<p class='alert alert-success'>Registration Succesful</p>";
					setcookie ("username",$_POST["id"],time()+ 3600);
					setcookie ("password",$_POST["pwd"],time()+ 3600);
					echo "Cookies Set Successfuly";
				}
				else{
					echo "<p class='alert alert-danger'>Registration failed due to technical error. Please try again...</p>";
				}
			}
			else{
				echo "<p class='alert alert-danger'>Username not available</p>";
				$id_st = -1;
			}
		}
		else{
			echo "<p class='alert alert-danger'>The email address you have entered is already registered</p>";
			$email_st = -1;
		}
	}
	else{
		echo "<p class='alert alert-warning'>Passwords don't match. Please try again...</p>";
		$pwd_st = -1;
	}
}

?>

<html>
<head>
<title>Sign up</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>LogIn/Register | Notes+</title>
	
	<?php include("css.php"); ?>
	<?php include("js.php"); ?>
<head>
<body>
<nav class="navbar navbar-default navbar-static-top">
		<div class="container">
			<ul class="nav navbar-nav">
				<li class="heading"><img src="images/book.png" width="100px" />&nbsp;<strong>VClass</strong> <i class="fa fa-plus-circle" aria-hidden="true"></i></li>
			</ul>
		</div>
	</nav>
<div class="col-md-4">
			</div>
			<div class="col-md-5" style="padding-top: 80px;">
				
				<legend class="form-heading">Sign up</legend>
				<br />
				
				<form method="post">
				  
				  <div class="form-group has-feedback" id="11">
				    <div class="input-group">
					    <span class="input-group-addon">
					    	<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Length: 5-10; Allowed Characters: a-z A-Z 0-9 ._@$%&" aria-hidden="true"></i>
					    </span>
					    <input type="text" class="form-control" name="id" id="id" placeholder="UserID" pattern="[a-zA-Z0-9.@$&_]{5,10}" onclick="removeClass('#11', '#21')" onblur="checkID()" required>
				    </div>
			    	<span class="glyphicon form-control-feedback" id="21" aria-hidden="true"></span>					    
				  </div>
				  <br />
				  <div class="row">
				  	<div class="col-md-6 form-group">
					    <div class="input-group">
						    <span class="input-group-addon">
						    	<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Length: 6-30" aria-hidden="true"></i>
						    </span>
					    	<input type="password" class="form-control" name="pwd" id="pwd" placeholder="Password" pattern=".{6,30}" required>
				    	</div>
				    </div>
				  	
				  	<div class="col-md-6">
				  		<div class="form-group has-feedback" id="12">
				    		<input type="password" class="form-control" name="re-pwd" id="re-pwd" placeholder="Re-enter Password" pattern=".{6,30}" onclick="removeClass('#12', '#22')" onblur="checkPassword()" required>
					    	<span class="glyphicon form-control-feedback" id="22" aria-hidden="true"></span>
				    	</div>
				    </div>
				  </div>
				  <br />
				  <div class="form-group has-feedback" id="13">
			    	<input type="email" class="form-control" name="email" id="email" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" onclick="removeClass('#13', '#23')" onblur="checkEmail()" required>
			    	<span class="glyphicon form-control-feedback" id="23" aria-hidden="true"></span>
				  </div>
				  <br />
				  <p><input type="checkbox" checked="checked" name="remember">
				  By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>
				   <br />
				  <input type="submit" class="btn btn-success" name="submitted" onsubmit="return validate()" value="Create Account"></input>
				  <a type="submit" class="btn btn-success" href="login.php">Sign in</a>
				</form>
			
			</div>
		</div>
	</div>
	<div class="footer">
  		<p>&copy: Copyright CMRIT</p>
	</div>
</body>
</html>
