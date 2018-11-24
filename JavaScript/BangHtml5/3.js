"use strict";
var MPC=8, PersonC=16, ArrowC=9, FCC=5;


var RoleNames = ['Шериф', 'Помощник шерифа', 'Бандит', 'Ренегат'];
var PersonNames = ['Журдоннэ','Росс Логан','Кит Карсон',//7
        'Сюзи Лафайет','Туко Рамирес','Бутч Кэссиди', 'Бедовая Джейн', 'Малыш Билли',//8
        'Ангельские глазки', 'Счастливый Люк','Блэк Джек', 'Том Кетчум',//8
        'Хладнокровная Рози', 'Большой Змей', 'Поль Регрет', 'Джесси Джеймс'];//9

var PersonInfo = 
['Вы не можете потерять больше единицы здоровья при нападении индейцев',
'Когда вы теряете одну или несколько единиц жизни из-за другого игрока, этот игрок должен взять стрелу',
'За каждый свой гатлинг вы можете сбросить одну стрелу у любого игрока',

'Если вы не выбросили на кубиках 1 и 2, получите 2 единицы здоровья',
'Всякий раз когда вы теряете единицу здоровья, можете сбросить одну из стрел',
'Можете брать стрелы вместо того чтобы терять здоровье, исключение - динамит, индейцы',
'Можете использовать 1 как 2 и наоборот',
'Вам достаточно двух значений "гатлинг" на кубиках чтобы запустить гатлинг',
'Один раз можете использовать пиво чтобы удвоить 1 и 2',
'Можете один раз дополнительно перебросить кубики',
'Можете перебрасываеть динамит, если только не выпало 3 и больше',
'В начале вашего хода игрок по вашему выбору получает единицу здоровья',

'Можете использовать 1 и 2 на игроков на единицу дальше',
'Всякий раз когда погибает игрок, вы получаете 2 единицы здоровья',
'Вы не теряете единицы здоровья при стрельбе из гатлинга',
'Если у вас 4 единицы здоровья и меньше вы восстанавливаете 2 единицы здоровья вместо 1'];

var CB1Checked = false, CB2Checked = false;
var PersonHP = [7,7,7,8, 8,8,8,8, 8,8,8,8, 9,9,9,9];
var AllRole = [ [0,0,0,0,0,0,0,0], [0,0,0,0,0,0,0,0], [0,2,0,0,0,0,0,0], [0,2,3,0,0,0,0,0] 
  [0,1,2,2,0,0,0,0], [0,1,2,2,3,0,0,0], [0,1,2,2,2,3,0,0], [0,1,1,2,2,2,3,0], [0,1,1,2,2,2,3,3] ];
var Players = [];
var Game, FiveCubes, RandUsed;
var imgs = [];


class TPlayer {

  constructor (id,person,rolenum,role,health,mhealth,arrows) {
    this.id = id;
    this.person = person;
    this.rolenum = rolenum;
    this.role = role;
    this.health = health;
    this.mhealth = mhealth;
    this.arrows = arrows;
  }

  Init(iid) 
  {
    this.id = iid;
  }

  Heal(v) 
  {
    if ( (this.person == 15) && (this.health<=4) && (v==1) ) 
      {v=2;}

    this.health+=v;
    if (this.health>this.mhealth)
      {this.health=this.mhealth;}
  }

  Damage(v,typical)
  {

    if ((CB1Checked) && (this.person==4) && (this.arrows>0))
    {
      this.arrows--;
      Game.BankArrows++;    
    }

    
    if ((CB2Checked) && (this.person==5))
    {
      this.arrows++;
      Game.BankArrows--;
      if (Game.BankArrows == 0)
        {Game.ArrowsToBank();}
      return;
    }

    this.health-=v;
    if (this.health<=0)
    {
      this.health=0;
      this.Dead();          
    }


    if ( (this.person == 1) && (this.id!=Game.CurrPlayer) && (Game.Per1==0) )
    {
      Players[Game.CurrPlayer].arrows++;
      Game.BankArrows--;
      if (Game.BankArrows == 0)
        {Game.ArrowsToBank();}
      Game.Per1=1;
    }

  }


  Dead()
  {
    alert('Игрок номер '+this.id+' мертв. Его роль - '+RoleNames[this.role]);
    Game.BankArrows+=Players[this.id].arrows;

    if (Game.CurrPlayer > this.id)
      {Game.CurrPlayer--;}

    for (var i = this.id; i<=Game.PlayerCount - 2; i++ )
    {
        Players[i].id=i;
        Players[i].person=Players[i+1].person;
        Players[i].rolenum=Players[i+1].rolenum;
        Players[i].role=Players[i+1].role;
        Players[i].health=Players[i+1].health;
        Players[i].mhealth=Players[i+1].mhealth;
        Players[i].arrows=Players[i+1].arrows;
    }


    Game.PlayerCount--;

    Game.SherifPlayer=-1;
    for (var i = 0; i<=Game.PlayerCount - 1; i++)
    {
      if (Players[i].role == 0)
        {Game.SherifPlayer=i;}
    }
        

    for (var i = 0; i<=Game.PlayerCount - 1; i++)
    {
      if (Players[i].person == 13)
        Players[i].Heal(2);
    }
        

    LaMatrixOut();
    CurrPlayerInfoOut();


    if (Game.PlayerCount == 1)
    {
      if (Players[0].role <= 1) {alert("Команда шерифа победила");}
      if (Players[0].role == 2) {alert("Команда бандитов победила");}
      if (Players[0].role == 3) {alert("Ренегат победил");}
      return;      
    }


    if (Game.SherifPlayer==-1)
    {
      alert("Команда бандитов победила");
      return;
    }

    if (Game.OnlyGoodRoles())
    {
      alert("Команда шерифа победила");
      return;
    }
  }
}



class TGame{

  constructor (PlayerCount,wPlayerCount, CurrPlayer, SherifPlayer,BankArrows, CurrCubeUse, Per1, Per2, Per8, Per11)
  {
    this.PlayerCount = PlayerCount;
    this.wPlayerCount = wPlayerCount;
    this.CurrPlayer = CurrPlayer;
    this.SherifPlayer = SherifPlayer;
    this.BankArrows = BankArrows;
    this.CurrCubeUse = CurrCubeUse;
    this.Per1 = Per1;
    this.Per2 = Per2;
    this.Per8 = Per8;
    this.Per11 = Per11;
  }

  
  GiveRoles()
  {
    var r = 0;
    RandUsed.Clear();
    for (var i=0;i<this.PlayerCount;i++)
    {      
      do
      {
        r=Math.floor(Math.random()*this.PlayerCount); 
      }
      while (RandUsed.Used(r)==true);

      RandUsed.Put(r); 
      Players[i].rolenum=r;
      Players[i].role=AllRole[this.PlayerCount][r];
    }
  }

  
  GivePersons()
  {
    var r = 0;
    this.BankArrows=ArrowC;
    this.CurrCubeUse=-1;
    RandUsed.Clear; 
    for (var i=0;i<this.PlayerCount;i++)
    {
      do
      {
        r=Math.floor(Math.random()*PersonC);
      }        
      while (RandUsed.Used(r)==true);

      RandUsed.Put(r);
      Players[i].person=r;
      Players[i].mhealth=PersonHP[r];
      if (Players[i].role == 0)
      {
        this.CurrPlayer=i;
        this.SherifPlayer=i;
        if (this.PlayerCount!=2)
          {Players[i].mhealth=PersonHP[r]+2;}        
      }
      Players[i].health=Players[i].mhealth;
    }
    
  }
  
  
  ArrowsToBank()
  {
    for (var i=0;i<Game.PlayerCount;i++)
    {
      var v=Players[i].arrows;
      if ( (v>0) && (i!=Game.CurrPlayer) )
      {
        if (Players[i].person == 0) {v=1;}
        Players[i].Damage(v,0);
        Players[i].arrows=0;      
      }
    }
    Players[Game.CurrPlayer].arrows=0;
    this.BankArrows=ArrowC;
  }


  GoodTargetPlayer(pl1,pl2,v)
  {
    var b=false;
    if ((pl1+v) % Game.PlayerCount == pl2) {b=true;}
    if ((pl2+v) % Game.PlayerCount == pl1) {b=true;}
    if (this.PlayerCount <= 3) {b=true;}

    if (Players[Game.CurrPlayer].person==12)
    {
      var v2=v+1;
      if ((pl1+v2) % Game.PlayerCount == pl2) {b=true;}
      if ((pl2+v2) % Game.PlayerCount == pl1) {b=true;}     
    }

    if (Players[Game.CurrPlayer].person==6)
    {
      var v2=3-v;
      if ((pl1+v2) % Game.PlayerCount == pl2) {b=true;}
      if ((pl2+v2) % Game.PlayerCount == pl1) {b=true;}
    }
    return b;
  }
  

  OnlyGoodRoles()
  {
    var b=true;
    for (var i=0;i<Game.PlayerCount;i++)
    {
      if ((Players[i].role == 2)||(Players[i].role == 3)) 
        {b=false;}
    }
    return b;
  }
}



class TRandUsed
{
  constructor ()
  {
    this.a=[-1,-1,-1,-1,-1,-1,-1,-1];
  }
  
  Used(r)
  {
    var b=false;
    for (var i=0;i<MPC;i++)
    {
      if (this.a[i]==r) {b=true;}  
    }
    return b;
  }

  Clear()
  { 
    for (var i=0;i<MPC;i++)
    {
      this.a[i]=-1;
    }
  }

  Put(r)
  {
    var i=0;
    while (this.a[i]!=-1) {i++;}
    this.a[i]=r;
  }
}


class TFiveCubes
{

  constructor ()
  {
    this.a = [6,6,6,6,6];
    this.fixed = [0,0,0,0,0];
    this.used = [-1,-1,-1,-1,-1];
    this.step = 0;
  }

  Init()
  {
    for (var i=0;i<FCC;i++)
    {
      this.a[i]=6;
      this.fixed[i]=0;
      this.used[i]=-1;      
    }
    this.step=0;
  }

  Fix(i,v)
  {
    this.fixed[i]=v; 
  }
  
  
  ThrowCubes()
  {
    var r=0,v=0;
    if (Players[Game.CurrPlayer].person == 9)
      {v=4;} 
    else 
      {v=3;}

    if (this.step>=v)
    {
      alert("Вы уже перерасывали кубики максимальное количество раз или выпало 3 динамита");
      return;
    }

    for (var i=0;i<FCC;i++)
    {
      if (this.fixed[i]==0)
      {
        r=Math.floor(Math.random()*6);
        if ( (r==0) && (Players[Game.CurrPlayer].person!=10) )
        {
          this.fixed[i]=2;
          this.used[i]=2;
        }

        if (r==5)
        {
          this.used[i]=2;
          Players[Game.CurrPlayer].arrows++;
          Game.BankArrows--;
          if (Game.BankArrows == 0)
            {Game.ArrowsToBank();}
        }
        
        if ((r>=1)&&(r<=4))
        {
          this.used[i]=0;
        }
        this.a[i]=r;
      }
    }

    this.step++;

    //Проверяется выпадение трех динамитов
    r=0;
    for (var i=0;i<FCC;i++)
    {
      if (this.a[i]==0) {r++;}
    }
        
    if (r>=3)
    {
      alert("Выпали 3 динамита");
      Step1Click();
      Players[Game.CurrPlayer].Damage(1,0);
      LaMatrixOut();
      CurrPlayerInfoOut();      
    }
  }
    

  CanNextPlayer()
  {
    var b=true;
    for (var i=0;i<FCC;i++)
    {
      if ( (this.a[i]>=1) && (this.a[i]<=2) && (this.used[i]==0) )
        b=false;      
    }
    return b;
  }

}


function qq(s)
{
  alert(s);
}


function ImageInit()
{
  for (var i=0;i<=6;i++)
  {
    var tmp = new Image();
    tmp.src = "Cubes\\"+i+".bmp";
    imgs.push(tmp);
  }
  
}


function GameInit()
{
  Game = new TGame(8,8,0,0,9,0, 0,0,0,0);
  RandUsed = new TRandUsed();
  FiveCubes = new TFiveCubes();
  for (var i = 0; i< MPC; i++)
  {
    var tmp = new TPlayer(i,0,0,0,0,0,0);
    Players.push(tmp);
  }

  //ImageInit();
}


function ShowRoleClick()
{
  alert('Ваша роль - '+RoleNames[Players[Game.CurrPlayer].role]);
}


function ShowPersonClick()
{
  alert('Ваша способность : '+PersonInfo[Players[Game.CurrPlayer].person]);
}


function ChB1Click()
{
  CB1Checked = document.getElementById("ChB1").checked;
}


function ChB2Click()
{
  CB2Checked = document.getElementById("ChB2").checked;
}


function LaMatrixOut()
{
  var ctx = document.getElementById("CanvasPlayerArray").getContext("2d");
  ctx.fillStyle='#8080ff';
  ctx.fillRect(0,0,270,275);

  for (var i=0;i<MPC;i++)
  {
    if (i>=Game.PlayerCount) 
      {ctx.fillStyle='#808080';}
    else
      {ctx.fillStyle='#00FF00';}
    if (i==Game.CurrPlayer)
      {ctx.fillStyle='#008080';}
    if (i==Game.SherifPlayer)
      {ctx.fillStyle='#FFFF00';}
    ctx.fillRect(5,i*32,260,30);
  }
  

  var s ="";
  ctx.fillStyle='#000000';
  for (var i=0;i<Game.PlayerCount;i++)
  {
    s=PersonNames[Players[i].person]+" HP: "+Players[i].health+'/'+Players[i].mhealth+" Стрел: "+Players[i].arrows;
    ctx.fillText(s,15,i*32+15);
  }

  document.getElementById("BankArrowCount").innerHTML='Стрел в банке '+Game.BankArrows;  
}


function CubesInfoOut()
{
  var ctx = document.getElementById("CanvasCubes").getContext("2d");

  for (var i=0;i<FCC;i++)
  {
    if (FiveCubes.a[i]!=-1)
    {
      ctx.drawImage(imgs[FiveCubes.a[i]],100*i,0,100,100);
    }
  }
}


function CubesThrowInfoOut()
{
  var ctx = document.getElementById("CanvasCubes").getContext("2d");  
  var s = "Бросать";
  for (var i=0;i<FCC;i++)
  {
    if (FiveCubes.fixed[i] == 0)
      { ctx.fillStyle = '#00FF00'; }
    else
      { ctx.fillStyle = '#FF0000'; }

    ctx.fillRect(100*i,100,100,30);
  }

  ctx.fillStyle = '#000000';
  for (var i=0;i<FCC;i++)
  {
    if (FiveCubes.fixed[i] == 0)
      { s="Бросать"; }
    else
      { s="Не бросать"; }
    ctx.fillText(s,100*i+15,115);
  }
}


function CubesUsedInfoOut()
{
  var ctx = document.getElementById("CanvasCubes").getContext("2d");  
  var s = "Использовать";
  for (var i=0;i<FCC;i++)
  {
    if (FiveCubes.used[i] <= 1)
      { ctx.fillStyle = '#FFFF00'; }
    else
      { ctx.fillStyle = '#FF0000'; }

    if (i==Game.CurrCubeUse)
    {
      ctx.fillStyle = '#00FFFF';
    }

    ctx.fillRect(100*i,130,100,30);
  }

  ctx.fillStyle = '#000000';
  for (var i=0;i<FCC;i++)
  {
    if (FiveCubes.used[i] <= 1)
      { s="Использовать"; }
    else if (FiveCubes.used[i]==3)
      { s="Уже использовано"; }
    else
      { s="Не используется"; }

    if (i==Game.CurrCubeUse)
    {
      s="Выберите игрока";
    }
    ctx.fillText(s,100*i+15,145);
  }
}


function CurrPlayerInfoOut()
{
  document.getElementById("LabelPlayerName").innerHTML=PersonNames[Players[Game.CurrPlayer].person];
  document.getElementById("LabelCurrPlayer").innerHTML='Игрок номер '+(Game.CurrPlayer+1);
  document.getElementById("LabelHP").innerHTML='Количество жизней= '+Players[Game.CurrPlayer].health+'/'+Players[Game.CurrPlayer].mhealth;
  document.getElementById("LabelArrows").innerHTML='Количество стрел= '+Players[Game.CurrPlayer].arrows;
}


function GameStart()
{
  GameInit();
  alert("Игра начинается");

  var value = document.getElementById("ChoosePlayerCount").value;
  Game.PlayerCount = Number(value);

  if ((Game.PlayerCount < 2) || (Game.PlayerCount>8))
  {
    alert("Введите число от 2 до 8");
    return;
  } 

  for (var i=0;i<Game.PlayerCount;i++)
  {
    Players[i].Init(i);
  }
      
  Game.GiveRoles();
  Game.GivePersons();
  FiveCubes.Init();

  document.getElementById("ChB1").disabled = true;
  document.getElementById("ChB2").disabled = true;

  for (var i=0;i<Game.PlayerCount;i++)
  {
    if (Players[i].person==4) 
      {
        document.getElementById("ChB1").disabled = false;
      }
    if (Players[i].person==5) 
      {
        document.getElementById("ChB2").disabled = false;
      }
  }
  

  LaMatrixOut();
  CurrPlayerInfoOut();

  CubesInfoOut();
  CubesThrowInfoOut();
  CubesUsedInfoOut();
}


function GameEnd()
{
  var ctx=document.getElementById("CanvasCubes").getContext("2d");
  ctx.fillStyle='#8080ff';
  ctx.fillRect(0,0,500,160);
  ctx=document.getElementById("CanvasPlayerArray").getContext("2d");
  ctx.fillStyle='#8080ff';
  ctx.fillRect(0,0,270,275);

  document.getElementById("BankArrowCount").innerHTML='Стрел в банке ';  
  document.getElementById("LabelPlayerName").innerHTML='Имя';
  document.getElementById("LabelCurrPlayer").innerHTML='Игрок номер ';
  document.getElementById("LabelHP").innerHTML='Количество жизней ';
  document.getElementById("LabelArrows").innerHTML='Количество стрел ';
}


function Step0Click()
{
  FiveCubes.ThrowCubes();
  CubesInfoOut();
  CubesThrowInfoOut();
  CubesUsedInfoOut();

  LaMatrixOut();
  CurrPlayerInfoOut();
}


function Step1Click()
{
  if (FiveCubes.step == 0)
  {
    alert("Сначала необходимо бросить кубики");
    return;
  }

  FiveCubes.step=5;

  if (Players[Game.CurrPlayer].person == 3)
  {
    var v=1;
    for (var i=0;i<FCC;i++)
    {
      if ((FiveCubes.a[i] >= 1) && (FiveCubes.a[i] <= 2))
        {v = 0; }
    }

    if (v==1)
    {
      alert("Вы лечитесь на 2 единицы здоровья");
      Players[Game.CurrPlayer].heal(2);
    }
  }

}


function Step2Click()
{
  if (FiveCubes.step!=5)
  {
    alert("Сначала необходимо бросить и применить кубики");
    return;
  }

  if (FiveCubes.CanNextPlayer()==false)
  {
    alert("Сначала необходимо применить все кубики с выстрелами");
    return;
  }

  Game.Per1=0;
  Game.Per2=0;
  Game.Per8=0;
  Game.Per11=0;

  Game.CurrPlayer++;
  if (Game.CurrPlayer==Game.PlayerCount) 
    {Game.CurrPlayer=0;}

  FiveCubes.Init();
  CubesInfoOut();
  CubesThrowInfoOut();
  CubesUsedInfoOut();

  LaMatrixOut();
  CurrPlayerInfoOut();
}


function UseAbility()
{
  switch (Players[Game.CurrPlayer].person)
  {
    case 2:
      Game.Per2 = 1- Game.Per2;
      if (Game.Per2 == 1)
        {alert("Способность активирована");}
      else
        {alert("Способность деактивирована");}
      break;

    case 8:
      Game.Per8 = 1- Game.Per8;
      if (Game.Per8 == 1)
        {alert("Способность активирована");}
      else
        {alert("Способность деактивирована");}      
      break;

    case 11:
      Game.Per11 = 1 - Game.Per11;
      if (Game.Per11 == 1)
        {alert("Способность активирована");}
      else
        {alert("Способность деактивирована");}      
      break;

    default:
      alert("Способность вашего персонажа не требует активации");
  }
}


function CanvasCubesClick(e)
{
  //alert("LFixCubesClick+LUseCubesClick");
  var ItemClicked = {X:0, Y:0};
  //alert(e.clientX); alert(e.clientY);
  ItemClicked.X = Math.trunc( (e.clientX-490) / 100) ;
  if ( (e.clientY-60>100) && (e.clientY-60<130) )
    { ItemClicked.Y=1; }
  else if ( (e.clientY-60>130) && (e.clientY-60<160) )
    { ItemClicked.Y=2; }
  else 
    { ItemClicked.Y=0; }
  
  //alert(ItemClicked.X);alert(ItemClicked.Y);

  if (ItemClicked.Y==1)
  {
    if (FiveCubes.step==0)
    {
      alert("В первый раз бросаются все кубики");
      return;
    }

    if (FiveCubes.step==5)
    {
      alert("Значения на кубиках уже зафиксированы");
      return;
    }

    if (FiveCubes.fixed[ItemClicked.X]==0)
    {
      FiveCubes.Fix(ItemClicked.X,1);
      CubesThrowInfoOut();      
    }
    else if (FiveCubes.fixed[ItemClicked.X]==1)
    {
      FiveCubes.Fix(ItemClicked.X,0);
      CubesThrowInfoOut();
    }
  }

  if (ItemClicked.Y==2)
  {
    if (FiveCubes.step!=5)
    {
      alert("Необходимо перейти на стадию применения значений на кубиках");
      return;
    }

    if (FiveCubes.used[ItemClicked.X]==0)
    {
      FiveCubes.used[ItemClicked.X]=1; //qq("01 "+ItemClicked.X);
      Game.CurrCubeUse = ItemClicked.X;
      CubesUsedInfoOut();      
    }
    else if (FiveCubes.used[ItemClicked.X]==1)
    {
      FiveCubes.used[ItemClicked.X]=0;//qq("02 "+ItemClicked.X);
      Game.CurrCubeUse = ItemClicked.X;
      CubesUsedInfoOut();
    }

  }
}



function LaMatrixClick(e)
{
  //alert("LaMatrixClick");

  var ItemClicked = 0;
  //alert(e.clientX); alert(e.clientY);
  ItemClicked = Math.trunc( (e.clientY-60) / 30) ;
  //alert(ItemClicked);

  var v,v2,TargetPlayer,i,j;
  var b=false;

  if (Game.Per11==1)
  {
    TargetPlayer=ItemClicked;
    Players[TargetPlayer].Heal(1);
    LaMatrixOut();
    CurrPlayerInfoOut();
    Game.Per11=2;
    //LaSpecOptions.Color:=clLime;
    return;
  }

  
  if (Game.CurrCubeUse == -1)
  {
    alert("Выберите кубик для применения");
    return;
  }
  alert("Применяем кубик "+(Game.CurrCubeUse+1));

  v=FiveCubes.a[Game.CurrCubeUse];
  TargetPlayer=ItemClicked;
  switch (v)
  {
    case 1:
      if (Game.GoodTargetPlayer(Game.CurrPlayer,TargetPlayer,1))
      {
        Players[TargetPlayer].Damage(1,1);
        LaMatrixOut();
        CurrPlayerInfoOut();
      }
      else
      {
        alert("Для применения кубика выберите соседнего игрока");
        return;
      }
      break;

      
    case 2:
      if (Game.GoodTargetPlayer(Game.CurrPlayer,TargetPlayer,2))
      {
        Players[TargetPlayer].Damage(1,1);
        LaMatrixOut();
        CurrPlayerInfoOut();
      }
      else
      {
        alert("Для применения кубика выберите игрока через одного");
        return;
      }
      break;

      
    case 3:
      if (Game.Per2==1)
      {
        if (Players[TargetPlayer].arrows==0) {return;}
        Players[TargetPlayer].arrows--;
        Game.BankArrows++;
        LaMatrixOut();
        CurrPlayerInfoOut();          
      }

      if (Game.Per2==0)
      {
        var j=0;
        for (var i=0;i<FCC;i++)
        {
          if (FiveCubes.a[i]==3) {j++;}
        }

        if (Players[Game.CurrPlayer].person==7)
          {v2=2;}
        else
          {v2=3;}

        if (j<v2)
        {
          alert("У вас недостаточно кубиков чтобы запустить гатлинг");
          return;
        }
        else
        {
          for (var i=0;i<Game.PlayerCount;i++)
          {
            if ( (i!=Game.CurrPlayer)&&(Players[i].person!=14) )
              { Players[i].Damage(1,1);}
          }
          LaMatrixOut();
          CurrPlayerInfoOut()
        }

        j=0;
        for (var i=0;i<FCC;i++)
        {
          if ( (FiveCubes.a[i]==3)&&(j<v2) )
          {
            FiveCubes.used[i]=3;
            j++;
          }
        }
        CubesUsedInfoOut();
      }
      break;

      
    case 4:
      if (Game.Per8==1)
      {
        v2=0;
        for (var i=0;i<FCC;i++)
        {
          if ( (FiveCubes.a[i]==1) && (v==0) ) {v2=1;}
          if ( (FiveCubes.a[i]==2) && (v==0) ) {v2=2;}
          if ( (FiveCubes.a[i]==1) && (v==2) ) {v2=3;}
          if ( (FiveCubes.a[i]==2) && (v==1) ) {v2=3;}
        }

        if (v2==0)
        {
          alert("Для применения пива как 1 и 2 необходимо выпадение 1 или 2");
          return;
        }

        if (v!=3)
        {
          b=Game.GoodTargetPlayer(Game.CurrPlayer,TargetPlayer,v)
        }
        else
        {
          b=Game.GoodTargetPlayer(Game.CurrPlayer,TargetPlayer,1) || Game.GoodTargetPlayer(Game.CurrPlayer,TargetPlayer,2);
        }

        if (b)
        {
          Players[TargetPlayer].Damage(1,1);
          LaMatrixOut();
          CurrPlayerInfoOut();            
        }
        else
        {
          alert("Выберите подходящую кубикам цель");
          return;
        }
        Game.Per8=2;
        //LaSpecOptions.Color:=clLime;          
      }

      if (Game.Per8==0)
      {
        Players[TargetPlayer].Heal(1);
        LaMatrixOut();
        CurrPlayerInfoOut()
      }
      break;

  }

  FiveCubes.used[Game.CurrCubeUse]=3;
  Game.CurrCubeUse=-1;
  CubesUsedInfoOut();
}


