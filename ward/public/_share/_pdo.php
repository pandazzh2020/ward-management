<?php
	//初始化数据库连接
	header('content-type:text/html;charset=utf-8');
	$dsn="mysql:host=localhost;port=3308;dbname=db_ward;charset=utf8";
	try{
		$pdo=new PDO($dsn,'root','');
	}catch(BDOException $e){
		echo $e->getMessage();
	}
?>