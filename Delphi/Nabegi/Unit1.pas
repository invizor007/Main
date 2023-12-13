unit Unit1;

interface
//Дизайн и программирование карточной игры Набеги
//Вариант сделать сетевую версию
//MSG1- Вы не можете отбиться этой картой
uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, ExtCtrls, StdCtrls, Buttons, Math;

type
  TForm1 = class(TForm)
    SpeedButton1: TSpeedButton;
    Label1: TLabel;
    SpeedButton2: TSpeedButton;
    Label2: TLabel;
    Label3: TLabel;
    Image1: TImage;
    Label4: TLabel;
    SpeedButton3: TSpeedButton;
    Panel1: TPanel;
    Panel2: TPanel;
    Label5: TLabel;
    SpeedButton4: TSpeedButton;
    SpeedButton5: TSpeedButton;
    procedure FormCreate(Sender: TObject);
    procedure Image2Click(Sender: TObject);
    procedure SpeedButton1Click(Sender: TObject);
    procedure SpeedButton2Click(Sender: TObject);
    procedure SpeedButton3Click(Sender: TObject);
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
    procedure PrepHod;
    procedure NextKon;
    procedure AddTown;
    procedure DelTown;
    procedure GenGameResult;
    procedure OutInfo;
    procedure MakeBtl;
    procedure SpeedButton4Click(Sender: TObject);
    procedure SpeedButton5Click(Sender: TObject);
    procedure FormKeyPress(Sender: TObject; var Key: Char);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  Form1: TForm1;

tmpcardnum,cubenum,tmppl,konnum,konnummax:integer;
cards:array[0..35] of TPoint;
plcards:array[0..1,0..2] of TPoint;
tncards:array[0..1,0..4]of TPoint;
tncardco,tncardlim,plhp,plskip:array[0..1]of integer;
plcardnum,plnum,plwin:integer;
btl:array[0..3]of integer;
imgapl:array[0..2]of TImage;
imgatn:array[0..4]of TImage;



implementation

{$R *.dfm}

function istown(p:TPoint):boolean;
begin
if p.X<=10 then result:=true else result:=false;
end;

procedure MakePlnum;
begin
if istown(cards[tmpcardnum]) then
        begin
        if cards[tmpcardnum].Y>=2 then plnum:=1
        else plnum:=0;
        end else
        begin
        if cards[tmpcardnum].Y>=2 then plnum:=0
        else plnum:=1;        
        end;
end;

procedure GenCardPlace;
var i,r:integer;
tmpa:array[0..35]of integer;
begin
for i:=0 to 35 do
        tmpa[i]:=0;
for i:=0 to 35 do
        begin
        repeat
        r:=random(36);
        until tmpa[r]=0;
        tmpa[r]:=1;

        cards[i].X:=(r div 4)+6;
        cards[i].Y:=r mod 4;
        end;
end;

procedure GenPlCards;
var i,j:integer;
begin
for i:=1 to 35 do
        begin
        if (cards[i].X=10)and(cards[i].Y=0) then
                begin
                cards[i]:=cards[0];
                cards[i].X:=10;
                cards[i].Y:=0;
                end;
        end;

for i:=2 to 35 do
        begin
        if (cards[i].X=10)and(cards[i].Y=2) then
                begin
                cards[i]:=cards[1];
                cards[i].X:=10;
                cards[i].Y:=2;
                end;
        end;

for i:=0 to 1 do for j:=0 to 2 do
        plcards[i][j]:=cards[i*3+j];
tncards[0][0].X:=10;tncards[0][0].Y:=0;
tncards[1][0].X:=10;tncards[1][0].Y:=2;
tncardco[0]:=1;tncardco[1]:=1;
tncardlim[0]:=min(5,konnum);tncardlim[1]:=min(5,konnum);
plhp[0]:=1;plhp[1]:=1;
plskip[0]:=1;plskip[1]:=1;
//del 2 card from cards
tmpcardnum:=8;

end;

function cardfilename(x,y:integer):string;
begin
result:='Cards/'+IntToStr(x)+'_'+IntToStr(y)+'.bmp';
end;

procedure TForm1.FormCreate(Sender: TObject);
var i:integer;
begin
randomize;
GenCardPlace;
GenPlCards;
for i:=0 to 4 do
        begin
        imgatn[i]:=TImage.Create(Panel2);
        imgatn[i].Parent:=Panel2;
        imgatn[i].Left:=i*125;
        imgatn[i].Top:=0;
        imgatn[i].Width:=125;
        imgatn[i].Height:=188;
        imgatn[i].Tag:=i;
        end;

for i:=0 to 2 do
        begin
        imgapl[i]:=TImage.Create(Panel1);
        imgapl[i].Parent:=Panel1;
        imgapl[i].Left:=i*125;
        imgapl[i].Top:=0;
        imgapl[i].Width:=125;
        imgapl[i].Height:=188;
        imgapl[i].OnClick:=Image2Click;
        imgapl[i].Tag:=i;
        end;

//переменные на старт игры
plcardnum:=-1;
cubenum:=random(6)+1;
MakePlnum;
konnum:=1;
konnummax:=9;
if not istown(cards[tmpcardnum]) then cubenum:=max(0,cubenum-2);

//стартовая инициализация btl
if istown(cards[tmpcardnum]) then
        begin
        btl[0]:=cards[tmpcardnum].X;
        btl[1]:=cubenum;
        btl[2]:=0;
        btl[3]:=0;
        end else
        begin
        btl[0]:=cards[tmpcardnum].X-10;
        btl[1]:=cubenum;
        btl[2]:=0;
        if btl[0]>btl[1] then btl[3]:=btl[0]-btl[1] else btl[3]:=0;
        end;

OutInfo;
end;

procedure TForm1.Image2Click(Sender: TObject);
begin
if plcardnum<>-1 then
        imgapl[plcardnum].Picture.LoadFromFile(cardfilename(plcards[plnum][plcardnum].x,plcards[plnum][plcardnum].y));


plcardnum:=TImage(Sender).Tag;

TImage(Sender).Canvas.Brush.Color:=clRed;
TImage(Sender).Canvas.FillRect(Rect(0,0,124,5));
TImage(Sender).Canvas.FillRect(Rect(0,182,124,187));
TImage(Sender).Canvas.FillRect(Rect(0,0,5,187));
TImage(Sender).Canvas.FillRect(Rect(120,0,124,187));
end;

procedure TForm1.SpeedButton1Click(Sender: TObject);
begin
if (btl[3]=0) then
        begin//skip hod
        tmpcardnum:=tmpcardnum+1;
        //Image1.Picture.LoadFromFile(cardfilename(cards[tmpcardnum].X,cards[tmpcardnum].Y));
        PrepHod;
        exit;
        end;

if plcardnum=-1 then
        begin
        showmessage('Выберите карту которой будете отбиваться');
        exit;
        end;        

if istown(cards[tmpcardnum]) then//Город
        begin
        btl[2]:=max(0,plcards[plnum,plcardnum].X-10);
        if btl[0]>btl[1]+btl[2] then
                begin
                showmessage('Вы не можете захватить город с помощью этой карты. Выберите другую.');
                exit;
                end;
        AddTown;
        plcards[plnum,plcardnum]:=cards[tmpcardnum+1];
        tmpcardnum:=tmpcardnum+2;
        end else//Существо
        begin
        btl[2]:=max(0,plcards[plnum,plcardnum].X-10);
        if btl[0]>btl[1]+btl[2] then
                begin
                showmessage('Вы не можете отбиться этой картой. Выберите другую.');
                exit;
                end;
        plcards[plnum,plcardnum]:=cards[tmpcardnum+1];
        tmpcardnum:=tmpcardnum+2;
        end;
PrepHod;
end;

procedure TForm1.AddTown;
begin
tncardco[plnum]:=tncardco[plnum]+1;
tncards[plnum][tncardco[plnum]-1].X:=cards[tmpcardnum].X;
tncards[plnum][tncardco[plnum]-1].Y:=cards[tmpcardnum].Y;
end;

procedure TForm1.DelTown;
var i:integer;
begin
for i:=0 to tncardco[plnum]-2 do
        tncards[plnum][i]:=tncards[plnum][i+1];
tncardco[plnum]:=tncardco[plnum]-1;
end;

procedure TForm1.SpeedButton2Click(Sender: TObject);
var i:integer;
begin
if istown(cards[tmpcardnum]) then
        begin
        tmpcardnum:=tmpcardnum+1;
        PrepHod;
        exit;
        end;

if plhp[plnum]=1 then
        begin
        plhp[plnum]:=0;
        end else
        begin
        DelTown;
        plhp[plnum]:=1;
        end;

for i:=0 to 2 do
        begin
        tmpcardnum:=tmpcardnum+1;
        plcards[plnum][i]:=cards[tmpcardnum];
        end;        
PrepHod;
end;

procedure TForm1.SpeedButton3Click(Sender: TObject);
var i:integer;
begin
if plskip[plnum]=0 then
        if Application.MessageBox('Заменив карты вы получите единицу урона','Замена карт производится раз за кон',1)=2 then
                exit;

for i:=0 to 2 do
        begin
        tmpcardnum:=tmpcardnum+1;
        plcards[plnum][i]:=cards[tmpcardnum];
        end;

if plskip[plnum]=1 then
        begin
        plskip[plnum]:=0;
        end else
        begin
        if plhp[plnum]=1 then
                plhp[plnum]:=0
        else
                DelTown;
        end;
PrepHod;
end;

procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
var i:integer;
begin
for i:=0 to 2 do
        imgapl[i].Free;
for i:=0 to 4 do
        imgatn[i].Free;
end;

procedure TForm1.PrepHod;
begin
cubenum:=random(6)+1;
if not istown(cards[tmpcardnum]) then cubenum:=max(0,cubenum-2);
plcardnum:=-1;
MakePlnum;
MakeBtl;

if tmpcardnum>=35 then NextKon;
OutInfo;
end;

procedure TForm1.NextKon;
var i:integer;
begin
if konnum=konnummax then
        begin
        GenGameResult;
        exit;
        end;
konnum:=konnum+1;

for i:=0 to 1 do
        begin
        tncardlim[i]:=min(5,konnum);
        plhp[i]:=1;
        plskip[i]:=1;
        end;

plcardnum:=-1;
cubenum:=random(6)+1;
if cards[tmpcardnum].Y>=2 then plnum:=1
else plnum:=0;
GenCardPlace;
GenPlCards;
end;

procedure TForm1.GenGameResult;
var i,sum0,sum1:integer;
begin
SpeedButton1.Enabled:=false;
SpeedButton2.Enabled:=false;
SpeedButton3.Enabled:=false;
plwin:=-1;
if tncardco[0]>tncardco[1]+1 then plwin:=0;
if tncardco[1]>tncardco[0]+1 then plwin:=1;

if plwin=-1 then
        begin
        sum0:=0;
        sum1:=0;
        for i:=0 to tncardco[0]-1 do
                sum0:=sum0+tncards[0,i].X;
        for i:=0 to tncardco[1]-1 do
                sum1:=sum1+tncards[1,i].X;

        if sum0>sum1 then plwin:=0;
        if sum1>sum0 then plwin:=1;        
        end;

if plwin=-1 then
        showmessage('Ничья')
else
        showmessage('Выиграл игрок номер '+IntToStr(plwin+1));
end;

procedure TForm1.OutInfo;
var i:integer;
begin
//Caption:='Набеги: кон '+IntToStr(konnum);
Caption:=IntToStr(btl[0])+' '+IntToStr(btl[1])+' '+IntToStr(btl[2])+' '+IntToStr(btl[3]);
Label1.Caption:='В колоде осталось '+IntToStr(35-tmpcardnum)+' карт';
Label2.Caption:='На кубике выпало число '+IntToStr(cubenum);
if btl[3]>0 then
        begin
        Label3.Caption:='Требуется сила >='+IntToStr(btl[3]);
        SpeedButton1.Caption:='Сражаться';
        SpeedButton2.Caption:='Пасовать';
        SpeedButton2.Enabled:=true;
        end
else
        begin
        SpeedButton1.Caption:='Следующий ход';
        SpeedButton2.Caption:='';
        SpeedButton2.Enabled:=false;
        Label3.Caption:='Сражаться не требуется';
        end;
Label4.Caption:='Ходит игрок номер '+IntToStr(plnum+1);
Label5.Caption:='Кон номер '+IntToStr(konnum);

Image1.Picture.LoadFromFile(cardfilename(cards[tmpcardnum].x,cards[tmpcardnum].y));
for i:=0 to tncardco[plnum]-1 do
        imgatn[i].Picture.LoadFromFile(cardfilename(tncards[plnum][i].x,tncards[plnum][i].y));
for i:=tncardco[plnum] to 4 do
        imgatn[i].Canvas.FillRect(Rect(0,0,125,188));
for i:=0 to 2 do
        imgapl[i].Picture.LoadFromFile(cardfilename(plcards[plnum][i].x,plcards[plnum][i].y));

if plhp[plnum]=0 then
        begin
        imgatn[0].Canvas.Brush.Color:=clRed;
        imgatn[0].Canvas.FillRect(Rect(90,10,110,30));
        end;
end;

procedure TForm1.SpeedButton4Click(Sender: TObject);
begin
Panel1.Visible:=true;
end;

procedure TForm1.SpeedButton5Click(Sender: TObject);
begin
Panel1.Visible:=false;
end;

procedure TForm1.MakeBtl;
begin           //временно tncardlim[0]:=10;tncardlim[1]:=10;
//btl[0] - сила карта нейтралов,    btl[1] - значение сила на кубике,
//btl[2] - выбранная игроком карта, btl[3] - сколько силы нужно добрать
if istown(cards[tmpcardnum]) then
        begin
        btl[0]:=cards[tmpcardnum].X;
        btl[1]:=cubenum;
        if plcardnum<>-1 then
                btl[2]:=max(0,plcards[plnum,plcardnum].X-10)
        else
                btl[2]:=max(max(plcards[plnum,0].X-10,plcards[plnum,1].X-10),max(plcards[plnum,2].X-10,0));
        btl[3]:=0;
        if (tncardco[plnum]<tncardlim[plnum]) then
                btl[3]:=max(0,btl[1]+btl[2]-btl[0]);
        end else
        begin
        btl[0]:=cards[tmpcardnum].X-10;
        btl[1]:=cubenum;
        if plcardnum<>-1 then
                btl[2]:=max(0,plcards[plnum,plcardnum].X-10)
        else
                btl[2]:=0;
        btl[3]:=0;
        if (btl[0]>btl[1]) then
                btl[3]:=btl[0]-btl[1];
        end;
end;                               

procedure TForm1.FormKeyPress(Sender: TObject; var Key: Char);
begin
if key='1' then
        begin
        plnum:=0;
        DelTown;
        OutInfo;
        end;

if key='2' then
        begin
        plnum:=0;
        AddTown;
        OutInfo;
        end;

if key='3' then
        begin
        NextKon;
        OutInfo;
        end;

if key='4' then
        begin
        GenGameResult;
        OutInfo;
        end;

if key='5' then
        begin
        MakeBtl;
        OutInfo;
        end;
end;

end.
