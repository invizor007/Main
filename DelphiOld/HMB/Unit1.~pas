unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, Grids, ValEdit, ComCtrls, StdCtrls,Math, ExtCtrls;
type
  Tm=record
  count,h,hc,ho:Integer;
  umax,umin:real;
  end;

  TForm1 = class(TForm)
    Button1: TButton;
    Label2: TLabel;
    ProgressBar1: TProgressBar;
    ProgressBar2: TProgressBar;
    ValueListEditor1: TValueListEditor;
    ValueListEditor2: TValueListEditor;
    Button2: TButton;
    Edit1: TEdit;
    Edit2: TEdit;
    Timer1: TTimer;
    CheckBox1: TCheckBox;
    CheckBox2: TCheckBox;
    procedure Button1Click(Sender: TObject);
    procedure Button2Click(Sender: TObject);
    procedure FormCreate(Sender: TObject);
    procedure Timer1Timer(Sender: TObject);

  private
    { Private declarations }
  public
    { Public declarations }
  end;

procedure SaveTmInf(VLE:TValueListEditor;var m:Tm);
procedure LoadTmInf(m:Tm;var VLE:TValueListEditor);
function RndB(urmin,urmax:real):integer;
var
  Form1: TForm1;

implementation

var m1,m2:Tm;
maxcnt:Integer;
{$R *.dfm}
procedure LoadTmInf(m:Tm;var VLE:TValueListEditor);
begin
if m.count>0 then VLE.Cells[1,1]:=IntToStr(m.count)
             else VLE.Cells[1,1]:='0';
VLE.Cells[1,5]:=IntToStr(m.hc);
end;

procedure SaveTmInf(VLE:TValueListEditor;var m:Tm);
begin
m.count:=StrToInt(VLE.Cells[1,1]);
m.umax:=StrToFloat(VLE.Cells[1,2]);
m.umin:=StrToFloat(VLE.Cells[1,3]);
m.h:=StrToInt(VLE.Cells[1,4]);
m.hc:=m.h;
m.ho:=m.count*m.h;
end;

function RndB(urmin,urmax:real):integer;
begin
if round(urmin)=round(urmax) then RndB:=round(urmin)
               else RndB:=Round(urmin+random*(urmax-urmin));
end;

procedure TForm1.Button1Click(Sender: TObject);
begin
Button2.Enabled:=true;
SaveTmInf(ValueListEditor1,m1);
SaveTmInf(ValueListEditor2,m2);
if CheckBox2.Checked then
  begin
  m1.count:=StrToInt(Edit1.Text);
  m2.count:=StrToInt(Edit2.Text);
  m1.ho:=m1.count*m1.h;
  m2.ho:=m2.count*m2.h;
  end;
maxcnt:=Max(m1.count,m2.count);
ProgressBar1.Max:=maxcnt;
ProgressBar2.Max:=maxcnt;
ProgressBar1.Position:=m1.count;
ProgressBar2.Position:=m2.count;
end;

procedure TForm1.Button2Click(Sender: TObject);
begin
m1.ho:=m1.ho-RndB(m2.umin*m2.count,m2.umax*m2.count);
m2.ho:=m2.ho-RndB(m1.umin*m1.count,m1.umax*m1.count);
if(m1.ho<=0)or(m2.ho<=0)then
  begin
  Button2.Enabled:=false;
  end;
m1.count:=((m1.ho-1) div m1.h)+1;
m1.hc:=m1.ho-((m1.count-1)*m1.h);
m2.count:=((m2.ho-1) div m2.h)+1;
m2.hc:=m2.ho-((m2.count-1)*m2.h);
LoadTminf(m1,ValueListEditor1);
LoadTminf(m2,ValueListEditor2);
ProgressBar1.Position:=m1.count;
ProgressBar2.Position:=m2.count;
end;

procedure TForm1.FormCreate(Sender: TObject);
begin
randomize;
end;

procedure TForm1.Timer1Timer(Sender: TObject);
begin
if(CheckBox1.Checked)and(Button2.Enabled)then Button2.Click;
end;

end.
