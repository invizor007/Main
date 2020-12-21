unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, Grids, Buttons, StdCtrls, Spin;

const maxlen = 15;
//15 - 2279184  14-365596

type
ta=array[1..maxlen]of 0..maxlen;

  TForm1 = class(TForm)
    DrawGrid1: TDrawGrid;
    SpeedButton1: TSpeedButton;
    SpeedButton2: TSpeedButton;
    SpinEdit1: TSpinEdit;
    Label1: TLabel;
    Label2: TLabel;
    SpinEdit2: TSpinEdit;
    procedure Draw(var a:ta);
    procedure SpeedButton1Click(Sender: TObject);
    procedure FormCreate(Sender: TObject);
    procedure BackTracking(k:integer;a:ta);
    procedure SpeedButton2Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  Form1: TForm1;

implementation
var a:ta;
t:cardinal;
exitclick:boolean;
co:cardinal;
curlen:integer;
showtime:cardinal;

{$R *.dfm}
procedure TForm1.Draw(var a:ta);
var i:integer;
begin
DrawGrid1.Canvas.Brush.Color:=clblue;
for i:=1 to curlen do with DrawGrid1 do
  Canvas.Ellipse(CellRect(i-1,a[i]-1));
end;

procedure TForm1.BackTracking(k:integer;a:ta);
var i,j:integer;
po:boolean;
b:ta;
begin
if exitclick then exit;

if k<curlen then
        begin
        for i:=1 to curlen do b[i]:=a[i];
        for i:=1 to curlen do
                begin
                po:=true;
                for j:=1 to k do
                        begin
                        if a[j]=i then po:=false;
                        if abs(a[j]-i)=abs(j-k-1) then po:=false;
                        end;
                if po then
                        begin
                        b[k+1]:=i;
                        BackTracking(k+1,b);
                        end;
                end;
        end else
        begin
        co:=co+1;
        Form1.Caption:=IntToStr(co);
        Form1.Draw(a);        

        t:=GetTickCount;
        repeat
                Application.ProcessMessages;
        until (GetTickCount-t)>showtime;
        DrawGrid1.Repaint;      
        end;
end;

procedure TForm1.SpeedButton1Click(Sender: TObject);
begin
co:=0;
exitclick:=false;
showtime:=SpinEdit2.Value;
curlen:=SpinEdit1.Value;
DrawGrid1.ColCount:=curlen;
DrawGrid1.RowCount:=curlen;
DrawGrid1.DefaultColWidth:=trunc( (DrawGrid1.Width-2*curlen)/curlen);
DrawGrid1.DefaultRowHeight:=trunc( (DrawGrid1.Height-2*curlen)/curlen);

backTracking(0,a);
end;

procedure TForm1.FormCreate(Sender: TObject);
begin
DrawGrid1.Canvas.Brush.Color:=clblue;
curlen:=8;
showtime:=300;
end;

procedure TForm1.SpeedButton2Click(Sender: TObject);
begin
exitclick:=true;
end;

end.
