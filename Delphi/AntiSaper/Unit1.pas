unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, Grids, StdCtrls, Buttons, Spin, ExtCtrls;

type
  TForm1 = class(TForm)
    DG1: TDrawGrid;
    La11: TLabel;
    La12: TLabel;
    La13: TLabel;
    SbT1: TSpeedButton;
    SbT2: TSpeedButton;
    SbNG: TSpeedButton;
    La14: TLabel;
    Pn1: TPanel;
    La21: TLabel;
    Se2: TSpinEdit;
    La22: TLabel;
    Se1: TSpinEdit;
    La23: TLabel;
    Se3: TSpinEdit;
    Cb24: TComboBox;
    Se4: TSpinEdit;
    La25: TLabel;
    Se5: TSpinEdit;
    SbNGOK: TSpeedButton;
    procedure FormCreate(Sender: TObject);
    procedure DG1DrawCell(Sender: TObject; ACol, ARow: Integer;
      Rect: TRect; State: TGridDrawState);
    procedure DG1DblClick(Sender: TObject);
    procedure OutInfo;
    procedure ReadOptions;
    procedure SbNGClick(Sender: TObject);
    procedure SbNGOKClick(Sender: TObject);
    procedure SbT2Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

tkl=record
a,v,s:integer;
end;

var
Form1: TForm1;
gold,klco,hodnum,errco,isendgame:integer;
a:array[0..19,0..19]of tkl;
opt:array[0..5]of integer;

procedure MakeNearVis(x1,x2:integer);
procedure MakeSum;
procedure ChangeKlad(x1,x2:integer);

implementation

{$R *.dfm}

procedure MakeNearVis(x1,x2:integer);
var k1,k2:integer;
begin
a[x1,x2].v:=1;

for k1:=-1 to 1 do for k2:=-1 to 1 do
        if (abs(k1)+abs(k2)>0) and (x1+k1>=0) and (x1+k1<opt[0]) and (x2+k2>=0) and (x2+k2<opt[0]) then
                if (a[x1+k1,x2+k2].s = 0) and (a[x1+k1,x2+k2].v=0) then
                        MakeNearVis(x1+k1,x2+k2);

if a[x1,x2].s = 0 then
        begin
        for k1:=-1 to 1 do for k2:=-1 to 1 do
                if (abs(k1)+abs(k2)>0) and (x1+k1>=0) and (x1+k1<opt[0]) and (x2+k2>=0) and (x2+k2<opt[0]) then
                        a[x1+k1,x2+k2].v:=1;
        end;                                     
end;

procedure MakeSum;
var i,j,k1,k2:integer;
begin
for i:=0 to 9 do for j:=0 to 9 do
        a[i,j].s:=0;
for i:=0 to 9 do for j:=0 to 9 do
        for k1:=-1 to 1 do for k2:=-1 to 1 do
                if (i+k1>=0) and (i+k1<opt[0]) and (j+k2>=0) and (j+k2<opt[0]) then
                        begin
                        a[i+k1,j+k2].s:=a[i+k1,j+k2].s+a[i,j].a;
                        end;
end;

procedure ChangeKlad(x1,x2:integer);
var i1,i2,t:integer;
begin
if a[x1,x2].a=0 then exit;
i1:=random(opt[0]);
i2:=random(opt[1]);
t:=0;
while a[i1,i2].a>0 do
        begin
        t:=t+1;
        i2:=(i2+1) mod opt[0];
        if (t mod opt[0])=0 then
                i1:=(i1+1) mod opt[0];
        end;
a[i1,i2].a:=a[x1,x2].a;
a[x1,x2].a:=0;
end;

procedure GameStart;
var r,k1,k2,i,j:integer;
begin
gold:=200;
klco:=opt[1];
hodnum:=0;
errco:=0;

for i:=0 to opt[0]-1 do for j:=0 to opt[0]-1 do
        begin
        a[i,j].a:=0;
        a[i,j].v:=0;
        a[i,j].s:=0;
        end;

while klco>0 do
        begin
        r:=random(opt[2])+1;
        repeat
        k1:=random(opt[0]);
        k2:=random(opt[0]);
        until a[k1,k2].a=0;
        a[k1,k2].a:=r;
        klco:=klco-r;
        if klco<0 then
                begin
                a[k1,k2].a:=a[k1,k2].a+klco;
                klco:=0;
                end;
        end;
klco:=opt[1];

r:=0;
for i:=0 to opt[0]-1 do
        begin
        for j:=0 to opt[0]-1 do
                if a[i,j].a=0 then
                        begin
                        r:=1;
                        break;
                        end;
        if r=1 then break;
        end;
if r=0 then
        showmessage('������� ����� ������. ������� ����� ����');
end;

procedure TForm1.FormCreate(Sender: TObject);
begin
Randomize;
ReadOptions;
GameStart;
MakeSum;
OutInfo;
end;

procedure TForm1.DG1DrawCell(Sender: TObject; ACol, ARow: Integer;
  Rect: TRect; State: TGridDrawState);
var x:integer;
begin
x:=a[acol,arow].s;
if a[acol,arow].v=0 then
        DG1.Canvas.TextOut(Rect.Left+15,Rect.Top+10,'?')
else
        DG1.Canvas.TextOut(Rect.Left+15,Rect.Top+10,inttostr(x));
end;

procedure TForm1.DG1DblClick(Sender: TObject);
var x1,x2,tip,res:integer;
begin
if isendgame<>0 then exit;
hodnum:=hodnum+1;
x1:=DG1.Col;
x2:=DG1.Row;
tip:=0;
if SbT2.Down then tip:=1;
res:=a[x1,x2].a;
if (hodnum<=1) and (res>0) then
        ChangeKlad(x1,x2);

if (tip=0) and (res=0) then
        begin
        gold:=gold-opt[5];
        showmessage('1.�� ������� '+inttostr(opt[5])+' ������');
        end;
if (tip=0) and (res>0) then
        begin
        klco:=klco-a[x1,x2].a;
        a[x1,x2].a:=0;
        gold:=gold-opt[5];
        showmessage('2.�� ������� '+inttostr(opt[5])+' ������');
        errco:=errco+1;
        end;
if (tip=1) and (res=0) then
        begin
        gold:=gold-opt[5]-opt[4];
        showmessage('3.�� ������� '+inttostr(opt[4]+opt[5])+' ������');
        errco:=errco+1;
        end;
if (tip=1) and (res>0) then
        begin
        gold:=gold+res*100;
        klco:=klco-a[x1,x2].a;
        a[x1,x2].a:=0;
        showmessage('4.�� ����� ���� � ��������� ������� '+inttostr(res*100)+' ������');
        end;

MakeSum;
MakeNearVis(x1,x2);

OutInfo;
DG1.Repaint;

if klco=0 then
        begin
        isendgame:=1;
        showmessage('�� ���������� '+inttostr(gold)+' �����');
        end;
if (opt[3]=1) and (errco>opt[4]) then
        begin
        isendgame:=-1;
        showmessage('�� ���������. ����� ������');
        end;
if gold<0 then
        begin
        isendgame:=-1;
        showmessage('� ��� ��� ����� �� ��������. �� ���������');
        end;
end;

procedure TForm1.OutInfo;
begin
La11.Caption:='������ '+inttostr(gold);
La12.Caption:='�������� '+inttostr(klco) +' ������';
La13.Caption:='������ '+inttostr(errco);
La14.Caption:='��� ����� '+inttostr(hodnum);
end;

procedure TForm1.SbNGClick(Sender: TObject);
begin
Pn1.Visible:=not Pn1.Visible;
end;

procedure TForm1.ReadOptions;
begin
opt[0]:=Se1.Value;
opt[1]:=Se2.Value;
opt[2]:=Se3.Value;
opt[3]:=Cb24.ItemIndex;
opt[4]:=Se4.Value;
opt[5]:=Se5.Value;
end;

procedure TForm1.SbNGOKClick(Sender: TObject);
begin
ReadOptions;
DG1.ColCount:=opt[0];
DG1.RowCount:=opt[0];
GameStart;
MakeSum;
OutInfo;
DG1.Repaint;
Pn1.Visible:=false;
end;

procedure TForm1.SbT2Click(Sender: TObject);
begin
if hodnum=0 then
        begin
        showmessage('������ ��� ������������ ������ ��������');
        SbT1.Down:=true;
        end;
end;

end.
