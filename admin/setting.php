<?php
include_once "../includes/connection.php";
include_once "../includes/function.php";
SESSION_START();
if(isset($_SESSION['author_role'])){
	if($_SESSION['author_role']=="admin"){
		
	
	?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Settings</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../style/bootstrap.min.css">
	<link rel="stylesheet" href="../style.css">
	
</head>
<body>

<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap  shadow">
	<a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="post.php"><b>BlogSystem</b></a>
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
        <h1 class="h2">Settings</h1>
        <center><h6> Howdy <?php 
		echo $_SESSION['author_name'];
		?> | Your Role Is <?php echo $_SESSION['author_role'];?></h6></center>
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
		
		<h4>All Settings</h4><br>
		
		<form method="post">
		Home Page JumboTron Title
		<input type="text" name="home_jumbo_title" class="form-control" placeholder="Enter Jumbo Title" value="<?php getSettingValue("home_jumbo_title") ?>"><br>
		
		Home Page JumboTron Description
		<input type="text" name="home_jumbo_desc" class="form-control" placeholder="Enter Jumbo Description" value="<?php getSettingValue("home_jumbo_desc") ?>"><br>
		<button name="submit" class="btn btn-success">
		Update Settings</button>
		</form><br>	
			
			<?php
			if(isset($_POST['submit'])){
				$jumboTitle = mysqli_real_escape_string($conn,$_POST['home_jumbo_title']);
				$jumboDesc = mysqli_real_escape_string($conn,$_POST['home_jumbo_desc']);
				
				setSettingValue("home_jumbo_title",$jumboTitle);
				setSettingValue("home_jumbo_desc",$jumboDesc);
				header("Location: setting.php?message=Settings+Updated");
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
	}
}else{
	header("Location:login.php?message=Please+Login");
}
?>
