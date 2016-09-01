<div　class="person-information">
	<div class="login-title">
		<h2>个人信息管理</h2>
		<label class="time-label" id="time_label"></label>
	</div>
	<div class="login-div">
		<form action="/user/log" method="post" class="login-form">
		<?php $cookies = Yii::$app->request->cookies; if (isset($cookies['name'])) { 
			?>
			<div class="name">
				<label>Username:</label>
				<input type="text" name="name" class="name-input" placeholder="Input username" value="<?=$cookies['name'];?>">
			</div>
			<div class="password">
				<label>Password:</label>
				<input type="password" name="password" class="password-input" placeholder="Input password" value="<?=$cookies['password'];?>">
			</div>
		<?php } else { ?>
			<div class="name-message">请输入长度3~12的用户名</div>
			<div class="name">
				<label>Username:</label>
				<input type="text" name="name" value="" class="name-input" placeholder="Input username">
			</div>
			<div class="password-message">请输入8~16位的密码</div>
			<div class="password">
				<label>Password:</label>
				<input type="password" name="password" value="" class="password-input" placeholder="Input password">
			</div>
	   <?php } ?>
			<div class="message">
				<?php if (!empty($message)) {?>
					<label><?=$message?></label>
				<?php }?>
			</div>
			<div class="remember-password">
				<input type="checkbox" name="checkbox" value="checked">rememberMe?&nbsp;&nbsp;
				<a href="/user/to-forget" id="forget_me">forgetMe?</a>
			</div>
			<div class="submit">
				<button type="button" class="btn btn-primary btn-sm" id="submit_button">Login</button>
			</div>
			<div class="register">
				<button type="button" class="btn btn-primary btn-sm" id="register">Register</button>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	$("#register").click(function() {
		location.href = "/user/to-register";
	});

	$("#submit_button").click(function() {
		$(".login-form").submit();
	});

	$(".name-message").css("display", "none");
	$(".password-message").css("display", "none");

	$(".name-input").blur(function() {
	    var length = $(".name-input")[0].value.length;
	    if (length > 16 || length < 3) {
	        $(".name-message").css("display", "inline");
	        $(".name-input").val("");
	    }
	    $(".message").css("display", "none");
	    $(".password-message").css("display", "none");
	});

    $(".password-input").blur(function() {
    	var length = $(".password-input")[0].value.length;
    	if (length > 16 || length < 8) {
    		$(".password-message").css("display", "inline");
    		$(".password-input").val("");
    	}
    	$(".message").css("display", "none");
    	$(".name-message").css("display", "none");
    });

</script>