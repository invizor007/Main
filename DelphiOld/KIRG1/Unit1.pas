unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, ExtCtrls, Buttons, StdCtrls, Systema;

type
  TForm1 = class(TForm)
    SpeedButton1: TSpeedButton;
    SpeedButton2: TSpeedButton;
    SpeedButton3: TSpeedButton;
    SpeedButton4: TSpeedButton;
    SpeedButton5: TSpeedButton;
    SpeedButton6: TSpeedButton;
    LabeledEdit1: TLabeledEdit;
    LabeledEdit2: TLabeledEdit;
    LabeledEdit3: TLabeledEdit;
    SpeedButton7: TSpeedButton;
    Label1: TLabel;
    procedure FormPaint(Sender: TObject);
    procedure LabeledEdit1Change(Sender: TObject);
    procedure LabeledEdit1KeyPress(Sender: TObject; var Key: Char);
    procedure FormCreate(Sender: TObject);
    procedure LabeledEdit2KeyPress(Sender: TObject; var Key: Char);
    procedure LabeledEdit3KeyPress(Sender: TObject; var Key: Char);
    procedure SpeedButton1Click(Sender: TObject);
    procedure SpeedButton2Click(Sender: TObject);
    procedure SpeedButton3Click(Sender: TObject);
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

implementation
var Dann:array[1..6]of Real;
//1-5--R1-R5;6--E
Obj:array[1..6]of TSpeedButton;
Num:Integer;
{$R *.dfm}
//рисование линий
procedure TForm1.FormPaint(Sender: TObject);
begin
With Canvas do
   begin
   rectangle(75,75,375,275);
   rectangle(75,175,375,275);
   MoveTo(225,75);LineTo(225,175);
   MoveTo(260,100);LineTo(260,150);
   LineTo(255,145);LineTo(265,145);LineTo(260,150);
   end;
end;

procedure TForm1.LabeledEdit1Change(Sender: TObject);
var i:integer;
begin
if (LabeledEdit1.Text<>'')and(LabeledEdit1.Text[Length(LabeledEdit1.Text)]<>'.')
   then Dann[Num]:=StrToFloat(LabeledEdit1.Text);
Obj[Num].Caption:=LabeledEdit1.Text;
//присвоения
UrsCount:=6;
for i:=1 to 5 do Syst[0,i]:=0;Syst[0,6]:=-Dann[6];Syst[1,1]:=-1;
Syst[1,2]:=1;Syst[1,3]:=0;Syst[1,4]:=Dann[1];Syst[1,5]:=0;
Syst[1,6]:=Dann[1];Syst[2,1]:=0;Syst[2,2]:=1;Syst[2,3]:=1;
Syst[2,4]:=-Dann[2];Syst[2,5]:=0;Syst[2,6]:=0;Syst[3,1]:=1;
for i:=2 to 4 do Syst[3,i]:=0;Syst[3,5]:=-Dann[3];Syst[3,6]:=Dann[3];
Syst[4,1]:=0;Syst[4,2]:=0;Syst[4,3]:=-1;Syst[4,4]:=0;
Syst[4,5]:=Dann[4];Syst[4,6]:=0;Syst[5,1]:=1;Syst[5,2]:=0;
Syst[5,3]:=1;Syst[5,4]:=Dann[5];Syst[5,5]:=Dann[5];Syst[5,6]:=0;
Syst[6,1]:=0;Syst[6,2]:=-1;for i:=3 to 6 do Syst[6,i]:=0;

Solve;
LabeledEdit3.Text:=FloatToStr(SystSolve[Num]);
if Num=6 then LabeledEdit2.Text:=FloatToStr(Dann[6])
         else LabeledEdit2.Text:=FloatToStr(Dann[Num]*SystSolve[Num]);
Label1.Caption:='R0='+FloatToStr(Dann[6]/SystSolve[6]);
end;
//контроль key
procedure TForm1.LabeledEdit1KeyPress(Sender: TObject; var Key: Char);
begin
if not(Key in ['0'..'9','.',#8]) then Key:=#0;
end;
//SpeedButtonы в группу
procedure TForm1.FormCreate(Sender: TObject);
var i:integer;
begin
for i:=1 to 6 do Dann[i]:=1;
Obj[1]:=SpeedButton1;Obj[2]:=SpeedButton2;Obj[3]:=SpeedButton3;
Obj[4]:=SpeedButton4;Obj[5]:=SpeedButton5;Obj[6]:=SpeedButton7;
end;
//контроль key
procedure TForm1.LabeledEdit2KeyPress(Sender: TObject; var Key: Char);
begin
{if not(Key in ['0'..'9','.',#8]) then }Key:=#0;
end;
//контроль key
procedure TForm1.LabeledEdit3KeyPress(Sender: TObject; var Key: Char);
begin
{if not(Key in ['0'..'9','.',#8]) then }Key:=#0;
end;
//SpeedButtonClickи
procedure TForm1.SpeedButton1Click(Sender: TObject);
begin
Num:=1;
LabeledEdit1.Text:=SpeedButton1.Caption;
LabeledEdit1.EditLabel.Caption:='R1';
LabeledEdit1Change(LabeledEdit1);
end;

procedure TForm1.SpeedButton2Click(Sender: TObject);
begin
Num:=2;
LabeledEdit1.Text:=SpeedButton2.Caption;
LabeledEdit1.EditLabel.Caption:='R2';
LabeledEdit1Change(LabeledEdit1);
end;

procedure TForm1.SpeedButton3Click(Sender: TObject);
begin
Num:=3;
LabeledEdit1.Text:=SpeedButton3.Caption;
LabeledEdit1.EditLabel.Caption:='R3';
LabeledEdit1Change(LabeledEdit1);
end;

procedure TForm1.SpeedButton4Click(Sender: TObject);
begin
Num:=4;
LabeledEdit1.Text:=SpeedButton4.Caption;
LabeledEdit1.EditLabel.Caption:='R4';
LabeledEdit1Change(LabeledEdit1);
end;

procedure TForm1.SpeedButton5Click(Sender: TObject);
begin
Num:=5;
LabeledEdit1.Text:=SpeedButton5.Caption;
LabeledEdit1.EditLabel.Caption:='R5';
LabeledEdit1Change(LabeledEdit1);
end;

procedure TForm1.SpeedButton6Click(Sender: TObject);
begin
Num:=6;
LabeledEdit1.Text:=SpeedButton7.Caption;
LabeledEdit1.EditLabel.Caption:='E';
LabeledEdit1Change(LabeledEdit1);
end;

end.
