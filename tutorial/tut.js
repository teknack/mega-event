var grid=[];
var canvas;
var	ctx;
var slotSize=30;
var playArea=9;
function assignGrid()
{
	for(var i=0;i<playArea;i++)
	{
		for(var j=0;j>playArea;j++)
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
	for(var i=0,x=0;i<playArea;i++,x+=slotSize)
	{
		for(var j=0,y=0;j<playArea;j++,y+=slotSize)
		{
			ctx.fillStyle=grid[i][j];
			ctx.strokeRect(x,y,slotSize,slotSize);
			ctx.fillRect(x,y,slotSize,slotSize);
		}
	}
}
window.onload=function renderLocal()
{
	for(var i=0;i<9;i++)
	{
		grid[i]=[];
	}
	assignGrid();
	renderGrid();
}