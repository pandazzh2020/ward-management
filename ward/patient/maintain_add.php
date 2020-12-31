<?php
	header('content-type:text/html;charset=utf-8');
	define('APP','itcast');
	session_start();
	
	if(isset($_SESSION['user_id'])&&isset($_SESSION['user_type'])){
		$user_type=$_SESSION['user_type'];
		if($user_type!="patient"){
			//非学生用户不允许访问学生平台
			header("Location: ../$user_type/home.php");
		}else{
			//获取学生信息
			$user_account=$_SESSION['user_account'];
			$user_name=$_SESSION['user_name'];
			$user_id=$_SESSION['user_id'];
			
			if(isset($_SESSION['ward_id'])&&isset($_SESSION['ward_building'])){
				//获取宿舍信息
				$ward_id=$_SESSION['ward_id'];
				$ward_building=$_SESSION['ward_building'];
				$ward_number=$_SESSION['ward_number'];
				
				if($_POST){
					require '../public/_share/_pdo.php';
					$sql="insert into ward_maintain(`ward_id`,`request`) values($ward_id,?)";
					$stmt=$pdo->prepare($sql);
					$stmt->bindParam(1,$_POST['request']);
					if(!$stmt->execute())
					{
						exit("申请失败，请重试。".$stmt->errorInfo());
					}
					header('Location: ./maintain.php');
				}
				
				require './view/maintain_add_html.php';
			}else{
				//如果获取宿舍信息失败
				header('Location: ./view/maintain.php');
			}
		}
	}else{
		//如果用户未登录
		header('Location: ../public/logout.php');
	}
?>