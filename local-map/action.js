var slotSize=50;
var playArea=9;
var grid=[];
var playerId;
var faction;
var canvas, ctx;
var grass=new Image();

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
            //console.log(test);
            comm=JSON.parse(test);
            var content="";
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
            }
            else
            {
                var quant=document.getElementById("quantity");
                quant.style.visibility='visible';
            }
            document.getElementById("action").innerHTML=content;
            document.getElementById("bottom_hint").innerHTML=hint;
            document.getElementById("row").value=row;
            document.getElementById("col").value=col;
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
            var value = grid[i][j];
            ctx.fillStyle = value;
            if(grid[i][j]=="white")
            {
              //console.log(x,y);
              ctx.drawImage(grass,x,y,slotSize-2,slotSize-2);
              //ctx.fillRect(x,y,slotSize,slotSize);
            }
            else
            {
                ctx.fillRect(x,y,slotSize,slotSize);
            }
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

window.onload=function loadLocal()
{
    canvas=document.getElementById("canvas");
    ctx = canvas.getContext("2d");

    for(var i=0;i<playArea;i++)
    {
      grid[i]=[];
    }

    grass.onload = getGrid;
    grass.src = "../assets/grass.jpg";
    canvas.setAttribute("onClick","action(canvas,event)");
    document.getElementById("up").setAttribute("onClick","shiftUp()");
    document.getElementById("down").setAttribute("onClick","shiftDown()");
    document.getElementById("left").setAttribute("onClick","shiftLeft()");
    document.getElementById("right").setAttribute("onClick","shiftRight()");
    document.getElementById("world").setAttribute("onClick","world()");
}