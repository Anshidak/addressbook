</<?php 
//start the session to access session variables
session_start();

//unset the 'use_id' session variable
unset($_SESSION['user_id']);
unset($_SESSION['name']);

//destroy the session
session_destroy();

//redirect the user to the login page
header("Location: login.php");

 ?>