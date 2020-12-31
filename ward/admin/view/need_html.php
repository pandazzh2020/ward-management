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
		<div class="column is-8">
			<div class="box" data-aos="flip-right" data-aos-duration="800" data-aos-once="true">
				<h2 class="has-text-centered subtitle"><i class="fas fa-paste"></i>&thinsp;病人需求</h2>
				<div class="has-text-centered">
					<a class="button is-info is-outlined is-small" href="./patient.php?func=需求登记">
						需求登记
					</a>
				</div>
				<br>
					<?php
						if(empty($need_list)):
					?>
						<p class="has-text-centered">暂无病人需求记录</p>
					<?php
						else:
					?>
						<table class="table" style="width: 100%;">
							<thead>
							    <tr>
									<th>账号</th>
									<th>姓名</th>
									<th>需求日期</th>
									<th>需求内容</th>
									<th>医生答复</th>
									<th>操作</th>
							    </tr>
							</thead>
					<?php
							foreach($need_list as $row):
					?>
								<tr>
									<td>
										<?=$row['account']?>
									</td>
									<td>
										<a href="./patient_detail?id=<?=$row['patient_id']?>">
											<?=$row['name']?>
										</a>
									</td>
									<td>
										<?=date('Y-m-d',strtotime($row['date']))?>
									</td>
									<td>
										<?=$row['detail']?>
									</td>
									<td>
										<?=$row['doctor_response']?>
									</td>
									<td>
										<a class="button is-outlined is-danger is-small" onclick="checkDelete(<?=$row['id']?>,'<?=$row['name']?>')">
											删除
										</a>
									</td>
								</tr>
					<?php 
							endforeach;
					?>
						</table>
						<form id="form" method="post" action="need.php?page=<?=$page?>">
							<!-- 提交用的隐藏表单 -->
							<input type="hidden" name="id" id="id" />
						</form>
						<script>
							function checkDelete(id,name){
								var r = confirm("确定删除"+name+"患者的需求记录吗？");
								if (r == true) {
									$("#id").val(id);
									$("form").submit();
								}
							}
						</script>
						<?php
							if($max_page>1):
						?>
							<br>
							<nav class="pagination is-centered" role="navigation" aria-label="pagination">
							  <a class="pagination-previous has-background-white" href="./need.php?page=1">首页</a>
							  <a class="pagination-previous has-background-white" href="./need.php?page=<?=$page-1; ?>"><</a>
							  <ul class="pagination-list">
									<?php
										for($p=1;$p<=$max_page;$p++):
											if($p==$page):
									?>
												<li><a class="pagination-link is-current" href="./need.php?page=<?=$p?>"><?=$p?></a></li>
									<?php
											else:
									?>
												<li><a class="pagination-link has-background-white" href="./need.php?page=<?=$p?>"><?=$p?></a></li>
									<?php
											endif;
										endfor;
									?>
							  </ul>
							  <a class="pagination-next has-background-white" href="./need.php?page=<?=$page+1; ?>">></a>
							  <a class="pagination-next has-background-white" href="./need.php?page=<?=$max_page; ?>">尾页</a>
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
