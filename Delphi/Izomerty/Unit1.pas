unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, ExtDlgs, ExtCtrls, Buttons, StdCtrls;

type
  TForm1 = class(TForm)
    Image1: TImage;
    ImageL: TImage;
    ImageR: TImage;
    ImageUp: TImage;
    ImageDown: TImage;
    SpeedButton1: TSpeedButton;
    SpeedButton2: TSpeedButton;
    SpeedButton3: TSpeedButton;
    Label1: TLabel;
    SpeedButton4: TSpeedButton;
    SpeedButton5: TSpeedButton;
    SpeedButton6: TSpeedButton;
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
    procedure FormCreate(Sender: TObject);
    procedure Draw;
    procedure OutSprite(col,row:integer);
    procedure ChooseImage(i:integer);
    procedure OutGrid;
    procedure OutCellNum;
    procedure DrawVector(c:TCanvas;x0,y0,dx,dy:integer);
    procedure ImageUpClick(Sender: TObject);
    procedure ImageDownClick(Sender: TObject);
    procedure Image1MouseDown(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    procedure SpeedButton4Click(Sender: TObject);
    procedure SpeedButton5Click(Sender: TObject);
    procedure SpeedButton6Click(Sender: TObject);
    procedure ImageRClick(Sender: TObject);
    procedure ImageLClick(Sender: TObject);
    procedure Image1MouseMove(Sender: TObject; Shift: TShiftState; X,
      Y: Integer);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  Form1: TForm1;

implementation
const SpriteH=256;
SpriteW=128;
Inf:array[-1..9]of string=('пусто','здание №0','здание №1','здание №2','здание №3',
'здание №4','здание №5','здание №6','здание №7','здание №8','здание №9');
type TRGBArray=array[0..500]of TRGBTriple;
var m_fon,m_curr:TBitmap;
l_fon,l_curr:^TRGBArray;
Map:array[-3..3,-3..3]of integer;
Building:integer;
dBuild:integer;
getx,gety:integer;

{$R *.dfm}

procedure TForm1.DrawVector(c:TCanvas;x0,y0,dx,dy:integer);
var a:array[0..3] of extended;
b:array[0..2]of extended;
i,j:integer;
temp:extended;
begin
a[0]:=(400-x0)/dx;
a[1]:=(-x0)/dx;
a[2]:=(400-y0)/dy;
a[3]:=(-y0)/dy;
for i:=0 to 3 do for j:=i+1 to 3 do
  if a[i]>a[j] then
    begin
    temp:=a[i];
    a[i]:=a[j];
    a[j]:=temp;
    end;
for i:=0 to 2 do
  begin
  b[i]:=(a[i]+a[i+1])/2;
  if (x0+b[i]*dx>=0)and(x0+b[i]*dx<400)and(y0+b[i]*dy>=0)and(y0+b[i]*dy<400) then
    begin
    c.MoveTo(round(x0+a[i]*dx),round(y0+a[i]*dy));
    c.LineTo(round(x0+a[i+1]*dx),round(y0+a[i+1]*dy));    
    end;
  end;
end;

procedure TForm1.OutGrid;
var i:integer;
begin    
for i:=-4 to 4 do 
  begin
  DrawVector(m_fon.Canvas,200+100*i,200,100,50);
  DrawVector(m_fon.Canvas,200+100*i,200,100,-50);
  end;

end;

procedure TForm1.Draw;
var i,j:integer;
begin
m_fon.LoadFromFile('BitMaps\land.bmp');
OutCellNum;
OutGrid;

for i:=3 downto -3 do for j:=-3 to 3 do if abs(i)+abs(j)<8 then
  begin
  //ChooseImage(random(7)+1);
  OutSprite(j,i);
  end;

//ChooseImage(2);
//OutSprite(2,1);
Image1.Canvas.Draw(0,0,m_fon);
end;

procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
begin
m_fon.Free;
m_curr.Free;
end;

procedure TForm1.FormCreate(Sender: TObject);
var i,j:integer;
//x,y:integer;
begin
for i:=-3 to 3 do for j:=-3 to 3 do
  map[i,j]:=-1;
randomize;                           
m_fon:=TBitMap.Create;
m_fon.Width:=ClientWidth;
m_fon.Height:=ClientHeight;

m_curr:=TBitMap.Create;
m_curr.Width:=SpriteW;
m_curr.Height:=SpriteH;
Draw;

ImageUp.Picture.Bitmap.LoadFromFile('Scroll\up.bmp');
ImageDown.Picture.Bitmap.LoadFromFile('Scroll\down.bmp');

ImageL.Picture.Bitmap.LoadFromFile('BitMaps\0'+IntToStr(dBuild)+'.bmp');
ImageR.Picture.Bitmap.LoadFromFile('BitMaps\0'+IntToStr(dBuild+1)+'.bmp');
end;

procedure TForm1.ChooseImage(i:integer);
begin
m_curr.LoadFromFile('BitMaps\'+IntToStr(i div 10)+IntToStr(i mod 10)+'.bmp');
end;

procedure TForm1.OutSprite(col,row:integer);
var dx,dy,i,j:integer;
begin
if Map[col,row]=-1 then exit;
ChooseImage(Map[col,row]);          
dx:=(col+row)*50-64+200;
dy:=(col-row)*25-256+200;

for i:=0 to SpriteH-1 do if (i+dy<400)and(i+dy>=0) then
  begin
  l_fon:=m_fon.ScanLine[i+dy];
  l_curr:=m_curr.ScanLine[i];

  for j:=0 to 128-1 do if (j+dx<400)and(j+dx>=0) then
    begin
    if (l_curr[j].rgbtBlue<>255)or(l_curr[j].rgbtGreen<>255)or(l_curr[j].rgbtRed<>255) then
      begin
      l_fon[j+dx]:=l_curr[j];
      end;
    end;
  end;

end;

procedure TForm1.OutCellNum;
var dx,dy,i,j:integer;//col-j row-i
s:string;
begin
m_fon.Canvas.Font.Color:=clRed;
m_fon.Canvas.Font.Size:=8;
for i:=-3 to 3 do for j:=-3 to 3 do if abs(i)+abs(j)<8 then
  begin
  dx:=(j+i)*50+200-10;
  dy:=(j-i)*25+200-30;
  s:=IntToStr(i)+','+IntToStr(j);
  m_fon.Canvas.TextOut(dx,dy,s);
  end;
end;

procedure TForm1.ImageUpClick(Sender: TObject);
begin
if dBuild>0 then
  begin
  dBuild:=dBuild-2;
  ImageL.Picture.Bitmap.LoadFromFile('BitMaps\0'+IntToStr(dBuild)+'.bmp');
  ImageR.Picture.Bitmap.LoadFromFile('BitMaps\0'+IntToStr(dBuild+1)+'.bmp');
  end;
end;

procedure TForm1.ImageDownClick(Sender: TObject);
begin
if dBuild<8 then
  begin
  dBuild:=dBuild+2;
  ImageL.Picture.Bitmap.LoadFromFile('BitMaps\0'+IntToStr(dBuild)+'.bmp');
  ImageR.Picture.Bitmap.LoadFromFile('BitMaps\0'+IntToStr(dBuild+1)+'.bmp');
  end;
end;

procedure select_cell(x,y:integer);
var flx,fly:extended;
begin
x:=x-200;y:=y-200;
flx:=(x+2*y)/(sqrt(5)*50);
fly:=(x-2*y)/(sqrt(5)*50);
getx:=round(flx-0.5)+1;
gety:=round(fly-0.5);

showmessage(floattostr(getx)+'  '+floattostr(gety));
end;

procedure TForm1.Image1MouseDown(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
begin
if SpeedButton3.Down then
  begin
  select_cell(x,y);
  Label1.Caption:=Inf[map[getX,getY]];
  end;
if SpeedButton1.Down then
  begin
  select_cell(x,y);
  map[getX,getY]:=Building;
  Draw;
  end;
if SpeedButton2.Down then
  begin
  select_cell(x,y);
  map[getX,getY]:=-1;
  Draw;
  end;
end;

procedure TForm1.SpeedButton4Click(Sender: TObject);
var i,j:integer;
begin
for i:=-3 to 3 do for j:=-3 to 3 do
  Map[i,j]:=Building;
Draw;
end;

procedure TForm1.SpeedButton5Click(Sender: TObject);
var i,j:integer;
begin
for i:=-3 to 3 do for j:=-3 to 3 do
  Map[i,j]:=-1;
Draw;
end;

procedure TForm1.SpeedButton6Click(Sender: TObject);
var i,j:integer;
begin
for i:=-3 to 3 do for j:=-3 to 3 do
  Map[i,j]:=random(11)-1;
Draw;
end;

procedure TForm1.ImageRClick(Sender: TObject);
begin
Building:=dBuild+1;
end;

procedure TForm1.ImageLClick(Sender: TObject);
begin
Building:=dBuild;
end;

procedure TForm1.Image1MouseMove(Sender: TObject; Shift: TShiftState; X,
  Y: Integer);
begin
Caption:=IntToStr(X)+' '+IntToStr(Y);
end;

end.
