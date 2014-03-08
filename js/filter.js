var times = new Array();

$(document).ready(function(){
	//Checkbox function
	$('#sidebar :checkbox').click(function () {
		//Check if time
		day = this.parentNode.parentNode.parentNode.id.substring(0,2);
		time = this.value;
		if(this.checked){//add to array
			times.push(day + time);
		}else{//Remove from array
			var index = times.indexOf(day + time);
			if (index > -1){
				times.splice(index, 1);
			}
		}

		filter();
	});
});

function filter(){
	$('.eventContainer').each(function(i, obj) {
		eventData = JSON.parse(obj.children[0].innerHTML);

		if(times.length >= 1){//Times array is not empty, filer by it
			if(-1 != times.indexOf(eventData.day + eventData.time)){//In filter, show
				obj.style.display = "inherit";
			}else{//Hide
				obj.style.display = "none";
			}
		}else{//No time filtering, show all
			obj.style.display = "inherit";
		}//Done with time filtering

	});
}