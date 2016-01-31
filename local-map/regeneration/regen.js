function up(type){
	var max = parseInt(document.getElementById("max").innerHTML);
	var num = parseInt(document.getElementById(type).innerHTML);
	if((num<6) && (max>0)){
		num++;
		max--;
	}
	document.getElementById("max").innerHTML = max;
	document.getElementById(type).innerHTML = num;
}
function down(type){
	var max = parseInt(document.getElementById("max").innerHTML);
	var num = parseInt(document.getElementById(type).innerHTML);
	if(num>0){
		num--;
		max++;
	}
	document.getElementById("max").innerHTML = max;
	document.getElementById(type).innerHTML = num;
}