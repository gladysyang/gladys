function Refresh() {
	var newDate = new Date();
	document.getElementById('time_label').innerText = newDate.toLocaleString();
}
var interval = setInterval("Refresh()", 1000);
