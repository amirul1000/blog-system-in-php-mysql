<?php 
include_once "connection.php";
SESSION_START();
?>
	<link rel="stylesheet" href="style/style.css">
	<nav class="navbar navbar-expand-lg navbar-light" >
	<a class="navbar-brand" href="../index.php"><b>BlogSystem</b></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mx-auto">
    </ul>
	
	<a href="login.php"><button type="button" class="btn btn-dark"><b>Admin Login</b></button></a>
	
	<a href="#"><button type="button" class="btn btn-dark"><b>Author Login</b></button></a>

  </div>
</nav>