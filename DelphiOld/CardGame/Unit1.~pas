unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, Grids, Buttons, StdCtrls, ExtCtrls, Math;

type
card=record
v,m:integer;
end;

colod=record
a:array[0..35] of card;
size:integer;
end;

  TForm1 = class(TForm)
    DrawGrid1: TDrawGrid;
    DrawGrid2: TDrawGrid;
    SpeedButton1: TSpeedButton;
    SpeedButton2: TSpeedButton;
    SpeedButton3: TSpeedButton;
    SpeedButton4: TSpeedButton;
    Label1: TLabel;
    SpeedButton5: TSpeedButton;
    DrawGrid3: TDrawGrid;
    DrawGrid4: TDrawGrid;
    SpeedButton6: TSpeedButton;
    SpeedButton7: TSpeedButton;
    OpenDialog1: TOpenDialog;
    SaveDialog1: TSaveDialog;
    CheckBox1: TCheckBox;
    CheckBox2: TCheckBox;
    Timer1: TTimer;
    SpeedButton8: TSpeedButton;
    SpeedButton9: TSpeedButton;
    procedure FormCreate(Sender: TObject);
    procedure DrawGrid1DrawCell(Sender: TObject; ACol, ARow: Integer;
      Rect: TRect; State: TGridDrawState);
    procedure DrawGrid2DrawCell(Sender: TObject; ACol, ARow: Integer;
      Rect: TRect; State: TGridDrawState);
    procedure SpeedButton4Click(Sender: TObject);
    procedure outinf;
    procedure DrawGrid3DrawCell(Sender: TObject; ACol, ARow: Integer;
      Rect: TRect; State: TGridDrawState);
    procedure DrawGrid1DblClick(Sender: TObject);

    procedure out_colod(Dg:TDrawGrid;co:colod);
    procedure first_hod(fh:boolean);
    procedure DrawGrid2DblClick(Sender: TObject);
    procedure SpeedButton1Click(Sender: TObject);
    procedure SpeedButton2Click(Sender: TObject);
    procedure SpeedButton3Click(Sender: TObject);
    procedure SpeedButton5Click(Sender: TObject);
    procedure DrawGrid3DblClick(Sender: TObject);
    procedure DrawGrid4DblClick(Sender: TObject);
    procedure DrawGrid4DrawCell(Sender: TObject; ACol, ARow: Integer;
      Rect: TRect; State: TGridDrawState);
    procedure SpeedButton6Click(Sender: TObject);
    procedure SpeedButton7Click(Sender: TObject);
    procedure Timer1Timer(Sender: TObject);
    procedure CheckBox1Click(Sender: TObject);
    procedure CheckBox2Click(Sender: TObject);
    procedure SpeedButton8Click(Sender: TObject);
    procedure Set_Widths;
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
    procedure check_win;
    procedure FormClick(Sender: TObject);
    procedure SpeedButton9Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  Form1: TForm1;

implementation

{$R *.dfm}

var
full:array [0..35]of integer;//1-is -0 -no
c,c1,c2,ci1,ci2,cg,ce:colod;
//l:tlist;
bmp:tbitmap;
f:text;
hod,kon,currig:integer;//kon v hode
stat:integer;//0-sbros,1-otbit,2-zabrat 3-first hod
eop:integer;//0 if operation is not end
comp:array[0..1] of integer;//0 if human 1 if comp
reta:array[0..35] of integer;

function to_card(i:integer):card;
begin
to_card.v:=i div 4 +6;
to_card.m:=i mod 4;
end;
//beat and throw
function can_beat(ca1,ca2:card):boolean;
begin
if (ca2.v>ca1.v) and(ca2.m=ca1.m) then can_beat:=true
else if (ca2.m=3)and(ca1.m<>3) then can_beat:=true
else can_beat:=false;
end;
//ret-number of card in co which can beat ca
function can_cbeat(ca:card;co:colod;var ret:integer):boolean;
var i:integer;
res:boolean;
begin
res:=false;
for i:=0 to co.size-1 do
        begin
        if can_beat(ca,co.a[i])and(res=false) then
                begin
                res:=true;
                ret:=i;
                end else
        if  (can_beat(ca,co.a[i]))and(can_beat(co.a[i],co.a[ret]))and(res=true) then
                ret:=i;
        end;
can_cbeat:=res;
end;

function can_throw(ca:card):boolean;
var ret:boolean;i:integer;
begin
ret:=false;
for i:=0 to cg.size do
        if cg.a[i].v=ca.v then ret:=true;
can_throw:=ret;
end;
//reta[i]=1 if can_throw by i
function can_cthrow(co:colod):boolean;
var res:boolean;
i:integer;
begin
res:=false;
for i:=0 to 35 do reta[i]:=0;
for i:=0 to co.size-1 do
        if can_throw(co.a[i])and(co.a[i].m<>3) then
                begin
                reta[i]:=1;
                res:=true;
                end;
can_cthrow:=res;
end;
//sbros kozyrey
function can_cthrow2(co:colod;var ret:integer):boolean;
var res:boolean;
i,mi:integer;//mi-index of min
begin
res:=false;mi:=15;
for i:=0 to co.size-1 do
        if can_throw(co.a[i])and(co.a[i].m=3)and(co.a[i].v<mi) then
                begin
                ret:=i;
                res:=true;
                mi:=co.a[i].v;
                end;
can_cthrow2:=res;
end;
//comp choose card for first hod
function cmfh(co:colod):integer;
var mv,mi,i:integer;//min value and min index
begin
mv:=100;
for i:=0 to co.size-1 do
        if co.a[i].v+10*(co.a[i].m div 3)<mv then
                begin
                mi:=i;
                mv:=co.a[i].v+10*(co.a[i].m div 3);
                end;
cmfh:=mi;
end;

function to_fs(ca:card):string;
begin
to_fs:='bmp/'+inttostr(ca.v)+'_'+inttostr(ca.m)+'.bmp';
end;
//save/load
procedure savecolod(co:colod);
var i:integer;
begin
writeln(f,co.size);
for i:=0 to co.size do
        writeln(f,co.a[i].v,' ',co.a[i].m);
end;

procedure loadcolod(var co:colod);
var i:integer;
begin
readln(f,co.size);
for i:=0 to co.size do
        readln(f,co.a[i].v,co.a[i].m);
end;

function ss(s:integer):string;//stat string
begin
if s=-1 then ss:='Ничего'
//else if s=-2 then ss:='do hod'
else if s=0 then ss:='Сброс'
else if s=1 then ss:='Отбить'
else if s=2 then ss:='Забрать'
else if s=3 then ss:='Первый ход'
end;
//moving of card from place fp of cf to end of ct
procedure cmove(var cf,ct:colod;fp:integer);
var ca:card;
i:integer;
begin
if cf.size=0 then exit;
ca.v:=cf.a[fp].v;
ca.m:=cf.a[fp].m;
cf.size:=cf.size-1;
for i:=fp to cf.size-1 do
        cf.a[i]:=cf.a[i+1];
cf.a[cf.size].v:=0;
cf.a[cf.size].m:=0;

ct.size:=ct.size+1;
ct.a[ct.size-1].v:=ca.v;
ct.a[ct.size-1].m:=ca.m;
end;
//moving all cards in colod
procedure comove(var cf,ct:colod);
begin
while (cf.size<>0) do
        cmove(cf,ct,0);
end;
//obratnoe movanie,from colod from(not) last to colod to
procedure obcmove(var cfl,cfnl,ct:colod);
var i,j:integer;
begin
i:=0;
while(cfl.size>0)or(cfnl.size>0) do
        begin
        for j:=0 to ct.size-1 do ct.a[j+1]:=ct.a[j];
        ct.size:=ct.size+1;
        if i mod 2 =0 then
                begin
                ct.a[0].v:=cfl.a[cfl.size-1].v;
                ct.a[0].m:=cfl.a[cfl.size-1].m;
                cfl.size:=cfl.size-1;
                end else
                begin
                ct.a[0].v:=cfl.a[cfnl.size-1].v;
                ct.a[0].m:=cfl.a[cfnl.size-1].m;
                cfnl.size:=cfnl.size-1;
                end;
        i:=i+1;
        end;
end;
//dobrat karty do nedostayushih count
procedure taketo7(var cf,ct:colod;count:integer);
begin
while (ct.size<count)and(cf.size>0) do
        cmove(cf,ct,0);
end;
//outinf
procedure TForm1.outinf;
begin
Caption:='Кон '+inttostr(kon)+'.  Ход='+inttostr(hod)+'.  Игрок='+
        inttostr(currig)+'.   Осталось карт:'+inttostr(c.size)+' '+inttostr(c1.size) +' '+inttostr(c2.size);
Label1.Caption:=ss(stat)+' '+inttostr(eop);
end;

procedure TForm1.out_colod(Dg:TDrawGrid;co:colod);
var i:integer;
begin
Dg.ColCount:=co.size;
Dg.Width:=Dg.DefaultColWidth*min(7,co.size)+9;//??
Dg.Repaint;
end;

procedure TForm1.first_hod(fh:boolean);
begin
DrawGrid1.Visible:=currig=1;
DrawGrid2.Visible:=currig=2;

SpeedButton1.Visible:=not fh;
SpeedButton2.Visible:=not fh;
SpeedButton3.Visible:=not fh;
SpeedButton4.Visible:=fh;

SpeedButton5.Visible:=false;
eop:=0;
end;
//FORMCREATE
procedure TForm1.FormCreate(Sender: TObject);
var count,r:integer;
i:integer;
begin
Bmp:=TBitmap.Create;
bmp.Width:=DrawGrid1.DefaultColWidth;
bmp.Height:=DrawGrid1.DefaultRowHeight;
randomize;//tus
count:=0;
for i:=0 to 1 do comp[i]:=0;
for i:=0 to 35 do full[i]:=0;
while count<36 do
    begin
    repeat
    r:=random(36);
    until full[r]=0;
    full[r]:=1;
    c.a[count].v:=to_card(r).v;
    c.a[count].m:=to_card(r).m;
    count:=count+1;
    end;
c1.size:=7;c2.size:=7;c.size:=22;cg.size:=0;ce.size:=0;ci1.size:=0;ci2.size:=0;
hod:=0;kon:=1;currig:=1;stat:=-1;eop:=0;
for i:=0 to 6 do
        begin
        c1.a[i].v:=c.a[22+i].v;
        c1.a[i].m:=c.a[22+i].m;
        c2.a[i].v:=c.a[29+i].v;
        c2.a[i].m:=c.a[29+i].m;
        end;     
//DrawGrid1.ColCount:=c1.size;
//DrawGrid2.ColCount:=c2.size;
//DrawGrid3.ColCount:=cg.size;
//DrawGrid4.ColCount:=ce.size;
set_widths;
first_hod(true);
outinf;        
end;
//DRAWCELL
procedure TForm1.DrawGrid1DrawCell(Sender: TObject; ACol, ARow: Integer;
  Rect: TRect; State: TGridDrawState);
begin
if acol<c1.size then
        Bmp.LoadFromFile(to_fs(c1.a[acol]))
else
        Bmp.Canvas.FillRect(Classes.Rect(0,0,TDrawGrid(Sender).DefaultColWidth,TDrawGrid(Sender).DefaultRowHeight));
DrawGrid1.Canvas.Draw(rect.Left,rect.Top,bmp);
end;

procedure TForm1.DrawGrid2DrawCell(Sender: TObject; ACol, ARow: Integer;
  Rect: TRect; State: TGridDrawState);
begin
if acol<c2.size then
        Bmp.LoadFromFile(to_fs(c2.a[acol]))
else
        Bmp.Canvas.FillRect(Classes.Rect(0,0,TDrawGrid(Sender).DefaultColWidth,TDrawGrid(Sender).DefaultRowHeight));
DrawGrid2.Canvas.Draw(rect.Left,rect.Top,bmp);
end;

procedure TForm1.DrawGrid3DrawCell(Sender: TObject; ACol, ARow: Integer;
  Rect: TRect; State: TGridDrawState);
begin
if (cg.size>0)and(acol<cg.size) then
        Bmp.LoadFromFile(to_fs(cg.a[acol]))
else
        Bmp.Canvas.FillRect(Classes.Rect(0,0,TDrawGrid(Sender).DefaultColWidth,TDrawGrid(Sender).DefaultRowHeight));
DrawGrid3.Canvas.Draw(rect.Left,rect.Top,bmp);
end;

procedure TForm1.DrawGrid4DrawCell(Sender: TObject; ACol, ARow: Integer;
  Rect: TRect; State: TGridDrawState);
begin
if (ce.size>0)and(acol<ce.size) then
        Bmp.LoadFromFile(to_fs(ce.a[acol]))
else
        Bmp.Canvas.FillRect(Classes.Rect(0,0,TDrawGrid(Sender).DefaultColWidth,TDrawGrid(Sender).DefaultRowHeight));
DrawGrid4.Canvas.Draw(rect.Left,rect.Top,bmp);
end;
//DOUBLECLICK
procedure TForm1.DrawGrid1DblClick(Sender: TObject);
begin
if (stat=3)and(currig=1)and(eop=0) then//first hod
        begin
        cmove(c1,cg,DrawGrid1.Col);
        out_colod(DrawGrid1,c1);
        out_colod(DrawGrid3,cg);
        //cmove(c,ci1,c.size-1);
        eop:=1;SpeedButton5.Visible:=true;
        end else
if (stat=1)and(currig=1)and(eop=0)and(can_beat(cg.a[cg.size-1],c1.a[DrawGrid1.Col])) then//otbit
        begin
        cmove(c1,cg,DrawGrid1.Col);
        out_colod(DrawGrid1,c1);
        out_colod(DrawGrid3,cg);
        //cmove(c,ci1,c.size-1);
        eop:=1;SpeedButton5.Visible:=true;
        end else
if (stat=0)and(currig=1)and(can_throw(c1.a[DrawGrid1.Col]))then//sbros
        begin
        cmove(c1,ce,DrawGrid1.Col);
        out_colod(DrawGrid1,c1);
        out_colod(DrawGrid4,ce);
        eop:=1;SpeedButton5.Visible:=true;
        end;
end;

procedure TForm1.DrawGrid2DblClick(Sender: TObject);
begin
if (stat=3)and(currig=2)and(eop=0) then//first hod
        begin
        cmove(c2,cg,DrawGrid2.Col);
        out_colod(DrawGrid2,c2);
        out_colod(DrawGrid3,cg);
        //cmove(c,ci2,c.size-1);
        eop:=1;SpeedButton5.Visible:=true;
        end else
if (stat=1)and(currig=2)and(eop=0)and(can_beat(cg.a[cg.size-1],c2.a[DrawGrid2.Col])) then//otbit
        begin
        cmove(c2,cg,DrawGrid2.Col);
        out_colod(DrawGrid2,c2);
        out_colod(DrawGrid3,cg);
        //cmove(c,ci2,c.size-1);
        eop:=1;SpeedButton5.Visible:=true;
        end;
if (stat=0)and(currig=2)and(can_throw(c2.a[DrawGrid2.Col]))then
        begin
        cmove(c2,ce,DrawGrid2.Col);
        out_colod(DrawGrid2,c1);
        out_colod(DrawGrid4,ce);
        eop:=1;SpeedButton5.Visible:=true;
        end;
end;

procedure TForm1.DrawGrid3DblClick(Sender: TObject);
begin
if (stat=3)and(eop=1) then
        begin
        if currig=1 then cmove(cg,c1,0)
        else cmove(cg,c2,0);
        if currig=1 then out_colod(DrawGrid1,c1)
        else out_colod(DrawGrid2,c2);
        out_colod(DrawGrid3,cg);
        eop:=0;SpeedButton5.Visible:=false;
        end else
if (stat=1)and(eop=1) then
        begin
        if currig=1 then cmove(cg,c1,cg.size-1)
        else cmove(cg,c2,cg.size-1);
        if currig=1 then out_colod(DrawGrid1,c1)
        else out_colod(DrawGrid2,c2);
        out_colod(DrawGrid3,cg);
        eop:=0;SpeedButton5.Visible:=false;
        end;
end;

procedure TForm1.DrawGrid4DblClick(Sender: TObject);
begin
if (stat=0)then begin
if currig=1 then cmove(ce,c1,DrawGrid4.Col)
else cmove(ce,c2,DrawGrid4.Col);
out_colod(DrawGrid4,ce);
if currig=1 then out_colod(DrawGrid1,c1)
else out_colod(DrawGrid2,c2);
if ce.size=0 then
        begin
        eop:=0;SpeedButton5.Visible:=false;
        end;
end;
end;
//SPEEDBUTTONSCLICK
procedure TForm1.SpeedButton1Click(Sender: TObject);
begin
stat:=0;
outinf;
end;

procedure TForm1.SpeedButton2Click(Sender: TObject);
begin
stat:=1;
outinf;
end;

procedure TForm1.SpeedButton3Click(Sender: TObject);
begin
stat:=2;
eop:=1;SpeedButton5.Visible:=true;
outinf;
end;

procedure TForm1.SpeedButton4Click(Sender: TObject);
begin
stat:=3;
outinf;
end;

procedure TForm1.SpeedButton5Click(Sender: TObject);
var i:integer;
begin
if eop=1 then
        begin
        if stat=3 then//firsthod
                begin
                //ci1,ci2
                if currig=1 then cmove(c,ci1,0)
                else cmove(c,ci2,0);
                hod:=hod+1;
                currig:=3-currig;
                stat:=-1;
                outinf;
                first_hod(false);
                eop:=0;SpeedButton5.Visible:=false;
                end else
        if stat=2 then//zabrat
                begin
                if currig=1 then comove(cg,c1)
                else comove(cg,c2);
                if(currig=1)then out_colod(DrawGrid1,c1)
                else out_colod(DrawGrid2,c2);
                out_colod(DrawGrid3,cg);
                eop:=0;SpeedButton5.Visible:=false;
                //ci1 and ci2
                if currig=1 then
                        begin
                        obcmove(ci2,ci1,c);
                        taketo7(c,c2,7);
                        out_colod(DrawGrid2,c2);
                        end else
                        begin
                        obcmove(ci1,ci2,c);
                        taketo7(c,c1,7);
                        out_colod(DrawGrid1,c1);
                        end;

                hod:=0;kon:=kon+1;
                currig:=3-currig;
                stat:=-1;
                outinf;
                first_hod(true);
                end else
        if stat=1 then//otbit
                begin
                //ci1,ci2
                if currig=1 then cmove(c,ci1,0)
                else cmove(c,ci2,0);

                hod:=hod+1;
                currig:=3-currig;
                stat:=-1;
                outinf;
                first_hod(false);
                eop:=0;SpeedButton5.Visible:=false;
                end else
        if stat=0 then//sbros
                begin
                //ci1,ci2
                for i:=0 to ce.size-1 do
                        begin
                        if currig=1 then cmove(c,ci1,0)
                        else cmove(c,ci2,0);
                        end;
                comove(ci1,c1);
                comove(ci2,c2);

                cg.size:=0;
                ce.size:=0;
                hod:=0;kon:=kon+1;
                stat:=-1;//currig ne izmen
                outinf;
                first_hod(true);
                eop:=0;SpeedButton5.Visible:=false;
                out_colod(DrawGrid1,c1);
                out_colod(DrawGrid2,c2);
                set_widths;
                end;
        end;
check_win;
end;
//SAVELOAD
procedure TForm1.SpeedButton6Click(Sender: TObject);
begin
if saveDialog1.Execute then
        begin
        assignfile(f,saveDialog1.FileName);
        rewrite(f);
        writeln(f,hod,' ',kon,' ',currig,' ',stat,' ',eop);
        savecolod(c);
        savecolod(c1);
        savecolod(c2);
        savecolod(ci1);
        savecolod(ci2);
        savecolod(cg);
        savecolod(ce);
        closefile(f);
        end;
end;

procedure TForm1.Set_Widths;
var i:integer;
begin
        DrawGrid1.ColCount:=c1.size;
        DrawGrid1.Width:=(DrawGrid1.DefaultColWidth+2)*min(7,c1.size)+9;
        for i:=0 to c1.size-1 do
                DrawGrid1DrawCell(DrawGrid1,i,0,DrawGrid1.CellRect(i,0),[]);

        DrawGrid2.ColCount:=c2.size;
        DrawGrid2.Width:=(DrawGrid2.DefaultColWidth+2)*min(7,c2.size)+9;
        for i:=0 to c2.size-1 do
                DrawGrid2DrawCell(DrawGrid2,i,0,DrawGrid2.CellRect(i,0),[]);

        DrawGrid3.ColCount:=cg.size;
        DrawGrid3.Width:=(DrawGrid3.DefaultColWidth+2)*min(7,cg.size)+9;
        for i:=0 to cg.size-1 do
                DrawGrid3DrawCell(DrawGrid3,i,0,DrawGrid3.CellRect(i,0),[]);

        DrawGrid4.ColCount:=ce.size;
        DrawGrid4.Width:=(DrawGrid4.DefaultColWidth+2)*min(7,ce.size)+9;
        for i:=0 to ce.size-1 do
                DrawGrid4DrawCell(DrawGrid4,i,0,DrawGrid4.CellRect(i,0),[]);
end;

procedure TForm1.SpeedButton7Click(Sender: TObject);
var i:integer;
begin
if OpenDialog1.Execute then
        begin
        assignfile(f,openDialog1.FileName);
        reset(f);
        readln(f,hod,kon,currig,stat,eop);
        loadcolod(c);
        loadcolod(c1);
        loadcolod(c2);
        loadcolod(ci1);
        loadcolod(ci2);
        loadcolod(cg);
        loadcolod(ce);
        closefile(f);

        Set_Widths;
        if hod=0 then first_hod(true)
        else first_hod(false);
        if eop=1 then SpeedButton5.Visible:=true;
        outinf;
        end;
end;

procedure TForm1.Timer1Timer(Sender: TObject);
var ret,i:integer;
begin
if comp[currig-1]=1 then
        begin
        if eop=1 then SpeedButton5Click(SpeedButton5)
        else    begin
                if hod=0 then//fisrt hod
                        begin
                        speedButton4Click(SpeedButton4);
                        if currig=1 then
                                begin
                                ret:=cmfh(c1);
                                DrawGrid1.Col:=ret;
                                DrawGrid1DblClick(DrawGrid1);
                                end else
                                begin
                                ret:=cmfh(c2);
                                DrawGrid2.Col:=ret;
                                DrawGrid2DblClick(DrawGrid2);
                                end;
                        //////
                        SpeedButton5Click(SpeedButton5);
                        end else //if hod>0 then
                        begin
                        if currig=1 then
                                begin  //sbros bez kozyrey

                                if can_cthrow(c1)=true then
                                        begin    
                                        SpeedButton1Click(SpeedButton1);
                                        for i:=c1.size-1 downto 0 do if reta[i]=1 then
//                                        while can_cthrow(c1) do
                                                begin
                                                DrawGrid1.Col:=i;
                                                DrawGrid1DblClick(DrawGrid1);
                                                end;

                                        end else //otbit
                                if can_cbeat(cg.a[cg.size-1],c1,ret)=true then
                                        begin
                                        SpeedButton2Click(SpeedButton2);
                                        DrawGrid1.Col:=ret;
                                        DrawGrid1DblClick(DrawGrid1);
                                        end else//sbros kozyrey
                                if can_cthrow2(c1,ret)=true then
                                        begin
                                        SpeedButton1Click(SpeedButton1);
                                        DrawGrid1.Col:=ret;
                                        DrawGrid1DblClick(DrawGrid1);
                                        end else//zabrat
                                        SpeedButton3Click(SpeedButton3);
                                end else
                                begin
                                if can_cthrow(c2)=true then
                                        begin      
                                        SpeedButton1Click(SpeedButton1);
                                        for i:=c2.size-1 downto 0 do if reta[i]=1 then
//                                        while can_cthrow(c2) do
                                                begin
                                                DrawGrid2.Col:=i;
                                                DrawGrid2DblClick(DrawGrid2);
                                                end;

                                        end else //otbit
                                if can_cbeat(cg.a[cg.size-1],c2,ret)=true then
                                        begin
                                        SpeedButton2Click(SpeedButton2);
                                        DrawGrid2.Col:=ret;
                                        DrawGrid2DblClick(DrawGrid2);
                                        end else//sbros kozyrey
                                if can_cthrow2(c2,ret)=true then
                                        begin
                                        SpeedButton1Click(SpeedButton1);
                                        DrawGrid2.Col:=ret;
                                        DrawGrid2DblClick(DrawGrid2);
                                        end else//zabrat
                                        SpeedButton3Click(SpeedButton3);

                                end;
                        //SpeedButton1Click(SpeedButton1);
                        SpeedButton5Click(SpeedButton5);
                        end;
                end;
        //showmessage('Компьютер сделал ход');
        end //else showmessage('Сейчас ходите вы');
end;

procedure TForm1.CheckBox1Click(Sender: TObject);
begin
if CheckBox1.Checked then comp[0]:=1
else comp[0]:=0;
end;

procedure TForm1.CheckBox2Click(Sender: TObject);
begin
if CheckBox2.Checked then comp[1]:=1
else comp[1]:=0;
end;

procedure TForm1.SpeedButton8Click(Sender: TObject);
begin
//timer1timer(timer1);
Timer1.Enabled:=not Timer1.Enabled;
if Timer1.Enabled then SpeedButton8.Caption:='Выключить таймер'
else SpeedButton8.Caption:='Включить таймер'
end;

procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
begin
bmp.Free;
end;

procedure TForm1.check_win;
var Action: TCloseAction;
begin
if (c1.size=0) and (c.size=0) then
        begin
        Timer1.Enabled:=false;
        showmessage('Выиграл первый');
        //FormClose(Form1,action);
        //FormCreate(Form1);
        end;
if (c2.size=0) and (c.size=0) then
        begin
        Timer1.Enabled:=false;
        showmessage('Выиграл второй');
        //FormClose(Form1,action);
        //FormCreate(Form1);
        end;
end;

procedure TForm1.FormClick(Sender: TObject);
begin
showmessage(inttostr(drawgrid2.width));
end;

procedure TForm1.SpeedButton9Click(Sender: TObject);
begin
timer1timer(timer1);
end;

end.
