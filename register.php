<?php
include_once('header.php');

$error = "";





?>
<div class="container">
    <h2>Create an account:</h2>
        <form action="register.php" method="POST" class="form-group">
        <div class="form-group">
            <label>Username: </label>
			<input type="text" name="username" class="form-control"/> <br/>
		
			<label>Name: </label>
			<input type="text" name="name" class="form-control"/> <br/>

			<label>Surname: </label>
			<input type="text" name="surname" class="form-control" /> <br/>
			
			<label>Email: </label>
			<input type="email" name="useremail" class="form-control"/> <br/>

            <label>Password: </label>
			<input type="password" name="password" class="form-control"/> <br/>

			<label>Re-enter Password: </label>
			<input type="password" name="repeat_password" class="form-control"/> 
		
			<h3>Optional: </h3>
			<label>Address: </label>
			<input type="text" name="address" class="form-control"/> <br/>

			<label>Zip code: </label>
			<input type="text" name="zipcode" class="form-control"/> <br/>

			<label>Phone number: </label>
			<input type="text" name="phone" class="form-control"/><br/>

			<input type="submit" name="submit" value="Register" class="btn btn-success" /> <br/>
			<label class="text-danger"><?php echo $error; ?></label>
        </div>
    </form>
</div>
<?php

include_once('footer.php');
?>