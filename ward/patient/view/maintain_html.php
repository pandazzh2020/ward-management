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
				<h2 class="has-text-centered subtitle"><i class="fas fa-wrench"></i>&thinsp;后勤报修</h2>
				<div class="columns">
					<div class="column">
						<table style="width: 100%;border-collapse:separate; border-spacing:0px 10px;">
							<tr>
								<td>
									病房楼座:
								</td>
								<td style="padding-left: 15px;">
									<?=isset($ward_building)?$ward_building." 号楼":"未安排"?>
								</td>
							</tr>
							<tr>
								<td>
									病房门牌:
								</td>
								<td style="padding-left: 15px;">
									<?=isset($ward_number)?$ward_number." 户":"未安排"?>
								</td>
							</tr>
						</table>
					</div>
					<div class="column has-text-centered">
						<a class="button is-info is-outlined is-small" <?=isset($ward_id)?"href=\"maintain_add.php\"":"disabled=\"disabled\""?>>
							提交申请
						</a>
					</div>
				</div>
					<?php
						if(empty($maintain_list)):
					?>
						<p class="has-text-centered">暂无报修记录</p>
					<?php
						else:
					?>
						<table class="table" style="width: 100%;">
							<thead>
							    <tr>
									<th>日期</th>
									<th>报修内容</th>
									<th>答复</th>
							    </tr>
							</thead>
					<?php
							foreach($maintain_list as $row):
					?>
								<tr>
									<td>
										<?=date('Y-m-d',strtotime($row['date']))?>
									</td>
									<td>
										<?=$row['request']?>
									</td>
									<td>
										<?=$row['admin_response']?>
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
							  <a class="pagination-previous has-background-white" href="./maintain.php?page=1">首页</a>
							  <a class="pagination-previous has-background-white" href="./maintain.php?page=<?=$page-1; ?>"><</a>
							  <ul class="pagination-list">
									<?php
										for($p=1;$p<=$max_page;$p++):
											if($p==$page):
									?>
												<li><a class="pagination-link is-current" href="./maintain.php?page=<?=$p?>"><?=$p?></a></li>
									<?php
											else:
									?>
												<li><a class="pagination-link has-background-white" href="./maintain.php?page=<?=$p?>"><?=$p?></a></li>
									<?php
											endif;
										endfor;
									?>
							  </ul>
							  <a class="pagination-next has-background-white" href="./maintain.php?page=<?=$page+1; ?>">></a>
							  <a class="pagination-next has-background-white" href="./maintain.php?page=<?=$max_page; ?>">尾页</a>
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