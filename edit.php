<?php
include_once('header.php');

function edit($rowId, $title, $desc, $categories ,$img){
	global $conn;
	$title = mysqli_real_escape_string($conn, $title);
	$desc = mysqli_real_escape_string($conn, $desc);
	$user_id = $_SESSION["USER_ID"];
	$path = imageCheck($img);

    // Updating the edit time
	$unix_time = time();
	$sql_timestamp = date('Y-m-d H:i:s', $unix_time);
	$sub_time = date('Y-m-d H:i:s', strtotime($sql_timestamp . ' +1 hour')); // Add one hour to timestamp

	$query = "UPDATE ads 
			SET title = '$title', description = '$desc', image = '$path', submission_time = '$sub_time' 
            WHERE id = $rowId;";
				
	// Sending the query into the database and using an if to check if anything is wrong
	if($conn->query($query)){
        $adsCategoryId = getIdAdsCategories($rowId);
        $i = 0;
		foreach($categories as $cat_id){
            $id = intval($adsCategoryId[$i]['id']);
			$category_query = "UPDATE ads_category SET category_id = '$cat_id' WHERE ads_id = $rowId AND id = $id";
			$conn->query($category_query);
            $i++;
		}
		return true;
	}
	else{
		return false;
	}
}

// Reciving the ids of the ads_category table
function getIdAdsCategories($rowId){
    global $conn;
    $res = array();
    $query = "SELECT id FROM ads_category WHERE ads_id = $rowId;" ;
    $result = $conn->query($query);
	$array = array();

    while($row = $result->fetch_assoc()){
		array_push($array, $row);
	}

    return $array;
}

// Cheacking the inserted image
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

// All of the data from the post
function getData($id){
	global $conn;
	$query = "SELECT * FROM ads WHERE id = '$id'";
	$resObj = $conn->query($query);
	$res = $resObj->fetch_object();
	return $res;
}

// Getting the categories
function getCategories(){
	global $conn;
	$query = "SELECT * FROM category";
	$result = $conn->query($query);
	$categories = array();

	while($row = $result->fetch_assoc()){
		array_push($categories, $row);
	}

	return $categories;
}

$error = "";
$rowId = NULL;

// Getting the id from the URL
if (isset($_GET["id"])) {
    $rowId = intval($_GET["id"]);
}
else {
    $error = "ID is not set!";
}

$data = getData($rowId);

$categories = getCategories();

if(isset($_POST["submit"])){
	if(edit($rowId, $_POST["title"], $_POST["description"] , $_POST["categories"], $_FILES["image"])){
		header("Location: myads.php");
		die();
	}
	else{
		$error = "Error with submitting edit.";
	}
}

?>
	<div class="container">
	<h2>Edit Ad</h2>
	<form action="edit.php?id=<?php echo $rowId;?>" method="POST" enctype="multipart/form-data" class="form-group">
		<div class="form-group">
		<label>Title: </label>
		<input type="text" name="title" value="<?php echo $data->title;?>" class="form-control"/> <br/>
		
		<label>Description: </label>
		<textarea name="description" rows="10" cols="50" class="form-control"><?php echo $data->description;?></textarea> <br/>

		<label>Categories: </label>
        <?php foreach($categories as $category) : ?>
				<div class="form-check">

				<input name="categories[]" value="<?php echo $category['id']; ?>" class="form-check-input" type="checkbox">
				<label class="form-check-label">
					<?php echo $category['name']; ?>
				</label>

				</div>
        <?php endforeach?>

		<label>Image: </label>
		<input type="file" name="image" id="image" value="<?php echo $data->image;?>"  class="form-control-file"/> <br/><br>
		
		<input type="submit" name="submit" value="Save changes" class="btn btn-success" /> <br/>
		<label class="text-warning"><?php echo $error; ?></label>
		</div>
	</form>
	</div>
<?php
include_once('footer.php');
?>