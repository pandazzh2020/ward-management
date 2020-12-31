<?php
	if(!defined('APP')) die('error!<br>不能直接访问此页面');
?>
<?php
	//头部文件
	require '../public/_share/_head.php';
?>

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
				<div class="has-text-centered">
					<h2 class="has-text-centered subtitle"><i class="fas fa-user-graduate"></i>&thinsp;病人信息</h2>
				</div>
				<br>
				<table style="width: 100%;border-collapse:separate; border-spacing:0px 10px;">
					<tr>
						<td>
							姓名:
						</td>
						<td style="padding-left: 15px;">
							<?=$patient_detail["patient_name"]?>
						</td>
					</tr>
					<tr>
						<td>
							账号:
						</td>
						<td style="padding-left: 15px;">
							<?=$patient_detail["account"]?>
						</td>
					</tr>
					<tr>
						<td>
							性别:
						</td>
						<td style="padding-left: 15px;">
							<?=$patient_detail["sex"]?>
						</td>
					</tr>
					<tr>
						<td>
							所属科室:
						</td>
						<td style="padding-left: 15px;">
							<?=$patient_detail["department"]?>
						</td>
					</tr>
					<tr>
						<td>
							病症:
						</td>
						<td style="padding-left: 15px;">
							<?=$patient_detail["disease_name"]?>
						</td>
					</tr>
					<tr>
						<td>
							负责医生:
						</td>
						<td style="padding-left: 15px;">
							<?=$patient_detail["doctor_name"]?>
						</td>
					</tr>
					<tr>
						<td>
							病房:
						</td>
						<td style="padding-left: 15px;">
							<?php
								if(empty($patient_detail['building'])):
							?>
								<span>暂未安排</span>
							<?php
								else:
							?>
								<a href="./ward_detail?id=<?=$patient_detail['ward_id']?>">
									<?=$patient_detail['building']?>号楼&nbsp;<?=$patient_detail['number']?>室
								</a>
							<?php
								endif;
							?>
						</td>
					</tr>
					<tr>
						<td>
							是否特殊观察:
						</td>
						<td style="padding-left: 15px;">
							<?=$patient_detail["supervisor"]?>
						</td>
					</tr>
				</table>
				<br>
				<div class="has-text-centered">
					<a class="button is-info is-outlined is-small" href="./need_add.php?id=<?=$patient_detail["patient_id"]?>">
						需求登记
					</a>
				</div>
				<br>
				<div class="has-text-centered">
					<a href="leave.php"><i class="fas fa-arrow-left"></i>&thinsp;
					<a href="JavaScript:history.go(-1)">返回</a>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	window.onload = function () {
		//打招呼
		now = new Date(), hour = now.getHours()
		if (hour < 6) { $('#helloMsg').text("凌晨好，") }
		else if (hour < 9) { $('#helloMsg').text("早上好！") }
		else if (hour < 12) { $('#helloMsg').text("上午好！") }
		else if (hour < 14) { $('#helloMsg').text("中午好！") }
		else if (hour < 17) { $('#helloMsg').text("下午好！") }
		else if (hour < 19) { $('#helloMsg').text("傍晚好！") }
		else { $('#helloMsg').text("晚上好，") }
	}
</script>
<?php
	//脚部文件
	require '../public/_share/_footer.php';
?>