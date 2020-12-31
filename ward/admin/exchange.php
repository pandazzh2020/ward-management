<?php
	header('content-type:text/html;charset=utf-8');
	define('APP','itcast');
	session_start();
	
	if(isset($_SESSION['user_id'])&&isset($_SESSION['user_type'])){
		$user_type=$_SESSION['user_type'];
		if($user_type!="admin"){
			//非管理员用户不允许访问管理员平台
			header("Location: ../$user_type/home.php");
		}else{
			
			require '../public/_share/_pdo.php';
			
			//处理分页
			$page_size=5;
			$result=$pdo->query("select count(*) from ward_exchange");
			$count=$result->fetch()[0];
			$max_page=ceil($count/$page_size);
			$page=isset($_GET['page']) ? intval($_GET['page']) : 1;
			$page=$page>$max_page ? $max_page : $page;
			$page=$page < 1 ? 1 : $page;
			$lim=($page -1)*$page_size;
			
			$sql="select a.id,a.date,admin_response,a.patient_id,a.to_ward_id,d.ward_id as from_ward_id,name,account,c.building as to_ward_building,c.number as to_ward_number,e.building as from_ward_building,e.number as from_ward_number,e.id as from_ward_id
				from ward_exchange as a left join patient as b on a.patient_id=b.id left join ward as c on a.to_ward_id=c.id left join patien_ward as d on d.patient_id=b.id left join ward as e on e.id=d.ward_id
				order by a.id desc limit $lim,$page_size";
			$result=$pdo->query($sql);
			$exchange_list=$result->fetchAll();
			
			require './view/exchange_html.php';
		}
	}else{
		//如果用户未登录
		header('Location: ../public/logout.php');
	}
?>