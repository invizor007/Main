unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, StdCtrls, ExtCtrls, Buttons;

type
  TForm1 = class(TForm)
    Memo1: TMemo;
    Edit1: TEdit;
    Label1: TLabel;
    Label2: TLabel;
    SpeedButton1: TSpeedButton;
    SpeedButton2: TSpeedButton;
    SpeedButton3: TSpeedButton;
    Label3: TLabel;
    Memo2: TMemo;
    ComboBox1: TComboBox;
    Label4: TLabel;
    SpeedButton4: TSpeedButton;
    procedure AppMsgRec(var Msg:TMsg;var Handled:Boolean);
    procedure FormKeyDown(Sender: TObject; var Key: Word;
      Shift: TShiftState);
    Procedure DoEvent(msg,x,y:Integer);
    procedure keymouse_record(Sender: TObject);
    procedure keymouse_repeat(Sender: TObject);
    procedure stop_click(Sender: TObject);
    procedure delete_protocol(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  Form1: TForm1;

implementation
var t0:Cardinal;
f:Textfile;
recordpressed,repeatpressed,exitpressed:boolean;
{$R *.dfm}

procedure TForm1.AppMsgRec(var Msg:TMsg;var Handled:Boolean);
var t:Integer;
P:TPoint;
begin
If ((Msg.message=Wm_KEYDOWN)and(Msg.wParam=27)) or (exitpressed) then
    begin
    Application.OnMessage:=nil;
    Memo1.Lines.SaveToFile('Protocol.txt');
    Showmessage('Запись сделана');
    recordpressed:=false;
    SpeedButton1.Enabled:=true;
    exit;
    end;
    
t:=GetTickCount-t0;
if (Msg.message=Wm_LButtonDown)or(Msg.message=Wm_LButtonUp)or(Msg.message=Wm_RButtonDown)or(Msg.message=Wm_RButtonUp)or(msg.message=Wm_MouseMove)then
    begin
    GetCursorPos(p);
    Memo1.Lines.Add(IntToStr(t)+' '+IntToStr(Msg.message)+' '+IntToStr(p.X)+' '+IntToStr(p.Y));
    end;
    
If Msg.message=Wm_KeyDown then
    Memo1.Lines.Add(IntToStr(t)+' '+IntToStr(Msg.message)+' '+IntToStr(Msg.wParam)+' 0');
If Msg.message=Wm_KeyUp then
    Memo1.Lines.Add(IntToStr(t)+' '+IntToStr(Msg.message)+' '+IntToStr(Msg.wParam)+' 2');
end;

procedure TForm1.FormKeyDown(Sender: TObject; var Key: Word;
  Shift: TShiftState);
begin
if Key=Vk_F2 then
    keymouse_record(SpeedButton1);
if Key=Vk_F3 then
    keymouse_repeat(SpeedButton2);
if Key=VK_ESCAPE then
    stop_click(SpeedButton3);
end;

Procedure TForm1.DoEvent(msg,x,y:Integer);
var flag:integer;
begin
if (Msg=WM_LbuttonDown)or (Msg=WM_RbuttonDown)or(Msg=WM_LbuttonUp)or (Msg=WM_RbuttonUp)or(Msg=WM_MouseMove)then begin
    case Msg of
    Wm_MouseMove : flag:=MouseEventF_Move or MOUSEEVENTF_ABSOLUTE ;
    Wm_LButtonDown : flag:=MOUSEEVENTF_LEFTDOWN or MOUSEEVENTF_ABSOLUTE;
    Wm_RButtonDown : flag:=MOUSEEVENTF_RIGHTDOWN or MOUSEEVENTF_ABSOLUTE;
    Wm_LButtonUp : flag:=MOUSEEVENTF_LEFTUP or MOUSEEVENTF_ABSOLUTE;
    Wm_RButtonUp : flag:=MOUSEEVENTF_RIGHTUP or MOUSEEVENTF_ABSOLUTE;
    else flag:=MouseEventF_Move or MOUSEEVENTF_ABSOLUTE;
    end;
    Mouse_Event(flag,x*65535 div Screen.Width,y*65535 div Screen.Height,0,0);
    end;
if (Msg=Wm_KeyUp) or(Msg=Wm_KeyDown)then KeyBd_Event(x,0,y,0);
end;

procedure TForm1.keymouse_record(Sender: TObject);
begin
if repeatpressed then
        begin
        showmessage('Запись еще идет, завершите ее ESC');
        exit;
        end;
SpeedButton1.Enabled:=false;
recordpressed:=true;
exitpressed:=false;
t0:=GetTickCount;
Application.OnMessage:=AppMsgRec;
end;


procedure TForm1.keymouse_repeat(Sender: TObject);
var msg,x,y:Integer;
t,t1:Cardinal;
begin
if recordpressed then
        begin
        showmessage('Воспроизведение еще идет, завершите ее ESC');
        exit;
        end;
SpeedButton2.Enabled:=false;
repeatpressed:=true;
exitpressed:=false;
AssignFile(f,'Protocol.txt');
Reset(f);
t0:=GetTickCount;
While not eof(f) and not exitpressed do
        begin
        readln(f,t,msg,x,y);
        repeat
        t1:=GetTickCount;
        Application.ProcessMessages;
        until t1-t0>=t;
        DoEvent(msg,x,y);
        end;
CloseFile(f);
ShowMessage('Воспроизведение завершилось');
repeatpressed:=false;
SpeedButton2.Enabled:=true;
end;

procedure TForm1.stop_click(Sender: TObject);
begin
exitpressed:=true;
end;

procedure TForm1.delete_protocol(Sender: TObject);
begin
AssignFile(f,'Protocol.txt');
Rewrite(f);
CloseFile(f);
Showmessage('Протокол удален');
end;

end.
