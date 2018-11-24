/////////////////  ��������-������   ///////////////////////

unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
  Grids, StdCtrls, ComCtrls, ExtCtrls, Buttons;

type
  TForm1 = class(TForm)
    Grid: TDrawGrid;
    Timer1: TTimer;
    Label1: TLabel;
    SpeedButton1: TSpeedButton;
    procedure GridDrawCell(Sender: TObject; ACol, ARow: Integer; Rect: TRect; State: TGridDrawState);
    procedure GridMouseDown(Sender: TObject; Button: TMouseButton; Shift: TShiftState; X, Y: Integer);
    procedure FormShow(Sender: TObject);
    procedure FormClick(Sender: TObject);
    procedure Timer1Timer(Sender: TObject);
    procedure SpeedButton1Click(Sender: TObject);
  private
    { Private declarations }
    Hod:integer; // 0-��� ���, 1-��� ����������
    NumHod:integer; // ����� ����
    Pole:array[-1..3,-1..3] of char;
    t:Longint;
    procedure NewGame;
    procedure Analiz(var Count,i1,j1,i2,j2:integer); // ���� �����������?
    procedure NextHod; // ��������� ��� ��� ��������� ����
    procedure CompHod; // ������ ��� �� ���������
    procedure BestHod(var BestI,BestJ,BestV:integer; player1,player2:char);
  end;

var
  Form1: TForm1;

implementation

{$R *.DFM}

//////////////////  ������  ����  ////////////////////////////

procedure TForm1.NewGame;
  var i,j:integer;
begin
  for i:=0 to 2 do
    for j:=0 to 2 do Pole[i,j]:=#0;
  Grid.Repaint;
  NumHod:=1;
  if Application.MessageBox('������ ������ ������?','��������-������',MB_YESNO)=idYes then
    Hod:=0
  else begin
    Hod:=1; CompHod;
  end;
end;

procedure TForm1.GridDrawCell(Sender: TObject; ACol, ARow: Integer;
  Rect: TRect; State: TGridDrawState);
begin
  if Pole[ACol,ARow]=#0 then Grid.Canvas.FillRect(Rect)
  else Grid.Canvas.TextOut(Rect.Left+30,Rect.Top+15,Pole[ACol,ARow]);
end;

procedure TForm1.GridMouseDown(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
  var ACol,ARow:integer;
begin
  Grid.MouseToCell(x,y,ACol,ARow);
  if Pole[ACol,ARow]=#0 then begin
    if NumHod mod 2=1 then Pole[ACol,ARow]:='X' else Pole[ACol,ARow]:='0';
    Grid.Repaint;
    NextHod;
  end else ShowMessage('��� ������ ��� ������!');
end;

procedure TForm1.Analiz(var Count,i1,j1,i2,j2:integer);
  var i,j:integer;
begin
  Count:=0; i1:=-1;
  for i:=0 to 2 do
    for j:=0 to 2 do
      if Pole[i,j]<>#0 then begin
        inc(Count);
        if (Pole[i-1,j]=Pole[i,j])and(Pole[i,j]=Pole[i+1,j]) then begin
          i1:=i-1; j1:=j; i2:=i+1; j2:=j; exit;
        end;
        if (Pole[i,j-1]=Pole[i,j])and(Pole[i,j]=Pole[i,j+1]) then begin
          i1:=i; j1:=j-1; i2:=i; j2:=j+1; exit;
        end;
        if (Pole[i-1,j-1]=Pole[i,j])and(Pole[i,j]=Pole[i+1,j+1]) then begin
          i1:=i-1; j1:=j-1; i2:=i+1; j2:=j+1; exit;
        end;
        if (Pole[i-1,j+1]=Pole[i,j])and(Pole[i,j]=Pole[i+1,j-1]) then begin
          i1:=i-1; j1:=j+1; i2:=i+1; j2:=j-1; exit;
        end;
      end;
end;

procedure TForm1.NextHod;
  var r,k,i1,j1,i2,j2,dw,dh:integer;
begin
  Analiz(k,i1,j1,i2,j2);
  if i1=-1 then begin  // ����� ��� �����������
    if k<9 then r:=3 else r:=2;
  end else begin       // ���-�� �������
    if Hod=0 then r:=4 else r:=1;
    dw:=Grid.DefaultColWidth; dh:=Grid.DefaultRowHeight;
    Grid.Canvas.Pen.Color:=clRed;
    Grid.Canvas.Pen.Width:=5;
    Grid.Canvas.MoveTo(dw*i1+dw div 2, dh*j1+dh div 2);
    Grid.Canvas.LineTo(dw*i2+dw div 2, dh*j2+dh div 2);
  end;
  // ���������� �������
  case r of
    1:begin
      ShowMessage('�� ��������...');
      Grid.Enabled:=false;
      {NewGame;}
    end;
    2:begin
      ShowMessage('�����');
      Grid.Enabled:=false;
      {NewGame;}
    end;
    3:begin
      inc(NumHod);
      Hod:=1-Hod;
      if Hod=1 then CompHod;
    end;
    4:begin
      ShowMessage('�� �������!');
      Grid.Enabled:=false;
      {NewGame;}
    end;
  end;
end;

procedure TForm1.FormShow(Sender: TObject);
begin

end;


//////////////////  ���������  ����  ////////////////////////////

procedure TForm1.CompHod;
  var i,j,v:integer;
begin
  if NumHod mod 2=1 then begin
    BestHod(i,j,v,'X','0');
    Pole[i,j]:='X';
  end else begin
    BestHod(i,j,v,'0','X');
    Pole[i,j]:='0';
  end;
  Label1.Caption:=IntToStr(v);
  Grid.Repaint;
  t:=0;
  NextHod;
end;

procedure TForm1.BestHod(var BestI,BestJ,BestV:integer; player1,player2:char);
  var i,j,CurI,CurJ,CurV:integer;
      k,i1,j1,i2,j2:integer;
begin
  // ���� �����������?
  Analiz(k,i1,j1,i2,j2);
  if t>10000 then
      begin
      t:=0;
      exit;
      end;
  if (k=9) and (i1=-1) then begin // �����
    BestV:=2;
    exit;
  end;
  if (i1>=0) then begin // ���-�� �������
    if Pole[i1,j1]=player1 then BestV:=4 else BestV:=1;
    exit;
  end;
  // ������������ ������������ ������� ����������
  BestV:=5;
  for i:=0 to 2 do
    for j:=0 to 2 do
      if Pole[i,j]=#0 then begin
        Pole[i,j]:=player1;
        BestHod(CurI,CurJ,CurV,player2,player1);
        Pole[i,j]:=#0;
        if CurV<BestV then begin
          BestI:=i; BestJ:=j;
          BestV:=CurV;
          if BestV=1 then break;
        end;
      end;
  if BestV=4 then BestV:=1
  else if BestV=1 then BestV:=4;
end;


(* �����������:
1. ��������-������ �� ����������� �����
2. ����������� �����������
3. ������� ��� (���� � �������� �����������)
4. ���� "���"
*)

procedure TForm1.FormClick(Sender: TObject);
begin
Grid.Enabled:=true;
 Grid.Canvas.Font:=Grid.Font;
  NewGame;
end;

procedure TForm1.Timer1Timer(Sender: TObject);
begin
t:=t+1;
end;

procedure TForm1.SpeedButton1Click(Sender: TObject);
begin
{ }
end;

end.
