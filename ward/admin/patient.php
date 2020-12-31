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
			//搜索页面被其他模块调用时，有多种形态
			if(isset($_GET['func'])){
				$html_func=$_GET['func'];
			}
			
			require '../public/_share/_pdo.php';
			//拿到全部病人信息
			$page_size2=5;
			$result2=$pdo->query("select count(*) from patient");
			$count2=$result2->fetch()[0];
			$max_page2=ceil($count2/$page_size2);
			$page2=isset($_GET['page2']) ? intval($_GET['page2']) : 1;
			$page2=$page2>$max_page2 ? $max_page2 : $page2;
			$page2=$page2 < 1 ? 1 : $page2;
			$lim2=($page2 -1)*$page_size2;
			
			$sql2="select patient_id,ward_id,building,number,c.sex,account,c.name as patient_name,d.name as disease_name
				from patien_ward as a right join ward as b on a.ward_id=b.id right join patient as c on c.id=a.patient_id left join disease as d on d.id=c.disease_id
				limit $lim2,$page_size2";
			$result2=$pdo->query($sql2);
			$all_patient_list=$result2->fetchAll();
		
			//接收关键词并搜索
			if(isset($_GET['keyword'])){ 
				$keyword=$_GET['keyword'];
				//处理分页
				$page_size=5;
				$result=$pdo->query("select count(*) from patient where name like '%$keyword%' or account like '%$keyword%'");
				$count=$result->fetch()[0];
				$max_page=ceil($count/$page_size);
				$page=isset($_GET['page']) ? intval($_GET['page']) : 1;
				$page=$page>$max_page ? $max_page : $page;
				$page=$page < 1 ? 1 : $page;
				$lim=($page -1)*$page_size;

				$sql="select patient_id,ward_id,building,number,c.sex,account,c.name as patient_name,d.name as disease_name
					from patien_ward as a right join ward as b on a.ward_id=b.id right join patient as c on c.id=a.patient_id left join disease as d on d.id=c.disease_id
					where c.name like '%$keyword%' or account like '%$keyword%'
					limit $lim,$page_size";
				$result=$pdo->query($sql);
				$patient_list=$result->fetchAll();
			}
			
			require './view/patient_html.php';
		}
	}else{
		//如果用户未登录
		header('Location: ../public/logout.php');
	}
?>