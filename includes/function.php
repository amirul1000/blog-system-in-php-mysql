<?php
	include_once "connection.php";

	function getAuthorName($id){
		global $conn;
		$sql = "SELECT * FROM `author` WHERE author_id = '$id'";
		$result = mysqli_query($conn,$sql);
		
		while($row = mysqli_fetch_assoc($result)){
			$name = $row['author_name'];
			echo $name;
		}
	}
	
	function getCategoryName($id){
		global $conn;
		$sql = "SELECT * FROM `category` WHERE category_id = '$id'";
		$result = mysqli_query($conn,$sql);
		
		while($row = mysqli_fetch_assoc($result)){
			$name = $row['category_name'];
			echo $name;
		}
	}
	
	function getSettingValue($setting){
		global $conn;
		$sql = "SELECT * FROM `setting` WHERE setting_name = '$setting'";
		$result = mysqli_query($conn,$sql);
		
		while($row = mysqli_fetch_assoc($result)){
			$value = $row['setting_value'];
			echo $value;
		}
	}
	
	function setSettingValue($setting,$value){
		global $conn;
		$sql = "UPDATE setting SET setting_value = '$value' WHERE setting_name = '$setting'";
		if(mysqli_query($conn,$sql)){
			return true;
		}else{
			return false;
		}
	}
?>