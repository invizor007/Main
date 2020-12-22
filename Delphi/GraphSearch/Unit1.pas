unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, Grids, Buttons, StdCtrls, Spin;

const vcount = 9;

type

TBaseItem = record
id,s:integer;
end;

PBaseItem = ^TBaseItem;

PQu = ^TQu;

TQu = record
id,s:integer;
next:PQu;
end;

PSta = ^TSta;

TSta= record
id,s:integer;
next:PSta;
end;

  TForm1 = class(TForm)
    StringGrid1: TStringGrid;
    SpeedButton1: TSpeedButton;
    SpeedButton2: TSpeedButton;
    SpinEdit1: TSpinEdit;
    SpinEdit2: TSpinEdit;
    Label1: TLabel;
    Label2: TLabel;
    procedure SpeedButton2Click(Sender: TObject);
    procedure FormCreate(Sender: TObject);
    procedure SpeedButton1Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  Form1: TForm1;
  shead:PSta;
  qhead,qtail:PQu;
  a:array[1..vcount,1..vcount] of integer;
  marked:array[1..vcount]of integer;
  r:real;
  s_v,e_v:integer;

implementation

{$R *.dfm}

procedure TForm1.SpeedButton2Click(Sender: TObject);
var i,j:integer;
begin
for i:=1 to vcount do
        for j:=1 to i do
                begin
                if i<>j then
                        begin
                        a[i,j]:=1;//random(vcount)+1;//1
                        if random<0.4 then a[i,j]:=0;
                        StringGrid1.Cells[i,j]:=IntToStr(a[i,j]);
                        a[j,i]:=a[i,j];
                        StringGrid1.Cells[j,i]:=StringGrid1.Cells[i,j];
                        end else
                        begin
                        a[i,j]:=1;//0;
                        StringGrid1.Cells[i,j]:=IntToStr(a[i,j]);
                        a[j,i]:=a[i,j];
                        StringGrid1.Cells[j,i]:=StringGrid1.Cells[i,j];
                        end;
                end;
end;

procedure TForm1.FormCreate(Sender: TObject);
var i:integer;
begin
randomize;
for i:=1 to vcount do
        begin
        StringGrid1.Cells[i,0]:=IntToStr(i);
        StringGrid1.Cells[0,i]:=IntToStr(i);        
        end;
end;

function is_empty_q:boolean;
begin
if qhead=nil then result:=true else result:=false;
end;

function is_empty_s:boolean;
begin
if shead=nil then result:=true else result:=false;
end;

function dequeue:integer;
var temp:pqu;
begin
if not is_empty_q then
        begin
        temp:= qhead;
        qhead:= qhead^.next;
        result:= temp^.id;
        dispose(temp);
        end else result:= -1;
end;

procedure enqueue(thisid:integer);
var temp:PQu;
begin
New(temp);
temp^.id:= thisid;
temp^.s:= 0;
temp^.next:= nil;
if is_empty_q then
        begin
        qhead:=temp;
        qtail:=temp;
        end else
        begin
        qtail^.next:=temp;
        qtail:=temp;
        end;
end;

procedure Push(id:integer);
var temp: PSta;
begin
New(temp);
temp^.id:= id;
temp^.next:= nil;
if (is_empty_s) then
        shead:= temp
else
        begin
        temp^.next:= shead;
        shead:= temp;
        end;
end;

function Pop:integer;
var temp: PSta;
begin
if not is_empty_s then
        begin
        temp:= shead;
        shead:= shead^.next;
        result:= temp^.id;
        Dispose(temp);
        end else
        result:= 0;
end;

function BFS:boolean;
var curr:integer;
i:integer;
begin
enqueue(s_v);
while not is_empty_q do
        begin
        curr:=dequeue;

        if curr=e_v then
                begin
                BFS:=true;
                exit;
                end;

        marked[curr]:=1;

        for i:=1 to vcount do
                if (curr<>i) and (a[i,curr]>=1) then
                        if marked[i]=0 then
                                enqueue(i);
        end;
BFS:=false;
end;

function DFS(v:integer;depth:integer):boolean;
var i:integer;
begin
marked[v]:=1;
if v=e_v then
        begin
        DFS:=true;
        exit;
        end;

for i:=1 to vcount do
        if (v<>i)and(a[i,v]>0)and(marked[i]=0) then
                if DFS(i,depth+1) then
                        begin
                        DFS:=true;
                        exit;
                        end;

DFS:=false;
end;

procedure TForm1.SpeedButton1Click(Sender: TObject);
var i,j:integer;
begin
s_v:=SpinEdit1.Value;
e_v:=SpinEdit2.Value;

for i:=1 to vcount do
        for j:=1 to vcount do
                a[i,j]:=StrToInt(StringGrid1.Cells[i,j]);


//BFS - в ширину - очередь
showmessage('Поиск в ширину');
qhead:=nil;qtail:=nil;
for i:=1 to vcount do marked[i]:=0;
if BFS then showmessage('Есть путь') else showmessage('Нет пути');
while not is_empty_q do dequeue;
qhead:=nil;qtail:=nil;

showmessage('Поиск в глубину');
shead:= nil;
for i:=1 to vcount do marked[i]:=0;
if DFS(s_v,0) then showmessage('Есть путь') else showmessage('Нет пути');
while not is_empty_s do Pop;
shead:= nil;
end;

end.
