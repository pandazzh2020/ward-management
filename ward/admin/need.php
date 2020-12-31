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
				$voilation_id=$_POST['id'];

				$sql="delete from patient_need where id=?";
				$stmt=$pdo->prepare($sql);
				$stmt->bindParam(1,$voilation_id);
				if(!$stmt->execute())
				{
					exit("删除失败，请重试。".$stmt->errorInfo());
				}
			}
			
			//处理分页
			$page_size=5;
			$result=$pdo->query("select count(*) from patient_need");
			$count=$result->fetch()[0];
			$max_page=ceil($count/$page_size);
			$page=isset($_GET['page']) ? intval($_GET['page']) : 1;
			$page=$page>$max_page ? $max_page : $page;
			$page=$page < 1 ? 1 : $page;
			$lim=($page -1)*$page_size;
			$sql="select a.id,patient_id,date,detail,doctor_response,name,account
				from patient_need as a join patient as b on a.patient_id=b.id
				order by date desc limit $lim,$page_size";
			$result=$pdo->query($sql);
			$need_list=$result->fetchAll();
			
			require './view/need_html.php';
		}
	}else{
		//如果用户未登录
		header('Location: ../public/logout.php');
	}
?>