var times = new Array();

$(document).ready(function(){
	//Checkbox function
	$('#sidebar :checkbox').click(function () {
		//Check if time
		day = this.parentNode.parentNode.parentNode.id.substring(0,2);
		time = this.value;
		if(this.checked){//add to array
			times.push(day + time);
			alert("added " + day + time);
		}else{//Remove from array
			var index = times.indexOf(day + time);
			if (index > -1){
				times.splice(index, 1);
				alert("removed " + day + time);
			}
		}

		filter();
	});
});

function filter(){
	$('.eventContainer').each(function(i, obj) {
		eventData = JSON.parse(obj.children[0].innerHTML);
		console.log(eventData.day + eventData.time);
		if(-1 == times.indexOf(eventData.day + eventData.time)){//In filter, show
			obj.style.display = "inline";
		}else{//Hide
			obj.style.display = "hide";
		}
	});
}