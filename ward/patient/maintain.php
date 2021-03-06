<?php
	header('content-type:text/html;charset=utf-8');
	define('APP','itcast');
	session_start();
	
	if(isset($_SESSION['user_id'])&&isset($_SESSION['user_type'])){
		$user_type=$_SESSION['user_type'];
		if($user_type!="patient"){
			//
			header("Location: ../$user_type/home.php");
		}else{
			//获取信息
			$user_account=$_SESSION['user_account'];
			$user_name=$_SESSION['user_name'];
			$user_id=$_SESSION['user_id'];
			
			if(isset($_SESSION['ward_id'])&&isset($_SESSION['ward_building'])){
				//获取宿舍信息
				$ward_id=$_SESSION['ward_id'];
				$ward_building=$_SESSION['ward_building'];
				$ward_number=$_SESSION['ward_number'];
				
				require '../public/_share/_pdo.php';
				
				//处理分页
				$page_size=5;
				$result=$pdo->query("select count(*) from ward_maintain where ward_id=$ward_id");
				$count=$result->fetch()[0];
				$max_page=ceil($count/$page_size);
				$page=isset($_GET['page']) ? intval($_GET['page']) : 1;
				$page=$page>$max_page ? $max_page : $page;
				$page=$page < 1 ? 1 : $page;
				$lim=($page -1)*$page_size;
				
				$sql="select * from ward_maintain where ward_id=$ward_id order by date desc limit $lim,$page_size";
				$result=$pdo->query($sql);
				$maintain_list=$result->fetchAll();
			}
			require './view/maintain_html.php';
		}
	}else{
		//如果用户未登录
		header('Location: ../public/logout.php');
	}
?>