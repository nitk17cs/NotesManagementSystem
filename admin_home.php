<!DOCTYPE html>
<html>
<head>
<title>upload</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<?php include("css.php"); ?>
	<?php include("js.php"); ?>
</head>
<nav class="navbar navbar-default navbar-static-top">
	<button onclick="location.href='index.html'" class="btn"><i class="fa fa-home"></i></button>
		<div class="container">
			<ul class="nav navbar-nav">
				<li class="heading" style="margin-left: -140px;"><img src="images/book.png" width="100px" />&nbsp;<strong>Notes</strong> <i class="fa fa-plus-circle" aria-hidden="true"></i></li>
			</ul>
		</div>
	</nav>
<body style="overflow: scroll">
<div class="container">
	<div class="row">
		<div class="col-md-3">

			<h2 class="form-heading">Upload</h2>
			<br />    		

<?php
include('connection.php');
if (isset($_POST['uploaded'])==1) {
	
	$file = $_FILES['file'];

	$fileName = $_FILES['file']['name'];
	$fileTmpName = $_FILES['file']['tmp_name'];
	$fileSize = $_FILES['file']['size'];
	$fileError = $_FILES['file']['error'];
	$fileType = $_FILES['file']['type'];

	$fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

	$allowed = array('pdf', 'txt', 'doc', 'docx', 'png', 'jpg', 'jpeg','mp4','avi','3gp','mov','mpeg');

	if (in_array($fileExt, $allowed)) {
		if ($fileError === 0) {
			if ($fileSize < 104857601) {

				$q = "SELECT * FROM admin_docs WHERE filename='$fileName'";
				$file = 'C:\\Docs\\admin_uploads\\';
				if (!file_exists($file)){
				mkdir('C:\\Docs\\admin_uploads\\',0777, true);
				}

				if (mysqli_num_rows(mysqli_query($dbc, $q)) == 0) {

					$fileDestination = 'C:\\Docs\\admin_uploads\\'.$fileName;
					move_uploaded_file($fileTmpName, $fileDestination);
				
					$created = @date('Y-m-d H:i:s');
					$description = mysqli_real_escape_string($dbc, $_POST['description']);
					
					$sql = "INSERT INTO admin_docs (filename, created, branch, semester, description) VALUES ('$fileName', '$created', '$_POST[branch]', '$_POST[semester]', '$description')";
            		mysqli_query($dbc, $sql);
				
					echo "<p class='alert alert-success'>File uploaded successfully</p><br>";
				}
				else{
					echo "<p class='alert alert-warning'>File already exixts. Check it out OR Change your filename and try again...</p><br>";
				}
			}
			else{
				echo "<p class='alert alert-warning'>File too large</p><br>";
			}
		}
		else{
			echo "<p class='alert alert-danger'>Error uploading file</p><br>";
		}
	}
	else{
		echo "<p class='alert alert-danger'>Invalid file type</p><br>";
	}
}

?>

    		<form action="" method="post" enctype="multipart/form-data">
				<div class="form-group">
				    <label for="file">Notes Input* : </label>
				    <div class="input-group">
					    <span class="input-group-addon">
					    	<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Supported File Format: pdf, txt, doc, docx, png, jpg, jpeg" aria-hidden="true"></i>
					    </span>
					    <input type="file" class="btn btn-default" style="width: 225px" id="file" name="file" required>
					</div>
				</div>
				<div class="form-group">
					<label for="branch">Branch* : </label>
						<select class="form-control" id="branch" name="branch" required>
						  <option value="">Select Branch</option>
						  
						  <?php 
						  	$q = "SELECT * FROM courses";
							$r = mysqli_query($dbc, $q);
							
						  	while($row = mysqli_fetch_array($r)){ 
						  
						  ?>			
						  
						  		<option value="<?php echo $row['code']; ?>"><?php echo $row['name']; ?></option>
						  
						  <?php } ?>
						
						</select>
				</div>
				<div class="form-group">
					<label for="semester">Semester* : </label>
					<select class="form-control" id="semester" name="semester" required>
					  <option value="">Select Sem</option>
						  
						  <?php for($i=1;$i<=10;$i++){ 
						  			if($i==1){
						  ?>			
						  
						  			<option value="EASY">EASY</option>
						  
						  <?php } elseif($i==2){ ?>
						  
						  			<option value="HARD">HARD</option>
						  
						  <?php } else{ ?>
						  
						  			<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						  
						  <?php }} ?>
						
					</select>
				</div>
				<div class="form-group">
					<label for="description">Subject(Topic) / Description : </label>
					<textarea class="form-control" id="description" name="description" rows="3"></textarea>
				</div>
    			<input type="submit" class="btn btn-success" name="uploaded" value="Upload">
    		</form>
			
		</div>
		<div class="col-md-1">
		</div>		
		<div class="col-md-8">
			<h2 class="form-heading">My Uploads</h2>
			<br />
		            
					<?php
						if(isset($_GET['id'])==1){
							$id = $_GET['id'];
						
							$q = "SELECT * FROM admin_docs WHERE sl=$id";
							$r = mysqli_fetch_assoc(mysqli_query($dbc, $q));
							unlink("C:\\Docs\\admin_uploads\\".$r['filename']);

							$q = "DELETE FROM admin_docs WHERE admin_docs.sl = $id";
							mysqli_query($dbc, $q);							
						
						}
					
					?>
		            
		    <table class="table table-hover">
		        <tr>
		            <th>Created</th>
		            <th>#</th>
		            <th>Filename</th>
		            <th>Branch</th>
		            <th>Sem</th>
		            <th>Description</th>
		            <th>View</th>
		            <th>Delete</th>
		        </tr>
		        
		        <?php
		
				$q = "SELECT * FROM admin_docs ORDER BY created DESC, created DESC";				
				$r = mysqli_query($dbc, $q);
				
		        $i = 1;
		        while($row = mysqli_fetch_array($r)) { ?>
		        <tr>
		            <td class=""><?php echo $row['created']; ?></td>
		            <td><?php echo $i++; ?></td>
		            <td><?php echo $row['filename']; ?></td>
		            <td><?php echo $row['branch']; ?></td>
		            <td><?php echo $row['semester']; ?></td>
		            <td><?php echo $row['description']; ?></td>
		            <td><a href="view_file1.php?doc=<?php echo $row['filename']; ?>" target="_blank"><i class="fa fa-file" aria-hidden="true"></i></a></td>
		            <td><a href="admin_home.php" id="dele_<?php echo $row['sl']; ?>" class="btn btn-default btn-deleted"><i class="fa fa-trash dislikes" aria-hidden="true"></i></a></td>
		        </tr>
		        <?php } ?>
		    
		    </table>
			
		</div>
	</div>
</div>

</body>
</html>