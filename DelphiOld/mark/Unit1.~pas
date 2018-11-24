unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, Grids, StdCtrls, Buttons, ExtCtrls;

type
  TForm1 = class(TForm)
    Edit1: TEdit;
    StringGrid1: TStringGrid;
    SpeedButton1: TSpeedButton;
    CheckBox1: TCheckBox;
    Timer1: TTimer;
    SpeedButton2: TSpeedButton;
    Edit2: TEdit;
    Label1: TLabel;
    Label2: TLabel;
    procedure StringGrid1KeyPress(Sender: TObject; var Key: Char);
    procedure SpeedButton1Click(Sender: TObject);
    procedure Timer1Timer(Sender: TObject);
    procedure SpeedButton2Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  Form1: TForm1;

implementation
type es=record
e:boolean;
s:string;
end;
{$R *.dfm}
function StrToES(s:string):ES;
begin
if s<>'' then if s[1]='.' then
  begin
  StrToes.e:=true;
  delete(s,1,1);
  end else StrToes.e:=false;
StrToes.s:=s;
end;

procedure TForm1.StringGrid1KeyPress(Sender: TObject; var Key: Char);
begin
if key=#1 then StringGrid1.RowCount:=StringGrid1.RowCount+1;
if key=#17 then StringGrid1.RowCount:=StringGrid1.RowCount-1;
end;

procedure TForm1.SpeedButton1Click(Sender: TObject);
var i,p:integer;
s:string;
begin
i:=0;
with StringGrid1 do
  begin
  s:=Edit1.Text;
  while (pos(Cells[0,i],s)=0)and(i<RowCount)and(cells[0,i]<>'') do i:=i+1;
  if i=RowCount then i:=i-1;
  if (pos(Cells[0,i],s)=0)and(cells[0,i]<>'') then
    begin
    CheckBox1.Checked:=false;
    SpeedButton1.Enabled:=false;
    end
                       else
    begin
    if (StrtoES(cells[0,i]).s='') then s:=StrtoES(cells[1,i]).s+s
                       else
      begin
      p:=pos(Cells[0,i],s);
      delete(s,p,length(cells[0,i]));
      insert(StrToES(Cells[1,i]).s,s,p);
      end;
    if StrToES(Cells[1,i]).e then
      begin
      SpeedButton1.Enabled:=false;
      CheckBox1.Checked:=false;
      CheckBox1.Visible:=false;
      end;
    if s='' then
      begin
      CheckBox1.Checked:=false;
      SpeedButton1.Enabled:=false;
      end;
    Edit1.Text:=s;
    end;
  end;
end;

procedure TForm1.Timer1Timer(Sender: TObject);
begin
if CheckBox1.Checked then SpeedButton1Click(Form1);
end;

procedure TForm1.SpeedButton2Click(Sender: TObject);
begin
Edit2.Text:=Edit1.Text;
SpeedButton1.Enabled:=true;
CheckBox1.Visible:=true;
end;

end.
