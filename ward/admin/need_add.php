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
			
			//处理表单提交
			if($_POST){
				$patient_id=$_POST['id'];
				$date=$_POST['date'];
				$detail=$_POST['detail'];
				
				if(strtotime($date)>time()){
					echo "<script>alert('您选择的时间有误，请重试')</script>";
				}else{
					$sql="insert patient_need set patient_id=? ,date=? ,detail=?";
					$stmt=$pdo->prepare($sql);
					$stmt->bindParam(1,$patient_id);
					$stmt->bindParam(2,$date);
					$stmt->bindParam(3,$detail);
					if(!$stmt->execute())
					{
						exit("提交失败，请重试。".$stmt->errorInfo());
					}
					header('Location: ./need.php');
				}
			}
			
			if(isset($_GET['id'])){ 
				$patient_id=$_GET['id'];
				
				//获取患者详细信息
				$sql="select patient_id,ward_id,building,number,c.sex,account,name,supervisor
					from patien_ward as a join ward as b on a.ward_id=b.id join patient as c on c.id=a.patient_id
					where c.id=$patient_id";
				$result=$pdo->query($sql);
				$patient_detail=$result->fetch();
			}else{
				//如果没有传入学生id,跳转到搜索页面
				header("Location: ./patient.php?func=违规登记");
			}
			
			require './view/need_add_html.php';
		}
	}else{
		//如果用户未登录
		header('Location: ../public/logout.php');
	}
?>