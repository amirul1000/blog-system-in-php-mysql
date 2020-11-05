<?php
include_once "../includes/connection.php";
SESSION_START();
if(isset($_SESSION['author_role'])){
	?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>New Post</title>
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
        <h1 class="h2">Add New Post</h1>
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
	
	<form method="post" enctype="multipart/form-data">
		
		Post Title:<input type="text" name="post_title" minlength="15" maxlength="50" class="form-control"   placeholder="Enter Post Title"><br>
		
		Post Category:<select name="post_category" class="form-control" id="exampleFormControlSelect1">
		<?php
			$sql = "SELECT * FROM `category`";
			$result = mysqli_query($conn,$sql);
			while($row = mysqli_fetch_assoc($result)){
				$category_id = $row['category_id'];
				$category_name = $row['category_name'];
				?>
				<option value="<?php echo $category_id; ?>">
				<?php echo $category_name;?>
				</option>
				<?php
			}
		?>
		</select><br>
		
		Post Content:<textarea name="post_content" class="form-control" id="exampleFormControlTextarea1"rows="3"></textarea><br>
		
		Post Image:<input type="file" name="file" class="form-control-file" id="exampleFormControlFile1"><br>
		
		Post Keywords:<input type="text" name="post_keyword" class="form-control"   placeholder="Enter Post Keywords"><br>

		<button type="submit" name="submit" class="btn btn-primary">Add Post</button>
	</form>
		<?php
			if(isset($_POST['submit'])){
				$post_title = mysqli_real_escape_string($conn,$_POST['post_title']);
				
				$post_category = mysqli_real_escape_string($conn,$_POST['post_category']);
				
				$post_content = mysqli_real_escape_string($conn,$_POST['post_content']);
				
				$post_keyword = mysqli_real_escape_string($conn,$_POST['post_keyword']);
				
				$file = $_FILES['file'];
				
				$post_author = $_SESSION['author_id'];
				$post_date = date("d/m/y");				
			
				//checking if above fields empty
				
				if(empty($post_title) OR empty($post_category) OR empty($post_content)){
					header("Location:newpost.php?message=Empty+Fields");
					exit();
				}
			
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
						$sql = "INSERT INTO `post` (`post_title`,`post_category`,`post_content`,`post_keyword`,`post_image`,`post_author`,`post_date`) VALUES ('$post_title','$post_category','$post_content','$post_keyword','$dbdestination','$post_author','$post_date')";
						if(mysqli_query($conn,$sql)){
							header("Location: post.php?message=Post+Published");
						}else{
							header("Location: newpost.php?message=Error+Publishing");
						}
						}	else {
						header("Location:newpost.php?message=File+Size+Too+Large");
						exit();
					}
					
				}else{
					header("Location:newpost.php?message=Error+Uploading+File");
					exit();
				}
					
			}else{
				header("Location:newpost.php?message=Please+Select+Appropriate+File");
				exit();
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
}else{
	header("Location:login.php?message=Please+Login");
}
?>
