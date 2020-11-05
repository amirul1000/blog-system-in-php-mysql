<?php
include_once "includes/connection.php";
include_once "includes/function.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>BlogPoint</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="style/bootstrap.min.css">
	<link rel="stylesheet" href="style/style.css">
	
</head>
<body>


	<!--Navigation Bar Starts Here-->
	<?php include_once "includes/nav.php"; ?>
	<!--Navigation Bar Ends Here-->
	
	<div class="jumbotron jumbotron-fluid">
	<div class="container">
    <h1 class="display-4"><?php getSettingValue("home_jumbo_title");?></h1>
    <p class="lead"><?php getSettingValue("home_jumbo_desc");?></p>
	</div>
	</div>
	
	<!--Blog Cards Starts Here-->
	<div class="main">
	<div class="container">
	
	<?php
	
		//pagination
		$sqlpg = "SELECT * FROM `post`";
		$resultpg = mysqli_query($conn,$sqlpg);
		$totalpost = mysqli_num_rows($resultpg);
		$totalpage =  ceil($totalpost/4);
		
	?>
	<?php
		//pagination getSettingValue
		if(isset($_GET['p'])){
			$pageid = $_GET['p'];
			$start = ($pageid*4)-4;
			$sql = "SELECT * FROM `post` ORDER BY post_id DESC LIMIT $start,4";
		}else{
			$sql = "SELECT * FROM `post` ORDER BY post_id DESC LIMIT 0,4";
		}
	?>
	<div class="row card-columns">
	<?php
		
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
		
	</div>	<br>
		<?php
			echo "<center>";
			for($i=1;$i<=$totalpage;$i++){
				?>
				<a href="?p=<?php echo $i;?>"><button class="btn btn-info"><?php echo $i;?></button></a>&nbsp;
				
				<?php
				}
			echo "</center>";
		?>
		
	</div>
	</div>

	
	<!--Blog Card Endss Here-->
	
	
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/scroll.js"></script>
</body>
</html>