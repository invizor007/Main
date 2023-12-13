var imgstr = ['1.png','2.png','3.png','4.png','5.png','6.png','7.png','8.png'];
var imgx = [800,123,5,114,5,40,32,60];
var imgy = [600,55,5,57,5,40,32,60];
var imgs = [];

var youx = 100, youy = 400;
var youmovex=0, youmovey=0;
var score = 0, endgame = 0, tcount=0, yhp = 5;

var buls = [];
var ebuls = [];
var enemies = [];
var heas = [];
var bons = [];
var bombs = [];

//Collision with you
function cls_you_ebul(j)
{
	var x1 = youx, y1 = youy;
	var x2 = ebuls[j].x, y2 = ebuls[j].y;
	
	if ( (x2+imgx[4]>x1)&&(x1+imgx[1]>x2)&&(y2+imgy[4]>y1)&&(y1+imgy[1]>y2) )
	{
		ebuls.splice(j,1);
		yhp--;
		if (yhp<=0)
		{
			endgame = 1;
			alert('Вы набрали '+score+' очков. Обновите страницу чтобы начать новую игру.');
			return 1;
		}
	}
	return 0;
}

function cls_you_bombs(j)
{
	var x1 = youx, y1 = youy;
	var x2 = bombs[j].x, y2 = bombs[j].y;
	
	if ( (x2+imgx[7]>x1)&&(x1+imgx[1]>x2)&&(y2+imgy[7]>y1)&&(y1+imgy[1]>y2) )
	{
		bombs.splice(j,1);
		yhp-=3;
		if (yhp<=0)
		{
			endgame = 1;
			alert('Вы набрали '+score+' очков. Обновите страницу чтобы начать новую игру.');
			return 1;
		}
	}
	
	return 0;
}

function cls_you_ene(j)
{
	var x1 = youx, y1 = youy;
	var x2 = enemies[j].x, y2 = enemies[j].y;
	
	if ( (x2+imgx[3]>x1)&&(x1+imgx[1]>x2)&&(y2+imgy[3]>y1)&&(y1+imgy[1]>y2) )
	{
		endgame = 1;
		alert('Вы набрали '+score+' очков. Обновите страницу чтобы начать новую игру.');
		return 1;
	}
	return 0;
}

function cls_you_heas(j)
{
	var x1 = youx, y1 = youy;
	var x2 = heas[j].x, y2 = heas[j].y;
	
	if ( (x2+imgx[5]>x1)&&(x1+imgx[1]>x2)&&(y2+imgy[5]>y1)&&(y1+imgy[1]>y2) )
	{
		yhp++;
		if (yhp>5) yhp = 5;
		heas.splice(j,1);
	}
	return 0;
}

function cls_you_bons(j)
{
	var x1 = youx, y1 = youy;
	var x2 = bons[j].x, y2 = bons[j].y;
	
	if ( (x2+imgx[6]>x1)&&(x1+imgx[1]>x2)&&(y2+imgy[6]>y1)&&(y1+imgy[1]>y2) )
	{
		score+=10;
		bons.splice(j,1);
	}
	return 0;
}

function cls_ene_bul(i,j)
{
	var x1 = enemies[i].x, y1 = enemies[i].y;
	var x2 = buls[j].x, y2 = buls[j].y;
	
	if ( (x2+imgx[2]>x1)&&(x1+imgx[3]>x2)&&(y2+imgy[2]>y1)&&(y1+imgy[3]>y2) )
	{
		buls.splice(j,1);
		enemies[i].hp--;
		if (enemies[i].hp<=0)
		{
			enemies.splice(i,1);
			score+=20;
			return 1;
		}
	}
	return 0;
}



function new_bullet()
{
	var tmp = {};
	tmp.x=youx+170;
	tmp.y=youy+33;
	
	buls.push(tmp);
}

function new_ebullet(i)
{
	var tmp = {};
	tmp.x=enemies[i].x-imgx[3]-2;
	tmp.y=enemies[i].y+Math.floor(imgx[3]/2);
	
	ebuls.push(tmp);
}

function new_enemies()
{
	if (enemies.length>0) return;
	var a1 = [Math.floor(Math.random()*4),Math.floor(Math.random()*3)];//[0 1 2 3],[0 1 2]
	if (a1[1]==a1[0]) a1[1]++;
	var a2 = [Math.floor(Math.random()*100),Math.floor(Math.random()*100)]
	
	for (var i=0;i<=1;i++)
	{
		var tmp = {};
		tmp.y=a1[i]*100+120;
		tmp.x=650+youx+a2[i];
		tmp.hp = 2;
		enemies.push(tmp);
	}
}

function new_heas()
{
	if (heas.length>0) return;
	var tmp = {};
	tmp.x=900+youx;
	if (tmp.x>1600) tmp.x-=800;
	tmp.y=150+Math.floor(Math.random()*300);
	heas.push(tmp);
}

function new_bons()
{
	if (bons.length>0) return;
	var tmp = {};
	tmp.x=600+youx;
	tmp.y=150+Math.floor(Math.random()*300);
	bons.push(tmp);
}

function new_bombs()
{
	if (bombs.length>0) return;
	var tmp = {};
	tmp.x=700+youx;
	tmp.y=150+Math.floor(Math.random()*300);
	bombs.push(tmp);
}

//MOVE
function move_enemies()
{
	for (var i=enemies.length-1;i>=0;i--)
	{
		enemies[i].x-=4;
		if (enemies[i].x<-100)
			enemies.splice(i,1);
	}
}

function move_bullets()
{
	var bul_del = 0;
	for (var i=buls.length-1;i>=0;i--)
	{
		bul_del = 0;
		buls[i].x+=9;
		for (var j=enemies.length-1;j>=0;j--)
		{
			if (bul_del==0)
				if (cls_ene_bul(j,i) == 1) 
					bul_del = 1;
		}
	}
	
	for (var i=buls.length-1;i>=0;i--)
	{
		if (bul_del==0)
			if (buls[i].x>880)
				buls.splice(i,1);
	}
}

function move_ebullets()
{
	for (var i=ebuls.length-1;i>=0;i--)
	{
		ebuls[i].x-=9;
		
		if (ebuls[i].x<-40)
			ebuls.splice(i,1);
	}
}

function game_keypress(e)
{
	if (endgame == 1) return 1;
	if (e.keyCode==37)
		{youmovex = -1; youmovey = 0;}
	if (e.keyCode==39)
		{youmovex = 1; youmovey = 0;}
		
	if (e.keyCode==38)
		{youmovex = 0; youmovey = -1;}
	if (e.keyCode==40)
		{youmovex = 0; youmovey = 1;}
	
	if (e.keyCode==32)
		new_bullet();
	return 0;
}

function move_you()
{
if (youx >= 800-5-imgx[1])
{
	youx-=800;
	ebuls.length = 0;
	for (var i=0;i<enemies.length;i++)
		enemies[i].x-=800;
	for (var i=0;i<bombs.length;i++)
		bombs[i].x-=800;
	for (var i=0;i<bons.length;i++)
		bons[i].x-=800;
	for (var i=0;i<heas.length;i++)
		heas[i].x-=800;
}
if (youx <= 0+5)
	{ youmovex = 1; youmovey = 0; }
if (youy >= 600-5-imgy[1])
	{ youmovey = -1; youmovex = 0; }
if (youy <= 0+5)
	{ youmovey = 1; youmovex = 0; }

youx += youmovex*5;
youy += youmovey*2;	

for (i=enemies.length-1;i>=0;i--)
	if (cls_you_ene(i) == 1)
		return 1;
for (i=ebuls.length-1;i>=0;i--)
		if (cls_you_ebul(i) == 1) 
			return 1;
for (i=bombs.length-1;i>=0;i--)
	if (cls_you_bombs(i) == 1) 
			return 1;
for (i=bons.length-1;i>=0;i--)
	if (cls_you_bons(i) == 1) 
			return 1;
for (i=heas.length-1;i>=0;i--)
	if (cls_you_heas(i) == 1) 
			return 1;
return 0;
}

//TIMER

function timer()
{
if (endgame == 1) return;
move_you();

tcount++;
if (tcount % 50 == 0)
{
	for (var i=0;i<enemies.length;i++)
	{
		if (Math.random()<0.2+Math.min(0.1,0.001*(tcount % 100) ) )
			new_ebullet(i);
	}
}

//MOVE
move_bullets();
if (move_ebullets() == 1) return;
move_enemies();

//NEW
new_enemies();
new_bombs();
new_bons();
new_heas();

document.onkeydown = game_keypress;
game_draw();
window.setTimeout("timer();", 20);
}

//DRAW

function images_init()
{
  for (var i=0;i<=7;i++)
  {
    var tmp = new Image();
    tmp.src = imgstr[i];
    imgs.push(tmp);
  }
}

function game_draw()
{
	images_init();
	var cnv = document.getElementById("canvas");
	var ctx = cnv.getContext("2d");
	
	ctx.drawImage(imgs[0],0,0);
	ctx.drawImage(imgs[1],youx,youy);
	
	for (var i=0;i<buls.length;i++)
		ctx.drawImage(imgs[2],buls[i].x,buls[i].y);
	
	for (var i=0;i<enemies.length;i++)
		ctx.drawImage(imgs[3],enemies[i].x,enemies[i].y);
	
	for (var i=0;i<ebuls.length;i++)
		ctx.drawImage(imgs[4],ebuls[i].x,ebuls[i].y);	
	
	for (var i=0;i<heas.length;i++)
		ctx.drawImage(imgs[5],heas[i].x,heas[i].y);
	
	for (var i=0;i<bons.length;i++)
		ctx.drawImage(imgs[6],bons[i].x,bons[i].y);
	
	for (var i=0;i<bombs.length;i++)
		ctx.drawImage(imgs[7],bombs[i].x,bombs[i].y);

	ctx.fillStyle = "#FFFF00";
	ctx.font = "bold 30pt Arial";
	ctx.fillText('$'+score,20,30);
	ctx.fillText('HP'+yhp,670,30);
}

window.addEventListener("load",game_draw,true);
