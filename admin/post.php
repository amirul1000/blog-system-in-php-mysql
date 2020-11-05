<?php
include_once "../includes/connection.php";
SESSION_START();
if(isset($_SESSION['author_role'])){
	?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Posts</title>
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


<?php
	
		//pagination
		$sqlpg = "SELECT * FROM `post`";
		$resultpg = mysqli_query($conn,$sqlpg);
		$totalpost = mysqli_num_rows($resultpg);
		$totalpage =  ceil($totalpost/5);
		
	?>
	<?php
		//pagination getSettingValue
		if(isset($_GET['p'])){
			$pageid = $_GET['p'];
			$start = ($pageid*5)-5;
			$sql = "SELECT * FROM `post` ORDER BY post_id DESC LIMIT $start,5";
		}else{
			$sql = "SELECT * FROM `post` ORDER BY post_id DESC LIMIT 0,5";
		}
?>
	
	
  <div class="row">
  
    <?php include_once "nav.inc.php"; ?>
    
	<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Posts</h1>
        <center><h6> Howdy <?php 
		echo $_SESSION['author_name'];
		?> | Your Role Is <?php echo $_SESSION['author_role'];?></h6></center>
		<a href="newpost.php"><button class="btn btn-info">Add New Post</button></a>
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
		
		<h4>All Posts</h4><br>
		
		<table class="table">
			  <thead>
				<tr>
				  <th scope="col">Post Id</th>
				  <th scope="col">Post Title</th>
				  <th scope="col">Post Image</th>
				  <th scope="col">Post Author</th>
				  <?php if($_SESSION['author_role']=="admin"){
				  ?>
				  <th scope="col">Action</th>
				  <?php } ?> 
				</tr>
			  </thead>
			  <tbody>
	<?php
			  
		$result = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$post_title = $row['post_title'];
			$post_image = $row['post_image'];
			$post_author = $row['post_author'];
			$post_content = $row['post_content'];
			$post_id = $row['post_id'];
			$post_date = $row['post_date'];
			
			$sqlauth = "SELECT * FROM `author` WHERE author_id = '$post_author'";
			$resultauth = mysqli_query($conn,$sqlauth);
			while($authrow=mysqli_fetch_array($resultauth)){
				$post_author_name = $authrow['author_name'];
			
		
	?>
				<tr>
				  <th scope="row"><?php echo $post_id;?></th>
				  <td><?php echo $post_title;?></td>
				  <td><img src="../<?php echo $post_image;?>" width="150px";height="150px"></td>
				  <td><?php echo $post_author_name;?></td>
				  <?php if($_SESSION['author_role']=="admin"){
				  ?>
				  <td>
				  <a href="editpost.php?id=<?php echo $post_id;?>"><button class="btn btn-info">Edit</button></a>
				  
				  <a onClick="return confirm('Are You Sure?');" href="deletepost.php?id=<?php echo $post_id;?>"><button class="btn btn-danger">Delete</button></a>
				  </td>
				  <?php } ?>
				</tr>
	
		<?php } }?>
			  
			  </tbody>
		</table>
	</div>
    </main>
  </div>
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
	
	
	
	<script src="../js/jquery.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/scroll.js"></script>
</body>
</html>	
	<?php
}else{
	header("Location:login.php?message=Please+Login");
}
?>
