<?php
include_once('header.php');

function getData($id){
	global $conn;
	$query = "SELECT * FROM ads WHERE id = '$id'";
	$resObj = $conn->query($query);
	$res = $resObj->fetch_object();
	return $res;
}

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

if (isset($_GET["id"])) {
    $rowId = intval($_GET["id"]);
}
else {
    $error = "ID is not set!";
}

$data = getData($rowId);

$categories = getCategories();

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