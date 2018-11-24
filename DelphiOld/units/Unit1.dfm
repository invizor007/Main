object Form1: TForm1
  Left = 192
  Top = 114
  Width = 696
  Height = 480
  Caption = 'Form1'
  Color = clBtnFace
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'MS Sans Serif'
  Font.Style = []
  OldCreateOrder = False
  OnClose = FormClose
  OnCreate = FormCreate
  PixelsPerInch = 96
  TextHeight = 13
  object SpeedButton1: TSpeedButton
    Left = 464
    Top = 88
    Width = 113
    Height = 33
    Caption = 'Start'
    OnClick = SpeedButton1Click
  end
  object StringGrid1: TStringGrid
    Left = 32
    Top = 16
    Width = 345
    Height = 105
    ColCount = 1
    FixedColor = clPurple
    FixedCols = 0
    RowCount = 3
    FixedRows = 0
    Options = [goFixedVertLine, goFixedHorzLine, goVertLine, goHorzLine, goRangeSelect, goEditing]
    TabOrder = 0
  end
  object StringGrid2: TStringGrid
    Left = 32
    Top = 176
    Width = 345
    Height = 105
    ColCount = 2
    FixedColor = clPurple
    FixedCols = 0
    RowCount = 3
    FixedRows = 0
    Options = [goFixedVertLine, goFixedHorzLine, goVertLine, goHorzLine, goRangeSelect, goEditing]
    TabOrder = 1
  end
  object SpinEdit1: TSpinEdit
    Left = 464
    Top = 40
    Width = 121
    Height = 22
    MaxValue = 0
    MinValue = 0
    TabOrder = 2
    Value = 1
    OnChange = SpinEdit1Change
  end
  object SpinEdit2: TSpinEdit
    Left = 464
    Top = 152
    Width = 121
    Height = 22
    MaxValue = 0
    MinValue = 0
    TabOrder = 3
    Value = 2
    OnChange = SpinEdit2Change
  end
  object CheckBox1: TCheckBox
    Left = 464
    Top = 184
    Width = 169
    Height = 25
    Caption = #1057#1086#1093#1088#1072#1085#1103#1090#1100' '#1087#1088#1080' '#1079#1072#1074#1077#1088#1096#1077#1085#1080#1080'?'
    TabOrder = 4
  end
  object Timer1: TTimer
    Enabled = False
    Interval = 1
    OnTimer = Timer1Timer
    Left = 456
    Top = 224
  end
end
