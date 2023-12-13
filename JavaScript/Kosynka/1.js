//m1- 0-red 1-black
//m2- 0..1 detail 00,01,10,11
//v- 1..13
//p1 - 0- nothing, -1 - colod, -2 -exit, 1..7 line
//p2 - p1=-1 num in colod, p1=-2 in panel3, 1..7 place under in panel2
var tmpcard = {m1:0,m2:0,v:0,p1:0,p2:0};
var cards = [];//array 52 elements of tmpcard

var upcardnum = [0,0,0,0];//upper card in place 3, 0 if nothing
var fieldcardco = [[0,1,2,3,4,5,6],[0,0,0,0,0,0,0]];//max and min for p2
var fieldfree = [0,0,0,0,0,0,0];
var ifr = -1, ito = -1;

var imgs = [];//card images
var imgs2 = [];//other images

var stage = 0, offs1 = 0, offs1m = 24;
var lastclickp = 0, lastclickn = 0, moveco = 0;//place and num for moving card

const size_H1 = 300, size_H2 = 500, size_W1 = 600;
const card_W = 125, card_H = 188;
const dist_W1 = 140, dist_H2 = 20;

//for debug
var debug_tmp1 = 0;
var logtype = 1;

function debug()
{
	//part1
	//cards[debug_tmp1].p1 = 2;
	//cards[debug_tmp1].p2 = -debug_tmp1;
	//fieldcardco[1][1] = -debug_tmp1;
	//debug_tmp1++;
	
	return;
}

function alertif(s)
{
	if (logtype==0) alert(s);
	else if (logtype==1) console.log(s);
}

//////////// INIT ////////////
function InitImages()
{
	for (var i=0;i<=3;i++)
	{
		for (var j=1;j<=13;j++)
		{
			var tmp = new Image();
			tmp.src = 'Cards/'+j+'_'+i+'.bmp';
			imgs.push(tmp);
		}
	}	
	
	var tmp = new Image();
	tmp.src = "Cards/closed.bmp";
	imgs2.push(tmp);
}


function InitCards()
{
	for (var i=0;i<=3;i++)
	{
		for (var j=1;j<=13;j++)
		{
			var tmp = {m1:Math.floor(i/2),m2:i % 2,v:j, p1:-10, p2:-10};
			cards.push(tmp);
		}
	}
}

function MakeCardPlace()
{
	//1 random values p1
	for (var i=0;i<52;i++)
	{
		var loopi = 0;
		do
		{
			num = Math.floor(52*Math.random());
			if (cards[num].p1 == -10)
				cards[num].p1 = i;
			else num = -1;
			loopi++;
		}
		while ((num==-1)&&(loopi<1000))
	} 
	//2 make places
	for (var i=0;i<52;i++)
	{
		if ((cards[i].p1>=0)&&(cards[i].p1<=28-1))
		{
			var j=1, tmp = cards[i].p1;//27-1-2-3-4-5-6-7
			do
			{
				tmp-=j;
				j++;
			}
			while ((j<=7)&&(tmp>=0));
			
			j--;
			tmp+=j;
			cards[i].p1 = j;
			cards[i].p2 = tmp;
		}
		if ((cards[i].p1>=28)&&(cards[i].p1<=52-1))
		{
			cards[i].p2 = cards[i].p1 - 28;
			cards[i].p1 = -1;
		}
	}
}

//////////// MOVING CARDS ////////////
//1-colod //2-main  //3-exit

function canmove12(plfr,plto)
{
	alertif("canmove12("+plfr+","+plto+")");
	ifr = -1, ito = -1;
	for (var i=0;i<52;i++)
	{
		if ((cards[i].p1 == -1)&&(cards[i].p2 == plfr)) ifr = i;
		if ((cards[i].p1 == plto)&&(cards[i].p2 == fieldcardco[1][plto-1]/*0*/)) ito = i;
	}
	if (ifr == -1) return false;
	
	if (fieldfree[plto-1] == 1)//(ito == -1)
	{
		if (cards[ifr].v == 13) return true;
		else return false;
	}
	if (ifr != -1)
		alertif("ifr="+cards[ifr].v+" "+cards[ifr].m1+cards[ifr].m2);
	if (ito != -1)
		alertif("ito="+cards[ito].v+" "+cards[ito].m1+cards[ito].m2);
	if ((cards[ito].m1!=cards[ifr].m1)&&(cards[ito].v == cards[ifr].v+1)) return true;
	else return false;
}

function move12(plfr,plto)
{
	if (!canmove12(plfr,plto)) 
	{
		lastclickp = 0;
		lastclickn = 0;
		return;	
	}		
	alertif("move12");
	ifr = -1;
	for (var i=0;i<52;i++)
		if ((cards[i].p1 == -1)&&(cards[i].p2 == plfr)) ifr = i;
	if (ifr == -1) return;
	cards[ifr].p1 = plto;
	cards[ifr].p2 = fieldcardco[1][plto-1]-1;
	fieldcardco[1][plto-1]--;
	if (cards[ifr].v==13)
	{
		cards[ifr].p2 = 0;
		fieldcardco[1][plto-1] = 0;
		fieldfree[plto-1] = 0;
	}
	for (var i=0;i<52;i++)
		if ((cards[i].p1 == -1)&&(cards[i].p2 > plfr)) cards[i].p2--;	
	offs1m--;
	lastclickp = 0;
	lastclickn = 0;
}

function canmove13(plfr)
{
	alertif("canmove13("+plfr+")");
	ifr = -1;
	for (var i=0;i<52;i++)
		if ((cards[i].p1 == -1)&&(cards[i].p2 == plfr)) ifr = i;
	if (ifr == -1) return false;
	
	var tmp = cards[ifr].m1*2+cards[ifr].m2; 
	//alertif("tmp="+tmp);alertif("ifr="+ifr);
	if (upcardnum[tmp]+1 == cards[ifr].v) return true;
	else return false;
}

function move13(plfr)
{	
	if (!canmove13(plfr))
	{
		lastclickp = 0;
		lastclickn = 0;
		return;	
	}			
	alertif("move13");
	ifr = -1;
	for (var i=0;i<52;i++)
		if ((cards[i].p1 == -1)&&(cards[i].p2 == plfr)) ifr = i;
	if (ifr == -1) return;
	var tmp = cards[ifr].m1*2+cards[ifr].m2;
	upcardnum[tmp]++;
	cards[ifr].p1 = 60;
	cards[ifr].p2 = 60;
	for (var i=0;i<52;i++)
		if ((cards[i].p1 == -1)&&(cards[i].p2 > plfr)) cards[i].p2--;	
	offs1m--;

	lastclickp = 0;
	lastclickn = 0;	
}

function canmove22(plfr,plto)
{
	alertif("canmove22("+plfr+","+plto+")");
	moveco = 0;
	if (plfr == plto) return false;
	ifr = -1, ito = -1;
	for (var i=0;i<52;i++)
	{		
		if ((cards[i].p1 == plfr)&&(cards[i].p2 == /*0*/fieldcardco[1][plfr-1])) ifr = i;
		if ((cards[i].p1 == plto)&&(cards[i].p2 == fieldcardco[1][plto-1])) ito = i;
	}
	if (ifr == -1) return false;
	if (ito == -1)//(fieldfree[plto-1] == 1)//(ito == -1)
	{
		if (cards[ifr].v-fieldcardco[1][plfr-1] == 13) 
		{
			moveco = 1-fieldcardco[1][plfr-1];
			return true;
		}
		else return false;
	}
	if ((fieldcardco[0][plto-1]==0)&&(fieldcardco[1][plto-1]==0)&&(fieldfree[plto-1]==1))
	{
		if (cards[ifr].v-fieldcardco[1][plfr-1] == 13) 
		{
			moveco = 1-fieldcardco[1][plfr-1];
			return true;
		}
	}

	var x = -fieldcardco[1][plfr-1]+1, b = false; alertif("x="+x);
	if (ifr != -1)
	{
		alertif("cards[ifr].m1="+cards[ifr].m1);
		alertif("cards[ifr].v="+cards[ifr].v);
	}
				
	if (ito != -1)
	{
		alertif("cards[ito].m1="+cards[ito].m1);
		alertif("cards[ito].v="+cards[ito].v);
	}
			
	for (var i=0;i<=x;i++)
		if ((cards[ito].m1!=cards[ifr].m1+(i % 2))&&(cards[ito].v == cards[ifr].v+i+1)) 
		{
			b = true;
			moveco = i+1;
		}		
	
	alertif("moveco="+moveco);
	return b;
}


function move22(plfr,plto)
{
	if (!canmove22(plfr,plto))
	{
		lastclickp = 0;
		lastclickn = 0;
		return;	
	}
	alertif("move22");
	
	var x = 0;
	for (var j=0;j<moveco;j++)
	{
		x = fieldcardco[1][plfr-1]+j;
		ifr = -1;
		for (var i=0;i<52;i++)
			if ((cards[i].p1 == plfr)&&(cards[i].p2 == x)) ifr = i;
		
		cards[ifr].p1 = plto;
		cards[ifr].p2 = fieldcardco[1][plto-1]-moveco+j;
		if (fieldfree[plto-1]==1)
		{
			cards[ifr].p2++;		
		}
		//fieldcardco[1][plto-1]--;
		//fieldcardco[1][plfr-1]++;
		if (ifr != -1)
			alertif("ifr="+ifr+" cards[ifr].p1="+cards[ifr].p1+" cards[ifr].p2="+cards[ifr].p2);
	}
	fieldcardco[1][plto-1]-=moveco;
	fieldcardco[1][plfr-1]+=moveco;
	if (fieldfree[plto-1]==1)
	{
		fieldcardco[1][plto-1]++;		
	}	
	
	if (fieldcardco[1][plfr-1]>0)
	{
		//open card
		fieldcardco[1][plfr-1]=0;
		fieldcardco[0][plfr-1]--;
		if (fieldcardco[0][plfr-1]<0) fieldcardco[0][plfr-1]=0;
		for (var i=0;i<52;i++)
			if ((cards[i].p1 == plfr)&&(cards[i].p2 > 0)) cards[i].p2--;
	}
	else
	{	
		fieldcardco[1][plfr-1] = 0;
	}
	
	if ( (fieldcardco[1][plfr-1]==0)&&(fieldcardco[0][plfr-1]==0) )
		fieldfree[plfr-1] = 1;	
	for (var i=0;i<52;i++)
		if (cards[i].p1 == plfr)
			fieldfree[plfr-1] = 0;
	fieldfree[plto-1] = 0;
	moveco = 0;
	
	lastclickp = 0;
	lastclickn = 0;	
}


function canmove23(plfr)
{
	alertif("canmove23("+plfr+")");
	ifr = -1;
	for (var i=0;i<52;i++)
	{
		if ((cards[i].p1 == plfr)&&(cards[i].p2 == fieldcardco[1][plfr-1])) ifr = i;
	}
	if (ifr == -1) return false;
	
	var tmp = cards[ifr].m1*2+cards[ifr].m2; 
	//alertif("1:"+upcardnum[tmp]);alertif("2:"+cards[ifr].v);
	//alertif("tmp="+tmp);alertif("ifr="+ifr);
	if (upcardnum[tmp]+1 == cards[ifr].v) return true;
	else return false;
}

function move23(plfr)
{
	if (!canmove23(plfr))
	{
		lastclickp = 0;
		lastclickn = 0;
		return;	
	}			
	alertif("move23");
	ifr = -1;
	for (var i=0;i<52;i++)
	{
		if ((cards[i].p1 == plfr)&&(cards[i].p2 == fieldcardco[1][plfr-1])) ifr = i;
	}
	if (ifr == -1) return;
	var tmp = cards[ifr].m1*2+cards[ifr].m2;
	upcardnum[tmp]++;
	cards[ifr].p1 = 60;
	cards[ifr].p2 = 60;
	if (fieldcardco[1][plfr-1]==0)
	{
		for (var i=0;i<52;i++)
			if ((cards[i].p1 == plfr)&&(cards[i].p2 > 0)) cards[i].p2--;
		fieldcardco[0][plfr-1]--;
		if (fieldcardco[0][plfr-1]<0) fieldcardco[0][plfr-1]=0;		
	}
	else
	{
		fieldcardco[1][plfr-1]++;
	}
	if ((fieldcardco[0][plfr-1]==0)&&(fieldcardco[1][plfr-1]==0))
		fieldfree[plfr-1] = 1;
	
	lastclickp = 0;
	lastclickn = 0;	
}

function canmove32(plfr,plto)
{
	alertif("canmove32("+plfr+","+plto+")");
	ito = -1;
	for (var i=0;i<52;i++)
	{
		if ((cards[i].p1 == plto)&&(cards[i].p2 == fieldcardco[1][plto-1])) ito = i;
	}
	if (ito == -1) return false;
	ifr = 13*plfr+upcardnum[plfr]-1;
	var tmp = Math.floor(plfr/2);
	
	if ((cards[ito].v == cards[ifr].v+1)&&(tmp!=cards[ito].m1)) return true;
	else return false;
}

function move32(plfr,plto)
{
	if (!canmove32(plfr,plto))
	{
		lastclickp = 0;
		lastclickn = 0;
		return;	
	}			
	alertif("move32");
	
	ito = -1;
	for (var i=0;i<52;i++)
	{
		if ((cards[i].p1 == plto)&&(cards[i].p2 == fieldcardco[1][plto-1])) ito = i;
	}
	if (ito == -1) return false;	
	
	ifr = 13*plfr+upcardnum[plfr]-1;
	upcardnum[plfr]--;
	cards[ifr].p1 = plto;
	cards[ifr].p2 = fieldcardco[1][plto-1]-1;	
	fieldcardco[1][plto-1]--;
	fieldfree[plto-1] = 0;
	
	lastclickp = 0;
	lastclickn = 0;	
}

function click1(e)
{ 
	var x = Math.floor((e.clientX - size_W1 - 10)/dist_W1);
	if ((x<0)||(x>3)) return;
	
	if (x==3)
	{
		offs1++;
		if (offs1>=offs1m) offs1 = 0;			
	}

	lastclickp = 1;
	lastclickn = x;	
}

function click2(e)
{
	var x = Math.floor((e.clientX - 10)/dist_W1);
	if (x>7) debug();
	if ((x<0)||(x>7)) return;
	x++;
	//var y1 = Math.floor((e.clientY - size_H1 - 10-70)/20); 
	//if (y1<0) y1=0;
	
	if (lastclickp == 1)
		move12(lastclickn+offs1,x);
	else if (lastclickp == 2)
		move22(lastclickn,x);
	else if (lastclickp == 3)
		move32(lastclickn,x);
	else if (lastclickp == 0)
	{
		lastclickp = 2;
		lastclickn = x;
	}
	
}

function click3(e)
{
	var x = Math.floor((e.clientX - 10)/dist_W1);	
	if ((x<0)||(x>3)) return;
	
	if (lastclickp == 1)
		move13(lastclickn+offs1);
	else if (lastclickp == 2)
		move23(lastclickn);
	else if (lastclickp == 0)
	{
		lastclickp = 3;
		lastclickn = x;
	}	
}

function draw()
{
	if (stage==0)
	{
		InitImages();
		InitCards();
		MakeCardPlace();
		//document.onkeydown = click1;
		stage = 1;
	}

	//canvas1
	var ctx = document.getElementById("canvas1").getContext("2d");
	ctx.fillStyle = 'white';
	ctx.strokeStyle = 'green';
	ctx.fillRect(0,0,document.getElementById("canvas1").width,document.getElementById("canvas1").height);	
	
	for (var i=0;i<52;i++)
	{
		if ((cards[i].p1==-1)&&(cards[i].p2>=offs1)&&(cards[i].p2<=offs1+2))
			ctx.drawImage(imgs[i],(cards[i].p2-offs1)*dist_W1,0);
	}
	ctx.drawImage(imgs2[0],3*dist_W1,0);
	if (lastclickp == 1)
	{
		ctx.strokeRect(lastclickn*dist_W1,5,dist_W1,190);
	}
		
	
	//canvas2	
	ctx = document.getElementById("canvas2").getContext("2d");
	ctx.fillStyle = 'white';
	ctx.strokeStyle = 'green';
	ctx.fillRect(0,0,document.getElementById("canvas2").width,document.getElementById("canvas2").height);
	
	for (var i=0;i<52;i++)
	{
		var p1 = cards[i].p1, p2 = cards[i].p2;
		
		if ((p1>=1)&&(p1<=7)&&(p2>0))
			ctx.drawImage(imgs2[0],
				0,10,card_W,10,
				(cards[i].p1-1)*dist_W1,70-10*cards[i].p2,card_W,10);
				
		if ((p1>=1)&&(p1<=7)&&(p2>fieldcardco[1][p1-1])&&(p2<=0))
			ctx.drawImage(imgs[i],
				0,0,card_W,30,
				(p1-1)*dist_W1,70-30*p2,card_W,30);			
			
		if ((p1>=1)&&(p1<=7)&&(p2<=fieldcardco[1][p1-1]))
			ctx.drawImage(imgs[i],
				0,0,card_W,card_H,
				(p1-1)*dist_W1,70-30*p2,card_W,card_H);
	}
	if (lastclickp == 2)
		ctx.strokeRect((lastclickn-1)*dist_W1,75,card_W,190-30*fieldcardco[1][lastclickn-1]);		

	
	//canvas3
	ctx = document.getElementById("canvas3").getContext("2d");
	ctx.fillStyle = 'white';
	ctx.strokeStyle = 'green';
	ctx.fillRect(0,0,document.getElementById("canvas3").width,document.getElementById("canvas3").height);	
	for (var i=0;i<=3;i++)
	{
		if (upcardnum[i]==0)
			ctx.drawImage(imgs2[0],i*dist_W1,0);
		else
			ctx.drawImage(imgs[i*13+upcardnum[i]-1],i*dist_W1,0);
	}
	if (lastclickp == 3)
		ctx.strokeRect(lastclickn*dist_W1,5,dist_W1,190);
			
}

function timer()
{
	draw();
	window.setTimeout("timer();", 200);
}

window.addEventListener("load",timer,true);
