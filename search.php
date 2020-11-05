<?php
include_once "includes/connection.php";

if(!isset($_GET['s'])){
	header("Location:index.php?message=here");
	exit();
}else{
	
	$search = mysqli_real_escape_string($conn,$_GET['s']);
	
	
	?>
	
	
	<!DOCTYPE html>
<html lang="en">
<head>
	<title>Blogs</title>
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
	
	<!--Blog Cards Starts Here-->
	<div class="container">
	<h1 style="text-align:center;">Showing All Results For Search
	<?php echo $search; ?>
	</h1>
	<div class="row card-columns" style="padding-top:20px;">
	<?php
		$sql = "SELECT * FROM `post` WHERE `post_title` LIKE '%$search%' OR `post_content` LIKE '%$search%' OR `post_keyword` LIKE '%$search%'";
		
		$result = mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)<=0){
			echo "No Result Found";
			
		}else{
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
	
	<!--Blog Card Endss Here-->
	
	
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/scroll.js"></script>
</body>
</html>
	
	
	<?php
}}

?>