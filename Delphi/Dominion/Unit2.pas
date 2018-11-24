unit Unit2;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, Buttons, StdCtrls, ExtCtrls;

const
  AllBuildingNames : array [0..24] of String =
    ('71 - мастерска€', '72 - лесоруб', '73 - ведьма', '74 - деревн€',
    '75 - тронный зал', '76 - вор', '77 - шпион', '78 - кузница', '79 - сады',
    '81 - реконструкци€', '82 - ростовщик', '83 - рудник','84 - ополчение',
    '85 - рынок', '86 - библиотека', '87 - лаборатори€', '88 - фестиваль',
    '91 - пир', '92 - зал совета', '93 - часовн€', '94 - канцлер',
    '95 - погреба', '96 - чиновник', '97 - искатель приключений', '98 - ров');

type
  TForm2 = class(TForm)
    ListBox1: TListBox;
    ListBox2: TListBox;
    SBMoveTo: TSpeedButton;
    SBMoveFrom: TSpeedButton;
    SBOK: TSpeedButton;
    SBCancel: TSpeedButton;
    LEPlayerCount: TLabeledEdit;
    CBNameSet: TComboBox;
    LaLB2Count: TLabel;
    OpenDialog1: TOpenDialog;
    SaveDialog1: TSaveDialog;
    SBFileLoad: TSpeedButton;
    SBFileSave: TSpeedButton;
    procedure FormCreate(Sender: TObject);
    procedure SBOKClick(Sender: TObject);
    procedure SBCancelClick(Sender: TObject);
    procedure SBFileLoadClick(Sender: TObject);
    procedure SBFileSaveClick(Sender: TObject);
    procedure SBMoveToClick(Sender: TObject);
    procedure SBMoveFromClick(Sender: TObject);
    procedure CBNameSetChange(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  Form2: TForm2;

  Settings:array[0..9,0..9]of integer;
  SettingNames:array[0..9]of String;
  tf:Text;
  CurrSettingsNum:integer;
  PlayerCount:integer;

function GetCode(name:string):integer;
function IsInArray(value,index:integer):boolean;
function MakeStringByCode(code:integer):string;
procedure LoadFromFile(filename:string);
procedure SaveToFile(filename:string);


implementation

function GetCode(name:string):integer;
var a,b:integer;
begin
a:=ord(name[1])-ord('0');
b:=ord(name[2])-ord('0');
result:=a*10+b;
end;

function IsInArray(value,index:integer):boolean;
var i:integer;
begin
result:=false;
for i:=0 to 9 do
        if Settings[index,i]=value then  result:=true;
end;

function MakeStringByCode(code:integer):string;
var i:integer;
begin
result:='';
for i:=0 to 24 do
        if GetCode(AllBuildingNames[i]) = code then
                result:=AllBuildingNames[i];
end;

procedure LoadFromFile(filename:string);
var i,j:integer;
begin
assignfile(tf,FileName);
reset(tf);
for i:=0 to 9 do
        begin
        for j:=0 to 9 do
                read(tf,Settings[i,j]);
        readln(tf,SettingNames[i]);
        end;
closefile(tf);
end;

procedure SaveToFile(filename:string);
var i,j:integer;
begin
assignfile(tf,FileName);
rewrite(tf);
for i:=0 to 9 do
        begin
        for j:=0 to 9 do
                write(tf,Settings[i,j]);
        writeln(tf,SettingNames[i]);
        end;
closefile(tf);
end;

{$R *.dfm}

procedure TForm2.FormCreate(Sender: TObject);
var i,v:integer;
begin
LoadFromFile('Settings.txt');

for i:=0 to 24 do
        ListBox1.Items.Add(AllBuildingNames[i]);

for i:=0 to 24 do
        begin
        v:=GetCode(AllBuildingNames[i]);
        if IsInArray(v,0) then ListBox2.Items.Add(AllBuildingNames[i]);
        end;

CBNameSet.Items.Clear;
for i:=0 to 9 do
        CBNameSet.Items.Add(SettingNames[i]);
CBNameSet.ItemIndex:=0;
PlayerCount:=3;
end;

procedure TForm2.SBOKClick(Sender: TObject);
var i,tmp,c:integer;
begin
if CBNameSet.ItemIndex=-1 then exit;
if ListBox2.Items.Count<>10 then exit;

val(LEPlayerCount.Text,tmp,c);
if (tmp < 2) or (tmp > 5) or (c<>0) then
        begin
        Showmessage('¬ведите число от 2 до 5');
        exit;
        end;
PlayerCount:=tmp;

CurrSettingsNum:=CBNameSet.ItemIndex;

for i:=0 to 9 do
        Settings[CurrSettingsNum,i]:=GetCode(ListBox2.Items[i]);
end;

procedure TForm2.SBCancelClick(Sender: TObject);
var i,v:integer;
begin
if CBNameSet.ItemIndex=-1 then exit;

LEPlayerCount.Text:=IntToStr(PlayerCount);
v:=CBNameSet.ItemIndex;

ListBox2.Items.Clear;
for i:=0 to 9 do
        ListBox2.Items.Add(MakeStringByCode(Settings[v,i]));
LaLB2Count.Caption:=IntToStr(ListBox2.Items.Count);
end;

procedure TForm2.SBFileLoadClick(Sender: TObject);
begin
if OpenDialog1.Execute then
        LoadFromFile(OpenDialog1.FileName);
end;

procedure TForm2.SBFileSaveClick(Sender: TObject);
begin
if SaveDialog1.Execute then
        SaveToFile(SaveDialog1.FileName);
end;

procedure TForm2.SBMoveToClick(Sender: TObject);
var v,i,index:integer;
begin
if ListBox1.ItemIndex = -1 then exit;
v:=GetCode(ListBox1.Items[ListBox1.ItemIndex]);

index:=0;
for i:=0 to ListBox2.Items.Count-1 do
        begin
        if v>GetCode(ListBox2.Items[i]) then index:=index+1
        else if v=GetCode(ListBox2.Items[i]) then index:=-1
        else break;
        end;

if index = -1 then exit; //LB2[index] первое большее чем v
ListBox2.Items.Add(' ');
for i:=ListBox2.Items.Count-1 downto index+1 do
        ListBox2.Items[i]:=ListBox2.Items[i-1];
ListBox2.Items[index]:=ListBox1.Items[ListBox1.ItemIndex];

LaLB2Count.Caption:=IntToStr(ListBox2.Items.Count);
end;

procedure TForm2.SBMoveFromClick(Sender: TObject);
begin
if ListBox2.ItemIndex = -1 then exit;
ListBox2.Items.Delete(ListBox2.ItemIndex);
LaLB2Count.Caption:=IntToStr(ListBox2.Items.Count);
end;

procedure TForm2.CBNameSetChange(Sender: TObject);
var i,v:integer;
begin
ListBox2.Items.Clear;
for i:=0 to 24 do
        begin
        v:=GetCode(AllBuildingNames[i]);
        if IsInArray(v,CBNameSet.ItemIndex) then ListBox2.Items.Add(AllBuildingNames[i]);
        end;
CurrSettingsNum:=CBNameSet.ItemIndex;
end;

end.


