<?php
	header('content-type:text/html;charset=utf-8');
	define('APP','itcast');
	session_start();
	
	if(isset($_SESSION['user_id'])&&isset($_SESSION['user_type'])){
		$user_type=$_SESSION['user_type'];
		if($user_type!="patient"){
			//非学生用户不允许访问学生平台
			header("Location: ../$user_type/home.php");
		}else{
			//获取学生信息
			$user_account=$_SESSION['user_account'];
			$user_name=$_SESSION['user_name'];
			$user_id=$_SESSION['user_id'];
			$user_sex=$_SESSION['user_sex'];
			
			//获取当前宿舍信息
			$ward_building=isset($_SESSION['ward_building'])?$_SESSION['ward_building']:null;
			$ward_number=isset($_SESSION['ward_number'])?$_SESSION['ward_number']:null;
			
			if($_POST){
				//目标宿舍的信息
				$to_ward_building=$_POST['building'];
				$to_ward_number=$_POST['number'];
				//换宿舍的原因
				$request=$_POST['request'];
				if($to_ward_building==$ward_building&&$to_ward_number==$ward_number){
					echo "<script>alert('您当前已在此病房')</script>";
				}else{
					require '../public/_share/_pdo.php';
					
					$sql="select id,sex from ward where building='$to_ward_building' and number='$to_ward_number'";
					$result=$pdo->query($sql);
					$row=$result->fetch();
					$to_ward_id=$row['id'];
					if(empty($to_ward_id)){
						echo "<script>alert('目标病房不存在，请核对。')</script>";
					}else{
						$to_ward_sex=$row['sex'];
						if($user_sex!=$to_ward_sex){
							echo "<script>alert('该病房是".$to_ward_sex."生病房，您无法申请更换。')</script>";
						}else{
							$sql="insert into ward_exchange(`patient_id`,`to_ward_id`,`request`) values($user_id,?,?)";
							$stmt=$pdo->prepare($sql);
							$stmt->bindParam(1,$to_ward_id);
							$stmt->bindParam(2,$request);
							if(!$stmt->execute())
							{
								exit("申请失败，请重试。".$stmt->errorInfo());
							}
							header('Location: ./exchange.php');
						}
					}
				}
			}
			
			require './view/exchange_add_html.php';
		}
	}else{
		//如果用户未登录
		header('Location: ../public/logout.php');
	}
?>