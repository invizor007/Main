object Form1: TForm1
  Left = 192
  Top = 117
  Width = 756
  Height = 370
  Caption = #1054#1073#1093#1086#1076' '#1075#1088#1072#1092#1072
  Color = clBtnFace
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'MS Sans Serif'
  Font.Style = []
  OldCreateOrder = False
  OnCreate = FormCreate
  PixelsPerInch = 96
  TextHeight = 13
  object SpeedButton1: TSpeedButton
    Left = 600
    Top = 144
    Width = 81
    Height = 25
    Caption = #1055#1088#1080#1084#1077#1085#1080#1090#1100
    OnClick = SpeedButton1Click
  end
  object SpeedButton2: TSpeedButton
    Left = 528
    Top = 16
    Width = 81
    Height = 25
    Caption = #1057#1083#1091#1095#1072#1081#1085#1086
    OnClick = SpeedButton2Click
  end
  object Label1: TLabel
    Left = 536
    Top = 72
    Width = 73
    Height = 17
    AutoSize = False
    Caption = #1057#1090#1072#1088#1090
  end
  object Label2: TLabel
    Left = 536
    Top = 104
    Width = 73
    Height = 17
    AutoSize = False
    Caption = #1060#1080#1085#1080#1096
  end
  object StringGrid1: TStringGrid
    Left = 0
    Top = 0
    Width = 505
    Height = 321
    ColCount = 10
    DefaultColWidth = 40
    RowCount = 10
    Options = [goFixedVertLine, goFixedHorzLine, goVertLine, goHorzLine, goEditing]
    TabOrder = 0
  end
  object SpinEdit1: TSpinEdit
    Left = 616
    Top = 72
    Width = 121
    Height = 22
    MaxValue = 0
    MinValue = 0
    TabOrder = 1
    Value = 2
  end
  object SpinEdit2: TSpinEdit
    Left = 616
    Top = 104
    Width = 121
    Height = 22
    MaxValue = 0
    MinValue = 0
    TabOrder = 2
    Value = 3
  end
end
