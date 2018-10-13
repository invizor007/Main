unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, Buttons, Grids, ValEdit, StdCtrls, Math, Spin;

const
CamelC=5; CellC=20; CellFinish=16;
C_Fact: array [0..CamelC-1] of integer =   (1, 2,  6, 24, 120);
C_InPow: array [0.. CamelC-1] of integer = (3, 9, 27, 81, 243);
C_FirstChar:string = 'СЖЗКБ';

type
  TForm1 = class(TForm)
    Main_SB1: TSpeedButton;
    Main_VLE: TValueListEditor;
    Main_DG: TDrawGrid;
    Main_La1: TLabel;
    Main_SB2: TSpeedButton;
    CamSet_GB: TGroupBox;
    CamSet_Sb3: TSpeedButton;
    CamSet_Sb1: TSpeedButton;
    CamSet_Sb2: TSpeedButton;
    CamSet_La1: TLabel;
    CamSet_La2: TLabel;
    CamSet_Cb1: TComboBox;
    CamSet_SE1: TSpinEdit;
    OaSet_GB: TGroupBox;
    OaSet_La1: TLabel;
    OaSet_SE1: TSpinEdit;
    OaSet_SB1: TSpeedButton;
    OaSet_SB2: TSpeedButton;
    OaSet_SB3: TSpeedButton;
    Forec_GB: TGroupBox;
    Forec_SB1: TSpeedButton;
    Forec_SG: TStringGrid;
    SpeedButton1: TSpeedButton;
    CheatThr_GB: TGroupBox;
    CheatThr_SB1: TSpeedButton;
    CheatThr_SE1: TSpinEdit;
    CheatThr_La1: TLabel;
    CheatThr_CB1: TComboBox;
    procedure FormCreate(Sender: TObject);
    //Новые дополнительные процедуры к форме
    procedure OutInf_VLE;
    procedure FormClick(Sender: TObject);
    procedure Main_SB1Click(Sender: TObject);
    procedure Main_DGDrawCell(Sender: TObject; ACol, ARow: Integer;
      Rect: TRect; State: TGridDrawState);
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
    procedure Main_SB2Click(Sender: TObject);
    procedure Forec_SB1Click(Sender: TObject);
    procedure CamSet_Sb3Click(Sender: TObject);
    procedure OaSet_SB3Click(Sender: TObject);
    procedure SpeedButton1Click(Sender: TObject);
    procedure CheatThr_SB1Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

//Другие типы
TCamel = record
x,y,throwed,moving,order:integer;
color:TColor;
end;

TCell = record
num, oasis, camelsIn:integer;
end;

TSyst = record
Camels:array[0..CamelC] of TCamel;//Верблюды
Cells:array[0..CellC] of TCell;//Ячейки
PartyN:integer;//Номер партии
ThrowedN:integer;//Брошенные кубики
end;
//1*2*3*4*5 - порядок выскакивания верблюдов как получить порядок записанный одним числом
//у нас будет двумерный массив вместо десятимерного - порядок верблюдов x! + выпадающие числа 3^x
//790/5 - номер первой цифры, далее остаток делим на 4 и т.д.
TCamelCalc = record
Num, Value:integer;
end;

var
  Form1: TForm1;
//Другие переменные
Systs:array[0..1] of TSyst;
Bmp:TBitMap;
f:text;

CamelCalcC:integer;
CamelCalc:array[0..CamelC-1] of TCamelCalc;//Последовательность ходов верблюдов, формируемая для вычислений
CamelCalcRes:array[0..CamelC-1,1..CamelC] of integer;//Количество таких случаев что верблюд номер i займет место номер j
GameEnd:boolean;

//Процедуры и функции
procedure SystIni(id_syst:integer);
procedure MakeCamelOrder(id_syst:integer);
procedure CamelMove(id_syst,r,rc:integer);
function Cell_21(col,row:integer):integer;
function Cell_12(num:integer):TPoint;

procedure MakeCamelCalc(count, num, value:integer);
procedure MakeCamelCalcRes;

implementation

{$R *.dfm}

procedure qq(i:integer);
begin
ShowMessage(IntToStr(i));
end;

procedure SystIni(id_syst:integer);
var i,r:integer;
begin
for i:=0 to CamelC-1 do
        begin
        systs[id_syst].Camels[i].x:=0;
        systs[id_syst].Camels[i].y:=i;
        end;
systs[id_syst].Camels[0].color:=clBlue;
systs[id_syst].Camels[1].color:=clYellow;
systs[id_syst].Camels[2].color:=clGreen;
systs[id_syst].Camels[3].color:=clRed;
systs[id_syst].Camels[4].color:=clWhite;

//Первоначальное присвоение
for i:=0 to CamelC-1 do
        begin
        r:=1+random(3);//от 1 до 3
        systs[id_syst].Camels[i].x:=r;
        systs[id_syst].Camels[i].y:=systs[0].Cells[r].CamelsIn;
        systs[id_syst].Cells[r].CamelsIn:=systs[0].Cells[r].CamelsIn+1;
        end;
end;

procedure TForm1.FormCreate(Sender: TObject);
begin
Randomize;
Bmp:=TBitMap.Create;Bmp.Width:=80;Bmp.Height:=80;
SystIni(0);
OutInf_VLE;
end;

procedure TForm1.OutInf_VLE;
var i:integer;
begin
for i:=0 to 4 do
        begin
        Main_VLE.Cells[1,i+1]:='x='+IntToStr(systs[0].Camels[i].x) +
                '; y=' + IntToStr(systs[0].Camels[i].y) +
                '; thw=' + IntToStr(systs[0].Camels[i].throwed)+
                '; ord=' + IntToStr(systs[0].Camels[i].order);
        end;
end;

procedure TForm1.FormClick(Sender: TObject);
begin
MakeCamelOrder(0);
OutInf_VLE;
//MakeCamelCalc(5, 76, 76);
//qq(round(Math.IntPower(2,3)));
end;

//Процедура записывает в массив CamelCalc значения согласно параметрам
procedure MakeCamelCalc(count, num, value:integer);
var i,temp:integer;
begin
//Закодированный номер
temp:=num;
for i:=0 to count-1 do
        begin
        CamelCalc[i].Num:=temp div C_Fact[count-1-i];//Это относительный номер далее надо отсчитывать
        //незанятые слоты и можно сразу им же проставлять валуе, можно 2 цикла слить
        temp:=temp mod C_Fact[count-1-i];//вообще мы считаем что сюда записывается номер кубика
        end;//среди невыпавших минус 1, его мы будет использовать потом
CamelCalc[count].Num:=temp;
//Закодированное значение
temp:=value;
for i:=0 to count-1 do
        begin
        CamelCalc[i].Value:= temp div C_InPow[count-1-i];
        temp:=temp mod C_InPow[count-1-i];
        end;
CamelCalc[count].Value:=temp;
end;

//Как раз та комплексная процедура которая будет расчитывать вероятности мест верблюдов
procedure MakeCamelCalcRes;
var i,j,k,l,co,move_r,move_rc:integer;
begin
//assignfile(f,'CamelDebug1.txt');
//rewrite(f);
for i:=0 to CamelC-1 do
        for j:=1 to CamelC do
                CamelCalcRes[i,j]:=0;
co:=CamelC - systs[0].ThrowedN-1;

for i:=0 to C_Fact[co]-1 do
        for j:=0 to C_InPow[co]-1 do
                begin
                systs[1]:=systs[0];//Система 1- тестовая, над ней мы будет потешаться, Система 0 - боевая
                MakeCamelCalc(co,i,j);
                //Делаем "co" перемещений верблюдов в нужной последовательности
                for k:=0 to co do
                        begin
                        //Определяем какой верблюд ходит с помощью нехитрой расшифровки
                        move_rc:=0;l:=-1;
                        while (l<CamelCalc[k].Num) do
                                begin
                                if systs[1].Camels[move_rc].throwed=0 then
                                        l:=l+1;
                                move_rc:=move_rc+1;
                                end;
                        move_rc:=move_rc-1;
                        //А то насколько он походит нам известно из заполненного массива CamelCalc
                        move_r:=CamelCalc[k].Value+1;
                        CamelMove(1,move_r,move_rc);
                        //вместо
{                        writeln(f,'i=',i,' j=',j,' k=',k,
                                ' move_r=',move_r,
//                                ' CamelCalc[k].Num=',CamelCalc[k].Num,
                                ' move_rc=',move_rc);}
                        end;
                //Теперь распределяем верблюдов по местам
                MakeCamelOrder(1);
                for k:=0 to CamelC-1 do
                        CamelCalcRes[k,systs[1].Camels[k].order]:=CamelCalcRes[k,systs[1].Camels[k].order]+1;
                end;

//for i:=0 to CamelC-1 do
//        for j:=1 to CamelC do пока выводит первое место
//                writeln(f,100.0*CamelCalcRes[i,1]/C_Fact[co]/C_InPow[co]:4:4);
//closefile(f);
end;

procedure CamelMove(id_syst,r,rc:integer);
var i,co,oa,ypc:integer;
begin
systs[id_syst].Camels[rc].throwed:=r;
systs[id_syst].Camels[rc].moving:=1;
systs[id_syst].ThrowedN:=systs[id_syst].ThrowedN+1;
//Смотрим модификатор оазис \ пустыня на клетке на которую хотят перейти верблюды
oa:=systs[id_syst].Cells[systs[id_syst].Camels[rc].x+r].oasis;
//1 - если оазис то просто перемещаем нашего верблюда и того кто выше на одну клетку дальше
//-1 тогда верблюды которые перемещаются идут с более ранними y, а те кто уже находится на клетке выше их

//Важное - инициализируем переменную moving. Аксиома - на оазисе и пустыне никто не может стоять
ypc:=0;
if oa=-1 then//Случай пустыни- определяем кто находится на клетке куда хотят перейти верблюды
        for i:=0 to CamelC-1 do
                if systs[id_syst].Camels[i].x = systs[id_syst].Camels[rc].x+r-1 then
                        begin
                        systs[id_syst].Camels[i].moving:=systs[id_syst].Camels[i].y+10;
                        //ypc:=ypc+1;
                        end;

//Определение верблюдов которые находятся на нашем
co:=1;
for i:=0 to CamelC-1 do
        if (systs[id_syst].Camels[i].x = systs[id_syst].Camels[rc].x) and (systs[id_syst].Camels[i].y>systs[id_syst].Camels[rc].y) then
                begin
                systs[id_syst].Camels[i].moving := systs[id_syst].Camels[i].y-systs[id_syst].Camels[rc].y+1;//1 для нашего верблюда, 2,3... для того кто стоит на нем
                co:=co+1;//а 0 для всех остальных и если есть пустыня то 10+ если верблюды стоят на месте до пустыни
                end;

//В итоге мы убираем наших верблюдов
systs[id_syst].Cells[systs[id_syst].Camels[rc].x].camelsIn:=systs[id_syst].Cells[systs[id_syst].Camels[rc].x].camelsIn-co;
for i:=0 to CamelC-1 do
        if (systs[id_syst].Camels[i].moving>0) and (systs[id_syst].Camels[i].moving<10) then
                begin
                ypc:=ypc+1;
                systs[id_syst].Camels[i].x:=systs[id_syst].Camels[i].x+r+oa;//max(oa,0); 01012017 - было ранее
                if systs[id_syst].Camels[i].x>=CellFinish then GameEnd:=true;//Проверка на окончание игры
                if oa = -1 then systs[id_syst].Camels[i].y:=systs[id_syst].Camels[i].moving-1
                else systs[id_syst].Camels[i].y:=systs[id_syst].Cells[systs[id_syst].Camels[i].x].camelsIn+systs[id_syst].Camels[i].moving - 1;
                end;
for i:=0 to CamelC-1 do
        if (systs[id_syst].Camels[i].moving>=10) then
                begin
                systs[id_syst].Camels[i].y:=(systs[id_syst].Camels[i].moving-10)+ypc;
                end;
//Верблюдов переместили и теперь делаем окончательные присвоения переменных
systs[id_syst].Cells[systs[id_syst].Camels[rc].x].camelsIn:=systs[id_syst].Cells[systs[id_syst].Camels[rc].x].camelsIn+co;
for i:=0 to CamelC-1 do
        systs[id_syst].Camels[i].moving:=0;

if GameEnd=true then ShowMessage('Игра завершена');
end;

procedure TForm1.Main_SB1Click(Sender: TObject);
var r,rc:integer;
begin
if systs[0].ThrowedN = CamelC then exit;

repeat
rc:=random(CamelC);//Случайный кубик - до тех пор пока не выпал новый
until systs[0].Camels[rc].throwed = 0;
r:=random(3)+1;//Случайное значение на кубике
Main_La1.Caption:= 'Число = '+inttostr(r)+'; верблюд № '+inttostr(rc+1);

CamelMove(0,r,rc);
MakeCamelOrder(0);
OutInf_VLE;
Main_DG.Repaint;
end;

function Cell_21(col,row:integer):integer;
begin
if (row=0) and (col>=0) and (col<=4) then result:=col
else if (col=4) and(row>=0) and (row<=4) then result:=4+row
else if (row=4) and (col>=0) and (col<=4) then result:=12-col
else if (col=0) and (row>=0) and (row<=4) then result:=16-row
else result:=-1;
end;

function Cell_12(num:integer):TPoint;
begin
if (num>=0) and (num<4) then
        begin result.x:=num;result.y:=0; end
else if (num>=4) and (num<8) then
        begin result.x:=4;result.y:=num-4; end
else if (num>=8) and (num<12) then
        begin result.x:=12-num;result.y:=4; end
else if (num>=12) and (num<16) then
        begin result.x:=0;result.y:=16-num; end
else
        begin result.x:=-1;result.y:=-1; end;
end;

//Эта процедура распределяет верблюдов по местам то есть записывает в переменную order
procedure MakeCamelOrder(id_syst:integer);
var i,j,va,iva:integer;
begin
iva:=0;
for i:=0 to CamelC-1 do
        systs[id_syst].Camels[i].order:=0;

for i:=CamelC downto 1 do
        begin
        va:=10000;
        for j:=0 to CamelC-1 do
                if systs[id_syst].Camels[j].order=0 then
                        if systs[id_syst].Camels[j].x*10+systs[id_syst].Camels[j].y<va then
                                begin
                                va:=systs[id_syst].Camels[j].x*10+systs[id_syst].Camels[j].y;
                                iva:=j;
                                end;
        systs[id_syst].Camels[iva].order:=i;
        end;
end;

procedure TForm1.Main_DGDrawCell(Sender: TObject; ACol, ARow: Integer;
  Rect: TRect; State: TGridDrawState);
var i:integer;
begin
if (ACol>=1) and (ACol<=3) and (ARow>=1) and (ARow<=3) then
        begin
        Bmp.Canvas.Brush.Color:=clGray;
        Bmp.Canvas.FillRect(Classes.Rect(0,0,79,79));
        end
else
        begin
        Bmp.Canvas.Brush.Color:=clLime;
        Bmp.Canvas.FillRect(Classes.Rect(0,0,79,79));
        //Пока сделаю ка я вывод чисел сюда
        Bmp.Canvas.TextOut(30,30, IntToStr(Cell_21(acol,arow)) );
        //Теперь самое главное - размещение верблюдов
        for i:=0 to CamelC-1 do
                if systs[0].Camels[i].x=Cell_21(acol,arow) then
                        begin
                        Bmp.Canvas.Brush.Color:=systs[0].Camels[i].Color;
                        Bmp.Canvas.FillRect(Classes.Rect(20,60-10*systs[0].Camels[i].y,60,70-10*systs[0].Camels[i].y));
                        end;
        if systs[0].Cells[Cell_21(acol,arow)].oasis = 1 then
                begin
                Bmp.Canvas.TextOut(65,3,'+1');
                end;
        if systs[0].Cells[Cell_21(acol,arow)].oasis = -1 then
                begin
                Bmp.Canvas.TextOut(65,3,'-1');
                end;
        end;

Main_DG.Canvas.Draw(Rect.Left,Rect.Top,Bmp);
end;

procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
begin
Bmp.Free;
end;

procedure TForm1.Main_SB2Click(Sender: TObject);
var i:integer;
begin
if systs[0].ThrowedN<>5 then
        begin showmessage('Не все верблюды походили'); exit; end;
systs[0].PartyN:=systs[0].PartyN+1;
systs[0].ThrowedN:=0;
for i:=0 to CamelC-1 do
        begin
        systs[0].Camels[i].throwed:=0;
        end;
end;

procedure TForm1.Forec_SB1Click(Sender: TObject);
var i,j,co:integer;
begin
MakeCamelCalcRes;
co:=CamelC - systs[0].ThrowedN-1;
for i:=1 to CamelC do
        Forec_SG.Cells[0,i]:=IntToStr(i);
for i:=1 to CamelC do
        Forec_SG.Cells[i,0]:=C_FirstChar[i];

for i:=0 to CamelC-1 do
        for j:=1 to CamelC do
                Forec_SG.Cells[i+1,j]:=FloatToStr
                        (Round(10000*CamelCalcRes[i,j]/C_Fact[co]/C_InPow[co])/100 );
end;

procedure TForm1.CamSet_Sb3Click(Sender: TObject);
var val,opt,num:integer;
i:integer;
begin//Сначала устанавливаем основные переменные
val:=CamSet_Se1.Value;//Номер клетки куда следует переместить верблюда
if CamSet_Sb1.Down then opt:=1 else opt:=0;//1 Это значит наверх, 0 это значит вниз
num:=CamSet_Cb1.ItemIndex;//Номер верблюда которого мы перемещаем

//Убираем нашего верблюда с того места на котором он стоял, указанные действия производим с боевой системой
for i:=0 to CamelC-1 do
        if (i<>num) and (systs[0].Camels[i].x = systs[0].Camels[num].x) and (systs[0].Camels[i].y >= systs[0].Camels[num].y) then
                systs[0].Camels[i].y:=systs[0].Camels[i].y-1;

systs[0].Cells[systs[0].Camels[num].x].camelsIn:=systs[0].Cells[systs[0].Camels[num].x].camelsIn-1;
//Ставим его на нужное место
systs[0].Camels[num].x:=val;
if opt = 1 then
        systs[0].Camels[num].y:=systs[0].Cells[val].camelsIn
else
        begin
        for i:=0 to CamelC-1 do
                if (i<>num) and (systs[0].Camels[i].x = systs[0].Camels[num].x) then
                        systs[0].Camels[i].y:=systs[0].Camels[i].y+1;
        systs[0].Camels[num].y:=0;
        end;
systs[0].Cells[val].camelsIn:=systs[0].Cells[val].camelsIn+1;
OutInf_VLE;
Main_DG.Repaint;
end;

procedure TForm1.OaSet_SB3Click(Sender: TObject);
var place,tip:integer;
begin
place:=OaSet_SE1.Value;
if OaSet_SB1.Down then tip:=1 else tip:=-1;
systs[0].Cells[place].oasis:=tip;
Main_DG.Repaint;
end;

procedure TForm1.SpeedButton1Click(Sender: TObject);
var i:integer;
begin
for i:=0 to CellC-1 do
        begin
        systs[0].Cells[i].oasis:=0;
        end;
Main_DG.Repaint;
end;

procedure TForm1.CheatThr_SB1Click(Sender: TObject);
begin
if (CheatThr_SE1.Value<1) or (CheatThr_SE1.Value>3) then exit;
if CheatThr_CB1.ItemIndex = -1 then exit;
CamelMove(0,CheatThr_SE1.Value,CheatThr_CB1.ItemIndex);
OutInf_VLE;
Main_DG.Repaint;
end;

end.
//Далее
//Деньги
//Все таки последовательность ходов
//Проверка окончания
//Выводить информацию о том какие кубики уже выпали
