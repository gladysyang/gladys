<div class="person-information">
	<div class="update-title">
		<div style="text-align:left;"><a href="/person/all" class="back">返回</a></div>
		<div class="header"><h2>修改用户个人信息</h2></div>
		<div><label class="time-label" id="time_label"></label></div>
	</div>
	<div class="update-div">
		<img src="/<?php echo $person['imageFile'] ?>" class="image" >
		<a href="javascript:void(0)" class="update-image">修改头像</a>
		<form class="update-form" method="post" action="/person/update" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?=$person['_id']?>">
			<input type="hidden" name="hidden-imageFile" value="<?=$person['imageFile'] ?>">
			<div class="file">
				<input type="file" name="imageFile" style="display:none" id="file">
			</div>
			<div class="name">
				<label>Name : </label><input type="text" name="name" value="<?=$person['name']?>">
			</div>
			<div class="gender">
				<label>Gender : </label>
				<input type="radio" name="gender" class="gender-one" value="male" <?php echo $person['gender'] == 'male' ? 'checked':''; ?>> male
				<input type="radio" name="gender" class="gender-two" value="female" <?php echo $person['gender'] == 'female' ? 'checked':''; ?>> female
			</div>
			<div class="age">
				<label>Age : </label><input type="text" name="age" value="<?=$person['age']?>">
			</div>
			<div class="button-div">
				<button type="button" class="btn btn-primary btn-sm" id="update_button">UPDATE</button>
				<button type="button" class="btn btn-primary btn-sm" id="cancel_button">CANCEL</button>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	$("#update_button").click(function() {
		$(".update-form").submit();
	});

	$("#cancel_button").click(function() {
		location.href = "/person/all";
	});

	$(".update-image").click(function() {
		$("#file").css("display", "inline");
	})
</script>