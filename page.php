<?php
include_once "includes/connection.php";
include_once "includes/function.php";

if(!isset($_GET['id'])){
	header("Location:index.php");
}else{
	$id = mysqli_real_escape_string($conn,$_GET['id']);
	if(!is_numeric($id)){
		header("Location:index.php?");
		exit();
	}else if(is_numeric($id)){
		
		$sql = "SELECT * FROM `page` WHERE page_id='$id'";
		$result = mysqli_query($conn,$sql); 
		//check if post available
		if(mysqli_num_rows($result)<=0){
			//nopost
			header("Location:index.php?message=noPageFound");
		}else if(mysqli_num_rows($result)>0){
			while($row=mysqli_fetch_array($result)){
				
			$page_title = $row['page_title'];	
			$page_content = $row['page_content'];		
			$page_title2 = $row['page_title'];
?>
				
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $page_title; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="style/bootstrap.min.css">
	<link rel="stylesheet" href="style/style.css">
	
</head>
<body >


	<!--Navigation Bar Starts Here-->
	<?php include_once "includes/nav.php"; ?>
	<!--Navigation Bar Ends Here-->
	
	<!--Jumbotron Starts Here-->
	<?php include_once "includes/jumbo.php"; ?>
	<!--Jumbotron Endss Here-->
	
	<!--Blog Cards Starts Here-->
	<div class="main">
	<div class="container">
		
		<h1 style="width:100%;background-color:grey;padding-top:25px;padding-bottom:25px;text-align:center;"><?php echo $page_title2; ?></h1>
		<hr>
		
		<p><?php echo $page_content;?></p>
	</div>	
	</div>	
	
	

	
	
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/scroll.js"></script>
</body>
</html>
				
				<?php
			}
		}
	}
}

?>