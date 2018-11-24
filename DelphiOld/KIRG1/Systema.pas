Unit Systema;

interface

{public}
var Syst:array [0..10,1..10]of real;
UrsCount:Integer;
SystSolve:array[1..10]of Real;

procedure Izb(ur1,ur2,NPer:Integer);
procedure CalcVar(i:integer);
procedure Solve;
implementation
//избавление от переменной NPer в ур-ии єur2 использу€ ur1
procedure Izb(ur1,ur2,NPer:Integer);
var i:integer;
begin
for i:=0 to UrsCount do//по переменным
    begin
    if i<>NPer then
        syst[i,ur2]:=syst[i,ur1]*syst[Nper,ur2]-syst[i,ur2]*syst[Nper,ur1]
    end;
Syst[NPer,ur2]:=0;
end;
//окончательное вычисление переменной номером i
procedure CalcVar(i:integer);
var j:integer;
begin
syst[0,i]:=-syst[0,i];
for j:=i+1 to UrsCount do
    syst[0,i]:=syst[0,i]-syst[j,i]*syst[0,j];
syst[0,i]:=syst[0,i]/syst[i,i];
end;
//решение
procedure Solve;
var i,j:integer;               
begin
for i:=1 to UrsCount-1 do
    for j:=i+1 to UrsCount do
        izb(i,j,i);
for i:=UrsCount downto 1 do CalcVar(i);
for i:=1 to UrsCount do
    SystSolve[i]:=Syst[0,i];
end;

end.
