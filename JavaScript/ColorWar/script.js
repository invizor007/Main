var aaMap = new Array(20);//двумерный массив цифр клеток
var aaOwner = new Array(20);//двумерный массив,0 - полностью нейтральная клетка\1 или 2 это клетка игрока
//11 или 12 значит скрыта от определенного игрока, 13 скрыта от обоих игроков

const caColor = ['#000000'/*Ч*/,'#901080'/*Ф*/,'#1010FF'/*С*/,//0-2
'#30C0C0'/*Г*/,'#60FF60'/*З*/,'#FFFF30'/*Ж*/,'#FF8020'/*О*/,//3-6
'#FF3030'/*К*/,'#FFA0A0'/*Р*/,'#FFFFFF'/*Б*/,'#808080'/*Т*/];//7-10
const aModeStr = ['-','2 игрока','Против ИИ ','Одиночный'];
const imgstr = ['0.jpg','1.jpg'];
const sz = 30, co = 20;

var imgs = [];
var aBon=[2,2];
var aScore = [1,1];
var aVal = [0,0,0,0,0];

var stage = 0, plnum = 1, hodnum = 0, acttype = 0, mode = 2, aineedhod = 0;
var bonx = 0, bony = 0, RectX = 0, RectY = 0;
var chval = 0;
var htime = 30000;

///////////Инициализация объектов///////////////

function timer()
{	
	if (stage==3) return;
	draw();
	window.setTimeout("timer();", 1000);
	htime-=1000;
	if (htime<0) newhod();
}

function aiatt()
{
	//console.log("aiatt");
	
	RectX=19;RectY=19;
	var ind = 0;
	//0 good 1 bad 2 bad 11 good 12 bad 13 bad
	while ( (check_near()||((aaOwner[RectX][RectY]!=11)&&(aaOwner[RectX][RectY]!=0)) )&&(ind<1000) )
	{
		RectX--;
		if (RectX<0) 
		{
			RectY--;
			RectX=19;
		}
		if (RectY<0) return; 
		ind++;
	}
	//console.log("ind="+ind);
	//RectX++;
	var tmpOwner = aaOwner[RectX][RectY];
	var tmpMap = aaMap[RectX][RectY];
	
	aaMap[RectX][RectY]=Math.max(tmpMap-3,0);
	aaOwner[RectX][RectY]=2;

	aBon[1]--;	
	aineedhod = 1;
}

function aiscout()
{
	//console.log("aiscout");
	RectX = Math.floor(Math.random()*20);
	RectY = Math.floor(Math.random()*20);

	if ( (hodnum<10)&&((aaOwner[16][18]==13)||(aaOwner[16][18]==12)) )
	{
		RectX=16;
		RectY=18;
	}
	else if ( (hodnum<10)&&((aaOwner[18][16]==13)||(aaOwner[18][16]==12)) )
	{
		RectX=18;
		RectY=16;
	}
	else if ( (hodnum<20)&&((aaOwner[13][18]==13)||(aaOwner[13][18]==12)) )
	{
		RectX=13;
		RectY=18;
	}
	else if ( (hodnum<20)&&((aaOwner[18][13]==13)||(aaOwner[18][13]==12)) )
	{
		RectX=18;
		RectY=13;
	}
	
	for (var one_x=-1;one_x<=1;one_x++)
		for (var one_y=-1;one_y<=1;one_y++)
		{
				if ( (RectX+one_x>=0)&&(RectX+one_x<=19)&&(RectY+one_y>=0)&&(RectY+one_y<=19) )
				{
					if  (aaOwner[RectX+one_x][RectY+one_y]==12)
					{
						aaOwner[RectX+one_x][RectY+one_y]=0;
						aineedhod = 1;
					}
						
					if (aaOwner[RectX+one_x][RectY+one_y]==13)
					{
						aaOwner[RectX+one_x][RectY+one_y]=11;
						aineedhod = 1;
					}
						
				}
		}
	
}

function aicheckbon()
{
	//console.log("aicheckbon");
	var aigoodfind = 0 , aival = 0;
	var tmp1 = 0, tmp2 = 0, tmp3 = 0;
	for (var i=0;i<20;i++)
		for (var j=0;j<20;j++)
			if (aigoodfind==0)
			{
				tmp1 = 0; tmp2 = 0; tmp3 = 0;
				if (j+1<20)
				{
					if ((aaOwner[i][j]<10)||(aaOwner[i][j]==11)) tmp1 = 1;
					if ((aaOwner[i][j+1]<10)||(aaOwner[i][j+1]==11)) tmp2 = 1;
						
					if ((tmp1==1)&&(tmp2==1))
					{
						aival=10*aaMap[i][j]+aaMap[i][j+1];
						if ((aival == aVal[0])||(aival == aVal[1])) aigoodfind = 1;
						aival=10*aaMap[i][j+1]+aaMap[i][j];
						if ((aival == aVal[0])||(aival == aVal[1])) aigoodfind = 1;						
					}
				}
				
				tmp1 = 0; tmp2 = 0; tmp3 = 0;
				if (i+1<20)
				{
					if ((aaOwner[i][j]<10)||(aaOwner[i][j]==11)) tmp1 = 1;
					if ((aaOwner[i][j+1]<10)||(aaOwner[i][j+1]==11)) tmp2 = 1;
					
					if ((tmp1==1)&&(tmp2==1))
					{
						aival=10*aaMap[i][j]+aaMap[i][j+1];
						if ((aival == aVal[0])||(aival == aVal[1])) aigoodfind = 1;
						aival=10*aaMap[i][j+1]+aaMap[i][j];
						if ((aival == aVal[0])||(aival == aVal[1])) aigoodfind = 1;	
					}
				}
					
				tmp1 = 0; tmp2 = 0; tmp3 = 0;
				if (i+2<20)
				{
					if ((aaOwner[i][j]<10)||(aaOwner[i][j]==11)) tmp1 = 1;
					if ((aaOwner[i+1][j]<10)||(aaOwner[i+1][j]==11)) tmp2 = 1;
					if ((aaOwner[i+2][j]<10)||(aaOwner[i+2][j]==11)) tmp3 = 1;
						
					if ((tmp1==1)&&(tmp2==1)&&(tmp3==1))
					{
						aival=100*aaMap[i][j]+10*aaMap[i+1][j]+aaMap[i+2][j];
						if ((aival == aVal[2])||(aival == aVal[3])||(aival == aVal[4])) aigoodfind = 2;
						aival=100*aaMap[i+2][j]+10*aaMap[i+1][j]+aaMap[i][j];
						if ((aival == aVal[2])||(aival == aVal[3])||(aival == aVal[4])) aigoodfind = 2;						
					}
				}
				
				tmp1 = 0; tmp2 = 0; tmp3 = 0;
				if (j+2<20)
				{
					if ((aaOwner[i][j]<10)||(aaOwner[i][j]==11)) tmp1 = 1;
					if ((aaOwner[i][j+1]<10)||(aaOwner[i][j+1]==11)) tmp2 = 1;
					if ((aaOwner[i][j+2]<10)||(aaOwner[i][j+2]==11)) tmp3 = 1;
						
					if ((tmp1==1)&&(tmp2==1)&&(tmp3==1))
					{
						aival=100*aaMap[i][j]+10*aaMap[i][j+1]+aaMap[i][j+2];
						if ((aival == aVal[2])||(aival == aVal[3])||(aival == aVal[4])) aigoodfind = 2;
						aival=100*aaMap[i][j+2]+10*aaMap[i][j+1]+aaMap[i][j];
						if ((aival == aVal[2])||(aival == aVal[3])||(aival == aVal[4])) aigoodfind = 2;						
					}
				}
		}
		
		

		if (aigoodfind>0)
		{
			aBon[1]+=aigoodfind;
			make_aval();
			aineedhod = 1;
		}

}



function aihod()
{
	aineedhod = 0;
	if ( (aBon[1]<=3)&&(aBon[1]+aScore[1]<15) )
		aicheckbon();
	if ((aBon[1]>0)&&(aineedhod==0))
		aiatt();
	if (aineedhod==0) 
		aiscout();
	if (aineedhod==0) 
		aiatt();	
	newhod();
}

function newhod()
{
	plnum++;
	if (plnum==3)
	{
		hodnum++;
		plnum=1;
	}
	acttype = 0;
	htime = 30000;
	if (plnum==2)
	{
		if (mode==2) aihod();
		if (mode==3) 
		{
			plnum=1;
			hodnum++;
		}
	}
	
	if (hodnum % 5 == 0)
		make_aval();
	make_ascore();
}

function check_near()
{
	for (var i=-1;i<=1;i++)
		for (var j=-1;j<=1;j++)
			if ((RectX+i>=0)&&(RectX+i<co)&&(RectY+j>=0)&&(RectY+j<co))
			{
				var tmpOwner = aaOwner[RectX+i][RectY+j];
				if (tmpOwner==plnum)
					return false;
			}
	return true;
}

function ImagesInit()
{
  for (var i=0;i<imgstr.length;i++)
  {
    var tmp = new Image();
    tmp.src = imgstr[i];
    imgs.push(tmp);
  } 
}

function init_game()
{
	for (var i=0;i<co;i++)
	{
		aaMap[i] = new Array(co);
		for (var j=0;j<co;j++)
			aaMap[i][j] = 1+Math.floor(8*Math.random());
	}
	aaMap[0][0]=9;
	aaMap[co-1][co-1]=0;
	
	for (var i=0;i<co;i++)
	{
		aaOwner[i] = new Array(co);
		for (var j=0;j<co;j++)
			aaOwner[i][j] = 13;
	}
	aaOwner[0][0]=1;
	aaOwner[19][19]=2;
	
	aaOwner[0][1]=12;
	aaOwner[1][0]=12;
	aaOwner[1][1]=12;
	aaOwner[19][18]=11;
	aaOwner[18][19]=11;
	aaOwner[18][18]=11;
	
	make_aval();
}

function restart_game()
{
	for (var i=0;i<co;i++)
		for (var j=0;j<co;j++)
			aaMap[i][j] = 1+Math.floor(8*Math.random());
	aaMap[0][0]=9;
	aaMap[co-1][co-1]=0;
	
	for (var i=0;i<co;i++)
		for (var j=0;j<co;j++)
			aaOwner[i][j] = 13;
	aaOwner[0][0]=1;
	aaOwner[19][19]=2;
	
	aaOwner[0][1]=12;
	aaOwner[1][0]=12;
	aaOwner[1][1]=12;
	aaOwner[19][18]=11;
	aaOwner[18][19]=11;
	aaOwner[18][18]=11;
	
	make_aval();
}

function make_aval()
{
	aVal[0] = Math.floor(Math.random()*90)+10;
	aVal[1] = Math.floor(Math.random()*90)+10;
	if (aVal[0]==aVal[1])
	{
		aVal[1]++;
		if (aVal[1]==100)
			aVal[1]=10;
	}
	aVal[2] = Math.floor(Math.random()*900)+100;
	aVal[3] = Math.floor(Math.random()*900)+100;
	if (aVal[3]==aVal[2])
	{	
		aVal[3]++;
		if (aVal[3]==1000)
			aVal[3]=101;
	}
	
	aVal[4] = Math.floor(Math.random()*900)+100;
	if ((aVal[4]==aVal[2])||(aVal[4]==aVal[3]))
	{
		aVal[4]=(aVal[2]+aVal[3]) % 1000;
	}
}

function make_ascore()
{
	aScore[0] = 0;
	aScore[1] = 0;
	for (var i=0;i<co;i++)
		for (var j=0;j<co;j++)
		{
			if (aaOwner[i][j]==1) aScore[0]++;
			if (aaOwner[i][j]==2) aScore[1]++;
		}
		
	if (aScore[0]>=15)
	{
		stage=3;
		draw();
		alert("Игрок номер 1 выиграл. Начните новую игру");
		return;
	}
	if (aScore[1]>=15)
	{
		stage=3;
		draw();
		alert("Игрок номер 2 выиграл. Начните новую игру");
		return;
	}
}

function make_rectxy(clientX,clientY)
{
	RectX = Math.floor((clientX-200)/sz);
	RectY = Math.floor((clientY-60)/sz);	
}


//----------------------------DRAW

function draw()
{
	if (stage==0)
	{
		ImagesInit();
		init_game();
		stage = 1;
	}

	var cnv = document.getElementById("canvas1");
	var ctx = cnv.getContext("2d");
	ctx.fillStyle = 'white';
	ctx.fillRect(0,0,600,600);
	
	//Рисуем карту
	for (var i=0;i<co;i++) for (var j=0;j<co;j++)
	{
		var num = aaMap[i][j];
		var own = aaOwner[i][j];
		var klz = 0;
		if ((own==13)||(own==10+plnum))
			klz = 1;
		
		if (klz==0) ctx.fillStyle = caColor[num]; else ctx.fillStyle = 'gray';
		ctx.fillRect(i*sz,j*sz,sz,sz);
		
		ctx.font = '10px Arial';
		if ((num==0)&&(klz==0))
		{
			ctx.fillStyle = 'white';
			ctx.fillRect(i*sz+5,j*sz+3,12,12);
		}

		ctx.strokeStyle = '000000';
		if (klz==0)
			ctx.strokeText(num+"",i*sz+10,j*sz+10);
	}
	
	ctx.lineWidth = 3;
	ctx.fillStyle = '9090FF';
	ctx.strokeStyle = '9090FF';
	for (var i=0;i<co;i++) for (var j=0;j<co;j++)
		if (aaOwner[i][j]==1)
			ctx.strokeRect(i*sz,j*sz,sz,sz);
	
	
	ctx.strokeStyle = '9090FF';
	ctx.fillStyle = '9090FF';
	for (var i=0;i<co;i++) for (var j=0;j<co;j++)
		if (aaOwner[i][j]==2)
			ctx.strokeRect(i*sz,j*sz,sz,sz);
	
	ctx.lineWidth = 1;
	
	//canvas2 
	var cnv2 = document.getElementById("canvas2");
	var ctx2 = cnv2.getContext("2d");
	ctx2.fillStyle = 'gray';
	ctx2.fillRect(0,0,1000,50);
	
	if ((stage==2)||(stage==3))
	{
		ctx2.fillStyle = 'yellow';
		ctx2.fillRect(0,0,160,50);
		ctx2.fillRect(200,0,160,50);
		ctx2.fillRect(400,0,160,50);
		if (stage==2)
			ctx2.fillRect(600,0,160,50);
		
		ctx2.fillStyle = 'green';
		ctx2.fillText(aModeStr[1],10,30);
		ctx2.fillText(aModeStr[2],210,30);
		ctx2.fillText(aModeStr[3],410,30);
		if (stage==2)
			ctx2.fillText('Отмена',610,30);
	}
	else
	{
	ctx2.strokeStyle = 'green';
	ctx2.fillStyle = 'green';
	ctx2.font = 'bold 18px Arial';
	ctx2.fillText('Числа для поиска: '+aVal[0]+' '+aVal[1]+' '+aVal[2]+' '+aVal[3]+' '+aVal[4],50,20);
	ctx2.fillText('Ход №'+(hodnum+1)+'. Ходит игрок '+plnum+'. Осталось времени '+(htime/1000),50,40);
	ctx2.fillText('Режим '+aModeStr[mode],550,20);
	ctx2.fillText('Счет '+aScore[0]+' VS '+aScore[1],550,40);
	
	ctx2.fillStyle = 'yellow';
	ctx2.fillRect(740,0,120,50);
	ctx2.fillStyle = 'green';
	ctx2.fillText('Новая игра ',750,30);
	}

	//canvas 11
	var cnv11 = document.getElementById("canvas11");
	var ctx11 = cnv11.getContext("2d");	
	ctx11.strokeStyle = 'red';
	
	if ((acttype==1)&&(plnum==1)) ctx11.fillStyle = 'green';else ctx11.fillStyle = 'yellow'; 
	ctx11.fillRect(0,0,180,100);
	ctx11.strokeRect(0,0,180,100);
	
	if ((acttype==2)&&(plnum==1)) ctx11.fillStyle = 'green';else ctx11.fillStyle = 'yellow'; 
	ctx11.fillRect(0,100,180,100);
	ctx11.strokeRect(0,100,180,100);
	
	if ((acttype==3)&&(plnum==1)) ctx11.fillStyle = 'green';else ctx11.fillStyle = 'yellow'; 
	ctx11.fillRect(0,200,180,100);
	ctx11.strokeRect(0,200,180,100);
	
	ctx11.font = 'bold 24px Arial';
	ctx11.strokeText("Атака",60,60);
	ctx11.strokeText("Разведка",45,160);
	ctx11.strokeText("Сбор монет",20,260);
	
	ctx11.fillStyle = 'gray';
	ctx11.fillRect(0,300,200,70);ctx11.strokeRect(0,300,200,70);
	ctx11.font = 'bold 16px Arial';
	ctx11.fillStyle = 'red';
	ctx11.fillText("Количество монет "+aBon[0],10,330);
	
	ctx11.drawImage(imgs[0],0,370);
	
	//canvas 12
	var cnv12 = document.getElementById("canvas12");
	var ctx12 = cnv12.getContext("2d");	
	ctx12.strokeStyle = 'red';
	
	if ((acttype==1)&&(plnum==2)) ctx12.fillStyle = 'green';else ctx12.fillStyle = '#2020A0';
	ctx12.fillRect(0,0,180,100);
	ctx12.strokeRect(0,0,180,100);
	
	if ((acttype==2)&&(plnum==2)) ctx12.fillStyle = 'green';else ctx12.fillStyle = '#2020A0';
	ctx12.fillRect(0,100,180,100);
	ctx12.strokeRect(0,100,180,100);
	
	if ((acttype==3)&&(plnum==2)) ctx12.fillStyle = 'green';else ctx12.fillStyle = '#2020A0';
	ctx12.fillRect(0,200,180,100);
	ctx12.strokeRect(0,200,180,100);
	
	ctx12.font = 'bold 24px Arial';
	ctx12.strokeText("Атака",60,60);
	ctx12.strokeText("Разведка",45,160);
	ctx12.strokeText("Сбор монет",20,260);	
	
	ctx12.fillStyle = 'gray';
	ctx12.fillRect(0,300,180,70);ctx12.strokeRect(0,300,180,70);
	ctx12.font = 'bold 16px Arial';
	ctx12.fillStyle = 'red';
	ctx12.fillText("Количество монет "+aBon[1],10,330);
	ctx12.drawImage(imgs[1],0,370);
}


//----------------------------MOUSE
function mousedown1(e)
{
	make_rectxy(e.pageX,e.pageY);
	
	if  (acttype==3)
	{
		//bonus
		bonx = RectX;
		bony = RectY;		
	}

}

function mouseup1(e)
{
	make_rectxy(e.pageX,e.pageY);
	if  (acttype==1)
	{
		//attack
		if ((RectX<0)||(RectX>19)) return;
		if ((RectY<0)||(RectY>19)) return;
		if (aBon[plnum-1]==0)
		{
			alert("Для атаки нужны бонусы");
			return;
		}
		if (check_near())
		{
			alert("Атаковать можно только клетку рядом с вашей территорией");
			return;
		}
		var tmpOwner = aaOwner[RectX][RectY];
		var tmpMap = aaMap[RectX][RectY];
		if ((tmpOwner==13)||(tmpOwner==10+plnum)) return;
		
		if (plnum==1)
		{
			aaMap[RectX][RectY]=Math.min(tmpMap+3,9);
			aaOwner[RectX][RectY]=1;
		}	
		if (plnum==2)
		{
			aaMap[RectX][RectY]=Math.max(tmpMap-3,0);
			aaOwner[RectX][RectY]=2;
		}
		aBon[plnum-1]--;
		newhod();
		{}
	}
	if  (acttype==2)
	{
		//see
		for (var one_x=-1;one_x<=1;one_x++)
			for (var one_y=-1;one_y<=1;one_y++)
			{
				if ( (RectX+one_x>=0)&&(RectX+one_x<=19)&&(RectY+one_y>=0)&&(RectY+one_y<=19) )
				{
					if  (aaOwner[RectX+one_x][RectY+one_y]==10+plnum)
						aaOwner[RectX+one_x][RectY+one_y]=0;
					if (aaOwner[RectX+one_x][RectY+one_y]==13)
						aaOwner[RectX+one_x][RectY+one_y]=13-plnum;
				}
			}
		newhod(); 
		
	}
	if  (acttype==3)
	{//bonus
		if ((RectX==bonx)&&(RectY==bony))
		{
			chval = aaMap[bonx][bony];
			return;
		}
		
		if ((RectX!=bonx)&&(RectY!=bony))
		{
			chval = 0;
			return;
		}		
		
		if (Math.abs(bony-RectY)>=3) return;
		if (Math.abs(bonx-RectX)>=3) return;
		
		//console.log("RectX "+RectX);console.log("bonx "+bonx);
		//console.log("RectY "+RectY);console.log("bony "+bony);
		var one_x = 0, one_y = 0;
		chval = aaMap[bonx][bony];
		if (RectX==bonx)
		{
			if (bony>RectY) one_y=-1; else one_y=1;
			
			var moving_bony=bony;
			while (moving_bony!=RectY)
			{
				moving_bony+=one_y;
				chval=10*chval+aaMap[bonx][moving_bony];
			}	
		}
		if (RectY==bony)
		{
			if (bonx>RectX) one_x=-1; else one_x=1;
			var moving_bonx=bonx;
			while (moving_bonx!=RectX)
			{
				moving_bonx+=one_x;
				chval=10*chval+aaMap[moving_bonx][bony];
			}
		}
		var goodfind = 0;
		for (var i=0;i<=1;i++)
			if (chval==aVal[i]) goodfind = 1;
		for (var i=2;i<=4;i++)
			if (chval==aVal[i]) goodfind = 2;

		if (goodfind>0)
		{
			aBon[plnum-1]+=goodfind;
			make_aval();
			newhod();			
		}

	}

}

function c2click(e)
{
	var nrt = 0;
	if ((e.clientX>=740)&&(e.clientX<=860)&&(e.clientY>=0)&&(e.clientY<=50)&&(stage==1))
	{
		stage = 2; 
	}
	
	if ((e.clientX>=0)&&(e.clientX<=160)&&(e.clientY>=0)&&(e.clientY<=50)&&((stage==2)||(stage==3)))
	{
		if (stage==3) nrt = 1;
		mode = 1;
		newgame(nrt);
	}
	if ((e.clientX>=200)&&(e.clientX<=360)&&(e.clientY>=0)&&(e.clientY<=50)&&((stage==2)||(stage==3)))
	{
		if (stage==3) nrt = 1;
		mode = 2;
		newgame(nrt);
	}
	if ((e.clientX>=400)&&(e.clientX<=560)&&(e.clientY>=0)&&(e.clientY<=50)&&((stage==2)||(stage==3)))
	{
		if (stage==3) nrt = 1;
		mode = 3;
		newgame(nrt);
	}
	if ((e.clientX>=600)&&(e.clientX<=760)&&(e.clientY>=0)&&(e.clientY<=50)&&(stage==2))
	{
		stage = 1;
		draw();
	}
}

function c11click(e)
{
	if (plnum!=1) return;
	var y = Math.floor((e.clientY-60)/100);
	if ((y>=0)&&(y<=2))
		acttype = y+1;
}

function c12click(e)
{
	if (plnum!=2) return;
	var y = Math.floor((e.clientY-60)/100);
	if ((y>=0)&&(y<=2))
		acttype = y+1;
}

//NEWGAME

function newgame(nrt)
{
	aBon[0]=2;
	aBon[1]=2;
	stage = 1;
	plnum = 1;
	hodnum = 0;
	acttype = 0;
	bonx = 0; 
	bony = 0; 
	RectX = 0; 
	RectY = 0;
	aScore[0]=1;
	aScore[1]=1;
	chval = 0;
	htime = 30000;
	restart_game();
	if (nrt == 1) timer();
}

window.addEventListener("load",draw,true);
