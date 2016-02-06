var playArea=9;
var canvas;
var ctx;
var playerId=1;
var faction=1;
var slotSize=50; //cell size in px
var grass;
var grid=[];
var coord;
for(var i=0;i<playArea;i++)
{
    grid[i]=[];
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

function getGrid(row,col)
{
    var xhttp;
    var coordf=document.getElementById("topLeft").value;
    coord=coordf.split(",");
    var row=coord[0];
    var col=coord[1];
    var temp;
    console.log(row+","+col);
    console.log(coord);
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
            //playerId=jsonVar[playArea*playArea]["player"];
            //faction=jsonVar[playArea*playArea]["faction"];
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

function renderGrid(grid)
{
    for(var i=0,y=0;i<playArea;i++,y+=slotSize)
    {
        for(var j=0,x=0;j<playArea;j++,x+=slotSize)
        {
            ctx.fillStyle=grid[i][j];
            /*if(grid[i][j]=="white")
            {
                grass=new Image();
                grass.onload=function()
                {
                    var a=x;
                    var b=y;
                    //console.log(x+","+y);
                    ctx.drawImage(grass,x,y,slotSize-2,slotSize-2);
                    //ctx.drawImage(grass,450+1,0+1,slotSize-2,slotSize-2);
                }
                grass.src="../assets/grass.jpg";
            }
            else
            {
                
            }*/
            ctx.fillRect(x,y,slotSize,slotSize);
            ctx.strokeRect(x,y,slotSize,slotSize);
        }
        
    }
}

window.onload=function loadLocal()
{
    canvas=document.getElementById("canvas");
    ctx = canvas.getContext("2d");
    getGrid();
    canvas.setAttribute("onClick","action(canvas,event)");
}