var arr_a=[[0,0,0],[0,0,0],[0,0,0]];
var arr_cost = [0,0,0];
var arr_res = [0,0,0];
var co1 = 3, co2 = 3;
var arr_sim = [[0,0,0],[0,0,0],[0,0,0]];
var tmpelem,tmplabel,tmpbtn;
var isim = 0;
var imin = 0,jmin = 0,vmin = 0;

function ValidateCount()
{
	if ((document.getElementById("Count1").value < 2)||(document.getElementById("Count1").value > 7))
	{
		alert("Введите количество ресурсов от 2 до 7");		
		return false;
	}
		
	if ((document.getElementById("Count2").value < 2)||(document.getElementById("Count2").value > 7))
	{
		alert("Введите количество товаров от 2 до 7");		
		return false;
	}
	
	co1 = parseInt(document.getElementById("Count1").value,10);
	co2 = parseInt(document.getElementById("Count2").value,10);	
	return true;
}

function MakeMatrix()
{
	document.getElementById("Panel2").innerHTML = "";
	
	for (var i=0;i<document.getElementById("Count2").value;i++)
	{	
		
		for (var j=0;j<document.getElementById("Count1").value;j++)
		{
			tmpelem = document.createElement('input'); 
			tmpelem.value = "0";
			tmpelem.type = "number";
			tmpelem.step = "0.01";
			tmpelem.className = "littlenum";
			tmpelem.id = "ln_"+i+"_"+j;
			document.getElementById("Panel2").appendChild( tmpelem );
		}
		
		tmpelem = document.createElement('br');
		document.getElementById("Panel2").appendChild( tmpelem );		
	}	
	
	tmpelem = document.createElement('p');
	tmpelem.innerHTML = 'Введите ограничение по ресурсам';
	document.getElementById("Panel2").appendChild( tmpelem );	
	
	for (var j=0;j<document.getElementById("Count1").value;j++)
	{
		tmpelem = document.createElement('input'); 
		tmpelem.value = "0";
		tmpelem.type = "number";
		tmpelem.className = "littlenum";
		tmpelem.step = "0.01";
		tmpelem.id = "ra_"+j;
		document.getElementById("Panel2").appendChild( tmpelem );
	}
		
	tmpelem = document.createElement('p');
	tmpelem.innerHTML = 'Введите стоимость товаров';
	document.getElementById("Panel2").appendChild( tmpelem );

	for (var j=0;j<document.getElementById("Count2").value;j++)
	{
		tmpelem = document.createElement('input'); 
		tmpelem.value = "0";
		tmpelem.type = "number";
		tmpelem.className = "littlenum";
		tmpelem.step = "0.01";
		tmpelem.id = "pa_"+j;
		document.getElementById("Panel2").appendChild( tmpelem );
	}
		
	tmpelem = document.createElement('br');
	document.getElementById("Panel2").appendChild( tmpelem );
}

function SetVar()
{
	isim = 0;
	arr_a.length = co2;
	for (var i=0;i<co2;i++)
		arr_a[i].length = co1; 
	
	for (var i=0;i<co2;i++)
		for (var j=0;j<co1;j++)
			arr_a[i][j]=parseFloat(document.getElementById("ln_"+i+"_"+j).value);
	
	for (var j=0;j<co1;j++)
		arr_res[j]=parseFloat(document.getElementById("ra_"+j).value);
	
	for (var j=0;j<co2;j++)
		arr_cost[j]=parseFloat(document.getElementById("pa_"+j).value);	
}

function SimStart()
{
	arr_sim.length = 0;
	for (var i=0;i<1+co2;i++)
	{
		arr_sim[i] = new Array();
		arr_sim[i].length = 0;
		for (var j=0;j<1+co1+co2;j++)
		{			
			arr_sim[i].push(0);
		}
	}	
	//first row
	arr_sim[0][0] = 0;	
	for (var i=0;i<co1;i++)
		arr_sim[0][1+i] = -arr_cost[i];	
	for (var i=0;i<co2;i++)
		arr_sim[0][1+co1+i] = 0;
	
	//other
	for (var i=0;i<co1;i++)
		arr_sim[1+i][0] = arr_res[i];
	for (var i=0;i<co2;i++) 
		for (var j=0;j<co1;j++)
			arr_sim[1+i][1+j] = arr_a[i][j];
	for (var i=0;i<co1;i++) 
		for (var j=0;j<co1;j++)
		{
			if (i==j) arr_sim[i+1][j+co2+1] = 1;
			else arr_sim[i+1][j+co2+1] = 0;
		}	
}

function SimStep()
{
	imin = 0,jmin = 0,vmin = 0;
	for (var j=1;j<1+co1+co2;j++)
	{
		if (arr_sim[0][j] < vmin)
		{
			vmin = arr_sim[0][j];
			jmin = j;
		}
	}
	
	vmin = arr_sim[1][0]/arr_sim[1][jmin]+1;
	for (var i=1;i<1+co1;i++)
	{
		if (arr_sim[i][0]/arr_sim[i][jmin] < vmin)
		{
			vmin = arr_sim[i][0]/arr_sim[i][jmin];
			imin = i;
		}
	}
	var el1 = arr_sim[0][jmin], el2 = arr_sim[imin][jmin];	
	
	for (var i=0;i<1+co1;i++)
		if (i!=imin) 
		{
			el1 = arr_sim[i][jmin];
			for (var j=0;j<1+co1+co2;j++)
			{
				arr_sim[i][j]-=el1*arr_sim[imin][j]/el2;
			}
		}

	for (var j=0;j<1+co1+co2;j++)
	{
		arr_sim[imin][j]=arr_sim[imin][j]/el2;
	}
	
	isim++;
}

function SimCheck()
{
	b = false;
	for (var i=1;i<1+co1+co2;i++)
	{
		if (arr_sim[0][i]<0) b=true;
	}
	return b;
}
		
function Calc()
{
	SetVar();	
	SimStart();	
	while (SimCheck()&&(isim<co1+co2))
		SimStep();
	
	document.getElementById("CalcRes").value = arr_sim[0][0];
}

function GenStartDOM()
{
	tmplabel = document.createElement("p");
	tmplabel.innerHTML = "Количество ресурсов";
	document.getElementById("Panel1").appendChild( tmplabel );
	
	tmpelem = document.createElement('input');
	tmpelem.value = "3";
	tmpelem.type = "number";
	tmpelem.id = "Count1";
	document.getElementById("Panel1").appendChild( tmpelem );
	
	tmplabel = document.createElement("p");
	tmplabel.innerHTML = "Количество товаров";
	document.getElementById("Panel1").appendChild( tmplabel );	
	
	tmpelem = document.createElement('input');
	tmpelem.value = "3";
	tmpelem.type = "number";
	tmpelem.id = "Count2";
	document.getElementById("Panel1").appendChild( tmpelem );	
	
	tmplabel = document.createElement('br');
	document.getElementById("Panel1").appendChild( tmplabel );	

	tmplabel = document.createElement('br');
	document.getElementById("Panel1").appendChild( tmplabel );	
	
	let tmpbtn = document.createElement('input');
	tmpbtn.type = "button";
	tmpbtn.value = "Создать матрицу";
	tmpbtn.onclick = function ()
	{
		if (ValidateCount())
			MakeMatrix();
	}
	
	document.getElementById("Panel1").appendChild( tmpbtn );	
	
	tmplabel = document.createElement('br');
	document.getElementById("Panel1").appendChild( tmplabel );	
	
	tmplabel = document.createElement('div');
	tmplabel.id="Panel2";
	document.getElementById("Panel1").appendChild( tmplabel );		
	MakeMatrix();

	tmpbtn = document.createElement('input');
	tmpbtn.type = "button";
	tmpbtn.value = "Сделать расчет";
	tmpbtn.onclick = function ()
	{
		Calc();
	}
	document.getElementById("Panel1").appendChild( tmpbtn );
	
	tmplabel = document.createElement("p");
	tmplabel.innerHTML = "Результат";
	document.getElementById("Panel1").appendChild( tmplabel );	
	
	tmpelem = document.createElement('input');
	tmpelem.value = "0";
	tmpelem.type = "text";
	tmpelem.id = "CalcRes";
	document.getElementById("Panel1").appendChild( tmpelem );	
}
