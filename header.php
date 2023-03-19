<?php
    // Starting the sesssion and setting the time of the session to be active up to 30 minutes
    session_start();

    if(isset($_SESSION['LAST_ACTIVITY']) && time() - $_SESSION['LAST_ACTIVITY'] < 1800){
		session_regenerate_id(true);
	}
	$_SESSION['LAST_ACTIVITY'] = time();

    // Connecting to the database called "vaja_1" and setting character encoding
    // betweeen the server and database to be on UTF8
    $conn = new mysqli('localhost', 'root', '', 'vaja_1');
    $conn->set_charset("UTF8");
?>
<html>
<head>
    <title>Cool Ad Website</title>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<div>
    <h1>Cool Ad Website</h1>
    <p>Get the coolest things here!</p>
</div>

<body>
    <nav>
        <div>
            <ul>
            <li>
                <a href="index.php">Home</a></li>
            </li>
            <?php
            if(isset($_SESSION["USER_ID"])){
				?>
				<li>
					<a href="publish.php">Publish Ad</a></li>
				<li>
					<a href="myads.php">My Ads</a></li>
				<li class="nav-item">
					<a href="logout.php">Log out</a></li>
				<?php
			} else{
				?>
				<li class="nav-item">
					<a href="login.php">Log in</a></li>
				<li class="nav-item">
					<a href="register.php">Register</a></li>
				<?php
			}
			?>
			</ul>
        </div>
    </nav>
    <br>