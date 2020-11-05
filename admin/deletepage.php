<?php
	session_start();
	include_once "../includes/connection.php";
	
	if(!isset($_GET['id'])){
		header("Location: page.php?message=Please+Click+Delete+Button");
		exit();
	}else{
		//check if session is active
		
	if(!isset($_SESSION['author_role'])){
		header("Location: page.php?message=Please+Login");
	}else {
		if($_SESSION['author_role']!="admin"){
			echo "You Cannot Access This Page.";
			exit();
		}else if($_SESSION['author_role']=="admin"){
			$id = $_GET['id'];
			
			$sqlCheck =  "SELECT * FROM `page` WHERE page_id = '$id'";
			$result = mysqli_query($conn,$sqlCheck);
			if(mysqli_num_rows($result)<=0){
				header("Location:page.php?message=No+File");
				exit();
			}
			
			$sql = "DELETE FROM `page` WHERE page_id = '$id'";
			if(mysqli_query($conn, $sql)){
				header("Location: page.php?message=Page+Deleted+Successfully");
				exit();
			}else{
				header("Location: page.php?message=Could+Not+Delete+Your+Page");
				exit();
			}
		}
	}	
}
?>