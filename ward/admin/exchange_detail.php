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
			
			$exchange_id=$_GET['id'];
			if(empty($exchange_id)){
				//如果没有$exchange_id参数就返回exchange列表
				header('Location: ./exchange.php');
			}
			
			//处理表单提交
			if($_POST){
				//表单Post有两种功能,根据func字段判断
				$func=$_POST['func'];
				if($func=="移至目标病房"){
					$patient_id=$_POST['patient_id'];
					$to_ward_id=$_POST['to_ward_id'];
					
					$sql="delete from patien_ward where patient_id=?;
						insert into patien_ward(patient_id,ward_id,supervisor) values(?,?,'否')";
					$stmt=$pdo->prepare($sql);
					$stmt->bindParam(1,$patient_id);
					$stmt->bindParam(2,$patient_id);
					$stmt->bindParam(3,$to_ward_id);
					if(!$stmt->execute())
					{
						exit("提交失败，请重试。".$stmt->errorInfo());
					}
					//echo "<script>alert('成功移入目标病房');</script>";
					//不用header强制刷新一次的话,会莫名其妙报错
					header("Location: ./exchange_detail.php?id=$exchange_id");
					
				}else{
					$exchange_id=$_POST['id'];
					$admin_response=$_POST['response'];
					
					$sql="update ward_exchange set admin_response=? where id=?";
					$stmt=$pdo->prepare($sql);
					$stmt->bindParam(1,$admin_response);
					$stmt->bindParam(2,$exchange_id);
					if(!$stmt->execute())
					{
						exit("提交失败，请重试。".$stmt->errorInfo());
					}
				}
			}
			
			
			
			$sql="select a.id,a.date,request,doctor_response,admin_response,a.patient_id,a.to_ward_id,d.ward_id as from_ward_id,name,account,c.building as to_ward_building,c.number as to_ward_number,e.building as from_ward_building,e.number as from_ward_number,e.id as from_ward_id
				from ward_exchange as a right join patient as b on a.patient_id=b.id left join ward as c on a.to_ward_id=c.id left join patien_ward as d on d.patient_id=b.id left join ward as e on e.id=d.ward_id
				where a.id=$exchange_id";
			$result=$pdo->query($sql);
			$exchange_detail=$result->fetch();
			
			require './view/exchange_detail_html.php';
		}
	}else{
		//如果用户未登录
		header('Location: ../public/logout.php');
	}
?>