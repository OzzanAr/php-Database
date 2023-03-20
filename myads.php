<?php
include_once('header.php');

// Getting the ads of the current logged in user
function get_ads(){
	global $conn;
    $user_id = $_SESSION["USER_ID"];
	$query = "SELECT ads.* FROM ads WHERE ads.user_id = $user_id";
	$res = $conn->query($query);
	$ads = array();
	while($ad = $res->fetch_object()){
		array_push($ads, $ad);
	}
	return $ads;
}

// Getting the categories from the current user
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

$ads = get_ads();

foreach($ads as $ad){
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

		<img src="<?php echo $ad->image ?>" class="rounded"><br><br>
		
		
		<a href="edit.php?id=<?php echo $ad->id;?>"><button class="btn btn-primary">Edit</button></a>
		<a href="delete.php?id=<?php echo $ad->id;?>&title=<?php echo $ad->title;?>"><button class="btn btn-danger">Delete</button></a></br>
		</div>
	</div>
	<?php
}

include_once('footer.php');
?>