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
    var comm;
    var visibility; //decides if form is visible
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
                if(comm[i]['action']!=null)
                    content+="<input type='submit' value="+comm[i]['action']+" name="+comm[i]['action']+"><br>";
                else
                    visibility=comm[i]['visible'];
            }
            //alert(visibility);
            if(visibility=="false")
            {
                var quant=document.getElementById("quantity");
                quant.style.visibility='hidden';
            }
            else
            {
                var quant=document.getElementById("quantity");
                quant.style.visibility='visible';
            }
            document.getElementById("action").innerHTML=content;
            document.getElementById("row").value=row;
            document.getElementById("col").value=col;
        }
    }
    xhttp.open("GET", "getActions.php?row="+row+"&col="+col, true);
  	xhttp.send();
}
function getLoc(row,col)
{
	action(row,col);
}
window.onload=function dothings()
{
    var button=document.getElementById("resource");
    alert(button);
    button.onClick=function collect()
    {
        var xhttp;
    var comm;
    var visibility; //decides if form is visible
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
            
        }
    }
    xhttp.open("GET", "resources.php", true);
    xhttp.send();       
    }

}