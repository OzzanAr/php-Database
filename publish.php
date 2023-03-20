<?php
include_once("header.php");

$error = "";

function publish($title, $desc, $categories ,$img){
	global $conn;
	$title = mysqli_real_escape_string($conn, $title);
	$desc = mysqli_real_escape_string($conn, $desc);
	$user_id = $_SESSION["USER_ID"];

	$path = imageCheck($img);
	$path = mysqli_real_escape_string($conn, $path);

	// Getting the time of submission
	$unix_time = time();
	$sql_timestamp = date('Y-m-d H:i:s', $unix_time);
	$sub_time = date('Y-m-d H:i:s', strtotime($sql_timestamp . ' +1 hour')); // Add one hour to timestamp

	$query = "INSERT INTO ads (title, description, user_id, image, submission_time)
	VALUES('$title', '$desc', '$user_id','$path', '$sub_time');";
				
	// Sending the query into the database and using an if to check if anything is wrong
	if($conn->query($query)){
		$id_query = "SELECT id FROM ads WHERE submission_time = '$sub_time'";
		$id_res = $conn->query($id_query);

		$category_ids = getCategoryIDs($categories);

		foreach($category_ids as $cat_id){
			$category_query = "INSERT INTO ads_category(category_id, ads_id)
			VALUES('$cat_id', '$id_res');";
		}

		return true;
	}
	else{
		return false;
	}
}

function getCategoryIDs($categories){
	$array = array();
	foreach($categories as $category){
		$query_category = "SELECT id FROM category WHERE name='$category'";
		$res = $conn->query($query_category);
		$row = $res->fetch_assoc();
		array_push($array, $row['id']);
	}

	return $array;
}

function imageCheck($img){
	$target_dir = "uploads/";
	$target_file = $target_dir . basename($img["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	$path=$target_file;

	$imageError = "";
	// Check if image file is a actual image or fake image
	$check = getimagesize($img["tmp_name"]);
	if($check !== false) {
		$uploadOk = 1;
	} else {
		$imageError = "File is not an image.";
		$uploadOk = 0;
	}

	// Check if file already exists
	if (file_exists($target_file)) {
		$imageError = "Sorry, file already exists.";
		$uploadOk = 0;
	}

	// Check file size
	if ($img["size"] > 500000) {
		$imageError = "Sorry, your file is too large.";
		$uploadOk = 0;
	}

	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
		$imageError = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		$error = "Sorry, your file was not uploaded; ". $imageError;	
	} 
	// if everything is ok, try to upload file
	else {
		if (move_uploaded_file($img["tmp_name"], $target_file)) {
			return $path = $target_file;
		} else {
			$error = "Sorry, there was an error uploading your file.";
		}
	}
}

function getCategories(){
   global $conn;
	$query = "SELECT name FROM category";
	$result = $conn->query($query);
	$categories = array();

	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$categories[] = $row['name'];
		}
	}

	return $categories;
}








?>
<div class="container">
	<h2>Create an Ad</h2>
	<form action="publish.php" method="POST" enctype="multipart/form-data" class="form-group">
		<div class="form-group">	
			<label>Title: </label>
			<input type="text" name="title" class="form-control"/>
			
			<label>Description: </label>
			<textarea name="description" rows="10" cols="50" class="form-control"></textarea>
			
			<label>Categories: </label>
			<select multiple name="categories" id="categories" class="form-select">
				<?php
					$categories = getCategories();
					foreach($categories as $category){
						echo "<option value=\"".$category."\">".$category."</option>";
					}
				?>
			</select></br>

			<label>Image: </label>
			<input type="file" name="image" id="image"  class="form-control-file"/> <br/><br/>
			
			<input type="submit" name="submit" value="Publish Ad" class="btn btn-success"/> <br/>
			<label class="text-danger"><?php echo $error; ?></label>
		</div>				
	</form>
<div>
<?php
include_once("footer.php");
?>