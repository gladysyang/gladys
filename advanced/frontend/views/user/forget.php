<div　class="person-information">
	<div class="register-title">
		<div style="text-align:left;"><a href="/user/login" class="back">返回</a></div>
		<div class="header"><h2>找回密码</h2></div>
		<div><label class="time-label" id="time_label"></label></div>
	</div>
	<div class="forget-div">
		<form action="/user/forget" method="post" class="forget-password-form">
			<div class="forget-message">请输入你的有效邮箱，方便找回密码</div>
			<div class="message-email">请输入正确的邮箱</div>
			<div class="email">Email :<input type="text" name="email" class="email-input"></div>
			<div class="forget">
				<button type="button" class="btn btn-primary btn-sm" id="send_button">Send</button>
			</div>
		</form>
		<div class="message"><?php if (!empty($message)) {echo $message;} ?></div> 
	</div>
</div>
<script type="text/javascript">
	$("#send_button").click(function() {
		$(".forget-password-form").submit();
	})
	$(".email-input").mouseleave(function() {
		var value = $(".email-input").val();
		var reg = new RegExp("^[a-zA-Z0-9_-]+@([a-zA-Z0-9-]+)*[a-zA-Z]+/.$");
		if (value != "" && !reg.test(value)) {
			$(".message-email").css("display", "inline");
		} else {
			$(".message-email").css("display", "none");
		}
	})
</script>