unit Unit1;

interface

uses
  Windows, Messages, Classes, Forms, Controls, StdCtrls, ExtCtrls, ComCtrls;

type
  TForm1 = class(TForm)
    Image1: TImage;
    TrackBar1: TTrackBar;
    procedure TrackBar1Change(Sender: TObject);
    procedure FormCreate(Sender: TObject);
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
  end;

var
  Form1:     TForm1;
  Pixels:    array of integer;
  RezP,RezQ: single;

implementation

{$R *.dfm}

const
bmp: BitmapInfo=(bmiHeader:(biSize:        sizeof(BITMAPINFOHEADER);
                              biWidth:       640;
                              biHeight:      -480;
                              biPlanes:      1;
                              biBitCount:    32;
                              biCompression: 0;
                              biSizeImage:   640*480*4));
Pmax=1.5;
Pmin=-2.5;
Qmax=1.5;
Qmin=-1.5;
m   =5;

procedure TForm1.TrackBar1Change(Sender: TObject);
var k,i:integer;
x,y,Xk,Yk,Q,P: single;
begin
fillchar(Pixels[0],bmp.bmiHeader.biSizeImage,255);
i:=bmp.bmiHeader.biSizeImage shr 2;
Q:=Qmin-bmp.bmiHeader.biHeight*rezQ;
repeat
Q:=Q-rezQ;
P:=Pmin+bmp.bmiHeader.biWidth*rezP;
        repeat
        P:=P-rezP;
        Xk:=0;
        Yk:=0;
        dec(i);
        for k:=TrackBar1.Position downto 0 do
                begin
                x:=sqr(Xk);
                y:=sqr(Yk);
                Yk:=Q+2*Xk*Yk;
                Xk:=P+x-y;
                if x+y>m then
                        begin
                        Pixels[i]:=0;
                        break;
                        end;
                end;
        until P<=Pmin;
until Q<=Qmin;
Image1.Refresh;
end;

procedure TForm1.FormCreate(Sender: TObject);
begin
Image1.Picture.Bitmap.Handle:=CreateDIBSection(Image1.Canvas.Handle,bmp,0,Pointer(Pixels),0,0);
rezP:=(Pmax-Pmin)/Image1.Width;
rezQ:=(Qmax-Qmin)/Image1.Height;
TrackBar1.OnChange(self);
end;

procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
begin
LongInt(Pixels):=0;
end;

end.
