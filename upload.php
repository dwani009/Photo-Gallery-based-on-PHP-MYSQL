<?php
include 'functions.php';
register_shutdown_function('handleFatalPhpError');
session_start();
if(!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit();
}

function handleFatalPhpError() {
   $last_error = error_get_last();
   if($last_error['type'] === E_ERROR) {
      echo "Fatal error";
   }
}

// The output message
$msg = '';
// Check if user has uploaded new image
if (isset($_FILES['image'], $_POST['title'], $_POST['description'])){
	$title = $_POST['title'];
	$description = $_POST['description'];
	/*print($_POST['title']);
	if(!isset($_POST['title'])){
		$files = '';
	} 
	if(isset($_POST['title'])){
		$files = $_POST['title'];
	}
	
	if(!isset($_POST['description'])){
		$description = '';
	}
	if(isset($_POST['description'])){
		$description = $_POST['description'];
	}*/
	
	// The folder where the images will be stored
	$target_dir = 'images/';
	// The path of the new uploaded image
	$image_path = $target_dir . basename($_FILES['image']['name']);
	// Check to make sure the image is valid
	if (!empty($_FILES['image']['tmp_name']) && getimagesize($_FILES['image']['tmp_name'])) {
		if (file_exists($image_path)) {
			$msg = 'Image already exists, please choose another or rename that image.';
		}else if ($_FILES['image']['size'] > 500000) {
			$msg = 'Image file size too large, please choose an image less than 500kb.';
		}else{
			// Connect to MySQL
			$pdo = connect_mysql();
			if($pdo){
				$stmt = "INSERT INTO images VALUES (NULL, '$title', '$description', '$image_path', CURRENT_TIMESTAMP)";

				if (mysqli_query($pdo, $stmt)) {
					move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
					$msg = 'Image uploaded successfully!';
				}
			}
		}
	} else {
		$msg = 'Please upload an image!';
	}
}
?>

<?=template_header('Upload Image')?>

<div class="content upload">
	<h2>Upload Image</h2>
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<label for="image">Choose Image</label>
		<input type="file" name="image" accept="image/*" id="image">
		<label for="title">Title</label>
		<input type="text" name="title" id="title">
		<label for="description">Description</label>
		<textarea name="description" id="description"></textarea>
	    <input type="submit" value="Upload Image" name="submit">
	</form>
	<p><?=$msg?></p>
</div>

<?=template_footer()?>