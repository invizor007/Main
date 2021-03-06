unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, ExtCtrls,Math;

type
  TForm1 = class(TForm)
    Shape1: TShape;
    Timer1: TTimer;
    Shape2: TShape;
    procedure FormCreate(Sender: TObject);
    procedure Timer1Timer(Sender: TObject);
    procedure FormMouseDown(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    procedure FormShow(Sender: TObject);
    procedure Shape1MouseDown(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    procedure Shape1DragOver(Sender, Source: TObject; X, Y: Integer;
      State: TDragState; var Accept: Boolean);
    procedure FormDragOver(Sender, Source: TObject; X, Y: Integer;
      State: TDragState; var Accept: Boolean);
    procedure Shape2DragOver(Sender, Source: TObject; X, Y: Integer;
      State: TDragState; var Accept: Boolean);
    procedure Shape2MouseDown(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
var
  Form1: TForm1;

implementation
uses Unit2;
{$R *.dfm}

procedure TForm1.FormCreate(Sender: TObject);
begin
am:=0;
end;

procedure TForm1.Timer1Timer(Sender: TObject);
begin
t:=t+1;
Form2.Label1.Caption:=IntToStr(t);
vmx:=vm*cos(am);
vmy:=vm*sin(am);
xm:=xm+vmx;
ym:=ym+vmy;
Shape1.Left:=Round(xm);
Shape1.Top:=Round(ym);

ar:=ArcTan2(ym-yr,xm-xr);
vrx:=vr*cos(ar);
vry:=vr*sin(ar);
xr:=xr+vrx;
yr:=yr+vry;
Shape2.Left:=Round(xr);
Shape2.Top:=Round(yr);
if Sqr(Shape1.Top-Shape2.Top)+Sqr(Shape1.Left-Shape2.Left)<400 then
  begin
  Form2.BitBtn1.Enabled:=true;
  Form2.BitBtn2.Enabled:=false;
  Timer1.Enabled:=false;
  end;
end;

procedure TForm1.FormMouseDown(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
begin
am:=ArcTan2(y-ym,x-xm);
end;

procedure TForm1.FormShow(Sender: TObject);
begin
Form2.Show;
end;

procedure TForm1.Shape1MouseDown(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
begin
if Timer1.Enabled=false then
  begin
  x0:=x;y0:=y;
  Shape1.BeginDrag(true);
  end;
end;

procedure TForm1.Shape1DragOver(Sender, Source: TObject; X, Y: Integer;
  State: TDragState; var Accept: Boolean);
begin
if Timer1.Enabled=false then
  begin
  Shape1.Left:=Shape1.Left+x-x0;
  Shape1.Top:=Shape1.Top+y-y0;
  end;
end;

procedure TForm1.FormDragOver(Sender, Source: TObject; X, Y: Integer;
  State: TDragState; var Accept: Boolean);
begin
if Shape1.Dragging then Shape1.OnDragOver(Form1,Shape1,x-Shape1.Left,y-Shape1.Top,State,Accept);
if Shape2.Dragging then Shape2.OnDragOver(Form1,Shape2,x-Shape2.Left,y-Shape2.Top,State,Accept);
end;

procedure TForm1.Shape2DragOver(Sender, Source: TObject; X, Y: Integer;
  State: TDragState; var Accept: Boolean);
begin
if Timer1.Enabled=false then
  begin
  Shape2.Left:=Shape2.Left+x-x0;
  Shape2.Top:=Shape2.Top+y-y0;
  end;
end;

procedure TForm1.Shape2MouseDown(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
begin
if Timer1.Enabled=false then
  begin
  x0:=x;y0:=y;
  Shape2.BeginDrag(true);
  end;
end;

end.
