<?php
include_once "../includes/connection.php";
include_once "../includes/function.php";
session_start();

if(!isset($_GET['id'])){
	header("Location: page.php?message=Please+Click+The+Edit+Button");
	exit();
}else{
	if(!isset($_SESSION['author_role'])){
	header("Location: page.php?message=Please+Login");
	exit();	
	}else{
		if($_SESSION['author_role']!="admin"){
			echo "You Cannot Access This Page";
		}else{
			$page_id= $_GET['id'];
			$sql = "SELECT * FROM page WHERE page_id = '$page_id'";
			$result=mysqli_query($conn,$sql);
			
			if(mysqli_num_rows($result)<=0){
				//we dont have any page for this id
				header("Location: page.php?message=No+Page+Found");
				exit();
			}else{
				?>
				
				
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Edit Post</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../style/bootstrap.min.css">
	<link rel="stylesheet" href="../style.css">
	
</head>
<body>

<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap  shadow">
	<a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="post.php">Let`s Blog</a>
	<button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
	</button>
	<input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
	<ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="logout.php">Log out</a>
    </li>
	</ul>
</nav>

<div class="container-fluid">
  <div class="row">
    
	<?php include_once "nav.inc.php"; ?>
    
	<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Page</h1>
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
	<?php
		$page_id = $_GET['id'];
		$Formsql = "SELECT * FROM `page` WHERE page_id = '$page_id'";
		$Formresult = mysqli_query($conn,$Formsql);
		while($Formrow=mysqli_fetch_assoc($Formresult)){
			$pageTitle = $Formrow['page_title'];
			$pageContent = $Formrow['page_content'];
			
	?>
	<form method="post" enctype="multipart/form-data">
		
		Page Title:<input type="text" name="page_title" class="form-control"   placeholder="Enter Page Title" value="<?php echo $pageTitle;?>"><br>
		
		Page Content:<textarea name="page_content" class="form-control" id="exampleFormControlTextarea1"rows="5"><?php echo $pageContent; ?></textarea><br>
		
		
		<button type="submit" name="update" class="btn btn-primary">Update Page</button>
		
	</form>
		<?php } ?>
		<?php
			if(isset($_POST['update'])){
				$page_title = mysqli_real_escape_string($conn,$_POST['page_title']);
				
				$page_content = mysqli_real_escape_string($conn,$_POST['page_content']);
				
				//checking if above fields empty
				
				if(empty($page_title) OR empty($page_content)){
					echo '<script>window.location = "page.php?message=Empty+Fields"</script>';
					exit();
				}
					
				
				$sql = "UPDATE  `page` SET page_title = '$page_title',page_content = '$page_content' WHERE page_id = '$page_id'";
				
				if(mysqli_query($conn,$sql)){
				echo '<script>window.location = "page.php?message=Page+Updated"</script>';
				}else{
				echo '<script>window.location = "page.php?message=Error+Updating"</script>';
				}
			}
	?>
	  
		
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
		}
	}
}

?>