<div　class="person-information">
	<div class="login-title">
		<h2>个人信息管理</h2>
		<label class="time-label" id="time_label"></label>
	</div>
	<div class="forget-div">
		<div class="forget-message">邮件发送成功，请到邮箱查看详情</div>
		<?php if (!empty($url)) { ?>		
			<div class="email">点击以下链接－－></div>
			<a class="forget" href="<?=$url ?>">进入邮箱</a>
		<?php } ?>
	</div>
</div>

