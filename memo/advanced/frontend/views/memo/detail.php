<div class="memo">
	<div class="title">
		<div class="memo-edit" onclick="canAdd()"><</div>
		<div class="title-head">查看</div>
		<div class="memo-add">
			<font id="add_content" onclick="addContent()">添加</font>
		</div>
	</div>
	<?php if (!empty($memo)) 
	{  ?>			
	<div class="content" onclick="toUpdate()">
		<div class="clock" id="clock">
			<span name="clock" id="clock_span" class="clock-text"><?php if(!empty($memo->clock) ) { echo $memo->clock;} else { echo "";} ?></span>
			<img src="/static/images/Time_icon_24px_515107_easyicon.net.png">
		</div>
		<input type="hidden" name="id" value="<?=$memo->_id; ?>">
		<?php if (!empty($memo->content)) { echo $memo->content;}?>
	</div>
	<div class="show-time">
		<div><?php if (!empty($memo->date)) { echo $memo->date; }?></div>
	</div>
	<?php }?>
</div>
<script type="text/javascript">
	var clock = document.getElementById("clock_span");
	if (clock.innerText == "") {
		document.getElementById("clock").style.display = "none";
	}

	if (clock.innerText == "已过时") {
		document.getElementById("clock").style.marginLeft = "76%";
	}

</script>