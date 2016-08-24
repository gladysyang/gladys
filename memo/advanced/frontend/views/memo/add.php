<div class="memo">
	<div class="title">
		<div class="memo-edit"><font id="cancel_add" onclick="canAdd()">取消</font></div>
		<div class="title-head">编辑</div>
		<div class="memo-add"><font id="memo_add" onclick="finishMethod()">完成</font></div>
	</div>
	<div class="memo-content" id="memo_content">
		<form method="post" id="add_form" action="/memo/add">
			<div class="clock" id="clock">
				<input type="text" name="clock" id="clock_span" class="clock-text"/>
				<img src="/static/images/Time_icon_24px_515107_easyicon.net.png">
			</div>
			<textarea class="edit-content" id="edit_content" name="edit_content" cols="20" >
			</textarea>
		</form>
	</div>
	<!-- 设置提醒时间 -->
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
		<div><input type="file" accept="image/*" id="avatar-select" name="file" capture="camera">上传图片</div>
	</div>

	<div class="add-content">
		<div onclick="backgroundEvent()"><img src="/static/images/background_31.551506657323px_1202945_easyicon.net.png"></div>
		<div onclick="insertPicture()"><img src="/static/images/picture_30.215827338129px_1201195_easyicon.net.png">
		</div>
		<div onclick="showTime()"><img src="/static/images/Time_icon_24px_515107_easyicon.net.png"></div>
		<div ><img src="/static/images/paint_brush_24px_1074011_easyicon.net.png"></div>
	</div>
</div>
<script type="text/javascript">
	var finish = document.getElementById("memo_add");
	finish.setAttribute("disabled", "disabled");

	var backgroundDiv = document.getElementById("background_div");
	backgroundDiv.style.display = "none";

	var backgroundDiv = document.getElementById("insert_picture");
	backgroundDiv.style.display = "none";

	document.getElementById("time_div").style.display = "none";

	var now = new Date();
	document.getElementById("now_time").innerText = now.toLocaleString(); 
	document.getElementById("calendar").value = now.getFullYear() + "-" + fix((now.getMonth() + 1),2) + "-" + fix(now.getDate(),2) + "T" + fix(now.getHours(),2) + ":" + fix(now.getMinutes(),2);

	function fix(num, length) {
	  	return ('' + num).length < length ? ((new Array(length + 1)).join('0') + num).slice(-length) : '' + num;
	}
</script>