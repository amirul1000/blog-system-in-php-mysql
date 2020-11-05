<?php 
include_once "../includes/connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Log In</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../style/bootstrap.min.css">
	<link rel="stylesheet" href="../style/style.css">
	
</head>
<body>

	<!--Navigation Bar Starts Here-->
	<?php include_once "../includes/loginnav.php"; ?>
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
	<h1 class="h3 mb-3 font-weight-normal"><b>Please Login</b></h1>
	
	<input type="email" name="author_email"  id="inputEmail" class="form-control" placeholder="Email address"  autofocus><br>
	
	<input type="password" name="author_password" id="inputPassword" class="form-control" placeholder="Password" ><br>
	<button class="btn btn-lg btn-primary btn-block" name="login" type="submit">Log In</button>
	</form>
	</div>	

	<?php
		if(isset($_POST['login'])){
								
			$author_email = mysqli_real_escape_string($conn,$_POST['author_email']);
			
			$author_password = mysqli_real_escape_string($conn,$_POST['author_password']);
			
			//checking if empty field 

			if(empty($author_email) OR empty($author_password)){
				header("Location: login.php?message=Empty+Fields");
				exit();
			}
			
			//checking if email valid
			
			if(!filter_var($author_email,FILTER_VALIDATE_EMAIL)){
				header("Location: login.php?message=Please+Enter+A+Valid+Email");
				exit();
			}else{
				// if email exist
				
				 $sql = "SELECT * FROM `author` WHERE `author_email` = '$author_email'";
				 $result = mysqli_query($conn,$sql);
				
				 if(mysqli_num_rows($result)<=0){
					header("Location: login.php?message=Login+Error");
					exit();
				 }else{
					 while($row=mysqli_fetch_array($result)){
						//check passowrd matches
					 
					 if(!($author_password==$row['author_password'])){
						 
						header("Location: login.php?message=Login+Error");
						exit();
					 }elseif($author_password==$row['author_password']){
							$_SESSION['author_id'] = $row['author_id'];
							$_SESSION['author_name'] = $row['author_name'];
							$_SESSION['author_email'] = $row['author_email'];
							$_SESSION['author_bio'] = $row['author_bio'];
							$_SESSION['author_role'] = $row['author_role'];
							
							header("Location:index.php");
					}
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