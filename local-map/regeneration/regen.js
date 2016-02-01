function up(type){
	var max = parseInt(document.getElementById("max").value);
	var num = parseInt(document.getElementById(type).innerHTML);
	if((num<6) && (max>0)){
		num++;
		max--;
	}
	document.getElementById("max").value = max;
	document.getElementById(type).innerHTML = num;
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
}

function sendback(){
	var foodres = parseInt(document.getElementsById("food").innerHTML);
	var waterres = parseInt(document.getElementsById("water").innerHTML);
	var powerres = parseInt(document.getElementsById("power").innerHTML);
	var metalres = parseInt(document.getElementsById("metal").innerHTML);
	var woodres = parseInt(document.getElementsById("wood").innerHTML);

	window.location.href = "../player.php?foodres="+foodres+"&waterres="+waterres+"&powerres="+powerres+"&metalres="+metalres+"&woodres="+woodres;
}
