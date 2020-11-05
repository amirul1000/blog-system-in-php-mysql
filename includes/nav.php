<?php 
include_once "includes/connection.php";
SESSION_START();
?>
	<link rel="stylesheet" href="style/style.css">
	<nav class="navbar navbar-expand-lg navbar-light" >
	<a class="navbar-brand" href="index.php"><b>BlogSystem</b></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mx-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php"><b>Posts</b> <span class="sr-only">(current)</span></a>
      </li>
	  
	  <?php
	  
	  $sqlpage = "SELECT * FROM page";
		$resultpage = mysqli_query($conn,$sqlpage);
		
		while($rowpage=mysqli_fetch_array($resultpage)){
			$page_id = $rowpage['page_id'];
			$page_title = $rowpage['page_title'];
			
			?> 
			
			<li class="nav-item">
			<a class="nav-link" href="page.php?id=<?php echo $page_id;?>"><b><?php echo $page_title;?></b></a>
			</li>
	  
	  <?php
		}
	  ?>
	  
      
      <li class="nav-item dropdown" >
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <b>All Categories</b>
        </a>
		
		<div class="dropdown-menu" aria-labelledby="navbarDropdown">
		
		<?php
		$sql = "SELECT * FROM category";
		$result = mysqli_query($conn,$sql);
		
		while($row=mysqli_fetch_array($result)){
			$category_id = $row['category_id'];
			$category_name = $row['category_name'];
			
			?> 
			
			<a class="dropdown-item" href="category.php?id=<?php echo $category_id ?>"><?php echo $category_name; ?></a>
			
			
			<?php
		}
		?>
		
        
         
       
        
        </div>
      </li>
    </ul>
	<a href="../blog/admin/signup.php"><button type="button" class="btn btn-dark"><b>Sign Up</b></button></a>
	
	<a href="../blog/admin/login.php"><button type="button" class="btn btn-dark"><b>Admin Login</b></button></a>
	
	<a href="../blog/admin/login.php"><button type="button" class="btn btn-dark"><b>Author Login</b></button></a>

    <form action="search.php" class="form-inline my-2 my-lg-0">
      <input name="s" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>