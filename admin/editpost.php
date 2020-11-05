<?php
include_once "../includes/connection.php";
SESSION_START();
if(isset($_SESSION['author_role'])){
	if($_SESSION['author_role']=="admin"){
		if(isset($_GET['id'])){
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
        <h1 class="h2">Edit Post</h1>
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
		$post_id = $_GET['id'];
		$Formsql = "SELECT * FROM `post` WHERE post_id = '$post_id'";
		$Formresult = mysqli_query($conn,$Formsql);
		while($Formrow=mysqli_fetch_assoc($Formresult)){
			$postTitle = $Formrow['post_title'];
			$postContent = $Formrow['post_content'];
			$postImage = $Formrow['post_image'];
			$postKeyword = $Formrow['post_keyword'];
	?>
	<form method="post" enctype="multipart/form-data">
		
		Post Title:<input type="text" name="post_title" minlength="15" maxlength="50" class="form-control"   placeholder="Enter Post Title" value="<?php echo $postTitle;?>"><br>
		
		Post Content:<textarea name="post_content" class="form-control" id="exampleFormControlTextarea1"rows="5"><?php echo $postContent; ?></textarea><br>
		
		<img src="../<?php echo $postImage;?>" width="180px"height="150px"><br>
		
		Post Image:<input type="file" name="file" class="form-control-file" id="exampleFormControlFile1"><br>
		
		Post Keywords:<input type="text" name="post_keyword" class="form-control"   placeholder="Enter Post Keywords" value="<?php echo $postKeyword;?>"><br>

		<button type="submit" name="update" class="btn btn-primary">Update Post</button>
	</form>
		<?php } ?>
		<?php
			if(isset($_POST['update'])){
				$post_title = mysqli_real_escape_string($conn,$_POST['post_title']);
				
				
				$post_content = mysqli_real_escape_string($conn,$_POST['post_content']);
				
				$post_keyword = mysqli_real_escape_string($conn,$_POST['post_keyword']);
								
			
				//checking if above fields empty
				
				if(empty($post_title) OR empty($post_content)){
					echo '<script>window.location = "post.php?message=Empty+Fields"</script>';
					exit();
				}
				
				if(is_uploaded_file($_FILES['file']['tmp_name'])){
					//user wants to update the image too
					
					$file = $_FILES['file'];

			$fileName = $file['name'];
			$fileType = $file['type'];
			$fileTmp = $file['tmp_name'];
			$fileErr = $file['error'];
			$fileSize = $file['size'];
			
			$fileExt = explode('.', $fileName);
			
			$fileExtension = strtolower(end($fileExt));
			
			$allowedExt = array("jpg","jpeg","png","gif");
			
			if(in_array($fileExtension,$allowedExt)){
				if($fileErr===0){
					if($fileSize <10000000){
						$newFileName=uniqid('',true).'.'.$fileExtension;
						$destination="../uploads/$newFileName";
						$dbdestination="uploads/$newFileName";
						move_uploaded_file($fileTmp,$destination);
						$sql = "UPDATE  `post` SET post_title = '$post_title',post_content = '$post_content',post_keyword = '$post_keyword',post_image='$dbdestination' WHERE post_id = '$post_id'";
						if(mysqli_query($conn,$sql)){
							header("Location: post.php?message=Post+Updated");
						}else{
							header("Location: post.php?message=Error+Updating");
						}
						}	else {
						header("Location:newpost.php?message=File+Size+Too+Large");
						exit();
					}
					
				}else{
					echo '<script>window.location = "newpost.php?message=Error+Uploading+File"</script>';
					exit();
				}
					
			}else{
				echo '<script>window.location = "newpost.php?message=Please+Select+Appropriate+File"</script>';
				exit();
				}
					
				}else{
					//user not updating image
				
				$sql = "UPDATE  `post` SET post_title = '$post_title',post_content = '$post_content',post_keyword = '$post_keyword' WHERE post_id = '$post_id'";
				}
				if(mysqli_query($conn,$sql)){
				echo '<script>window.location = "post.php?message=Post+Updated"</script>';
				}else{
				echo '<script>window.location = "post.php?message=Error+Updating"</script>';
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
	<?php } }else{
		echo '<script>window.location = "index.php"</script>';
	}
}else{
	echo '<script>window.location = "login.php?message=Please+Login"</script>';
}
?>
