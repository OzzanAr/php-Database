<?php
include_once('header.php');

$error = "";

function register_user($username, $password, $email, $name, $surname, $address, $zipcode, $phone){
    global $conn;
    // Cheacking for SQL injections
	$username = mysqli_real_escape_string($conn, $username);
	$name = mysqli_real_escape_string($conn, $name);
	$surname = mysqli_real_escape_string($conn, $surname);
	$address = mysqli_real_escape_string($conn, $address);
	$zipcode = mysqli_real_escape_string($conn, $zipcode);
	$phone = mysqli_real_escape_string($conn, $phone);

	// Hashing the password using SHA encryption algorithm
	$pass = sha1($password);
    // Adding the data to the database
	$query = "INSERT INTO users (username, password, email, name, surname, address, zipcode, phone)
	VALUES ('$username', '$pass', '$email', '$name', '$surname', NULLIF('$address',''), NULLIF('$zipcode',''), NULLIF('$phone',''));";

    // Cheacking to see if the query is valid.
	if($conn->query($query)){
		return true;
	}
	else{
		echo mysqli_error($conn);
		return false;
	}
}

// Function checks if the username exits in the database
// By comparing the inserted user name with the submitted one
function username_exists($username){
	global $conn;
	$username = mysqli_real_escape_string($conn, $username);
	$query = "SELECT * FROM users WHERE username='$username'";
	$res = $conn->query($query);
	return mysqli_num_rows($res) > 0;
}

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
    elseif(username_exists($_POST["username"])){
        $error = "Username already exists!";
    }
    // If any other errors occur during registiration
    else if(register_user($_POST["username"], $_POST["password"], $_POST["email"], $_POST["name"], $_POST["surname"], $_POST["address"], $_POST["zipcode"], $_POST["phone"] )){
		header("Location: login.php");
		die();
	}
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