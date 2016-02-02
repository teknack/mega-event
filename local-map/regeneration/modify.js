function up(type){	
	var max = parseInt(document.getElementById("max").value);
	var num = parseInt(document.getElementById(type).innerHTML);
	if((num<6) && (max>0)){
		num++;
		max--;
	}
	document.getElementById("max").value = max;
	document.getElementById(type).innerHTML = num;
	document.getElementById(type).value = num;
}
function down(type){
	var max = parseInt(document.getElementById("max").value);
	var num = parseInt(document.getElementById(type).innerHTML);
	if(num>0){
		num--;
		max++;
	}
	document.getElementById("max").value = max;
	document.getElementById(type).innerHTML = num;
	document.getElementById(type).value = num;
}

function sendback(){
	
	<!--Wrong line -->
	var foodres = parseInt(document.getElementById("fooddiv").value);
	var waterres = parseInt(document.getElementById("waterdiv").value);
	var powerres = parseInt(document.getElementById("powerdiv").value);
	var metalres = parseInt(document.getElementById("metaldiv").value);
	var woodres = parseInt(document.getElementById("wooddiv").value);

	alert("foodres :"+foodres);
	window.location = "../player.php?foodres="+foodres+"&waterres="+waterres+"&powerres="+powerres+"&metalres="+metalres+"&woodres="+woodres;
}
