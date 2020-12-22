var StsWidth = [4,6,8];
var StsRounds = [8,12,16];
var StsSkip = [ [4,5],[3,4,9,10],[5,6,9,10] ];
var StsPlC = [2,3,4];
var StsDiv = [150,100,75];
var StsScore = [1,1,1,2,4,6,9,12];

var Matr = [];

var CurrPl=1,CurrH=1,CurrCo=0,CurrD=1;
var PlCount,StsInd;
var Score = [0,0,0,0];

function qq(s)
{
	alert(s);
}

function GameInit()
{
	for (var i = 0; i < 8; i++)
	{
		Matr[i] = [];
		for (var j = 0; j < 8; j++)
		{
			Matr[i][j]=0;
		}
	}
	document.getElementById("cnv1").addEventListener('mousedown', ApplyClick, false);
	var ctx=document.getElementById("cnv1").getContext("2d");
	ctx.fillStyle='#8080FF';
	ctx.strokeStyle = '#000000';
	ctx.fillRect(0,0,599,599);
}

function DrawLines()
{
	var ctx=document.getElementById("cnv1").getContext("2d");
	ctx.fillStyle='#8080FF';
	ctx.strokeStyle = '#000000';
	ctx.fillRect(0,0,599,599);
	ctx.fill();
	
	for (var i = 1; i< StsWidth[StsInd]; i++)
	{
		ctx.moveTo(i*StsDiv[StsInd],0);
		ctx.lineTo(i*StsDiv[StsInd],599);
	}
	for (var i = 1; i< StsWidth[StsInd]; i++)
	{
		ctx.moveTo(0,i*StsDiv[StsInd]);
		ctx.lineTo(599,i*StsDiv[StsInd]);
	}
	ctx.stroke();
}

function DrawDigits()
{
	DrawLines();
	var ctx=document.getElementById("cnv1").getContext("2d");
	ctx.fillStyle='#000000';
	ctx.font="italic bold 18px arial"
	for (var i = 0; i < StsWidth[StsInd]; i++)
	{
		for (var j = 0; j < StsWidth[StsInd]; j++)
		{
			ctx.fillText(Matr[i][j]+"",j*StsDiv[StsInd]+30,i*StsDiv[StsInd]+40);
		}
	}
	ctx.stroke();
}


function GameStart()
{
	GameInit();

	var value = document.getElementById("ChoosePlayerCount").value;
	PlCount = Number(value);

	if ((PlCount < 2) || (PlCount > 4))
	{
		alert("Введите число от 2 до 4");
		return;
	} 

	StsInd = PlCount - 2;
	DrawDigits();
	OutMainInfo();
	alert("Игра начинается");
}

function ChangeHod()
{
	CurrPl++;
	CurrCo++;
	if (CurrPl>PlCount)
	{
		CurrPl=1;
		CurrH++;
	}
	if (CurrH in StsSkip[StsInd])
	{
		CurrD = (CurrPl % PlCount) + 1;
	}
	else
	{
		CurrD = CurrPl;
	}
}

function OutMainInfo()
{
	document.getElementById("LabelCurrH").innerHTML='Ход номер: '+CurrH;
	document.getElementById("LabelCurrPl").innerHTML='Игрок номер: '+CurrPl;
	document.getElementById("LabelCurrD").innerHTML='Ставится цифра: '+CurrD;
	document.getElementById("LabelCurrCo").innerHTML='Установлено цифр: '+CurrCo;
}

function ApplyClick(e)
{
	var j=Math.floor((e.clientX-10)/StsDiv[StsInd]);
	var i=Math.floor((e.clientY-60)/StsDiv[StsInd]); 
	if (Matr[i][j]>0) {return;}
	Matr[i][j] = CurrD;
	
	DrawDigits();
	ChangeHod();
	
	OutMainInfo();
	OutScoreInfo();
}

function CalcScore()
{
	//Prepare
	for (var i = 0; i < 4; i++)
	{
		Score[i] = 0;
	}
	for (var i = 0; i < StsWidth[StsInd]; i++)
	{
		for (var j = 0; j < StsWidth[StsInd]; j++)
		{
			Matr[i][j] = Matr[i][j] % 10;
		}
	}	
	//Vertical
	for (var i = 0; i < StsWidth[StsInd]; i++)
	{
		for (var j = 0; j < StsWidth[StsInd] - 1; j++)
		{
			if ( (Matr[i][j]==Matr[i][j+1]) && (Matr[i][j]>0) && (Matr[i][j]<5) )
			{
				var CalcPl = Matr[i][j];
				var lsize = 0;
				while (Matr[i][j+lsize]==CalcPl)
				{
					Matr[i][j+lsize]+=10;
					lsize++;
				}
				Score[CalcPl-1]+=StsScore[lsize];
				
			}
		}
	}
	
	//Horizontal
	for (var i = 0; i < StsWidth[StsInd] - 1; i++)
	{
		for (var j = 0; j < StsWidth[StsInd]; j++)
		{
			if ( (Matr[i][j]==Matr[i+1][j]) && (Matr[i][j]>0) && (Matr[i][j]<5) )
			{
				var CalcPl = Matr[i][j];
				var lsize = 0;
				while (Matr[i+lsize][j]==CalcPl)
				{
					Matr[i+lsize][j]+=10;
					lsize++;
				}
				Score[CalcPl-1]+=StsScore[lsize];
				
			}
		}
	}	
}


function OutScoreInfo()
{
	CalcScore();
	document.getElementById("LabelSco1").innerHTML='Очки игрок 1: '+Score[0];
	document.getElementById("LabelSco2").innerHTML='Очки игрок 2: '+Score[1];
	document.getElementById("LabelSco3").innerHTML='Очки игрок 3: '+Score[2];
	document.getElementById("LabelSco4").innerHTML='Очки игрок 4: '+Score[3];
	DrawDigits();
}

