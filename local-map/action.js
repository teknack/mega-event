var troopSelected=false;
var selRow;
var selCol;
var quantity;
function selectTroops()
{
	selRow=0;//make method to pass the row and column selected and also number of troops
	selCol=8;
	quantity=1;
	troopSelected=true;
}
function action() //call it to get the available actions
{
	var row,col;
	row=0;//make method to pass the row and column selected
	col=8;
	var xhttp;
  	if (window.XMLHttpRequest) {
    // code for modern browsers
    xhttp = new XMLHttpRequest();
    } else {
    // code for IE6, IE5
    xhttp = new ActiveXObject("Microsoft.XMLHTTP");
  	}
  	xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
    	return xhttp.responseText;
    }
  }
  xhttp.open("POST", "getWMap.php", true);
  if(troopSelected==false)                         //if no troops have been selected
  {
  	xhttp.send("func=getAction&row="+row+"&col="+col);
  }
  else
  {                                                //if troops have been selected
  	xhttp.send("func=move&srcRow="+selRow+"&srcCol="+selCol+"&destRow="+row+"&destCol="+col+"&quantity="+quantity);
  }
}