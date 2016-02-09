var slotSize=50;
var wMapSlotSize=10;
var playArea=9;
var grid=[];
var playerId;
var faction;
var canvas, ctx;
var map;
var coord;

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
    console.log("action!");
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
}

function renderGrid()
{
    for(var i=0,y=0;i<playArea;i++,y+=slotSize)
    {
        for(var j=0,x=0;j<playArea;j++,x+=slotSize)
        {
            var value=grid[i][j];
            ctx.fillStyle =value;
            if(value!="white")
                ctx.fillRect(x,y,slotSize,slotSize);
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
    ctx1.drawImage(map,sx,sy,playArea*wMapSlotSize,playArea*wMapSlotSize,0,0,450,450);
}

window.onload=function loadLocal()
{
    var co=document.getElementById("topLeft").value;
    coord=co.split(",");
    canvas=document.getElementById("canvas");
    ctx = canvas.getContext("2d");
    mapCanvas=document.getElementById("mapCanvas");
    ctx1 = mapCanvas.getContext("2d");
    window.oncontextmenu=function(){return false}; //disable default context menu 
    for(var i=0;i<playArea;i++)
    {
      grid[i]=[];
    }
    map=new Image();
    map.src = "../assets/test1.jpg";
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