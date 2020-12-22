unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, ExtCtrls, Buttons;

const sz=100;

type
  TForm1 = class(TForm)
    Image1: TImage;
    SpeedButton1: TSpeedButton;
    SpeedButton2: TSpeedButton;
    SpeedButton3: TSpeedButton;
    SpeedButton4: TSpeedButton;
    SpeedButton5: TSpeedButton;
    procedure FormCreate(Sender: TObject);
    procedure DrawArr;
    procedure msort(st,fi:integer);
    procedure qsort(st,fi:integer);
    procedure SortStep(tick:cardinal);
    procedure SortPuzyr;
    procedure SortMerge;
    procedure SortQuick;
    procedure SortMinSearch;
    procedure SpeedButton1Click(Sender: TObject);
    procedure SpeedButton2Click(Sender: TObject);
    procedure SpeedButton3Click(Sender: TObject);
    procedure SpeedButton4Click(Sender: TObject);
    procedure SpeedButton5Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  Form1: TForm1;
  arr,arr2:array[0..sz-1]of integer;
  step:integer;

implementation

{$R *.dfm}

procedure PutNumbers;
var i:integer;
begin
for i:=0 to sz-1 do
        arr[i]:=random(80);
end;

procedure TForm1.DrawArr;
var i:integer;
begin
Image1.Canvas.Brush.Color:=clWhite;
Image1.Canvas.FillRect(Rect(0,0,500,500));
Image1.Canvas.Brush.Color:=clRed;
for i:=0 to sz-1 do
        Image1.Canvas.FillRect(Rect(i*5,0,i*5+5,5*arr[i]));
end;

procedure TForm1.SortStep(tick:cardinal);
var tstart:cardinal;
begin
step:=step+1;
if step mod 10 =0 then
        begin
        tstart := GetTickCount;
        repeat
        Application.ProcessMessages;
        until GetTickCount - tstart >= tick;
        DrawArr;
        end;
end;

procedure TForm1.SortPuzyr;
var i,j,temp:integer;
begin
step:=0;
for i:=0 to sz-1 do
        begin
        for j:=i+1 to sz-1 do
		begin
                SortStep(40);
                if arr[i]>arr[j] then
			begin
                        temp:=arr[i];
                        arr[i]:=arr[j];
                        arr[j]:=temp;
			end;
		end;
        end;
showmessage('Готово. Step='+IntToStr(step));
end;

procedure TForm1.SortMinSearch;
var i,j,mini,minv,temp:integer;
begin
step:=0;
for i:=0 to sz-1 do
        begin
        minv:=100;
        mini:=-1;
        for j:=i to sz-1 do
                begin
                SortStep(40);

                if arr[j]<minv then
                        begin
                        mini:=j;
                        minv:=arr[j];
                        end;
                end;
        temp:=arr[i];
        arr[i]:=arr[mini];
        arr[mini]:=temp;
        end;
showmessage('Готово. Step='+IntToStr(step));        
end;

procedure TForm1.msort(st,fi:integer);
var mid,id1,id2,i:integer;
begin
//showmessage(inttostr(st)+' '+inttostr(fi));
if st=fi then exit;

mid:=(st+fi) div 2;
msort(st,mid);
msort(mid+1,fi);

id1:=st;id2:=mid+1;
for i:=st to fi do
        begin
        SortStep(90);

        if id1=mid+1 then
                begin
                arr2[i]:=arr[id2];
                id2:=id2+1;
                end else
        if id2=fi+1 then
                begin
                arr2[i]:=arr[id1];
                id1:=id1+1;
                end else
                begin
                if arr[id1]<arr[id2] then
                        begin
                        arr2[i]:=arr[id1];
                        id1:=id1+1;
                        end else
                        begin
                        arr2[i]:=arr[id2];
                        id2:=id2+1;
                        end;
                end;
        end;

for i:=st to fi do
        begin
        arr[i]:=arr2[i];
        end;
end;

procedure TForm1.qsort(st,fi:integer);
var i,j,tmp,pivot:integer;
begin
i:=st;
j:=fi;
pivot:=fi;

while i<=j do
        begin
        while arr[i]<arr[pivot] do i:=i+1;
        while arr[j]>arr[pivot] do j:=j-1;
        SortStep(160);

        if i<=j then
                begin
                tmp:=arr[i];
                arr[i]:=arr[j];
                arr[j]:=tmp;
                i:=i+1;
                j:=j-1;
                end;
        end;

if st<j then qsort(st,j);
if i<fi then qsort(i,fi);
end;

procedure TForm1.SortMerge;
begin
step:=0;
msort(0,sz-1);
DrawArr;
showmessage('Готово. Step='+IntToStr(step)); 
end;

procedure TForm1.SortQuick;
begin
step:=0;
qsort(0,sz-1);
DrawArr;
showmessage('Готово. Step='+IntToStr(step));
end;

procedure TForm1.FormCreate(Sender: TObject);
begin
randomize;
PutNumbers;
DrawArr;
end;

procedure TForm1.SpeedButton1Click(Sender: TObject);
begin
PutNumbers;
DrawArr;
end;

procedure TForm1.SpeedButton2Click(Sender: TObject);
begin
SortPuzyr;
end;

procedure TForm1.SpeedButton3Click(Sender: TObject);
begin
SortMinSearch;
end;

procedure TForm1.SpeedButton4Click(Sender: TObject);
begin
SortMerge;
end;

procedure TForm1.SpeedButton5Click(Sender: TObject);
begin
SortQuick;
end;

end.
