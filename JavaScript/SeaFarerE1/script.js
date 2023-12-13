var imgstr = ['img/0.jpg','img/1.png','img/2.png','img/3.png','img/4.png','img/5.png','img/6.png','img/7.png','img/8.png','img/9.png','img/10.png','img/11.png','img/12.png','img/13.png','img/14.png'];
var imgx = [800,40,64,32,49,150,150,150,150,75,75,75,75];
var imgy = [600,40,64,24,49,150,150,150,150,75,75,75,75];
var imgs = [];
var youx = 100, youy = 400;
var youstepx=4,youstepy=3;
var youmovex=0,youmovey=0;

var objwreckage = [], objgold = [], objtavern = [], objmine = [], objprison = [];
var gold = 0,incgold = 0;
var exp = 0;
var stage = 0;
var glev = 1, mlev = 5;
var actions_curr = 0, actions_max = 4, actions_avail = 4;
var visittype = 0, showtime = 0;
var isbattle = 0,isbuy = 0, isprepbattle = 0;

var stagedata = [];

var currunit = 0;
var armycost = [27,24,20,25];
var army = [0,0,0,0];//массив количество определенных отрядов (канониры, матросы, защитники, далее урон пушки)
var enemyarmy = [0,0,0,0];
var resthp = [20,20,20,50];
var restehp = [20,20,20,50];
var hpexample = [20,20,20,50];
var dmgbonus = [2,0,1,-1];
var visitbonus = 0, wreckageindex = 0, mineindex = 0, prisonindex = 0;
var battempunit = 0,battempenemy = 0, batuinfo=-1;
var armystr = ['Канониры','Матросы','Защитники','Пушка'];

//Здания
//1 - обломки кораблекрушения - сражение, за победу сокровища
//2 - золото - сокровища без охраны
//3 - таверна - обмен
//4 - шахта - армия в обмен на золото
//5 - тюрьма - сражение и в награду армия

///////////Инициализация объектов///////////////

function init_objects()
{
	//номер уровня, номер объекта, x_координата, y_координата
	stagedata = JSON.parse(data);
	//alert(stagedata[0].lev);
}

function init_startarmy()
{
	army[0] = 3; //канонир
	army[1] = 3; //матрос
	army[2] = 5; //защитник
	army[3] = 20;//пушка
	//Здоровье у пушки 50, у других 20. Урон 3-4. Преимущество матрос против канонира, защитник против матроса, канонир против защитника
}

function init_objwreckage()
{
	for (var i=0;i<stagedata.length;i++)
	{
		if ((stagedata[i].lev==glev)&&(stagedata[i].num==1))
		{
			var tmp = {};
			tmp.x = parseInt(stagedata[i].x);
			tmp.y = parseInt(stagedata[i].y);
			objwreckage.push(tmp);
		}
	}
}

function init_objgold()
{
	for (var i=0;i<stagedata.length;i++)
	{
		if ((stagedata[i].lev==glev)&&(stagedata[i].num==2))
		{
			var tmp = {};
			tmp.x = parseInt(stagedata[i].x);
			tmp.y = parseInt(stagedata[i].y);
			objgold.push(tmp);
		}
	}	
}

function init_objtavern()
{	
	for (var i=0;i<stagedata.length;i++)
	{
		if ((stagedata[i].lev==glev)&&(stagedata[i].num==3))
		{
			var tmp = {};
			tmp.x = parseInt(stagedata[i].x);
			tmp.y = parseInt(stagedata[i].y);
			objtavern.push(tmp);
		}
	}		
}

function init_objmine()
{	
	for (var i=0;i<stagedata.length;i++)
	{
		if ((stagedata[i].lev==glev)&&(stagedata[i].num==4))
		{
			var tmp = {};
			tmp.x = parseInt(stagedata[i].x);
			tmp.y = parseInt(stagedata[i].y);
			objmine.push(tmp);
		}
	}		
}

function init_objprison()
{	
	for (var i=0;i<stagedata.length;i++)
	{
		if ((stagedata[i].lev==glev)&&(stagedata[i].num==5))
		{
			var tmp = {};
			tmp.x = parseInt(stagedata[i].x);
			tmp.y = parseInt(stagedata[i].y);
			objprison.push(tmp);
		}
	}		
}

function calc_actions_max()
{
	actions_max=0;
	for (var i=0;i<stagedata.length;i++)
	{
		if (stagedata[i].lev==glev) actions_max++;
	}
}

///////////Посещение объектов///////////////
function check_wreckage(i)
{
	var x1 = youx, y1 = youy;
	var x2 = objwreckage[i].x, y2 = objwreckage[i].y;
	var r = 0, d = 0;
	
	if ( (x2+imgx[2]>x1)&&(x1+imgx[1]>x2)&&(y2+imgy[2]>y1)&&(y1+imgy[1]>y2) )
	{
		visittype = 1;
		//actions_curr++;
		wreckageindex = i;
		youmovex = 0; 
		youmovey = 0;
		isprepbattle = 1;

		visitbonus = 10;
		for (var i=0;i<3;i++)
		{
			enemyarmy[i] = 1+Math.floor(3*Math.random());
			visitbonus+=10*enemyarmy[i];
		}
		enemyarmy[3] = 10;
		for (var i=0;i<3;i++)
		{
			resthp[i] = hpexample[i];
			restehp[i] = hpexample[i];
		}
	}
}

function check_gold(i)
{
	var x1 = youx, y1 = youy;
	var x2 = objgold[i].x, y2 = objgold[i].y;
	
	if ( (x2+imgx[3]>x1)&&(x1+imgx[1]>x2)&&(y2+imgy[3]>y1)&&(y1+imgy[1]>y2) )
	{
		incgold = 50+Math.floor(25*Math.random());
		gold+=incgold;
		visittype = 2;
		objgold.splice(i,1);
		actions_curr++;
		showtime = 30;
	}
	
}

function check_tavern(i)
{
	var x1 = youx, y1 = youy;
	var x2 = objtavern[i].x, y2 = objtavern[i].y;
	if (gold<50) return;
	
	if ( (x2+imgx[4]>x1)&&(x1+imgx[1]>x2)&&(y2+imgy[4]>y1)&&(y1+imgy[1]>y2) )
	{
		visittype = 3;
		currunit = Math.floor(4*Math.random(4));
		objtavern.splice(i,1);
		//actions_curr++;
		isbuy = 1;
		youmovex = 0; 
		youmovey = 0;
	}
	
	return 0;
}

function check_mine(i)
{
	var x1 = youx, y1 = youy;
	var x2 = objmine[i].x, y2 = objmine[i].y;
	var r = 0, d = 0;
	
	if ( (x2+imgx[2]>x1)&&(x1+imgx[1]>x2)&&(y2+imgy[2]>y1)&&(y1+imgy[1]>y2) )
	{
		visittype = 4;
		//actions_curr++;
		mineindex = i;
		youmovex = 0; 
		youmovey = 0;

		visitbonus = 11;
	}
	
	return 0;
}

function check_prison(i)
{
	var x1 = youx, y1 = youy;
	var x2 = objprison[i].x, y2 = objprison[i].y;
	var r = 0, d = 0;
	
	if ( (x2+imgx[2]>x1)&&(x1+imgx[1]>x2)&&(y2+imgy[2]>y1)&&(y1+imgy[1]>y2) )
	{
		visittype = 5;
		//actions_curr++;
		prisonindex = i;
		youmovex = 0; 
		youmovey = 0;
		isprepbattle = 1;

		visitbonus = 10;
		for (var i=0;i<3;i++)
		{
			enemyarmy[i] = 1+Math.floor(3*Math.random());
			visitbonus+=10*enemyarmy[i];
		}
		enemyarmy[3] = 10;
		for (var i=0;i<3;i++)
		{
			resthp[i] = hpexample[i];
			restehp[i] = hpexample[i];
		}
	}
	
}

///////////Перемещение///////////////


function move_you(e)
{ //console.log("A1");
	if (isbattle>0) return;
	if (isbuy>0) return;
	if (isprepbattle>0) return;
	
	if (e.keyCode==37)
		{youmovex = -1; youmovey = 0;}
	if (e.keyCode==39)
		{youmovex = 1; youmovey = 0;}
		
	if (e.keyCode==38)
		{youmovex = 0; youmovey = -1;}
	if (e.keyCode==40)
		{youmovex = 0; youmovey = 1;}
	
	if (e.keyCode==32)
		{youmovex = 0; youmovey = 0; /*console.log("AAA");*/}
	
}

function timer()
{
	if (youx >= 800-5-imgx[1])
		{ youmovex = -1; youmovey = 0; }
	if (youx <= 0+5)
		{ youmovex = 1; youmovey = 0; }
	if (youy >= 600-5-imgy[1])
		{ youmovey = -1; youmovex = 0; }
	if (youy <= 5)
		{ youmovey = 1; youmovex = 0; }

	youx += youmovex*youstepx;
	youy += youmovey*youstepy;
	
	if (showtime>0)
	{
		showtime--;
		if (showtime==0) visittype = 0;
	}

	document.onkeydown = move_you;
	draw();
	if (stage < 3)
	{
		window.setTimeout("timer();", 20);
	}
	
	if ((isbuy==0)&&(isbattle==0)&&(isprepbattle==0))
	{
		for (var i=0;i<objwreckage.length;i++)
			check_wreckage(i);
	
		for (var i=0;i<objgold.length;i++)
			check_gold(i);
	
		for (var i=0;i<objtavern.length;i++)
			check_tavern(i);	

		for (var i=0;i<objmine.length;i++)
			check_mine(i);

		for (var i=0;i<objprison.length;i++)
			check_prison(i);		
	}


	if (actions_curr==actions_avail)
	{//alert("glev="+glev);alert("mlev="+mlev);
		if (glev==mlev)
		{
			stage=3; 
			var score=exp+gold;
			alert('Вы прошли игру. Счет '+score);
		}
		else
		{
			stage = 2;
			glev++;
			actions_curr = 0;
			youx = 100;
			youy = 400;
			
			objwreckage = [];
			objgold = [];
			objtavern = [];
			objmine = [];
			objprison = [];
		}
	}	
}

///////////Дополнение///////////////

function ImagesInit()
{
  for (var i=0;i<=14;i++)
  {
    var tmp = new Image();
    tmp.src = imgstr[i];//i+".png";
    imgs.push(tmp);
  }
}

function Action1Click(e)
{
	//alert(e.clientX+' '+e.clientY);
	if ( (e.clientX>=810)&&(e.clientX<=860) && (e.clientY>=625)&&(e.clientY<=743) )
	{
		//Да
		if (visittype==1)
		{
			visittype = 11;
			isbattle = 1;
			isprepbattle = 0;
			battempenemy = 0;
			battempunit = 0;
		}

		if (visittype==3)
		{
			gold-=armycost[currunit];
			if (currunit==3) {army[currunit]+=10;}
			else {army[currunit]++;}
			visittype = 13;
			//showtime = 30;
			isbuy = 0;
			actions_curr++;
		}

		if (visittype==4)
		{
			gold+=50;
			currunit = Math.floor(Math.random()*3);
			army[currunit]--;
			if (army[currunit]<0) 
			{
				army[currunit]=0;
				gold-=50;
			}
				
			visittype = 14;
			showtime = 30;
			isbuy = 0;
			actions_curr++;
			objmine.splice(mineindex,1);
		}	

		if (visittype==5)
		{
			visittype = 15;
			isbattle = 1;
			isprepbattle = 0;
			battempenemy = 0;
			battempunit = 0;
		}		
	}
	if ( (e.clientX>=870)&&(e.clientX<=920) && (e.clientY>=625)&&(e.clientY<=743) )
	{ 
		//Нет
		if (visittype==1)
		{
			visittype = 0;
			isbattle = 0;
			isprepbattle = 0;
			actions_curr++;			
			objwreckage.splice(wreckageindex,1);
		}
		
		if (visittype==3)
		{
			visittype = 0;
			isbuy = 0;
			actions_curr++;
		}
		
		if (visittype==4)
		{
			visittype = 0;
			isbuy = 0;
			actions_curr++;
			objmine.splice(mineindex,1);
		}
		
		if (visittype==5)
		{
			visittype = 0;
			isbuy = 0;
			isprepbattle = 0;
			isbattle = 0;
			actions_curr++;
			objprison.splice(prisonindex,1);
		}
		

	}
}

function Action2Click(e)
{
	//alert(e.clientX+' '+e.clientY);
	
	if ((e.clientX>=1060+75)&&(e.clientX<1060+150))
	{
		var unum = Math.floor((e.clientY-50)/75);
		if ((unum>=0)&&(unum<=3))
		{
			if (enemyarmy[unum]<=0)
			{
				alert('Юнитов уже нет. Выберите другую цель');
				return;
			}
			
			var dmg = 0;
			//рассчитываем урон
			if (battempunit==3)
			{
				dmg = army[3];//+army[0];
			}
			else
			{
				dmg = 3*army[battempunit]+Math.floor(1*army[battempunit]);
			}
			if ( dmgbonus[battempunit]==battempenemy )
			{
				dmg = Math.round(dmg*1.5);
			}
			alert('Вы наносите урон '+dmg);
			
			restehp[battempenemy] -= dmg;
			while (restehp[battempenemy]<=0)
			{
				restehp[battempenemy]+=hpexample[battempenemy];
				if (battempenemy==3)
				{
					enemyarmy[battempenemy]=0;
				}
				else
				{
					enemyarmy[battempenemy]--;
				}
				if (enemyarmy[battempenemy]<0)
					enemyarmy[battempenemy] = 0;
			}
			//alert(enemyarmy[battempunit]);
			//Ход компьютера
			
			if (enemyarmy[battempunit]>0)
			{

				if (battempunit==3)
				{
					dmg = enemyarmy[3];//+enemyarmy[0];
				}
				else
				{
					dmg = 3*enemyarmy[battempunit]+Math.floor(1*enemyarmy[battempunit]);
				}
				
				var enemychoose = Math.floor(4*Math.random());//3 without cannon | 4 with cannon
				
				while ( (army[enemychoose]==0)&&(enemychoose!=battempunit) )
				{
					enemychoose--;
					if (enemychoose == -1) enemychoose = 3;
				}
				
				if ( dmgbonus[battempunit]==enemychoose )
				{
					dmg = Math.round(dmg*1.5);
				}
				alert('Враг наносит урон '+dmg);
			
				resthp[enemychoose] -= dmg;
				while (resthp[enemychoose]<=0)
				{
					resthp[enemychoose]+=hpexample[enemychoose];
					if (enemychoose==3)
					{
						army[enemychoose]=0;
					}
					else
					{
						army[enemychoose]--;
					}
					if (army[enemychoose]<0)
						army[enemychoose] = 0;
				}
		
			}

			//Проверка на окончание битвы
			if (enemyarmy[0]+enemyarmy[1]+enemyarmy[2]==0) 
			{
				isbattle = 0;
				actions_curr++;
				
				if (visittype==11)
				{
					gold+=visitbonus;
					exp+=visitbonus;
					objwreckage.splice(wreckageindex,1);					
				}
				if (visittype==15)
				{
					currunit = Math.floor(Math.random()*3);
					army[currunit]++;
					objprison.splice(prisonindex,1);					
				}
				
				alert('Вы побеждаете в сражении и получаете бонусы');
				visittype = 0;
				if (army[3]==0)
					army[3]=10;
			}
			if (army[0]+army[1]+army[2]==0)
			{
				isbattle = 2;
				stage = 3;
				alert('Вы проиграли. Начните игру заново');
			}

			//Переход хода к другому юниту
			battempunit++;
			if (battempunit==4) battempunit=0;
			
		}
	}
}

function Action2Move(e)
{
	if (isbattle == 0)
	{
		battempenemy = 0;
		battempunit = 0;
		batuinfo = 0;
	}
	else
	{
		if ((e.clientX>=1060)&&(e.clientX<1060+75))
		{
			batuinfo = Math.floor((e.clientY-50)/75);
		}
		if ((e.clientX>=1060+75)&&(e.clientX<1060+150))
		{
			battempenemy = Math.floor((e.clientY-50)/75);
		}
	}
}

///////////Отрисовка///////////////

function draw()
{
	if (stage==0) 
	{
		ImagesInit();
		init_objects();
		
		init_objwreckage();
		init_objgold();
		init_objtavern();
		init_objmine();
		init_objprison();
		
		init_startarmy();
		calc_actions_max();
		stage = 1;
	}
	
	if (stage==2) 
	{
		init_objects();
		
		init_objwreckage();
		init_objgold();
		init_objtavern();
		init_objmine();
		init_objprison();
		
		calc_actions_max();
		stage = 1;
	}
	
	//Canvas1
	var cnv = document.getElementById("canvas1");
	var ctx = cnv.getContext("2d");
	
	var offsx = 0, offsy = 0;
	if (youmovex==-1) {offsy=40;}
	if (youmovey==-1) {offsx=80;}
	if (youmovey==1) {offsy=40; offsx=80;}
	
	ctx.drawImage(imgs[0],0,0);
	ctx.drawImage(imgs[1],offsx,offsy,40,40,youx,youy,40,40);
	
	for (var i=0;i<objwreckage.length;i++)
		ctx.drawImage(imgs[2],objwreckage[i].x,objwreckage[i].y);
	for (var i=0;i<objgold.length;i++)
		ctx.drawImage(imgs[3],objgold[i].x,objgold[i].y);
	for (var i=0;i<objtavern.length;i++)
		ctx.drawImage(imgs[4],objtavern[i].x,objtavern[i].y);
	for (var i=0;i<objmine.length;i++)
		ctx.drawImage(imgs[13],objmine[i].x,objmine[i].y);
	for (var i=0;i<objprison.length;i++)
		ctx.drawImage(imgs[14],objprison[i].x,objprison[i].y);	

	//Canvas2
	cnv = document.getElementById("canvas2");
	ctx = cnv.getContext("2d");
	ctx.fillStyle = "#FFFFFF";
	ctx.fillRect(20,20,170,60);
	ctx.fillRect(240,20,150,60);
	ctx.fillRect(440,20,150,60);
	ctx.fillRect(670,20,290,60);
	
	ctx.fillStyle = "#00FF00";
	ctx.font = "bold 10pt Arial";
	ctx.fillText('Координаты: '+youx+' '+youy,30,50);
	ctx.fillText('Опыт: '+exp,250,50);
	ctx.fillText('Золото: '+gold,450,50);
	
	if (visittype==1)
	{
		ctx.fillText("Мощность "+visitbonus+". Хотите ли сразиться?",690,50);
		ctx.fillText("Да",720,75);
		ctx.fillText("Нет",780,75);
		ctx.strokeStyle = "#FF0000";
		ctx.strokeRect(710,60,50,18);
		ctx.strokeRect(770,60,50,18);
	}
	else if (visittype==2)
	{
		ctx.fillText("Вы нашли "+incgold+" золота",690,50);
	}
	else if (visittype==3)
	{
		ctx.fillText(armystr[currunit]+":"+armycost[currunit]+" золота: купить?",690,50);
		ctx.fillText("Да",720,75);
		ctx.fillText("Нет",780,75);
		ctx.strokeStyle = "#FF0000";
		ctx.strokeRect(710,60,50,18);
		ctx.strokeRect(770,60,50,18);
	}
	else if (visittype==4)
	{
		ctx.fillText("Хотите отправить воинов для добычи золота?",690,50);
		ctx.fillText("Да",720,75);
		ctx.fillText("Нет",780,75);
		ctx.strokeStyle = "#FF0000";
		ctx.strokeRect(710,60,50,18);
		ctx.strokeRect(770,60,50,18);
	}
	else if (visittype==5)
	{
		ctx.fillText("Хотите сразиться со стражей?",690,50);
		ctx.fillText("Да",720,75);
		ctx.fillText("Нет",780,75);
		ctx.strokeStyle = "#FF0000";
		ctx.strokeRect(710,60,50,18);
		ctx.strokeRect(770,60,50,18);
	}
	else if (visittype==13)
	{
		ctx.fillText("Вы купили юнит "+armystr[currunit],690,50);
	}	
	else if (visittype==14)
	{
		ctx.fillText("Вы получаете награду 50 золота",690,50);
	}
	else if (visittype==15)
	{
		ctx.fillText("Вы сражаетесь ",690,50);
	}	
	
	//Canvas3
	cnv = document.getElementById("canvas3");
	ctx = cnv.getContext("2d");
	ctx.fillStyle = "#FFFFFF";
	ctx.fillRect(0,0,150,600);
	ctx.fillStyle = "#00FF00";
	ctx.font = "bold 14pt Arial";
	for (var i=0;i<4;i++)
	{
		ctx.drawImage(imgs[5+i],0,i*150);
		ctx.fillText(armystr[i]+'('+army[i]+')',10,i*150+20);
	}
	
	
	//Canvas4
	cnv = document.getElementById("canvas4");
	ctx = cnv.getContext("2d");
	ctx.fillStyle = "#FFFFFF";
	ctx.fillRect(0,0,150,600);
	
	if (isbattle!=0)
	{
		ctx.fillStyle = "#00FF00";
		ctx.font = "bold 10pt Arial";
		for (var i=0;i<4;i++)
		{
			ctx.drawImage(imgs[9+i],0,i*75);
			ctx.fillText(army[i],20,i*75+20);
			if (army[i]>0)
				ctx.fillText(resthp[i],60,i*75+55);
			else
				ctx.fillText('-',60,i*75+55);
		}	
		for (var i=0;i<4;i++)
		{
			ctx.drawImage(imgs[9+i],75,i*75);
			ctx.fillText(enemyarmy[i],95,i*75+20);
			if (enemyarmy[i]>0)
				ctx.fillText(restehp[i],135,i*75+55);
			else
				ctx.fillText('-',135,i*75+55);
		}
		
		if ((batuinfo>=0)&&(batuinfo<=3))
			ctx.fillText(armystr[batuinfo],30,320);
		
		ctx.lineWidth = 3;
		if ((battempunit>=0)&&(battempunit<=3))
		{
			ctx.strokeStyle = "#0000FF";
			ctx.strokeRect(0,75*battempunit,75,75);
		}		
		
		if ((battempenemy>=0)&&(battempenemy<=3))
		{
			ctx.strokeStyle = "#FF0000";
			ctx.strokeRect(75,75*battempenemy,75,75);
		}
		ctx.lineWidth = 1;
		
	}
	else
	{
		ctx.fillStyle = "#00FF00";
		ctx.font = "bold 10pt Arial";
		ctx.fillText('Вы сейчас',5,20);
		ctx.fillText('не сражаетесь',5,40);
	}

	
	//Canvast
	cnv = document.getElementById("canvast");
	ctx = cnv.getContext("2d");
	ctx.fillStyle = "#FFFFFF";
	ctx.fillRect(0,0,700,30);
	ctx.fillStyle = "#0000FF";
	ctx.font = "bold 12pt Arial";
	ctx.fillText('Мореплаватель: уровень '+glev+' из '+mlev+'. Посещено '+actions_curr+' из '+actions_max+'.',5,20);

	//Canvast2
	cnv = document.getElementById("canvast2");
	ctx = cnv.getContext("2d");
	ctx.fillStyle = "#FFFFFF";
	ctx.fillRect(0,0,120,30);
	ctx.fillStyle = "#0000FF";
	ctx.font = "bold 12pt Arial";
	ctx.fillText('Ваш экипаж:',5,20);
	
	//Canvast3
	cnv = document.getElementById("canvast3");
	ctx = cnv.getContext("2d");
	ctx.fillStyle = "#FFFFFF";
	ctx.fillRect(0,0,120,30);
	ctx.fillStyle = "#0000FF";
	ctx.font = "bold 12pt Arial";
	ctx.fillText('Битва:',5,20);	
	
}

window.addEventListener("load",draw,true);
