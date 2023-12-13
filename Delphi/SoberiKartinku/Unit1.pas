unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, ExtCtrls, Buttons, StdCtrls;

const
cutw = 5;
cuth = 5;

type
  TForm1 = class(TForm)
    Image1: TImage;
    SpeedButton1: TSpeedButton;
    SpeedButton2: TSpeedButton;
    SpeedButton3: TSpeedButton;
    SpeedButton4: TSpeedButton;
    SpeedButton5: TSpeedButton;
    SpeedButton6: TSpeedButton;
    procedure SpeedButton1Click(Sender: TObject);
    procedure SpeedButton2Click(Sender: TObject);
    procedure SpeedButton3Click(Sender: TObject);
    procedure FormCreate(Sender: TObject);
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
    procedure Image1DragOver(Sender, Source: TObject; X, Y: Integer;
      State: TDragState; var Accept: Boolean);
    procedure Image1EndDrag(Sender, Target: TObject; X, Y: Integer);
    procedure ImgsEndDrag(Sender, Target: TObject; X, Y: Integer);
    procedure Image1MouseDown(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    procedure FormDragOver(Sender, Source: TObject; X, Y: Integer;
      State: TDragState; var Accept: Boolean);
    procedure SpeedButton4Click(Sender: TObject);
    procedure SpeedButton5Click(Sender: TObject);
    procedure SpeedButton6Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var

Form1: TForm1;
PartsImgs:array[0..cutw-1,0..cuth-1]of TImage;
DragWasX,DragWasY:integer;


implementation

{$R *.dfm}

procedure qq(i:integer);
begin
showmessage(inttostr(i));
end;

procedure TForm1.SpeedButton1Click(Sender: TObject);
var i,j:integer;
begin
Image1.Picture.LoadFromFile('all.bmp');
Image1.Show;
for i:=0 to cutw-1 do for j:=0 to cuth-1 do
        PartsImgs[i,j].Hide;
end;

procedure TForm1.SpeedButton3Click(Sender: TObject);
var i,j:integer;
begin
Image1.Hide;
for i:=0 to cutw-1 do for j:=0 to cuth-1 do
        begin
        PartsImgs[i,j].Width:=200;
        PartsImgs[i,j].Height:=120;
        PartsImgs[i,j].Canvas.CopyRect(Rect(0,0,199,119),Image1.Canvas,Rect(i*200,j*120,i*200+199,j*120+119));
        PartsImgs[i,j].Show;
        end;
end;

procedure TForm1.SpeedButton2Click(Sender: TObject);
var i,j:integer;
begin
Image1.Picture.LoadFromFile('all.bmp');
for i:=0 to cuth-1 do
        begin
        Image1.Canvas.MoveTo(0,i*120);
        Image1.Canvas.LineTo(999,i*120);
        end;
for i:=0 to cutw-1 do
        begin
        Image1.Canvas.MoveTo(i*200,0);
        Image1.Canvas.LineTo(i*200,599);
        end;

Image1.Show;
for i:=0 to cutw-1 do for j:=0 to cuth-1 do
        begin
        PartsImgs[i,j].Hide;
        end;
end;

procedure TForm1.FormCreate(Sender: TObject);
var i,j:integer;
begin
Randomize;
Image1.Picture.LoadFromFile('all.bmp');

Image1.Canvas.Brush.Color:=clWhite;
Image1.Canvas.Pen.Color:=clBlack;
for i:=0 to cutw-1 do for j:=0 to cuth-1 do
        begin
        PartsImgs[i,j]:=TImage.Create(Form1);
        PartsImgs[i,j].Parent:=Form1;
        PartsImgs[i,j].Width:=200;
        PartsImgs[i,j].Height:=120;
        PartsImgs[i,j].Left:=200*i;
        PartsImgs[i,j].Top:=120*j;
        PartsImgs[i,j].Hide;
        PartsImgs[i,j].OnMouseDown:=Image1MouseDown;
        PartsImgs[i,j].OnDragOver:=Image1DragOver;
        PartsImgs[i,j].OnEndDrag:=ImgsEndDrag;
        end;

end;

procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
var i,j:integer;
begin
for i:=0 to cutw-1 do for j:=0 to cuth-1 do
        PartsImgs[i,j].Free;
end;

procedure TForm1.Image1DragOver(Sender, Source: TObject; X, Y: Integer;
  State: TDragState; var Accept: Boolean);
begin
Accept:=true;
Caption:=IntToStr(DragWasX)+'->'+IntToStr(x)+', '+IntToStr(DragWasY)+'->'+IntToStr(y);
end;

procedure TForm1.Image1EndDrag(Sender, Target: TObject; X, Y: Integer);
var newx,newy:integer;
begin
newx:=TImage(Sender).Left+x-DragWasX;
newy:=TImage(Sender).Top+y-DragWasY;

if newx<0 then newx:=0;
if newx>100 then newx:=100;
if newy<0 then newy:=0;
if newy>100 then newy:=100;

TImage(Sender).Left:=newx;
TImage(Sender).Top:=newy;
end;

procedure TForm1.ImgsEndDrag(Sender, Target: TObject; X, Y: Integer);
var newx,newy:integer;
begin
newx:=TImage(Sender).Left+x-DragWasX;
newy:=TImage(Sender).Top+y-DragWasY;
if Target<>Form1 then
        begin
        newx:=newx+TImage(Target).Left;
        newy:=newy+TImage(Target).Top;  //qq(-1);
        end;          //qq(newx);qq(newy);

if newx<0 then newx:=0;
if newx>1000 then newx:=1000;
if newy<0 then newy:=0;
if newy>700 then newy:=700;

TImage(Sender).Left:=newx;
TImage(Sender).Top:=newy;
end;

procedure TForm1.Image1MouseDown(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
begin
DragWasX:=x+TImage(Sender).Left;
DragWasY:=y+TImage(Sender).Top;
if Button = mbLeft then
        TImage(Sender).BeginDrag(True);

end;

procedure TForm1.FormDragOver(Sender, Source: TObject; X, Y: Integer;
  State: TDragState; var Accept: Boolean);
begin
Accept:=true;
Caption:=IntToStr(DragWasX)+'->'+IntToStr(x)+', '+IntToStr(DragWasY)+'->'+IntToStr(y);
end;

procedure TForm1.SpeedButton4Click(Sender: TObject);
var i,j:integer;
begin
for i:=0 to cutw-1 do for j:=0 to cuth-1 do
        begin
        PartsImgs[i,j].Left:=random(900);
        PartsImgs[i,j].Top:=random(580);
        end;
end;

procedure TForm1.SpeedButton5Click(Sender: TObject);
var i,j:integer;
begin
SpeedButton3Click(SpeedButton3);
for i:=0 to cutw-1 do for j:=0 to cuth-1 do
        PartsImgs[i,j].Hide;

PartsImgs[0,0].Show;
Image1.Hide;
end;


procedure TForm1.SpeedButton6Click(Sender: TObject);
var i,j,tmp1,res:integer;
begin
res:=1;
for i:=0 to cutw-2 do for j:=0 to cuth-2 do
        begin
        tmp1:=PartsImgs[i+1,j].Left-PartsImgs[i,j].Left;
        if (tmp1<190)or(tmp1>210) then res:=0;
        end;

for i:=0 to cutw-2 do for j:=0 to cuth-2 do
        begin
        tmp1:=PartsImgs[i,j+1].Top-PartsImgs[i,j].Top;
        if (tmp1<110)or(tmp1>130) then res:=0;
        end;                
if res=1 then
        showmessage('Поздравляю. Вы выиграли')
else
        showmessage('Расставьте пожалуйста куски точнее');
end;



end.
