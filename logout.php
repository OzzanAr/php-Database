<?php
// First loading the session then clearing the variables
// destroying the session then redirecting the user to index.php
session_start();
session_unset();
session_destroy();
header("Location: index.php");
?>