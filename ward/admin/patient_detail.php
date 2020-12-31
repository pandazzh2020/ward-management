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
			if(isset($_GET['id'])){ 
				$patient_id=$_GET['id'];
				
				require '../public/_share/_pdo.php';

				$sql="select patient_id,ward_id,building,number,supervisor,c.sex,c.account,c.name as patient_name,d.name as disease_name,department,e.name as doctor_name
					from patien_ward as a right join ward as b on a.ward_id=b.id right join patient as c on c.id=a.patient_id right  join disease as d on d.id=c.disease_id right join doctor as e on d.doctor_id=e.id
					where c.id=$patient_id";
				$result=$pdo->query($sql);
				$patient_detail=$result->fetch();
			}else{
				header('Location: ./patient.php');
			}
			require './view/patient_detail_html.php';
		}
	}else{
		//如果用户未登录
		header('Location: ../public/logout.php');
	}
?>