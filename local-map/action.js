var troopSelected=false;
var selRow;
var selCol;
var quantity;

function selectTroops()
{
	selRow=0;//make method to pass the row and column selected and also number of troops
	selCol=8;
	quantity=1;
	troopSelected=true;
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

function getLoc(row,col)
{
    action(row,col);
}


function action(row,col) //call it to get the available actions
{
	/*row=0;//make method to pass the row and column selected
	col=8;*/
    console.log(row+","+col)
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
            /*for(var i=0;i<actions.length;i++)
            {
                if(comm[i]['action']=="move")
                {
                    document.getElementById("move").setAttribute("onmousemove","move()");
                }
                if(comm[i]['action']=="fortify")
                {
                    document.getElementById("fortify").setAttribute("onmousemove","fortify()");
                }
                if(comm[i]['action']=="move")
                {
                    document.getElementById("attack").setAttribute("onmousemove","attack()");
                }
                if(comm[i]['action']=="move")
                {
                    document.getElementById("settle").setAttribute("onmousemove","settle()");
                }
                if(comm[i]['action']=="move")
                {
                    document.getElementById("create_troops").setAttribute("onmousemove","create_troops()");
                }
            }*/
        }
    }
    xhttp.open("GET", "getActions.php?row="+row+"&col="+col, true);
  	xhttp.send();
}
/**/