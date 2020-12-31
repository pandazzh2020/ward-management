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
			
			$ward_id=$_GET['id'];
			if(empty($ward_id)){
				//如果没有$ward_id参数就返回ward列表
				header('Location: ./ward.php');
			}
			
			//病房信息
			$sql="select * from ward where id=$ward_id";
			$result=$pdo->query($sql);
			$ward_detail=$result->fetch();
			
			//处理表单提交
			if($_POST){
				//表单Post有两种功能,根据func字段判断
				$func=$_POST['func'];
				
				if($func=="添加病人"){
					$account=$_POST['account'];
					
					//先找到这名患者
					$sql="select id,sex from patient where account='$account'";
					$result=$pdo->query($sql);
					$row=$result->fetch();
					$patient_id=$row['id'];
					$patient_sex=$row['sex'];
					$ward_sex=$ward_detail['sex'];
					
					if(empty($patient_id)){
						echo "<script>alert('没有找到这名患者，请核对您输入的账号。');</script>";
					}else if($ward_sex!=$patient_sex){
						echo "<script>alert('无法将".$patient_sex."生添加到".$ward_sex."病房。');</script>";
					}else{
						$sql="delete from patien_ward where patient_id=?;
							insert into patien_ward(patient_id,ward_id,supervisor) values(?,?,'否')";
						$stmt=$pdo->prepare($sql);
						$stmt->bindParam(1,$patient_id);
						$stmt->bindParam(2,$patient_id);
						$stmt->bindParam(3,$ward_id);
						if(!$stmt->execute())
						{
							exit("提交失败，请重试。".$stmt->errorInfo());
						}
						//echo "<script>alert('成功添加学生。');</script>";
						header("Location: ./ward_detail.php?id=$ward_id");	
					}

				}else if($func=="移出病房"){
					$patient_ids=$_POST['patient_id'];
					
					$sql_patient_ids=implode("," ,$patient_ids);
					$sql="delete from patien_ward where patient_id in ($sql_patient_ids)";
					if(!$pdo->query($sql)){
						exit("移出失败，请重试。".$stmt->errorInfo());
					}
					echo "<script>alert('移出成功。');</script>";
					
				}else if($func=="设为特殊观察"){
					$patient_ids=$_POST['patient_id'];
					
					$sql_patient_ids=implode("," ,$patient_ids);
					$sql="update patien_ward set supervisor='是' where patient_id in ($sql_patient_ids)";
					if(!$pdo->query($sql)){
						exit("特殊观察设置失败，请重试。".$stmt->errorInfo());
					}
					echo "<script>alert('特殊观察设置成功。');</script>";
					
				}else if($func=="取消特殊观察"){
					$patient_ids=$_POST['patient_id'];
					
					$sql_patient_ids=implode("," ,$patient_ids);
					$sql="update patien_ward set supervisor='否' where patient_id in ($sql_patient_ids)";
					if(!$pdo->query($sql)){
						exit("特殊观察取消失败，请重试。".$stmt->errorInfo());
					}
					echo "<script>alert('特殊观察已取消。');</script>";
				}
			}
			
			//住在病房的患者信息
			$sql="select account,name,supervisor,patient_id
				from patient as a join patien_ward as b on a.id=b.patient_id
				where b.ward_id=$ward_id";
			$result=$pdo->query($sql);
			$ward_patient=$result->fetchAll();
			
			require './view/ward_detail_html.php';
		}
	}else{
		//如果用户未登录
		header('Location: ../public/logout.php');
	}
?>