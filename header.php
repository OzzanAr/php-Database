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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .navbar .navbar-nav {
 			display: inline-block;
  			float: none;
  			vertical-align: top;
        }

        img {
			width: 250px; /* set the width to 250 pixels */
			height: 250px; /* set the height to 250 pixels */
		}
    </style>
</head>

<div class="container-fluid p-3 bg-primary text-white text-center">
    <h1>Cool Ad Website</h1>
    <p>Get the coolest things here!</p>
</div>

<body>
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container-fluid">
            <ul class="nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a href="index.php" class="nav-link">Home</a></li>
            </li>
            <?php
            if(isset($_SESSION["USER_ID"])){
				?>
				<li class="nav-item">
					<a href="publish.php" class="nav-link">Publish Ad</a></li>
				<li class="nav-item">
					<a href="myads.php" class="nav-link">My Ads</a></li>
				<li class="nav-item">
					<a href="logout.php" class="nav-link">Log out</a></li>
				<?php
			} else{
				?>
				<li class="nav-item">
					<a href="login.php" class="nav-link">Log in</a></li>
				<li class="nav-item">
					<a href="register.php" class="nav-link">Register</a></li>
				<?php
			}
			?>
			</ul>
        </div>
    </nav>