unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, Grids, Buttons, StdCtrls, ExtCtrls;

type
  TForm1 = class(TForm)
    DrawGrid1: TDrawGrid;
    SpeedButton1: TSpeedButton;
    SpeedButton2: TSpeedButton;
    SpeedButton3: TSpeedButton;
    LabeledEdit1: TLabeledEdit;
    LabeledEdit2: TLabeledEdit;
    Timer1: TTimer;
    DrawGrid2: TDrawGrid;
    CheckBox1: TCheckBox;
    Label1: TLabel;
    Label2: TLabel;
    SpeedButton4: TSpeedButton;
    LabeledEdit3: TLabeledEdit;
    LabeledEdit4: TLabeledEdit;
    procedure SpeedButton3Click(Sender: TObject);
    procedure Timer1Timer(Sender: TObject);
    procedure FormCreate(Sender: TObject);
    procedure DrawGrid1DrawCell(Sender: TObject; ACol, ARow: Integer;
      Rect: TRect; State: TGridDrawState);
    procedure DrawGrid2DrawCell(Sender: TObject; ACol, ARow: Integer;
      Rect: TRect; State: TGridDrawState);
    procedure FormKeyDown(Sender: TObject; var Key: Word;
      Shift: TShiftState);
    procedure SpeedButton1Click(Sender: TObject);
    procedure SpeedButton2Click(Sender: TObject);

    procedure ChangeFig;
    procedure CheckDelLine;
    procedure FormPaint(Sender: TObject);
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
    procedure SpeedButton4Click(Sender: TObject);
    procedure CheckEndGame;
  private
    { Private declarations }
  public
    { Public declarations }
  end;

{
TKletka=record//TPoint
x,y:integer;
end;
}

Figura=record
p,count:integer;
a:array[0..4,0..3] of TPoint;
end;

var
  Form1: TForm1;

a:array of array of integer;//Main array[col(X),row(Y) 0-free,1-current figure,2-busy
xc,yc,r,x,y,tickaction,DG2stip,DG2X,DG2Y:integer;
cou,tip,score,rotnum,isendgame:integer;
kl:array[0..4]of TPoint;
bmpred,bmpwhite,bmpgreen:tbitmap;
typesc:integer;
types:array of figura;//first load if rotnum=0 then make_rot_figures
f:text;

function CanMoveX(dir:integer):boolean;
function CanMoveY:boolean;
function CanRotate:boolean;
procedure MakeFigXY;
procedure MakeRotatedFigires;
procedure Make00(tip,rot:integer);


implementation

{$R *.dfm}

//Game Start
procedure TForm1.SpeedButton3Click(Sender: TObject);
var i,j:integer;
msg1:string;
begin
msg1:='������� ����� ����� �� 8 �� 15';
try
xc:=strtoint(LabeledEdit1.Text);
except
showmessage(msg1);
exit;
end;
if (xc>15)or(xc<8) then begin showmessage(msg1);exit;end;

try
yc:=strtoint(LabeledEdit2.Text);
except
showmessage(msg1);
exit;
end;
if (yc>15)or(yc<8) then begin showmessage(msg1);exit;end;

DrawGrid1.ColCount:=xc;
DrawGrid1.RowCount:=yc;
setlength(a,yc);
for i:=0 to yc-1 do
        setlength(a[i],xc);
//0-nothing 1-already 2-current
for i:=0 to yc-1 do for j:=0 to xc-1 do
        a[i,j]:=0;
DrawGrid1.Repaint;
Timer1.Enabled:=false;
end;

procedure MakeFigXY;
var i:integer;
begin
cou:=types[tip].count;
for i:=0 to 4 do
        begin
        kl[i].x:=types[tip].a[i,rotnum].x+x;
        kl[i].y:=types[tip].a[i,rotnum].y+y;
        end;
end;

function GenTip:integer;
var i,sum:integer;
r:extended;
begin
sum:=0;
for i:=0 to typesc-1 do
        sum:=sum+types[i].p;

r:=random*sum;
sum:=0;
result:=0;
for i:=0 to typesc-1 do
        begin
        sum:=sum+types[i].p;
        if r>sum then result:=result+1;
        end;
end;

procedure TForm1.ChangeFig;
begin
tip:=GenTip;//random(typesc);
x:=xc div 2;
y:=0;
rotnum:=0;

MakeFigXY;
DrawGrid2.Repaint;
end;

function CanMoveY:boolean;
var i:integer;
begin
result:=true;
for i:=0 to cou-1 do
        begin
        if (kl[i].y+1>=yc)then result:=false
        else if a[kl[i].x,kl[i].y+1]=1 then result:=false;
        end;
end;

procedure TForm1.Timer1Timer(Sender: TObject);
var i,j:integer;
begin
if IsEndGame=1 then exit;
Label1.Caption:=' X='+IntToStr(X)+' Y='+IntToStr(Y)+' r='+IntToStr(r)+' rotnum='+IntToStr(rotnum);
Caption:='�������� ������ ����� '+inttostr(tip+1);

//Change tickaction
case tickaction of
        0:begin
        if CanMoveY then tickaction:=0 else tickaction:=1;
        end;
        1:begin
        tickaction:=2;
        end;
        2:begin
        tickaction:=0;
        end;
end;

//Do action
case tickaction of
        0:begin
        //Delele figure
        for i:=0 to Cou-1 do
                if (kl[i].x>=0)and(kl[i].x<xc)and(kl[i].y>=0)and(kl[i].x<yc) then
                        a[kl[i].x,kl[i].y]:=0;
        for i:=0 to yc-1 do for j:=0 to xc-1 do
                if a[i,j]=2 then a[i,j]:=0;

        y:=y+1;
        MakeFigXY;
        for i:=0 to Cou-1 do
                a[kl[i].x,kl[i].y]:=2;
        DrawGrid1.Repaint;
        end;

        1:begin
        MakeFigXY;
        for i:=0 to Cou-1 do
                a[kl[i].x,kl[i].y]:=1;
        DrawGrid1.Repaint;
        end;

        2:begin
        ChangeFig;
        CheckDelLine;
        Label2.Caption:='����: '+IntToStr(score);
        DrawGrid1.Repaint;
        DrawGrid2.Repaint;
        end;
end;

CheckEndGame;
end;

procedure TForm1.CheckDelLine;
var res,i,j,i1:integer;
begin
for i:=yc-1 downto 0 do
        begin
        res:=0;
        for j:=0 to xc-1 do
                if a[j,i]=1 then res:=res+1;
        if res=xc then
                begin
                for j:=0 to xc-1 do
                        a[j,i]:=0;
                for i1:=i-1 downto 0 do
                        for j:=0 to xc-1 do
                                a[j,i1+1]:=a[j,i1];
                Score:=Score+100;
                end;
        end;
end;

procedure TForm1.FormCreate(Sender: TObject);
var i,j:integer;
begin
//start parametrs
randomize;
bmpred:=tbitmap.Create;
bmpred.Width:=DrawGrid1.DefaultColWidth;
bmpred.Height:=DrawGrid1.DefaultRowHeight;
bmpwhite:=tbitmap.Create;
bmpwhite.Width:=DrawGrid1.DefaultColWidth;
bmpwhite.Height:=DrawGrid1.DefaultRowHeight;
bmpgreen:=tbitmap.Create;
bmpgreen.Width:=DrawGrid1.DefaultColWidth;
bmpgreen.Height:=DrawGrid1.DefaultRowHeight;
bmpgreen.LoadFromFile('Bmp/green.bmp');
bmpred.LoadFromFile('Bmp/red.bmp');
bmpwhite.LoadFromFile('Bmp/white.bmp');

tickaction:=0;
rotnum:=0;
xc:=15;yc:=15;
setlength(a,xc);
for i:=0 to xc-1 do
        setlength(a[i],yc);

//Load options file
assignfile(f,'Options.txt');
reset(f);
readln(f,typesc);
setlength(types,typesc);
readln(f);
for i:=0 to typesc-1 do
        begin
        readln(f,types[i].p);
        readln(f,types[i].count);
        for j:=0 to types[i].count-1 do
                readln(f,types[i].a[j,rotnum].x,types[i].a[j,rotnum].y);
        readln(f);
        end;
closefile(f);
MakeRotatedFigires;
tip:=Gentip;//random(typesc);
end;

procedure Make00(tip,rot:integer);
var i,xmin,ymin:integer;
begin
xmin:=10;ymin:=10;
for i:=0 to types[tip].count-1 do
        begin
        if xmin>types[tip].a[i,rot].x then xmin:=types[tip].a[i,rot].x;
        if ymin>types[tip].a[i,rot].y then ymin:=types[tip].a[i,rot].y;
        end;

for i:=0 to types[tip].count-1 do
        begin
        types[tip].a[i,rot].x:=types[tip].a[i,rot].x-xmin;
        types[tip].a[i,rot].y:=types[tip].a[i,rot].y-ymin;
        end;
end;

procedure MakeRotatedFigires;
var i,j:integer;
begin
for i:=0 to typesc-1 do
        begin
        for j:=0 to types[i].count-1 do
                begin
                types[i].a[j,1].x:=types[i].a[j,0].y;
                types[i].a[j,1].y:=-types[i].a[j,0].x;

                types[i].a[j,2].x:=-types[i].a[j,0].x;
                types[i].a[j,2].y:=-types[i].a[j,0].y;

                types[i].a[j,3].x:=-types[i].a[j,0].y;
                types[i].a[j,3].y:=types[i].a[j,0].x;
                end;

        for j:=1 to 3 do
                Make00(i,j);
        end;

end;

procedure TForm1.DrawGrid1DrawCell(Sender: TObject; ACol, ARow: Integer;
  Rect: TRect; State: TGridDrawState);
begin
if a[acol,arow]=2 then
        DrawGrid1.Canvas.Draw(Rect.Left,Rect.Top,bmpred)
else if a[acol,arow]=1 then
        DrawGrid1.Canvas.Draw(Rect.Left,Rect.Top,bmpgreen)
else{if a[acol,arow]=0 then}
        DrawGrid1.Canvas.Draw(Rect.Left,Rect.Top,bmpwhite);

end;

procedure TForm1.DrawGrid2DrawCell(Sender: TObject; ACol, ARow: Integer;
  Rect: TRect; State: TGridDrawState);
var i,figt,figr:integer;b:boolean;
begin
if DG2stip=0 then figt:=tip else figt:=DG2X;
if DG2stip=0 then figr:=rotnum else figr:=DG2Y;

b:=false;
for i:=0 to cou-1 do
        if (acol=types[figt].a[i,figr].x)and(arow=types[figt].a[i,figr].y)
                then b:=true;

{
if b then DrawGrid2.Canvas.Brush.Color:=clRed
else DrawGrid2.Canvas.Brush.Color:=clWhite;
DrawGrid2.Canvas.FillRect(rect);
}
if b then DrawGrid2.Canvas.Draw(Rect.Left,Rect.Top,BmpRed)
else DrawGrid2.Canvas.Draw(Rect.Left,Rect.Top,BmpWhite);

end;

function CanMoveX(dir:integer):boolean;
var i:integer;
begin
result:=true;
for i:=0 to Cou-1 do
        begin
        if kl[i].x+dir<0 then begin result:=false; exit; end;
        if kl[i].x+dir>=xc then begin result:=false; exit; end;
        if a[kl[i].x+dir,kl[i].y]=1 then begin result:=false; exit; end;
        end;

end;

function CanRotate:boolean;
var tmpx,tmpy,i,newrotnum:integer;
begin
result:=true;
newrotnum:=rotnum+1;
if newrotnum=4 then newrotnum:=0;
for i:=0 to cou-1 do
        begin
        tmpx:=x+types[tip].a[i,newrotnum].x;
        tmpy:=y+types[tip].a[i,newrotnum].y;

        
        if (tmpx<0)or(tmpx>=xc) then begin result:=false;exit; end;
        if (tmpy<0)or(tmpy>=yc) then begin result:=false;exit; end;
        if a[tmpx,tmpy]=1 then begin result:=false;exit; end;
        end;
end;

procedure TForm1.FormKeyDown(Sender: TObject; var Key: Word;
  Shift: TShiftState);
var i:integer;
begin

//showmessage(inttostr(key));
if key=37 then//left button
        begin
        Caption:='Left';
        if not CanMoveX(-1) then exit;
        x:=x-1;
        MakeFigXY;
        end;
if key=39 then//right button
        begin
        if not CanMoveX(1) then exit;
        Caption:='Right';
        x:=x+1;
        MakeFigXY;
        end;
if key=38 then//up button
        begin
        if not CanRotate then exit;
        Caption:='Rotate';
        for i:=0 to cou-1 do
                a[kl[i].x,kl[i].y]:=0;
        //type
        rotnum:=rotnum+1;
        if rotnum=4 then rotnum:=0;

        for i:=0 to cou-1 do
                begin
                kl[i].x:=x+types[tip].a[i,rotnum].x;
                kl[i].y:=y+types[tip].a[i,rotnum].y;
                end;

        for i:=0 to cou-1 do
                a[kl[i].x,kl[i].y]:=2;
        end;

DrawGrid1.Col:=0;DrawGrid1.Row:=0;
end;

procedure TForm1.SpeedButton1Click(Sender: TObject);
begin
Timer1.Enabled:=true;
end;

procedure TForm1.SpeedButton2Click(Sender: TObject);
begin
Timer1.Enabled:=false;
end;

procedure TForm1.FormPaint(Sender: TObject);
begin
DrawGrid2.Repaint;
end;

procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
begin
bmpred.Free;
bmpwhite.Free;
bmpgreen.Free;
end;

procedure TForm1.CheckEndGame;
var i,j:integer;
begin
isendgame:=0;
for i:=0 to xc-1 do
        for j:=0 to 3-1 do
                if a[i,j]=1 then isendgame:=1;

if isendgame=1 then
        begin
        Caption:='���� ���������';
        Timer1.Enabled:=false;
        end;
end;

procedure TForm1.SpeedButton4Click(Sender: TObject);
var s,msg1,msg2:string;
begin
msg1:='Figire Number: ������� ����� �� 0 �� '+IntToStr(typesc-1);
msg2:='Figire Rotate: ������� ����� �� 0 �� 3';

s:=LabeledEdit3.Text;
try
DG2X:=StrToInt(s);
except
showmessage(msg1);
exit;
end;

s:=LabeledEdit4.Text;
try
DG2Y:=StrToInt(s);
except
showmessage(msg2);
exit;
end;

if (DG2X>typesc-1)or(DG2X<0) then begin showmessage(msg1);exit;end;
if (DG2Y>3)or(DG2Y<0) then begin showmessage(msg2);exit;end;

if DG2stip=0 then
        begin
        DG2stip:=1;
        SpeedButton4.Caption:='HideFigure';
        end else
        begin
        DG2stip:=0;
        SpeedButton4.Caption:='ShowFigure';
        end;

Drawgrid2.Repaint;
end;

end.
