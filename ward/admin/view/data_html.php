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
				<h2 class="has-text-centered subtitle"><i class="fas fa-info-circle"></i>&thinsp;数据统计</h2>

				<!-- 使用dom和echarts库做数据统计图 -->
				<h3 class="has-text-centered subtitle">1 患者挂号科室统计</h2>
				<div id="container" style="height: 300%"></div>
				<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/echarts.min.js"></script>
				<script type="text/javascript">
					var dom = document.getElementById("container");
					var myChart = echarts.init(dom);
					var app = {};
					app.title = '患者挂号科室统计环形图';
					var option = {
						tooltip: {
							trigger: 'item',
							formatter: "{a} <br/>{b}: {c} ({d}%)"
						},
						color:['#93D8A9','#FFB99D','#AF7DCC','#FFD83D','#bbe2e8'],
						legend: {
							orient: 'horizontal',
							x: 'left',
							data: ['耳鼻喉科', '外科', '胸科', '化验科', '骨科']
						},
						series: [{
							name: '挂号科室|人数|占比',
							type: 'pie',
							radius: ['50%', '90%'],
							avoidLabelOverlap: false,
							label: {
								normal: {
									show: false,
									position: 'center'
								},
								emphasis: {
									show: true,
									textStyle: {
										fontSize: '30',
										fontWeight: 'bold'
									}
								}
							},
							labelLine: {
								normal: {
									show: false
								}
							},
							data: [{
									value: 335,
									name: '耳鼻喉科'
								},
								{
									value: 310,
									name: '外科'
								},
								{
									value: 234,
									name: '胸科'
								},
								{
									value: 135,
									name: '化验科'
								},
								{
									value: 1548,
									name: '骨科'
								}
							]
						}]
					};
					if(option && typeof option === "object") {
						myChart.setOption(option, true);
					}
				</script>
				<br />
				<br />
				<h3 class="has-text-centered subtitle">2 患者性别统计</h2>
				<div id="container2" style="height: 300%"></div>
				<script type="text/javascript">
					var dom = document.getElementById("container2");
					var myChart = echarts.init(dom);
					var app = {};
					app.title = '患者性别统计环形图';
					var option = {
						tooltip: {
							trigger: 'item',
							formatter: "{a} <br/>{b}: {c} ({d}%)"
						},
						color:['#93D8A9','#FFB99D','#AF7DCC','#FFD83D','#bbe2e8'],
						legend: {
							orient: 'horizontal',
							x: 'left',
							data: ['男', '女']
						},
						series: [{
							name: '性别|人数|占比',
							type: 'pie',
							radius: ['50%', '90%'],
							avoidLabelOverlap: false,
							label: {
								normal: {
									show: false,
									position: 'center'
								},
								emphasis: {
									show: true,
									textStyle: {
										fontSize: '30',
										fontWeight: 'bold'
									}
								}
							},
							labelLine: {
								normal: {
									show: false
								}
							},
							data: [{
									value: <?=$sex_man?>,
									name: '男'
								},
								{
									value: <?=$sex_woman?>,
									name: '女'
								}
							]
						}]
					};
					if(option && typeof option === "object") {
						myChart.setOption(option, true);
					}
				</script>
				
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