"use strict";
var MaxPlayerC = 5,
CardTypeC = 14,
SpecialCardC = 4,
SCardTypeCX = 2, SCardTypeCY = 2,
CardTypeCX = 7, CardTypeCY = 2,
BmpCardX = 65, BmpCardY = 100;


var CurrPlayerCount = 0,
Step = 0,
EndGame = 0,
Retry = 0,
Doubles = 0;

var CurrCubeNumber = 0, CurrCubeCount = 0, CurrPlayerCount = 0, CurrPlayer = 0, IsDoubles = 0;

var SpecialCardCost = [4,10,16,22];
var SCardInfo = ['Вы можете бросать 2 кубика вместо 1', 'Каждое ваше кафе, ресторан, пекарня, магазин приносит на одну монету больше',
  'Если на кубиках выпал дубль сделайте еще ход', 'Один раз можете перебросить кубики'];


var Money = [0,0,0,0,0,0];
var Cards = new Array(MaxPlayerC+1); 
var SCards = new Array(MaxPlayerC+1);


var CardTypes = {  
  eff:[0,0,2,1,1,0,3,3,1,1,0,0,2,1],
  value:[1,2,3,2,4,5,6,6,7,8,9,10,9,11],
  value2:[1,2,3,3,4,5,6,6,7,8,9,10,10,12],
  bonus:[1,1,1,1,3,1,2,5,3,3,5,3,2,2],
  cost: [1,1,2,1,2,3,6,7,5,3,6,3,3,2],
  name: ["Пшеничное поле","Ферма","Кафе","Пекарня","Магазин","Лес","Стадион","Телецентр","Сыроварня","Мебельная фабрика","Шахта","Яблоневый сад","Ресторан","Фруктовый рынок"]
}



function GameStart()
{
 
  var value = document.getElementById("ChoosePlayerCount").value;
  CurrPlayerCount = Number(value);

  if ((CurrPlayerCount < 2) || (CurrPlayerCount>5))
  {
    alert("Введите число от 2 до 5");
    return;
  } 

  EndGame = 1;
  CardImageInit();
  PlayerStartInit();
  MoneyOut();
  document.getElementById("label2").innerHTML='Ходит игрок номер '+ CurrPlayer;
  document.getElementById("label3").innerHTML='Количество золота = '+ Money[CurrPlayer];
  document.getElementById("label4").innerHTML='Выпало число ';
}



function GameEnd()
{  
  EndGame = 0;
}



function CardImageInit () 
{
  var img1 = new Image();
  img1.src = "Cards.png";
  var ctx1 = document.getElementById("Canvas1").getContext("2d");
  var ctx2 = document.getElementById("Canvas2").getContext("2d");
  var ctx5 = document.getElementById("Canvas5").getContext("2d");
  img1.onload= function()
  {        
    ctx1.drawImage(img1, 0, 0);        
    ctx1.font = "18px Arial";
    for (var i=0;i<CardTypeCY;i++)
    {
      for (var j=0;j<CardTypeCX;j++)
      {
        ctx1.fillText("6", j*65+25, i*100+25); 
      }
    }
    ctx1.stroke();

    ctx2.drawImage(img1, 0, 0);        
    ctx2.font = "18px Arial";
    for (var i=0;i<CardTypeCY;i++)
    {
      for (var j=0;j<CardTypeCX;j++)
      {
        if ( (i==0) && ((j==0)||(j==3)) )
        {
          ctx2.fillStyle="#000000";
          ctx2.fillText("1", j*65+25, i*100+25); 
        }
        else
        {
          ctx2.fillStyle="#FFFFFF";
          ctx2.fillRect(j*BmpCardX,i*BmpCardY,BmpCardX,BmpCardY);
        }  
      }
    }
    ctx2.stroke();    
  
  ctx5.font = "18px Arial"; 
  ctx5.fillStyle="#FFFFFF";
  ctx5.fillRect(0,0,130,200);
  ctx5.fillStyle="#000000";
  for (var i=0;i<SCardTypeCY;i++)
    {
      for (var j=0;j<SCardTypeCX;j++)
      {
        var v = i*SCardTypeCX+j;
        ctx5.fillText(SpecialCardCost[v]+"", j*65+25, i*100+25); 
      }
    }  
  ctx5.stroke();
  }

}



function CubeThrow()
{
  var i=Math.floor(Math.random() * 6)+1; 
  var j=Math.floor(Math.random() * 6)+1; 
  if (CurrCubeCount == 1) 
  {
    CurrCubeNumber=i;
  }
  if (CurrCubeCount == 2) 
  {
    CurrCubeNumber=i+j;
  }
  if ( (i == j) && (CurrCubeCount == 2) )
  {
    IsDoubles=1;
  }
  else 
  {
    IsDoubles=0;
  }
}



function PlayerStartInit()
{
  Money = [0,0,0,0,0,0]; 
  Cards = [ [0,0,0,0,0,0,0,0,0,0,0,0,0,0], [0,0,0,0,0,0,0,0,0,0,0,0,0,0], [0,0,0,0,0,0,0,0,0,0,0,0,0,0],
    [0,0,0,0,0,0,0,0,0,0,0,0,0,0], [0,0,0,0,0,0,0,0,0,0,0,0,0,0], [0,0,0,0,0,0,0,0,0,0,0,0,0,0] ];
  SCards = [ [0,0,0,0], [0,0,0,0], [0,0,0,0], [0,0,0,0], [0,0,0,0], [0,0,0,0]];

  for (var i = 1; i<=CurrPlayerCount; i++) 
  {
    for (var j=0;j<=CardTypeC-1;j++)
    {
      Cards[i][j]=0;
    }
  } 


  for (var i = 1; i<=CurrPlayerCount; i++) 
  {
    for (var j=0;j<=CardTypeC-1;j++)
    {
      SCards[i][j]=0;
    }
  } 
        

  for (var i=1;i<=CurrPlayerCount;i++)
  {
    Cards[i][0]=1;
    Cards[i][3]=1;
    Money[i]=3;
  } 

  for (var i=0;i<=CardTypeC-1;i++)
  {
    Cards[0][i]=6;
  } 
        
  CurrPlayer=1;
  CurrCubeCount=1;  //SCards[2][0]=1;//tut
}



function neiclick(e)
{  
  var ItemClicked = {X:0, Y:0, Tag:0};
  ItemClicked.X = Math.trunc( (e.clientX-10) / 65) ;
  ItemClicked.Y = Math.trunc( (e.clientY-70) / 100);
  ItemClicked.Tag = ItemClicked.Y * CardTypeCX + ItemClicked.X;

  if (EndGame!=1)
  {
    alert('Начните новую игру');
    return;
  } 

  if (Step!=2)
  {
    alert('Покупка возможна только на этапе покупки карт');
    return;
  }

    
  var v=Cards[CurrPlayer][6]+Cards[CurrPlayer][7]; 
  if ( (v>0) && ((ItemClicked.Tag=6) || (ItemClicked.Tag=7) ))
  {
    alert('Игрок уже имеет фиолетовую карту. Покупка невозможна');
    return;
  }
    
  v = CardTypes["cost"][ItemClicked.Tag];
    
  if (Money[CurrPlayer]<v)
  {
    alert('Недостаточно золота для покупки карты');
    return;
  }

  if (Cards[0][ItemClicked.Tag]==0)
  {
    alert('Указанных зданий уже нет в наличии');
    return;
  }

  Money[CurrPlayer]=Money[CurrPlayer]-v;
  Cards[CurrPlayer][ItemClicked.Tag]=Cards[CurrPlayer][ItemClicked.Tag]+1;
  Cards[0][ItemClicked.Tag]=Cards[0][ItemClicked.Tag]-1;

  NeiCardsOut();
  IgCardsOut();
  IgSCardsOut();
  MoneyOut();
  Step=3;
  ChangeStepButton(Step);
}



function specclick(e)
{
  var ItemClicked = {X:0, Y:0, Tag:0};
  ItemClicked.X = Math.trunc( (e.clientX-480) / 65) ;
  ItemClicked.Y = Math.trunc( (e.clientY-290) / 100);
  ItemClicked.Tag = ItemClicked.Y * CardTypeCX + ItemClicked.X; 


  if (Step!=2)
  {
    alert('Покупка возможна только на этапе покупки карт');
    return;
  }

  var v=SpecialCardCost[ItemClicked.Tag];
  if (Money[CurrPlayer]<v)
  {
    alert('Недостаточно золота для покупки карты');
    return;
  }

  if (SCards[CurrPlayer][ItemClicked.Tag]==1)
  {
    alert('Карта уже куплена');
    return;  
  }


  Money[CurrPlayer]=Money[CurrPlayer]-v;
  SCards[CurrPlayer][ItemClicked.Tag]=1;

  v=0;
  for (var i=0;i<=SpecialCardC-1;i++)
  {
    v=v+SCards[CurrPlayer][i];
  }
  if (v==4)
  {
    EndGame = 0;
    alert('Игрок номер' + CurrPlayer + 'выиграл') 
  }

  NeiCardsOut();
  IgCardsOut();
  IgSCardsOut();
  MoneyOut();
  Step=3;
  ChangeStepButton(Step);   
}



function NeiCardsOut()
{
  var img1 = new Image();
  img1.src = "Cards.png";
  var ctx1 = document.getElementById("Canvas1").getContext("2d");
  img1.onload= function()
  {        
    ctx1.drawImage(img1, 0, 0);        
    ctx1.font = "18px Arial";
    for (var i=0;i<CardTypeCY;i++)
    {
      for (var j=0;j<CardTypeCX;j++)
      {
        ctx1.fillText(Cards[0][i*CardTypeCX+j], j*65+25, i*100+25); 
      }
    }
    ctx1.stroke();
  }  
}



function IgCardsOut()
{
  var img1 = new Image();
  img1.src = "Cards.png";
  var ctx2 = document.getElementById("Canvas2").getContext("2d");
  img1.onload= function()
  {        

    ctx2.drawImage(img1, 0, 0);        
    ctx2.font = "18px Arial";
    for (var i=0;i<CardTypeCY;i++)
    {
      for (var j=0;j<CardTypeCX;j++)
      {
        var Tag = i*CardTypeCX+j;
        if ( Cards[CurrPlayer][Tag]>0 )
        {
          ctx2.fillStyle="#000000";
          ctx2.fillText(Cards[CurrPlayer][Tag], j*65+25, i*100+25); 
        }
        else
        {
          ctx2.fillStyle="#FFFFFF";
          ctx2.fillRect(j*BmpCardX,i*BmpCardY,BmpCardX,BmpCardY);
        }  
      }
    }
    ctx2.stroke();
  }    
}



function IgSCardsOut()
{
  var img1 = new Image();
  img1.src = "SCards.png";
  var ctx5 = document.getElementById("Canvas5").getContext("2d");
  img1.onload = function()
  {
    ctx5.drawImage(img1, 0, 0);        
    ctx5.font = "18px Arial";    
    for (var i=0;i<SCardTypeCY;i++)
      {
        for (var j=0;j<SCardTypeCX;j++)
        {
          var Tag = i*SCardTypeCX+j;
          if (SCards[CurrPlayer][Tag]==0)
          {
            ctx5.fillStyle="#FFFFFF";
            ctx5.fillRect(65*j,100*i,65,100);
            ctx5.fillStyle="#000000";
            ctx5.fillText(SpecialCardCost[Tag]+"", j*65+25, i*100+25); 
          }
        }
      }  
    ctx5.stroke();    
  }
}



function MoneyIncrease()
{
  
  for (var i=1;i<=CurrPlayerCount;i++)
  {
    for (var j=0;j<=CardTypeC-1;j++)
    {
      if (CardTypes.eff[j]==0)
      {
        if ( (CardTypes.value[j]==CurrCubeNumber)||(CardTypes.value2[j]==CurrCubeNumber) )
        {
          Money[i]=Money[i]+Cards[i][j]*CardTypes.bonus[j];
        }
      }
    }
  }


  if ( (CurrCubeNumber == 2) || (CurrCubeNumber == 3) )
  {
    Money[CurrPlayer]=Money[CurrPlayer]+Cards[CurrPlayer][3]*(CardTypes.bonus[3]+SCards[CurrPlayer][1]);  
  }
  
  if (CurrCubeNumber == 4) 
  {
    Money[CurrPlayer]=Money[CurrPlayer]+Cards[CurrPlayer][4]*(CardTypes.bonus[4]+SCards[CurrPlayer][1]);
  }

  if (CurrCubeNumber == 7)
  {
    Money[CurrPlayer]=Money[CurrPlayer]+Cards[CurrPlayer][8]*Cards[CurrPlayer][1]*CardTypes.bonus[8];
  }

  if (CurrCubeNumber == 8)
  {
    Money[CurrPlayer]=Money[CurrPlayer]+Cards[CurrPlayer][9]*(Cards[CurrPlayer][5]+Cards[CurrPlayer][10])*CardTypes.bonus[9];
  }

  if ( (CurrCubeNumber == 11) || (CurrCubeNumber == 12) )
  {
    Money[CurrPlayer]=Money[CurrPlayer]+Cards[CurrPlayer][9]*(Cards[CurrPlayer][0]+Cards[CurrPlayer][11])*CardTypes.bonus[13];
  }
  
}



function MoneyTransfer()
{
  if (CurrCubeNumber==6)
  {
    if (Cards[CurrPlayer][6]>0)
    {
      var j=(CurrPlayer % CurrPlayerCount) + 1;
      while (j!=CurrPlayer)
      {
        if (Money[j]<2)
        {
          Money[CurrPlayer]=Money[CurrPlayer]+Money[j]; 
          Money[j]=0;
        }
        else
        {
          Money[CurrPlayer]=Money[CurrPlayer]+2; 
          Money[j]=Money[j]-2;
        }
        j=(j % CurrPlayerCount) + 1;
      }
    } 

    if (Cards[CurrPlayer][7]>0)
    {
      var v=0;
      var i=1;
      for (var j=1;j<=CurrPlayerCount;j++)
      {
        if ( (j!=CurrPlayer) && (v<Money[j]) )
        {
          v=Money[j];
          i=j;
        }
      }


      if (Money[i]<5)
      {
        Money[CurrPlayer]=Money[CurrPlayer]+Money[i]; 
        Money[i]=0;
      }
      else
      {
        Money[CurrPlayer]=Money[CurrPlayer]+5; 
        Money[i]=Money[i]-5;
      }
    }
  }



  if (CurrCubeNumber == 3)
  {
    var v=1+SCards[CurrPlayer][1];
    var j=(CurrPlayer % CurrPlayerCount) + 1;
    
    while (j!=CurrPlayer)
    {
      if (Money[CurrPlayer]<v*Cards[j][2])
      {
        Money[j]=Money[CurrPlayer]+Money[j]; 
        Money[CurrPlayer]=0;
      }
      else
      {
        Money[j]=Money[j]+v*Cards[j][2]; 
        Money[CurrPlayer]=Money[CurrPlayer]-v*Cards[j][2];
      }
      j=(j % CurrPlayerCount) + 1;    
    }
    
  }


  if ( (CurrCubeNumber == 9)||(CurrCubeNumber == 10) )
  {
    v=2+SCards[CurrPlayer][1];
    j=(CurrPlayer % CurrPlayerCount) + 1;
    while (j!=CurrPlayer)
    {
      if (Money[CurrPlayer]<v*Cards[j][12])
      {
        Money[j]=Money[CurrPlayer]+Money[j]; 
        Money[CurrPlayer]=0;
      }
      else
      {
        Money[j]=Money[j]+v*Cards[j][12]; 
        Money[CurrPlayer]=Money[CurrPlayer]-v*Cards[j][12];
      }
      j=(j % CurrPlayerCount) + 1;
    }
  }
  
}



function MoneyOut()
{
  var ctx4 = document.getElementById("Canvas4").getContext("2d");
  ctx4.fillStyle ="#8080ff";
  ctx4.fillRect(0,0,40,200);
  ctx4.fillStyle = "#000000";
  ctx4.font = "18px Arial";  
  for (var i=0;i<CurrPlayerCount;i++)
  {
    ctx4.fillText(Money[i+1]+"",20,i*40+30);
  }
  ctx4.stroke();
}



function ChangeStepButton(Step)
{
  document.getElementById("Step0").className = "btn btn-default GameBtn";
  document.getElementById("Step1").className = "btn btn-default GameBtn";
  document.getElementById("Step2").className = "btn btn-default GameBtn";
  document.getElementById("Step3").className = "btn btn-default GameBtn";

  switch (Step)
  {
    case 0: 
      document.getElementById("Step0").className = "btn btn-default GameActiveBtn";
      break;
    case 1: 
      document.getElementById("Step1").className = "btn btn-default GameActiveBtn";
      break;
    case 2: 
      document.getElementById("Step2").className = "btn btn-default GameActiveBtn";
      break;
    case 3: 
      document.getElementById("Step3").className = "btn btn-default GameActiveBtn";
      break;
    default:
      alert("Неверное значение шага");
  }
}



function CubeCountChoice()
{
  if (document.getElementById("CubeChoice1").checked)
  {
    CurrCubeCount = 1;
  }
  if (document.getElementById("CubeChoice2").checked)
  {
    CurrCubeCount = 2;
  }
}



function Step0Click()
{
  if (EndGame==0)
  {
    alert('Игра закончена, начните новую игру');
    return;
  }


  if ((Step==0)||(Step==1))
  {
    CubeThrow();
    
    if (IsDoubles==1)
      {document.getElementById("label4").innerHTML='Выпало число '+ CurrCubeNumber +' + дубли';}
    else
      {document.getElementById("label4").innerHTML='Выпало число '+ CurrCubeNumber;}
    if (Step==1)
        {Retry=0;}
    Step=1;
    ChangeStepButton(Step);    
  }
}



function Step1Click()
{
  if (EndGame==0)
  {
    alert('Игра закончена, начните новую игру');
    return;
  } 

  if (Step == 1)
  {
    MoneyTransfer(); 
    MoneyIncrease();
    MoneyOut(); 
    Step=Step+1;
    ChangeStepButton(Step);
  }
}



function Step2Click()
{
  if (Step==2)
  {
    if (!confirm("Вы хотите пропустить этап покупки карт?"))
      {return;}
    Step=Step+1;
    ChangeStepButton(Step);
  }
}



function Step3Click()
{
  if (EndGame==0)
  {
    alert('Игра закончена, начните новую игру');
    return;
  }

  if (Step==0)
  {
    alert("Бросать кубик обязательно");
    return;    
  }

  Step=0;
  ChangeStepButton(0);
  if (IsDoubles==0)
  {
    CurrPlayer=CurrPlayer+1;
  }
        
  if (CurrPlayer>CurrPlayerCount)
  {
    CurrPlayer=1;
  }

  if (SCards[CurrPlayer][3]==1)
    {Retry=1;}
  else
    {Retry=0;}

  
  if (SCards[CurrPlayer][0]==1)
  {
    document.getElementById("CubeChoice2").disabled = false;
  }
  else
  {
    document.getElementById("CubeChoice2").disabled = true;
    document.getElementById("CubeChoice1").checked = true;
    CurrCubeCount=1;
  }

  document.getElementById("label2").innerHTML='Ходит игрок номер '+ CurrPlayer;
  document.getElementById("label3").innerHTML='Количество золота = '+ Money[CurrPlayer];
  document.getElementById("label4").innerHTML='Выпало число ';
  NeiCardsOut();
  IgCardsOut();
  IgSCardsOut();
  MoneyOut();
}

