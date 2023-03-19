<?php
include_once('header.php');

$error = "";


function checkRequirments($username, $name, $surname, $email, $password){
    global $error;

	if (empty($username) or empty($name) or 
        empty($surname) or empty($email) or
        empty($password)) {
		$error = "All required fileds must be filled!";
	}

	return $error;
}

if(isset($_POST["submit"])){
	$error = checkRequirments($_POST["username"], $_POST["name"], $_POST["surname"], $_POST["email"], $_POST["password"]);

	if(!empty($error)){
		// display the error to the user
		$error;
	} // Cheacking to see if the passwords are the same
	else if($_POST["password"] != $_POST["repeat_password"]){
		$error = "Repeted password is not the same!";
	}
    // If any other errors occur during registiration
	else{
		$error = "Error occured during registration!";
	}
}

?>
<div class="container">
    <h2>Create an account:</h2>
        <form action="register.php" method="POST" class="form-group">
        <div class="form-group">
            <h5>Required:</h5>
            <label>Username: </label>
			<input type="text" name="username" class="form-control"/> <br/>
		
			<label>Name: </label>
			<input type="text" name="name" class="form-control"/> <br/>

			<label>Surname: </label>
			<input type="text" name="surname" class="form-control" /> <br/>
			
			<label>Email: </label>
			<input type="email" name="email" class="form-control"/> <br/>

            <label>Password: </label>
			<input type="password" name="password" class="form-control"/> <br/>

			<label>Re-enter Password: </label>
			<input type="password" name="repeat_password" class="form-control"/> <br>
		
			<h5>Optional: </h5>
			<label>Address: </label>
			<input type="text" name="address" class="form-control"/> <br/>

			<label>Zip code: </label>
			<input type="text" name="zipcode" class="form-control"/> <br/>

			<label>Phone number: </label>
			<input type="text" name="phone" class="form-control"/><br/>

			<input type="submit" name="submit" value="Register" class="btn btn-success" /> <br/>
			<label class="text-danger"><?php echo $error; ?></label><br>
        </div>
    </form>
</div>
<?php

include_once('footer.php');
?>