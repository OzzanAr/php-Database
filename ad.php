<?php 
include_once('header.php');

// Function to get the information about the ad
// and the user that created it 
function get_ad($id){
	global $conn;
	$id = mysqli_real_escape_string($conn, $id);
	$query = "SELECT ads.*, users.username, ads.views FROM ads 
	LEFT JOIN users ON users.id = ads.user_id WHERE ads.id = $id;";

	$res = $conn->query($query);
	if($obj = $res->fetch_object()){
		return $obj;
	}
	return null;
}

function get_categories($ad){
	global $conn;

	$currentAdID = $ad->id;

	$query = "SELECT category.name as category_name FROM category 
	INNER JOIN ads_category ON category.id = ads_category.category_id 
	WHERE ads_category.ads_id = $currentAdID";
	
	$res = $conn->query($query);
	$categories = array();
	while($category = $res->fetch_object()){
		array_push($categories, $category);
	}
	return $categories;
}


// Main Function:
if(!isset($_GET["user_id"])){
	echo "Missing parameters!";
	die();
}

$id = $_GET["user_id"];
$ad = get_ad($id);
if($ad == null){
	echo "Ad doesn't exist";
	die();
}
// Base64 code for the image (hexadecimal notation of bytes from the file)
$img_data = base64_encode($ad->image);

// Check if the ad has been viewed by the current user
$cookie_name = 'ad_' . $id;
if(!isset($_COOKIE[$cookie_name])){
	// Increment the 'views' column in the 'ads' table
	$views = $ad->views + 1;
	$query = "UPDATE ads SET views = $views WHERE id = $id;";
	$conn->query($query);

	// Set a cookie to prevent the view from being counted multiple times for the same user
	setcookie($cookie_name, 1, time() + (86400 * 30), "/"); // 1 day
}

?>
<div class="container p-5 my-5 border"">
	<div class="ad">
		<h3 style="color:blue;"><?php echo $ad->title;?></h3>
		<?php
			$categories = get_categories($ad);
			foreach($categories as $category){
				?>	
				<h5><?php echo $category->category_name;?></h5>
				<?php
			}
			?>
		<hr>
		<p><?php echo $ad->description;?></p>
		
		<img src="<?php echo $ad->image ?>" class="rounded"/><br>
		<h6>Ad created by user: <?php echo $ad->username; ?></h6>
		<p>Views: <?php echo $ad->views; ?></p>
		<a href="index.php"><button class="btn btn-primary">Back</button></a>
	</div>
</div>
<?php
include_once('footer.php');
?>
