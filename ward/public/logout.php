<?php
	session_start();
	$_SESSION['user_id']=null;
	$_SESSION['user_account']=null;
	$_SESSION['user_type']=null;
	$_SESSION['user_name']=null;
	$_SESSION['user_sex']=null;
	
	$_SESSION['ward_id']=null;
	$_SESSION['ward_building']=null;
	$_SESSION['ward_number']=null;
	
	header('Location: ./login.php');
?>