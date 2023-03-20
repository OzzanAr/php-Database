<?php 
include_once('header.php');

// Function to delete the ad
function delete_ad($adId){
	global $conn;
	$query = "DELETE FROM ads WHERE id = '$adId';";
    $category_query = "DELETE FROM ads_category WHERE ads_id = '$adId';";

	if($conn->query($category_query)){
        $conn->query($query);
		return true;
	}
	else{
		echo mysqli_error($conn);
		return false;
	}
}

// Intilizing the variables
$error = "";
$title = NULL;
$id = NULL;

// Reciving the variables from the URL
if (isset($_GET["title"])) {
    $title = $_GET["title"];
}

if (isset($_GET["id"])) {
    $rowId = intval($_GET["id"]);
}
else {
    $error = "Cannot read ID!";
}

// Cheacking for submit
if(isset($_POST["submit"])){
	if(delete_ad($rowId)){
		header("Location: myads.php");
		die();
	}
	else{
		$error = "Error with deleting!";
	}
} // If the user presses no gets sent back to myads page
else if(isset($_POST["noSubmit"])){
	header("Location: myads.php");
	die();
}

?>
<div class="container">
<h3>Are you sure you want to delete the post titled: <?php echo $title ?> ?</h3>

<form action="delete.php?id=<?php echo $rowId;?>" method="POST" enctype="multipart/form-data" class="form-group">
	<input type="submit" name="submit" value="Yes" class="btn btn-danger" />
	<input type="submit" name="noSubmit" value="No" class="btn btn-primary"/> <br/>
	<label><?php echo $error; ?></label>
</form>
<div>
<?php
?>