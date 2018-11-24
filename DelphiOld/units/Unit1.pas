unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, Grids, Buttons, StdCtrls, Spin, ExtCtrls;

type
  TForm1 = class(TForm)
    StringGrid1: TStringGrid;
    StringGrid2: TStringGrid;
    SpinEdit1: TSpinEdit;
    SpinEdit2: TSpinEdit;
    SpeedButton1: TSpeedButton;
    Timer1: TTimer;
    CheckBox1: TCheckBox;
    procedure SpinEdit1Change(Sender: TObject);
    procedure SpinEdit2Change(Sender: TObject);
    procedure SpeedButton1Click(Sender: TObject);
    procedure FormCreate(Sender: TObject);
    procedure Timer1Timer(Sender: TObject);
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  Form1: TForm1;

implementation

type
monstr=record
hp,hpm,d:extended;
end;

var a,b:array of monstr;
am,bm:integer;
k:extended;
f:text;

{$R *.dfm}

procedure TForm1.SpinEdit1Change(Sender: TObject);
begin
StringGrid1.ColCount:=Spinedit1.Value;
am:=spinedit1.Value;
end;

procedure TForm1.SpinEdit2Change(Sender: TObject);
begin
StringGrid2.ColCount:=Spinedit2.Value;
bm:=spinedit2.Value;
end;

procedure TForm1.SpeedButton1Click(Sender: TObject);
var i:integer;
begin
if Timer1.Enabled=false then
    begin
    setlength(a,spinedit1.Value);
    setlength(b,spinedit2.Value);

    for i:= 0 to SpinEdit1.Value-1 do
        begin
        a[i].hpm:=StrToFloat(StringGrid1.cells[i,1]);
        a[i].d:=StrToFloat(StringGrid1.cells[i,2]);
        a[i].hp:=a[i].hpm;
        Stringgrid1.Cells[i,0]:=StringGrid1.cells[i,1];
        end;

    for i:= 0 to SpinEdit2.Value-1 do
        begin
        b[i].hpm:=StrToFloat(StringGrid2.cells[i,1]);
        b[i].d:=StrToFloat(StringGrid2.cells[i,2]);
        b[i].hp:=b[i].hpm;
        Stringgrid2.Cells[i,0]:=StringGrid2.cells[i,1];
        end;
    end;

Timer1.Enabled:=not Timer1.Enabled;
if Timer1.Enabled then SpeedButton1.Caption:='stop'
else SpeedButton1.Caption:='start';
end;

procedure TForm1.FormCreate(Sender: TObject);
var i:integer;
d:extended;
begin
k:=0.1;
assignfile(f,'save.txt');
reset(f);
read(f,am);SpinEdit1.Value:=am;
StringGrid1.ColCount:=Spinedit1.Value;

for i:=0 to am-1 do
        begin
        read(f,d);
        stringGrid1.Cells[i,1]:=FloatToStr(d);
        read(f,d);
        stringGrid1.Cells[i,2]:=FloatToStr(d);
        end;

read(f,bm);SpinEdit2.Value:=bm;
StringGrid2.ColCount:=Spinedit2.Value;

for i:=0 to bm-1 do
        begin
        read(f,d);
        stringGrid2.Cells[i,1]:=FloatToStr(d);
        read(f,d);
        stringGrid2.Cells[i,2]:=FloatToStr(d);
        end;
closefile(f);
end;

procedure TForm1.Timer1Timer(Sender: TObject);
var i:integer;
begin
for i:=0 to am-1 do
        begin
        b[bm-1].hp:=b[bm-1].hp-k*a[i].d;
        end;

for i:=0 to bm-1 do
        begin
        a[am-1].hp:=a[am-1].hp-k*b[i].d;
        end;

stringgrid1.Cells[am-1,0]:=FloatToStr(a[am-1].hp);
stringgrid2.Cells[bm-1,0]:=FloatToStr(b[bm-1].hp);

if a[am-1].hp<=0 then am:=am-1;
if b[bm-1].hp<=0 then bm:=bm-1;
if (bm=0)or(am=0) then Timer1.Enabled:=false;

end;

procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
var i:integer;
begin
if not CheckBox1.Checked then exit;

assignfile(f,'save.txt');
rewrite(f);
writeln(f,am);
for i:=0 to am-1 do
        begin
        writeln(f,stringGrid1.Cells[i,1]);
        writeln(f,stringGrid1.Cells[i,2]);
        end;

writeln(f,bm);
for i:=0 to bm-1 do
        begin
        writeln(f,stringGrid2.Cells[i,1]);
        writeln(f,stringGrid2.Cells[i,2]);
        end;
closefile(f);
end;

end.
