unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, StdCtrls, ExtCtrls, Buttons;

type
CHOS=record
Chast,Ost:Integer;end;
  TForm1 = class(TForm)
    Image1: TImage;
    Button1: TButton;
    Button2: TButton;
    Button3: TButton;
    OpenDialog1: TOpenDialog;
    SaveDialog1: TSaveDialog;
    Button4: TButton;
    Button5: TButton;
    LabeledEdit1: TLabeledEdit;
    Button6: TButton;
    Timer1: TTimer;
    SpeedButton1: TSpeedButton;
    Timer2: TTimer;
    LabeledEdit2: TLabeledEdit;
    LabeledEdit3: TLabeledEdit;
    Button7: TButton;
    procedure Button1Click(Sender: TObject);
    procedure Button2Click(Sender: TObject);
    procedure FormCreate(Sender: TObject);
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
    procedure Button4Click(Sender: TObject);
    procedure Button3Click(Sender: TObject);
    procedure Image1MouseDown(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    procedure Button5Click(Sender: TObject);
    procedure LabeledEdit1Change(Sender: TObject);
    procedure Timer1Timer(Sender: TObject);
    procedure Button6Click(Sender: TObject);
    procedure SetCletkaBool(X,Y:Integer;Bool:Boolean);
    procedure Image1MouseMove(Sender: TObject; Shift: TShiftState; X,
      Y: Integer);
    procedure SpeedButton1Click(Sender: TObject);
    function Soseds(Y,X:integer):Integer;
    procedure Image1MouseUp(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    procedure Timer2Timer(Sender: TObject);
    function DivMod(Delimoe,Delitel:Integer):CHOS;
    procedure Button7Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  Form1: TForm1;

implementation

const Pix=5;KolX=140;KolY=120;
var Bmp:TBitMap;koef:Real;
PredTor:array[0..KolY-1,0..KolX-1]of Boolean;
Tor:array[0..KolY-1,0..KolX-1]of Boolean;
DoPaint,Play,LPr,RPr:Boolean;
kolvo,krec:Integer;tf:TextFile;
{$R *.dfm}

function TForm1.DivMod(Delimoe,Delitel:Integer):CHOS;
begin
if Delimoe>=0 then
    begin
    DivMod.Chast:=Delimoe div Delitel;
    DivMod.Ost:=Delimoe mod Delitel;
    end
              else
    begin
    DivMod.Chast:=((Delimoe+1) div Delitel)-1;
    DivMod.Ost:=Delimoe-Delitel*( ((Delimoe+1) div Delitel)-1);
    end;
end;

procedure TForm1.Button1Click(Sender: TObject);
var i,j:Integer;
begin
If OpenDialog1.Execute then
   begin
   Bmp.LoadFromFile(OpenDialog1.FileName);
   for i:=0 to KolY-1 do
        for j:=0 to KolX-1 do
            begin
            if Bmp.Canvas.Pixels[5*j+2,5*i+2]=clWhite then
                begin
                PredTor[i,j]:=false;
                Tor[i,j]:=false;
                Bmp.Canvas.Brush.Color:=clWhite;
                Bmp.Canvas.FillRect(Rect(5*j,5*i,5*j+4,5*i+4));
                end;
            if Bmp.Canvas.Pixels[5*j+2,5*i+2]=clBlack then
                begin
                PredTor[i,j]:=true;
                Tor[i,j]:=true;
                Bmp.Canvas.Brush.Color:=clBlack;
                Bmp.Canvas.FillRect(Rect(5*j,5*i,5*j+4,5*i+4));
                end;
            end;
   Image1.Canvas.Draw(0,0,Bmp);
   end;
end;

procedure TForm1.Button2Click(Sender: TObject);
begin
If SaveDialog1.Execute then
   begin
   Bmp.SaveToFile(SaveDialog1.FileName);
   end;
end;

procedure TForm1.FormCreate(Sender: TObject);
begin
assignfile(tf,'rec.txt');
reset(tf);
read(tf,krec);
Randomize;
Bmp:=TBitMap.Create;
Bmp.Width:=700;
Bmp.Height:=600;
With Image1.Canvas do
     begin
     Brush.Color:=clWhite;
     FillRect(Rect(0,0,Width,Height));
     end;
end;

procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
begin
Bmp.Free;
rewrite(tf);
Write(tf,krec);
closefile(tf);
end;

procedure TForm1.Button4Click(Sender: TObject);
begin
DoPaint:=true;
end;

procedure TForm1.Button3Click(Sender: TObject);
var Code:integer;
begin
val(LabeledEdit1.Text,koef,code);
if code=0 then Koef:=StrToFloat(LabeledEdit1.Text);
if (Koef>0)and(koef<1)then DoPaint:=false;
end;

procedure TForm1.SetCletkaBool(X,Y:Integer;Bool:Boolean);
begin
if Bool=false then
        begin
        Bmp.Canvas.Pen.Color:=clWhite;
        Bmp.Canvas.Brush.Color:=clWhite;
        end
              else
        begin
        Bmp.Canvas.Pen.Color:=clBlack;
        Bmp.Canvas.Brush.Color:=clBlack;
        end;
PredTor[Y,X]:=Bool;
Tor[Y,X]:=Bool;
Bmp.Canvas.FillRect(Rect(5*X,5*Y,5*X+4,5*Y+4));
end;

procedure TForm1.Image1MouseDown(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
begin
if DoPaint=true then begin
if Button=mbLeft then
        begin
        LPr:=true;
        Form1.SetCletkaBool(x div 5,y div 5,false);
        end;
if Button=mbRight then
        begin
        RPr:=true;
        Form1.SetCletkaBool(x div 5,y div 5,true);
        end;
Image1.Canvas.Draw(0,0,Bmp);
end;
end;

function TForm1.Soseds(Y,X:integer):Integer;
var i,j,s,SelfBool:integer;
begin
s:=0;
if PredTor[Y,X]=false then SelfBool:=0
                      else SelfBool:=1;
for i:=Y-1 to Y+1 do for j:=X-1 to X+1 do
        If PredTor[DivMod(i,KolY).Ost,DivMod(j,KolX).Ost]=true then S:=S+1;
Soseds:=S-SelfBool;
end;

procedure TForm1.Button5Click(Sender: TObject);
begin
Koef:=Random;
LabeledEdit1.Text:=FloatToStr(koef);
end;

procedure TForm1.LabeledEdit1Change(Sender: TObject);
begin
If LabeledEdit1.Text='' then Button3.Enabled:=false
                        else Button3.Enabled:=true;
end;

procedure TForm1.Timer1Timer(Sender: TObject);
begin
If (koef>0)and(koef<1) then Button6.Enabled:=true
                       else Button6.Enabled:=false;
end;

procedure TForm1.Button6Click(Sender: TObject);
var i,j:integer;Rand:Real;
begin
For I:=0 to KolY-1 do
    for j:=0 to KolX-1 do
        begin
        Rand:=random;
        if rand<koef then Form1.SetCletkaBool(j,i,true);
        if rand>koef then Form1.SetCletkaBool(j,i,false);
        end;
Image1.Canvas.Draw(0,0,Bmp);
end;

procedure TForm1.Image1MouseMove(Sender: TObject; Shift: TShiftState; X,
  Y: Integer);
begin
Caption:=IntToStr(X div 5)+' '+IntToStr(Y div 5);
if LPr=true then Form1.SetCletkaBool(x div 5,y div 5,false);
if RPr=true then Form1.SetCletkaBool(x div 5,y div 5,true);
if (LPr=true)or(RPr=true)then Image1.Canvas.Draw(0,0,Bmp);
end;

procedure TForm1.SpeedButton1Click(Sender: TObject);
begin
Play:=not Play;
Button1.Visible:=not Button1.Visible;
Button2.Visible:=not Button2.Visible;
Button3.Visible:=not Button3.Visible;
Button4.Visible:=not Button4.Visible;
Button5.Visible:=not Button5.Visible;
Button6.Visible:=not Button6.Visible;
Button7.Visible:=not Button7.Visible;
LabeledEdit1.Visible:=not LabeledEdit1.Visible;
Timer2.Enabled:=not Timer2.Enabled;
If Play=false then SpeedButton1.Caption:='start'
              else SpeedButton1.Caption:='stop';
end;

procedure TForm1.Image1MouseUp(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
begin
If Button=mbLeft then LPr:=false;
If Button=mbRight then RPr:=false;
end;

procedure TForm1.Timer2Timer(Sender: TObject);
var i,j:integer;
begin
for i:=0 to KolY-1 do
    for j:=0 to KolX-1 do
        begin
        If(PredTor[i,j]=false)and(Soseds(i,j)=3)
             then Tor[i,j]:=true;
        If(PredTor[i,j]=true)and( (Soseds(i,j)>3)or(Soseds(i,j)<2) )
             then Tor[i,j]:=false;
        end;
if kolvo>krec then krec:=kolvo;
kolvo:=0;

for i:=0 to KolY-1 do
    for j:=0 to KolX-1 do
        begin
        PredTor[i,j]:=Tor[i,j];
        if Tor[i,j]=true then kolvo:=kolvo+1;
        Form1.SetCletkaBool(j,i,PredTor[i,j]);
        end;
Image1.Canvas.Draw(0,0,Bmp);
LabeledEdit3.Text:=IntToStr(kolvo);
LabeledEdit2.Text:=IntToStr(Krec);
end;

procedure TForm1.Button7Click(Sender: TObject);
var i,j:Integer;
begin
Bmp.Canvas.Brush.Color:=clWhite;
Bmp.Canvas.FillRect(Rect(0,0,5*KolX-1,5*KolY-1));
Canvas.Brush.Color:=clWhite;
Canvas.FillRect(Rect(0,0,5*KolX-1,5*KolY-1));
for i:=0 to KolY-1 do
    for j:=0 to KolX-1 do
        begin
        PredTor[i,j]:=false;
        Tor[i,j]:=false;
        end;
end;

end.
