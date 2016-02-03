var grid=[];
var canvas;
var	ctx;
var slotSize=50;
var playArea=9;
var selectedTroops=0;
var selectedRow;
var selectedCol;
var food=1000;
var water=1000;
var wood=1000;
var metal=1000;
var power=750;
var max=0;
var moveCostFood=12;
var moveCostWater=16;
var moveCostPower=6;
var scoutCostFood=8;
var scoutCostWater=12;
var settleWoodCost=40;
var settleMetalCost=60;
var settlePowerCost=35;
var fortifyWoodCost=[40,70,100,130,160,190,200];
var fortifyMetalCost=[60,100,140,180,220,260,300];
var fortifyPowerCost=[35,70,90,110,140,160,180,200];
var createTroopCostFoodBase=10;
var createTroopCostWaterBase=13;
var createTroopCostPowerBase=4;
function assignGrid()
{
	for(var i=0;i<playArea;i++)
	{
		for(var j=0;j<playArea;j++)
		{
			if((i==3 && j==2) || (i==4 && j==2) || (i==3 && j==3))
			{
				grid[i][j]['color']="yellow";
				grid[i][j]['troops']=parseInt(2,10);
				grid[i][j]['fortification']=1;
			}
			else if((i==2 && j==6) || (i==3 && j==7) || (i==3 && j==8))
			{
				grid[i][j]['color']="red";
				grid[i][j]['troops']=parseInt(2,10);
				grid[i][j]['fortification']=1;
			}
			else if( i==5 && j==3)
			{
				grid[i][j]['color']="blue";
				grid[i][j]['troops']=parseInt(2,10);
				grid[i][j]['fortification']=1;
			}
			else
			{
				grid[i][j]['color']="white";
				grid[i][j]['troops']=parseInt(2,10);
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
    response("rc",rc);
    return({x:x,y:y});
}

function show(actionmenu,quantityTB)
{
		var menu=[];
		menu['allyMenu']=document.getElementById("ally");
		menu['allyMenuS']=document.getElementById("sally");
		menu['enemyMenuS']=document.getElementById("sEnemy");
        menu['quantityTextBox']=document.getElementById("quantity");
		menu['enemyMenu']=document.getElementById("enemy");
        menu['playerMenu']=document.getElementById("player");
        menu['playerMenuS']=document.getElementById("splayer");
        menu['neutralMenuS']=document.getElementById("sneutral");
        menu['neutralMenu']=document.getElementById("neutral");
        for(var i in menu)
        {
        	if(i==actionmenu)
        	{
        		menu[i].style.visibility="visible";
        	}
        	else
        	{
        		menu[i].style.visibility="hidden";
        	}
        }
        if(quantityTB)
        	menu['quantityTextBox'].style.visibility="visible";
}

function hideAll()
{
		var menu=[];
		menu['allyMenu']=document.getElementById("ally");
		menu['allyMenuS']=document.getElementById("sally");
		menu['enemyMenuS']=document.getElementById("sEnemy");
        menu['quantityTextBox']=document.getElementById("quantity");
		menu['enemyMenu']=document.getElementById("enemy");
        menu['playerMenu']=document.getElementById("player");
        menu['playerMenuS']=document.getElementById("splayer");
        menu['neutralMenuS']=document.getElementById("sneutral");
        menu['neutralMenu']=document.getElementById("neutral");
        for(var i in menu)
        {
        	menu[i].style.visibility="hidden";
        }
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
		scout();
		if(selectedTroops==0)
		{
			show("playerMenu",true);
		}
		else
		{
			show("playerMenuS",false);
		}
	}
	else if(grid[i][j]['color']=="yellow")
	{
		if(selectedTroops==0)
		{
			show("allyMenu",false);
		}
		else
		{
			show("allyMenuS",false);
		}
	}	
	else if(grid[i][j]['color']=="red")
	{
		console.log(selectedTroops);
		if(selectedTroops==0)
		{
			show("enemyMenu",false);
		}
		else
		{
			show("enemyMenuS",false);
		}
	}
	else
	{
		if(selectedTroops==0)
		{
			show("neutralMenu",false);
		}
		else
		{
			show("neutralMenuS",false);
		}
	}
}

function selectTroops() //pass max as 0 to remove select troops constraint
{
	hideAll();
	var row=document.getElementById("row").value;
	var col=document.getElementById("col").value;
	var quantity=document.getElementById("quantity").value;
	if(quantity==null)
		quantity=1;
	if(grid[row][col]['color']=="blue")
	{
		if(quantity>grid[row][col]['troops'])
		{
			response("bottom_hint","you don't have those many troops");
		}
		else if(quantity!=max && max!=0)
		{
			response("bottom_hint","you are supposed to select"+max+"soldier(s) please comply");
			alert("you are supposed to select only ");	
		}
		else
		{
			selectedTroops=quantity;
			selectedRow=row;
			selectedCol=col;
			response("bottom_hint","selected "+selectedTroops+" troops");
		}
	}
	else if(grid[row][col]['color']=="yellow")
	{
		if(quantity>grid[row][col]['troops']+2)
		{
			response("bottom_hint","you don't have those many troops stationed here");
		}
		else if(quantity!=max && max!=0)
		{
			response("bottom_hint","you are supposed to select"+max+"soldier(s) please comply");
			alert("you are supposed to select only ");	
		}
		else
		{
			selectedTroops=quantity;
			selectedRow=row;
			selectedCol=col;
			response("bottom_hint","selected "+selectedTroops+" troops");
		}	
	}
}

function scout()
{
	hideAll();
    var i=document.getElementById("row").value;
	var j=document.getElementById("col").value;
	var output;
	if(grid[i][j]['color']=="blue")
	{
		output="Occupant:player<br>troops:"+grid[i][j]['troops']+"<br>fortification:"+grid[i][j]['fortification'];
	}
	else if(grid[i][j]['color']=="yellow")
	{
		output="Occupant:ally<br>troops:"+grid[i][j]['troops']+"<br>fortification:"+grid[i][j]['fortification'];
	}
	else if(grid[i][j]['color']=="red")
	{
		output="Occupant:enemy<br>troops:"+grid[i][j]['troops']+"<br>fortification:"+grid[i][j]['fortification'];
	}
	else
	{
		output="Occupant:enemy<br>troops:"+grid[i][j]['troops']+"<br>fortification:"+grid[i][j]['fortification'];	
	}
	response("bottom_hint",output);
}

function response(id,message)
{
	document.getElementById(id).innerHTML=message;
}

function createTroops()
{
	hideAll();
	var quantity=document.getElementById("quantity").value;
	var row=document.getElementById("row").value;
	var col=document.getElementById("col").value;
	if(quantity==null)
		quantity=1;
	if(quantity>max && max!=0 && max!=null)
	{
		response("prompt","you are supposed to select"+max+"soldier(s) please comply");
		alert("you are supposed to create only "+max+" troops");	
	}
	else
	{
		grid[row][col]['troops']+=quantity;
		response("bottom_hint","created "+quantity+" troops");
	}	
}

function fortify()
{
	hideAll();
	var row=document.getElementById("row").value;
	var col=document.getElementById("col").value;
	if(grid[row][col]['fortification']<8)
	{
		grid[row][col]['fortification']+=1;	
	}
	else
	{
		response("bottom_hint","you already have maximum fortification");
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

function attack()
{
	hideAll();
}

function move()
{
	hideAll();
	var destRow=document.getElementById("row").value;
	var destCol=document.getElementById("col").value;
	var srcRow=selectedRow;
	var srcCol=selectedCol;
	selectedRow=null;
	selectedCol=null;
	var distance=Math.max(Math.abs(destRow-srcRow),Math.abs(destCol-srcCol));
	if(grid[destRow][destCol]['color']=="blue" || grid[destRow][destCol]['color']=="yellow")
		distance/=2;
	var foodCost=moveCostFood*distance;
	var waterCost=moveCostWater*distance;
	var powerCost=moveCostPower*distance;
	/*query resources*/
	if(queryResource("food",foodCost) && queryResource("water",waterCost) && queryResource("power",powerCost))
	{
		deductResource("food",foodCost);
		deductResource("water",waterCost);
		deductResource("power",powerCost);
	}
	else
	{
		response("bottom_hint","not enough resources");
	}
	/*deduct resources*/
	selectedTroops=parseInt(selectedTroops,10);
	grid[srcRow][srcCol]['troops']-=selectedTroops;
	grid[destRow][destCol]['troops']+=selectedTroops;
	console.log(typeof(grid[destRow][destCol]['troops']));
	response("bottom_hint","moved "+selectedTroops+" by "+distance+" blocks");
	selectedTroops=0;
}

window.onload=function renderLocal()
{
	hideAll();
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
	document.getElementById("scout1").setAttribute("onclick","scout()");
	document.getElementById("scout2").setAttribute("onclick","scout()");
	document.getElementById("scout3").setAttribute("onclick","scout()");
	document.getElementById("scout4").setAttribute("onclick","scout()");
	document.getElementById("scout5").setAttribute("onclick","scout()");
	document.getElementById("attack").setAttribute("onclick","attack()");
	document.getElementById("fortify").setAttribute("onclick","fortify()");
	document.getElementById("move").setAttribute("onclick","move()");
	document.getElementById("move1").setAttribute("onclick","move()");
	document.getElementById("move2").setAttribute("onclick","move()");
	//alert("all set");
}