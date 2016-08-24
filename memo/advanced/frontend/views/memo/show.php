<div class="memo">
	<div class="title">
		<div class="memo-edit" ><font id="memo_edit" onclick="editMethod()">编辑</font></div>
		<div class="title-head">便签</div>
		<div class="memo-add">
			<font id="edit_cancel" onclick="editCancel()">取消</font>
			<font id="add_content" onclick="addContent()">添加</font>
		</div>
	</div>
	<div class="memo-content">
	<?php if (!empty($memos)) 
	{  
		for ($i = 0; $i < count($memos); $i ++) 
		{ ?>
			<div class="each-record" >
				<div class="each-content" id="content">
					<input type="hidden" value="<?=$memos[$i]->_id; ?>">
					<input type="checkbox" onclick="checkboxClick(this)"><?php if (!empty($memos[$i]->content)) { echo mb_substr($memos[$i]->content, 0, 5, "utf-8");}?>
				</div>
				<div class="each-date" onclick="eachRecord(this)"><?php if (!empty($memos[$i]->date)) { echo substr($memos[$i]->date, 2, 8);}?> ></div>
			</div>
		<?php } }?>
	</div>
	<div class="delete-content" id="delete_content">
		<button class="del" id="del" onclick="delRecord()">删除(<span id="count"></span>)</button>
	</div>
</div>
<script type="text/javascript">
	var deleteContent = document.getElementById("delete_content");
	deleteContent.style.display = "none";

	//取消设为不可见
	var cancelEdit = document.getElementById("edit_cancel");
	cancelEdit.style.display = 'none';

	//页面刚加载时，所有的checkbox设为不可见的
	var checkboxs = document.getElementsByTagName("input");
	for(var i = 0; i < checkboxs.length; i ++) {
		if (checkboxs[i].type == "checkbox") {
			checkboxs[i].style.display = "none";
		}
	}
</script>