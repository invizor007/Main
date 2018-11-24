object Form1: TForm1
  Left = 0
  Top = 0
  Width = 845
  Height = 739
  Color = clBtnFace
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'MS Sans Serif'
  Font.Style = []
  OldCreateOrder = False
  OnCreate = FormCreate
  OnDragOver = FormDragOver
  OnMouseDown = FormMouseDown
  OnShow = FormShow
  PixelsPerInch = 96
  TextHeight = 13
  object Shape1: TShape
    Left = 232
    Top = 120
    Width = 20
    Height = 20
    Shape = stCircle
    OnDragOver = Shape1DragOver
    OnMouseDown = Shape1MouseDown
  end
  object Shape2: TShape
    Left = 192
    Top = 256
    Width = 20
    Height = 20
    Brush.Color = clYellow
    Shape = stCircle
    OnDragOver = Shape2DragOver
    OnMouseDown = Shape2MouseDown
  end
  object Timer1: TTimer
    Enabled = False
    Interval = 1
    OnTimer = Timer1Timer
    Left = 120
    Top = 40
  end
end
