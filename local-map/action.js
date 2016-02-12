var slotSize=60;
var wMapSlotSize=10;
var playArea=9;
var grid=[];
var fortSet=1;
for(var i=0;i<playArea;i++)
{
    grid[i]=[];
    for(var j=0;j<playArea;j++)
    {
        grid[i][j]="white";
    }
}
var playerId;
var faction;
var canvas, ctx;
var map;
var coord;
var playerSprite;
var allySprite;
var enemySprite;
var allyFort;
var playerFort;
var enemyFort;
/*orange-enemy troops color in grid 
  green-allied trooops color in grid*/
function response(id,message)
{
    document.getElementById(id).innerHTML=message;
}

function scoutCost()
{

    var xhttp;
    if (window.XMLHttpRequest) 
    {
    // code for modern browsers
    xhttp = new XMLHttpRequest();
    } else 
    {
    // code for IE6, IE5
    xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhttp.onreadystatechange = function() 
    {
        if (xhttp.readyState == 4 && xhttp.status == 200) 
        {
            document.getElementById("cost").innerHTML = xhttp.responseText;
        }
    };
  xhttp.open("GET", "actionCosts.php?action=scout", true);
  xhttp.send();
}

function moveCost()
{
    var xhttp;
    var destRow=document.getElementById("row").value;
    var destCol=document.getElementById("col").value;
    if (window.XMLHttpRequest) 
    {
    // code for modern browsers
    xhttp = new XMLHttpRequest();
    } else 
    {
    // code for IE6, IE5
    xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhttp.onreadystatechange = function() 
    {
        if (xhttp.readyState == 4 && xhttp.status == 200) 
        {
            document.getElementById("cost").innerHTML = xhttp.responseText;
        }
    };
  xhttp.open("GET", "actionCosts.php?action=move&row="+destRow+"&col="+destCol, true);
  xhttp.send();
}

function attackCost()
{
    var xhttp;
    var destRow=document.getElementById("row").value;
    var destCol=document.getElementById("col").value;
    if (window.XMLHttpRequest) 
    {
    // code for modern browsers
    xhttp = new XMLHttpRequest();
    } else 
    {
    // code for IE6, IE5
    xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhttp.onreadystatechange = function() 
    {
        if (xhttp.readyState == 4 && xhttp.status == 200) 
        {
            document.getElementById("cost").innerHTML = xhttp.responseText;
        }
    };
  xhttp.open("GET", "actionCosts.php?action=attack&row="+destRow+"&col="+destCol, true);
  xhttp.send();   
}

function create_troopsCost()
{
    var xhttp;
    var quantity=document.getElementById("quantity").value;
    if(quantity==0)
        quantity=1;
    if (window.XMLHttpRequest) 
    {
    // code for modern browsers
    xhttp = new XMLHttpRequest();
    } else 
    {
    // code for IE6, IE5
    xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhttp.onreadystatechange = function() 
    {
        if (xhttp.readyState == 4 && xhttp.status == 200) 
        {
            document.getElementById("cost").innerHTML = xhttp.responseText;
        }
    };
  xhttp.open("GET", "actionCosts.php?action=createTroops&quantity="+quantity, true);
  xhttp.send();
}

function settleCost()
{
    var xhttp;
    if (window.XMLHttpRequest) 
    {
    // code for modern browsers
    xhttp = new XMLHttpRequest();
    } else 
    {
    // code for IE6, IE5
    xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhttp.onreadystatechange = function() 
    {
        if (xhttp.readyState == 4 && xhttp.status == 200) 
        {
            document.getElementById("cost").innerHTML = xhttp.responseText;
        }
    };
  xhttp.open("GET", "actionCosts.php?action=settle", true);
  xhttp.send();
}

function fortifyCost()
{
    var xhttp;
    var row=document.getElementById("row").value;
    var col=document.getElementById("col").value;
    if (window.XMLHttpRequest) 
    {
    // code for modern browsers
    xhttp = new XMLHttpRequest();
    } else 
    {
    // code for IE6, IE5
    xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhttp.onreadystatechange = function() 
    {
        if (xhttp.readyState == 4 && xhttp.status == 200) 
        {
            document.getElementById("cost").innerHTML = xhttp.responseText;
        }
    };
  xhttp.open("GET", "actionCosts.php?action=fortify&row="+row+"&col="+col, true);
  xhttp.send();
}

function select_troopsCost()
{
    return false;
}

function getCursorPosition(canvas , event) 
{
    var rect = canvas.getBoundingClientRect();
    var x = event.clientX - rect.left;
    var y = event.clientY - rect.top;
    var res=x+","+y;
    var baseRow=parseInt(coord[0]);
    var baseCol=parseInt(coord[1]);
    var row=baseRow+Math.floor(y/slotSize);
    var col=baseCol+Math.floor(x/slotSize);
    var rc=row+","+col;
    response("rc",rc);
    return({x:x,y:y});
}

function action(canvas,event) //call it to get the available actions
{
  /*row=0;//make method to pass the row and column selected
  col=8;*/
    var rect = canvas.getBoundingClientRect();
    var x = event.clientX - rect.left;
    var y = event.clientY - rect.top;
    var baseRow=parseInt(coord[0],10);
    var baseCol=parseInt(coord[1],10);
    var row=baseRow+Math.floor(y/slotSize);
    var col=baseCol+Math.floor(x/slotSize);
    console.log(row+","+col);
    HideMenu('ctxMenu');//hides custom context menu
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
            var test=xhttp.responseText;
            console.log(test);
            comm=JSON.parse(test);
            var content="";
            var contextContent="";
            var hint="";
            for(var i=0;i<comm.length;i++)
            {
                if(comm[i]['response']!=null)
                {
                    hint=comm[i]['response'];
                }
                else if(comm[i]['action']!=null)
                {   
                    content+="<input type='submit' value="+comm[i]['action']+" name="+comm[i]['action']+" onmousemove="+comm[i]['action']+"Cost()><br>";
                }
                else
                    visibility=comm[i]['visible'];
            }
            //alert(visibility);
            if(visibility=="false")
            {
                var quant=document.getElementById("quantity");
                quant.style.visibility='hidden';
                var quant1=document.getElementById("quantity");
                quant1.style.visibility='hidden';
            }
            else
            {
                var quant=document.getElementById("quantity");
                quant.style.visibility='visible';
            }
            document.getElementById("action").innerHTML=content;
            document.getElementById("action1").innerHTML=contextContent;
            document.getElementById("bottom_hint").innerHTML=hint;
            document.getElementById("row").value=row;
            document.getElementById("col").value=col;
            document.getElementById("row1").value=row;
            document.getElementById("col1").value=col;
        }
    }
    xhttp.open("GET", "getActions.php?row="+row+"&col="+col, true);
    xhttp.send();
}

function contextAction(canvas,event) //call it to get the available actions from context menu (clone of action())...
{
  /*row=0;//make method to pass the row and column selected
  col=8;*/
    var rect = canvas.getBoundingClientRect();
    var x = event.clientX - rect.left;
    var y = event.clientY - rect.top;
    var baseRow=parseInt(coord[0],10);
    var baseCol=parseInt(coord[1],10);
    var row=baseRow+Math.floor(y/slotSize);
    var col=baseCol+Math.floor(x/slotSize);
    console.log(row+","+col);
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
            var test=xhttp.responseText;
            console.log(test);
            comm=JSON.parse(test);
            var content="";
            var contextContent="";
            var hint="";
            for(var i=0;i<comm.length;i++)
            {
                if(comm[i]['response']!=null)
                {
                    hint=comm[i]['response'];
                }
                else if(comm[i]['action']!=null)
                {   
                    contextContent+="<input type='submit' value="+comm[i]['action']+" name="+comm[i]['action']+" onmousemove="+comm[i]['action']+"Cost()><br>";
                }
                else
                    visibility=comm[i]['visible'];
            }
            //alert(visibility);
            if(visibility=="false")
            {
                var quant=document.getElementById("quantity");
                quant.style.visibility='hidden';
                var quant1=document.getElementById("quantity");
                quant1.style.visibility='hidden';
            }
            else
            {
                var quant1=document.getElementById("quantity1");
                quant1.style.visibility='visible';
            }
            document.getElementById("action").innerHTML=content;
            document.getElementById("action1").innerHTML=contextContent;
            document.getElementById("bottom_hint").innerHTML=hint;
            document.getElementById("row").value=row;
            document.getElementById("col").value=col;
            document.getElementById("row1").value=row;
            document.getElementById("col1").value=col;
        }
    }
    xhttp.open("GET", "getActions.php?row="+row+"&col="+col, true);
    xhttp.send();
}

function getGrid()
{
    var xhttp;
    var coordf=document.getElementById("topLeft").value;
    coord=coordf.split(",");
    var row=coord[0];
    var col=coord[1];
    var temp;
    if (window.XMLHttpRequest) 
    {
    // code for modern browsers
    xhttp = new XMLHttpRequest();
    } 
    else 
    {
    // code for IE6, IE5
    xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhttp.onreadystatechange = function() 
    {
        if (xhttp.readyState == 4 && xhttp.status == 200) 
        {
            console.log(xhttp.responseText);
            temp=JSON.parse(xhttp.responseText);
            playerId=temp[playArea*playArea]["player"];
            faction=temp[playArea*playArea]["faction"];
            food=temp[playArea*playArea]["food"]+"/"+temp[playArea*playArea]["foodr"];
            water=temp[playArea*playArea]["water"]+"/"+temp[playArea*playArea]["waterr"];
            power=temp[playArea*playArea]["power"]+"/"+temp[playArea*playArea]["powerr"];
            metal=temp[playArea*playArea]["metal"]+"/"+temp[playArea*playArea]["metalr"];
            wood=temp[playArea*playArea]["wood"]+"/"+temp[playArea*playArea]["woodr"];
            document.getElementById("food").innerHTML+=food;
            document.getElementById("water").innerHTML+=water;
            document.getElementById("power").innerHTML+=power;
            document.getElementById("metal").innerHTML+=metal;
            document.getElementById("wood").innerHTML+=wood;
            assignGrid(temp);
            renderGrid(grid);
        }
    };
  xhttp.open("GET", "getLocalMap.php?row="+row+"&col="+col, true);
  xhttp.send(); 
}

function assignGrid(jsonVar)
{
    for(var i=0,k=0;i<playArea;i++)
    {
        for(var j=0;j<playArea;j++,k++)
        {
            if(jsonVar[k]["occupied"]!=0)
            {
                if(jsonVar[k]["occupied"]==playerId) //slot of player
                {
                    grid[i][j]="blue";
                }
                else if(jsonVar[k]["faction"]==faction) //slot of ally
                {
                    grid[i][j]="yellow";
                }
                else
                {
                    grid[i][j]="red"; //slot of enemy
                }
            }
            else if(jsonVar[k]["troops"]>0)
                grid[i][j]="cyan";
            else
            {
                grid[i][j]="white";
            }   

        }
    }
    var row=parseInt(document.getElementById("scoutRow").value)-parseInt(coord[0]);
    var col=parseInt(document.getElementById("scoutCol").value)-parseInt(coord[1]);
    var side=document.getElementById("side").value;
    console.log("side-"+side);
    if(side=="enemy")
    {
        console.log(row+","+col);
        grid[row][col]="orange";
    }
    else if(side=="ally")
    {
        console.log("green!");
        grid[row][col]="green";
    }
    console.log(grid[row]);
    console.log(grid[row+1]);
}

function renderGrid()
{
    for(var i=0,y=0;i<playArea;i++,y+=slotSize)
    {
        for(var j=0,x=0;j<playArea;j++,x+=slotSize)
        {
            var value=grid[i][j];
            ctx.fillStyle =value;
            if(value=="white")
            {
                //don't fill any color
            }
            else if(value=="cyan")
            {
                console.log("cyan!");
                ctx.drawImage(playerSprite,x,y,slotSize,slotSize);
            }
            else if(value=="orange")
            {
                ctx.drawImage(enemySprite,x,y,slotSize,slotSize);
                console.log("orange!");
            }
            else if(value=="green")
            {
                console.log("green");
                ctx.drawImage(allySprite,x,y,slotSize,slotSize);
            }
            else if(value=="blue")
                ctx.drawImage(playerFort,x,y,slotSize,slotSize);   
            else if(value=="red")
                ctx.drawImage(enemyFort,x,y,slotSize,slotSize);
            else if(value=="yellow")
                ctx.drawImage(allyFort,x,y,slotSize,slotSize);
            ctx.strokeRect(x,y,slotSize,slotSize);
        }

    }
}

function shiftUp()
{
    var row=parseInt(coord[0]);
    var col=parseInt(coord[1]);
    if(row>0)
    {
        row--;
        document.getElementById("topLeft").value=row+","+col;
        getGrid();
    }
    else
        alert("you are already at the top of the map!!");
}

function shiftDown()
{
    var row=parseInt(coord[0]);
    var col=parseInt(coord[1]);
    if(row<100-playArea)
    {
        row++;
        document.getElementById("topLeft").value=row+","+col;
        getGrid();
    }
    else
        alert("you are already at the bottom of the map!!");   
}

function shiftLeft()
{
    var row=parseInt(coord[0]);
    var col=parseInt(coord[1]);
    if(col>0)
    {
        col--;
        document.getElementById("topLeft").value=row+","+col;
        getGrid();
    }
    else
        alert("That's as far towards left as you can go!!");
}

function shiftRight()
{
    var row=parseInt(coord[0]);
    var col=parseInt(coord[1]);
    if(col<100-playArea)
    {
        col++;
        document.getElementById("topLeft").value=row+","+col;
        getGrid();
    }
    else
        alert("Thats as far towards right as you can go!!");
}

function world()
{
    window.location="../world-map/canvas1.html";
}


function ShowMenu(e) 
{
    contextAction(canvas,e);
    var posx = e.clientX +window.pageXOffset +'px'; //Left Position of Mouse Pointer
    var posy = e.clientY + window.pageYOffset + 'px'; //Top Position of Mouse Pointer
    document.getElementById('ctxMenu').style.position = 'absolute';
    document.getElementById('ctxMenu').style.display = 'inline';
    document.getElementById('ctxMenu').style.left = posx;
    document.getElementById('ctxMenu').style.top = posy;           
}
function HideMenu(control) 
{ 
    document.getElementById(control).style.display = 'none'; 
}

function drawMap()
{
    var row=coord[0];
    var col=coord[1];
    var sx=col*wMapSlotSize;
    var sy=row*wMapSlotSize;
    console.log(sx+","+sy);
    console.log(coord);
    ctx1.drawImage(map,sx,sy,playArea*wMapSlotSize,playArea*wMapSlotSize,0,0,playArea*slotSize,playArea*slotSize);
}


var everythingLoaded = setInterval(function() {
  if (/loaded|complete/.test(document.readyState)) {
    clearInterval(everythingLoaded);
    loadLocal(); // this is the function that gets called when everything is loaded
  }
}, 10);

function loadLocal()
{
    var co=document.getElementById("topLeft").value;
    coord=co.split(",");
    canvas=document.getElementById("canvas");
    ctx = canvas.getContext("2d");
    mapCanvas=document.getElementById("mapCanvas");
    ctx1 = mapCanvas.getContext("2d");
    window.oncontextmenu=function(){return false}; //disable default context menu 
    playerSprite=new Image();
    playerSprite.src="../assets/blue.png";
    allySprite=new Image();
    allySprite.src="../assets/yellow.png";
    enemySprite=new Image();
    enemySprite.src="../assets/red.png";
    playerFort=new Image();
    playerFort.src="../assets/"+fortSet+"b.png";
    enemyFort=new Image();
    enemyFort.src="../assets/"+fortSet+"r.png";
    allyFort=new Image();
    allyFort.src="../assets/"+fortSet+"y.png";
    map=new Image();
    map.src = "../assets/map.png";
    map.onload=drawMap;
    getGrid();
    canvas.setAttribute("onClick","action(canvas,event)");
    canvas.setAttribute("onContextMenu","ShowMenu(event)");
    canvas.setAttribute("onmousemove","getCursorPosition(canvas,event)");
    document.getElementById("up").setAttribute("onClick","shiftUp()");
    document.getElementById("down").setAttribute("onClick","shiftDown()");
    document.getElementById("left").setAttribute("onClick","shiftLeft()");
    document.getElementById("right").setAttribute("onClick","shiftRight()");
    document.getElementById("world").setAttribute("onClick","world()");
}