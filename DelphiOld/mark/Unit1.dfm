object Form1: TForm1
  Left = 192
  Top = 107
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
  PixelsPerInch = 96
  TextHeight = 13
  object SpeedButton1: TSpeedButton
    Left = 392
    Top = 144
    Width = 137
    Height = 41
    Caption = 'Step'
    Enabled = False
    OnClick = SpeedButton1Click
  end
  object SpeedButton2: TSpeedButton
    Left = 392
    Top = 344
    Width = 153
    Height = 41
    Caption = 'New'
    OnClick = SpeedButton2Click
  end
  object Label1: TLabel
    Left = 16
    Top = 0
    Width = 158
    Height = 13
    Caption = #1048#1089#1093#1086#1076#1085#1072#1103' '#1087#1086#1089#1083#1077#1076#1086#1074#1072#1090#1077#1083#1100#1085#1086#1089#1090#1100
  end
  object Label2: TLabel
    Left = 16
    Top = 40
    Width = 154
    Height = 13
    Caption = #1058#1077#1082#1091#1097#1072#1103' '#1087#1086#1089#1083#1077#1076#1086#1074#1072#1090#1077#1083#1100#1085#1086#1089#1090#1100
  end
  object Edit1: TEdit
    Left = 16
    Top = 56
    Width = 657
    Height = 21
    TabOrder = 0
  end
  object StringGrid1: TStringGrid
    Left = 16
    Top = 80
    Width = 273
    Height = 345
    ColCount = 2
    FixedCols = 0
    RowCount = 1
    FixedRows = 0
    Options = [goFixedVertLine, goFixedHorzLine, goVertLine, goHorzLine, goEditing]
    TabOrder = 1
    OnKeyPress = StringGrid1KeyPress
  end
  object CheckBox1: TCheckBox
    Left = 384
    Top = 240
    Width = 153
    Height = 17
    Caption = 'Auto'
    TabOrder = 2
  end
  object Edit2: TEdit
    Left = 16
    Top = 16
    Width = 657
    Height = 21
    TabOrder = 3
  end
  object Timer1: TTimer
    Interval = 1
    OnTimer = Timer1Timer
    Left = 400
    Top = 288
  end
end
