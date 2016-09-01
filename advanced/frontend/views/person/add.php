<div class="person-information">
	<div class="add-title">
		<div style="text-align:left;"><a href="/person/all" class="back">返回</a></div>
		<div class="header"><h2>添加用户信息</h2></div>
		<div><label class="time-label" id="time_label"></label></div>
	</div>
	<div class="add-div">
		<form class="add-form" method="post" action="/person/save" id="add_form" enctype="multipart/form-data">
			<div class="image">
				<input type="file" name="imageFile" class="file">
			</div>
			<div class="name">
				<label>Name : </label><input type="text" name="name" >
			</div>
			<div class="gender" id="gender">
				<label>Gender : </label>
				<input type="radio" name="gender" class="gender-one" value="male"> male
				<input type="radio" name="gender" class="gender-two" value="female"> female
			</div>
			<div class="age">
				<label>Age : </label><input type="text" name="age" id="age">
				<span class="age-message">×</span>
			</div>
			
			<div class="button-div">
				<button type="button" class="btn btn-primary btn-sm" id="add_button">ADD</button>
				<button type="button" class="btn btn-primary btn-sm" id="reset_button">RESET</button>
			</div>
		</form>
	</div>
	<div class="message">
		<font><?php if (!empty($message)){echo $message;}?></font>
	</div>
</div>
<script type="text/javascript">
	$(".age-message").css("color", "red");
	$(".age-message").css("display" ,"none");

	$("#add_button").click(function() {
		$("#add_form").submit();
	});

	$("#reset_button").click(function() {
		$(".name > input").val("");
		$(".age > input").val("");
	})
	$("#age").mouseleave(function() {
		var age = $("#age").val();
		if (age < 3 || age > 100 || isNaN(parseInt(age))) {
			$(".age-message").css("display" ,"inline");
		} else {
			$(".age-message").css("display" ,"none");
		}
	});
	$("#age").mousedown(function() {
		$("#age").val("");
		$(".age-message").css("display" ,"none");
	});
</script>