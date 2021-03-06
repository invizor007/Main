unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, Grids, StdCtrls, Spin, Buttons;

const
  MaxCount=25;
  DiagDist=1.4;

type
  TForm1 = class(TForm)
    DrawGrid1: TDrawGrid;
    SpinEdit1: TSpinEdit;
    SpinEdit2: TSpinEdit;
    Label1: TLabel;
    Label2: TLabel;
    SpeedButton1: TSpeedButton;
    SpeedButton2: TSpeedButton;
    SpeedButton3: TSpeedButton;
    SpeedButton4: TSpeedButton;
    SpeedButton5: TSpeedButton;
    SpeedButton6: TSpeedButton;
    SpeedButton7: TSpeedButton;
    SpinEdit3: TSpinEdit;
    Label3: TLabel;
    procedure SpeedButton1Click(Sender: TObject);
    procedure DrawGrid1MouseDown(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    procedure DrawGrid1DrawCell(Sender: TObject; ACol, ARow: Integer;
      Rect: TRect; State: TGridDrawState);
    procedure FormCreate(Sender: TObject);
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
    procedure SpeedButton2Click(Sender: TObject);
    procedure SpeedButton3Click(Sender: TObject);
    procedure SpeedButton4Click(Sender: TObject);
    procedure SpeedButton5Click(Sender: TObject);
    procedure SpeedButton6Click(Sender: TObject);
    procedure SpeedButton7Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

  TCellInfo=record
  step,g:integer;
  dx,dy:integer;
  stat:extended;
  end;

var
  Form1: TForm1;

  a:array[0..MaxCount-1,0..MaxCount-1] of TCellInfo;
  CurrWidth,CurrHeight,StartCol,StartRow:integer;
  bmp:TBitMap;


procedure WaySearch(StartX,StartY:Integer);

implementation

{$R *.dfm}

procedure TForm1.SpeedButton1Click(Sender: TObject);
begin
DrawGrid1.RowCount:=SpinEdit1.Value;
DrawGrid1.ColCount:=SpinEdit2.Value;
end;

procedure TForm1.DrawGrid1MouseDown(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
var acol,arow:integer;
begin
DrawGrid1.MouseToCell(X,Y,acol,arow);
Caption:=IntToStr(a[acol,arow].step)+' '+IntToStr(a[acol,arow].dx)+' '+IntToStr(a[acol,arow].dy);
end;

procedure TForm1.DrawGrid1DrawCell(Sender: TObject; ACol, ARow: Integer;
  Rect: TRect; State: TGridDrawState);
var ValStr:string;
begin
if a[acol,arow].g=0 then bmp.LoadFromFile('bmp/0.bmp')
else if a[acol,arow].g=1 then bmp.LoadFromFile('bmp/1.bmp');
if a[acol,arow].stat<>100 then
//if 99<>100 then
        begin
        ValStr:=FloatToStr(a[acol,arow].stat);
        bmp.Canvas.TextOut(2,2,ValStr);
        end;
DrawGrid1.Canvas.CopyRect(Rect,bmp.Canvas,Classes.Rect(0,0,39,39));
end;

procedure TForm1.FormCreate(Sender: TObject);
var i,j:integer;
begin
randomize;
bmp:=TBitMap.Create;
bmp.Width:=40;
bmp.Height:=40;
StartCol:=1;StartRow:=1;
for i:=0 to MaxCount-1 do for j:=0 to MaxCount-1 do
        a[i,j].stat:=100;
end;

procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
begin
bmp.Free;
end;

procedure TForm1.SpeedButton2Click(Sender: TObject);
begin
a[DrawGrid1.Col,DrawGrid1.Row].g:=1;
DrawGrid1.Repaint;
end;

procedure TForm1.SpeedButton3Click(Sender: TObject);
begin
a[DrawGrid1.Col,DrawGrid1.Row].g:=0;
DrawGrid1.Repaint;
end;

procedure TForm1.SpeedButton4Click(Sender: TObject);
begin
StartCol:=DrawGrid1.Col;
StartRow:=DrawGrid1.Row;
end;

procedure TForm1.SpeedButton5Click(Sender: TObject);
var i,j:integer;
begin
CurrWidth:=DrawGrid1.ColCount;
CurrHeight:=DrawGrid1.RowCount;
for i:=0 to CurrWidth-1 do for j:=0 to CurrHeight-1 do
        a[i,j].stat:=100;
a[StartCol,StartRow].stat:=0;
WaySearch(StartCol,StartRow);
DrawGrid1.Repaint;
end;

procedure TForm1.SpeedButton6Click(Sender: TObject);
begin
DrawGrid1.GridLineWidth:=1-DrawGrid1.GridLineWidth;
end;

procedure WaySearch(StartX,StartY:Integer);
var x,y,i,j,step:integer;
ax,ay:integer;
added:boolean;
dist:extended;
begin
for i:=0 to CurrHeight-1 do
        for j:=0 to CurrWidth-1 do
                a[i][j].step:=-1;

a[StartX][StartY].Step:=0;
step:=0;
dist:=1;
added:=True;

while added  do
        begin
        added:=false;
        inc(Step);
        for i:=0 to CurrWidth-1 do for j:=0 to CurrHeight-1 do if a[i][j].step=step-1 then
                begin
                for ax:=-1 to 1 do for ay:=-1 to 1 do if abs(ax)+abs(ay)<>0 then
                        begin
                        x:=i+ax;
                        y:=j+ay;

                        if abs(ax)+abs(ay)=2 then dist:=DiagDist;
                        if abs(ax)+abs(ay)=1 then dist:=1;

                        if (x<0) or (y<0) or (x>CurrWidth-1) or (y>CurrHeight-1) then continue;
                        if (a[x][y].g=1) or (a[x,y].stat<a[i,j].stat+dist) then continue;

                        a[x][y].step:=step;
                        a[x][y].dx:=i;
                        a[x][y].dy:=j;
                        a[x,y].stat:=a[i,j].stat+dist;
                        
                        added:=true;
                        end;
                end;
        end;
end;


procedure TForm1.SpeedButton7Click(Sender: TObject);
var i,j,r:integer;
begin
for i:=0 to DrawGrid1.ColCount-1 do for j:=0 to DrawGrid1.RowCount-1 do
        begin
        r:=random(100);
        if r>=SpinEdit1.Value
                then a[i,j].g:=0
                else a[i,j].g:=1;
        end;
DrawGrid1.Repaint;
end;

end.



