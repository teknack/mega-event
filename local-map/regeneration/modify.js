window.onload = function display(){
	var max = parseInt(document.getElementById("max").value);
	if(!(max>0))
		max=0;
	document.getElementById("disp").innerHTML = max;
}

function up(type){
	var max = parseInt(document.getElementById("max").value);
	var num = parseInt(document.getElementById(type).innerHTML);
	if((num<6) && (max>0)){
		num++;
		max--;
	}
	document.getElementById("max").value = max;
	document.getElementById("disp").innerHTML = max;
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
	document.getElementById("disp").innerHTML = max;
	document.getElementById(type).innerHTML = num;
	document.getElementById(type).value = num;
}

function sendback(bonus){

	var foodres = parseInt(document.getElementById("fooddiv").value);
	var waterres = parseInt(document.getElementById("waterdiv").value);
	var powerres = parseInt(document.getElementById("powerdiv").value);
	var metalres = parseInt(document.getElementById("metaldiv").value);
	var woodres = parseInt(document.getElementById("wooddiv").value);

	if(!(foodres>0))
		foodres = 0;
	if(!(waterres>0))
		waterres = 0;
	if(!(powerres>0))
		powerres = 0;
	if(!(metalres>0))
		metalres = 0;
	if(!(woodres>0))
		woodres = 0;

	var factor = parseInt(bonus);

	switch(factor) {
		case 0:
			waterres = waterres + 2;
			break;
		case 1:
			foodres++;
			waterres++;
			break;
		case 2:
			powerres++;
			waterres--;
			break;
		case 4:
			metalres++;
			woodres++;
			break;
	}

	window.location = "../player.php?foodres="+foodres+"&waterres="+waterres+"&powerres="+powerres+"&metalres="+metalres+"&woodres="+woodres;
}
