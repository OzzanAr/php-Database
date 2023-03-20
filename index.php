<?php
include_once('header.php');

// The function is used to recive the ads from the server
function get_ads(){
	global $conn;
    // Ordering by date in descending order
	$query = "SELECT ads.* FROM ads ORDER BY submission_time DESC";

	$res = $conn->query($query);
	$ads = array();
	while($ad = $res->fetch_object()){
		array_push($ads, $ad);
	}
	return $ads;
}

// Function to get the catogires from the ads_category table
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

// Reading the ads from the database
// and putting into a variable
$ads = get_ads();

// Displaying the ads on the home page
// Clicking on the title will display more info about the ad
foreach($ads as $ad){
    ?>
	<div class="container p-5 my-5 border">
		<div class="ad" id="cl">
			<a href="ad.php?user_id=<?php echo $ad->id;?>" style="text-decoration: none"><h2><?php echo $ad->title;?></h2></a>
			
			<?php
			$categories = get_categories($ad);
			foreach($categories as $category){
				?>	
				<h5><?php echo $category->category_name;?></h5>
				<?php
			}
			?>

			<img class="rounded" src="<?php echo $ad->image ?>">
		</div>
	</div>
	<?php
}

include_once('footer.php');
?>