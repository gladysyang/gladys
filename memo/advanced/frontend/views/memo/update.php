<div class="memo">
	<div class="title">
		<div class="memo-edit"><a href="/memo/to-show">取消</a></div>
		<div class="title-head">编辑</div>
		<div class="memo-add"><font id="memo_add" onclick="finishMethod()">完成</font></div>
	</div>
	<div class="memo-content">
		<?php if (!empty($memo)) { ?>
		<form method="post" id="add_form" action="/memo/update">
			<div class="clock" id="clock">
				<input type="text" name="clock" id="clock_span" class="clock-text" value="<?php if(!empty($memo->clock)) { echo $memo->clock;} else { echo "";} ?>"/>
				<img src="/static/images/Time_icon_24px_515107_easyicon.net.png">
			</div>
			<input type="hidden" name="id" value="<?=$memo->_id; ?>"/>
			<textarea class="edit-content" id="edit_content" name="edit_content" cols="20"><?php if(!empty($memo->content)) { echo $memo->content;} else { echo "";} ?></textarea>
		</form>
		<?php } ?>
	</div>
	<!-- 设置提醒时间 -->http://192.168.222.54:8888/memo/to-show
	<!-- 隐藏层 -->
	<div class="hidebg" id="hidebg"></div>
	<div class="time-div" id="time_div">
		<h4>设置提醒时间</h4>
		<div class="now-time" id="now_time"></div>
		<div class="select-time" id="select_time">
			<input type="datetime-local" name="calendar" class="calendar" id="calendar">
		</div>
		<div class="submit-button">
			<div class="submit" id="submit" onclick="submitTime()">确认</div>
			<div class="cancel" id="cancel" onclick="hideTime()">取消</div>
		</div>
	</div>
	<div class="background-div" id="background_div">
		<div class="background-one" onclick="setBackground(this)" id="background_one"></div>
		<div class="background-two" onclick="setBackground(this)" id="background_two"></div>
		<div class="background-three" onclick="setBackground(this)" id="background_three"></div>
	</div>
	<div class="insert-picture" id="insert_picture">
		<div onclick="insert(this)">拍照</div>
		<div onclick="insert(this)"><input type="file" name="image" style="display:none" id="image">图片</div>
	</div>

	<div class="add-content">
		<div onclick="backgroundEvent()"><img src="/static/images/background_31.551506657323px_1202945_easyicon.net.png"></div>
		<div onclick="insertPicture()"><img src="/static/images/picture_30.215827338129px_1201195_easyicon.net.png"></div>
		<div onclick="showTime()"><img src="/static/images/Time_icon_24px_515107_easyicon.net.png"></div>
		<div><img src="/static/images/paint_brush_24px_1074011_easyicon.net.png"></div>
	</div>
</div>
<script type="text/javascript">

	var backgroundDiv = document.getElementById("background_div");
	backgroundDiv.style.display = "none";

	var backgroundDiv = document.getElementById("insert_picture");
	backgroundDiv.style.display = "none";

	document.getElementById("time_div").style.display = "none";

	//给time-div赋值
	var now = new Date();
	document.getElementById("now_time").innerText = now.toLocaleString(); 
	document.getElementById("calendar").value = now.getFullYear() + "-" + fix((now.getMonth() + 1),2) + "-" + fix(now.getDate(),2) + "T" + fix(now.getHours(),2) + ":" + fix(now.getMinutes(),2);

	function fix(num, length) {
	  	return ('' + num).length < length ? ((new Array(length + 1)).join('0') + num).slice(-length) : '' + num;
	}

	var clock = document.getElementById("clock").children[0];
	if (clock.value != "") {
		document.getElementById("clock").style.display = "inline";
	}

</script>