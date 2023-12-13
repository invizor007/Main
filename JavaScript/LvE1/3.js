var all_cards = [
10,10,10,10,10,10,
20,20,20,20,20,20,20,20,
30,30,30,30,30,30,30,30,
40,40,40,40,40,40,
50,50,50,50,50,50,
60,60,60,60,60,
70,70,70,70,70,
80,80,80,80,80,
90,90,90,90,90
];//карты с деньгами, их достоинство

var all_cardsC = 54;//количество этих карт
var CubesAllThrow=8;//количество кубиков

var used_cards = [];//использованные карты с деньгами среди списка
var cube_cards = [[0],[0],[0],[0],[0],[0]]; //выбранные карты под каждым значением кубика
var cards_count_num = [0,0,0,0,0,0];//количество карт под каждым значением кубика
var hodnum=0, stgnum = 0, konnum=0;//номер хода и номер стадии
var plnum=0, plcount=0;//номер игрока и количество игроков
var gameactive = 0;//Начата ли игра
var isneicube=0;//опция нейтральный кубик
var cube_stat = [[0,0,0,0,0,0,0,0],
[0,0,0,0,0,0,0,0],
[0,0,0,0,0,0,0,0],
[0,0,0,0,0,0,0,0],
[0,0,0,0,0,0,0,0]];//статистика того что выпало на кубиках
var plnames=['Red','Green','Blue','Yellow','White'];//название цвета каждого игрока
var plcubescount = [[0,0,0,0,0,0],
[0,0,0,0,0,0],
[0,0,0,0,0,0],
[0,0,0,0,0,0],
[0,0,0,0,0,0]];//количество кубиков каждого игрока под каждым значением на кубике. index1 - номер игрока , index2-  значение на кубике
var plmoney = [0,0,0,0,0];//количество денег у каждого игрока

//stg = 0 - бросок кубиков, 1- проверка значений на кубиках
/*
5 (60,70,80,90) 20
6 (10,40,50) 18
8 (20,30) 16
20+18+16=54
*/

function gm_init()//изначальная инициализация
{
alert('init');
}

function update_num6()
{
var htmltmp = '';
for (var i=0;i<6;i++)
{
	htmltmp +='<div><b>'+ (i+1) +':: </b>';
	for (var j=0;j<cards_count_num[i];j++)
	{
		htmltmp+='<i>'+cube_cards[i][j]+'</i>'+' ';
	}
	htmltmp+='&nbsp;';
	for (var j=0;j<5;j++)
	{
		htmltmp+='<b>'+plcubescount[j][i]+'</b>'+' ';
	}	
	htmltmp +='</div><br>'
}
document.getElementById('num6').innerHTML= htmltmp;
}

function update_maininfo()
{
document.getElementById('maininfo').innerHTML = '&nbsp;Ход номер '+hodnum+'. <br>&nbsp;Ходит игрок '+(plnum+1)+
'. <br>&nbsp;Кон номер '+(konnum+1)+'.';
if (stgnum==0)
{
	document.getElementById('maininfo').innerHTML+='<br>&nbsp;Бросьте кубики';
}
else if (stgnum==1)
{
	document.getElementById('maininfo').innerHTML+='<br>&nbsp;Выберите номер';
}
	
}
//
function update_cubevalues()
{
var htmltmp = '&nbsp;<input type="button" value="Бросить кубики" onclick="cube_throw()"><br>&nbsp;';
for (var i=0;i<CubesAllThrow;i++) if (cube_stat[plnum][i]<10)
{
	htmltmp+='<i>'+cube_stat[plnum][i]+'</i>'+' ';
}
//alert(isneicube);
if (isneicube > 0)
{
	for (var i=0;i<isneicube;i++) if (cube_stat[4][isneicube*plnum+i]<10)
	{
		htmltmp+='<i>'+cube_stat[4][isneicube*plnum+i]+'</i>'+' ';
	}
}

document.getElementById('statepanel').innerHTML= htmltmp;	
}

function update_plmoney()
{
var htmltmp = 'Деньги:<br>';
for (var i=0;i<plcount;i++) 
{
	htmltmp+='&nbsp;<b>'+plmoney[i]+'</b>'+'<br>';
}
document.getElementById('plmoney').innerHTML= htmltmp;		
}

function outcubestat()
{
	var s='';
	for (var i=0;i<2;i++)
	{	
		for (var j=0;j<8;j++)
		{
			s+=cube_stat[i][j]+' ';
		}
	s+=' # ';
	}
	alert(s);
}

function outplcubecount()
{
	var s='';
	for (var i=0;i<2;i++)
	{	
		for (var j=0;j<6;j++)
		{
			s+=plcubescount[i][j]+' ';
		}
	s+=' # ';
	}
	alert(s);
}

function make_cube_cards()
{
for (var i=0;i<6;i++)
{
	var sum=0,j=0;
	do
	{
		do
		{
			var tmp = Math.floor(Math.random()*all_cardsC);
		}
		while (used_cards[tmp]==1);
		used_cards[tmp]=1;
		sum+=all_cards[tmp];
		cube_cards[i][j]=all_cards[tmp];
		j++;
	}
	while (sum<50);
	cards_count_num[i]=j;
}	
}

function nullcubestat()
{
	for (var i=0;i<5;i++)
		for (var j=0;j<8;j++)
		{
			cube_stat[i][j]=0;
		}
}
 
function gm_start()//старт новой игры
{
alert('Начинаем игру');
gameactive = 1;
plnum = 0;
hodnum = 1; 
stgnum = 0;
konnum = 0;

plcount = document.getElementById("plcount").value;
isneicube = 2;
if (plcount == 5) {isneicube = 0;}
if (plcount == 2) {isneicube = 4;}
if (! document.getElementById("neicube").checked)
{
	isneicube = 0;
}
update_maininfo();

for (var i=0;i<all_cardsC;i++) {used_cards[i]=0;}
make_cube_cards();


for (var i=0;i<5;i++)//цикл по игрокам
	for (var j=0;j<6;j++)//цикл по значениям на кубике
		plcubescount[i][j]=0;


update_num6();
update_plmoney();
}

function cube_throw()//бросить кубики
{
if (gameactive==0) {alert('Игра еще не начата'); return;}
if (stgnum!=0) {alert('Сейчас нельзя бросить кубики');return 1;}
for (var i=0;i<CubesAllThrow;i++) if (cube_stat[plnum][i]<10)
{
	var r = Math.floor(Math.random()*6)+1;
	cube_stat[plnum][i]=r;
}
stgnum = 1;
update_maininfo();



if (isneicube>0)//есть нейтральные кубики, они всегда под индексом 4 то есть как у последнего игрока
{
	for (var i=0;i<isneicube;i++)
	{
		var r = Math.floor(Math.random()*6)+1;
		cube_stat[4][plnum*isneicube+i]=r;
	}
}

update_cubevalues();


var b=true;
for (var i=0;i<8;i++)
{
	if (cube_stat[plnum][i]<10) {b=false}
}
	
if (b)
{
	alert('У вас нет кубиков, ход передан следующему игроку');
	stgnum=0;
	plnum++;
	if (plnum>=plcount) {plnum=0;}
}
update_maininfo();

}


function calc_plcubescount()
{
for (var i=0;i<5;i++)//цикл по игрокам
	for (var j=0;j<6;j++)//цикл по значениям на кубике
		plcubescount[i][j]=0;
	
for (var i=0;i<5;i++)//цикл по игрокам, причем по всем
	for (var j=0;j<8;j++)//цикл по восьми кубикам
	{
		if (cube_stat[i][j]>=10)
		{
			var r = cube_stat[i][j]-10;
			plcubescount[i][r-1]++;
		}
	}	
}

function calc_money()//подсчитать прирост денег для каждого игрока
{
	alert("Считаем деньги");
//подсчитать plcubescount
/*
for (var i=0;i<5;i++)
	for (var j=0;j<8;j++)
	{
		if (cube_stat[i][j]>=10)
		{
			var r = cube_stat[i][j]-10;
			plcubescount[i][r-1]++;
		}
	}
*/
calc_plcubescount();
//удалить дубликаты для plcubescount
for (var i=0;i<6;i++)
	for (var j=0;j<5;j++)
	{
		var hasdupl = 0;
		for (var k=j+1;k<5;k++)
			if (plcubescount[j][i]==plcubescount[k][i])
				{
					plcubescount[k][i]=0;//or +10 or +100
					hasdupl = 1;
				}
		if (hasdupl == 1)
		{
			plcubescount[j][i]=0;
		}
	}
//подсчитать деньги
for (var i=0;i<6;i++)//для каждого значения на кубике
{
	var money = 0; //alert("i="+i);
	//выбрать игрока который имеет максимальное значение по plcubescount
	for (var c=0;c<cards_count_num[i];c++)// пробегаемся по всем ставкам и определяем игрока которому эта карта достается
	{ //alert("c="+c+" cards_count_num[i]="+cards_count_num[i]);
		//1. определяем номер игрока
		var plmax = -1, vmax = 0;
		for (var j=0;j<plcount;j++)
		{
			if (plcubescount[j][i]>vmax) {vmax = plcubescount[j][i]; plmax = j;}
		}
		if (plmax==-1) {break;}
		
		plcubescount[plmax][i] = 0; //alert("plmax="+plmax+" vmax="+vmax);		
		
		//2. определяем номер карты
		var moneymax = 0, mimax = 0;
		for (var j=0;j<cards_count_num[i];j++)
		{
			if (cube_cards[i][j]>moneymax) {moneymax = cube_cards[i][j]; mimax = j;}
		}		
		cube_cards[i][mimax]=0; //alert("mimax="+mimax+" moneymax="+moneymax);
		plmoney[plmax]+=moneymax;
	}
}

update_plmoney();

if (konnum<4)
{
	konnum++;
	nullcubestat()
	make_cube_cards();

	for (var i=0;i<5;i++)//цикл по игрокам
		for (var j=0;j<6;j++)//цикл по значениям на кубике
			plcubescount[i][j]=0;	
			
	update_maininfo();
	update_num6();
	update_cubevalues();
}
else
{
	//Игра закончилась
	alert('Игра завершилась. Начните новую игру.');
	gameactive = 0;
}


return 0;
}

function test()
{
	outcubestat();
	outplcubecount();
	calc_money();
}

function allonlyupper10()
{
	var b=true;
	for (var i=0;i<8;i++)
		for (var j=0;j<plcount;j++)
			if (cube_stat[j][i]<10) {b=false;}
		
	if (isneicube>0)
	{
		for (var i=0;i<isneicube;i++)
			for (var j=0;j<plcount;j++)
			{
				if (cube_stat[4][j*isneicube+i]<10) {b=false;}
			}
	}
	return b;
}

function choose_num()//выбрать номер на кубике согласно инпуту
{
	if (gameactive==0) {alert('Игра еще не начата'); return;}
	var chnum = document.getElementById("chnum").value;
	var isnumber = 0; //alert(chnum);
	for (var i=0;i<CubesAllThrow;i++)
	{
		if (cube_stat[plnum][i]==chnum)
		{
			cube_stat[plnum][i] += 10;
			isnumber=1;
		}
		
	}
	
	//if (isneicube>0)
	//{
		for (var i=0;i<isneicube;i++)
		{
			if (cube_stat[4][plnum*isneicube+i]==chnum)
			{
				cube_stat[4][plnum*isneicube+i] += 10;
				isnumber=1;
			}
		}
	//}	
	
	if (isnumber==0)
	{
		alert('Среди кубиков нет указанного номера. Пробуйте еще раз.');
		return -1;
	}
	else
	{
		alert('Выполнено успешно.');
		stgnum = 0;
		plnum++; //alert(plnum) 1;alert(plcount); 2
		calc_plcubescount();
		if (plnum>=plcount) 
		{
			plnum=0;
			hodnum++;
		}
		update_maininfo();
		update_num6();
		//alert(allonlyupper10());
		
		
		if (allonlyupper10())
		{
			calc_money();
			plnum=0;
			//
			hodnum++;
		}
		
		
		return 0;
	}
}

