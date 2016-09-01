<div　class="person-information">
	<div class="register-title">
		<div style="text-align:left;"><a href="/user/login" class="back">返回</a></div>
		<div class="header"><h2>注册</h2></div>
		<div><label class="time-label" id="time_label"></label></div>
	</div>
	<div class="register-div">
		<form action="/user/register" method="post" class="register-form">
			<div><?php ?></div>
			<div class="message-name">*字母开头，允许5-16字节，允许字母数字下划线</div>
			<div class="name">
				<span><?php if(!empty($message['name'])) { echo $message['name'][0];} ?></span><br>
				<label>Username:</label>
				<input type="text" name="name" value="" class="input-name">
			</div>
			<div class="message-password">*以字母开头，长度在8-18之间，只能包含字符、数字和下划线</div>
			<div class="password">
				<span><?php if(!empty($message['password'])) {echo $message['password'][0];} ?></span><br>
				<label>Password:</label>
				<input type="password" name="input_password" value="" class="password-input">
			</div>
			<div class="confirm-message">*密码不一致，请重新输入</div>
			<div class="confirm-password">
				<span><?php if(!empty($confirm_password)) {echo $confirm_password;} ?></span><br>
				<label>Confirm Password:</label>
				<input type="password" name="confirm_password" value="" class="confirm-input">
			</div>
			<div class="email-message">*请输入正确的邮箱地址</div>
			<div class="email">
				<span><?php if(!empty($message['email'])) {echo $message['email'][0];} ?></span><br>
				<label>Email:</label>
				<input type="text" name="email" value="" class="email-input">
			</div>
			<div class="register">
				<button type="button" class="btn btn-primary btn-sm" id="submit_button">Register</button>
				<button type="button" class="btn btn-primary btn-sm" id="reset_button">Reset</button>
			</div>
		</form>
	</div>
</div>