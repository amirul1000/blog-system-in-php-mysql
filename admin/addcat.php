<?php

include_once "../includes/connection.php";
session_start();

if(!isset($_POST['submit'])){
	header("Location:category.php?message=Please+Add+Category");
	exit();
}else{
	if(!isset($_SESSION['author_role'])){
		header("Location:login.php");
	}else{
		if($_SESSION['author_role']!="admin"){
		echo("You Can't Access This Page");
		exit();
	}else if($_SESSION['author_role']=="admin"){
		$category_name = $_POST['category_name'];
		
		$sql = "INSERT INTO `category` (`category_name`) VALUES('$category_name')";
		
		if(mysqli_query($conn,$sql)){
			header("Location: category.php?message=Category+Added+Succesfully");
			exit();
		}else{
			header("Location: category.php?message=Error+Adding+Category");
			exit();
			}
		}
	}
}
?>