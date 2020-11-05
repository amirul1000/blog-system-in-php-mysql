<?php
include_once "../includes/connection.php";
SESSION_START();
if(isset($_SESSION['author_id'])){
	?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $_SESSION['author_role'];?> Dashboard</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../style/bootstrap.min.css">
	<link rel="stylesheet" href="../style.css">
	
</head>
<body>

<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap  shadow">
	<a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#"><b>BlogSystem</b></a>
	<button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
	</button>
	<input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
	<ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="logout.php"><b>Log out</b></a>
    </li>
	</ul>
</nav>

<div class="container-fluid">
  <div class="row">
    
	<?php include_once "nav.inc.php"; ?>
    
	<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <h6> Howdy <?php 
		echo $_SESSION['author_name'];
		?> | Your Role Is <?php echo $_SESSION['author_role'];?></h6>
      </div>
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
	  
		<div id="admin-index-form">
		<h3>Your Profile</h3>
		<form method="post">
		Name:<input name="author_name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Name" value="<?php echo $_SESSION['author_name'];?>"><br>
		Email:<input name="author_email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Email" value="<?php echo $_SESSION['author_email'];?>">
		<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small><br>
		Password:<input name="author_password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter Password"><br>
		Your Bio:<textarea name="author_bio" class="form-control" id="exampleInputPassword1" rows="3"><?php echo $_SESSION['author_bio'];?></textarea><br>
		<button type="submit" name="update" class="btn btn-primary">Update</button>
		</form>
<?php
			if(isset($_POST['update'])){
				$author_name = mysqli_real_escape_string($conn,$_POST['author_name']);
				
	 			$author_email = mysqli_real_escape_string($conn,$_POST['author_email']);
				
				$author_password = mysqli_real_escape_string($conn,$_POST['author_password']);
				
				$author_bio = mysqli_real_escape_string($conn,$_POST['author_bio']);
				
				//checking if empty fields
				
				if(empty($author_name) OR empty($author_email) OR empty($author_bio) OR empty($author_bio)){
					echo "Empty Fields";
				}else{
					//checking if email valid
				if(!filter_var($author_email,FILTER_VALIDATE_EMAIL)){
					echo "Please Enter A Valid Email";	
				}else{
					//check if password is new
				if(empty($author_password)){
					//user dont want to change password
					$author_id = $_SESSION['author_id'];
					$sql = "UPDATE `author` SET author_name='$author_name',author_email='$author_email',author_bio='$author_bio' WHERE author_id='$author_id'";
					if(mysqli_query($conn,$sql)){
						echo "Record Updated";
							$_SESSION['author_name'] = $author_name;
							$_SESSION['author_email'] = $author_email;
							$_SESSION['author_bio'] = $author_bio;
							header("Location: index.php?message=Record+Updated");
						}else{
						echo "Error Updating";
						
					}
				}else{
					//user wants to change password
					$hash = password_hash($author_password,PASSWORD_DEFAULT);
					$author_id = $_SESSION['author_id'];
					$sql = "UPDATE `author` SET author_name='$author_name',author_email='$author_email',author_password='$hash',author_bio='$author_bio' WHERE author_id='$author_id'";
					if(mysqli_query($conn,$sql)){
						echo "Record Updated";
							$_SESSION['author_name'] = $author_name;
							$_SESSION['author_email'] = $author_email;
							$_SESSION['author_password'] = $author_password;
							$_SESSION['author_bio'] = $author_bio;
							session_unset();
							session_destroy();
							header("Location: login.php?message=Record+Updated+Please+Login+With+New+Password");
						}else{
						echo "Error Updating";
					}
				}
			}
		}
	}
?>
		
		</div>
    </main>
  </div>
</div>
	
	
	
	<script src="../js/jquery.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/scroll.js"></script>
	<script src="https://cdn.tiny.cloud/1/wo9t72eysstjisfoybj8nk8qhhnbfqvgcd1lzpjscbudukhm/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
	<script>tinymce.init({selector:'textarea'});</script>
</body>
</html>	
	<?php
}else{
	header("Location:login.php?message=Please+Login");
}
?>
