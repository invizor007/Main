unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, Buttons, StdCtrls, ExtCtrls;

const
MaxPlayerC = 5;
CardTypeC = 14;
SpecialCardC = 4;
SCardTypeCX = 2; SCardTypeCY = 2;
CardTypeCX = 7; CardTypeCY = 2;
BmpCardX = 65; BmpCardY = 100;//Для панели 455*200
SpecialCardCost :array[0..SpecialCardC-1] of integer = (4,10,16,22);

type
  TForm1 = class(TForm)
    LabeledEdit1: TLabeledEdit;
    SBGameStart: TSpeedButton;
    SBGameEnd: TSpeedButton;
    Panel1: TPanel;
    Panel2: TPanel;
    Panel3: TPanel;
    Panel4: TPanel;
    Label1: TLabel;
    Label2: TLabel;
    Label3: TLabel;
    Panel5: TPanel;
    SBStep0: TSpeedButton;
    SbOneCube: TSpeedButton;
    SbTwoCubes: TSpeedButton;
    SBStep3: TSpeedButton;
    SBStep1: TSpeedButton;
    SBStep2: TSpeedButton;
    SBTest: TSpeedButton;
    procedure SBGameStartClick(Sender: TObject);
    procedure SBGameEndClick(Sender: TObject);

    procedure BuyCardClick(Sender: TObject);
    procedure BuySCardClick(Sender: TObject);    
    procedure CardImageInit;
    procedure GameInit;
    procedure MoneyOut;
    procedure NeiCardsOut;
    procedure IgCardsOut;
    procedure IgSCardsOut;    
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
    procedure SbOneCubeClick(Sender: TObject);
    procedure SbTwoCubesClick(Sender: TObject);

    procedure SpeedButtonStep0Click(Sender: TObject);
    procedure SpeedButtonStep1Click(Sender: TObject);
    procedure SpeedButtonStep2Click(Sender: TObject);
    procedure SpeedButtonStep3Click(Sender: TObject);
    procedure ChangeStepButton(id:integer);
    procedure SBTestClick(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

TCardType = record
id, eff, tip, cost, value, value2, count, bonus:integer;
name,info:string;
end;



var
  Form1: TForm1;

Cards:array[0..MaxPlayerC,0..CardTypeC-1] of integer;//0- нейтральный герой у которого сначала находятся все здания
CardTypes:array[0..CardTypeC-1] of TCardType;
CurrCubeNumber,CurrCubeCount,CurrPlayerCount, CurrPlayer, IsDoubles:integer;
Money:array[0..MaxPlayerC] of integer;
SCards:array[1..MaxPlayerC,0..SpecialCardC-1]of integer;
NeiCardImages:array[0..CardTypeCY-1,0..CardTypeCX-1] of TImage;
IgCardImages:array[0..CardTypeCY-1,0..CardTypeCX-1] of TImage;
IgSCardImages:array [0..SCardTypeCY-1,0..SCardTypeCX-1]of TImage;
MoneyImage:array[0..MaxPlayerC-1]of TImage;
SCardInfo:array[0..SpecialCardC-1] of string;
Step, Retry, Doubles:integer;
EndGame:boolean;

procedure CardTypesInit;
procedure PlayerStartInit;
procedure MoneyTransfer;
procedure MoneyIncrease;
procedure FreeObjects;


implementation

{$R *.dfm}
//Eff - 0- для всех, 1-для своих, 2-красная карта, 3- фиолетовая карта
//tip - 0- пшеничные поля и яблоневый сад, 1- фермы, 2- кафе и ресторан, 3- магазин и пекарня, 4- лес и шахта, 5- сыроварная и мебельная фабрика 6- фруктовый сад 9 - фиолетовая карта



procedure CubeThrow;
var i,j:integer;
begin
i:=random(6)+1;j:=random(6)+1;
if CurrCubeCount = 1 then CurrCubeNumber:=i;
if CurrCubeCount = 2 then CurrCubeNumber:=i+j;
if (i = j)and(CurrCubeCount = 2) then IsDoubles:=1 else IsDoubles:=0;
end;



procedure CardTypesInit;
begin
//инициируем CardTypes всего 14 типов карт

with CardTypes[0] do begin id:=0;eff:=0;tip:=0;cost:=1;value:=1;value2:=1;count:=6;bonus:=1;name:='Пшеничное поле'; end;
with CardTypes[1] do begin id:=1;eff:=0;tip:=1;cost:=1;value:=2;value2:=2;count:=6;bonus:=1;name:='Ферма'; end;

with CardTypes[2] do begin id:=2;eff:=2;tip:=2;cost:=2;value:=3;value2:=3;count:=6;bonus:=1;name:='Кафе'; end;
with CardTypes[3] do begin id:=3;eff:=1;tip:=3;cost:=1;value:=2;value2:=3;count:=6;bonus:=1;name:='Пекарня'; end;
with CardTypes[4] do begin id:=4;eff:=1;tip:=3;cost:=2;value:=4;value2:=4;count:=6;bonus:=3;name:='Магазин'; end;
with CardTypes[5] do begin id:=5;eff:=0;tip:=4;cost:=3;value:=5;value2:=5;count:=6;bonus:=1;name:='Лес'; end;

with CardTypes[6] do begin id:=6;eff:=3;tip:=9;cost:=6;value:=6;value2:=6;count:=6;bonus:=2;name:='Стадион'; end;
with CardTypes[7] do begin id:=7;eff:=3;tip:=9;cost:=7;value:=6;value2:=6;count:=6;bonus:=5;name:='Телецентр'; end;


with CardTypes[8] do begin id:=8;eff:=1;tip:=5;cost:=5;value:=7;value2:=7;count:=6;bonus:=3;name:='Сыроварня'; end;
with CardTypes[9] do begin id:=9;eff:=1;tip:=5;cost:=3;value:=8;value2:=8;count:=6;bonus:=3;name:='Мебельная фабрика'; end;
with CardTypes[10] do begin id:=10;eff:=0;tip:=4;cost:=6;value:=9;value2:=9;count:=6;bonus:=5;name:='Шахта'; end;
with CardTypes[11] do begin id:=11;eff:=0;tip:=0;cost:=3;value:=10;value2:=10;count:=6;bonus:=3;name:='Яблоневый сад'; end;
with CardTypes[12] do begin id:=12;eff:=2;tip:=2;cost:=3;value:=9;value2:=10;count:=6;bonus:=2;name:='Ресторан'; end;
with CardTypes[13] do begin id:=13;eff:=1;tip:=6;cost:=2;value:=11;value2:=12;count:=6;bonus:=2;name:='Фруктовый рынок'; end;

CardTypes[0].info:='Возьмите одну монету из банка в ход любого игрока. Стоимость 1.';
CardTypes[1].info:='Возьмите одну монету из банка в ход любого игрока. Стоимость 1.';
CardTypes[2].info:='Возьмите одну монету у игрока, бросившего кубики. Стоимость 2.';
CardTypes[3].info:='Возьмите одну монету из банка в свой ход. Стоимость 1.';
CardTypes[4].info:='Возьмите три монеты из банка в свой ход. Стоимость 2.';
CardTypes[5].info:='Возьмите одну монету из банка в ход любого игрока. Стоимость 3.';

CardTypes[6].info:='Возьмите две монеты у каждого игрока в свой ход. Стоимость 6.';
CardTypes[7].info:='Возьмите пять монет у одного любого игрока в свой ход. Стоимость 7.';

CardTypes[8].info:='Возьмите 3 монеты из банка за каждую ферму в свой ход. Стоимость 5.';
CardTypes[9].info:='Возьмите 3 монеты из банка за каждую лес и шахту в свой ход. Стоимость 3.';
CardTypes[10].info:='Возьмите пять монет из банка в ход любого игрока. Стоимость 6.';
CardTypes[11].info:='Возьмите три монеты из банка в ход любого игрока. Стоимость 3.';
CardTypes[12].info:='Возьмите две монеты у игрока бросившего кубик. Стоимость 3.';
CardTypes[13].info:='Возьмите две монеты за каждое пшеничное поле и яблоневый сад в свой ход. Стоимость 2.';

SCardInfo[0]:='Можете бросать 2 кубика вместо 1';
SCardInfo[1]:='Каждое ваше кафе, ресторан, пекарня, магазин приносит на 1 монету больше';
SCardInfo[2]:='Если на кубиках выпал дубль сделайте еще один ход';
SCardInfo[3]:='Один раз можете перебросить кубики';
end;



procedure TForm1.CardImageInit;
var i,j:integer;
begin
for i:=0 to CardTypeCY-1 do for j:=0 to CardTypeCX-1 do
        begin
        neiCardImages[i,j]:=TImage.Create(Form1.Panel1);
        neiCardImages[i,j].Parent:=Form1.Panel1;
        neiCardImages[i,j].Width:=BmpCardX;
        neiCardImages[i,j].Height:=BmpCardY;
        neiCardImages[i,j].Left:=BmpCardX*j;
        neiCardImages[i,j].Top:=BmpCardY*i;
        neiCardImages[i,j].Picture.Bitmap.LoadFromFile('Cards/'+IntToStr((i*CardTypeCX+j) div 10)+IntToStr((i*CardTypeCX+j) mod 10)+'.bmp');
        neiCardImages[i,j].Canvas.TextOut(10,10,IntToStr(Cards[0,i*CardTypeCX+j]));
        neiCardImages[i,j].Tag:=i*CardTypeCX+j;
        neiCardImages[i,j].OnClick:=BuyCardClick;
        neiCardImages[i,j].Hint:=CardTypes[i*CardTypeCX+j].info;
        neiCardImages[i,j].ShowHint:=true;
        end;

for i:=0 to CardTypeCY-1 do for j:=0 to CardTypeCX-1 do
        begin
        igCardImages[i,j]:=TImage.Create(Form1.Panel3);
        igCardImages[i,j].Parent:=Form1.Panel3;
        igCardImages[i,j].Width:=BmpCardX;
        igCardImages[i,j].Height:=BmpCardY;
        igCardImages[i,j].Left:=BmpCardX*j;
        igCardImages[i,j].Top:=BmpCardY*i;
        if Cards[CurrPlayer,i*CardTypeCX+j]>0 then
                igCardImages[i,j].Picture.Bitmap.LoadFromFile('Cards/'+IntToStr((i*CardTypeCX+j) div 10)+IntToStr((i*CardTypeCX+j) mod 10)+'.bmp')
        else
                begin
                igCardImages[i,j].Canvas.Brush.Color:=clWhite;
                igCardImages[i,j].Canvas.FillRect(Rect(0,0,BmpCardX-1,BmpCardY-1));
                end;
        igCardImages[i,j].Canvas.TextOut(10,10,IntToStr(Cards[CurrPlayer,i*CardTypeCX+j]));
        igCardImages[i,j].Tag:=i*CardTypeCX+j;
        igCardImages[i,j].Hint:=CardTypes[i*CardTypeCX+j].info;
        igCardImages[i,j].ShowHint:=true;
        end;

for i:=0 to SCardTypeCY-1 do for j:=0 to SCardTypeCX-1 do
        begin
        igSCardImages[i,j]:=TImage.Create(Form1.Panel4);
        igSCardImages[i,j].Parent:=Form1.Panel4;
        igSCardImages[i,j].Width:=BmpCardX;
        igSCardImages[i,j].Height:=BmpCardY;
        igSCardImages[i,j].Left:=BmpCardX*j;
        igSCardImages[i,j].Top:=BmpCardY*i;
        if SCards[CurrPlayer,i*SCardTypeCX+j]>0 then
                igSCardImages[i,j].Picture.Bitmap.LoadFromFile('Cards/S0'+IntToStr(i*SCardTypeCX+j)+'.bmp')
        else
                begin
                igSCardImages[i,j].Canvas.Brush.Color:=clWhite;
                igSCardImages[i,j].Canvas.FillRect(Rect(0,0,BmpCardX-1,BmpCardY-1));
                igCardImages[i,j].Canvas.TextOut(10,10,IntToStr(SpecialCardCost[i*SCardTypeCX+j]));
                end;
        igSCardImages[i,j].OnClick:=BuySCardClick;
        igSCardImages[i,j].Hint:=SCardInfo[i*SCardTypeCX+j];
        igSCardImages[i,j].ShowHint:=true;
        igSCardImages[i,j].Tag:=i*SCardTypeCX+j;
        end;

for i:=0 to CurrPlayerCount-1 do
        begin
        MoneyImage[i]:=TImage.Create(Form1.Panel2);
        MoneyImage[i].Parent:=Form1.Panel2;
        MoneyImage[i].Width:=50;
        MoneyImage[i].Height:=50;
        MoneyImage[i].Left:=50*i;
        MoneyImage[i].Top:=0;
        MoneyImage[i].Canvas.TextOut(20,20,IntToStr(Money[i+1]))
        end;
end;



procedure PlayerStartInit;
var i,j:integer;
begin
for i:=1 to CurrPlayerCount do for j:=0 to CardTypeC-1 do
        Cards[i][j]:=0;

for i:=1 to CurrPlayerCount do for j:=0 to SpecialCardC-1 do
        SCards[i][j]:=0;

for i:=1 to CurrPlayerCount do
        begin
        Cards[i][0]:=1;
        Cards[i][3]:=1;
        Money[i]:=3;
        end;
for i:=0 to CardTypeC-1 do
        begin
        Cards[0][i]:=CardTypes[i].count;
        end;
CurrPlayer:=1;
CurrCubeCount:=1;
end;



procedure TForm1.GameInit;
begin
CardTypesInit;
PlayerStartInit;
CardImageInit;
end;



procedure TForm1.SBGameStartClick(Sender: TObject);
var c:integer;
begin
CurrPlayerCount:=0;
val(LabeledEdit1.Text,CurrPlayerCount,c);
if (CurrPlayerCount < 2) or (CurrPlayerCount>5) or (c<>0) then
        begin
        Showmessage('Введите число от 2 до 5');
        exit;
        end;

Step:=0;
ChangeStepButton(Step);
Randomize;
GameInit;
IgCardsOut;
IgSCardsOut;
LabeledEdit1.Enabled:=false;
SBGameStart.Enabled:=false;
SBGameEnd.Enabled:=true;
Label1.Visible:=true;
Label1.Caption:='Ходит игрок номер '+IntToStr(CurrPlayer);
Label2.Visible:=true;
Label2.Caption:='Количество золота = '+IntToStr(Money[CurrPlayer]);
Label3.Visible:=true;
Label3.Caption:='Выпало число ';
Panel5.Visible:=true;
EndGame:=false;
end;



procedure TForm1.SBGameEndClick(Sender: TObject);
begin
LabeledEdit1.Enabled:=true;
SBGameStart.Enabled:=true;
SBGameEnd.Enabled:=false;
Label1.Visible:=false;
Label2.Visible:=false;
Label3.Visible:=false;
Panel5.Visible:=false;
FreeObjects;
end;



procedure MoneyTransfer;
var i,j,v:integer;
begin
if CurrCubeNumber=6 then//Работают фиолетовые карты
        begin
        if Cards[CurrPlayer][6]>0 then//работает стадион то есть 2 монеты у каждого игрока в свой ход
                begin
                j:=(CurrPlayer mod CurrPlayerCount) + 1;
                while (j<>CurrPlayer) do
                        begin
                        if Money[j]<2 then
                                begin Money[CurrPlayer]:=Money[CurrPlayer]+Money[j]; Money[j]:=0; end
                        else
                                begin Money[CurrPlayer]:=Money[CurrPlayer]+2; Money[j]:=Money[j]-2; end;
                        j:=(j mod CurrPlayerCount) + 1;
                        end;
                end;
        if Cards[CurrPlayer][7]>0 then//работает телецентр то есть 5 монет у игрока с максимальным количеством золота в свой ход
                begin
                v:=0;i:=1;
                for j:=1 to CurrPlayerCount do
                        if (j<>CurrPlayer) and (v<Money[j]) then
                                begin
                                v:=Money[j];
                                i:=j;
                                end;

                if Money[i]<5 then
                        begin Money[CurrPlayer]:=Money[CurrPlayer]+Money[i]; Money[i]:=0; end
                else
                        begin Money[CurrPlayer]:=Money[CurrPlayer]+5; Money[i]:=Money[i]-5; end;
                end;
        end;

if (CurrCubeNumber in [3]) then// Работают кафе - передача одного золота за кафе другому игроку по очереди
        begin
        v:=1+SCards[CurrPlayer][1];//1+бонус за кафе
        j:=(CurrPlayer mod CurrPlayerCount) + 1;
        while (j<>CurrPlayer) do
                begin
                if Money[CurrPlayer]<v*Cards[j][2] then
                        begin Money[j]:=Money[CurrPlayer]+Money[j]; Money[CurrPlayer]:=0; end
                else
                        begin Money[j]:=Money[j]+v*Cards[j][2]; Money[CurrPlayer]:=Money[CurrPlayer]-v*Cards[j][2]; end;
                j:=(j mod CurrPlayerCount) + 1;
                end;
        end;

if (CurrCubeNumber in [9,10]) then// Работает ресторан - передача одного золота за кафе другому игроку по очереди
        begin
        v:=2+SCards[CurrPlayer][1];//2+бонус за кафе
        j:=(CurrPlayer mod CurrPlayerCount) + 1;
        while (j<>CurrPlayer) do
                begin
                if Money[CurrPlayer]<v*Cards[j][12] then
                        begin Money[j]:=Money[CurrPlayer]+Money[j]; Money[CurrPlayer]:=0; end
                else
                        begin Money[j]:=Money[j]+v*Cards[j][12]; Money[CurrPlayer]:=Money[CurrPlayer]-v*Cards[j][12]; end;
                j:=(j mod CurrPlayerCount) + 1;
                end;
        end;
end;



procedure MoneyIncrease;
var i,j:integer;
begin
//Золото для всех за синие карты
for i:=1 to CurrPlayerCount do
        begin
        for j:=0 to CardTypeC - 1 do
                if CardTypes[j].eff=0 then
                        if (CardTypes[j].value=CurrCubeNumber)or(CardTypes[j].value2=CurrCubeNumber) then
                                Money[i]:=Money[i]+Cards[i][j]*CardTypes[j].bonus;
        end;
//Золото для всех за синие карты
if (CurrCubeNumber in [2,3]) then//Работает пекарня
        Money[CurrPlayer]:=Money[CurrPlayer]+Cards[CurrPlayer][3]*(CardTypes[3].bonus+SCards[CurrPlayer][1]);
if (CurrCubeNumber = 4) then//Работает магазин
        Money[CurrPlayer]:=Money[CurrPlayer]+Cards[CurrPlayer][4]*(CardTypes[4].bonus+SCards[CurrPlayer][1]);
if (CurrCubeNumber = 7) then//Работает сыроварня
        Money[CurrPlayer]:=Money[CurrPlayer]+Cards[CurrPlayer][8]*Cards[CurrPlayer][1]*CardTypes[8].bonus;
if (CurrCubeNumber = 8) then//Работает мебельная фабрика
        Money[CurrPlayer]:=Money[CurrPlayer]+Cards[CurrPlayer][9]*(Cards[CurrPlayer][5]+Cards[CurrPlayer][10])*CardTypes[9].bonus;
if (CurrCubeNumber in [11,12]) then//Работает фруктовый рынок
        Money[CurrPlayer]:=Money[CurrPlayer]+Cards[CurrPlayer][9]*(Cards[CurrPlayer][0]+Cards[CurrPlayer][11])*CardTypes[13].bonus;
end;



procedure TForm1.MoneyOut;
var i:integer;
begin
for i:=1 to CurrPlayerCount do
        begin
        MoneyImage[i-1].Canvas.Brush.Color:=clWhite;
        MoneyImage[i-1].Canvas.FillRect(Rect(0,0,49,49));
        MoneyImage[i-1].Canvas.TextOut(20,20,IntToStr(Money[i]));
        end;
Label2.Caption:='Количество золота = '+IntToStr(Money[CurrPlayer]);
end;



procedure TForm1.NeiCardsOut;
var i,j:integer;
begin
for i:=0 to CardTypeCY-1 do for j:=0 to CardTypeCX-1 do
        begin
        neiCardImages[i,j].Picture.Bitmap.LoadFromFile('Cards/'+IntToStr((i*CardTypeCX+j) div 10)+IntToStr((i*CardTypeCX+j) mod 10)+'.bmp');
        neiCardImages[i,j].Canvas.TextOut(10,10,IntToStr(Cards[0,i*CardTypeCX+j]));
        end;
end;



procedure TForm1.IgCardsOut;
var i,j:integer;
begin
for i:=0 to CardTypeCY-1 do for j:=0 to CardTypeCX-1 do
        begin
        if Cards[CurrPlayer,i*CardTypeCX+j]>0 then
                igCardImages[i,j].Picture.Bitmap.LoadFromFile('Cards/'+IntToStr((i*CardTypeCX+j) div 10)+IntToStr((i*CardTypeCX+j) mod 10)+'.bmp')
        else
                begin
                igCardImages[i,j].Canvas.Brush.Color:=clWhite;
                igCardImages[i,j].Canvas.FillRect(Rect(0,0,BmpCardX-1,BmpCardY-1));
                end;
        igCardImages[i,j].Canvas.TextOut(10,10,IntToStr(Cards[CurrPlayer,i*CardTypeCX+j]));
        end;
end;



procedure TForm1.IgSCardsOut;
var i,j:integer;
begin
for i:=0 to SCardTypeCY-1 do for j:=0 to SCardTypeCX-1 do
        begin
        if SCards[CurrPlayer,i*SCardTypeCX+j]>0 then
                igSCardImages[i,j].Picture.Bitmap.LoadFromFile('Cards/S0'+IntToStr(i*SCardTypeCX+j)+'.bmp')
        else
                begin
                igSCardImages[i,j].Canvas.Brush.Color:=clWhite;
                igSCardImages[i,j].Canvas.FillRect(Rect(0,0,BmpCardX-1,BmpCardY-1));
                igSCardImages[i,j].Canvas.TextOut(10,10,IntToStr(SpecialCardCost[i*SCardTypeCX+j]));
                end;
        end;
end;



procedure TForm1.SpeedButtonStep0Click(Sender: TObject);
begin
if EndGame then
        begin
        Showmessage('Игра закончена, начните новую игру');
        exit;
        end;

if Step in [0,1] then
        begin
        CubeThrow;
        if IsDoubles=1 then
                Label3.Caption:='Выпало число '+IntToStr(CurrCubeNumber)+' + дубли на кубиках'
        else
                Label3.Caption:='Выпало число '+IntToStr(CurrCubeNumber);
        if Step=1 then
                Retry:=0;
        Step:=1;
        ChangeStepButton(Step);
        end;

end;



procedure TForm1.SpeedButtonStep1Click(Sender: TObject);
begin
if EndGame then
        begin
        Showmessage('Игра закончена, начните новую игру');
        exit;
        end;

if Step = 1 then
        begin
        MoneyTransfer;
        MoneyIncrease;
        MoneyOut;
        Step:=Step+1;
        ChangeStepButton(Step);
        end;
end;



procedure TForm1.SpeedButtonStep2Click(Sender: TObject);
begin
if Step=2 then
        begin
        if Application.MessageBox('Вы хотите пропустить этап покупка карты?','Мачи-коро',1)=2 then exit;
        Step:=Step+1;
        ChangeStepButton(Step);
        end;
end;



procedure TForm1.SpeedButtonStep3Click(Sender: TObject);
begin
if EndGame then
        begin
        Showmessage('Игра закончена, начните новую игру');
        exit;
        end;

if Step=0 then
        begin
        ShowMessage('Бросать кубик обязательно');
        exit;
        end;

Step:=0;
ChangeStepButton(0);
if IsDoubles=0 then
        CurrPlayer:=CurrPlayer+1;
if CurrPlayer>CurrPlayerCount then CurrPlayer:=1;

if SCards[CurrPlayer][3]=1 then
        Retry:=1
else
        Retry:=0;

if SCards[CurrPlayer][0]=1 then
        SbTwoCubes.Enabled:=true
else
        SbTwoCubes.Enabled:=false;

if SCards[CurrPlayer][0]=0 then
        begin
        CurrCubeCount:=1;
        SBOneCube.Down:=true;
        end;

Label1.Caption:='Ходит игрок номер '+IntToStr(CurrPlayer);
Label2.Caption:='Количество золота = '+IntToStr(Money[CurrPlayer]);
Label3.Caption:='Выпало число ';
NeiCardsOut;
IgCardsOut;
IgSCardsOut;
MoneyOut;
end;



procedure TForm1.ChangeStepButton(id:integer);
begin
SBStep0.Enabled:=id=0;
SBStep1.Enabled:=id=1;
SBStep2.Enabled:=id=2;
SBStep3.Enabled:=id=3;

if (Retry=1) and (id=1) then
        SBStep0.Enabled:=true;
end;



procedure TForm1.BuyCardClick(Sender: TObject);
var v:integer;
begin
if Step<>2 then
        begin
        Showmessage('Покупка возможна только на этапе покупки карт');
        exit;
        end;

v:=Cards[CurrPlayer][6]+Cards[CurrPlayer][7];
if (v>=1) and (TImage(Sender).Tag in [6,7]) then
        begin
        Showmessage('Игрок уже имеет фиолетовую карту. Покупка невозможна');
        exit;
        end;

v:=CardTypes[TImage(Sender).Tag].cost;//количество золота за карту
if Money[CurrPlayer]<v then
        begin
        Showmessage('Недостаточно золота для покупки карты');
        exit;
        end;

if Cards[0][TImage(Sender).Tag]=0 then
        begin
        Showmessage('Указанных зданий уже нет в наличии');
        exit;
        end;

Money[CurrPlayer]:=Money[CurrPlayer]-v;
Cards[CurrPlayer][TImage(Sender).Tag]:=Cards[CurrPlayer][TImage(Sender).Tag]+1;
Cards[0][TImage(Sender).Tag]:=Cards[0][TImage(Sender).Tag]-1;
NeiCardsOut;
IgCardsOut;
IgSCardsOut;
MoneyOut;
Step:=3;
ChangeStepButton(Step);
end;



procedure TForm1.BuySCardClick(Sender: TObject);
var v,i:integer;
begin
if Step<>2 then
        begin
        Showmessage('Покупка возможна только на этапе покупки карт');
        exit;
        end;

v:=SpecialCardCost[TImage(Sender).Tag];//количество золота за карту
if Money[CurrPlayer]<v then
        begin
        Showmessage('Недостаточно золота для покупки карты');
        exit;
        end;

if SCards[CurrPlayer][TImage(Sender).Tag]=1 then
        begin
        Showmessage('Карта уже куплена');
        exit;
        end;

Money[CurrPlayer]:=Money[CurrPlayer]-v;
SCards[CurrPlayer][TImage(Sender).Tag]:=1;

v:=0;
for i:=0 to SpecialCardC-1 do
        v:=v+SCards[CurrPlayer][i];
if v=4 then
        begin
        EndGame:=true;
        Showmessage('Игрок номер '+ IntToStr(CurrPlayer) +' победил');
        end;

NeiCardsOut;
IgCardsOut;
IgSCardsOut;
MoneyOut;
Step:=3;
ChangeStepButton(Step);
end;



procedure FreeObjects;
var i,j:integer;
begin
for i:=0 to CardTypeCY-1 do for j:=0 to CardTypeCX-1 do
        begin
        NeiCardImages[i,j].Free;
        IgCardImages[i,j].Free;
        end;
for i:=0 to SCardTypeCY-1 do for j:=0 to SCardTypeCX-1 do
        IgSCardImages[i,j].Free;
for i:=0 to CurrPlayerCount-1 do
        MoneyImage[i].Free;        
end;



procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
begin
FreeObjects;
end;



procedure TForm1.SbOneCubeClick(Sender: TObject);
begin
CurrCubeCount:=1;
end;



procedure TForm1.SbTwoCubesClick(Sender: TObject);
begin
CurrCubeCount:=2;
end;



procedure TForm1.SBTestClick(Sender: TObject);
var i:integer;
begin
for i:=1 to CurrPlayerCount do
        begin
        SCards[i][0]:=1;
        SCards[i][2]:=1;
        SCards[i][3]:=1;
        SCards[i][1]:=1;
        end;
IgSCardsOut;
end;

end.
