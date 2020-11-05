<?php
include_once "../includes/connection.php";
SESSION_START();
if(isset($_SESSION['author_role'])){
	if($_SESSION['author_role']=="admin"){
	?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Category</title>
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
        <h1 class="h2">Category</h1>
        
		<center><h6> Howdy <?php 
		echo $_SESSION['author_name'];
		?> | Your Role Is <?php echo $_SESSION['author_role'];?></h6></center>
		
		<button id="addCatBtn" class="btn btn-info">Add New Category</button>
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
		
		<h4>All Categories</h4><br>
		
		<div style="display:none;" id="addCatForm">
		<form action="addcat.php" method="post">
		<input type="text" name="category_name" class="form-control" placeholder="Category Name"><br>
		
		<button name="submit" class="btn btn-success">Add Category</button>
		</form><br>
		</div>
		
		<table class="table">
			  <thead>
				<tr>
				  <th scope="col">Categort Id</th>
				  <th scope="col">Category Name</th>
				</tr>
			  </thead>
			  <tbody>
	<?php
			  $sql = "SELECT * FROM `category` ORDER BY category_id DESC";
		
		$result = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$category_id = $row['category_id'];
			$category_name = $row['category_name'];
			
		
	?>
				<tr>
				  <th scope="row"><?php echo $category_id;?></th>
				  <td><?php echo $category_name;?></td>
				 
				</tr>
	
		<?php  } ?>
			  
			  </tbody>
		</table>
	</div>
    </main>
  </div>
</div>
	
	
	
	<script src="../js/jquery.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/scroll.js"></script>
	<script>
		$(document).ready(function(){
			$("#addCatBtn").click(function(){
				$("#addCatForm").slideToggle();
			})
		});
	</script>
</body>
</html>	
	<?php }
}else{
	header("Location:login.php?message=Please+Login");
}
?>
