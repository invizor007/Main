unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, ExtCtrls, StdCtrls, Buttons, Spin;

type
  TForm1 = class(TForm)
    Image1: TImage;
    Label1: TLabel;
    RadioGroup1: TRadioGroup;
    SpinEdit1: TSpinEdit;
    procedure FormCreate(Sender: TObject);
    procedure LineKoh(x1,y1,x2,y2,n:integer);
    procedure SnowKoh(x1,y1,x2,y2,n:integer);
    procedure DrawTriangle(x1, y1, x2, y2, x3, y3: Real;i:integer);
    procedure DrawFractal(x1, y1, x2, y2, x3, y3: Real; n: Integer);
    procedure ReDraw;
    procedure SpinEdit1Change(Sender: TObject);
    procedure RadioGroup1Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  Form1: TForm1;

implementation
var iter:integer;
var p1x,p1y,p2x,p2y,p3x,p3y:integer;
fcolor:TColor;

{$R *.dfm}

procedure TForm1.LineKoh(x1,y1,x2,y2,n:integer);
var dx,dy,xp,yp:integer;
begin
if n<=0 then exit;
dx:=x2-x1;
dy:=y2-y1;

Image1.Canvas.Pen.Color:=clWhite;
Image1.Canvas.MoveTo(x1+round(dx/3),y1+round(dy/3));
Image1.Canvas.LineTo(x2-round(dx/3),y2-round(dy/3));

Image1.Canvas.Pen.Color:=clBlack;
xp:=round(x1+dx/3+dx/6+dy*sqrt(3)/6);
yp:=round(y1+dy/3-dx*sqrt(3)/6+dy/6);
Image1.Canvas.MoveTo(x1+round(dx/3),y1+round(dy/3));
Image1.Canvas.LineTo(xp,yp);
Image1.Canvas.LineTo(x2-round(dx/3),y2-round(dy/3));

LineKoh(x1,y1,x1+round(dx/3),y1+round(dy/3),n-1);
LineKoh(x1+round(dx/3),y1+round(dy/3),xp,yp,n-1);
LineKoh(xp,yp,x2-round(dx/3),y2-round(dy/3),n-1);
LineKoh(x2-round(dx/3),y2-round(dy/3),x2,y2,n-1);
end;

procedure TForm1.SnowKoh(x1,y1,x2,y2,n:integer);
var dx,dy,xp,yp:integer;
begin
if n>0 then
        begin
        dx:=x2-x1;
        dy:=y2-y1;
        xp:=round(x1+dx/3+dx/6+dy*sqrt(3)/6);
        yp:=round(y1+dy/3-dx*sqrt(3)/6+dy/6);
        SnowKoh(x1,y1,x1+round(dx/3),y1+round(dy/3),n-1);
        SnowKoh(x1+round(dx/3),y1+round(dy/3),xp,yp,n-1);
        SnowKoh(xp,yp,x2-round(dx/3),y2-round(dy/3),n-1);
        SnowKoh(x2-round(dx/3),y2-round(dy/3),x2,y2,n-1);
        end else
        begin
        Image1.Canvas.MoveTo(x1,y1);
        Image1.Canvas.LineTo(x2,y2);
        end;
end;

procedure TForm1.DrawTriangle(x1, y1, x2, y2, x3, y3: Real;i:integer);
begin
Image1.Canvas.Pen.Color:=fcolor;
Image1.Canvas.MoveTo(Round(x1), Round(y1));
Image1.Canvas.LineTo(Round(x2), Round(y2));
Image1.Canvas.LineTo(Round(x3), Round(y3));
Image1.Canvas.LineTo(Round(x1), Round(y1));
Image1.Canvas.Brush.Color:=fcolor;
Image1.Canvas.FloodFill(round((x1+x2+x3)/3),round((y1+y2+y3)/3),Image1.Canvas.Pen.Color,fsBorder);
end;

procedure TForm1.DrawFractal(x1, y1, x2, y2, x3, y3: Real; n: Integer);
var x1n, y1n, x2n, y2n, x3n, y3n : Real;
begin
if  n > 0  then
        begin
        x1n := (x1 + x2) / 2;
        y1n := (y1 + y2) / 2;
        x2n := (x2 + x3) / 2;
        y2n := (y2 + y3) / 2;
        x3n := (x3 + x1) / 2;
        y3n := (y3 + y1) / 2;
        DrawTriangle(x1n, y1n, x2n, y2n, x3n, y3n,n);

        DrawFractal(x1, y1, x1n, y1n, x3n, y3n, n - 1);
        DrawFractal(x2, y2, x1n, y1n, x2n, y2n, n - 1);
        DrawFractal(x3, y3, x2n, y2n, x3n, y3n, n - 1);
        end;
end;

procedure TForm1.ReDraw;
begin
Image1.Canvas.Brush.Color:=clWhite;
Image1.Canvas.FillRect(Rect(0,0,400,400));
Image1.Canvas.Pen.Color:=clBlack;
if RadioGroup1.ItemIndex = 0 then
        begin
        Image1.Canvas.MoveTo(0,200);
        Image1.Canvas.LineTo(400,200);

        LineKoh(0,200,400,200,iter);
        end else
if RadioGroup1.ItemIndex = 1 then
        begin
        p1x:=100;p1y:=300;
        p2x:=200;p2y:=127;
        p3x:=300;p3y:=300;

        SnowKoh(p1x,p1y,p2x,p2y,iter);
        SnowKoh(p2x,p2y,p3x,p3y,iter);
        SnowKoh(p3x,p3y,p1x,p1y,iter);
        end else
if RadioGroup1.ItemIndex = 2 then
        begin
        fcolor:=clRed;
        DrawTriangle(0,399,399,399,199,53,iter);
        
        fcolor:=clYellow;
        DrawFractal(0,399,399,399,199,53,iter);
        end;
end;

procedure TForm1.FormCreate(Sender: TObject);
begin
iter:=6;
ReDraw;
end;

procedure TForm1.SpinEdit1Change(Sender: TObject);
begin
iter:=SpinEdit1.Value;
ReDraw;
end;

procedure TForm1.RadioGroup1Click(Sender: TObject);
begin
Redraw;
end;

end.

