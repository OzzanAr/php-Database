<?php
include_once("header.php");

$error = "";

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