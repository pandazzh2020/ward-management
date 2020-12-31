<?php
	if(!defined('APP')) die('error!<br>不能直接访问此页面');
?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>哈工医院 病房管理系统</title>
    <script src="../lib/jquery-3.3.1.min.js" type="text/javascript"></script>
   	<script src="../lib/all.min.js" type="text/javascript"></script>
	<script src="../lib/aos.js" type="text/javascript"></script>
	<link href="../lib/bulma.min.css" rel="stylesheet"/>
	<link href="../lib/aos.css" rel="stylesheet" />
	<script src="http://cdn.highcharts.com.cn/highcharts/8.2.2/highcharts.js"></script>
	
</head>
<html>
	<body style="background-image: url(../img/bg.png);">
		
<div class="hero is-info">
	<div class="hero-body">
		<div class="columns is-gapless">
			<div class="column is-hidden-mobile is-1">
				<figure class="image is-64x64">
				  <img src="../img/fjut.png">
				</figure>
			</div>
			<div class="column has-text-centered">
				<h1 class="title">哈工医院 病房管理系统<span class="is-hidden-mobile">&emsp;&emsp;</span></h1>
				<h2 class="subtitle">管理员平台<span class="is-hidden-mobile">&emsp;&emsp;</span></h2>
			</div>
		</div>
	</div>
</div>
<section class="section">
	<div class="columns">
		<div class="column is-2 is-offset-1">
			<?php
				//菜单文件
				require './_share/_mune.php';
			?>
		</div>
		
		<div class="column is-8" data-aos="flip-right" data-aos-duration="800" data-aos-once="true">
			<div class="box">
				<h2 class="has-text-centered subtitle"><i class="fas fa-info-circle"></i>&thinsp;打印报表</h2>

				
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">

</script>

<?php
	//脚部文件
	require '../public/_share/_footer.php';
?>