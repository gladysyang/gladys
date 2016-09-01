<div class="person-information">
	<div class="add-title">
		<div style="text-align:left;"><a href="/person/all" class="back">返回</a></div>
		<div class="header"><h2>批量添加用户信息</h2></div>
		<div><label class="time-label" id="time_label"></label></div>
	</div>
	<div class="add-div">
		<form class="add-form" method="post" action="/person/import" enctype="multipart/form-data">
			<div class="batch-add">
				选择本地的csv文件上传
				<input type="file" name="file">
			</div>		
			<div class="import-div">
				<button type="button" class="btn btn-primary btn-sm" id="import_button">IMPORT</button>
				<button type="button" class="btn btn-primary btn-sm" id="cancel_button">CANCEL</button>
			</div>
		</form>
	</div>
	<div class="message">
		<font><?php if (!empty($message)){echo $message;}?></font>
	</div>
</div>
<script type="text/javascript">
	$("#import_button").click(function() {
		$(".add-form").submit();
	});

	$("#cancel_button").click(function() {
		location.href = "/person/all";
	})
</script>