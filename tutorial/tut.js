var grid=[];
var canvas;
var	ctx;
var slotSize=50;
var playArea=9;
function assignGrid()
{
	console.log(playArea);
	for(var i=0;i<playArea;i++)
	{
		for(var j=0;j<playArea;j++)
		{
			if((i==3 && j==2) || (i==4 && j==2) || (i==3 && j==3))
			{
				grid[i][j]="yellow";
			}
			else if((i==2 && j==6) || (i==3 && j==7) || (i==3 && j==8))
			{
				grid[i][j]="red";
			}
			else if( i==5 && j==3)
			{
				grid[i][j]="blue";
			}
			else
			{
				grid[i][j]="white";
			}
		}
	}
}
function renderGrid()
{
	for(var i=0,y=0;i<playArea;i++,y+=slotSize)
	{
		for(var j=0,x=0;j<playArea;j++,x+=slotSize)
		{
			ctx.fillStyle=grid[i][j];
			console.log(grid[i][j]);
			console.log(ctx.fillStyle+",,fill:"+x+","+y);
			ctx.strokeRect(x,y,slotSize,slotSize);
			ctx.fillRect(x,y,slotSize,slotSize);
		}
	}
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
}
function getCursorPosition(canvas , event) {
  	var rect = canvas.getBoundingClientRect();
    var x = event.clientX - rect.left;
    var y = event.clientY - rect.top;
    var res=x+","+y;
    var row=Math.floor(y/slotSize);
    var col=Math.floor(x/slotSize);
    var rc=row+","+col;
    document.getElementById("bottom_hint").innerHTML=rc;
    return({x:x,y:y});
 }
window.onload=function renderLocal()
{
	canvas=document.getElementById("canvas");
	ctx = canvas.getContext("2d");
	for(var i=0;i<9;i++)
	{
		grid[i]=[];
	}
	assignGrid();
	console.log(grid);
	renderGrid();
	canvas.setAttribute("onmousemove","getCursorPosition(canvas,event)");
	canvas.setAttribute("onclick","getActions(canvas,event)");
}