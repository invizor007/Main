"use strict";
var CardTypeC=10, CardValC=6, UrnaC=10, PlayerMaxC=4, LCardC = 60, ucmode = 0, PlayerCount = 2,
CurrPlayer = 0, itemnum = 0, stage = 0, ShowPlayer = 0, CurrLA = -1, CurrPLA = -1;


var Cards = Array(60);
var PlCards = [[],[],[],[]];
var Urna = [0,1,2,3,4,5,6,7,8,9];
var LCards = [];
var AbiCards = [0,0,0];
var Score = [0,0,0,0];
var HighVal = [[0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0]];
var HasTip = [0,0,0,0,0,0,0,0,0,0];
var Abi = [0,0,0,0,0,0,0,0,0,0];//0- need not used \ 1 - used \ 2 - passive \ 3 - not need
var TmpArrY = [0,0,0,0,0,0,0,0,0,0];
var TmpArrE = [0,0,0,0,0,0,0,0,0,0];


var CB1Checked = false, CB2Checked = false;
var Players = [];
var Game, FiveCubes, RandUsed;
var imgs = [];

////////////////////////INITIALIZATION

function GenCards()
{
	var r = 0, exst = 0;
	for (var i=0;i<50;i++)
	{
		do
		{    
			exst = 1;
			r = Math.floor(Math.random()*50)+10;
			for (var j=0;j<i;j++)
				if (Cards[j]==r) exst = 0;
		}
		while (exst==0);
		Cards[i] = r;
	}
}

function qq(s)
{
	alert(s);
}


function ImageInit()
{
	for (var i=0;i<=10;i++)
	{
		var tmp = new Image();
		tmp.src = "imgs\\"+i+".bmp";
		imgs.push(tmp);
	}  
}

function cval(i)
{
	var x = Math.floor(i/10);
	if (i%10==0) x+=4;
	else x+=2;
	return x;
}

function ctip(i)
{
	return (i%10);
}

function f_abi(currt)
{
	if ((currt == 0)||(currt==3)||(currt==7)) return 2;
	else if ((currt == 1)||(currt==6)) return 3;
	else return 0;
}

////////////////////////CARD SPECIAL FUNCTIONS

//take cards from urna
function priz16()
{
	var co = Math.min(2*LCards.length,Urna.length), val = 0;
	for (var i=0;i<co;i++)
	{
		var r = Math.random()*Urna.length;
		val = Urna[r];
		Urna.splice(r,1);
		PlCards[CurrPlayer].push(val);
	}
	alert('Вы получаете '+co+' карт в качестве награды');
	LCards = [];
	CurrPlayer++;
	if (CurrPlayer==PlayerCount) CurrPlayer = 0;
	CanvasLRefresh();
	CanvasPlRefresh();	
	CurrPlayerInfoOut();
	return 0;
}
//Take one of 3 cards
function choose5()
{
	ucmode = 5;
	ShowPlayer = -2;
	var loopco = 3;
	if (loopco>Urna.length) loopco = Urna.length;
	for (var i=0;i<loopco;i++)
	{
		var r = Math.floor(Math.random()*Urna.length);
		AbiCards[i]=Urna[r];
		Urna.splice(r,1);
	}
	
	if (loopco==0)
	{
		ucmode = 0;
		ShowPlayer = CurrPlayer;
		Abi[CurrLA] = 1;
	}
	
	CanvasLRefresh();
	CanvasPlRefresh();
	return 0;
}

function setarr8()
{
	ucmode = 8;
	for (var i=0;i<10;i++)
		TmpArrY[i]=0;
	for (var i=0;i<10;i++)
		TmpArrE[i]=0;	
	
	for (var i=0;i<PlCards[CurrPlayer].length;i++)
		TmpArrY[ctip(PlCards[CurrPlayer][i])] = 1;
	for (var p=0;p<PlayerCount;p++)
		for (var i=0;i<PlCards[p].length;i++)
			TmpArrE[ctip(PlCards[p][i])] = 1;
}

//See New Card in line
function see9()
{
	ucmode = 9;
	ShowPlayer = -3;
	Abi[CurrLA] = 1;
	CanvasPlRefresh();	
	return 0;
}

////////////////////////BUTTONS

function UseAbility()
{
	if (stage!=1) 
	{
		alert('Начните новую игру!');
		return 2;
	}
	if (CurrLA==-1)
	{
		alert('Выберите карту которую применить');
		return 2;
	}
	var currt = ctip(LCards[CurrLA]);
	CheckAbiSkip();
	
	var check1 = 0;	
	if (currt==1)
	{
		for (var i=0;i<LCards.length;i++)
			if (ctip(LCards[i])==6)
				check1 = 1;
		if (check1==1)
			priz16();
	}
	if (currt==6)
	{
		for (var i=0;i<LCards.length;i++)
			if (ctip(LCards[i])==1)
				check1 = 1;
		if (check1==1)
			priz16();
	}	
	
	if  ((currt==2)||(currt==4))
		ucmode = currt;
	if (currt==5)
		choose5();
	if (currt==8)
		setarr8();
	if (currt==9)
		see9();
	
	
	CanvasLRefresh();
	CanvasPlRefresh();
	CurrPlayerInfoOut();
	return 0;
}

function NewCard()
{
	CheckEnd();
	if (stage!=1) 
	{
		alert('Начните новую игру!');
		return 2;
	}
	for (var i=0;i<LCards.length;i++)
	{
		if (Abi[i]==0) 
		{
			alert('Для начала примените способности всех активных карт');
			return 2;
		}
	}
	
	ucmode = 0;
	ShowPlayer = CurrPlayer;
	LCards.push(Cards[itemnum]);
	itemnum++;
	var currt = ctip(LCards[LCards.length-1]);
	if (HasTip[currt]==1)
		ChangePl();
	HasTip[currt]=1;
	Abi[LCards.length-1]=f_abi(currt);
	
	if (currt==3)
	{
		//add two new cards N1
		LCards.push(Cards[itemnum]);
		itemnum++;	
		currt = ctip(LCards[LCards.length-1]);
		if (HasTip[currt]==1)
			ChangePl();
		HasTip[currt]=1;
		Abi[LCards.length-1]=f_abi(currt);
		
		//N2
		LCards.push(Cards[itemnum]);
		itemnum++;	
		currt = ctip(LCards[LCards.length-1]);
		if (HasTip[currt]==1)
			ChangePl();
		HasTip[currt]=1;
		Abi[LCards.length-1]=f_abi(currt);		
	}
	
	CanvasLRefresh();
	CanvasPlRefresh();
	CurrPlayerInfoOut();	
}

function RefreshShowPlayer(i)
{
	if (i==-1) ShowPlayer = CurrPlayer;
	else ShowPlayer = i;
	CalcScore(ShowPlayer);
	var sps = Score[ShowPlayer];
	alert("Итого очков "+sps);
	CanvasPlRefresh();
}

function TakeCards()
{
	if (stage!=1) 
	{
		alert('Начните новую игру!');
		return 2;
	}
	for (var i=0;i<LCards.length;i++)
		PlCards[CurrPlayer].push(LCards[i]);

	LCards = [];
	
	CalcScore(CurrPlayer);
	CurrPlayer++;
	if (CurrPlayer>=PlayerCount) CurrPlayer = 0;
	for (var i=0;i<10;i++)
		Abi[i]=0;	
	for (var i=0;i<10;i++)
		HasTip[i]=0;	

	CanvasLRefresh();
	CanvasPlRefresh();	
	CurrPlayerInfoOut();
}

function ChangePl()
{
	var has7 = 0;
	for (var i=LCards.length;i>=0 && has7==0;i--)
	{
		if (ctip(LCards[i])==7) has7 = 1;
		Urna.push(LCards[LCards.length-1]);
		LCards.splice(i-1,1);
	}
	//LCards = [];
	
	for (var i=0;i<9;i++)
		HasTip[i]=0;
	CalcScore(CurrPlayer);
	CurrPlayer++;
	if (CurrPlayer>=PlayerCount) CurrPlayer = 0;
	CanvasLRefresh();	
	CanvasPlRefresh();	
	CurrPlayerInfoOut();	
}

function CheckAbiSkip()
{
	var currt = ctip(LCards[CurrLA]);
	var skip = 0;
	if (currt==2)
	{
		skip = 1;
		for (var i=0;i<PlayerCount;i++)
			if ((PlCards[i].length>0)&&(i!=CurrPlayer)) 
				skip = 0;
	}
	if (currt==4)
	{		
		if (PlCards[CurrPlayer].length>0)
			skip = 0;
		else skip = 1;
	}	
	if (currt==5)
	{		
		if (Urna.length>0)
			skip = 0;
		else skip = 1;
	}	
	if (currt==8) 
	{		
		skip = 1;
		for (var i=0;i<10;i++)
			if (TmpArrY[i]!=TmpArrE[i]) 
				skip = 0;
	}
	
	if (skip==1)
	{
		Abi[CurrLA]=1;
		alert('Карту сейчас нельзя применить, пропускаем применение.');
	}
	CanvasLRefresh();
	CanvasPlRefresh();
	CurrPlayerInfoOut();
}

function CalcScore(pl)
{
	var num = 0;
	for (var i=0;i<10;i++)
		HighVal[pl][i]=0;
	for (var i=0;i<PlCards[pl].length;i++)
	{
		num = ctip(PlCards[pl][i]);
		if (HighVal[pl][num] < cval(PlCards[pl][i]))
			HighVal[pl][num] = cval(PlCards[pl][i]);
	}
	Score[pl] = 0;
	for (var i=0;i<10;i++)
		Score[pl] += HighVal[pl][i];
}

function GameInit()
{
	ImageInit(); 
	GenCards();
}

///////////////////////////////Canvas Drawing

function CanvasPlRefresh()
{	
	if (ShowPlayer==-2)
	{
		var ctx = document.getElementById("CanvasPlayerArray").getContext("2d");
		ctx.fillStyle='#8080ff';
		ctx.fillRect(0,0,1500,220);
		ctx.font = "24px serif";
		ctx.fillStyle='#0000ff';
	
		for (var i=0;i<3;i++)
		{
			ctx.drawImage(imgs[ctip(AbiCards[i])],150*i,0);	
			ctx.fillText(cval(AbiCards[i]),150*i+15,25);
		}
	
		return 0;
	}
  
	if (ShowPlayer==-3)
	{
		var ctx = document.getElementById("CanvasPlayerArray").getContext("2d");
		ctx.fillStyle='#8080ff';
		ctx.fillRect(0,0,1500,220);
		ctx.font = "24px serif";
		ctx.fillStyle='#0000ff';
	
		ctx.drawImage(imgs[ctip(Cards[itemnum])],150*0,0);	
		ctx.fillText(cval(Cards[itemnum]),150*0+15,25);	  
		return 0;
	}  
  
	var ctx = document.getElementById("CanvasPlayerArray").getContext("2d");
	ctx.fillStyle='#8080ff';
	ctx.fillRect(0,0,1500,220);
	ctx.font = "24px serif";
	ctx.fillStyle='#0000ff';  
	for (var i=0;i<10;i++)
	{
		if (HighVal[ShowPlayer][i]>0)
		{
			ctx.drawImage(imgs[i],150*i,0);
			var k=0;
			for (var j=0;j<PlCards[ShowPlayer].length;j++)
			{
				if (ctip(PlCards[ShowPlayer][j])==i)
				{
					ctx.fillText(cval(PlCards[ShowPlayer][j]),150*i+15+25*k,25);
					k++;
				}				
			}
		}
	}
}

function CanvasLRefresh()
{
	var ctx = document.getElementById("CanvasLCards").getContext("2d");
	ctx.fillStyle='#8080ff';
	ctx.fillRect(0,0,1500,220); 
	for (var i=0;i<LCards.length;i++)
	{
		var currval = cval(LCards[i]);
		var currtip = ctip(LCards[i]);	  
		ctx.drawImage(imgs[currtip],150*i,0);
		ctx.font = "24px serif";
		ctx.fillStyle='#0000ff';
		ctx.fillText(currval,150*i+15,25);
	  
		if (Abi[i]==0) ctx.fillStyle='#ffff80';
		else if (Abi[i]==1) ctx.fillStyle='#ff00ff';
		else if (Abi[i]==2) ctx.fillStyle='#808080';
		else ctx.fillStyle='#80FF80';
		ctx.fillRect(150*i,200,150,20);			  
	}
}

/////////////////////////START , END


function CheckEnd()
{
	if (itemnum >= 50)
	{
		for (var i=0;i<3;i++)
			CalcScore(i);
		stage = 2;
	}
}


function GameStart()
{
	GameInit();
	alert("Игра начинается");

	var value = document.getElementById("ChoosePlayerCount").value;
	PlayerCount = Number(value);

	if ((PlayerCount < 2) || (PlayerCount>4))
	{
		alert("Введите число от 2 до 4");
		return;
	} 
	CurrPlayer = 0;
	itemnum = 0;
	stage = 1;
	GenCards(); Test1();

	CanvasPlRefresh();
	CanvasLRefresh();
	CurrPlayerInfoOut();
}


function GameEnd()
{
	stage = 2;
	ctx=document.getElementById("CanvasPlayerArray").getContext("2d");
	ctx.fillStyle='#8080ff';
	ctx.fillRect(0,0,1500,225);

	document.getElementById("LabelCurrPlayer").innerHTML='Игрок номер '+(CurrPlayer+1);
	document.getElementById("LabelScore").innerHTML=Score[CurrPlayer]+' очков ';
}

function CurrPlayerInfoOut()
{
	document.getElementById("LabelCurrPlayer").innerHTML='Ходит игрок '+(CurrPlayer+1);
	document.getElementById("LabelScore").innerHTML=Score[CurrPlayer]+' очков ';
}

function AfterMove()
{
	var cnum = LCards[LCards.length-1];
	var t = ctip(cnum), v = cval(cnum), makedel = 0;
	for (var i=0;i<LCards.length-1;i++)
		if (ctip(LCards[i])==t) makedel = 1;
		
	if (makedel==1)
	{
		var i7=0;
		for (var i=0;i<LCards.length;i++)
			if (ctip(LCards[i])==7)
				i7=i;
		for (var i=0;i<i7;i++)
			PlCards[CurrPlayer].push(LCards[i]);
		LCards.length = 0;
		CurrPlayer++;
		if (CurrPlayer>=PlayerCount) CurrPlayer = 0;
	}	
}

///////////////////////CANVAS CLICK


function LCardsClick(e)
{
	if (ucmode>=0)
	{
		var x = Math.floor(e.clientX/150);
		if (x<LCards.length)
			CurrLA = x;
		alert('Выбрана карта '+x);
	}	
	return 0;
}

function PlCardsClick(e)
{
	if (ucmode==0)
	{
		var x = Math.floor(e.clientX/150);
		if (x<10)
			CurrPLA = x;		
		alert('Выбрана карта '+x);		
	}
	if (ucmode==2)
	{
		var x = Math.floor(e.clientX/150);
		if (x<10)
			CurrPLA = x;		
		alert('Выбрана карта '+x);
		if (ShowPlayer==CurrPlayer) 
		{
			alert('Выберите карту другого игрока');
			return 2;
		}
		var i_del = -1,v_del = -1;
	
		for (var i=0;i<PlCards[ShowPlayer].length;i++)
		{ //alert("PlCards[ShowPlayer][i]="+PlCards[ShowPlayer][i]+" CurrPLA="+CurrPLA);
			if (ctip(PlCards[ShowPlayer][i])==CurrPLA)
			{ 
				if (cval(PlCards[ShowPlayer][i])>v_del)
				{
					v_del = cval(PlCards[ShowPlayer][i]);
					i_del = i;
				}
			}
		}
		
		Urna.push(PlCards[ShowPlayer][i_del]);
		PlCards[ShowPlayer].splice(i_del,1); //alert("i_del "+i_del);
		ucmode = 0;
		Abi[CurrLA] = 1;
		CalcScore(ShowPlayer);
		CurrLA = -1;
	}
	if (ucmode==4)
	{
		var x = Math.floor(e.clientX/150);
		if (x<PlCards[ShowPlayer].length)
			CurrPLA = x;		
		alert('Выбрана карта '+x);
		if (ShowPlayer!=CurrPlayer) 
		{
			alert('Выберите карту у себя');
			return 2;
		}
		
		var i_del = -1,v_del = -1;
	
		for (var i=0;i<PlCards[ShowPlayer].length;i++)
		{ //alert("PlCards[ShowPlayer][i]="+PlCards[ShowPlayer][i]+" CurrPLA="+CurrPLA);
			if (ctip(PlCards[ShowPlayer][i])==CurrPLA)
			{ 
				if (cval(PlCards[ShowPlayer][i])>v_del)
				{
					v_del = cval(PlCards[ShowPlayer][i]);
					i_del = i;
				}
			}
		}
		var c_num = v_del*10+CurrPLA;
				
		Urna.splice(PlCards[ShowPlayer][i_del]);
		PlCards[ShowPlayer].splice(i_del,1); //alert("i_del "+i_del);
		LCards.push(cnum);
		Abi[LCards.length-1] = f_abi(ctip(LCards[LCards.length-1]));
		
		AfterMove();
		ucmode = 0;
		CalcScore(ShowPlayer);
		Abi[CurrLA] = 1;
		CurrLA = -1;
	}
	if (ucmode==5)
	{
		var x = Math.floor(e.clientX/150);
		if (x<10)
			CurrPLA = x;		
		alert('Выбрана карта '+x);
		LCards.push(AbiCards[x]);
		Abi[LCards.length-1] = f_abi(ctip(LCards[LCards.length-1]));
		ucmode = 0;
		ShowPlayer = CurrPlayer;
		Abi[CurrLA] = 1;
		
		AfterMove();
		ucmode = 0;
		CalcScore(ShowPlayer);
		Abi[CurrLA] = 1;
		CurrLA = -1;
	}	
	if (ucmode==8)
	{
		var x = Math.floor(e.clientX/150);
		if (x<10)
			CurrPLA = x;		
		alert('Выбрана карта '+x);
		if (ShowPlayer==CurrPlayer) 
		{
			alert('Выберите карту другого игрока');
			return 2;
		}
				
		var cnum = PlCards[ShowPlayer][CurrPLA];
		if (TmpArrY[ctip(cnum)]==1) 
		{
			alert('Выберите другую карту');
			return 2;
		}

		var i_del = -1,v_del = -1;
	
		for (var i=0;i<PlCards[ShowPlayer].length;i++)
		{ //alert("PlCards[ShowPlayer][i]="+PlCards[ShowPlayer][i]+" CurrPLA="+CurrPLA);
			if (ctip(PlCards[ShowPlayer][i])==CurrPLA)
			{ 
				if (cval(PlCards[ShowPlayer][i])>v_del)
				{
					v_del = cval(PlCards[ShowPlayer][i]);
					i_del = i;
				}
			}
		}
		var c_num = v_del*10+CurrPLA;		
		
		Abi[LCards.length-1] = f_abi(ctip(LCards[LCards.length-1]));		
		AfterMove();		
		ucmode = 0;
		CalcScore(ShowPlayer);
		Abi[CurrLA] = 1;
		CurrLA = -1;	
				
	}	
	
	CanvasLRefresh();
	CanvasPlRefresh();
	CurrPlayerInfoOut();
	return 0;
}


function Test1()
{
	//var tempCards = [55, 59, 14, 24, 10, 39, 46, 36, 22, 15, 47, 13, 54, 58, 33, 28, 18, 53, 40, 45, 50, 31, 12, 16, 20, 29, 21, 37, 35, 26, 34, 30, 23, 27, 56, 41, 32, 51, 43, 25, 44, 17, 38, 11, 48, 19, 57, 49, 42, 52, 0,0,0,0,0,0,0,0,0,0]
	//for (var i=0;i<60;i++)
	//	Cards[i] = tempCards[i];
	
	//LCards.push(1);
	//PlCards[0].push(2);
	//PlCards[1].push(3);
}

