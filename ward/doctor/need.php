<?php
	header('content-type:text/html;charset=utf-8');
	define('APP','itcast');
	session_start();
	
	if(isset($_SESSION['user_id'])&&isset($_SESSION['user_type'])){
		$user_type=$_SESSION['user_type'];
		if($user_type!="doctor"){
			//非教师用户不允许访问教师平台
			header("Location: ../$user_type/home.php");
		}else{
			$user_id=$_SESSION['user_id'];
			
			require '../public/_share/_pdo.php';
			
			//处理表单提交
			if($_POST){
				$need_id=$_POST['id'];
				$response="已读";
				if(!empty($need_id)){
					$sql="update patient_need set doctor_response=? where id=?";
					$stmt=$pdo->prepare($sql);
					$stmt->bindParam(1,$response);
					$stmt->bindParam(2,$need_id);
					if(!$stmt->execute())
					{
						exit("提交失败，请重试。".$stmt->errorInfo());
					}
					header('Location: ./need.php');
				}
			}
			
			//处理分页
			$page_size=5;
			$result=$pdo->query("select count(*) from patient_need as a join patient as b on a.patient_id=b.id join disease as c on b.disease_id=c.id
								where c.doctor_id=$user_id");
			$count=$result->fetch()[0];
			$max_page=ceil($count/$page_size);
			$page=isset($_GET['page']) ? intval($_GET['page']) : 1;
			$page=$page>$max_page ? $max_page : $page;
			$page=$page < 1 ? 1 : $page;
			$lim=($page -1)*$page_size;
			
			$sql="select a.id,detail,date,account,doctor_response,b.name as patient_name,c.name as disease_name
				from patient_need as a join patient as b on a.patient_id=b.id join disease as c on b.disease_id=c.id
				where c.doctor_id=$user_id
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