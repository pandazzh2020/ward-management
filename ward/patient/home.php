<?php
	header('content-type:text/html;charset=utf-8');
	define('APP','itcast');
	session_start();
	
	if(isset($_SESSION['user_id'])&&isset($_SESSION['user_type'])){
		$user_type=$_SESSION['user_type'];
		if($user_type!="patient"){
			//非患者用户不允许访问平台
			header("Location: ../$user_type/home.php");
		}else{
			$user_account=$_SESSION['user_account'];
			$user_name=$_SESSION['user_name'];
			$user_id=$_SESSION['user_id'];
			$user_sex=$_SESSION['user_sex'];
			
			//获取学生的宿舍信息
			require '../public/_share/_pdo.php';
			$sql="select * from patien_ward where patient_id=$user_id";
			$result=$pdo->query($sql);
			$row=$result->fetch();
			$ward_id=$row['ward_id'];
			$is_supervisor=$row['supervisor'];
			if(!empty($ward_id)){
				//获取病房详细信息
				$sql="select * from ward where id=$ward_id";
				$result=$pdo->query($sql);
				$row=$result->fetch();
				$ward_building=$row["building"];
				$ward_number=$row["number"];
				$_SESSION['ward_id']=$ward_id;
				$_SESSION['ward_building']=$ward_building;
				$_SESSION['ward_number']=$ward_number;
			}else{
				$_SESSION['ward_id']=null;
				$_SESSION['ward_building']=null;
				$_SESSION['ward_number']=null;
			}
			require './view/home_html.php';
		}
	}else{
		//如果用户未登录
		header('Location: ../public/logout.php');
	}
?>