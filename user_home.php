<?php

	session_start();
	
	if(!isset($_SESSION['username'])){
		header("Location: login.php");
	}

	error_reporting(0);
	
	include("connection.php");

?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<title>VClass+</title>
	
	<?php include("css.php"); ?>
	<?php include("js.php"); ?>
</head>
<body>
	<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-dark">
	<button onclick="location.href='user_home.php'" class='btn'><i style="font-size=5px" class="fa fa-home"></i></button>
	<div class="heading">
	<img src="images/book.png" width="120px" height="60px" />&nbsp;<strong>Notes</strong><i class="fa fa-plus-circle" aria-hidden="true"></i>
	</div>
  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
    	<span class="navbar-toggler-icon"></span>
  	</button>
  	<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
    	<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      	<li class="nav-item active">
        <li class="<?php if($_GET['page']==1){ echo 'active'; } ?> "><a class="nav-link" href="?page=1">Upload</a></li>
      	</li>
      	<li class="nav-item">
        <li class="<?php if($_GET['page']==2){ echo 'active'; } ?> "><a class="nav-link" href="?page=2">Download</a></li>
      	</li>
      	<li class="nav-item">
        <li class="<?php if($_GET['page']==3){ echo 'active'; }?> "><a class="nav-link" href="?page=3">Profile Settings</a></li>
      	</li>
	<li class="nav-item">
	<li class="navbar-right"><a class="nav-link" href="logout.php">Log Out</a></li>
	</li>
    	</ul>
  	</div>
	</nav>

	<div class="container">
	</div>
	<?php 
		$flag=0;
			switch($_GET['page']){
				case 1: {include("upload.php"); $flag = 1; break;}
				case 2: {include("download.php"); $flag=1; break;}
				case 3: {include("pr_settings.php"); $flag=1; break;}
			} 
			if($flag == 0){
		?>
	<div class="container">
	<h2 class="form-heading">Download</h2>
	<br />
	<legend>Filter Search : </legend>
    <form action="" method="post" class="form-inline">
		<div class="form-group" style="margin-bottom: 17px;">
			
			<label for="filter_b">Branch : </label>
			<select class="form-control" id="filter_b" name="filter_b" required>
			  <option value="">Select Branch</option>
				  
				  <?php 
				  
				  	$q = "SELECT * FROM courses";
					$r = mysqli_query($dbc, $q);
					
				  	while($row = mysqli_fetch_array($r)){ 
				  
				  ?>			
				  
				  		<option value="<?php echo $row['code']; ?>"<?php if(isset($_POST['go'])){ if($_POST['filter_b']==$row['code']){ echo " selected"; } } ?>><?php echo $row['name']; ?></option>
				  
				  <?php } ?>
				
			</select>			
		</div> &nbsp;&nbsp;&nbsp;
		<div class="form-group" style="margin-bottom: 17px;">
			<label for="filter_s">Semester : </label>
			<select class="form-control" id="filter_s" name="filter_s" required>
			  <option value="">Select Sem</option>
				  
				  <?php for($i=1;$i<=10;$i++){ 
				  			if($i==1){
				  ?>			

				  		<option value="EASY"<?php if(isset($_POST['go'])){ if($_POST['filter_s']=='EASY'){ echo " selected"; } } ?>>EASY</option>

				  <?php } elseif($i==2){ ?>

				  		<option value="HARD"<?php if(isset($_POST['go'])){ if($_POST['filter_s']=='HARD'){ echo " selected"; } } ?>>HARD</option>

				  <?php } else{ ?>		
				  	
					  	<option value="<?php echo $i; ?>"<?php if(isset($_POST['go'])){ if($_POST['filter_s']==$i){ echo " selected"; } } ?>><?php echo $i; ?></option>
				  
				  <?php }} ?>
				
			</select>			
		</div> &nbsp;&nbsp;&nbsp;
		<input type="submit" class="btn btn-default" name="go" value="Go">
    </form>
	<br />
	<br />
    
    <table class="table table-hover">
        <tr>
            <th>Created</th>
            <th>Filename</th>
            <th>Branch</th>
            <th>Sem</th>
            <th>Description</th>
            <th>View</th>
        </tr>
        
        <?php

        if (isset($_POST['go'])==1) {
        	if($_POST['filter_b']=="ALL"){
				$q = "SELECT * FROM admin_docs WHERE semester='$_POST[filter_s]' ORDER BY created";        		
        	}
			else{
				$q = "SELECT * FROM admin_docs WHERE branch='$_POST[filter_b]' AND semester='$_POST[filter_s]' ORDER BY created";
			}
		}
		else{
			$q = "SELECT * FROM admin_docs ORDER BY created DESC";
        }
		
        $r = mysqli_query($dbc, $q);
	
	
        $i = 1;
	$allowed = array('mp4','avi','3gp','mov','mpeg');
        while($row = mysqli_fetch_array($r)) { 
	$fileExt = mysqli_query($dbc, "select substring_index(filename,'.',-1) as AllFileExtension from admin_docs");
	if (in_array($fileExt, $allowed)) {	
        ?>
	<video width="300" height="200" controls>
	<scorce src="test_upload/<?php echo $row['filename']; ?>" type="video">
	</video>
	<?php }?>

        <tr>
	    <td><?php echo $row['created']; ?></td>
            <td><?php echo $row['filename']; ?></td>
            <td><?php echo $row['branch']; ?></td>
            <td><?php echo $row['semester']; ?></td>
	    <td><?php echo $row['description']; ?></td>
            <td><a href="view_file.php?doc=<?php echo $row['filename']; ?>" target="_blank"><i class="fa fa-file" aria-hidden="true"></i></a></td>
        </tr>
	<?php } ?>
    
    </table>
</div>
<?php } ?>
	
		
</body>
</html>