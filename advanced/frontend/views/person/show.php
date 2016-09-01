<div class="person-information">
	<div class="title">
		<h2>个人信息管理</h2>
		<label class="time-label" id="time_label"></label>
		<a href="/user/logout">
			<span class="logout">Logout</span>
		</a>
	</div>
	<div class="operation">
		<a href="/person/add">
			<img src="/static/images/add_user_33.338595106551px_1200609_easyicon.net.png" class="operation-add">
			<span class="add">添加用户</span>
		</a>
		<a href="/person/to-import">
			<span class="batch-add">批量添加用户</span>
		</a>
		<form class="select-form" action="/person/sel" name="select_form" method="get">
			<input type="text" name="select" value="<?php if (!empty($keyword)) echo $keyword;?>" class="operation-select-text" >
			<a href="javascript:void(0)" onclick="document:select_form.submit()">
				<img src="/static/images/Magnify_query_32px_1194075_easyicon.net.png" class="operation-select">
			</a>
		</form>
	</div>
	<div class="hidebg"></div>
    <div class="confirm-div">
        <span class="close-div">×</span>
        <div>Do you sure to delete?</div>
        <div class="button-div">
            <button type="button" class="btn btn-default btn-lg active" id="no_button">No</button>
            <button type="button" class="btn btn-primary btn-lg active" id="yes_button">Yes</button>
        </div>
    </div>
	<table class="information" cellspacing="0" cellpadding="0">
		<form action="/person/all" method="post" id="order_form">
			<tr class="information-head">
				<th>序号</th>
				<th>头像</th>
				<th><?php if(!empty($name)) {echo $name;} else {echo '姓名';} ?></th>
				<th>性别</th>
				<th><?php if(!empty($age)) {echo $age;} else {echo '年龄';} ?></th>
				<th>操作</th>
			</tr>
		</form>
		<?php  $i = 1; ?>
		<?php if (!empty($persons)) {?>
			<?php foreach ($persons as $value) {?>
				<tr class="information-head">
					<td><?=$i ?></td>
					<td><img src="/<?php echo (!empty($value['imageFile'])) ? $value['imageFile'] : '';?>"></td>
					<td><?php echo (!empty($value['name'])) ? $value['name'] : '';?></td>
					<td><?php echo (!empty($value['gender'])) ? $value['gender'] : '';?></td>
					<td><?php echo (!empty($value['age'])) ? $value['age'] : '';?></td>
					<td>
						<a href="/person/to-update?_id=<?php echo (!empty($value['_id'])) ? $value['_id'] : '';?>">
							<img src="/static/images/user_modify_32px_556807_easyicon.net.png" class="operation-modify">
						</a>

						<input type="hidden" class="del-id" value="<?php echo (!empty($value['_id'])) ? $value['_id'] : '';?>"/>
						<img src="/static/images/Delete_group_32px_1186690_easyicon.net.png" class="operation-delete">
					</td>
				</tr>
			<?php $i++;} ?>
		<?php } ?>
	</table>

	<!-- pagination -->
	<div class="pagination">
		<ul class="pagination pagination-lg">
			<?php if (!empty($pagination)) { ?>
				<?php if ($pagination->page > 0) { ?>
				    <li><a href="<?php if (!empty($keyword)) { echo $pagination->createUrl($pagination->page - 1).'&keyword='.$keyword; } else { echo $pagination->createUrl($pagination->page - 1); } ?>">&laquo;</a></li>
				<?php } else { ?>
				    <li><a href="#">&laquo;</a></li>
				<?php } ?>

				  <?php if($pagination->pageCount >= 1 && $pagination->pageCount < 10) { 
				  	for ($i = 0; $i < $pagination->pageCount; $i++) { ?>
				  <li><a href="<?php if (!empty($keyword)) { echo $pagination->createUrl($i).'&keyword='.$keyword; } else { echo $pagination->createUrl($i); } ?>"><?=$i+1; } ?>
				  <?php } ?></a></li>

				<?php if ($pagination->page < $pagination->pageCount) { ?>
				    <li><a href="<?php if (!empty($keyword)) { echo $pagination->createUrl($pagination->page + 1).'&keyword='.$keyword; } else { echo $pagination->createUrl($pagination->page + 1); } ?>">&raquo;</a></li>
				<?php } else { ?>
				    <li><a href="#">&raquo;</a></li>
				<?php } ?>
			<?php } ?>
		</ul>
	</div>
</div>
<div class="hidebg"></div>

<script type="text/javascript">
	var id;
	$(".operation-delete").click(function() {
		$(".hidebg").show();
		$(".hidebg")[0].style.height = $("body")[0].clientHeight + "px";
		$(".confirm-div").show("fast");
		id = $(this).parent().find("input:hidden").val();
		console.log(id);
	});

	$("#yes_button").click(function() {
		location.href = "/person/del?_id=" + id;
	});

	$("#no_button").click(function() {
		$(".hidebg").hide();
		$(".confirm-div").hide("fast");
	});

	$(".close-div").mouseover(function() {
		$(".close-div").css("color", "gray");
	});

	$(".close-div").mouseleave(function() {
		$(".close-div").css("color", "lightgray");
	});

	$(".close-div").click(function() {
		$(".hidebg").hide();
		$(".confirm-div").hide("fast");
	});
</script>