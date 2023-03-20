<?php
include_once("header.php");












?>
<div class="container">
	<h2>Create an Ad</h2>
	<form action="publish.php" method="POST" enctype="multipart/form-data" class="form-group">
		<div class="form-group">	
			<label>Title: </label>
			<input type="text" name="title" class="form-control"/> <br/>
			
			<label>Description: </label>
			<textarea name="description" rows="10" cols="50" class="form-control"></textarea> <br/>
			
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
			<input type="file" name="image" id="image"  class="form-control-file"/> <br/>
			
			<input type="submit" name="submit" value="Publish Ad" class="btn btn-success"/> <br/>
			<label class="text-warning"><?php echo $error; ?></label>
		</div>				
	</form>
<div>
<?php
include_once("footer.php");
?>