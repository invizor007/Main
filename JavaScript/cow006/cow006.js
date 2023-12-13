var plval = Array(10);
var incnums = Array(10);
var frontval = [[0],[0],[0],[0]];
var allval = Array(104);
var plco = 10;
var stage = 0;
var choosenum = 0;
var score = Array(10);
var step = 0;
var item = 0;
var incscore = 0;

function ochki(a)
{
	var c1 = Math.floor(a/10), c2 = a%10;
	if ((c1==5)&&(c2==5)) return 7;
	if (c1==c2) return 5;
	if (c2==0) return 3;
	if (c2==5) return 2;
	return 1;
}

function make_allval()
{
	for (var i=0;i<104;i++) allval[i] = -10;
	for (var i=0;i<104;i++)
	{
		var loopi = 0;
		do
		{
			num = Math.floor(104*Math.random());
			if (allval[num] == -10)
				allval[num] = i+1;
			else num = -1;
			loopi++;
		}
		while ((num==-1)&&(loopi<1000))
	} 
}

function make_game()
{
	if (plco<0) plco = 0;
	if (plco>10) plco = 10;
	for (var i=0;i<4;i++)		
		frontval[i][0] = allval[i+100];
	for (var i=0;i<plco;i++) 
	{	
		plval[i] = Array(10);
		for (var j=0;j<10;j++)
		{
			plval[i][j] = allval[i*10+j];
		}
	}
	
	//sorting
	for (var i=0;i<4;i++)
		for (var j=i+1;j<4;j++)
			if (frontval[i][0]>frontval[j][0])
			{
				var tmp1 = frontval[i][0] +frontval[j][0];
				frontval[i][0] = tmp1 - frontval[i][0];
				frontval[j][0] = tmp1 - frontval[j][0];
			}
			
	for (var i=0;i<10;i++)
		for (var j=i+1;j<10;j++)
			if (plval[0][i]>plval[0][j])
			{
				var tmp1 = plval[0][i]+plval[0][j];
				plval[0][i] = tmp1 - plval[0][i];
				plval[0][j] = tmp1 - plval[0][j];
			}
	for (var i=0;i<10;i++)
		score[i]=0;
}

function click1(e)
{
	if (stage!=1) return;
	if (e.clientY>450) return;
	if (e.clientY<400) return;
	choosenum = Math.floor((e.clientX)/50); 
	//alert(choosenum);
	if ((choosenum<0)||(choosenum>10)) return;
	make_hod();	
}

function draw()
{
	if (stage==0)
	{
		make_allval();
		make_game();
		stage = 1;
		step = 10;
		return;
	}

	if (stage==1)
	{
		var ctx = document.getElementById("canvas1").getContext("2d");
		ctx.fillStyle = 'white';
		ctx.strokeStyle = 'green';
		ctx.fillRect(0,0,document.getElementById("canvas1").width,document.getElementById("canvas1").height);	
		
		ctx.fillStyle = 'green';
		for (var i=0;i<4;i++) 
			for (var j=0;j<frontval[i].length;j++)
			{
				ctx.strokeRect(j*50,i*50,40,40);
				ctx.fillText(frontval[i][j]+"",10+50*j,50*i+20);
				var s="";
				for (var k=0;k<ochki(frontval[i][j]);k++) s=s+"*";
				ctx.fillText(s,10+50*j,50*i+30);
			}
		
		ctx.fillText("Ваши карты",20,290);
		for (var i=0;i<plval[0].length;i++)
		{
			ctx.strokeRect(i*50,300,40,40);
			ctx.fillText(plval[0][i]+"",50*i+10,320);
			var s="";
			for (var k=0;k<ochki(plval[0][i]);k++) s=s+"*";
			ctx.fillText(s,50*i+10,330);
		}	

		ctx.fillText("Счет",20,210);
		ctx.fillStyle = 'red';
		for (var i=0;i<10;i++)
		{
			ctx.strokeRect(i*50,230,40,40);
			ctx.fillText(score[i]+"",50*i+20,250);
		}			
	}

	if (stage==2)
	{
		var ctx = document.getElementById("canvas1").getContext("2d");
		ctx.fillStyle = 'white';
		ctx.strokeStyle = 'green';
		ctx.fillRect(0,0,document.getElementById("canvas1").width,document.getElementById("canvas1").height);	

		ctx.fillStyle = 'red';
		for (var i=0;i<10;i++)
		{
			ctx.strokeRect(i*50,230,40,40);
			ctx.fillText(score[i]+"",50*i+20,250);
		}			
	}
}

function frontmin()
{
	var iminsum = -1;
	incscore = 100;
	for (var i=0;i<4;i++)
	{
		var sum = 0;
		for (var j=0;j<frontval[i].length;j++)
			sum+=ochki(frontval[i][j]);
		if (sum<incscore)
		{
			incscore = sum;
			iminsum = i;
		}
	}
	return iminsum;
}

function make_hod()
{
	for (var i=1;i<plco;i++)
		incnums[i] = plval[i][step-1];
	incnums[0] = plval[0][choosenum];
	item = 0;
	
	var minnum = 105, iminnum = -1, idel = -1;
	for (var i=0;i<plco;i++)
		if (minnum>incnums[i])
		{
			iminnum = i;
			minnum = incnums[i];
		}
	
	if (minnum < frontval[0][frontval[0].length-1])
	{
		idel = frontmin();
		for (var i=idel;i>=1;i--)
		{
			frontval[i].length = 0;
			for (var j=0;j<frontval[i-1].length;j++)
				frontval[i].push(frontval[i-1][j]);
		}
			
		frontval[0].length=0;
		frontval[0].push(minnum);
		score[iminnum]+=incscore;
		item = 1;
		incnums[iminnum] = 105;
	}
	
	var lev = 0;
	while (item<plco)
	{
		minnum = 105, iminnum = -1;
		for (var i=0;i<10;i++)
			if (minnum>incnums[i])
			{
				iminnum = i;
				minnum = incnums[i];
			}
		
		for (var i=0;i<3;i++)
			if ((minnum>frontval[i][frontval[i].length-1]) && (minnum<frontval[i+1][frontval[i+1].length-1]))
				lev = i;
		if (minnum>frontval[3][frontval[3].length-1])
			lev = 3;//alert(minnum);
		
		if (frontval[lev].length<5)
		{
			frontval[lev].push(minnum);
		}
		else
		{
			var sum = 0;
			for (var j=0;j<frontval[lev].length;j++)
				sum+=ochki(frontval[lev][j]);
			score[iminnum]+=sum;
			frontval[lev].length = 1;
			frontval[lev][0] = minnum;
		}
		
		incnums[iminnum]=105;
		item++;
	}
	
	step--;
	plval[0].splice(choosenum,1);
	if (plval[0].length==0)
	{
		stage = 2;
	}
		
	return;
}


function start_game()
{
	plco = document.getElementById("txt1").value;
	make_allval();
	make_game();	
}

function timer()
{
	draw();
	window.setTimeout("timer();", 200);
}

window.addEventListener("load",timer,true);
