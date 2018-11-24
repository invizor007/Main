unit Unit2;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs,Unit1, StdCtrls, Buttons, ExtCtrls;

type
  TForm2 = class(TForm)
    LabeledEdit1: TLabeledEdit;
    LabeledEdit2: TLabeledEdit;
    BitBtn1: TBitBtn;
    BitBtn2: TBitBtn;
    Label1: TLabel;
    CheckBox1: TCheckBox;
    LabeledEdit3: TLabeledEdit;
    LabeledEdit4: TLabeledEdit;
    LabeledEdit5: TLabeledEdit;
    LabeledEdit6: TLabeledEdit;
    procedure LabeledEdit1KeyPress(Sender: TObject; var Key: Char);
    procedure LabeledEdit2KeyPress(Sender: TObject; var Key: Char);
    procedure BitBtn1Click(Sender: TObject);
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
    procedure BitBtn2Click(Sender: TObject);
    procedure CheckBox1Click(Sender: TObject);
    procedure LabeledEdit3KeyPress(Sender: TObject; var Key: Char);
    procedure LabeledEdit4KeyPress(Sender: TObject; var Key: Char);
    procedure LabeledEdit5KeyPress(Sender: TObject; var Key: Char);
    procedure LabeledEdit6KeyPress(Sender: TObject; var Key: Char);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  Form2: TForm2;

const rm=10;
var am,vm,vmx,vmy,xm,ym:real;
ar,vr,vrx,vry,xr,yr:real;
t:Integer;
x0,y0:integer;
implementation

{$R *.dfm}

procedure TForm2.LabeledEdit1KeyPress(Sender: TObject; var Key: Char);
begin
if not(key in ['0'..'9',#8,'.'])then key:=#0;
if (key='.')and((pos('.',LabeledEdit1.Text)<>0)or(LabeledEdit2.Text=''))
  then key:=#0;
end;

procedure TForm2.LabeledEdit2KeyPress(Sender: TObject; var Key: Char);
begin
if not(key in ['0'..'9',#8,'.'])then key:=#0;
if (key='.')and((pos('.',LabeledEdit2.Text)<>0)or(LabeledEdit2.Text=''))
  then key:=#0;
end;

procedure TForm2.BitBtn1Click(Sender: TObject);
var s:string;
begin
t:=0;
if LabeledEdit1.Text='' then LabeledEdit1.Text:='1';
s:=LabeledEdit1.Text;
if s[length(s)]='.' then Delete(s,Length(s),1);
LabeledEdit1.Text:=s;

if LabeledEdit2.Text='' then LabeledEdit2.Text:='1';
s:=LabeledEdit2.Text;
if s[length(s)]='.' then Delete(s,Length(s),1);
LabeledEdit2.Text:=s;

vm:=StrToFloat(LabeledEdit1.Text);
vr:=StrToFloat(LabeledEdit2.Text);

Form1.Timer1.Enabled:=true;
BitBtn1.Enabled:=false;
BitBtn2.Enabled:=true;

if CheckBox1.Checked then
  begin
  if LabeledEdit3.Text='' then LabeledEdit3.Text:='100';
  if LabeledEdit4.Text='' then LabeledEdit4.Text:='100';
  if LabeledEdit5.Text='' then LabeledEdit5.Text:='200';
  if LabeledEdit6.Text='' then LabeledEdit6.Text:='200';
  Form1.Shape1.Left:=StrToInt(LabeledEdit3.Text);
  Form1.Shape1.Top:=StrToInt(LabeledEdit4.Text);
  Form1.Shape2.Left:=StrToInt(LabeledEdit5.Text);
  Form1.Shape2.Top:=StrToInt(LabeledEdit6.Text);
  end;

if round(xm)<>Form1.Shape1.Left then xm:=Form1.Shape1.Left;
if round(ym)<>Form1.Shape1.Top then ym:=Form1.shape1.Top;
if round(xr)<>Form1.Shape2.Left then xr:=Form1.Shape2.Left;
if round(yr)<>Form1.Shape2.Top then yr:=Form1.shape2.Top;
end;

procedure TForm2.FormClose(Sender: TObject; var Action: TCloseAction);
begin
Form1.Close;
end;

procedure TForm2.BitBtn2Click(Sender: TObject);
begin
Form1.Timer1.Enabled:=false;
BitBtn1.Enabled:=true;
BitBtn2.Enabled:=false;
end;

procedure TForm2.CheckBox1Click(Sender: TObject);
begin
LabeledEdit3.Enabled:=CheckBox1.Checked;
LabeledEdit4.Enabled:=CheckBox1.Checked;
LabeledEdit5.Enabled:=CheckBox1.Checked;
LabeledEdit6.Enabled:=CheckBox1.Checked;
end;

procedure TForm2.LabeledEdit3KeyPress(Sender: TObject; var Key: Char);
begin
if not (key in['0'..'9',#8])then key:=#0;
end;

procedure TForm2.LabeledEdit4KeyPress(Sender: TObject; var Key: Char);
begin
if not (key in['0'..'9',#8])then key:=#0;
end;

procedure TForm2.LabeledEdit5KeyPress(Sender: TObject; var Key: Char);
begin
if not (key in['0'..'9',#8])then key:=#0;
end;

procedure TForm2.LabeledEdit6KeyPress(Sender: TObject; var Key: Char);
begin
if not (key in['0'..'9',#8])then key:=#0;
end;

end.
