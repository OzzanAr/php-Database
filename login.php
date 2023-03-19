<?php
include_once('header.php');
$error = "";




?>
<div class="container">
	<div class="form-group">
	<h2>Log in</h2>
	<form action="login.php" method="POST" class="form-group">
		<label>Username: </label>
		<input type="text" name="username" class="form-control"/> <br/>

		<label>Password: </label>
		<input type="password" name="password" class="form-control"/> <br/>
		
		<input type="submit" name="submit" value="Login" class="btn btn-success"/> <br/>
		<label class="text-danger"><?php echo $error; ?></label>
	</form>
	</div>
</div>
<?php
include_once('footer.php');
?>