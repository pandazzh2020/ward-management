<?php
function createtable($list,$filename,$header=array(),$index = array()){
	header("Content-type:application/vnd.ms-excel");    
	header("Content-Disposition:filename=".$filename.".xls");    
	$teble_header = implode("\t",$header);  
	$strexport = $teble_header."\r";  
	foreach ($list as $row){    
		foreach($index as $val){  
			$strexport.=$row[$val]."\t";     
		}  
		$strexport.="\r";   
  
	}    
	$strexport=iconv('UTF-8',"GB2312//IGNORE",$strexport);    
	exit($strexport);       
}
   
?>

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
			
			
			$sql2="select patient_id,ward_id,building,number,c.sex,account,c.name as patient_name,d.name as disease_name
				from patien_ward as a right join ward as b on a.ward_id=b.id right join patient as c on c.id=a.patient_id left join disease as d on d.id=c.disease_id";
			$result2=$pdo->query($sql2);
			$list=$result2->fetchAll();
			$filename = '患者病症信息'.date('YmdHis');  
			$header = array('账号','患者姓名','病症','病房楼号','房间号');  
			$index = array('account','patient_name','disease_name','building','number');  
			createtable($list,$filename,$header,$index); 
			
			require './view/print_html.php';
			
			echo '打印成功!';
		
		}
	}else{
		//如果用户未登录
		header('Location: ../public/logout.php');
	}
?>