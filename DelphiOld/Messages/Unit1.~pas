unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, StdCtrls;

type
  TForm1 = class(TForm)
    Memo1: TMemo;
    Edit1: TEdit;
    procedure AppMsgRec(var Msg:TMsg;var Handled:Boolean);
    procedure FormKeyDown(Sender: TObject; var Key: Word;
      Shift: TShiftState);
    Procedure DoEvent(msg,x,y:Integer);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  Form1: TForm1;

implementation
var t0:Integer;
{$R *.dfm}
procedure TForm1.AppMsgRec(var Msg:TMsg;var Handled:Boolean);
var t:Integer;
P:TPoint;
begin
If (Msg.message=Wm_KEYDOWN)and(Msg.wParam=27)then
    begin
    Application.OnMessage:=nil;
    Memo1.Lines.SaveToFile('Protocol.txt');
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
If Msg.message=Wm_KeyDown then
    Memo1.Lines.Add(IntToStr(t)+' '+IntToStr(Msg.message)+' '+IntToStr(Msg.wParam)+' 2');
end;

procedure TForm1.FormKeyDown(Sender: TObject; var Key: Word;
  Shift: TShiftState);
var f:TextFile;t,t1,msg,x,y:Integer;
label 1;
begin
if Key=Vk_F2 then
    begin
    t0:=GetTickCount;
    Application.OnMessage:=AppMsgRec;
    end;
if Key=Vk_F3 then
    begin
    AssignFile(f,'Protocol.txt');
    Reset(f);
    t0:=GetTickCount;
    While not eof(f) do
        begin
        readln(f,t,msg,x,y);
        1: t1:=GetTickCount;
        if t1-t0<t then goto 1; 
        DoEvent(msg,x,y);
        Application.ProcessMessages;
        end;
    CloseFile(f);
    end;
end;

Procedure TForm1.DoEvent(msg,x,y:Integer);
var flag:integer;
begin
if (Msg=WM_LbuttonDown)or (Msg=WM_RbuttonDown)or(Msg=WM_LbuttonUp)or (Msg=WM_RbuttonUp)or(Msg=WM_MouseMove)then begin
    case Msg of
    Wm_MouseMove : flag:=MouseEventF_Move or MOUSEEVENTF_ABSOLUTE ;
    Wm_LButtonDown : flag:=MOUSEEVENTF_LEFTDOWN or MOUSEEVENTF_ABSOLUTE;
    Wm_RButtonDown : flag:=MOUSEEVENTF_RIGHTDOWN or MOUSEEVENTF_ABSOLUTE;
    end;
    Mouse_Event(flag,x*65535 div Screen.Width,y*65535 div Screen.Height,0,0);
    end;
if (Msg=Wm_KeyUp) or(Msg=Wm_KeyDown)then KeyBd_Event(x,0,y,0);
end;

end.
