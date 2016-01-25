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
function action(row,col) //call it to get the available actions
{
	/*row=0;//make method to pass the row and column selected
	col=8;*/
  console.log(row+","+col)
	var xhttp;
    var comm
  	if (window.XMLHttpRequest) {
    // code for modern browsers
    xhttp = new XMLHttpRequest();
    } else {
    // code for IE6, IE5
    xhttp = new ActiveXObject("Microsoft.XMLHTTP");
  	}
  	xhttp.onreadystatechange = function() 
    {
        if (xhttp.readyState == 4 && xhttp.status == 200) 
        {
      	    comm=JSON.parse(xhttp.responseText);
            var content="";
            for(var i=0;i<comm.length;i++)
            {
                content+="<input type='submit' value="+comm[i]['action']+" name="+comm[i]['action']+"><br>";
            }
            document.getElementById("bottom_actions").innerHTML=content;
        }
    }
    xhttp.open("GET", "getActions.php?row="+row+"&col="+col, true);
  	xhttp.send();
}

function getLoc(row,col)
{
	action(row,col);
}
