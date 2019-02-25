<?php 
session_start();
$_SESSION['user_id'] = (int) 2 ; // hardcoded for make it easy 

// OOP mysqli 
$db = new mysqli('YOURHOST', 'DB_USERNAME', 'DB_PASSWORD' ,'DB_NAME'); 

