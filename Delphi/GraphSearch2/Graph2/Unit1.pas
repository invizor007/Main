unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, ExtCtrls, Buttons;

const MaxLen = 10000;
const MaxElem = 100;

type
  TForm1 = class(TForm)
    Image1: TImage;
    SpeedButton1: TSpeedButton;
    SpeedButton2: TSpeedButton;
    procedure FormCreate(Sender: TObject);
    procedure SpeedButton1Click(Sender: TObject);
    procedure SpeedButton2Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

TGraphInfo = record
vc,ec,snum,enum:integer;
ew:array[0..MaxElem-1] of integer;
ev:array[0..MaxElem-1] of TPoint;
weight:array[0..MaxElem-1] of integer;
vopen:array[0..MaxElem-1] of integer;
{vclose,}ag,ah:array[0..MaxElem-1]of integer;//это переменные для алгоритма А*
end;

var
  Form1: TForm1;
  gi:TGraphInfo;
  f:Text;
  fn:string;
  var a:array[0..MaxElem-1,0..MaxElem-1]of integer;

implementation

//алгоритм дейкстры и астар

{$R *.dfm}

procedure TForm1.FormCreate(Sender: TObject);
var i:integer;
begin
assignfile(f,'main.ini');
reset(f);
readln(f,fn);
closefile(f);

Image1.Picture.LoadFromFile(fn+'.bmp');
assignfile(f,fn+'.txt');
reset(f);
readln(f,gi.vc,gi.ec);
for i:=0 to gi.ec-1 do
        readln(f,gi.ev[i].x,gi.ev[i].y,gi.ew[i]);
closefile(f);
gi.snum:=1;gi.enum:=9;
end;

function AlgD(cur:integer):integer;
var i,n,len,lenm,im:integer;
begin
lenm:=MaxLen;
im:=-1;
for i:=0 to gi.ec-1 do
        if (gi.ev[i].x=cur)or(gi.ev[i].y=cur) then//cur - номер текущей вершины
                begin
                n:=gi.ev[i].x+gi.ev[i].y-cur;//номер смежной вершины

                if (gi.vopen[n]=0) then
                        begin
                        len:=gi.weight[cur]+gi.ew[i];
                        gi.weight[n]:=len;//расстояние
                        a[cur,n]:=len;
                        a[n,cur]:=len;
                        if len<lenm then
                                begin
                                lenm:=len;
                                im:=n;
                                end;
                        end;
                end;
if im<>-1 then
        gi.vopen[im]:=1;
result:=im;
end;

procedure AlgAS;//(ind:integer);
var i,j,minv,iminv:integer;
begin
minv:=1000;
iminv:=-1;
for i:=1 to gi.vc do if gi.vopen[i]=1 then
        begin
        for j:=1 to gi.vc do if (gi.vopen[j]=0) and (a[i,j]<MaxLen) then
                begin
                gi.ag[j]:=gi.ag[i]+a[i,j];
                gi.weight[j]:=gi.ag[j]+gi.ah[j];
                gi.vopen[j]:=3;
                if gi.weight[j]<minv then
                        begin
                        minv:=gi.weight[j];
                        iminv:=j;
                        end;
                end;
        end;

if iminv<>-1 then
        gi.vopen[iminv]:=4;

for i:=0 to gi.vc do
        begin
        if gi.vopen[i]=1 then gi.vopen[i]:=2;
        if gi.vopen[i]=3 then gi.vopen[i]:=2;{1;}
        if gi.vopen[i]=4 then gi.vopen[i]:=1;
        end;
end;

function AlgASEnd:boolean;
//var i:integer;
begin
result:=true;
if gi.vopen[gi.enum]<>2 then
        result:=false;
{for i:=1 to gi.vc do
        if gi.vopen[i]<>2 then
                result:=false;
}
end;

procedure TForm1.SpeedButton1Click(Sender: TObject);
var i,j,n:integer;
begin
//Стартовая инициализация для алгоритма Дейкстры
for i:=0 to gi.vc do
        begin
        gi.weight[i]:=MaxLen;
        gi.vopen[i]:=0;
        end;

for i:=0 to gi.vc do
        for j:=0 to gi.vc do
                begin
                a[i,j]:=MaxLen;
                end;

for i:=0 to gi.ec-1 do
        begin
        a[gi.ev[i].X,gi.ev[i].Y]:=gi.ew[i];
        a[gi.ev[i].Y,gi.ev[i].X]:=gi.ew[i];
        end;


gi.vopen[gi.snum]:=1;
gi.weight[gi.snum]:=0;
gi.ag[gi.snum]:=0;
//Сам алгоритм
n:=gi.snum;
repeat
n:=AlgD(n);
until n = -1;

ShowMessage('Длина от '+IntToStr(gi.snum)+' до '+IntToStr(gi.enum)+' равна '+IntToStr(gi.weight[gi.enum]));
end;

procedure TForm1.SpeedButton2Click(Sender: TObject);
var i,j:integer;
begin
//Стартовая инициализация для алгоритма А*
for i:=0 to gi.vc do
        begin
        gi.weight[i]:=MaxLen;
        gi.vopen[i]:=0;
//        gi.vclose[i]:=0;
        end;

for i:=0 to gi.vc do
        begin
        gi.ah[i]:=round(sqrt(abs(9-i))*15);
        gi.weight[i]:=round(sqrt(abs(9-i))*15);
        end;

for i:=0 to gi.vc do
        for j:=0 to gi.vc do
                begin
                a[i,j]:=MaxLen;
                end;

for i:=0 to gi.ec-1 do
        begin
        a[gi.ev[i].X,gi.ev[i].Y]:=gi.ew[i];
        a[gi.ev[i].Y,gi.ev[i].X]:=gi.ew[i];
        end;

gi.vopen[gi.snum]:=1;

repeat
AlgAS;
until AlgASEnd;

ShowMessage('Длина от '+IntToStr(gi.snum)+' до '+IntToStr(gi.enum)+' равна '+IntToStr(gi.weight[gi.enum]));

end;

end.
 