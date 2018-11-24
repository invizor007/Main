unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs,Parser, StdCtrls, ExtCtrls, Buttons;

type
  TForm1 = class(TForm)
    LabeledEdit1: TLabeledEdit;
    SpeedButton1: TSpeedButton;
    PaintBox1: TPaintBox;
    CheckBox1: TCheckBox;
    SpeedButton2: TSpeedButton;
    ColorDialog1: TColorDialog;
    Shape1: TShape;
    LabeledEdit3: TLabeledEdit;
    LabeledEdit4: TLabeledEdit;
    LabeledEdit5: TLabeledEdit;
    LabeledEdit6: TLabeledEdit;
    LabeledEdit2: TLabeledEdit;
    LabeledEdit7: TLabeledEdit;
    procedure SpeedButton1Click(Sender: TObject);
    procedure FormCreate(Sender: TObject);
    procedure SpeedButton2Click(Sender: TObject);
    procedure LabeledEdit1Change(Sender: TObject);
    procedure FormPaint(Sender: TObject);
    procedure Shape1MouseDown(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  Form1: TForm1;

implementation
 var Bmp:TBitMap;ScaleX,ScaleY,EIX,EIY:Real;
ShtrihX,ShtrihY:Integer;
{$R *.dfm}

procedure TForm1.SpeedButton1Click(Sender: TObject);
var P,EIFX,EIFY:TParSer;Args,EICX,EICY:array of real;i:Integer;
begin
if CheckBox1.Checked=false then SpeedButton2Click(Form1);
Bmp.Canvas.Pen.Color:=Shape1.Brush.Color;
P:=TParser.Create;
p.Variables.Add('x');
setlength(args,1);
P.Formula:=LabeledEdit1.Text;
args[0]:=-1;
    Bmp.Canvas.MoveTo(-1,350-Round(p.calc(args)*ScaleY));
for i:=-350 to 350 do
    begin
    args[0]:=i/ScaleX;
    Bmp.Canvas.LineTo(350+i,350-Round(p.calc(args)*ScaleY));
    end;
PaintBox1.Canvas.Draw(0,0,Bmp);
{Scale}
ScaleX:=StrToFloat(LabeledEdit2.Text);
{ShtrihX}
ShtrihX:=StrToInt(LabeledEdit3.Text);
EIFX:=TParser.Create;
EIFX.Variables.Add('x'); setlength(EICX,1);
EIFX.Formula:=LabeledEdit5.Text;EICX[0]:=0;
EIX:=EIFX.calc(EICX);
For i:=-Trunc(350/(ShtrihX*EIX*ScaleX)) to Trunc(350*ScaleX/(ShtrihX*EIX)) do With Bmp.Canvas do
    begin
    Pen.Color:=clBlack;
    MoveTo(350+Round(i*ScaleX*ShtrihX*EIX),345);
    LineTo(350+Round(i*ScaleX*ShtrihX*EIX),355);
    if EIX<>1 then TextOut(350+Round(i*ScaleX*ShtrihX*EIX),356,IntToStr(i*ShtrihX)+'*'+EIFX.Formula)
                else TextOut(350+Round(i*ScaleX*ShtrihX*EIX),356,IntToStr(i*ShtrihX))
    end;

ScaleY:=StrToFloat(LabeledEdit7.Text);
ShtrihY:=StrToInt(LabeledEdit4.Text);
EIFY:=TParser.Create;
EIFY.Variables.Add('y'); setlength(EICY,1);
EIFY.Formula:=LabeledEdit5.Text;EICY[0]:=0;
EIY:=EIFY.calc(EICY);
For i:=-Trunc(350/(ShtrihY*EIY*ScaleY)) to Trunc(350*ScaleY/(ShtrihY*EIY)) do With Bmp.Canvas do
    begin
    Pen.Color:=clBlack;
    MoveTo(345,350+Round(i*ScaleY*ShtrihY*EIY));
    LineTo(355,350+Round(i*ScaleY*ShtrihY*EIY));
    if EIX<>1 then TextOut(356,350+Round(i*ScaleX*ShtrihX*EIX),IntToStr(i*ShtrihX)+'*'+EIFX.Formula)
                else TextOut(356,350+Round(i*ScaleX*ShtrihX*EIX),IntToStr(i*ShtrihX))
    end;
end;

procedure TForm1.FormCreate(Sender: TObject);
begin
Bmp:=TBitMap.Create;
Bmp.Width:=PaintBox1.Width;
Bmp.Height:=PaintBox1.Height;
ScaleX:=1;ScaleY:=1;
{}


end;

procedure TForm1.SpeedButton2Click(Sender: TObject);
begin
Bmp.Canvas.FillRect(Rect(0,0,701,701));
Form1.FormPaint(Form1);
end;

procedure TForm1.LabeledEdit1Change(Sender: TObject);
begin
CheckBox1.Checked:=false;

end;

procedure TForm1.FormPaint(Sender: TObject);
begin
with Bmp.Canvas do
    begin
    Pen.Color:=clBlack;
    MoveTo(0,350);
    LineTo(701,350);LineTo(681,340);LineTo(681,360);LineTo(701,350);
    MoveTo(350,701);
    LineTo(350,0);LineTo(340,20);LineTo(360,20);LineTo(350,0);
    end;
PaintBox1.Canvas.Draw(0,0,Bmp);
end;

procedure TForm1.Shape1MouseDown(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
begin
if ColorDialog1.Execute then
    Shape1.Brush.Color:=ColorDialog1.Color;
end;

end.
 