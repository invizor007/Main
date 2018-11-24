unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, Buttons, Unit2, ExtCtrls, Grids, StdCtrls;

const MPC=4;CBC=10;CBCA=CBC+6;CBW = CBCA div 2; SkipCardFinish=3;
AttackInfoStr :array[1..6]of string = ('������','���','�����','���������','��������','��� ������');

//��������� -
//01 - 1��, 02- 3 ��, 03 - 6 ��, 04 - ����� ��
//11 - ����, 12 - �������, 13 - ������
//21 - 30 - ����� ���� ��� ����, ����������� ���������� ������ ��� ����
//71 - ����������, 72 - �������, 73- ������, 74 - �������
//75- ������� ��� 76- ��� 77- ����� 78 - ������� 79 ����
//81 - �������������, 82 - ���������, 83- ������, 84- ���������
//85 - �����, 86 - ����������, 87 - �����������, 88 - ���������
//91 - ���, 92- ��� ������ 93- �������, 94- �������
//95 - �������, 96 - ��������, 97 - �������� �����������, 98 - ���

type
  TForm1 = class(TForm)
    SBGameStart: TSpeedButton;
    SBEditSet: TSpeedButton;
    Panel1: TPanel;
    DrawGrid1: TDrawGrid;
    Panel2: TPanel;
    Label1: TLabel;
    Label2: TLabel;
    Label3: TLabel;
    Panel3: TPanel;
    SBAction1: TSpeedButton;
    SBAction3: TSpeedButton;
    SBAction2: TSpeedButton;
    SBGameEnd: TSpeedButton;
    Panel4: TPanel;
    Label5: TLabel;
    Label4: TLabel;
    Label6: TLabel;
    Label7: TLabel;
    procedure ShopClick(Sender:TObject);
    procedure OutLaInfo;

    procedure SBEditSetClick(Sender: TObject);
    procedure FormCreate(Sender: TObject);
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
    procedure SBGameStartClick(Sender: TObject);
    procedure SBAction1Click(Sender: TObject);
    procedure DrawGrid1DrawCell(Sender: TObject; ACol, ARow: Integer;
      Rect: TRect; State: TGridDrawState);
    procedure DrawGrid1MouseDown(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    procedure SBAction2Click(Sender: TObject);
    procedure SBAction3Click(Sender: TObject);
    procedure SBGameEndClick(Sender: TObject);
    procedure ReloadImBuy(i,j:integer);
    procedure FormClick(Sender: TObject);
    procedure Label5Click(Sender: TObject);
    procedure WinPointInfoOut;
  private
    { Private declarations }
  public
    { Public declarations }
  end;

  TCardInfo = record
    id,cost,active,paction,pmoney,pcards,pbuy,pwin,attack,spec{���� �� ����������� ��������}:integer;
    name,info:string;
  end;

  TPlayer = class
    Cards, Sbros:TList;
    attack:array[1..6]of integer;
    {1 - ������ 2- ��� 3 - ����� 4- ��������� 5- �������� 6-�����  - �� ���� ������}
    procedure init;
    procedure StartOptions;
    procedure GetCard;
    function CardCount:integer;
    function WinPoints:integer;
  end;

  TGame = class
    pl:array[0..MPC-1] of TPlayer;
    Svalka,Opened:TList;
    CurrPlayer,CurrAction,CurrGold,CurrBuy,Step,PlayerCount, CurseCount, BGold, BBuy:integer;
    Mod71,Mod75,Mod81,Mod81C,Mod82,Mod83,Mod86,Mod91,Mod91C,Mod93,Mod93C,Mod95,Mod95C:integer;
    Attack2, Attack4:integer;
    GameEnd:boolean;
    procedure init;
    procedure MoneyRecalc;
    procedure BuyRecalc;
    function OpenedExist(num:integer):boolean;
    function isEndGame:boolean;
    function isMod:boolean;
  end;

  TUsed = class
  c:integer;
  a:array [0..99] of integer;
  procedure clear;
  procedure add(n:integer);
  function exists(n:integer):boolean;
  procedure recalc(delcol:integer);
  procedure showused;
  end;

var
  Form1: TForm1;

  Game:TGame;
  ImBuy:array[0..1,0..CBW -1] of TImage;
  bmp:TBitMap;
  CardNum:array[0..1,0..CBW-1]of integer;
  CardNCount:array[0..1,0..CBW-1]of integer;
  CI:array[0..31] of TCardInfo;
  Used:TUsed;

procedure CardNumInit;
procedure CardNCountInit;
procedure CIInit;
function FindIdCI(id:integer):integer;

implementation

procedure qq(i:integer);
begin
showmessage(inttostr(i));
end;

procedure TUsed.clear;
begin
c:=0;
end;

procedure TUsed.add(n:integer);
begin
a[c]:=n;
c:=c+1;
end;

function TUsed.exists(n:integer):boolean;
var i:integer;
begin
result:=false;
for i:=0 to c-1 do
        if a[i]=n then result:=true;
end;

procedure TUsed.recalc(delcol:integer);
var i:integer;
begin
for i:=0 to c-1 do
        begin
        if a[i]>delcol then
                a[i]:=a[i]-1;
        //if a[i]=delcol then
        //        showmessage('!');
        end;
end;

procedure TUsed.showused;
var i:integer;
s:string;
begin
s:=IntToStr(c)+': ';
for i:=0 to c-1 do
        s:=s+IntToStr(a[i])+' ';
showmessage(s);
end;



procedure TPlayer.init;
var i:integer;
begin
for i:=0 to Cards.Count-1 do
        dispose(Cards.Items[i]);
for i:=0 to Sbros.Count-1 do
        dispose(Sbros.Items[i]);
Cards.Clear;
Sbros.Clear;
end;

procedure TPlayer.StartOptions;
var i:integer;
p:pinteger;
begin
for i:=0 to 6 do
        begin
        new(p);
        p^:=11;
        Cards.Add(p);
        end;

for i:=0 to 2 do
        begin
        new(p);
        p^:=1;
        Cards.Add(p);
        end;

//test
//        new(p);
//        p^:=75;
//        Cards.Add(p);

//        new(p);
//        p^:=82;
//        Cards.Add(p);
//CardNCount[0,0]:=1;
end;

procedure TPlayer.GetCard;
var r,i:integer;
begin
if Cards.Count=0 then
        begin
        showmessage('������ ������');
        exit;
        end;
r:=random(Cards.Count);
Game.Opened.Add(Cards.Items[r]);
Cards.Delete(r);

if Cards.Count=0 then
        begin
        for i:=0 to Sbros.Count-1 do
                Cards.Add(Sbros.Items[i]);
        Sbros.Clear;
        end;
end;

function TPlayer.CardCount:integer;
begin
result:=Cards.Count+Sbros.Count;
end;

function TPlayer.WinPoints:integer;
var i,v1,v2:integer;
p:pinteger;
begin
v1:=0;v2:=0;
for i:=0 to Cards.Count-1 do
        begin
        p:=Cards.Items[i];
        v1:=v1+CI[FindIdCI(p^)].pwin;
        if p^=79 then v2:=v2+1;
        end;
for i:=0 to Sbros.Count-1 do
        begin
        p:=Sbros.Items[i];
        v1:=v1+CI[FindIdCI(p^)].pwin;
        if p^=79 then v2:=v2+1;
        end;

result:=(CardCount div 10)*v2+v1;
end;



procedure TGame.init;
var i:integer;
begin
for i:=0 to Svalka.Count-1 do
        dispose(Svalka.Items[i]);
for i:=0 to Opened.Count-1 do
        dispose(Opened.Items[i]);
Svalka.Clear;
Opened.Clear;
for i:=0 to MPC-1 do
        begin
        Game.pl[i].init;
        Game.pl[i].StartOptions;
        end;

if PlayerCount<=2 then CurseCount:=10
else if PlayerCount=3 then CurseCount:=20
else CurseCount:=30;
end;

procedure TGame.MoneyRecalc;
var i:integer;
p:pinteger;
begin
CurrGold:=0;
for i:=0 to Opened.Count-1 do
        begin
        p:=Opened.Items[i];
        if (p^<20)or(Used.exists(i)) then
                Game.CurrGold:=Game.CurrGold+CI[FindIdCI(p^)].pmoney;
        end;
Game.CurrGold:=Game.CurrGold+Game.BGold;
end;

procedure TGame.BuyRecalc;
var i:integer;
p:pinteger;
begin
CurrBuy:=1;
for i:=0 to Opened.Count-1 do
        begin
        p:=Opened.Items[i];
        if (p^<20)or(Used.exists(i)) then
                Game.CurrBuy:=Game.CurrBuy+CI[FindIdCI(p^)].pbuy;
        end;
Game.CurrBuy:=Game.CurrBuy+Game.BBuy;
end;

function TGame.OpenedExist(num:integer):boolean;
var i:integer;
p:pinteger;
begin
result:=false;
for i:=0 to Opened.Count-1 do
        begin
        p:=Opened.Items[i];
        if p^=num then result:=true;
        end;
end;

function TGame.IsEndGame:boolean;
var i,j,v1:integer;
begin
v1:=0;
result:=false;
for i:=0 to 1 do for j:=0 to 4 do
        if CardNCount[i,j]=0 then v1:=v1+1;
if v1>=3 then result:=true;
if (CardNCount[0,5]=0) and (CardNCount[0,6]=0) and (CardNCount[0,7]=0) then
        result:=true;
end;

function TGame.isMod:boolean;
begin
result:=false;
if (Mod71>0)or(Mod75>0)or(Mod81>0)or(Mod82>0)or(Mod83>0)or(Mod86>0)or(Mod91>0)or(Mod93>0)or(Mod95>0) then
        result:=true;
end;



procedure CardNumInit;
begin
{
CardNum[0,0]:=71;CardNum[1,0]:=72;
CardNum[0,1]:=74;CardNum[1,1]:=78;
CardNum[0,2]:=81;CardNum[1,2]:=83;
CardNum[0,3]:=84;CardNum[1,3]:=85;
CardNum[0,4]:=95;CardNum[1,4]:=98;
}
Unit2.LoadFromFile('Settings.txt');
CardNum[0,0]:=Unit2.Settings[Unit2.CurrSettingsNum,0];CardNum[1,0]:=Unit2.Settings[Unit2.CurrSettingsNum,1];
CardNum[0,1]:=Unit2.Settings[Unit2.CurrSettingsNum,2];CardNum[1,1]:=Unit2.Settings[Unit2.CurrSettingsNum,3];
CardNum[0,2]:=Unit2.Settings[Unit2.CurrSettingsNum,4];CardNum[1,2]:=Unit2.Settings[Unit2.CurrSettingsNum,5];
CardNum[0,3]:=Unit2.Settings[Unit2.CurrSettingsNum,6];CardNum[1,3]:=Unit2.Settings[Unit2.CurrSettingsNum,7];
CardNum[0,4]:=Unit2.Settings[Unit2.CurrSettingsNum,8];CardNum[1,4]:=Unit2.Settings[Unit2.CurrSettingsNum,9];


CardNum[0,5]:=1;CardNum[1,5]:=11;
CardNum[0,6]:=2;CardNum[1,6]:=12;
CardNum[0,7]:=3;CardNum[1,7]:=13;

end;

procedure CardNCountInit;
var i,j:integer;
begin
for i:=0 to 1 do for j:=0 to 4 do
        CardNCount[i,j]:=10;

CardNCount[1,5]:=60-7*Game.PlayerCount;
CardNCount[1,6]:=40;
CardNCount[1,7]:=30;

if Game.PlayerCount<=2 then
        begin
        CardNCount[0,7]:=8;
        CardNCount[0,6]:=8;
        CardNCount[0,5]:=8;
        end else
        begin
        CardNCount[0,7]:=12;
        CardNCount[0,6]:=12;
        CardNCount[0,5]:=12;
        end;
end;

procedure CIInit;
var i:integer;
begin
//0-3
i:=0;
with CI[i] do
        begin id:=1;cost:=2;active:=0;paction:=0;pmoney:=0;pcards:=0;pbuy:=0;pwin:=1;attack:=0;spec:=0;
        name:='��������'; info:='���� �������� ����'; end; i:=i+1; //��
with CI[i] do
        begin id:=2;cost:=5;active:=0;paction:=0;pmoney:=0;pcards:=0;pbuy:=0;pwin:=3;attack:=0;spec:=0;
        name:='����������'; info:='��� �������� ����'; end; i:=i+1; //��
with CI[i] do
        begin id:=3;cost:=8;active:=0;paction:=0;pmoney:=0;pcards:=0;pbuy:=0;pwin:=6;attack:=0;spec:=0;
        name:='���������'; info:='����� �������� �����'; end; i:=i+1; //��
with CI[i] do
        begin id:=4;cost:=0;active:=0;paction:=0;pmoney:=0;pcards:=0;pbuy:=0;pwin:=-1;attack:=0;spec:=0;
        name:='���������'; info:='����� ���� �������� ����'; end; i:=i+1; //��

//4-6
with CI[i] do
        begin id:=11;cost:=0;active:=0;paction:=0;pmoney:=1;pcards:=0;pbuy:=0;pwin:=0;attack:=0;spec:=0;
        name:='����'; info:='������ ���������� 1'; end; i:=i+1;   //��
with CI[i] do
        begin id:=12;cost:=3;active:=0;paction:=0;pmoney:=2;pcards:=0;pbuy:=0;pwin:=0;attack:=0;spec:=0;
        name:='�������'; info:='������ ���������� 2'; end; i:=i+1;  //��
with CI[i] do
        begin id:=13;cost:=6;active:=0;paction:=0;pmoney:=3;pcards:=0;pbuy:=0;pwin:=0;attack:=0;spec:=0;
        name:='������'; info:='������ ���������� 3'; end; i:=i+1;   //��

//7-10
with CI[i] do
        begin id:=71;cost:=3;active:=1;paction:=0;pmoney:=0;pcards:=0;pbuy:=0;pwin:=0;attack:=0;spec:=1;
        name:='����������'; info:='�������� ����� �� ������ 4'; end; i:=i+1;//��
with CI[i] do
        begin id:=72;cost:=3;active:=1;paction:=0;pmoney:=2;pcards:=0;pbuy:=1;pwin:=0;attack:=0;spec:=0;
        name:='�������'; info:='+1 ������� +2 �����'; end; i:=i+1; //��
with CI[i] do
        begin id:=73;cost:=5;active:=1;paction:=0;pmoney:=0;pcards:=2;pbuy:=0;pwin:=0;attack:=1;spec:=0;
        name:='������'; info:='+2 �����, ��������� ������ �������� �� ����� ���������'; end; i:=i+1; //��
with CI[i] do
        begin id:=74;cost:=3;active:=1;paction:=2;pmoney:=0;pcards:=1;pbuy:=0;pwin:=0;attack:=0;spec:=0;
        name:='�������'; info:='+2 �������� +1 �����'; end; i:=i+1; //��

//11-15
with CI[i] do
        begin id:=75;cost:=4;active:=1;paction:=0;pmoney:=0;pcards:=0;pbuy:=0;pwin:=0;attack:=0;spec:=1;//��
        name:='������� ���'; info:='�������� �� ���� ����� � ��������� �� �������� ��������� �� ���� ���� �����'; end; i:=i+1;
with CI[i] do
        begin id:=76;cost:=4;active:=1;paction:=0;pmoney:=2;pcards:=0;pbuy:=0;pwin:=0;attack:=2;spec:=0;//��
        name:='���'; info:='���� ����� ������ ���� ���� �������� ����� �������� ��� ����� ��������� ��� �������'; end; i:=i+1;
with CI[i] do
        begin id:=77;cost:=4;active:=1;paction:=1;pmoney:=0;pcards:=1;pbuy:=0;pwin:=0;attack:=3;spec:=0;//��
        name:='�����'; info:='������ ����� ������� ��� ������ ����� ���������� ���� � ����� ���� � ������ �� ������ ������'; end; i:=i+1;
with CI[i] do
        begin id:=78;cost:=4;active:=1;paction:=0;pmoney:=0;pcards:=3;pbuy:=0;pwin:=0;attack:=0;spec:=0;
        name:='�������'; info:='+3 �����'; end; i:=i+1; //��
with CI[i] do
        begin id:=79;cost:=4;active:=0;paction:=0;pmoney:=0;pcards:=0;pbuy:=0;pwin:=0;attack:=0;spec:=0;
        name:='����'; info:='�������� 1 �������� ���� �� ������ 10 ���� � ����� ������'; end; i:=i+1; //��

//16-19
with CI[i] do
        begin id:=81;cost:=4;active:=1;paction:=0;pmoney:=0;pcards:=0;pbuy:=0;pwin:=0;attack:=0;spec:=1;//��
        name:='�������������'; info:='�������� �� ������ ����� � ����, �������� ����� ������ ��������� �� ����� ��� �� 2'; end; i:=i+1;
with CI[i] do
        begin id:=82;cost:=3;active:=1;paction:=0;pmoney:=3;pcards:=0;pbuy:=0;pwin:=0;attack:=0;spec:=0;
        name:='���������'; info:='�������� �� ������ ����� ����, �������� 3 ������'; end; i:=i+1; //��
with CI[i] do
        begin id:=83;cost:=5;active:=1;paction:=0;pmoney:=0;pcards:=0;pbuy:=0;pwin:=0;attack:=0;spec:=1;//��
        name:='������'; info:='��������� ����� ���� �� ����� ������� ��� ����� ������� �� ����� ������'; end; i:=i+1;
with CI[i] do
        begin id:=84;cost:=4;active:=1;paction:=0;pmoney:=2;pcards:=0;pbuy:=0;pwin:=0;attack:=4;spec:=0;
        name:='���������'; info:='��� ��������� ������ ���������� ��� ����� �� ����'; end; i:=i+1;//��

//20-23
with CI[i] do
        begin id:=85;cost:=5;active:=1;paction:=1;pmoney:=1;pcards:=1;pbuy:=1;pwin:=0;attack:=0;spec:=0;
        name:='�����'; info:='+1 �����,+1 ��������, +1 �������, +1 ������'; end; i:=i+1; //��
with CI[i] do
        begin id:=86;cost:=5;active:=1;paction:=0;pmoney:=0;pcards:=0;pbuy:=0;pwin:=0;attack:=0;spec:=0;//��
        name:='����������'; info:='������ ����� �� ��� ��� ���� �� �� �������� 7 �� ����, ����� ����������� ����� ��������'; end; i:=i+1;
with CI[i] do
        begin id:=87;cost:=5;active:=1;paction:=1;pmoney:=0;pcards:=2;pbuy:=0;pwin:=0;attack:=0;spec:=0;
        name:='�����������'; info:='+2 ����� +1 ��������'; end; i:=i+1; //��
with CI[i] do
        begin id:=88;cost:=5;active:=1;paction:=2;pmoney:=2;pcards:=0;pbuy:=1;pwin:=0;attack:=0;spec:=0;
        name:='���������'; info:='+2 �������� +1 ������� +2 ������'; end; i:=i+1; //��

//24-27
with CI[i] do
        begin id:=91;cost:=4;active:=1;paction:=0;pmoney:=0;pcards:=0;pbuy:=0;pwin:=0;attack:=0;spec:=1;
        name:='���'; info:='�������� ��� ����� �� ������. �������� ����� �� ������ 5'; end; i:=i+1;//��
with CI[i] do
        begin id:=92;cost:=3;active:=1;paction:=0;pmoney:=0;pcards:=4;pbuy:=1;pwin:=0;attack:=6;spec:=1;//��
        name:='��� ������'; info:='+4 ����� +1 �������, ��� ��������� ������ ����� �� 1 �����'; end; i:=i+1;
with CI[i] do
        begin id:=93;cost:=5;active:=1;paction:=0;pmoney:=0;pcards:=0;pbuy:=0;pwin:=0;attack:=0;spec:=0;
        name:='�������'; info:='����� �������� �� 4 ���� �� ������'; end; i:=i+1; //��
with CI[i] do
        begin id:=94;cost:=4;active:=1;paction:=0;pmoney:=2;pcards:=0;pbuy:=0;pwin:=0;attack:=1;spec:=0;
        name:='�������'; info:='+2 ������, ������ ���������� ���������� ������ � �����'; end; i:=i+1; //��

//28-31
with CI[i] do
        begin id:=95;cost:=2;active:=1;paction:=1;pmoney:=0;pcards:=0;pbuy:=0;pwin:=0;attack:=0;spec:=1;//��
        name:='�������'; info:='�������� ����� ����� ���� ������� �������� ������� �� ����'; end; i:=i+1;
with CI[i] do
        begin id:=96;cost:=4;active:=1;paction:=0;pmoney:=0;pcards:=0;pbuy:=0;pwin:=0;attack:=5;spec:=0;//��
        name:='��������'; info:='�������� ����� �������, �������� �� � ������. ��������� ������ ���������� �� ����� ������ � ���� � ������ �� � ���� ������'; end; i:=i+1;
with CI[i] do
        begin id:=97;cost:=5;active:=1;paction:=0;pmoney:=0;pcards:=0;pbuy:=0;pwin:=0;attack:=0;spec:=0;//��
        name:='�������� �����������'; info:='������ ����� �� ��� ��� ���� �� �������� 2 ����� ���������'; end; i:=i+1;
with CI[i] do
        begin id:=98;cost:=2;active:=1;paction:=0;pmoney:=0;pcards:=2;pbuy:=0;pwin:=0;attack:=0;spec:=0;
        name:='���'; info:='������ �� �����, +2 �����'; end; //��
end;

function FindIdCI(id:integer):integer;
var i:integer;
begin
result:=-1;
for i:=0 to 31 do
        if CI[i].id = id then result:=i;
end;


{$R *.dfm}

procedure TForm1.OutLaInfo;
begin
Label1.Caption:='�������� '+IntToStr(Game.CurrAction);
Label2.Caption:='������� '+IntToStr(Game.CurrBuy);
Label3.Caption:='����� '+IntToStr(Game.CurrGold);
Label4.Caption:='����� ����� '+IntToStr(Game.CurrPlayer+1);
end;


procedure TForm1.SBEditSetClick(Sender: TObject);
begin
Form2.Showmodal;
end;



procedure TForm1.FormCreate(Sender: TObject);
var i,j:integer;
begin
Randomize;
Bmp:=TBitMap.Create;
Bmp.Width:=65;
Bmp.Height:=100;
Used:=TUsed.Create;
Game:=TGame.Create;
Game.Svalka:=TList.Create;
Game.Opened:=TList.Create;
for i:=0 to MPC-1 do
        begin
        Game.pl[i]:=TPlayer.Create;
        Game.pl[i].Cards:=TList.Create;
        Game.pl[i].Sbros:=TList.Create;
        end;

Game.PlayerCount:=3;
CardNumInit;
CardNCountInit;
CIInit;

for i:=0 to 1 do for j:=0 to CBW-1 do
        begin
        ImBuy[i,j]:=TImage.Create(Form1.Panel1);
        ImBuy[i,j].Parent:=Form1.Panel1;
        ImBuy[i,j].Width:=65;
        ImBuy[i,j].Height:=100;
        ImBuy[i,j].Left:=65*j;
        ImBuy[i,j].Top:=100*i;
        ImBuy[i,j].Tag:=i*8+j;
        ImBuy[i,j].Picture.LoadFromFile('Cards\'+IntToStr(CardNum[i,j])+'.bmp');
        ImBuy[i,j].OnClick:=ShopClick;
        ImBuy[i,j].ShowHint:=true;
        ImBuy[i,j].Hint:=CI[FindIdCI(CardNum[i,j])].info+' ��������� '+IntToStr(CI[FindIdCI(CardNum[i,j])].cost);
        ImBuy[i,j].Canvas.TextOut(20,20,IntToStr(CardNCount[i,j]));
        end;
end;

procedure TForm1.ReloadImBuy(i,j:integer);
begin
ImBuy[i,j].Picture.LoadFromFile('Cards\'+IntToStr(CardNum[i,j])+'.bmp');
ImBuy[i,j].Canvas.TextOut(20,20,IntToStr(CardNCount[i,j]));
end;

procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
var i:integer;
begin
Bmp.Free;
for i:=0 to MPC-1 do
        begin
        Game.pl[i].Cards.Free;
        Game.pl[i].Sbros.Free;
        Game.pl[i].Free;
        end;
Game.Free;
Used.Free;
end;

procedure TForm1.SBGameStartClick(Sender: TObject);
var i,j:integer;
begin
Game.PlayerCount:=Unit2.PlayerCount;
CardNumInit;
CardNCountInit;
//test
//CardNCount[0,0]:=1;
//CardNCount[0,2]:=1;
//CardNCount[0,4]:=1;

for i:=0 to 1 do for j:=0 to CBW-1 do
        begin
        ImBuy[i,j].Picture.LoadFromFile('Cards\'+IntToStr(CardNum[i,j])+'.bmp');
        ImBuy[i,j].Hint:=CI[FindIdCI(CardNum[i,j])].info+' ��������� '+IntToStr(CI[FindIdCI(CardNum[i,j])].cost);
        ImBuy[i,j].Canvas.TextOut(20,20,IntToStr(CardNCount[i,j]));
        end;
Game.init;
Game.CurrPlayer:=0;
Game.CurrAction:=1;

Panel1.Visible:=true;
Panel2.Visible:=true;
Panel3.Visible:=true;
Panel4.Visible:=true;
DrawGrid1.Visible:=true;
Label7.Visible:=true;

DrawGrid1.ColCount:=5;
Game.GameEnd:=false;
DrawGrid1.Repaint;
Label6.Caption:='���������� ���������='+IntToStr(Game.CurseCount);
WinPointInfoOut;
end;



procedure TForm1.SBAction1Click(Sender: TObject);
var i:integer;
p:pinteger;
v1,v2:integer;
begin
for i:=0 to 4 do
        Game.pl[Game.CurrPlayer].GetCard;

DrawGrid1.Repaint;
SBAction1.Enabled:=false;
SBAction2.Enabled:=true;
SBAction3.Enabled:=false;
Game.Step:=1;

for i:=1 to 6 do
        if Game.pl[Game.CurrPlayer].attack[i]>0 then
                begin
                if (i<>6) and Game.OpenedExist(98) then// �� �������� �����
                        begin
                        showmessage('�������� ���. ����� ����������');
                        Game.pl[Game.CurrPlayer].attack[i]:=0;
                        end else
                        begin
                        case i of
                        1: begin //������
                           showmessage('������ �������');
                           if Game.CurseCount>0 then
                                   begin
                                   new(p);
                                   p^:=4;
                                   Game.Opened.Add(p);
                                   DrawGrid1.ColCount:=DrawGrid1.ColCount+1;
                                   //��������� ���������� ���������
                                   Game.CurseCount:=Game.CurseCount-1;
                                   Label6.Caption:='���������� ���������='+IntToStr(Game.CurseCount);
                                   end;
                           end;
                        2: begin  //���
                           showmessage('��� �������');
                           p:=Game.Opened.Items[0];
                           v1:=p^;
                           p:=Game.Opened.Items[1];
                           v2:=p^;
                           if ( ((v1>=11)and(v1<=13)) or ((v2>=11)and(v2<=13)) ) then
                                begin
                                Game.Attack2:=Game.pl[Game.CurrPlayer].attack[2];
                                end;
                           end;
                        3: begin //�����
                           showmessage('����� �������');
                           v1:=random(Game.pl[Game.CurrPlayer].Cards.Count);
                           p:=Game.pl[Game.CurrPlayer].Cards.Items[v1];
                           showmessage('����� ����������� ����� '+CI[FindIdCI(p^)].name);
                           Game.pl[Game.CurrPlayer].GetCard;
                           if Application.MessageBox('��������� �� ����� � �����?','�����',1) = 1 then
                                begin
                                Game.pl[Game.CurrPlayer].Cards.Delete(v1);
                                Game.pl[Game.CurrPlayer].Sbros.Add(p);
                                end;
                           end;
                        4: begin
                           showmessage('��������� �������');
                           showmessage('���������� ������� ��� ����� ����� ��������');
                           Game.Attack4:=2;
                           end;
                        5: begin//���������� � ������ ����� ������
                           showmessage('�������� �������');
                           for v1:=4 downto 0 do
                                begin
                                p:=Game.Opened[v1];
                                if (p^>=1) and (p^<=3) then//����� ����� ������, ������ �� ������� � ������
                                        begin
                                        Game.pl[Game.CurrPlayer].Cards.Add(p);
                                        Game.Opened.Delete(v1);
                                        DrawGrid1.ColCount:=DrawGrid1.ColCount-1;
                                        end;
                                end;
                           DrawGrid1.Repaint;
                           end;
                        6: begin
                           showmessage('�������� ��� ������');
                           Game.pl[Game.CurrPlayer].GetCard;
                           DrawGrid1.ColCount:=DrawGrid1.ColCount+1;
                           DrawGrid1.Repaint;
                           end;
                        end;
                        Game.pl[Game.CurrPlayer].attack[i]:=0;
                        DrawGrid1.Repaint;
                        end;
                end;

Game.CurrAction:=1;
Game.CurrBuy:=1;
Game.MoneyRecalc;
Form1.OutLaInfo;
end;



procedure TForm1.DrawGrid1DrawCell(Sender: TObject; ACol, ARow: Integer;
  Rect: TRect; State: TGridDrawState);
var p:pinteger;
begin
if Game.GameEnd then
        begin
        DrawGrid1.Canvas.TextOut(Rect.Left+10,Rect.Top+10,IntToStr(Game.pl[ACol].WinPoints));
        exit;
        end;

if ACol>=Game.Opened.Count then
        begin
        DrawGrid1.Canvas.Brush.Color:=clWhite;
        DrawGrid1.Canvas.FillRect(Rect);
        end else
        begin
        p:=Game.Opened.Items[ACol];
        bmp.LoadFromFile('Cards\'+IntToStr(p^)+'.bmp');
        DrawGrid1.Canvas.Draw(Rect.Left,Rect.Top,bmp);
        end;
end;



procedure TForm1.DrawGrid1MouseDown(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
var ACol,ARow,i,v,v2,v3:integer;
p,p2:pinteger;
begin
DrawGrid1.MouseToCell(X,Y,ACol,ARow);
if ARow<>0 then exit;
if ACol<0 then exit;
p:=Game.Opened.Items[ACol];
v:=FindIdCI(p^);

if (Game.Attack2>0)and(ACol<=1)and (p^>=11)and (p^<=13) then
        begin
        if Application.MessageBox('������ ������� ��������� �����','���',1)=1 then
                begin//������ ��������� �����
                Game.pl[Game.Attack2].Sbros.Add(p);
                end;
        Game.Opened.Delete(ACol);
        Used.recalc(ACol);
        DrawGrid1.ColCount:=DrawGrid1.ColCount-1;
        Game.Attack2:=0;
        exit;
        end;


if Game.Attack4 > 0 then//������� ����� (���������� � �����)
        begin
        Game.pl[Game.CurrPlayer].Sbros.Add(p);
        Game.Opened.Delete(Acol);
        Used.recalc(ACol);
        DrawGrid1.ColCount:=DrawGrid1.ColCount-1;
        DrawGrid1.Repaint;
        Game.Attack4:=Game.Attack4-1;
        exit;
        end;

if Game.Mod75 = 1 then
        begin
        if (p^>20)and(p^<>75)and(p^<>97)and(p^<>79) then
                begin//�� �� ����� �� used
                Game.BGold:=CI[v].pmoney;
                Game.CurrAction:=Game.CurrAction+CI[v].paction+1;//��������� ������ ��� �������� ����������
                Game.BBuy:=CI[v].pbuy;
                Game.Mod75:=0;           //� ������ �� ������ ��� ���������� ��������

                if CI[v].pcards>0 then
                        begin
                        for i:=0 to CI[v].pcards-1 do
                                begin
                                Game.pl[Game.CurrPlayer].GetCard;
                                DrawGrid1.ColCount:=DrawGrid1.ColCount+1;
                                end;
                        end;
                Game.MoneyRecalc;
                OutLaInfo;
                DrawGrid1.Repaint;

                if (p^ = 71) then
                        begin
                        showmessage('�������� ����� �� ������ 4');
                        Game.Mod71:=1;
                        end;

                if (p^ = 75) then
                        begin
                        showmessage('�������� ����� �������� ������� ����� ��������� ������');
                        Game.Mod75:=1;
                        end;

                if (p^ = 81) then
                        begin
                        showmessage('�������� ����� � ����');
                        Game.Mod81:=1;
                        end;

                if (p^ = 82) then
                        begin
                        showmessage('�������� ����� ���� ��� ���� ����� ��������� �� ������');
                        Game.Mod82:=1;
                        end;

                if (p^ = 83) then
                        begin
                        showmessage('�������� ����� ��������� �� ����');
                        Game.Mod83:=1;
                        end;

                if (p^=86) then
                        begin
                        showmessage('��������� ����� ����� ������ ������������ �� 7 ����. ����� �������� ����� ����� ������� �� ���. ��������� ������� ������� ����� �� ����������.');
                        Game.Mod86:=1;
                        end;

                if (p^=91) then
                        begin
                        showmessage('�������� ����� �� ������ 5');
                        Game.Mod91:=1;
                        Game.Mod91C:=ACol;
                        end;

                if (p^=93) then
                        begin
                        showmessage('�������� ����� ������� ����� �������� �� 4 ���� � ����� ������� ������������');
                        Game.Mod93:=1;
                        Game.Mod95C:=4;
                        end;

                if (p^=94) then
                        begin
                        showmessage('������������� ������ � �����');
                        for i:=Game.pl[Game.CurrPlayer].Sbros.Count-1 downto 0 do
                                begin
                                p2:=Game.pl[Game.CurrPlayer].Sbros.Items[i];
                                Game.pl[Game.CurrPlayer].Cards.Add(p2);
                                Game.pl[Game.CurrPlayer].Sbros.Delete(i);
                                end;
                        end;

                if (p^=95) then
                        begin
                        showmessage('��������� ����� ����� ������ �������� � ����� ������� ������ ������������');
                        Game.Mod95:=1;
                        Game.Mod95C:=0;
                        end;

                if (p^=96) then
                        begin
                        showmessage('��������� ��������� �� ��������� ����� ������� � ������');
                        new(p);
                        p^:=12;
                        Game.pl[Game.CurrPlayer].Cards.Add(p);
                        end;

                end;
        exit;
        end;

if Game.Mod81 = 1 then
        begin
        Game.Mod81C:=ACol;
        Game.Mod81:=CI[v].cost+2;
        showmessage('�������� ����� �� ������ '+inttostr(Game.Mod81));
        exit;
        end;


if Game.Mod82 = 1 then
        begin
        if p^=11 then
                begin
                Game.Opened.Delete(ACol);
                Used.recalc(ACol);
                DrawGrid1.ColCount:=DrawGrid1.ColCount-1;
                DrawGrid1.Repaint;
                Game.Mod82:=0;
                end;
        exit;
        end;


if Game.Mod83 = 1 then
        begin
        if (p^<11) or (p^>12) then
                begin
                showmessage('���������� ���� ��� �������');
                exit;
                end;
        p^:=p^+1;
        CardNCount[1,(p^-11)+5]:=CardNCount[1,(p^-11)+5]-1;
        ReloadImBuy(1,(p^-11)+5);
        DrawGrid1.Repaint;
        Game.MoneyRecalc;
        OutLaInfo;
        Game.Mod83:=0;
        exit;
        end;

if (Game.Mod86=1) then
        begin
        if (ACol>5)and(p^>20) then//��� ����� �� ���������� � �����
                begin
                Game.pl[Game.CurrPlayer].Sbros.Add(p);
                Game.Opened.Delete(ACol);
                Used.recalc(ACol);
                DrawGrid1.ColCount:=DrawGrid1.ColCount-1;
                Drawgrid1.Repaint;
                exit;
                end;
        if (p^=86) then //��� ������ ��� �� �������� �� ����������
                begin
                showmessage('�������� ���������� �����������');
                Game.Mod86:=0;
                Used.add(ACol);
                Game.MoneyRecalc;
                OutLaInfo;
                exit;
                end;
        exit;
        end;

if Game.Mod93 > 0 then//������� �����
        begin
        if Game.Mod93C=0 then
                begin
                showmessage('�� ��� ��������� �� ������ 4 �����');
                exit;
                end;
        Game.Opened.Delete(Acol);
        Used.recalc(acol);
        DrawGrid1.ColCount:=DrawGrid1.ColCount-1;
        DrawGrid1.Repaint;
        Game.Mod93C:=Game.Mod93C-1;
        exit;
        end;


if Game.Mod95 > 0 then//������� ����� (���������� � �����)
        begin
        Game.pl[Game.CurrPlayer].Sbros.Add(p);
        Game.Opened.Delete(Acol);
        Used.recalc(ACol);
        DrawGrid1.ColCount:=DrawGrid1.ColCount-1;
        DrawGrid1.Repaint;
        Game.Mod95C:=Game.Mod95C+1;
        exit;
        end;

//�������� �� ���������� ����� ��� ����������� ���������������

if (Game.Step=2) then
        begin
        showmessage('�� ����� ������� ����� ��� ������ ������������ �����');
        exit;
        end;

if Used.exists(ACol) then
        begin
        showmessage('��� ����� ��� ������������');
        exit;
        end;
if CI[v].active=0 then
        begin
        showmessage('��� ����� �� ���������� �������� ��������');
        exit;
        end;
if Game.CurrAction = 0 then
        begin
        showmessage('� ��� �� ������� �������� ��� ���������� �����');
        exit;
        end;

Game.CurrAction:=Game.CurrAction+CI[v].paction-1;
if CI[v].attack>0 then
        begin
        Showmessage('���������� ����� �� ������');
        for i:=0 to Game.PlayerCount-1 do if i<>Game.CurrPlayer then
                begin
                if (CI[v].attack=2)or(CI[v].attack=3) then
                        Game.pl[i].attack[CI[v].attack]:=Game.CurrPlayer+1
                else
                        Game.pl[i].attack[CI[v].attack]:=1;

                end;
        if CI[v].attack = 3 then
                Game.pl[Game.CurrPlayer].attack[3]:=Game.CurrPlayer;
        end;

if CI[v].pcards>0 then
        begin
        for i:=0 to CI[v].pcards-1 do
                begin
                Game.pl[Game.CurrPlayer].GetCard;
                DrawGrid1.ColCount:=DrawGrid1.ColCount+1;
                end;
        end;


if (p^ = 71) then
        begin
        showmessage('�������� ����� �� ������ 4');
        Game.Mod71:=1;
        end;

if (p^ = 75) then
        begin
        showmessage('�������� ����� �������� ������� ����� ��������� ������');
        Game.Mod75:=1;
        end;

if (p^ = 81) then
        begin
        showmessage('�������� ����� � ����');
        Game.Mod81:=1;
        end;

if (p^ = 82) then
        begin
        showmessage('�������� ����� ���� ��� ���� ����� ��������� �� ������');
        Game.Mod82:=1;
        end;

if (p^ = 83) then
        begin
        showmessage('�������� ����� ��������� �� ����');
        Game.Mod83:=1;
        end;

if (p^=86) then
        begin
        showmessage('��������� ����� ����� ������ ������������ �� 7 ����. ����� �������� ����� ����� ������� �� ���. ��������� ������� ������� ����� �� ����������.');
        Game.Mod86:=1;
        end;

if (p^=91) then
        begin
        showmessage('�������� ����� �� ������ 5');
        Game.Mod91:=1;
        Game.Mod91C:=ACol;
        end;

if (p^=93) then
        begin
        showmessage('�������� ����� ������� ����� �������� �� 4 ���� � ����� ������� ������������');
        Game.Mod93:=1;
        Game.Mod95C:=4;
        end;

if (p^=94) then
        begin
        showmessage('������������� ������ � �����');
        for i:=Game.pl[Game.CurrPlayer].Sbros.Count-1 downto 0 do
                begin
                p2:=Game.pl[Game.CurrPlayer].Sbros.Items[i];
                Game.pl[Game.CurrPlayer].Cards.Add(p2);
                Game.pl[Game.CurrPlayer].Sbros.Delete(i);
                end;
        end;

if (p^=95) then
        begin
        showmessage('��������� ����� ����� ������ �������� � ����� ������� ������ ������������');
        Game.Mod95:=1;
        Game.Mod95C:=0;
        end;

if (p^=96) then
        begin
        showmessage('��������� ��������� �� ��������� ����� ������� � ������');
        new(p);
        p^:=12;
        Game.pl[Game.CurrPlayer].Cards.Add(p);
        end;

if (p^=97) then
        begin
        showmessage('��������� �������� �����������');
        v2:=0;
        while (v2<2) do
                begin
                if Game.pl[Game.CurrPlayer].Cards.Count=0 then
                        begin
                        for i:=0 to Game.pl[Game.CurrPlayer].Sbros.Count-1 do
                                Game.pl[Game.CurrPlayer].Cards.Add(Game.pl[Game.CurrPlayer].Sbros.Items[i]);
                        Game.pl[Game.CurrPlayer].Sbros.Clear;
                        end;

                v3:=random(Game.pl[Game.CurrPlayer].Cards.Count);
                p:=Game.pl[Game.CurrPlayer].Cards.Items[v3];
                Game.pl[Game.CurrPlayer].Cards.Delete(v3);
                if (p^>=11)and(p^<=13) then
                        begin
                        Game.Opened.Add(p);
                        DrawGrid1.ColCount:=DrawGrid1.ColCount+1;
                        DrawGrid1.Repaint;
                        v2:=v2+1;
                        end else
                        begin
                        Game.pl[Game.CurrPlayer].Sbros.Add(p);
                        end;
                end;
        end;

Used.add(ACol);
DrawGrid1.Repaint;
Game.MoneyRecalc;
OutLaInfo;
end;



procedure TForm1.SBAction2Click(Sender: TObject);
begin
if Game.IsMod then
        begin
        showmessage('������� ���������� ��������� ����������� �������� ����');
        exit;
        end;

if Game.Attack4>0 then
        begin
        showmessage('������� ������� 2 ����� �� ����� ���������');
        exit;
        end;

Game.Step:=2;
Game.BuyRecalc;
Game.MoneyRecalc;
OutLaInfo;
SBAction1.Enabled:=false;
SBAction2.Enabled:=false;
SBAction3.Enabled:=true;
end;



procedure TForm1.SBAction3Click(Sender: TObject);
var i:integer;
begin
for i:=0 to Game.Opened.Count-1 do
        Game.pl[Game.CurrPlayer].Sbros.Add(Game.Opened.Items[i]);
Game.Opened.Clear;
Used.clear;


Game.Step:=0;
Game.CurrPlayer:=Game.CurrPlayer+1;
if Game.CurrPlayer=Game.PlayerCount then Game.CurrPlayer:=0;
Game.CurrAction:=1;
Game.CurrBuy:=1;
Game.CurrGold:=0;
Game.BGold:=0;
OutLaInfo;
DrawGrid1.ColCount:=5;
DrawGrid1.Repaint;
SBAction1.Enabled:=true;
SBAction2.Enabled:=false;
SBAction3.Enabled:=false;

if Game.isEndGame=true then
        begin
        ShowMessage('���� ���������, ������������ ����');
        Game.GameEnd:=true;
        DrawGrid1.ColCount:=Game.PlayerCount;
        DrawGrid1.Repaint;
        end;
WinPointInfoOut;
end;



procedure TForm1.ShopClick(Sender:TObject);
var v:integer;
p:pinteger;
begin
v:=CardNum[TImage(Sender).Tag div 8,TImage(Sender).Tag mod 8];

if CardNCount[TImage(Sender).Tag div 8,TImage(Sender).Tag mod 8]=0 then
        begin
        showmessage('������ ���������� �����. ����� ��� � �������');
        exit;
        end;

if (Game.Step<>2)and(Game.Mod71=0)and(Game.Mod81<=1) then
        begin
        showmessage('��������� �� ���� ������� ����');
        exit;
        end;


if Game.Mod71 = 1 then
        begin
        if (TImage(Sender).Tag mod 8)>=5 then
                begin
                showmessage('�� �� �������� ����� �������� ��� �������� �����');
                exit;
                end;

        if CI[FindIdCI(v)].cost>4 then
                begin
                showmessage('��������� ����� ������ 4');
                exit;
                end;

        new(p);
        p^:=v;
        Game.Opened.Add(p);
        Used.add(DrawGrid1.ColCount);
        DrawGrid1.ColCount:=DrawGrid1.ColCount+1;
        DrawGrid1.Repaint;

        CardNCount[TImage(Sender).Tag div 8,TImage(Sender).Tag mod 8]:=CardNCount[TImage(Sender).Tag div 8,TImage(Sender).Tag mod 8]-1;
        ReloadImBuy(TImage(Sender).Tag div 8,TImage(Sender).Tag mod 8);
        Game.Mod71 := 0;
        exit;
        end;


if Game.Mod81>=2 then
        begin
        if CI[FindIdCI(v)].cost>Game.Mod81 then
                begin
                showmessage('��������� ����� ������� ������');
                exit;
                end;

        p:=Game.Opened.Items[Game.Mod81C];
        p^:=v;
        Used.add(Game.Mod81C);
        DrawGrid1.Repaint;

        CardNCount[TImage(Sender).Tag div 8,TImage(Sender).Tag mod 8]:=CardNCount[TImage(Sender).Tag div 8,TImage(Sender).Tag mod 8]-1;
        ReloadImBuy(TImage(Sender).Tag div 8,TImage(Sender).Tag mod 8);
        Game.MoneyRecalc;
        OutLaInfo;
        Game.Mod81 := 0;
        Game.Mod81C:=0;
        exit;                
        end;


if Game.Mod91 = 1 then
        begin
        if CI[FindIdCI(v)].cost>5 then
                begin
                showmessage('��������� ����� ������ 5');
                exit;
                end;

        p:=Game.Opened.Items[Game.Mod91C];
        p^:=v;
        Used.add(Game.Mod91C);
        DrawGrid1.Repaint;

        CardNCount[TImage(Sender).Tag div 8,TImage(Sender).Tag mod 8]:=CardNCount[TImage(Sender).Tag div 8,TImage(Sender).Tag mod 8]-1;
        ReloadImBuy(TImage(Sender).Tag div 8,TImage(Sender).Tag mod 8);
        Game.Mod91 := 0;
        exit;
        end;


if CI[FindIdCI(v)].cost>Game.CurrGold then
        begin
        showmessage('������������ ������ ��� ������� �����');
        exit;
        end;

if Game.CurrBuy=0 then
        begin
        showmessage('�� ��������� ��� �������');
        exit;
        end;

//���� �������
new(p);
p^:=v;
Game.Opened.Add(p);
DrawGrid1.ColCount:=DrawGrid1.ColCount+1;
DrawGrid1.Repaint;
Game.CurrGold:=Game.CurrGold-CI[FindIdCI(v)].cost;
Game.CurrBuy:=Game.CurrBuy-1;
OutLaInfo;

CardNCount[TImage(Sender).Tag div 8,TImage(Sender).Tag mod 8]:=CardNCount[TImage(Sender).Tag div 8,TImage(Sender).Tag mod 8]-1;
ReloadImBuy(TImage(Sender).Tag div 8,TImage(Sender).Tag mod 8);
end;



procedure TForm1.SBGameEndClick(Sender: TObject);
var i,j:integer;
begin
Panel1.Visible:=false;
Panel2.Visible:=false;
Panel3.Visible:=false;
Panel4.Visible:=false;
Label7.Visible:=false;
//DrawGrid1.Visible:=false;

CardNCountInit;
for i:=0 to 1 do for j:=0 to CBW-1 do
        begin
        ImBuy[i,j].Picture.LoadFromFile('Cards\'+IntToStr(CardNum[i,j])+'.bmp');
        ImBuy[i,j].Canvas.TextOut(20,20,IntToStr(CardNCount[i,j]));
        end;
Game.GameEnd:=true;
DrawGrid1.ColCount:=Game.PlayerCount;
DrawGrid1.Repaint;
end;



procedure TForm1.FormClick(Sender: TObject);
begin
//Test
//Game.Attack4:=1;
//Game.GameEnd:=true;
Used.showused;
end;

procedure TForm1.Label5Click(Sender: TObject);
var i:integer;
begin
if Game.Mod75=1 then
        begin                        
        if Application.MessageBox('����� �������� �����?','��������',1)=1 then
                Game.Mod75:=0;
        end;

if Game.Mod86=1 then
        begin
        if Game.Opened.Count<=7 then
                Game.pl[Game.CurrPlayer].GetCard;
        DrawGrid1.ColCount:=DrawGrid1.ColCount+1;
        DrawGrid1.Repaint;
        Game.MoneyRecalc;
        OutLaInfo;
        end;


if Game.Mod93=1 then
        begin
        DrawGrid1.Repaint;
        Game.MoneyRecalc;
        OutLaInfo;
        Game.Mod93:=0;
        end;

if Game.Mod95=1 then
        begin
        for i:=0 to Game.Mod95C-1 do
                begin
                Game.pl[Game.CurrPlayer].GetCard;
                DrawGrid1.ColCount:=DrawGrid1.ColCount+1;
                end;
        DrawGrid1.Repaint;
        Game.MoneyRecalc;
        OutLaInfo;
        Game.Mod95:=0;
        end;

end;

procedure TForm1.WinPointInfoOut;
var i:integer;
s:string;
begin
s:='�������� ����: ';
for i:=0 to Game.PlayerCount-1 do
        begin
        s:=s+IntToStr(Game.pl[i].WinPoints)+'  ';
        end;
Label7.Caption:=s;
end;

end.


