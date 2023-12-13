var imgstr = [
'img\\00\\00.png','img\\00\\01.png','img\\00\\02.png','img\\00\\03.png','img\\00\\04.png',
'img\\01\\00.png','img\\01\\01.png','img\\01\\02.png','img\\01\\03.png','img\\01\\04.png',
'img\\02\\00.png','img\\02\\01.png','img\\02\\02.png','img\\02\\03.png','img\\02\\04.png',
'img\\02\\05.png','img\\02\\06.png'
];

var imgstr_e1 = [
'img\\03\\00.png','img\\03\\01.png','img\\03\\02.png','img\\03\\03.png','img\\03\\04.png','img\\03\\05.png',
'img\\04\\00.png','img\\04\\01.png','img\\04\\02.png','img\\04\\03.png'
];

var imgstr_e2 = [
'img\\05\\00.png','img\\05\\01.png','img\\05\\02.png','img\\05\\03.png',
'img\\05\\00.png','img\\05\\01.png','img\\06\\02.png','img\\06\\03.png','img\\06\\04.png','img\\06\\05.png'
];

var imgstro = [
'img\\07\\00.png','img\\07\\01.png','img\\07\\02.png','img\\07\\03.png','img\\07\\04.png',
'img\\07\\05.png','img\\07\\06.png'
];
var imgstrf = ['img\\08\\Ground.png','img\\08\\Location.jpg'];

var imgs = [], imgse2 = [], imgsf = [], imgse1 = [], imgso = [];

//положение на рисунке: left, top, right, bottom
var imgpos_pers = [15,1,85,115], imgpos_ene = [[35,35,173,100],[10,25,96,110]];

var persstart = {x:100, y:459};
var pers = {x:100, y:459, lr:0};
var enemies = [], mapobjects = [];
var pers_addx = [0,0,0,0,0,
0,0,0,0,0,
0,0,0,0,0,0,0];
var pers_addy = [0,3,0,0,5,
-10,-8,-2,7,12,
0,-10,-20,-60,-90,-50,-25];

var hp = 3, score = 0, stage = 0;
var glev = 1, mlev = 2;
var walkstep=0, attackstep = 0, jumpstep = 0; 
var offsx = 0, offsy = 0, lctn = 1;
var gtimer = {msg1:50};
var keys = [];
var guardx = 0, gportal = 0;

var stagedata = [];


///////////Инициализация объектов///////////////

function init_objects()
{
	//номер уровня, номер объекта, x_координата, y_координата, дополнительное свойство объекта
	stagedata = JSON.parse(data);
	//alert(stagedata[0].lev);
	//1- враг Ящер  \\ 2- враг Демон \\ 3-сердечко \\ 4-звездочка \\5 - сундук 
	// \\ 6-ключ \\7 страж \\ 8 портал
}

function init_enemies()
{ //return;
	enemies.length = 0;
	for (var i=0;i<stagedata.length;i++)
	{
		if ((stagedata[i].lev==glev)&&(stagedata[i].num==0))
		{
			var tmp = {};
			tmp.x = parseInt(stagedata[i].x,10);
			tmp.y = parseInt(stagedata[i].y,10);
			tmp.sx = tmp.x;
			tmp.sy = tmp.y;
			tmp.imgnum = 0;
			tmp.att = 0;
			tmp.needdel = 0;
			tmp.vx = 5;
			tmp.en_num = 1;
			tmp.lr = 0;
			tmp.atttimer = 80;
			tmp.sdid = parseInt(stagedata[i].id,10);
			enemies.push(tmp);
		}
		
		if ((stagedata[i].lev==glev)&&(stagedata[i].num==1))
		{
			var tmp = {};
			tmp.x = parseInt(stagedata[i].x,10);
			tmp.y = parseInt(stagedata[i].y,10);
			tmp.sx = tmp.x;
			tmp.sy = tmp.y;
			tmp.imgnum = 0;
			tmp.att = 0;
			tmp.needdel = 0;
			tmp.vx = 5;
			tmp.en_num = 2;
			tmp.lr = 0;
			tmp.atttimer = 60;
			tmp.sdid = parseInt(stagedata[i].id,10);
			enemies.push(tmp);
		}		
	}
}

function init_mapobjects()
{
	mapobjects.length = 0;
	for (var i=0;i<stagedata.length;i++)
	{
		if ((stagedata[i].lev==glev)&&(stagedata[i].num>=2)&&(stagedata[i].num<=9))
		{
			var tmp = {};
			tmp.x= parseInt(stagedata[i].x,10);
			tmp.y= parseInt(stagedata[i].y,10);
			tmp.s= parseInt(stagedata[i].s,10);
			tmp.obj_num = parseInt(stagedata[i].num,10)-2;
			tmp.sdid = parseInt(stagedata[i].id,10);
			tmp.needdel = 0;
			mapobjects.push(tmp);
		}
	}
	
}

function newlev()
{
	if (glev==mlev) return;
	glev++;
	pers.x = persstart.x;
	pers.y = persstart.y;
	guardx = 0;
	gportal = 0;
	keys.length = 0;
	init_mapobjects();
	init_enemies();
}

///////////Столкновение объектов///////////////

function collision_e(ei)
{	
	var n1 = enemies[ei].en_num-1;
	var iscls = 0;
	
	var x1 = enemies[ei].x+imgpos_ene[n1][0];
	var x2 = enemies[ei].x+imgpos_ene[n1][2];
	var y1 = enemies[ei].y+imgpos_ene[n1][1];
	var y2 = enemies[ei].y+imgpos_ene[n1][3];
	
	var ux1 = pers.x+imgpos_pers[0],ux2 = pers.x+imgpos_pers[2],
	uy1 = pers.y+imgpos_pers[1],uy2 = pers.y+imgpos_pers[3];
	if (attackstep>0) ux2+=35;
	if (jumpstep>0)
	{
		uy1+=pers_addy[10+jumpstep];
		uy2+=pers_addy[10+jumpstep];
	}	
	
	if ( ( coll_check(x1,x2,ux1,ux2)==1 )&&( coll_check(y1,y2,uy1,uy2)==1 ) )
		iscls = 1;
	
	if (iscls==1)
	{
		var dhp = 0;
		if (attackstep==0) dhp=1;
		if (enemies[ei].lr==0) dhp=1;
		if (enemies[ei].att<0) dhp=3;
		hp-=dhp;
		enemies[ei].needdel = 1;
		return 1;
	}	
	
	return 0;
}

function coll_check(x1,x2,ux1,ux2)
{
	if ((x1>ux1)&&(x1<ux2)) return 1;
	if ((x2>ux1)&&(x2<ux2)) return 1;
	
	if ((ux1>x1)&&(ux1<x2)) return 1;
	if ((ux2>x1)&&(ux2<x2)) return 1;
	return 0;
}

function collision_mo(obji)
{	
	var tmp_on = mapobjects[obji].obj_num;//console.log(tmp_on);
	var iscls = 0;
	var x1 = 0,x2 = 0,y1 = 0,y2 = 0;
	var ux1 = pers.x+imgpos_pers[0];
	var ux2 = pers.x+imgpos_pers[2];
	var uy1 = pers.y+imgpos_pers[1];
	var uy2 = pers.y+imgpos_pers[3];
	
	if (attackstep>0) ux2+=35;
	if (jumpstep>0)
	{
		uy1+=pers_addy[10+jumpstep];
		uy2+=pers_addy[10+jumpstep];
	}
	
	if (tmp_on==0)
	{
		if (hp==3) return;
		x1 = mapobjects[obji].x+ 1;
		x2 = mapobjects[obji].x+ 38;
		y1 = mapobjects[obji].y+ 1;
		y2 = mapobjects[obji].y+ 38;		
		
		if ( ( coll_check(x1,x2,ux1,ux2)==1 )&&( coll_check(y1,y2,uy1,uy2)==1 ) )
				iscls = 1;
		if (iscls==1)
		{
			hp++;
			mapobjects[obji].needdel = 1;
		}		
	}
	if (tmp_on==1)
	{
		x1 = mapobjects[obji].x+ 1;
		x2 = mapobjects[obji].x+ 29;
		y1 = mapobjects[obji].y+ 1;
		y2 = mapobjects[obji].y+ 31;	//console.log(" x1 "+x1+" x2 "+x2+" y1 "+y1+" y2 "+y2);

		if ( ( coll_check(x1,x2,ux1,ux2)==1 )&&( coll_check(y1,y2,uy1,uy2)==1 ) )
				iscls = 1;
		if (iscls==1)
		{
			score+=10;
			mapobjects[obji].needdel = 1;
		}		
	}
	if (tmp_on==2)
	{
		x1 = mapobjects[obji].x+ 10;
		x2 = mapobjects[obji].x+ 70;
		y1 = mapobjects[obji].y+ 10;
		y2 = mapobjects[obji].y+ 70;	

		if ( ( coll_check(x1,x2,ux1,ux2)==1 )&&( coll_check(y1,y2,uy1,uy2)==1 ) )
				iscls = 1;		
		
		if (iscls==1)
		{
			keys.push(mapobjects[obji].s);
			mapobjects[obji].needdel = 1;
		}
			
	}
	if (tmp_on==3)
	{
		x1 = mapobjects[obji].x+ 0;
		x2 = mapobjects[obji].x+ 79;
		y1 = mapobjects[obji].y+ 20;
		y2 = mapobjects[obji].y+ 55;

		if ( ( coll_check(x1,x2,ux1,ux2)==1 )&&( coll_check(y1,y2,uy1,uy2)==1 ) )
				iscls = 1;			

		if (iscls==1)
		{	
			var tmp = 0;
			for (var i=0;i<keys.length;i++)
			{
				if (keys[i]==mapobjects[obji].s+100)
					tmp = 1;
			}
			
			if (tmp==1)
			{
				score+=50;
				mapobjects[obji].needdel = 1;
			}
			/*else
			{
				console.log("Need key");
			}*/
		}
	}	
	if (tmp_on==4)
	{
		x1 = mapobjects[obji].x+ 1;
		x2 = mapobjects[obji].x+ 99;
		y1 = mapobjects[obji].y+ 1;
		y2 = mapobjects[obji].y+ 99;	

		if ( ( coll_check(x1,x2,ux1,ux2)==1 )&&( coll_check(y1,y2,uy1,uy2)==1 ) )
				iscls = 1;			
		
		if (iscls==1)
		{
			if (glev==mlev)
			{
				stage=2;
				alert("You win");
			}
			else
			{
				newlev();
			}			
		}

	}
	if (tmp_on==5)
	{
		x1 = mapobjects[obji].x+ 1;
		x2 = mapobjects[obji].x+ 85;
		y1 = mapobjects[obji].y+ 1;
		y2 = mapobjects[obji].y+ 99;

		if ( ( coll_check(x1,x2,ux1,ux2)==1 )&&( coll_check(y1,y2,uy1,uy2)==1 ) )
				iscls = 1;			

		if (iscls==1)
		{
			var tmp = 0;
			for (var i=0;i<keys.length;i++)
			{
				if (keys[i]==mapobjects[obji].s)
					tmp = 1;
			}
			
			if (tmp==1)
			{
				mapobjects[obji].needdel = 1;
				guardx = 0;
			}	
			else
			{
				guardx = mapobjects[obji].x;
				//mapobjects[obji].needdel = 1;
			}			
		}

	}
	if (tmp_on==6)
	{
		x1 = mapobjects[obji].x+ 5;
		x2 = mapobjects[obji].x+ 135;
		y1 = mapobjects[obji].y+ 15;
		y2 = mapobjects[obji].y+ 139;	

		if ( ( coll_check(x1,x2,ux1,ux2)==1 )&&( coll_check(y1,y2,uy1,uy2)==1 ) )
				iscls = 1;			
		
		if (iscls==1)
		{
			gportal = mapobjects[obji].s;
		}
	}
	if (tmp_on==7)
	{
		x1 = mapobjects[obji].x+ 1;
		x2 = mapobjects[obji].x+ 31;
		y1 = mapobjects[obji].y+ 1;
		y2 = mapobjects[obji].y+ 31;	

		if ( ( coll_check(x1,x2,ux1,ux2)==1 )&&( coll_check(y1,y2,uy1,uy2)==1 ) )
				iscls = 1;			
		
		if (iscls==1)
		{
			pers.y = mapobjects[obji].y-120;
		}
	}
	return iscls;
}


///////////Перемещение///////////////


function attack()
{
	attackstep = 1;
}

function jump()
{
	jumpstep = 1;
}

function move_you(e)
{
	
	if (e.keyCode==37)
	{
		pers.x -= 4;
		pers.lr=1;
	}
	if ((e.keyCode==39)&&(guardx==0))
	{
		pers.x += 4;
		//if (attackstep!=0) pers.x += 2;
		pers.lr=0;
	}
	if (e.keyCode==32)
		if ((jumpstep==0)&&(attackstep==0))
		{
			attack();
		}
			
	if (e.keyCode==38)
		if ((jumpstep==0)&&(attackstep==0))
		{
			jump();
		}
			
	if ((e.keyCode==13)&&(gportal>0))
	{
		var prtx = 0,prty = 0;
		for (var i=0;i<mapobjects.length;i++)
		{
			if ((mapobjects[i].obj_num==6)&&(mapobjects[i].sdid==gportal))
			{
				prtx = mapobjects[i].x;
				prty = mapobjects[i].y;//console.log("AAA");
			}
		}
		if (prty!=0)
		{
			pers.x = prtx;
			pers.y = prty+29;			
		}
		
		while ((pers.x-offsx<0)||(pers.x-offsx>800))
		{
			if (pers.x-offsx>800)
			{
				offsx+=800;
				lctn++;
			}
			if (pers.x-offsx<0)
			{
				offsx-=800;
				lctn--;
			}			
		}


	}		
		
	if (pers.x-offsx>800)
	{
		offsx+=800;
		lctn++;
	}
	if (pers.x-offsx<0)
	{
		offsx-=800;
		lctn--;
	}
	

}

function timer()
{
	if (stage==1)
	{ 
		//Столкновения
		for (var ei=0;ei<enemies.length;ei++)
			collision_e(ei);
		
		gportal = 0;
		guardx = 0;
		for (var obji=0;obji<mapobjects.length;obji++)
		{
			collision_mo(obji);
		}
					
					
		//Удаление помеченных объектов
		for (var i=enemies.length-1;i>=0;i--)
		{
			if (enemies[i].needdel==1) enemies.splice(i,1);
		}
		for (var i=mapobjects.length-1;i>=0;i--)
		{
			if (mapobjects[i].needdel==1) mapobjects.splice(i,1);
		}		

		for (var i=0;i<enemies.length;i++)
		{
			enemies[i].atttimer--;
			if (enemies[i].atttimer==0)
			{
				enemies[i].atttimer=80;
				enemies[i].att = 4;
			}
		}
		
		//Проверка на окончание игры
		if (hp <= 0)
		{
			alert("Вы проиграли");
			stage = 2;
		}
	}
	
	if (stage==1)
	{
		
		//Движение врагов
		for (var i=0;i<enemies.length;i++)
		{
			enemies[i].imgnum++;
			if (enemies[i].imgnum==5) enemies[i].imgnum=0;
			if ((enemies[i].x<enemies[i].sx-200)&&(enemies[i].lr==0)) enemies[i].lr = 1;
			if ((enemies[i].x>enemies[i].sx+200)&&(enemies[i].lr==1)) enemies[i].lr = 0;
			if (enemies[i].lr==0)
				enemies[i].x-=enemies[i].vx;
			else
				enemies[i].x+=enemies[i].vx;
			
		}
		
		//Движение персонажа
		if (attackstep>0)
		{
			if ((attackstep!=0)&&(pers.lr==0)) pers.x += 2;
			attackstep++;
			if (attackstep==5) {attackstep=0;}	
		}
		else if (jumpstep>0)
		{
			jumpstep++;
			if (jumpstep==7) {jumpstep=0;}	
		}
		else
		{
			walkstep++;
			if (walkstep==5) {walkstep=0;}			
		}

	}
	
	draw();
	window.setTimeout("timer();", 200);
}

function ImagesInit()
{
  for (var i=0;i<imgstr.length;i++)
  {
    var tmp = new Image();
    tmp.src = imgstr[i];
    imgs.push(tmp);
  } 
  
  for (var i=0;i<imgstr_e1.length;i++)
  {
    var tmp = new Image();
    tmp.src = imgstr_e1[i];
    imgse2.push(tmp);
  } 
  
  for (var i=0;i<imgstr_e2.length;i++)
  {
    var tmp = new Image();
    tmp.src = imgstr_e2[i];
    imgse1.push(tmp);
  }
  
  for (var i=0;i<imgstro.length;i++)
  {
    var tmp = new Image();
    tmp.src = imgstro[i];
    imgso.push(tmp);
  }    
  
  for (var i=0;i<imgstrf.length;i++)
  {
    var tmp = new Image();
    tmp.src = imgstrf[i];
    imgsf.push(tmp);
  } 
  
}


///////////Отрисовка///////////////


function draw()
{
	if (stage==0)
	{
		ImagesInit();
		init_objects();
		init_enemies();
		init_mapobjects();
		document.onkeydown = move_you;
		stage = 1;
	}

	var cnv = document.getElementById("canvas1");
	var ctx = cnv.getContext("2d");
	ctx.fillRect(0,0,800,600);
	
	//Рисуем небо
	ctx.drawImage(imgsf[1],0,0);
	
	//Рисуем пол и стены
	for (var i=0;i<30;i++)
	{
		ctx.drawImage(imgsf[0],32*i,570);
	}
	
	//Рисуем персонажа
	if (attackstep>0)
	{
		ctx.drawImage(imgs[attackstep+4],pers.x+pers_addx[5+attackstep]-offsx,pers.y+pers_addy[5+attackstep]);
	}
	else if (jumpstep>0)
	{
		ctx.drawImage(imgs[jumpstep+9],pers.x+pers_addx[10+jumpstep]-offsx,pers.y+pers_addy[10+jumpstep]);
	}
	else
	{
		ctx.drawImage(imgs[walkstep],pers.x+pers_addx[walkstep]-offsx,pers.y+pers_addy[walkstep]);		
	}
	
	//Рисуем врагов
	for (var i=0;i<enemies.length;i++)
	{
		if (enemies[i].en_num==1) 
		{
			var ind = enemies[i].imgnum;
			if (enemies[i].att>0)
			{
				ind=enemies[i].att+4;
				enemies[i].att--;
			}
			//imgse1[0].reflect();
			//ctx.drawImage(imgse1[ind],enemies[i].x-offsx,enemies[i].y);
			//var w = imgse1[ind].width, h = imgse1[ind].height;
			//ctx.drawImage(imgse1[ind],0,0, w, h,  enemies[i].x-offsx+w,enemies[i].y,  -w, h);
			if (enemies[i].lr==1)
			{
				var w = imgse1[ind].width;
				ctx.scale(-1,1);
				ctx.drawImage(imgse1[ind],-enemies[i].x+offsx-w,enemies[i].y);
				ctx.scale(-1,1);				
			}
			else
			{
				ctx.drawImage(imgse1[ind],enemies[i].x-offsx,enemies[i].y);
			}

		}
		if (enemies[i].en_num==2) 
		{
			var ind = enemies[i].imgnum;
			if (enemies[i].att>0)
			{
				ind=enemies[i].att+4;
				enemies[i].att--;
			}			
			if (enemies[i].lr==1)
			{
				var w = imgse2[ind].width;
				ctx.scale(-1,1);
				ctx.drawImage(imgse2[ind],-enemies[i].x+offsx-w,enemies[i].y);
				ctx.scale(-1,1);				
			}
			else
			{
				ctx.drawImage(imgse2[ind],enemies[i].x-offsx,enemies[i].y);
			}
		}
	}
	
	
	//Рисуем другие объекты
	for (var i=0;i<mapobjects.length;i++)
	{
		var num = mapobjects[i].obj_num;
		if ((num>=0)&&(num<=7))
		{
			ctx.drawImage(imgso[num],mapobjects[i].x-offsx,mapobjects[i].y);
		}
	}	
	
	//Рисуем основную информацию об игре
	ctx.strokeStyle = 'green';
	ctx.font = 'bold 24px Arial';
	ctx.strokeText('Счет:'+score+'. Здоровье:'+hp+'. Уровень '+glev+' из '+mlev+'. Локация '+lctn,50,50);
	
	gtimer.msg1--;
	if (gtimer.msg1<=0)
	{
		var tmpstr = "Ключи: ";
		for (var i=0;i<keys.length;i++)
		{
			if (keys[i]>=100)
			{
				tmpstr+='Сундук №'+(keys[i]-100)+' ';
			}
			else
			{
				tmpstr+='Страж №'+keys[i]+' ';
			}				
		}
		if (keys.length==0)
			tmpstr = 'Количество ключей 0';
		ctx.strokeText(tmpstr,50,150);
		if (gtimer.msg1==-5)
			gtimer.msg1=50;
	}
}

window.addEventListener("load",draw,true);
