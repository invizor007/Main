unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, ExtCtrls, Buttons;

const size=30;
type
  TMap=class (TObject)
  private
  a:array[0..15,0..15]of TImage;
  public
  constructor Create(Parent:TObject);
  destructor Free;
  procedure Show;
  procedure ImageClick(Sender:TObject);
  end;

  TForm1 = class(TForm)
    SpeedButton1: TSpeedButton;
    SpeedButton2: TSpeedButton;
    procedure FormCreate(Sender: TObject);
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
    procedure SpeedButton1Click(Sender: TObject);
    
  private
    { Private declarations }
  public
    { Public declarations }
  end;
//для отображение символа unitcode анализируется сдвиг по клику
var
  Form1: TForm1;
  Map1:TMap;
  old:byte;
  IsUnic:byte;

implementation
{$R *.dfm}

constructor TMap.Create(Parent:TObject);
var i,j:integer;
begin
for i:=0 to 15 do for j:=0 to 15 do
        begin
        a[i,j]:=TImage.Create(TComponent(Parent));
        a[i,j].Parent:=TWinControl(Parent);
        a[i,j].Width:=size;
        a[i,j].Height:=size;
        a[i,j].Left:=size*i;
        a[i,j].Top:=size*j;
        a[i,j].Tag:=i*16+j;
        a[i,j].OnClick:=ImageClick;
        end;
end;

procedure TMap.ImageClick(Sender:TObject);
begin
if IsUnic=1 then
        begin
        old:=TImage(Sender).Tag;
        Show;
        ShowMessage('Сдвиг '+inttoStr(256*old));
        end;
end;

destructor TMap.Free;
var i,j:integer;
begin
for i:=0 to 15 do for j:=0 to 15 do
        a[i,j].Free;
end;

procedure TMap.Show;
type
  TWideChar = packed record
    case Byte of
      0: (WideChar: WideChar);
      1: (Code: Word);
  end;
var
wChar: TWideChar;
wString:WideString;
i,j:integer;
ch:char;
begin
for i:=0 to 15 do for j:=0 to 15 do
        begin
        ch:=chr(i shl 4 +j);
        WString:='s';
        WString[1]:=widechar(i shl 4 +j+old shl 8);
        if IsUnic=1 then
                a[i,j].Canvas.TextOut(0,0,WString)
        else
                a[i,j].Canvas.TextOut(0,0,ch);
        a[i,j].Hint:=IntToStr(i shl 4 +j);
        a[i,j].ShowHint:=true;
        a[i,j].Show;
        end;
end;

procedure TForm1.FormCreate(Sender: TObject);
begin
Map1:=TMap.Create(Form1);Map1.Show;
end;

procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
begin
Map1.Free;
end;

procedure TForm1.SpeedButton1Click(Sender: TObject);
begin
IsUnic:=(TSpeedButton(Sender).Tag);
Map1.Show;
end;

end.
