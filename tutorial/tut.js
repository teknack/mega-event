var grid=[];
var canvas;
var	ctx;
var slotSize=50;
var playArea=9;
var selectedTroops=0;
var selectedRow;
var selectedCol;
var food=1000;
var foodr=0;
var water=1000;
var waterr=0;
var wood=1000;
var woodr=0;
var metal=1000;
var metalr=0;
var power=750;
var powerr=0;
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
var playerFort;
var allyFort;
var enemyFort;
var fortSet=1;
var playerSprite;
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
				grid[i][j]['troops']=parseInt(0,10);
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
			if(grid[i][j]['color']=="red")
				ctx.drawImage(enemyFort,x,y,slotSize,slotSize);
			if(grid[i][j]['color']=="blue")
				ctx.drawImage(playerFort,x,y,slotSize,slotSize);
			if(grid[i][j]['color']=="yellow")
				ctx.drawImage(allyFort,x,y,slotSize,slotSize);
			if(grid[i][j]['color']=="cyan")
				ctx.drawImage(playerSprite,x,y,slotSize,slotSize);
			ctx.strokeRect(x,y,slotSize,slotSize);
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

function updateResources()
{
	document.getElementById("food").innerHTML="food:"+food+"/"+foodr;
	document.getElementById("water").innerHTML="water"+water+"/"+waterr;
	document.getElementById("wood").innerHTML="wood"+wood+"/"+woodr;
	document.getElementById("metal").innerHTML="metal"+metal+"/"+metalr;
	document.getElementById("power").innerHTML="power"+power+"/"+powerr;
}

function show(actionmenu,quantityTB,type)
{
		var menu=[];
		if(type="leftClick")
		{
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
		}
		else if(type="rightClick")
		{
			menu['allyMenu']=document.getElementById("ally1");
			menu['allyMenuS']=document.getElementById("sally1");
			menu['enemyMenuS']=document.getElementById("sEnemy1");
	        menu['quantityTextBox']=document.getElementById("quantity1");
			menu['enemyMenu']=document.getElementById("enemy1");
	        menu['playerMenu']=document.getElementById("player1");
	        menu['playerMenuS']=document.getElementById("splayer1");
	        menu['neutralMenuS']=document.getElementById("sneutral1");
	        menu['neutralMenu']=document.getElementById("neutral1");
		}
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

function actions(event)
{
	var coord=getCursorPosition(canvas,event);
	var cx=coord.x;
	var cy=coord.y;
	var i=Math.floor(cy/slotSize);
	var j=Math.floor(cx/slotSize);
	document.getElementById("row").value=i;
	document.getElementById("col").value=j;
	//HideMenu("ctxMenu");
	options=document.getElementById("bottom_action");
	if(grid[i][j]['color']=="blue")
	{
		scout();
		if(selectedTroops==0)
		{
			show("playerMenu",true,"leftClick");
		}
		else
		{
			show("playerMenuS",false,"leftClick");
		}
	}
	else if(grid[i][j]['color']=="yellow")
	{
		if(selectedTroops==0)
		{
			show("allyMenu",true,"leftClick");
		}
		else
		{
			show("allyMenuS",false,"leftClick");
		}
	}	
	else if(grid[i][j]['color']=="red")
	{
		//console.log(selectedTroops);
		if(selectedTroops==0)
		{
			show("enemyMenu",false,"leftClick");
		}
		else
		{
			show("enemyMenuS",false,"leftClick");
		}
	}
	else
	{
		if(grid[i][j]['troops']>0)
			scout();
		if(selectedTroops==0)
		{
			show("neutralMenu",true,"leftClick");
		}
		else
		{
			show("neutralMenuS",false,"leftClick");
		}
	}
}

function HideMenu(control) 
{ 
    document.getElementById(control).style.display = 'none'; 
}

function ShowMenu(e) 
{
    contextActions(canvas,e);
    var posx = e.clientX +window.pageXOffset +'px'; //Left Position of Mouse Pointer
    var posy = e.clientY + window.pageYOffset + 'px'; //Top Position of Mouse Pointer
    document.getElementById('ctxMenu').style.position = 'absolute';
    document.getElementById('ctxMenu').style.display = 'inline';
    document.getElementById('ctxMenu').style.left = posx;
    document.getElementById('ctxMenu').style.top = posy;           
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
			document.getElementById("action").value="selectTroops";
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
    if(queryResource("food",scoutCostFood) && queryResource("water",scoutCostWater))
	{
		deductResource("food",scoutCostFood);
		deductResource("water",scoutCostWater);
		updateResources();
	}
	updateResources();
	document.getElementById("action").value="scout";
    var i=document.getElementById("row").value;
	var j=document.getElementById("col").value;
	var output;
	var srcRow=selectedRow;
	var srcCol=selectedCol;
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
		if(selectedRow!=null && selectedCol!=null && selectedTroops>0)
		{
			output=output+"<br>Win chance : "+simBattle(i,j)+"%";
		}
	}
	else
	{
		output="Occupant:unoccupied<br>troops:"+grid[i][j]['troops']+"<br>fortification:"+grid[i][j]['fortification'];	
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
	foodCost=quantity*createTroopCostFoodBase;
	waterCost=quantity*createTroopCostWaterBase;
	powerCost=quantity*createTroopCostPowerBase;
	if(queryResource("food",foodCost) && queryResource("water",waterCost) && queryResource("power",powerCost))
	{
		deductResource("food",foodCost);
		deductResource("water",waterCost);
		deductResource("power",powerCost);
		updateResources();
	}
	if(quantity>max && max!=0 && max!=null)
	{
		response("prompt","you are supposed to select"+max+"soldier(s) please comply");
		alert("you are supposed to create only "+max+" troops");	
	}
	else
	{
		quantity=parseInt(quantity,10);
		grid[row][col]['troops']+=quantity;
		document.getElementById("action").value="createTroops";
		response("bottom_hint","created "+quantity+" troops");
	}	
}

function fortify()
{
	hideAll();
	document.getElementById("action").value="fortify";
	var row=document.getElementById("row").value;
	var col=document.getElementById("col").value;
	var lvl=grid[row][col]['fortification'];
	var woodCost=fortifyWoodCost[lvl-1];
	var metalCost=fortifyMetalCost[lvl-1];
	var powerCost=fortifyPowerCost[lvl-1];
	if(queryResource("wood",woodCost) && queryResource("metal",metalCost) && queryResource("power",powerCost))
	{
		deductResource("wood",woodCost);
		deductResource("metal",metalCost);
		deductResource("power",powerCost);
		updateResources();
	}
	if(grid[row][col]['fortification']<8)
	{
		grid[row][col]['fortification']+=1;	
	}
	else
	{
		response("bottom_hint","you already have maximum fortification");
	}
}

function settle()
{
	var row=document.getElementById("row").value;
	var col=document.getElementById("col").value;
	if(grid[row][col]['color']!="green")
	{
		return;
	}
	if(queryResource("wood",settleWoodCost) && queryResource("metal",settleMetalCost) && queryResource("power",settlePowerCost))
	{
		deductResource("wood",settleWoodCost);
		deductResource("metal",settleMetalCost);
		deductResource("power",settlePowerCost);
		updateResources();
	}
	grid[row][col]['color']="blue";
	renderGrid();
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

function start()
{
	/*pending*/
	window.location="../world-map/canvas1.html";
}

function attack()
{
	hideAll();
	document.getElementById("action").value="attack";
	var destRow=document.getElementById("row").value;
	var destCol=document.getElementById("col").value;
	var srcRow=selectedRow;
	var srcCol=selectedCol;
	var distance=Math.max(Math.abs(destRow-srcRow),Math.abs(destCol-srcCol));
	var foodCost=moveCostFood*distance;
	var waterCost=moveCostWater*distance;
	var powerCost=moveCostPower*distance;
	/*query resources*/
	if(queryResource("food",foodCost) && queryResource("water",waterCost) && queryResource("power",powerCost))
	{
		deductResource("food",foodCost);
		deductResource("water",waterCost);
		deductResource("power",powerCost);
		updateResources();
	}
	else
	{
		response("bottom_hint","not enough resources to move");
		return;
	}
	var winChance=simBattle(destRow,destCol);
	var num=Math.floor(Math.random()*100);
	var result=false;
	if(num>winChance)
		result=false;
	else
		result=true;
	if(result) //battle won
	{
		food+=50;
		water+=50;
		wood+=50;
		metal+=50
		power+=50;
		grid[srcRow][srcCol]['troops']-=selectedTroops;
		selectedTroops-=selectedTroops*winChance/100;
		grid[destRow][destCol]['troops']+=selectedTroops;
		grid[destRow][destCol]['color']="blue";
		response("bottom_hint","you won!");
	}
	else
	{
		grid[srcRow][srcCol]['troops']-=selectedTroops;
		response("bottom_hint","you lost!");
	}
	selectedRow=null;
	selectedCol=null;
	selectedTroops=0;
}


function simBattle(row,col)
{
	var destRow=row;
	var destCol=col;
	var srcRow=selectedRow;
	var srcCol=selectedCol;
	var troopProbability=3;
	var defTroopProbability=0.5;
	troops=parseInt(selectedTroops,10);
	troops/=grid[destRow][destCol]['fortification'];
	var attackProb=troops*troopProbability;
	var defProb=grid[destRow][destCol]['troops']*defTroopProbability;
	var winChance=attackProb-defProb;
	//console.log(attackProb+"   "+defProb);
	if(winChance>100)
		winChance=100;
	return winChance;
}

function move()
{
	hideAll();
	document.getElementById("action").value="move";
	var destRow=document.getElementById("row").value;
	var destCol=document.getElementById("col").value;
	var srcRow=selectedRow;
	var srcCol=selectedCol;
	selectedRow=null;
	selectedCol=null;
	if(srcCol==destCol && srcRow==destRow)
	{
		selectedTroops=0;
		response("bottom_hint","cannot move troops to the same tile.Move cancelled");
		return;
	}
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
		response("bottom_hint","not enough resources to move");
		return;
	}
	/*deduct resources*/
	selectedTroops=parseInt(selectedTroops,10);
	grid[srcRow][srcCol]['troops']-=selectedTroops;
	grid[destRow][destCol]['troops']+=selectedTroops;
	if(grid[destRow][destCol]['color']=="white")
		grid[destRow][destCol]['color']="cyan";
	renderGrid();
	//console.log(typeof(grid[destRow][destCol]['troops']));
	response("bottom_hint","moved "+selectedTroops+" by "+distance+" blocks<br>Cost<br>food:"+foodCost+"<br>water:"+waterCost+"<br>power:"+powerCost);
	selectedTroops=0;
}

function introduce()
{
	var prompt="           INTRODUCTION             <br>"+
		  "All the tiles you see is the area you are gonna play on<br>"+ 
		  "-your objective is to occupy as many of these tiles as possible<br>"+ 
		  "-blue forts are the tiles on which you have settled, you will start "+ 
		   "your game with one tile occupied<br>"+ 
		  "-yellow forts belong to your allies,they are the ones who belong"+ 
		   "to the same faction as you do <br>"+ 
		  "-red forts belong to all the players who are in the other faction"+ 
		   "your enemies<br>"+
		  "-the empty tiles are unoccupied and you can send your troops to occupy them<br>"+
		  "-You will get to choose your faction once you actually start the game<br>"+ 
		   "but for now you could fiddle with the game to learn it or u could"+
		   "select the tutorial options on the right to let the game teach you<br>"+
		  "-YOUR OBJECTIVE IS TO GET AS MANY BLUE TILES/FORTS AS POSSIBLE"; 
		  "- YOU HAVEN'T STARTED THE GAME YET<br>"+
		  "- HAVE FUN"
	response("prompt",prompt);
}

function basics()
{
	var prompt="                        BASICS                     <br>"+
			   "At the top left are the resources you need to play the game<br>"+
			   "They look like   '1000/0'  so the number on the left of '/' is the<bR>"+
			   "amount of a resource you have while the number on the right is <br>"+
			   "regeneration rate of those resources per minute<br>"+
			   "To get the actions that you can perform on each tile use either left or right<br>"+
			   "click based on your comfort(right click)"
			   "At the bottom right are the local map navigation buttons which you<br>"+
			   " could use to shift the local map to right,left,up or down by one <br>"+
			   " column/row(this feature is not available in the tutorial)<br>"+
			   " the four directional buttons and the button in the middle are navigation button<br>"+
			   " they are useless in this tutorial.But in the main game you can navigate through the map<br>"+
			   " or u can go back to world map<br>";
	response("prompt",prompt);
}

function tileTypes()
{
	var prompt="                        TILE TYPES                     <br>"+
			   "The map you see below the tiles is not just for looks, it has a purpose<br>"+
			   "-the tiles below <br>"+
			   "-green areas give bonus FOOD and WATER(+1 food/min and +1 water/min)<br>"+
			   "-sandy areas areas give bonus POWER(+1 power/min and -1 water/min)<br>"+
			   "-water areas cannot be settled on but,are resource rich so you can loot<bR>"+
			   " them as many times as you want but it will be hard<br>"+
			   "-mountain areas can be settled on but you need certain amount of tech for that to happen(+2 metal/min and +2 water/min)<br>"+
			   "-brown colored muddy areas give bonus FOOD(+2 food/min)";
	response("prompt",prompt);	
}

function scouting()
{
	var prompt="     SCOUTING      <br>"+
			   "-scouting allows you to find out who is occupying a tile and more importantly"+
			   " the number of troops stationed in them<br>"+
			   "-you get all details of tiles occupied by you or unoccupied tiles on which"+
			   " you have stationed your troops<br>"+
			   "-click any tile not occupied by you and not having any of your troops,"+
			   " then click the scout option<br>"+
			   "-It lets you check out how many troops (if any) are stationed in a tile<br>"+
			   " and who's occupying it as well as their faction and also the type of tile"+
			   "**IF YOU CAN'T GET SCOUT OPTION YOU MIGHT BE DOING SOMETHING WRONG <br>**";
	response("prompt",prompt);
}

function selMove()
{
	
	var prompt="          SELECTING TROOPS and MOVING               <br>"+
			   "-To move or attack using your troops you have to first select them<br>"+
			   "-to select troops first click on a tile which has your troops stationed"+
			   " in it<br>"+
			   "-Enter the number of troops you want to select in the textbox in bottom left<br>"+
			   "-Then click on any tile except the tile you selected your troops from to get move option<br>"+
			   "-select one soldier in tile (5,3)<br>"+
		       "-Then click on tile (3,4) and move your troops there<br>"+
			   "-Notice the resource cost below?Also the green tiles have your troops stationed<br>"+
		       "-Now move your troops from (5,3) to (3,3)<br>"+
		       "-look at the resource cost for moving the same distance<br>The distance was<br>"+
			   "halved because your troops moved within friendly tiles which are connected<br>"+
			   "now move your soldier(s) in (3,3) to (3,4) and then start settle and attack tutorial<br>"+
			   "MOVE COST IS BASED ON THE NUMBER OF TILES YOUR SOLDIERS MOVE, NOT THE NUMBER OF SOLDIERS<br>";
	response("prompt",prompt);
}

function selMove2()
{
	var prompt="         SELECTING TROOPS and MOVING-II(AMBUSH)               <br>"+
			   "Now you know how to move your troops,lets see how you could use it<br>"+
			   "You could move your soldiers to unoccupied tiles.These soldiers will attack any<br>"+
			   "enemy troops which move in to the tile your troops are stationed in.<br>"+
			   "so you could make an invisible barrier(of sorts) around your tiles so the enemy<bR>"+
			   "will have a tougher time settling around you.But keep in mind your troops will be visible to scouting<br>"+
			   " however you could perform relevant research to decrease the troops visible to scouting to upto 0!<br>"+
			   " So in such a case if you had 10 troops and if 5 are hidden ,the enemy sees 5 troops.<br>Also your 5 hidden troops<br>"+
			   "will be as effective as 10 soldiers(2x as effective)."
	response("prompt",prompt);
}

function settling()
{
	var prompt="     SETTLING       <br>"+
			   "-The most important part of the game,which is the first way to acquire more tiles<bR>"+
			   " I would be assuming at this point that you have moved atleast one of your soldiers<br>"+
			   " to an occupied (white)tile .If not then DO IT<br>"+
			   " Click on the cyan(light blue) colored tile then select settle<br>"+
			   " In the main game you will be redirected to resource allocation page wherein you are<br>"
			   " given 3 points to distribute among resource regenerations, this could be increased by research"
			   "-pros:<br>"+
			   " -you get more resource regen per slot occupied i.e you get minimum"+
			   "  3 points to distribute among any resource and ofcourse, the tile bonuses apply<br>"+
			   "  upon which your allocated 3 points will be added<br>"+
			   "-cons:<br>"+
			   " -if you lose your tile you will lose a portion of your resource(10% to be precise) to<br>"+ 
			   " the attacker as plunder which you can retaliate and take back without restrications.<br>"+
			   "<br><br><br>";//add a mini-game tutorial button
			   response("prompt",prompt);
}

function creatingTroops()
{
	var prompt=" CREATING TROOPS <br>"+
			   " All your troops ARE necessarily of one type, initially your troops are unspecialised<br>"+
			   " and WEAK.<br>"+
			   " you can specialise them to stealth or warrior who have their respective bonuses.<br>"+
			   " Once you select a specialisation you CAN switch specialisation , but specialisation<br>"+
			   " will cost you, For ex- if you have level 3 stealth and want to convert to warrior<bR>"+
			   " you cannot convert to warrior of level 4 the warrior you get is of level 3 which have to be<br>"+
			   " upgraded later based on discretion.";
	response("prompt",prompt);
}

function attacking()
{
	var prompt=" ATTACKING <br>"+
			   " Now select all troops in your newly settled tiles<br>"+
			   " click on an enemy(red) tile and click on scout option NOT ATTACK<br>"+
			   " You can see the probability of attack success at the bottom of the page<br>"+
			   " Clearly you don't have enough troops, so make atleast 20 troops and then try<br>"+
			   " to attack your enemy.<br>"+
			   " BTW you will be redirected to a minigame which you have to succeed in so that your attack is a<br>"+
			   " win.In the highly unlikely case of you not wanting to play the attack mini-game ,you could<br>"+
			   " sim the attack (which will be available in the main game) the result will be decided based on probability<br>"+
			   " and well a figurative throw of dice.<br>"+
			   " If you win you go through the same process of settling where you allocate regen points<br>"+
			   " IF you lose , you lose all your troops<br><bR>"+
			   "<button onclick='mini()'>GO TO MINI GAME</button>";
	response("prompt",prompt);	
}

function mini()
{
	window.location="../mini-game/attack/redirect.php";
}

function research()
{
	window.open("research.php");
}

function market()
{
	window.open("market.php");
}

function starting()
{
	var prompt="When you start the game you will have to choose between 2 factions, after that you will be<bR>"+
			   " redirected to the world-map , the world map has HUMANAGOUS number of tiles,that's the number of tiles<br>"+
			   "available for all players to conquer/capture, however you can only select your play area from the world-map<bR>"+
			   " in the world map: <br>"+
			   " -blue tiles-your tiles<br>"+
			   " -yellow tiles - ally tiles(allies belong to the same faction)<br>"+
			   " -red tiles - enemy tiles (players belonging to the other faction<br>"+
			   " -transparent tiles - unoccupied<br><br><br><br><br>"+
			   " <button onclick='start()'>Start the game</button>";
	response("prompt",prompt);
}

function start()
{
	window.location="../index.php";	
}

var everythingLoaded = setInterval(function() {
  if (/loaded|complete/.test(document.readyState)) {
    clearInterval(everythingLoaded);
    renderLocal(); // this is the function that gets called when everything is loaded
  }
}, 10);

function renderLocal()
{
	hideAll();
	canvas=document.getElementById("canvas");
	ctx = canvas.getContext("2d");
	canvas1=document.getElementById("mapCanvas");
	ctx1 = canvas1.getContext("2d");
	var map=new Image();
	map.src="../assets/map.png";
	ctx1.drawImage(map,0,0,450,450);
	playerFort=new Image();
    playerFort.src="../assets/"+fortSet+"b.png";
    enemyFort=new Image();
    enemyFort.src="../assets/"+fortSet+"r.png";
    allyFort=new Image();
    allyFort.src="../assets/"+fortSet+"y.png";
    playerSprite=new Image();
    playerSprite.src="../assets/blue.png"
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
	introduce();
	updateResources();
	canvas.setAttribute("onmousemove","getCursorPosition(canvas,event)");
	canvas.setAttribute("onclick","actions(event)");
	document.getElementById("sTroops").setAttribute("onclick","selectTroops()");
	document.getElementById("sTroops1").setAttribute("onclick","selectTroops()");
	document.getElementById("sTroops2").setAttribute("onclick","selectTroops()");
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
	document.getElementById("scouting").setAttribute("onclick","scouting()");
	document.getElementById("tileTypes").setAttribute("onclick","tileTypes()");	
	document.getElementById("selMove").setAttribute("onclick","selMove()");
	document.getElementById("selMove2").setAttribute("onclick","selMove2()");
	document.getElementById("settling").setAttribute("onclick","settling()");
	document.getElementById("creatingTroops").setAttribute("onclick","creatingTroops()");
	document.getElementById("attacking").setAttribute("onclick","attacking()");
	document.getElementById("market").setAttribute("onclick","market()");
	document.getElementById("research").setAttribute("onclick","research()");
	document.getElementById("basics").setAttribute("onclick","basics()");
	document.getElementById("starting").setAttribute("onclick","starting()");
}
