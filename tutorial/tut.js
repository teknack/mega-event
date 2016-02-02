var grid=[];
var canvas;
var	ctx;
var slotSize=50;
var playArea=9;
var selectedTroops=0;
var food=1000;
var water=1000;
var wood=1000;
var metal=1000;
var power=750;
function assignGrid()
{
	for(var i=0;i<playArea;i++)
	{
		for(var j=0;j<playArea;j++)
		{
			if((i==3 && j==2) || (i==4 && j==2) || (i==3 && j==3))
			{
				grid[i][j]['color']="yellow";
				grid[i][j]['troops']=2;
				grid[i][j]['fortification']=1;
			}
			else if((i==2 && j==6) || (i==3 && j==7) || (i==3 && j==8))
			{
				grid[i][j]['color']="red";
				grid[i][j]['troops']=2;
				grid[i][j]['fortification']=1;
			}
			else if( i==5 && j==3)
			{
				grid[i][j]['color']="blue";
				grid[i][j]['troops']=2;
				grid[i][j]['fortification']=1;
			}
			else
			{
				grid[i][j]['color']="white";
				grid[i][j]['troops']=0;
				grid[i][j]['fortification']=0;
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
			ctx.fillStyle=grid[i][j]['color'];
			ctx.strokeRect(x,y,slotSize,slotSize);
			ctx.fillRect(x,y,slotSize,slotSize);
		}
	}
}
function getCursorPosition(canvas , event) {
  	var rect = canvas.getBoundingClientRect();
    var x = event.clientX - rect.left;
    var y = event.clientY - rect.top;
    var res=x+","+y;
    var row=Math.floor(y/slotSize);
    var col=Math.floor(x/slotSize);
    var rc=row+","+col;
    response(rc);
    return({x:x,y:y});
}
function getActions(event)
{
	var coord=getCursorPosition(canvas,event);
	var cx=coord.x;
	var cy=coord.y;
	var i=Math.floor(cy/slotSize);
	var j=Math.floor(cx/slotSize);
	document.getElementById("row").value=i;
	document.getElementById("col").value=j;
	options=document.getElementById("bottom_action");
	if(grid[i][j]['color']=="blue")
	{
		document.getElementById("ally").style.visibility="hidden";
		document.getElementById("sEnemy").style.visibility="hidden";
        document.getElementById("quantity").style.visibility="hidden";
		document.getElementById("enemy").style.visibility="hidden";
        document.getElementById("player").style.visibility="visible"; //player menu visible
        document.getElementById("quantity").style.visibility="visible";
	}
	else if(grid[i][j]['color']=="yellow")
	{
		document.getElementById("player").style.visibility="hidden";
        document.getElementById("quantity").style.visibility="hidden";
		document.getElementById("enemy").style.visibility="hidden";
		document.getElementById("sEnemy").style.visibility="hidden";
		document.getElementById("ally").style.visibility="visible"; //ally menu visible
	}	
	else if(grid[i][j]['color']=="red")
	{
		console.log(selectedTroops);
		if(selectedTroops==0)
		{
			document.getElementById("player").style.visibility="hidden";
	        document.getElementById("quantity").style.visibility="hidden";
			document.getElementById("enemy").style.visibility="visible"; //enemy menu visible
			document.getElementById("sEnemy").style.visibility="hidden";
			document.getElementById("ally").style.visibility="hidden";
		}
		else
		{
			document.getElementById("player").style.visibility="hidden";
	        document.getElementById("quantity").style.visibility="hidden";
			document.getElementById("enemy").style.visibility="hidden";
			document.getElementById("sEnemy").style.visibility="visible";
			document.getElementById("ally").style.visibility="hidden"; //enemy with selected troops menu visible
		}
	}
	else
	{
		document.getElementById("player").style.visibility="hidden";
        document.getElementById("quantity").style.visibility="hidden";
		document.getElementById("enemy").style.visibility="visible";
		document.getElementById("sEnemy").style.visibility="hidden";
		document.getElementById("ally").style.visibility="hidden";
	}
}

function selectTroops(max) //pass max as 0 to remove select troops constraint
{
	document.getElementById("player").style.visibility="hidden";
    document.getElementById("quantity").style.visibility="hidden";
	var quantity=document.getElementById("quantity").value;
	var row=document.getElementById("row").value;
	var col=document.getElementById("col").value;
	if(quantity==null)
		quantity=1;
	if(quantity>grid[row][col]['troops'])
	{
		response("you don't have those many troops");
	}
	else if(quantity!=max && max!=0)
	{
		response("you are supposed to select"+max+"soldier(s) please comply");
		alert("you are supposed to select only ");	
	}
	else
	{
		selectedTroops=quantity;
		response("selected "+selectedTroops+" troops");
	}
}

function scout()
{
	document.getElementById("player").style.visibility="hidden";
    document.getElementById("quantity").style.visibility="hidden";
	document.getElementById("enemy").style.visibility="hidden";
	document.getElementById("sEnemy").style.visibility="hidden";
	document.getElementById("ally").style.visibility="hidden";
    var row=document.getElementById("row").value;
	var col=document.getElementById("col").value;
	var output;
	if(grid[i][j]['color']==blue)
	{
		output="Occupant:player<br>troops:"+grid[i][j]['troops']+"fortification:"+grid[i][j]['fortification'];
	}
	else if(grid[i][j]['color']==yellow)
	{
		output="Occupant:ally<br>troops:"+grid[i][j]['troops']+"fortification:"+grid[i][j]['fortification'];
	}
	else if(grid[i][j]['color']==red)
	{
		output="Occupant:enemy<br>troops:"+grid[i][j]['troops']+"fortification:"+grid[i][j]['fortification'];
	}
	else
	{
		output="Occupant:enemy<br>troops:"+grid[i][j]['troops']+"fortification:"+grid[i][j]['fortification'];	
	}
}

function response(message)
{
	document.getElementById("bottom_hint").innerHTML=message;
}

function createTroops(max)
{
	document.getElementById("player").style.visibility="hidden";
    document.getElementById("quantity").style.visibility="hidden";
	document.getElementById("enemy").style.visibility="hidden";
	document.getElementById("sEnemy").style.visibility="hidden";
	document.getElementById("ally").style.visibility="hidden";
	var quantity=document.getElementById("quantity").value;
	var row=document.getElementById("row").value;
	var col=document.getElementById("col").value;
	if(quantity==null)
		quantity=1;
	if(quantity>max && max!=0 && max!=null)
	{
		response("you are supposed to select"+max+"soldier(s) please comply");
		alert("you are supposed to create only "+max+" troops");	
	}
	else
	{
		grid[row][col]['troops']+=quantity;
		response("created "+quantity+" troops");
	}	
}

function fortify()
{
	document.getElementById("player").style.visibility="hidden";
    document.getElementById("quantity").style.visibility="hidden";
	document.getElementById("enemy").style.visibility="hidden";
	document.getElementById("sEnemy").style.visibility="hidden";
	document.getElementById("ally").style.visibility="hidden";
	var row=document.getElementById("row").value;
	var col=document.getElementById("col").value;
	if(grid[row][col]['fortification']<8)
	{
		grid[row][col]['fortification']+=1;	
	}
	else
	{
		response("you have already have maximum fortification");
	}
}

function queryResource(resource,value)
{
	if(resource=="food")
	{
		if(food>value)
			return true;
		else
			return false;
	}
	if(resource=="water")
	{
		if(water>value)
			return true;
		else
			return false;
	}
	if(resource=="wood")
	{
		if(wood>value)
			return true;
		else
			return false;
	}
	if(resource=="metal")
	{
		if(metal>value)
			return true;
		else
			return false;
	}
	if(resource=="power")
	{
		if(power>value)
			return true;
		else
			return false;
	}
}

function deductResource(resource,value)
{
	if(resource=="food")
	{
		if(food>value)
			food-=value;
	}
	if(resource=="water")
	{
		if(water>value)
			water-=value;
	}
	if(resource=="wood")
	{
		if(wood>value)
			wood-=value;
	}
	if(resource=="metal")
	{
		if(metal>value)
			metal-=value;
	}
	if(resource=="power")
	{
		if(power>value)
			power-=value;
	}
}

window.onload=function renderLocal()
{
	canvas=document.getElementById("canvas");
	ctx = canvas.getContext("2d");
	document.getElementById("food").innerHTML+=food;
	document.getElementById("water").innerHTML+=water;
	document.getElementById("wood").innerHTML+=wood;
	document.getElementById("metal").innerHTML+=metal;
	document.getElementById("power").innerHTML+=power;
	for(var i=0;i<9;i++)
	{
		grid[i]=[];
	}
	for(var i=0;i<9;i++)
	{
		for(var j=0;j<9;j++)
		{
			grid[i][j]=[];
		}
	}
	assignGrid();
	renderGrid();
	canvas.setAttribute("onmousemove","getCursorPosition(canvas,event)");
	canvas.setAttribute("onclick","getActions(event)");
	document.getElementById("sTroops").setAttribute("onclick","selectTroops()");
	document.getElementById("cTroops").setAttribute("onclick","createTroops()");
	document.getElementById("scout").setAttribute("onclick","scout()");
	document.getElementById("attack").setAttribute("onclick","attack()");
	document.getElementById("fortify").setAttribute("onclick","fortify()");
}