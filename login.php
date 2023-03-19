<?php
include_once('header.php');
$error = "";

// Validating the login
function validate_login($username, $password){
	global $conn;
	$username = mysqli_real_escape_string($conn, $username);
    $pass = sha1($password);
    // Getting the only the data that matches the entered username and password
	$query = "SELECT * FROM users WHERE username='$username' AND password='$pass'";
	$res = $conn->query($query);
	if($user_obj = $res->fetch_object()){
		return $user_obj->id;
	}
	return -1;
}


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