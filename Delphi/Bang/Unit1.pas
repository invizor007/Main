unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, StdCtrls, ExtCtrls, Buttons;

const MPC=8;PersonC=16;ArrowC=9;FCC=5;
RoleNames:array[0..3]of string = ('Шериф', 'Помощник шерифа', 'Бандит', 'Ренегат');
PersonNames:array[0..PersonC-1]of string = ('Журдоннэ','Росс Логан','Кит Карсон',//7
        'Сюзи Лафайет','Туко Рамирес','Бутч Кэссиди', 'Бедовая Джейн', 'Малыш Билли',//8
        'Ангельские глазки', 'Счастливый Люк','Блэк Джек', 'Том Кетчум',//8
        'Хладнокровная Рози', 'Большой Змей', 'Поль Регрет', 'Джесси Джеймс');//9

PersonInfo:array[0..PersonC-1] of string = (
{00}'Вы не можете потерять больше единицы здоровья при нападении индейцев',
{01}'Когда вы теряете одну или несколько единиц жизни из-за другого игрока, этот игрок должен взять стрелу',
{02}'За каждый свой гатлинг вы можете сбросить одну стрелу у любого игрока',

{03}'Если вы не выбросили на кубиках 1 и 2, получите 2 единицы здоровья',
{04}'Всякий раз когда вы теряете единицу здоровья, можете сбросить одну из стрел',
{05}'Можете брать стрелы вместо того чтобы терять здоровье, исключение - динамит, индейцы',
{06}'Можете использовать 1 как 2 и наоборот',
{07}'Вам достаточно двух значений "гатлинг" на кубиках чтобы запустить гатлинг',
{08}'Один раз можете использовать пиво чтобы удвоить 1 и 2',
{09}'Можете один раз дополнительно перебросить кубики',
{10}'Можете перебрасываеть динамит, если только не выпало 3 и больше',
{11}'В начале вашего хода игрок по вашему выбору получает единицу здоровья',

{12}'Можете использовать 1 и 2 на игроков на единицу дальше',
{13}'Всякий раз когда погибает игрок, вы получаете 2 единицы здоровья',
{14}'Вы не теряете единицы здоровья при стрельбе из гатлинга',
{15}'Если у вас 4 единицы здоровья и меньше вы восстанавливаете 2 единицы здоровья вместо 1');

{
Расклады на количество игроков
2- шериф и бандит                                  02
3- шериф, бандит и ренегат                         023
4- шериф, 2бандита, помощник шерифа                0122
5- шериф, 2бандита, помощник шерифа, ренегат       01223
6- шериф, 3бандита, помощник шерифа, ренегат       012223
7- шериф, 3бандита, 2помощника шерифа, ренегат     0112223
8- шериф, 3бандита, 2помощника шерифа, 2 ренегата  01122233
}

{0-шериф
1-помощник шерифа
2-бандит
3-ренегат}

type
  TForm1 = class(TForm)
    LabeledEdit1: TLabeledEdit;
    SpeedButton1: TSpeedButton;
    SpeedButton2: TSpeedButton;
    Panel1: TPanel;
    Panel2: TPanel;
    Image1: TImage;
    laCurrPl2: TLabel;
    laCurrPl3: TLabel;
    Edit1: TEdit;
    laCurrPl1: TLabel;
    SBShowRole: TSpeedButton;
    Panel3: TPanel;
    Panel4: TPanel;
    SpeedButton3: TSpeedButton;
    SpeedButton4: TSpeedButton;
    SpeedButton5: TSpeedButton;
    LaBankArrows: TLabel;
    LaSpecOptions: TLabel;
    CheckBox1: TCheckBox;
    CheckBox2: TCheckBox;
    procedure SpeedButton1Click(Sender: TObject);
    procedure FormCreate(Sender: TObject);
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
    procedure FormClick(Sender: TObject);
    procedure SpeedButton3Click(Sender: TObject);
    procedure lfixCubesClick(Sender:TObject);
    procedure luseCubesClick(Sender:TObject);
    procedure laMatrixClick(Sender:TObject);
    procedure laMatrixOut;
    procedure CurrPlayerInfoOut;
    procedure SpeedButton4Click(Sender: TObject);
    procedure SpeedButton5Click(Sender: TObject);
    procedure SBShowRoleClick(Sender: TObject);
    procedure SpeedButton2Click(Sender: TObject);
    procedure Panel4Click(Sender: TObject);
    procedure LaSpecOptionsClick(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

  TPlayer = class
  public
    id,person,rolenum,role,health,mhealth,arrows:integer;
    procedure Init(iid:integer);
    procedure Heal(v:integer);
    procedure Damage(v,typical:integer);//typical - 1 - обычный урон 0- стрелы или динамит
    procedure Dead;
  end;

  TGame = class
    PlayerCount,wPlayerCount, CurrPlayer, SherifPlayer:integer;
    BankArrows, CurrCubeUse:integer;
    Per1,Per2,Per8,Per11:integer;
    Players:array[0..MPC-1] of TPlayer;
    procedure GiveRoles;
    procedure GivePersons;
    procedure ArrowsToBank;
    function GoodTargetPlayer(pl1,pl2,v:integer):boolean;
    function OnlyGoodRoles:boolean;
  end;

  TRandUsed = class
    a:array[0..MPC-1]of integer;
  public
    function Used(r:integer):boolean;
    procedure Clear;
    procedure Put(r:integer);
  end;

  TFiveCubes = class
  public
    a:array[0..FCC-1] of integer;
    fixed:array[0..FCC-1]of integer;
    used:array[0..FCC-1]of integer;
    step:integer;
    procedure init;
    procedure fix(i,v:integer);
    procedure throw;
    function CanNextPlayer:boolean;
  end;

var
  Form1: TForm1;
  Game: TGame;
  AllRole:array[2..MPC,0..MPC-1] of Integer;
  RandUsed:TRandUsed;
  PersonHP:array[0..PersonC-1]of integer;
  FiveCubes: TFiveCubes;

  imgCubes:array[0..FCC-1]of TImage;
  lfixCubes:array[0..FCC-1]of TLabel;
  luseCubes:array[0..FCC-1]of TLabel;
  laMatrix:array[0..MPC-1,0..2]of TLabel;//0- имя, 1- количество жизней,2- количество стрел

implementation

procedure qq(i:integer);
begin
showmessage(inttostr(i));
end;

function TRandUsed.Used(r:integer):boolean;
var i:integer;
begin
result:=false;
for i:=0 to MPC-1 do
        if a[i]=r then result:=true;
end;

procedure TRandUsed.Clear;
var i:integer;
begin
for i:=0 to MPC-1 do
        a[i]:=-1;
end;

procedure TRandUsed.Put(r:integer);
var i:integer;
begin
i:=0;
while a[i]<>-1 do
        i:=i+1;
a[i]:=r;
end;



procedure TFiveCubes.init;
var i:integer;
begin
for i:=0 to FCC-1 do
        begin
        a[i]:=-1;
        fixed[i]:=0;
        used[i]:=-1;
        end;
step:=0;
end;

procedure TFiveCubes.fix(i,v:integer);
begin
fixed[i]:=v;
end;

//0-Динамит
//1-выстрел на 1
//2-выстрел на 2
//3-гатлинг
//4-пиво
//5-стрела

procedure TFiveCubes.throw;
var i,r,v:integer;
begin
if Game.Players[Game.CurrPlayer].person = 9 then// специальноесвойство
        v:=4 else v:=3;

if step>=v then //специальноесвойство
        begin
        Showmessage('Вы уже перебрасывали кубики максимальное количество раз');
        exit;
        end;

for i:=0 to FCC-1 do
        if fixed[i]=0 then
                begin
                r:=random(6);
                if (r=0) and (Game.Players[Game.CurrPlayer].person<>10) then//специальноесвойство
                        begin
                        fixed[i]:=2;
                        used[i]:=2;
                        lfixCubes[i].Caption:='Не бросать';
                        lfixCubes[i].Color:=clRed;
                        luseCubes[i].Caption:='Не используется';
                        luseCubes[i].Color:=clRed;
                        end;
                if r=5 then
                        begin
                        used[i]:=2;
                        luseCubes[i].Caption:='Не используется';
                        luseCubes[i].Color:=clRed;
                        Game.Players[Game.CurrPlayer].arrows:=Game.Players[Game.CurrPlayer].arrows+1;
                        Game.BankArrows:=Game.BankArrows-1;
                        if Game.BankArrows = 0 then
                                Game.ArrowsToBank;//Процедура передачи стрел в банк с потерей жизней
                        end;
                if (r in [1,2,3,4]) then
                        begin
                        used[i]:=0;
                        luseCubes[i].Color:=clYellow;
                        luseCubes[i].Caption:='Использовать';
                        end;
                a[i]:=r;
                end;
step:=step+1;

//условие на то что выпало 3 динамита
r:=0;
for i:=0 to FCC-1 do
        if a[i]=0 then r:=r+1;
if r>=3 then
        begin
        Form1.SpeedButton4Click(Form1.SpeedButton4);
        Game.Players[Game.CurrPlayer].Damage(1,0);
        Form1.laMatrixOut;
        Form1.CurrPlayerInfoOut;
        end;
end;

function TFiveCubes.CanNextPlayer:boolean;
var i:integer;
begin
result:=true;
for i:=0 to FCC-1 do
        if (a[i] in [1,2]) and (used[i]=0) then
                result:=false;
end;



procedure TPlayer.init(iid:integer);
begin
id:=iid;
end;

procedure TPlayer.Heal(v:integer);
begin
if (person = 15) and (health<=4) and (v=1) then//Специальноесвойство
        v:=2;

health:=health+v;
if health>mhealth then
        health:=mhealth;
end;

procedure TPlayer.Damage(v,typical:integer);
begin
if (Form1.CheckBox1.Checked) and (person=4) and (arrows>0) then
        begin
        arrows:=arrows-1;
        Game.BankArrows:=Game.BankArrows+1;
        end;

if (Form1.CheckBox2.Checked) and (person=5) then
        begin
        arrows:=arrows+1;
        Game.BankArrows:=Game.BankArrows-1;
        if Game.BankArrows = 0 then
                Game.ArrowsToBank;//Процедура передачи стрел в банк с потерей жизней
        exit;
        end;

health:=health-v;
if health<=0 then
        begin
        health:=0;
        dead;
        end;


if (person = 1) and (id<>Game.CurrPlayer) and (Game.Per1=0) then//Специальноесвойство
        begin
        Game.Players[Game.CurrPlayer].arrows:=Game.Players[Game.CurrPlayer].arrows+1;
        Game.BankArrows:=Game.BankArrows-1;
        if Game.BankArrows = 0 then
                Game.ArrowsToBank;
        Game.Per1:=1;
        end;
end;

procedure TPlayer.Dead;
var i:integer;
begin
ShowMessage('Игрок номер '+inttostr(id+1)+' мертв');

if Game.CurrPlayer > id then
        Game.CurrPlayer:=Game.CurrPlayer-1;

for i:=id to Game.PlayerCount-2 do
        begin
        Game.Players[i].id:=i;
        Game.Players[i].person:=Game.Players[i+1].person;
        Game.Players[i].rolenum:=Game.Players[i+1].rolenum;
        Game.Players[i].role:=Game.Players[i+1].role;
        Game.Players[i].health:=Game.Players[i+1].health;
        Game.Players[i].mhealth:=Game.Players[i+1].mhealth;
        Game.Players[i].arrows:=Game.Players[i+1].arrows;
        end;

Game.PlayerCount:=Game.PlayerCount-1;

for i:=0 to Game.PlayerCount-1 do
        begin
        if Game.Players[i].role = 0 then
                Game.SherifPlayer:=i;
        end;

for i:=0 to Game.PlayerCount-1 do//специальноесвойство
        begin//если у нас есть большой змей, то он получает 2 единицы здоровья
        if Game.Players[i].person = 13 then
                Game.Players[i].Heal(2);
        end;

Form1.laMatrixOut;
Form1.CurrPlayerInfoOut;


if Game.PlayerCount = 1 then// Если остался последний игрок
        begin
        if Game.Players[0].role in [0,1] then Showmessage('Команда шерифа победила');
        if Game.Players[0].role = 2 then Showmessage('Команда бандитов победила');
        if Game.Players[0].role = 3 then Showmessage('Ренегат победил');
        exit;
        end;

if role=0 then// Если шериф мертв
        begin
        Showmessage('Команда бандитов победила');
        exit;
        end;

if Game.OnlyGoodRoles then
        begin
        Showmessage('Команда шерифа победила');
        exit;
        end;

end;



function TGame.OnlyGoodRoles:boolean;
var i:integer;
begin
result:=true;
for i:=0 to PlayerCount-1 do
        if (Players[i].role in [2,3]) then result:=false;
end;

procedure TGame.GiveRoles;
var r,i:integer;
begin
RandUsed.Clear;
for i:=0 to PlayerCount-1 do
        begin
        repeat
                r:=random(PlayerCount);
        until RandUsed.Used(r)=false;
        RandUsed.Put(r);
        Players[i].rolenum:=r;
        Players[i].role:=AllRole[PlayerCount][r];
        end;

end;

procedure TGame.GivePersons;
var r,i:integer;
begin
BankArrows:=ArrowC;
CurrCubeUse:=-1;
RandUsed.Clear;
for i:=0 to PlayerCount-1 do
        begin
        repeat
                r:=random(PersonC);
        until RandUsed.Used(r)=false;
        RandUsed.Put(r);
        Players[i].person:=r;
        Players[i].mhealth:=PersonHP[r];
        if Players[i].role = 0 then
                begin
                CurrPlayer:=i;
                SherifPlayer:=i;
                if PlayerCount<>2 then
                        Players[i].mhealth:=PersonHP[r]+2;
                end;
        Players[i].health:=Players[i].mhealth;
        end;
end;

procedure TGame.ArrowsToBank;
var i,v:integer;
begin
for i:=0 to PlayerCount-1 do
        begin
        v:=Players[i].arrows;
        if (v>0) and (i<>CurrPlayer) then
                begin
                if Players[i].person = 0 then v:=1;//Проверкаспецсвойства
                Players[i].Damage(v,0);
                Players[i].arrows:=0;
                //Здесь нужно еще условие на то что игрок жив
                end;
        end;
Players[CurrPlayer].arrows:=0;
BankArrows:=ArrowC;
end;

function TGame.GoodTargetPlayer(pl1,pl2,v:integer):boolean;
var v2:integer;
begin
Result:=false;
if (pl1+v) mod Game.PlayerCount = pl2 then Result:=true;
if (pl2+v) mod Game.PlayerCount = pl1 then Result:=true;
if Game.PlayerCount <= 3 then Result:=true;

if (Game.Players[Game.CurrPlayer].person=12) then //специальноесвойство
        begin
        v2:=v+1;
        if (pl1+v2) mod Game.PlayerCount = pl2 then Result:=true;
        if (pl2+v2) mod Game.PlayerCount = pl1 then Result:=true;
        end;

if (Game.Players[Game.CurrPlayer].person=6) then //специальноесвойство
        begin
        v2:=3-v;
        if (pl1+v2) mod Game.PlayerCount = pl2 then Result:=true;
        if (pl2+v2) mod Game.PlayerCount = pl1 then Result:=true;
        end;
end;

{$R *.dfm}

procedure TForm1.SpeedButton1Click(Sender: TObject);
var c,tmp,i:integer;
begin
val(LabeledEdit1.Text,tmp,c);
if (tmp < 2) or (tmp > 8) or (c<>0) then
        begin
        Showmessage('Введите число от 2 до 8');
        exit;
        end;
Game.PlayerCount:=tmp;

for i:=0 to Game.PlayerCount-1 do
        Game.Players[i].init(i);
Game.GiveRoles;
Game.GivePersons;

for i:=0 to Game.PlayerCount-1 do
        begin
        if Game.Players[i].person=4 then CheckBox1.Visible:=true;
        if Game.Players[i].person=5 then CheckBox2.Visible:=true;
        end;

Panel1.Visible:=true;
Panel2.Visible:=true;
Panel3.Visible:=true;
LaBankArrows.Visible:=true;
LaSpecOptions.Visible:=true;

Image1.Hint:=PersonInfo[Game.Players[Game.CurrPlayer].Person];
Image1.Picture.LoadFromFile('Persons\'+IntToStr(Game.Players[Game.CurrPlayer].Person)+'.bmp');
laMatrixOut;
CurrPlayerInfoOut;
end;



procedure TForm1.FormCreate(Sender: TObject);
var i,j:integer;
begin
Randomize;
RandUsed:=TRandUsed.Create;
Game:=TGame.Create;
for i:=0 to MPC-1 do
        Game.Players[i]:=TPlayer.Create;
AllRole[2][0]:=0;AllRole[2][1]:=2;
AllRole[3][0]:=0;AllRole[3][1]:=2;AllRole[3][2]:=3;
AllRole[4][0]:=0;AllRole[4][1]:=1;AllRole[4][2]:=2;AllRole[4][3]:=2;
AllRole[5][0]:=0;AllRole[5][1]:=1;AllRole[5][2]:=2;AllRole[5][3]:=2;AllRole[5][4]:=3;
AllRole[6][0]:=0;AllRole[6][1]:=1;AllRole[6][2]:=2;AllRole[6][3]:=2;AllRole[6][4]:=2;AllRole[6][5]:=3;
AllRole[7][0]:=0;AllRole[7][1]:=1;AllRole[7][2]:=1;AllRole[7][3]:=2;AllRole[7][4]:=2;AllRole[7][5]:=2;AllRole[7][6]:=3;
AllRole[8][0]:=0;AllRole[8][1]:=1;AllRole[8][2]:=1;AllRole[8][3]:=2;AllRole[8][4]:=2;AllRole[8][5]:=2;AllRole[8][6]:=3;AllRole[8][7]:=3;

for i:=0 to 2 do PersonHP[i]:=7;
for i:=3 to 11 do PersonHP[i]:=8;
for i:=12 to 15 do PersonHP[i]:=9;

FiveCubes:=TFiveCubes.Create;
FiveCubes.init;

for i:=0 to FCC-1 do
        begin
        imgCubes[i]:=TImage.Create(Form1.Panel2);
        imgCubes[i].Parent:=Form1.Panel2;
        imgCubes[i].Width:=100;
        imgCubes[i].Height:=100;
        imgCubes[i].Top:=0;
        imgCubes[i].Left:=100*i;
        imgCubes[i].Tag:=i;
        imgCubes[i].Canvas.Brush.Color:=clWhite;
        imgCubes[i].Canvas.FillRect(Rect(0,0,99,99));

        lfixCubes[i]:=TLabel.Create(Form1.Panel2);
        lfixCubes[i].Parent:=Form1.Panel2;
        lfixCubes[i].Width:=100;
        lfixCubes[i].Height:=25;
        lfixCubes[i].Top:=100;
        lfixCubes[i].Left:=100*i;
        lfixCubes[i].AutoSize:=false;
        lfixCubes[i].Color:=clLime;
        lfixCubes[i].Tag:=i;
        lfixCubes[i].OnClick:=lfixCubesClick;
        lfixCubes[i].Caption:='Бросать';
        lfixCubes[i].Enabled:=false;

        luseCubes[i]:=TLabel.Create(Form1.Panel2);
        luseCubes[i].Parent:=Form1.Panel2;
        luseCubes[i].Width:=100;
        luseCubes[i].Height:=25;
        luseCubes[i].Top:=125;
        luseCubes[i].Left:=100*i;
        luseCubes[i].AutoSize:=false;
        luseCubes[i].Color:=clYellow;
        luseCubes[i].Tag:=i;
        luseCubes[i].OnClick:=luseCubesClick;
        luseCubes[i].Caption:='Использовать';
        end;

for i:=0 to MPC-1 do for j:=0 to 2 do
        begin
        laMatrix[i,j]:=TLabel.Create(Form1.Panel3);
        laMatrix[i,j].Parent:=Form1.Panel3;
        if j=0 then
                laMatrix[i,j].Width:=140
        else
                laMatrix[i,j].Width:=40;
        case j of
        0:laMatrix[i,j].Left:=10;
        1:laMatrix[i,j].Left:=160;
        2:laMatrix[i,j].Left:=210;
        end;

        laMatrix[i,j].Height:=25;
        laMatrix[i,j].Top:=i*30+10;
        laMatrix[i,j].AutoSize:=false;
        laMatrix[i,j].Color:=clLime;
        laMatrix[i,j].Tag:=i;
        laMatrix[i,j].OnClick:=laMatrixClick;
        end;
Image1.Picture.LoadFromFile('Persons\0.bmp');
Image1.Hint:='Информация о персонаже';
Image1.ShowHint:=true;
end;



procedure TForm1.lfixCubesClick(Sender:TObject);
begin
if FiveCubes.fixed[TLabel(Sender).Tag]=0 then
        begin
        FiveCubes.fix(TLabel(Sender).Tag,1);
        TLabel(Sender).Color:=clRed;
        TLabel(Sender).Caption:='Не бросать';
        end else
if FiveCubes.fixed[TLabel(Sender).Tag]=1 then
        begin
        FiveCubes.fix(TLabel(Sender).Tag,0);
        TLabel(Sender).Color:=clLime;
        TLabel(Sender).Caption:='Бросать';
        end;
end;

procedure TForm1.luseCubesClick(Sender:TObject);
begin
if FiveCubes.Step<>5 then
        begin
        Showmessage('Необходимо перейти на стадию применения значение на кубиках');
        exit; 
        end;

if FiveCubes.used[TLabel(Sender).Tag]=0 then
        begin
        FiveCubes.used[TLabel(Sender).Tag]:=1;
        TLabel(Sender).Color:=clAqua;
        TLabel(Sender).Caption:='Выбрать игрока';
        Game.CurrCubeUse:=TLabel(Sender).Tag;
        end else
if FiveCubes.used[TLabel(Sender).Tag]=1 then
        begin
        FiveCubes.used[TLabel(Sender).Tag]:=0;
        TLabel(Sender).Color:=clYellow;
        TLabel(Sender).Caption:='Использовать';
        end;
end;

procedure TForm1.laMatrixClick(Sender:TObject);
var v,v2,TargetPlayer,i,j:integer;
b:boolean;
begin
if Game.Per11=1 then
        begin
        TargetPlayer:=TLabel(Sender).Tag;
        Game.Players[TargetPlayer].Heal(1);
        laMatrixOut;
        CurrPlayerInfoOut;
        Game.Per11:=2;
        LaSpecOptions.Color:=clLime;
        exit;
        end;

if Game.CurrCubeUse <> -1 then
        begin
        v:=FiveCubes.a[Game.CurrCubeUse];
        TargetPlayer:=TLabel(Sender).Tag;
        case v of
        1:begin//Если игрок соседний то можно нанести ему урон 1
          if Game.GoodTargetPlayer(Game.CurrPlayer,TargetPlayer,1) then
                begin
                Game.Players[TargetPlayer].Damage(1,1);
                laMatrixOut;
                CurrPlayerInfoOut;
                end else
                begin
                ShowMessage('Для применения кубика выберите соседнего игрока');
                exit;
                end;
          end;

        2:begin
          if Game.GoodTargetPlayer(Game.CurrPlayer,TargetPlayer,2) then
                begin
                Game.Players[TargetPlayer].Damage(1,1);
                laMatrixOut;
                CurrPlayerInfoOut;
                end else
                begin
                ShowMessage('Для применения кубика выберите игрока через одного');
                exit;
                end;
          end;

        3:begin// считаем сколько кубиков гатлинга выпало, если меньше 3 то ничего не делаем, если есть 3 наносим всем урон
          if Game.Per2=1 then//специальноесвойство
                begin
                if Game.Players[TargetPlayer].arrows=0 then exit;
                Game.Players[TargetPlayer].arrows:=Game.Players[TargetPlayer].arrows-1;
                Game.BankArrows:=Game.BankArrows+1;
                LaMatrixOut;
                CurrPlayerInfoOut;
                end;

          if Game.Per2=0 then
                  begin
                  j:=0;
                  for i:=0 to FCC-1 do
                        if FiveCubes.a[i]=3 then
                                j:=j+1;
                  if Game.Players[Game.CurrPlayer].person=7 then//Специальноесвойство
                        v2:=2 else v2:=3;
                  if j<v2 then
                        begin
                        Showmessage('У вас недостаточно кубиков чтобы запустить гатлинг');
                        exit;
                        end else
                        begin
                        for i:=0 to Game.PlayerCount-1 do
                                if (i<>Game.CurrPlayer)and(Game.Players[i].person<>14) then//Специальноесвойство
                                        Game.Players[i].Damage(1,1);
                        laMatrixOut;
                        CurrPlayerInfoOut;
                        end;

                  j:=0;
                  for i:=0 to FCC-1 do
                        begin
                        if (FiveCubes.a[i]=3)and(j<v2) then
                                begin
                                FiveCubes.used[i]:=3;
                                luseCubes[i].Caption:='Уже использовано';
                                luseCubes[i].Color:=clGreen;
                                j:=j+1;
                                end;
                        end;
                  end;
          end;

        4:begin
          if Game.Per8=1 then
                begin//Используем пиво как 1 или 2 если они есть в наличии
                v2:=0;
                for i:=0 to FCC-1 do
                        begin
                        if (FiveCubes.a[i]=1) and (v=0) then v2:=1;
                        if (FiveCubes.a[i]=2) and (v=0) then v2:=2;
                        if (FiveCubes.a[i]=1) and (v=2) then v2:=3;
                        if (FiveCubes.a[i]=2) and (v=1) then v2:=3;
                        end;

                if v2=0 then
                        begin
                        showmessage('Для применения пива как 1 и 2 необходимо выпадение 1 или 2');
                        exit;
                        end;

                if v<>3 then
                        b:=Game.GoodTargetPlayer(Game.CurrPlayer,TargetPlayer,v)
                else
                        b:=Game.GoodTargetPlayer(Game.CurrPlayer,TargetPlayer,1) or Game.GoodTargetPlayer(Game.CurrPlayer,TargetPlayer,2);

                if b then
                        begin
                        Game.Players[TargetPlayer].Damage(1,1);
                        laMatrixOut;
                        CurrPlayerInfoOut;
                        end else
                        begin
                        Showmessage('Выберите подходящую кубикам цель');
                        exit;
                        end;
                Game.Per8:=2;
                LaSpecOptions.Color:=clLime;
                end;

          if Game.Per8=0 then
                begin
                Game.Players[TargetPlayer].Heal(1);
                laMatrixOut;
                CurrPlayerInfoOut;
                end;
          end;

        end;

        FiveCubes.used[Game.CurrCubeUse]:=3;
        luseCubes[Game.CurrCubeUse].Caption:='Уже использовано';
        luseCubes[Game.CurrCubeUse].Color:=clGreen;
        Game.CurrCubeUse:=-1;
        end;
end;

procedure TForm1.laMatrixOut;
var i,j,prev:integer;
begin
for i:=0 to Game.PlayerCount-1 do
        begin
        laMatrix[i,0].Caption:=PersonNames[Game.Players[i].person];
        laMatrix[i,1].Caption:=IntToStr(Game.Players[i].health)+'/'+IntToStr(Game.Players[i].mhealth);
        laMatrix[i,2].Caption:=IntToStr(Game.Players[i].arrows);
        end;
for i:=Game.PlayerCount to MPC-1 do for j:=0 to 2 do
        begin
        laMatrix[i,j].Color:=clGray;
        laMatrix[i,j].Caption:='';
        end;
for j:=0 to 2 do
        begin
        prev:=Game.CurrPlayer-1;
        if prev<0 then prev:=Game.PlayerCount-1;

        laMatrix[prev,j].Color:=clLime;
        laMatrix[Game.CurrPlayer,j].Color:=clTeal;
        laMatrix[Game.SherifPlayer,j].Color:=clYellow;
        end;
LaBankArrows.Caption:='Количество стрел в банке '+IntToStr(Game.BankArrows);
end;

procedure TForm1.CurrPlayerInfoOut;
begin
Edit1.Text:=PersonNames[Game.Players[Game.CurrPlayer].person];
laCurrPl1.Caption:='Игрок номер '+IntToStr(Game.CurrPlayer+1);
laCurrPl2.Caption:='Количество жизней = '+IntToStr(Game.Players[Game.CurrPlayer].health)+'/'+IntToStr(Game.Players[Game.CurrPlayer].mhealth);
laCurrPl3.Caption:='Количество стрел = '+IntToStr(Game.Players[Game.CurrPlayer].arrows);

//Персонажи с активными свойствами Кит Карсон, Ангельские Глазки, Том Кетчум
if (Game.Players[Game.CurrPlayer].person in [2,8,11]) then
        begin
        LaSpecOptions.Color:=clLime;
        LaSpecOptions.Enabled:=true;
        end else
        begin
        LaSpecOptions.Color:=clGray;
        LaSpecOptions.Enabled:=false;
        end;

LaSpecOptions.Caption:='Специальное свойство: '+PersonInfo[Game.Players[Game.CurrPlayer].person];
end;


procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
var i,j:integer;
begin
FiveCubes.Free;
RandUsed.Free;
for i:=0 to MPC-1 do
        Game.Players[i].Free;
for i:=0 to MPC-1 do for j:=0 to 2 do
        laMatrix[i,j].Free;
Game.Free;

for i:=0 to FCC-1 do
        begin
        imgCubes[i].Free;
        lfixCubes[i].Free;
        end;
end;

procedure TForm1.FormClick(Sender: TObject);
var i:integer;
begin
exit;
for i:=0 to Game.PlayerCount-1 do
        Caption:=Caption+IntToStr(Game.Players[i].person)+' ';
end;


procedure TForm1.SpeedButton3Click(Sender: TObject);
var i:integer;
begin
FiveCubes.throw;
for i:=0 to FCC-1 do
        begin
        if FiveCubes.a[i]<>-1 then
                imgCubes[i].Picture.LoadFromFile('Cubes\'+IntToStr(FiveCubes.a[i])+'.bmp')
        else
                begin
                imgCubes[i].Canvas.Brush.Color:=clWhite;
                imgCubes[i].Canvas.FillRect(Rect(0,0,99,99));
                end;
        end;
SpeedButton4.Enabled:=true;
for i:=0 to FCC-1 do
        lfixCubes[i].Enabled:=true;
laMatrixOut;
CurrPlayerInfoOut;
end;

procedure TForm1.SpeedButton4Click(Sender: TObject);
var i,v:integer;
begin
if FiveCubes.step=0 then
        begin
        showmessage('Сначала необходимо бросить кубики');
        exit;
        end;
FiveCubes.step:=5;
SpeedButton3.Enabled:=false;
for i:=0 to FCC-1 do
        lfixCubes[i].Enabled:=false;

if Game.Players[Game.CurrPlayer].person = 3 then//специальноесвойство
        begin
        v:=1;
        for i:=0 to FCC-1 do
                if FiveCubes.a[i] in [1,2] then
                        v:=0;

        if v=1 then
                begin
                Showmessage('Вы лечитесь на 2 единицы здоровья');
                Game.Players[Game.CurrPlayer].heal(2);
                end;
        end;
end;

procedure TForm1.SpeedButton5Click(Sender: TObject);
var i:integer;
begin
if FiveCubes.step<>5 then
        begin
        showmessage('Сначала необходимо бросить и применить кубики');
        exit;
        end;

if not FiveCubes.CanNextPlayer then
        begin
        showmessage('Сначала необходимо применить все кубики с выстрелами');
        exit;
        end;

Game.Per1:=0;
Game.Per2:=0;
Game.Per11:=0;

Game.CurrPlayer:=Game.CurrPlayer+1;
if Game.CurrPlayer=Game.PlayerCount then Game.CurrPlayer:=0;
for i:=0 to FCC-1 do
        lfixCubes[i].Enabled:=false;

FiveCubes.init;
for i:=0 to FCC-1 do
        begin
        imgCubes[i].Canvas.Brush.Color:=clWhite;
        imgCubes[i].Canvas.FillRect(Rect(0,0,99,99));
        lfixCubes[i].Enabled:=false;
        //luseCubes[i].Enabled:=false;
        lfixCubes[i].Color:=clLime;
        luseCubes[i].Color:=clYellow;
        end;
SpeedButton3.Enabled:=true;

Image1.Hint:=PersonInfo[Game.Players[Game.CurrPlayer].Person];
Image1.Picture.LoadFromFile('Persons\'+IntToStr(Game.Players[Game.CurrPlayer].Person)+'.bmp');
laMatrixOut;
CurrPlayerInfoOut;
end;

procedure TForm1.SBShowRoleClick(Sender: TObject);
begin
ShowMessage('Ваша роль - '+RoleNames[Game.Players[Game.CurrPlayer].role]);
end;

procedure TForm1.SpeedButton2Click(Sender: TObject);
begin
Panel1.Visible:=false;
Panel2.Visible:=false;
Panel3.Visible:=false;
LaBankArrows.Visible:=false;
LaSpecOptions.Visible:=false;
CheckBox1.Visible:=false;
CheckBox2.Visible:=false;
end;



procedure TForm1.Panel4Click(Sender: TObject);
begin
Game.Players[0].Dead;
end;

procedure TForm1.LaSpecOptionsClick(Sender: TObject);
begin
case Game.Players[Game.CurrPlayer].person of
2:begin
  Game.Per2:=1-Game.Per2;
  if Game.Per2=1 then
        LaSpecOptions.Color:=clRed;
  end;

8:begin
   Game.Per8:=1-Game.Per8;
   if Game.Per8=1 then
        LaSpecOptions.Color:=clRed;
  end;

11:begin
   Game.Per11:=1-Game.Per11;
   if Game.Per11=1 then
        LaSpecOptions.Color:=clRed;
   end;
end;

end;

end.
