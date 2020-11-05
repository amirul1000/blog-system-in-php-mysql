<!DOCTYPE HTML>
<html lang="en">

<head>
	<title>Upload A File</title>
<head>

<body>
	<form method="post" enctype="multipart/form-data">
		<input type="file" name="file"><br><br>
		<input type="submit" name ="submit" value="upload">
		
	</form>
	
	<?php
		if(isset($_POST['submit'])){
			$file = $_FILES['file'];
			
			$fileName = $file['name'];
			$fileType = $file['type'];
			$fileTmp = $file['tmp_name'];
			$fileErr = $file['error'];
			$fileSize = $file['size'];
			
			$fileExt = explode('.', $fileName);
			
			$fileExtension = strtolower(end($fileExt));
			
			$allowedExt = array("jpg","jpeg","png","gif","mp4");
			
			if(in_array($fileExtension,$allowedExt)){
				if($fileErr===0){
					if($fileSize <10000000){
						$newFileName=uniqid('',true).'.'.$fileExtension;
						$destination="image/,$newFileName";
						move_uploaded_file($fileTmp,$destination);
						
						echo "File Uploaded Succesfully Your File Is <a href='$destination'>Click Here</a>";
					}else{
						echo "File Size Too Large";
					}
					
				}else{
					echo "Error Uploading File";
				}
					
			}else{
				echo "Please Select Appropriate File";
			}
		}
	?>

</body>
</html>