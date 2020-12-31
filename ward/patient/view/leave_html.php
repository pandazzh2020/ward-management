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
				<h2 class="subtitle">患者平台<span class="is-hidden-mobile">&emsp;&emsp;</span></h2>
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
		<div class="column is-8">
			<div class="box" data-aos="flip-right" data-aos-duration="800" data-aos-once="true">
				<h2 class="has-text-centered subtitle"><i class="fas fa-suitcase-rolling"></i>&thinsp;离院请假</h2>
				<div class="columns">
					<div class="column">
						<table style="width: 100%;border-collapse:separate; border-spacing:0px 10px;">
							<tr>
								<td>
									患者姓名:
								</td>
								<td style="padding-left: 15px;">
									<?=$user_name?>
								</td>
							</tr>
							<tr>
								<td>
									账号:
								</td>
								<td style="padding-left: 15px;">
									<?=$user_account?>
								</td>
							</tr>
						</table>
					</div>
					<div class="column has-text-centered">
						<a class="button is-info is-outlined is-small" <?=isset($user_id)?"href=\"leave_add.php\"":"disabled=\"disabled\""?>>
							提交申请
						</a>
					</div>
				</div>
					<?php
						if(empty($leave_list)):
					?>
						<p class="has-text-centered">暂无申请记录</p>
					<?php
						else:
					?>
						<table class="table" style="width: 100%;">
							<thead>
							    <tr>
									<th>起始时间</th>
									<th>返院时间</th>
									<th>离院原因</th>
									<th>医生审批</th>
							    </tr>
							</thead>
					<?php
							foreach($leave_list as $row):
					?>
								<tr>
									<td>
										<?=date('Y-m-d H:i',strtotime($row['date_start']))?>
									</td>
									<td>
										<?=date('Y-m-d H:i',strtotime($row['date_end']))?>
									</td>
									<td>
										<?=$row['request']?>
									</td>
									<td>
										<?=$row['doctor_response']?>
									</td>
								</tr>
					<?php 
							endforeach;
					?>
						</table>
						<?php
							if($max_page>1):
						?>
							<br>
							<nav class="pagination is-centered" role="navigation" aria-label="pagination">
							  <a class="pagination-previous has-background-white" href="./leave.php?page=1">首页</a>
							  <a class="pagination-previous has-background-white" href="./leave.php?page=<?=$page-1; ?>"><</a>
							  <ul class="pagination-list">
									<?php
										for($p=1;$p<=$max_page;$p++):
											if($p==$page):
									?>
												<li><a class="pagination-link is-current" href="./leave.php?page=<?=$p?>"><?=$p?></a></li>
									<?php
											else:
									?>
												<li><a class="pagination-link has-background-white" href="./leave.php?page=<?=$p?>"><?=$p?></a></li>
									<?php
											endif;
										endfor;
									?>
							  </ul>
							  <a class="pagination-next has-background-white" href="./leave.php?page=<?=$page+1; ?>">></a>
							  <a class="pagination-next has-background-white" href="./leave.php?page=<?=$max_page; ?>">尾页</a>
							</nav>
						<?php
							endif;
						?>
					<?php
						endif;
					?>
			</div>
		</div>
	</div>
</section>

<?php
	//脚部文件
	require '../public/_share/_footer.php';
?>