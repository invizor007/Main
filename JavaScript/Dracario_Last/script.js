var imgstr = ['img\\Walk1.png','img\\Walk2.png','img\\Walk3.png','img\\Walk4.png','img\\Walk5.png',
'img\\Attack1.png','img\\Attack2.png','img\\Attack3.png','img\\Attack4.png','img\\Fire_Attack1.png'
];
var imgstre = ['img\\EWalk1.png','img\\EWalk2.png','img\\EWalk3.png','img\\EWalk4.png','img\\EWalk5.png','img\\EWalk6.png'];
var imgstrem = ['img\\EMWalk1.png','img\\EMWalk2.png','img\\EMWalk3.png','img\\EMWalk4.png',
'img\\EMAttack1.png','img\\EMAttack2.png','img\\EMAttack3.png','img\\EMAttack4.png','img\\EMAttack5.png','img\\EMAttack6.png',
'img\\Medusa_Attack1.png'
];
var imgstro = ['img\\ObjHP1.png','img\\ObjScore1.png'];
var imgstrf = ['img\\Ground.png','img\\Sky.jpg'];

var imgs = [], imgse = [], imgsf = [], imgsem = [], imgso = [];

//положение на рисунке: left, top, right, bottom
var imgpos_dra = [49,122,205,194], imgpos_ene = [85,112,173,163], imgpos_fire = [4,5,31,20], 
imgpos_ma = [4,5,29,29], imgpos_enem = [51,38,114,99], imgpos_hp = [1,1,38,38], imgpos_sc = [1,1,31,31];

var drc = {x:100, y:379};
var enemies = [], fireblast = []; medusaatt = [], mapobjects = [];

var hp = 100, score = 0, stage=0;
var walkstep=1, attackstep = 0; 
var gltimer = {medusaatt:20, hpobjinit: 80, scoreobjinit: 120};


///////////Инициализация объектов///////////////

function init_enemies(temp_x,temp_att, temp_en_num)
{
	if (temp_en_num==0)
	{
		var tmp = {};
		tmp.x= temp_x;
		tmp.y= 413;
		tmp.imgnum = 0;
		tmp.att = temp_att;
		tmp.needdel = 0;
		tmp.vx = 5;
		tmp.en_num = temp_en_num;
		enemies.push(tmp);
	}
	
	if (temp_en_num==1)
	{
		var tmp = {};
		tmp.x= temp_x;
		tmp.y= 472;
		tmp.imgnum = 0;
		tmp.att = temp_att;
		tmp.needdel = 0;
		tmp.vx = 5;
		tmp.en_num = temp_en_num;
		enemies.push(tmp);
	}
}

function init_fireblast()
{
	var tmp = {};
	tmp.x = drc.x+180;
	tmp.y = drc.y+110;
	tmp.vx = 2;
	tmp.vy = 2;
	tmp.needdel = 0;
	fireblast.push(tmp);
	return;
}

function init_medusaatt()
{
	var tmp = {};
	tmp.x = enemies[0].x-5;
	tmp.y = enemies[0].y+50;
	tmp.vx = -8;
	tmp.vy = 0;
	tmp.needdel = 0;
	medusaatt.push(tmp);
	return;
}

function init_mapobjects(temp_obj_num)
{
	var tmp = {};
	tmp.obj_num = temp_obj_num;
	if (temp_obj_num==1)
	{
		tmp.x = drc.x+300;
		if (tmp.x >700) tmp.x = 70;
	}
	else
	{
		tmp.x = drc.x+350;
		if (tmp.x >700) tmp.x = 30;		
	}

	tmp.y = drc.y+140;
	tmp.needdel = 0;
	mapobjects.push(tmp);
	return;
}

///////////Столкновение объектов///////////////

function collision_d_e(ei)
{	
	var imgpos_et;
	if (enemies[ei].en_num == 1) {imgpos_et = imgpos_enem;}
	else {imgpos_et = imgpos_ene;}
	
	if ( (drc.x+imgpos_dra[2]>enemies[ei].x+imgpos_et[0]) && (enemies[ei].x+imgpos_et[2]>drc.x+imgpos_dra[0]) && 
			(drc.y+imgpos_dra[3]>enemies[ei].y+imgpos_et[1]) && (enemies[ei].y+imgpos_et[3]>drc.y+imgpos_dra[1]) )
	{
		hp-=10;
		enemies[ei].needdel = 1;
		playSoundDeath();
	}
	
	return 0;
}

function collision_f_e(ei,fi)
{
	var imgpos_et;
	if (enemies[ei].en_num == 1) {imgpos_et = imgpos_enem;}
	else {imgpos_et = imgpos_ene;}
	
	if ( (fireblast[fi].x+imgpos_fire[2]>enemies[ei].x+imgpos_et[0]) && (enemies[ei].x+imgpos_et[2]>fireblast[fi].x+imgpos_fire[0]) && 
			(fireblast[fi].y+imgpos_fire[3]>enemies[ei].y+imgpos_et[1]) && (enemies[ei].y+imgpos_et[3]>fireblast[fi].y+imgpos_fire[1]) )
	{
		enemies[ei].att--;
		if (enemies[ei].att<=0)
		{
			fireblast[fi].needdel = 1;
			enemies[ei].needdel = 1;
			score+=10;			
		}
		else
		{
			fireblast[fi].needdel = 1;
		}
	}
	
	return 0;
}

function collision_f_ma(mai,fi)
{
	if ( (fireblast[fi].x+imgpos_fire[2]>medusaatt[mai].x+imgpos_ma[0]) && (medusaatt[mai].x+imgpos_ma[2]>fireblast[fi].x+imgpos_fire[0]) && 
			(fireblast[fi].y+imgpos_fire[3]>medusaatt[mai].y+imgpos_ma[1]) && (medusaatt[mai].y+imgpos_ma[3]>fireblast[fi].y+imgpos_fire[1]) )
	{
		fireblast[fi].needdel = 1;
		medusaatt[mai].needdel = 1;
	}
	
	return 0;
}

function collision_d_ma(mai)
{	
	if ( (drc.x+imgpos_dra[2]>medusaatt[mai].x+imgpos_ma[0]) && (medusaatt[mai].x+imgpos_ma[2]>drc.x+imgpos_dra[0]) && 
			(drc.y+imgpos_dra[3]>medusaatt[mai].y+imgpos_ma[1]) && (medusaatt[mai].y+imgpos_ma[3]>drc.y+imgpos_dra[1]) )
	{
		hp-=10;
		medusaatt[mai].needdel = 1;
		playSoundDeath();
	}
	return 0;
}

function collision_d_hp(hpi)
{	
	if ( (drc.x+imgpos_dra[2]>mapobjects[hpi].x+imgpos_hp[0]) && (mapobjects[hpi].x+imgpos_hp[2]>drc.x+imgpos_dra[0]) && 
			(drc.y+imgpos_dra[3]>mapobjects[hpi].y+imgpos_hp[1]) && (mapobjects[hpi].y+imgpos_hp[3]>drc.y+imgpos_dra[1]) )
	{
		hp+=10;
		mapobjects[hpi].needdel = 1;
	}
	return 0;
}

function collision_d_sc(hpi)
{	
	if ( (drc.x+imgpos_dra[2]>mapobjects[hpi].x+imgpos_sc[0]) && (mapobjects[hpi].x+imgpos_sc[2]>drc.x+imgpos_dra[0]) && 
			(drc.y+imgpos_dra[3]>mapobjects[hpi].y+imgpos_sc[1]) && (mapobjects[hpi].y+imgpos_sc[3]>drc.y+imgpos_dra[1]) )
	{
		score+=10;
		mapobjects[hpi].needdel = 1;
	}
	return 0;
}

function collision_f_g(fi)
{
	if (fireblast[fi].y>543)
	{
		fireblast[fi].needdel = 1; 
	}
	
	return 0;
}

///////////Перемещение///////////////


function move_you(e)
{
	
	if (e.keyCode==37)
		{drc.x -= 3;}
	if (e.keyCode==39)
		{drc.x += 3;}
	if (e.keyCode==32)
		{attackstep = 1;}
	
}

function timer()
{
	if (stage==1)
	{ //alert(stage);
		for (var ei=0;ei<enemies.length;ei++)
			collision_d_e(ei);//Столкновение дракоша - враг
		
		for (var mai=0;mai<medusaatt.length;mai++)
			collision_d_ma(mai);//Столкновение дракоша - атака медузы
		
		for (var hpi=0;hpi<mapobjects.length;hpi++)
		{
			if (mapobjects[hpi].obj_num==1) collision_d_hp(hpi);//Столкновение дракоша - сердечко
			if (mapobjects[hpi].obj_num==2) collision_d_sc(hpi);//Столкновение дракоша - звездочки
		}
					
		for (var ei=0;ei<enemies.length;ei++) 
			for (var fi=0;fi<fireblast.length;fi++)
			{
				collision_f_e(ei,fi);//Столкновение огонь - враг
			}
			
		for (var mai=0;mai<medusaatt.length;mai++) 
			for (var fi=0;fi<fireblast.length;fi++)
			{
				collision_f_ma(mai,fi);//Столкновение огонь - атака медузы
			}			
			
		for (var fi=0;fi<fireblast.length;fi++) 
			collision_f_g(fi);//Столкновение огонь - земля
		
		//Удаление помеченных объектов
		for (var i=enemies.length-1;i>=0;i--)
		{
			if (enemies[i].needdel==1) enemies.splice(i,1);
		}
		
		for (var i=fireblast.length-1;i>=0;i--)
		{
			if (fireblast[i].needdel==1) fireblast.splice(i,1);
		}
		
		for (var i=medusaatt.length-1;i>=0;i--)
		{
			if (medusaatt[i].needdel==1) medusaatt.splice(i,1);
		}
		
		for (var i=mapobjects.length-1;i>=0;i--)
		{
			if (mapobjects[i].needdel==1) mapobjects.splice(i,1);
		}		

		//Инициализация нового врага
		if (enemies.length==0)
		{
			if (Math.random()>0.5) 
			{
				init_enemies(820,1,1);
			}
			else
			{
				init_enemies(820,3,0);
			}
		}
		
		//Проверка на окончание игры
		if (hp <= 0)
		{
			alert("Игра закончена");
			stage = 2;
		}
	}
	
	if (stage==1)
	{
		for (var i=0;i<enemies.length;i++)
		{
			enemies[i].imgnum++;
			if (enemies[i].imgnum==6) enemies[i].imgnum=0;
			enemies[i].x-=enemies[i].vx;
		}
		
		if (attackstep>0)
		{
			attackstep++;
			if (attackstep==3) {init_fireblast();playSoundAttack();}
			if (attackstep==5) {attackstep=0;}	
		}
		else
		{
			walkstep++;
			if (walkstep==5) {walkstep=0;}			
		}
		
		for (var i=0;i<fireblast.length;i++)
		{
			fireblast[i].x+=fireblast[i].vx;
			fireblast[i].y+=fireblast[i].vy;
		}
		
		for (var i=0;i<medusaatt.length;i++)
		{
			medusaatt[i].x+=medusaatt[i].vx;
			medusaatt[i].y+=medusaatt[i].vy;
		}		
		
		//Таймер по инициализации атаки медузы
		if (gltimer.medusaatt==0)
		{
			if (enemies[0].en_num==1)
				init_medusaatt();
			gltimer.medusaatt = 20;
		}
		else
		{
			gltimer.medusaatt--;
		}
		
		//Таймер по созданию сердечка
		if (gltimer.hpobjinit==0)
		{
			if ((mapobjects.length==0)&&(hp<100)) 
				init_mapobjects(1);
			gltimer.hpobjinit = 80;
		}
		else
		{
			gltimer.hpobjinit--;
		}

		//Таймер по созданию звездочки
		if (gltimer.scoreobjinit==0)
		{
			init_mapobjects(2);
			gltimer.scoreobjinit = 120;
		}
		else
		{
			gltimer.scoreobjinit--;
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
  
  for (var i=0;i<imgstre.length;i++)
  {
    var tmp = new Image();
    tmp.src = imgstre[i];
    imgse.push(tmp);
  } 
  
  for (var i=0;i<imgstrem.length;i++)
  {
    var tmp = new Image();
    tmp.src = imgstrem[i];
    imgsem.push(tmp);
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

function playSoundAttack() 
{
  var audio = new Audio(); // Создаём новый элемент Audio
  audio.src = 'sound1.wav'; // Указываем путь к звуку
  audio.autoplay = true; // Автоматически запускаем
}

function playSoundDeath() 
{
  var audio = new Audio(); // Создаём новый элемент Audio
  audio.src = 'sound2.wav'; // Указываем путь к звуку
  audio.autoplay = true; // Автоматически запускаем
}


///////////Отрисовка///////////////
//https://www.fotor.com/ онлайн редактор фотографий
//https://craftpix.net/ изображения и тайлы взяты отсюда
//http://gcup.ru/

function draw()
{
	if (stage==0)
	{
		ImagesInit();
		init_enemies(700,1,1);
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
	
	//Рисуем дракошу
	if (attackstep>0)
	{
		ctx.drawImage(imgs[attackstep+4],drc.x,drc.y);
	}
	else
	{
		ctx.drawImage(imgs[walkstep],drc.x,drc.y);		
	}
	
	//Рисуем врагов
	for (var i=0;i<enemies.length;i++)
	{
		if (enemies[i].en_num==1) {ctx.drawImage(imgsem[enemies[i].imgnum],enemies[i].x,enemies[i].y);}
		else {ctx.drawImage(imgse[enemies[i].imgnum],enemies[i].x,enemies[i].y);}
	}
	
	//Рисуем огонь дракоши
	for (var i=0;i<fireblast.length;i++)
	{
		ctx.drawImage(imgs[9],fireblast[i].x,fireblast[i].y);
	}
	
	//Рисуем атаки медузы
	for (var i=0;i<medusaatt.length;i++)
	{
		ctx.drawImage(imgsem[10],medusaatt[i].x,medusaatt[i].y);
	}
	
	//Рисуем сердечки и очки
	for (var i=0;i<mapobjects.length;i++)
	{
		if (mapobjects[i].obj_num==1)
		{
			ctx.drawImage(imgso[0],mapobjects[i].x,mapobjects[i].y);
		}
		else
		{
			ctx.drawImage(imgso[1],mapobjects[i].x,mapobjects[i].y);
		}
	}	
	
	//Рисуем счет и количество хп
	ctx.strokeStyle = 'green';
	ctx.font = 'bold 24px Arial';
	ctx.strokeText('Счет:'+score+'. Здоровье:'+hp,50,50);
}

window.addEventListener("load",draw,true);
