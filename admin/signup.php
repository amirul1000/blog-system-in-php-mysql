<?php 
include_once "../includes/connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Sign Up</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../style/bootstrap.min.css">
	<link rel="stylesheet" href="../style/style.css">
	
</head>
<body>

	<!--Navigation Bar Starts Here-->
	<?php include_once "../includes/signupnav.php"; ?>
	<!--Navigation Bar Ends Here-->
	
	<?php 
		if(isset($_GET['message'])){
			$msg = $_GET['message'];
			
			echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
			'.$msg.'
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
			</div>';
		}
	?>

	<div style="width:500px;margin:auto;margin-top:250px;">
	<form method="post" class="form-signin">
	<h1 class="h3 mb-3 font-weight-normal"><b>Please Sign Up</b></h1>
	<input type="text" name="author_name" id="input" class="form-control" placeholder="Enter Name"autofocus><br>
	
	<input type="email" name="author_email"  id="inputEmail" class="form-control" placeholder="Email address"  autofocus><br>
	
	<input type="password" name="author_password" id="inputPassword" class="form-control" placeholder="Password" ><br>
	<button class="btn btn-lg btn-primary btn-block" name="signup" type="submit">Sign Up</button>
</form>
	
</div>	

	<?php
		if(isset($_POST['signup'])){
						
			$author_name = mysqli_real_escape_string($conn,$_POST['author_name']);
			
			$author_email = mysqli_real_escape_string($conn,$_POST['author_email']);
			
			$author_password = mysqli_real_escape_string($conn,$_POST['author_password']);
			
			//checking if empty field 

			if(empty($author_name) OR empty($author_email) OR empty($author_password)){
				header("Location: signup.php?message=Empty+Fields");
				exit();
			}
			
			//checking if email valid
			
			if(!filter_var($author_email,FILTER_VALIDATE_EMAIL)){
				header("Location: signup.php?message=Please+Enter+A+Valid+Email");
				exit();
			}else{
				// if email exist
				
				 $sql2 = "SELECT * FROM `author` WHERE `author_email` = '$author_email'";
				 $result = mysqli_query($conn,$sql2);
				
				 if(mysqli_num_rows($result)>0){
					header("Location: signup.php?message=Email+Already+Exist");
					exit();
				 }else{
					// hashing passs
					$hash = password_hash($author_password,PASSWORD_DEFAULT);	
					$hash = $author_password;	
					
					// signining up the user
				
					$sql = "INSERT INTO `author` (`author_name`,`author_email`,`author_password`,`author_bio`,`author_role`) VALUES ('$author_name','$author_email','$hash','Enter Bio','author')";
					
					if(mysqli_query($conn,$sql)){
						header("Location: signup.php?message=Registered+Successfully");
						exit();
					}else{
						header("Location: signup.php?message=Registration+Failed");
						exit();
					 }	
				 }					
			}
		}
	?>
	
	
	
	<script src="../js/jquery.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/scroll.js"></script>
</body>
</html>