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
			//获取病人信息
			$user_account=$_SESSION['user_account'];
			$user_name=$_SESSION['user_name'];
			$user_id=$_SESSION['user_id'];
			$user_sex=$_SESSION['user_sex'];
			
			if(isset($_SESSION['ward_id'])&&isset($_SESSION['ward_building'])){
				//获取原病房信息
				$ward_id=$_SESSION['ward_id'];
				$ward_building=$_SESSION['ward_building'];
				$ward_number=$_SESSION['ward_number'];
			}
			require '../public/_share/_pdo.php';
			
			//处理分页
			$page_size=5;
			$result=$pdo->query("select count(*) from ward_exchange where patient_id=$user_id");
			$count=$result->fetch()[0];
			$max_page=ceil($count/$page_size);
			$page=isset($_GET['page']) ? intval($_GET['page']) : 1;
			$page=$page>$max_page ? $max_page : $page;
			$page=$page < 1 ? 1 : $page;
			$lim=($page -1)*$page_size;
			
			$sql="select * from ward_exchange left join ward on to_ward_id=ward.id
				where patient_id=$user_id order by date desc limit $lim,$page_size";
			$result=$pdo->query($sql);
			$exchange_list=$result->fetchAll();
			
			require './view/exchange_html.php';
		}
	}else{
		//如果用户未登录
		header('Location: ../public/logout.php');
	}
?>