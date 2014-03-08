$(document).ready(function(){
	//Checkbox function
	$('#sidebar :checkbox').click(function () {
		alert(this.parentNode.parentNode.parentNode.id);
	});

	$('.eventContainer').each(function(i, obj) {
		if(i == 0){
			eventData = obj.children[0].innerHTML;
			alert(JSON.parse(eventData).day);
		}
	});
});