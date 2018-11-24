unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, StdCtrls,Unit2, ExtCtrls;

type
  TForm1 = class(TForm)
    Shape1: TShape;
    procedure FormCreate(Sender: TObject);
    procedure FormPaint(Sender: TObject);
    procedure FormMouseMove(Sender: TObject; Shift: TShiftState; X,
      Y: Integer);
    procedure Shape1MouseMove(Sender: TObject; Shift: TShiftState; X,
      Y: Integer);
    procedure FormMouseDown(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  Form1: TForm1;

implementation

{$R *.dfm}

procedure TForm1.FormCreate(Sender: TObject);
begin
Form2:=TForm2.Create(Application);
Form2.Show;
Bmp1:=TBitMap.Create;
Bmp1.Width:=1024;Bmp1.Height:=600;
BmpTr:=TBitMap.Create;
BmpTr.Width:=1024;BmpTr.Height:=600;
nach:=true;Enab:=false;
Form2.CheckBox1Click(Form2.Checkbox1);
ti:=0;shag:=0;
with Form2.StringGrid1 do
    begin
    Cells[0,0]:='Perem';
    Cells[0,1]:='Znach';
    Cells[1,0]:='vx 1';
    Cells[2,0]:='vy 2';
    Cells[3,0]:='va 3';
    Cells[4,0]:='vm 4';
    Cells[5,0]:='ax 5';
    Cells[6,0]:='ay 6';
    Cells[7,0]:='aa 7';
    Cells[8,0]:='am 8';
    Cells[9,0]:='x 9';
    Cells[10,0]:='y 10';
    Cells[11,0]:='t 11';
    end;
Form2.BitBtn1Click(Form2.BitBtn1);
end;

procedure TForm1.FormPaint(Sender: TObject);
begin
if nach=true then with Form1.Canvas do
    begin
    Color:=clWhite;
    nach:=false;
    FillRect(Rect(0,0,1023,599)); 
    end;
end;

procedure TForm1.FormMouseMove(Sender: TObject; Shift: TShiftState; X,
  Y: Integer);
begin
CurX:=X;CurY:=Y;
end;

procedure TForm1.Shape1MouseMove(Sender: TObject; Shift: TShiftState; X,
  Y: Integer);
begin
FormMouseMove(Form1,Shift,X+Shape1.Left,Y+Shape1.Top);
end;

procedure TForm1.FormMouseDown(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
var radius:Integer;
begin
if ris=true then begin
Shag:=Shag+1;
ClPoi[shag]:=Point(X,Y);
if shag=Maxim then with Canvas do
    begin
    shag:=0;
    if fig=1 then
        begin
        MoveTo(ClPoi[1].X,ClPoi[1].Y);
        LineTo(ClPoi[2].X,ClPoi[2].Y);
        end;
    if fig=2 then
        Rectangle(ClPoi[1].X,ClPoi[1].Y,ClPoi[2].X,ClPoi[2].Y);
    if fig=3 then
        begin
        radius:=Round(Sqrt(Sqr(ClPoi[2].X-ClPoi[1].X)+Sqr(ClPoi[2].Y-ClPoi[1].Y)));
        Ellipse(ClPoi[1].X-radius,ClPoi[1].Y-radius,ClPoi[1].X+radius,ClPoi[1].Y+radius);
        end;
    if fig=4 then
        Ellipse(ClPoi[1].X,ClPoi[1].Y,ClPoi[2].X,ClPoi[2].Y);
    if fig=5 then
        Pixels[x,y]:=Pen.Color;
    if fig=6 then
        FillRect(Rect(x-1,y-1,x+1,y+1));
    end;end;

end;

end.
