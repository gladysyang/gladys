function finishMethod() {
	var finish = document.getElementById("memo_add");
	var text = document.getElementById("edit_content");
	var form = document.getElementById("add_form");
	if (text.value.trim() != "") {
		finish.setAttribute("disabled", "");
		form.submit();
	} else {
		finish.setAttribute("disabled", "disabled");
	}
}

function addContent() {
	this.location.href = "/memo/to-add";
}
function canAdd() {
	location.href = "/memo/to-show";
}
function editMethod() {
	var count = document.getElementById("count");
	var edit = document.getElementById("memo_edit");
		
	//点击编辑之后
	var deleteContent = document.getElementById("delete_content");
	deleteContent.style.display = "block";

	var addContent = document.getElementById("add_content");
	addContent.style.display = "none";

	var cancelEdit = document.getElementById("edit_cancel");
	cancelEdit.style.display = "block";
	
	var checkboxs = document.getElementsByTagName("input");
	for(var i = 0; i < checkboxs.length; i ++) {
		if (checkboxs[i].type == "checkbox") {
			checkboxs[i].style.display = "inline";
		}
	}

	if (edit.innerText == "编辑") {
		edit.innerText = "全选";
		return;
	}
	if (edit.innerText == "全选") {
		edit.innerText = "全不选";
		for (var i = 0; i < checkboxs.length; i++) {
			if (checkboxs[i].type == "checkbox") {
				checkboxs[i].checked = true;
				count.innerText++;
			}	
		}
		return;
	} 
	if (edit.innerText == "全不选") {
		edit.innerText = "全选";
		count.innerText = '';
		for (var i = 0; i < checkboxs.length; i++) {
			if (checkboxs[i].type == "checkbox") {
				checkboxs[i].checked = false;
			}
		}
		return;
	}	
}

//每个checkbox的点击事件
function checkboxClick(control) {
	if (control.checked == true) {
		++count.innerText;
		return;
	}
	if (control.checked == false) {
		--count.innerText;
		return;
	}
}

function editCancel() {
	var checkboxs = document.getElementsByTagName("input");
	for(var i = 0; i < checkboxs.length; i ++) {
		if (checkboxs[i].type == "checkbox") {
			checkboxs[i].style.display = "none";
		}
	}

	var deleteContent = document.getElementById("delete_content");
	deleteContent.style.display = "none";

	var addContent = document.getElementById("add_content");
	addContent.style.display = "block";

	var cancelEdit = document.getElementById("edit_cancel");
	cancelEdit.style.display = 'none';

	var edit = document.getElementById("memo_edit");
	if (edit.innerText == "全选" || edit.innerText == "全不选") {
		edit.innerText = "编辑";
	}
}

//查看每条记录
function eachRecord(control) {
	var id = control.parentNode.children[0].children[0].value;
	this.location.href = '/memo/detail?id=' + id;
}

//删除多条记录
function delRecord() {
	var idArr = new Array();
	var checkboxs = document.getElementsByTagName("input");

	for(var i = 0; i < checkboxs.length; i ++) {
		if (checkboxs[i].type == "checkbox" && checkboxs[i].checked == true) {
			idArr.push(checkboxs[i].parentNode.children[0].value);
		}
	}
	
	if (idArr.length > 0) {
		var form = document.createElement("form");
		form.action = "/memo/batch-del";
		form.method = "post";
		form.style.display = "none";
		
		var input = document.createElement("input");
		input.type = "hidden";
		input.value = idArr;
		input.name = "idArr";
		form.appendChild(input);

		document.body.appendChild(form);
		form.submit();
	}
}

//跳转到update页面
function toUpdate() {
	var input = document.getElementsByTagName("input");

	if (input[0].type == "hidden") {
		var id = input[0].value;
		this.location.href = "/memo/to-update?id=" + id;
	}
}

//换编辑器的背景色
function backgroundEvent() {
	var backgroundDiv = document.getElementById("background_div");
	backgroundDiv.style.display = "inline";
	var backgroundDiv = document.getElementById("insert_picture");
	backgroundDiv.style.display = "none";
}

function setBackground(control) {
	var editContent = document.getElementById("edit_content");
	var bgImage = getComputedStyle(document.getElementById(control.id), "style").backgroundImage;
	editContent.style.backgroundImage = bgImage;

	var backgroundDiv = document.getElementById("background_div");
	backgroundDiv.style.display = "none";
}

function insertPicture() {
	var backgroundDiv = document.getElementById("insert_picture");
	backgroundDiv.style.display = "inline";
	var backgroundDiv = document.getElementById("background_div");
	backgroundDiv.style.display = "none";
}

/*function insert(control) {
	var backgroundDiv = document.getElementById("insert_picture");
	backgroundDiv.style.display = "none";	
}*/

//显示提醒时间
function showTime() {
	var hidebg = document.getElementById("hidebg");
	hidebg.style.display = "block";
	hidebg.style.height = document.body.clientHeight + "px";
	document.getElementById("time_div").style.display = "block";
}

//取消设置时间
function hideTime() {
	document.getElementById("hidebg").style.display="none";
    document.getElementById("time_div").style.display="none";
}

//提交设置的时间
function submitTime() {
	var clock = document.getElementById("clock_span");
	//判断所选时间是否过时
	var selectTime = document.getElementById("calendar").value;
	//如果选择的时间没有过时
	if (compareTime(selectTime) < 0) {
		if (selectTime.indexOf('T') > 0) {
			selectTime = selectTime.replace("T", " ");
		}
	} else {
		selectTime = "已过时";
	}	

	clock.value = selectTime;

	document.getElementById("clock").style.display = "inline";
	document.getElementById("hidebg").style.display="none";
    document.getElementById("time_div").style.display="none";
}

//比较当前时间与选择的时间的大小
function compareTime(selectTime) {
	var now = new Date();
	if (selectTime.indexOf('T') > 0) {
		selectTime = selectTime.replace("T", " ");
	}
	var selTime = new Date(selectTime);
	
	return now.getTime() - selTime.getTime();
}

//打开本地文件或应用程序
