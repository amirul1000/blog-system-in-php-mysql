<?php
include_once "includes/connection.php";
include_once "includes/function.php";

if(!isset($_GET['id'])){
	header("Location:index.php");
}else{
	$id = mysqli_real_escape_string($conn,$_GET['id']);
	if(!is_numeric($id)){
		header("Location:index.php");
		exit();
	}else if(is_numeric($id)){
		
		$sql = "SELECT * FROM `category` WHERE category_id='$id'";
		$result = mysqli_query($conn,$sql); 
		//check if category exists
		if(mysqli_num_rows($result)<=0){
			//nocategory
			header("Location:index.php?message=No+Result");
		}else {
		?>
		
		<?php
include_once "includes/connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo getCategoryName($id)?> Posts</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="style/bootstrap.min.css">
	<link rel="stylesheet" href="style/style.css">
	
</head>
<body>


	<!--Navigation Bar Starts Here-->
	<?php include_once "includes/nav.php"; ?>
	<!--Navigation Bar Ends Here-->
	
	<!--Jumbotron Starts Here-->
	<?php include_once "includes/jumbo.php"; ?>
	<!--Jumbotron Endss Here-->
	
	<h1 style="text-align:center;"><b>Showing All Posts For Category <?php echo getCategoryName($id)?></b></h1>
	
	<!--Blog Cards Starts Here-->
	<div class="categorymain">
	<div class="container">
	
	<div class="row card-columns" style="padding-top:100px;">
	<?php
		$sql = "SELECT * FROM `post`WHERE post_category='$id' ORDER BY post_id DESC";
		
		$result = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$post_title = $row['post_title'];
			$post_image = $row['post_image'];
			$post_author = $row['post_author'];
			$post_content = $row['post_content'];
			$post_id = $row['post_id'];
			
			$sqlauth = "SELECT * FROM `author` WHERE author_id = '$post_author'";
			$resultauth = mysqli_query($conn,$sqlauth);
			while($authrow=mysqli_fetch_array($resultauth)){
				$post_author_name = $authrow['author_name'];
			
		
	?>
	<div class="card" style="width:16rem;">
		<img src="<?php echo $post_image; ?>" class="card-img-top" alt="...">
	<div class="card-body">
		<h5 class="card-title"><?php echo $post_title; ?></h5>
		<h6 class="card-subtitle mb-2 text-muted"><?php echo $post_author_name; ?></h6>
		<p class="card-text"><?php echo substr(strip_tags($post_content),0,100)."..."; ?></p>
		<a href="post.php?id=<?php echo $post_id ;?>" class="btn btn-primary">Read More</a>
	</div>
	</div>
		<?php } }?>
	</div>	
	</div>
	</div>
	
	<!--Blog Card Endss Here-->
	
	
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/scroll.js"></script>
</body>
</html>
		
		<?php
		}
	}
}
?>