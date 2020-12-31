<?php
	header('content-type:text/html;charset=utf-8');
	define('APP','itcast');
	session_start();
	
	require '../public/_share/_pdo.php';
	
	if(isset($_SESSION['user_id'])&&isset($_SESSION['user_type'])){
		$user_type=$_SESSION['user_type'];
		if($user_type!="admin"){
			//非管理员用户不允许访问管理员平台
			header("Location: ../$user_type/data.php");
		}else{
			//获取管理员信息
			$user_account=$_SESSION['user_account'];
			$user_name=$_SESSION['user_name'];
			$user_id=$_SESSION['user_id'];
			
			//为数据统计准备数据
			$sql="select count(*) as num from patient where sex='男'";
			$result=$pdo->query($sql);
			$row=$result->fetch();
			$sex_woman=$row['num'];
			
			$sql2="select count(*) as num2 from patient where sex='女'";
			$result2=$pdo->query($sql2);
			$row2=$result2->fetch();
			$sex_man=$row2['num2'];
			
			
			require './view/data_html.php';
		}
	}else{
		//如果用户未登录
		header('Location: ../public/logout.php');
	}
?>