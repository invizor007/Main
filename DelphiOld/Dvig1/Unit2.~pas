unit Unit2;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, StdCtrls, ExtCtrls, Grids, ValEdit, ExtDlgs, Buttons,Math, Menus;

type
  TForm2 = class(TForm)
    LabeledEdit1: TLabeledEdit;
    LabeledEdit2: TLabeledEdit;
    LabeledEdit3: TLabeledEdit;
    LabeledEdit4: TLabeledEdit;
    LabeledEdit5: TLabeledEdit;
    LabeledEdit6: TLabeledEdit;
    LabeledEdit7: TLabeledEdit;
    LabeledEdit9: TLabeledEdit;
    LabeledEdit10: TLabeledEdit;
    LabeledEdit8: TLabeledEdit;
    Label1: TLabel;
    OpenPictureDialog1: TOpenPictureDialog;
    StringGrid1: TStringGrid;
    BitBtn1: TBitBtn;
    Timer1: TTimer;
    CheckBox1: TCheckBox;
    CheckBox2: TCheckBox;
    BitBtn2: TBitBtn;
    BitBtn3: TBitBtn;
    SavePictureDialog1: TSavePictureDialog;
    ColorDialog1: TColorDialog;
    PopupMenu1: TPopupMenu;
    PmColor1: TMenuItem;
    Line1: TMenuItem;
    Rectangle1: TMenuItem;
    PmColor2: TMenuItem;
    Circle1: TMenuItem;
    Ellipse1: TMenuItem;
    Label2: TLabel;
    Carandash1: TMenuItem;
    ComboBox1: TComboBox;
    Edit1: TEdit;
    Brush1: TMenuItem;
    CheckBox3: TCheckBox;
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
    procedure Label1Click(Sender: TObject);
    procedure FormCreate(Sender: TObject);
    procedure LabeledEdit1KeyPress(Sender: TObject; var Key: Char);
    procedure BitBtn1Click(Sender: TObject);
    procedure LabeledEdit2KeyPress(Sender: TObject; var Key: Char);
    procedure Timer1Timer(Sender: TObject);
    procedure LabeledEdit3KeyPress(Sender: TObject; var Key: Char);
    procedure LabeledEdit4KeyPress(Sender: TObject; var Key: Char);
    procedure LabeledEdit5KeyPress(Sender: TObject; var Key: Char);
    procedure LabeledEdit6KeyPress(Sender: TObject; var Key: Char);
    procedure LabeledEdit7KeyPress(Sender: TObject; var Key: Char);
    procedure LabeledEdit8KeyPress(Sender: TObject; var Key: Char);
    procedure LabeledEdit9KeyPress(Sender: TObject; var Key: Char);
    procedure LabeledEdit10KeyPress(Sender: TObject; var Key: Char);
    procedure LabeledEdit2SubLabelClick(Sender: TObject);
    procedure CheckBox1Click(Sender: TObject);
    procedure CheckBox2Click(Sender: TObject);
    procedure BitBtn2Click(Sender: TObject);
    Procedure ModUg(kx,ky:Real;var ka,km:Real);
    procedure BitBtn3Click(Sender: TObject);
    procedure PmColor1Click(Sender: TObject);
    procedure Line1Click(Sender: TObject);
    procedure Rectangle1Click(Sender: TObject);
    procedure PmColor2Click(Sender: TObject);
    procedure Circle1Click(Sender: TObject);
    procedure Ellipse1Click(Sender: TObject);
    procedure Carandash1Click(Sender: TObject);
    procedure Edit1KeyPress(Sender: TObject; var Key: Char);
    procedure Brush1Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  Form2: TForm2;
var Bmp1,BmpTr:TBitMap;
uz,ti:integer;
y0,v0,va0,a,b,g,ga,et,el,fix:Real;
vars:array[1..11]of Real;
y0pm,nach,Enab,Ris,SaTr:boolean;
Fig,Maxim,Shag,ifix:Integer;
ClPoi:array[1..3]of TPoint;
CurX,CurY,CurXP,CurYP:Integer;
fn:String;
const r=10;koef=0.02157;
implementation

uses Unit1;

{$R *.dfm}
Procedure TForm2.ModUg(kx,ky:Real;var ka,km:Real);
begin
km:=sqrt(kx*kx+ky*ky);
if km=0 then ka:=0
  else if ky>=0 then ka:=180*arccos(kx/km)/pi
  else ka:=-180*arccos(kx/km)/pi;
end;

procedure TForm2.FormClose(Sender: TObject; var Action: TCloseAction);
begin
Form1.Close;
if SaTr=True then BmpTr.SaveToFile(fn);
Bmp1.Free;
BmpTr.Free;
end;

procedure TForm2.Label1Click(Sender: TObject);
begin
if OpenPictureDialog1.Execute then
    begin
    Label1.Caption:=OpenPictureDialog1.FileName;
    Bmp1.LoadFromFile(Label1.Caption);
    Form1.Hide;
    end;
end;

procedure TForm2.FormCreate(Sender: TObject);
begin
y0pm:=false;
end;

procedure TForm2.LabeledEdit1KeyPress(Sender: TObject; var Key: Char);
begin
if not(Key in ['0'..'9',#8])then Key:=#0;
if (Length(LabeledEdit1.Text)>2)and(Key<>#8) then Key:=#0;
end;

procedure TForm2.BitBtn1Click(Sender: TObject);
begin
ti:=0;
if SaTr=true then BmpTr.SaveToFile(fn);
with BmpTr.Canvas do
    begin
    Brush.Color:=clWhite;
    FillRect(Rect(0,0,1023,599));
    Pen.Color:=clGreen;
    MoveTo(0,uz);
    LineTo(1023,uz);
    end;
if(CheckBox3.Checked=true)and(CheckBox1.Checked=false)then
    if SavePictureDialog1.Execute then
        fn:=SavePictureDialog1.FileName;
if CheckBox3.Checked then SaTr:=true
                     else SaTr:=false;
with Form1.Canvas do if uz<>550 then
    begin
    Pen.Mode:=pmXor;
    Pen.Color:=clGreen;
    MoveTo(0,uz);
    LineTo(1024,uz);
    end;
if LabeledEdit1.Text='' then LabeledEdit1.Text:='0';{1}
uz:=StrToInt(LabeledEdit1.Text);
with Form1.Canvas do
    begin
    Pen.Mode:=pmCopy;
    Pen.Color:=clGreen;
    MoveTo(0,uz);
    LineTo(1024,uz);
    end;
{2}
if LabeledEdit2.Text='' then LabeledEdit2.Text:='0';
if LabeledEdit2.Text[Length(LabeledEdit2.Text)]='.' then
     LabeledEdit2.Text:=LabeledEdit2.Text+'0';
if y0pm=false then y0:=StrToFloat(LabeledEdit2.Text)
              else y0:=-StrToFloat(LabeledEdit2.Text);
{3}
if LabeledEdit3.Text='' then LabeledEdit3.Text:='0';
if LabeledEdit3.Text[Length(LabeledEdit3.Text)]='.' then
     LabeledEdit3.Text:=LabeledEdit3.Text+'0';
v0:=StrToFloat(LabeledEdit3.Text);
vars[4]:=v0;
if LabeledEdit4.Text='' then LabeledEdit4.Text:='0'; {4}
if LabeledEdit4.Text[Length(LabeledEdit4.Text)]='.' then
     LabeledEdit4.Text:=LabeledEdit4.Text+'0';
va0:=StrToFloat(LabeledEdit4.Text);
vars[3]:=va0;vars[1]:=vars[4]*cos(vars[3]*pi/180);vars[2]:=vars[4]*sin(vars[3]*pi/180);
{5}
if LabeledEdit5.Text='' then LabeledEdit5.Text:='0';
if LabeledEdit5.Text[Length(LabeledEdit5.Text)]='.' then
     LabeledEdit5.Text:=LabeledEdit5.Text+'0';
a:=StrToFloat(LabeledEdit5.Text);
{6}
if LabeledEdit6.Text='' then LabeledEdit6.Text:='0';
if LabeledEdit6.Text[Length(LabeledEdit6.Text)]='.' then
     LabeledEdit6.Text:=LabeledEdit6.Text+'0';
b:=StrToFloat(LabeledEdit6.Text);
{7}
if LabeledEdit7.Text='' then LabeledEdit7.Text:='0';
if LabeledEdit7.Text[Length(LabeledEdit7.Text)]='.' then
     LabeledEdit7.Text:=LabeledEdit7.Text+'0';
g:=StrToFloat(LabeledEdit7.Text);
{8}
if LabeledEdit8.Text='' then LabeledEdit8.Text:='0';
if LabeledEdit8.Text[Length(LabeledEdit8.Text)]='.' then
     LabeledEdit8.Text:=LabeledEdit8.Text+'0';
ga:=StrToFloat(LabeledEdit8.Text);
{9}
if (LabeledEdit9.Text='')or(LabeledEdit9.Text='0')then LabeledEdit9.Text:='1';
if LabeledEdit9.Text[Length(LabeledEdit9.Text)]='.' then
     LabeledEdit9.Text:=LabeledEdit9.Text+'0';
el:=StrToFloat(LabeledEdit9.Text);
{10}
if (LabeledEdit10.Text='')or(LabeledEdit10.Text='0')then LabeledEdit10.Text:='0.1';
if LabeledEdit10.Text[Length(LabeledEdit10.Text)]='.' then
     LabeledEdit10.Text:=LabeledEdit10.Text+'0';
et:=StrToFloat(LabeledEdit10.Text);
Form1.Shape1.Top:=uz-Round(y0/el)-r;
Form1.Shape1.Left:=-r;
vars[9]:=0;vars[10]:=y0;
{fix}
if Edit1.Text='' then Edit1.Text:='0';
if Edit1.Text[Length(Edit1.Text)]='.' then
     Edit1.Text:=Edit1.Text+'0';
if(ComboBox1.ItemIndex>-1)and(ComboBox1.ItemIndex<11)then
    ifix:=ComboBox1.ItemIndex+1;     
fix:=StrToFloat(Edit1.Text);
end;

procedure TForm2.LabeledEdit2KeyPress(Sender: TObject; var Key: Char);
var i:Integer;
begin
if not(Key in ['0'..'9',#8,'.'])then Key:=#0;
if (LabeledEdit2.Text='')and(Key='.')then Key:=#0;
for i:=1 to Length(LabeledEdit2.Text) do
    if(LabeledEdit2.Text[i]='.')and(Key='.')then Key:=#0;
end;
//TIMER
procedure TForm2.Timer1Timer(Sender: TObject);
var i:Integer;si1,si2:Integer;
begin
Caption:=FloatToStr(Round(CurX*el*1000)/1000)+'     '+FloatToStr(Round((uz-CurY)*el*1000)/1000);
CurXP:=CurX;CurYP:=CurY;
if  not Form1.Visible then
    begin
    Form1.Show;
    Form1.Canvas.Draw(0,0,Bmp1);
    end;
   if Enab=true then begin
si1:=sign(vars[ifix]-fix);
ti:=ti+1;vars[11]:=koef*ti*et;
vars[5]:=g*cos(pi*ga/180)-a*vars[1]-b*vars[1]* sqrt( sqr(vars[1]) + sqr(vars[2]) );
vars[6]:=g*sin(pi*ga/180)-a*vars[2]-b*vars[2]*sqrt( sqr(vars[1]) + sqr(vars[2]) );
vars[1]:=vars[1]+vars[5]*et*koef;
vars[2]:=vars[2]+vars[6]*et*koef;
vars[9]:=vars[9]+vars[1]*et*koef;
vars[10]:=vars[10]+vars[2]*et*koef;
with Form1.Shape1 do
    begin
    Left:=Round(vars[9]/el)-r;
    Top:=uz-Round(vars[10]/el)-r;
    end;
if SaTr=true then
    BmpTr.Canvas.Pixels[Form1.Shape1.Left+r,Form1.Shape1.Top+r]:=clRed;
ModUg(vars[1],vars[2],vars[3],vars[4]);
ModUg(vars[5],vars[6],vars[7],vars[8]);
si2:=sign(vars[ifix]-fix);
if si1<>si2 then
    Enab:=false;
for i:=1 to 11 do
    StringGrid1.Cells[i,1]:=FloatToStr(Round(10000000*vars[i])/10000000);
with Form1.Canvas do
    begin
    Pen.Mode:=pmCopy;
    Pen.Color:=clGreen;
    MoveTo(0,uz);
    LineTo(1023,uz);
    end;
end;end;

procedure TForm2.LabeledEdit3KeyPress(Sender: TObject; var Key: Char);
var i:Integer;
begin
if not(Key in ['0'..'9',#8,'.'])then Key:=#0;
if (LabeledEdit3.Text='')and(Key='.')then Key:=#0;
for i:=1 to Length(LabeledEdit3.Text) do
    if(LabeledEdit3.Text[i]='.')and(Key='.')then Key:=#0;
end;

procedure TForm2.LabeledEdit4KeyPress(Sender: TObject; var Key: Char);
var i:Integer;
begin
if not(Key in ['0'..'9',#8,'.'])then Key:=#0;
if (LabeledEdit4.Text='')and(Key='.')then Key:=#0;
for i:=1 to Length(LabeledEdit4.Text) do
    if(LabeledEdit4.Text[i]='.')and(Key='.')then Key:=#0;
end;

procedure TForm2.LabeledEdit5KeyPress(Sender: TObject; var Key: Char);
var i:Integer;
begin
if not(Key in ['0'..'9',#8,'.'])then Key:=#0;
if (LabeledEdit5.Text='')and(Key='.')then Key:=#0;
for i:=1 to Length(LabeledEdit5.Text) do
    if(LabeledEdit5.Text[i]='.')and(Key='.')then Key:=#0;
end;

procedure TForm2.LabeledEdit6KeyPress(Sender: TObject; var Key: Char);
var i:Integer;
begin
if not(Key in ['0'..'9',#8,'.'])then Key:=#0;
if (LabeledEdit6.Text='')and(Key='.')then Key:=#0;
for i:=1 to Length(LabeledEdit6.Text) do
    if(LabeledEdit6.Text[i]='.')and(Key='.')then Key:=#0;
end;

procedure TForm2.LabeledEdit7KeyPress(Sender: TObject; var Key: Char);
var i:Integer;
begin
if not(Key in ['0'..'9',#8,'.'])then Key:=#0;
if (LabeledEdit7.Text='')and(Key='.')then Key:=#0;
for i:=1 to Length(LabeledEdit7.Text) do
    if(LabeledEdit7.Text[i]='.')and(Key='.')then Key:=#0;
end;

procedure TForm2.LabeledEdit8KeyPress(Sender: TObject; var Key: Char);
var i:Integer;
begin
if not(Key in ['0'..'9',#8,'.'])then Key:=#0;
if (LabeledEdit8.Text='')and(Key='.')then Key:=#0;
for i:=1 to Length(LabeledEdit8.Text) do
    if(LabeledEdit8.Text[i]='.')and(Key='.')then Key:=#0;
end;

procedure TForm2.LabeledEdit9KeyPress(Sender: TObject; var Key: Char);
var i:Integer;
begin
if not(Key in ['0'..'9',#8,'.'])then Key:=#0;
if (LabeledEdit9.Text='')and(Key='.')then Key:=#0;
for i:=1 to Length(LabeledEdit9.Text) do
    if(LabeledEdit9.Text[i]='.')and(Key='.')then Key:=#0;
end;

procedure TForm2.LabeledEdit10KeyPress(Sender: TObject; var Key: Char);
var i:Integer;
begin
if not(Key in ['0'..'9',#8,'.'])then Key:=#0;
if (LabeledEdit10.Text='')and(Key='.')then Key:=#0;
for i:=1 to Length(LabeledEdit10.Text) do
    if(LabeledEdit10.Text[i]='.')and(Key='.')then Key:=#0;
end;

procedure TForm2.LabeledEdit2SubLabelClick(Sender: TObject);
begin
y0pm:=not y0pm;
if y0pm=false then LabeledEdit2.EditLabel.Caption:='НачВысота+'
              else LabeledEdit2.EditLabel.Caption:='НачВысота-';
end;

procedure TForm2.CheckBox1Click(Sender: TObject);
begin
if CheckBox1.Checked=true then Enab:=True
                     else Enab:=False;
end;

procedure TForm2.CheckBox2Click(Sender: TObject);
begin
if CheckBox2.Checked then  ris:=true
                     else  ris:=false;
end;

procedure TForm2.BitBtn2Click(Sender: TObject);
begin
Form1.Canvas.FillRect(Rect(0,0,1023,599));
Form1.Shape1.Left:=Form1.Shape1.Left+1;
Form1.Shape1.Left:=Form1.Shape1.Left-1;
end;

procedure TForm2.BitBtn3Click(Sender: TObject);
var r:TRect;
begin
R:=Rect(0,0,1023,599);
Bmp1.Canvas.CopyRect(R,Form1.Canvas,R);
if SavePictureDialog1.Execute then
    Bmp1.SaveToFile(SavePictureDialog1.FileName);
end;

procedure TForm2.PmColor1Click(Sender: TObject);
begin
if ColorDialog1.Execute then
    Form1.Canvas.Pen.Color:=ColorDialog1.Color;
end;

procedure TForm2.Line1Click(Sender: TObject);
begin
fig:=1;Maxim:=2;Label2.Caption:='Line 2';
end;

procedure TForm2.Rectangle1Click(Sender: TObject);
begin
fig:=2;Maxim:=2;Label2.Caption:='Rect 2';
end;

procedure TForm2.PmColor2Click(Sender: TObject);
begin
if ColorDialog1.Execute then
    Form1.Canvas.Brush.Color:=ColorDialog1.Color;
end;

procedure TForm2.Circle1Click(Sender: TObject);
begin
fig:=3;maxim:=2;Label2.Caption:='Circle 2';
end;

procedure TForm2.Ellipse1Click(Sender: TObject);
begin
fig:=4;maxim:=2;Label2.Caption:='Ellipse 2';
end;

procedure TForm2.Carandash1Click(Sender: TObject);
begin
fig:=5;maxim:=1;Label2.Caption:='Carand 1';
end;

procedure TForm2.Edit1KeyPress(Sender: TObject; var Key: Char);
var i:Integer;
begin
if not(Key in ['0'..'9',#8,'.'])then Key:=#0;
if (Edit1.Text='')and(Key='.')then Key:=#0;
for i:=1 to Length(Edit1.Text) do
    if(Edit1.Text[i]='.')and(Key='.')then Key:=#0;
end;

procedure TForm2.Brush1Click(Sender: TObject);
begin
fig:=6;Maxim:=1;Label2.Caption:='Brush 1';
end;

end.
