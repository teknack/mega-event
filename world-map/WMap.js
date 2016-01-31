var canvas;
var	ctx;
var x=0,i=0;
var y=0,j=0;
var playerId;
var faction;
var slotSize=10; //cell size in px
var hSize=9;     //hover window size , no. of slots/cells
var grid=[];
for(var i=0;i<100;i++)
{
	grid[i]=[];
}
var highlighted=[];
var temp;
function renderGrid()
{
	for(y=0,i=0;i<100;y+=slotSize,i++)
	{
		for(x=0,j=0;j<100;x+=slotSize,j++)
		{
			/*ctx.fillStyle=grid[i][j];
			ctx.strokeRect(x,y,slotSize,slotSize);
			ctx.strokeRect(x,y,slotSize,slotSize);
			ctx.strokeRect(x,y,slotSize,slotSize);
			ctx.fillRect(x,y,slotSize,slotSize);*/
			occupy(grid[i][j],i,j,1);
		}
	}
}
function convertToGrid(temp) //converts 1-D numeric 1-D associative to 2-D numeric array to 
{
	console.log(playerId);
	for(i=0,k=0;i<100;i++)
	  {
		for(j=0;j<100;j++,k++)
		{
			if(temp[k]["occupied"]==playerId )
			{
				grid[i][j]="blue";
			}
			else if(temp[k]["occupied"]==0)
			{
				grid[i][j]="white";
			}
			else
			{
				if(temp[k]["faction"]==faction)	
					grid[i][j]="yellow";
				else
					grid[i][j]="red";
			}
		}
	  }
}
window.onload=function loadDoc(){
	canvas=document.getElementById("canvas");
	ctx = canvas.getContext("2d");
  //ajax starts here do not edit!!
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
	  //window.alert(xhttp.responseText);
      temp=JSON.parse(xhttp.responseText);             //editable
      playerId=temp[10000]["player"];
      faction=temp[10000]["faction"];                                  
      convertToGrid(temp);	            			   //editable
      renderGrid(grid);                                //editable
    }
  }
  xhttp.open("GET", "getWMap.php", true);
  xhttp.send();
  //ajax ends--->
   document.getElementById("canvas").setAttribute("onClick","passCursorPosition(canvas,event)")	;
	document.getElementById("canvas").setAttribute("onmousemove","highlight(event)");
	document.getElementById("canvas").setAttribute("onmouseout","clear(event)");
  //playerId=temp[10]["player"];
}
function passCursorPosition(canvas, event) {
  	var xhttp;
  	var rect = canvas.getBoundingClientRect();
    var x = event.clientX - rect.left;
    var y = event.clientY - rect.top;
    x=x-(hSize/2*slotSize);
	if(x<0)
		x=0;
	y=y-(hSize/2*slotSize);
	if(y<0)
		y=0;
    var row=Math.floor(y/slotSize);
    var col=Math.floor(x/slotSize);
    if(row>99-hSize)
    	row=100-hSize;
    if(col>99-hSize)
    	col=100-hSize;
    var res=row+","+col;	
    window.location="../transfer.php?coord="+res;
}
function getCursorPosition(canvas , event) {
  	var rect = canvas.getBoundingClientRect();
    var x = event.clientX - rect.left;
    var y = event.clientY - rect.top;
    var res=x+","+y;
    return({x:x,y:y});
 }
 function fill(row,col,slotSize)
 {
 	//console.log("fill  "+row+","+col);
 	cx=(slotSize)*col;
	cy=(slotSize)*row;
 	ctx.fillRect(cx,cy,slotSize,slotSize); 
 	//console.log(ctx.strokeStyle);
	ctx.strokeRect(cx,cy,slotSize,slotSize);
 }
function occupy(style,row,col,quant)
{
	var tempCol=col;
	ctx.fillStyle=style;
	var i,j;
	for(j=0;j<quant && row<100;row++,j++)
	{
		for(i=0,col=tempCol;i<quant && col<100;col++,i++)
		{
			//console.log("fill "+row+","+col);
			fill(row,col,slotSize);
		}
	}
	//console.log(i*j);
}
var row=0,col=0;
function highlight(event)
{
	//console.log("highlight");
	var coords=getCursorPosition(canvas,event);
	var x=coords.x;
	var y=coords.y;
	x=x-(hSize/2*slotSize);
	if(x<0)
		x=0;
	y=y-(hSize/2*slotSize);
	if(y<0)
		y=0;
	if(row!=Math.floor(y/slotSize) || col!=Math.floor(x/slotSize))
	{
		var inp=row+","+col;
		highlighted.push(inp);
		clearc();					
		row=Math.floor(y/slotSize);                 //to truncate to int since all number are float by default
		col=Math.floor(x/slotSize);
		if(row>99-hSize)
			row=100-hSize;
		if(col>99-hSize)
			col=100-hSize;
		document.getElementById("info").innerHTML=x+","+y+"        "+row+","+col;
		occupy("rgba(128,128,128,0.3)",row,col,hSize);                  // highlighting color

	}
}
function clearc()
{
	//console.log("clear");
	while(highlighted.length>0)
	{
		var cod=highlighted.pop();
		var c=cod.split(",");
		var row=parseInt(c[0],10);
		var col=parseInt(c[1],10);
		var tempCol=col;
		for(var i=0;i<hSize && row<100;row++,i++)
		{
			for(var j=0,col=tempCol;j<hSize && col<100;col++,j++)
			{
				/*cx=col*slotSize;
				cy=row*slotSize;
				ctx.fillStyle=grid[row][col];
				ctx.strokeRect(cx,cy,slotSize,slotSize);
				ctx.fillRect(cx,cy,slotSize,slotSize);*/
				occupy(grid[row][col],row,col,1);
			}
		}
	}
}
