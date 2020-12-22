object Form1: TForm1
  Left = 192
  Top = 117
  Width = 760
  Height = 522
  Caption = #1055#1086#1080#1089#1082' '#1087#1091#1090#1080
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
  object Label1: TLabel
    Left = 600
    Top = 16
    Width = 91
    Height = 13
    Caption = #1050#1086#1083#1080#1095#1077#1089#1090#1074#1086' '#1089#1090#1088#1086#1082
  end
  object Label2: TLabel
    Left = 600
    Top = 72
    Width = 109
    Height = 13
    Caption = #1050#1086#1083#1080#1095#1077#1089#1090#1074#1086' '#1089#1090#1086#1083#1073#1094#1086#1074
  end
  object SpeedButton1: TSpeedButton
    Left = 616
    Top = 232
    Width = 97
    Height = 25
    Caption = #1055#1077#1088#1077#1088#1080#1089#1086#1074#1072#1090#1100
    OnClick = SpeedButton1Click
  end
  object SpeedButton2: TSpeedButton
    Left = 616
    Top = 296
    Width = 97
    Height = 25
    Caption = #1055#1088#1077#1087#1103#1090#1089#1090#1074#1080#1077
    OnClick = SpeedButton2Click
  end
  object SpeedButton3: TSpeedButton
    Left = 616
    Top = 320
    Width = 97
    Height = 25
    Caption = #1057#1074#1086#1073#1086#1076#1085#1086
    OnClick = SpeedButton3Click
  end
  object SpeedButton4: TSpeedButton
    Left = 616
    Top = 392
    Width = 97
    Height = 25
    Caption = #1042#1099#1073#1088#1072#1090#1100' '#1089#1090#1072#1088#1090
    OnClick = SpeedButton4Click
  end
  object SpeedButton5: TSpeedButton
    Left = 616
    Top = 416
    Width = 97
    Height = 25
    Caption = #1056#1072#1089#1089#1095#1080#1090#1072#1090#1100
    OnClick = SpeedButton5Click
  end
  object SpeedButton6: TSpeedButton
    Left = 616
    Top = 256
    Width = 97
    Height = 25
    Caption = #1057#1077#1090#1082#1072
    OnClick = SpeedButton6Click
  end
  object SpeedButton7: TSpeedButton
    Left = 616
    Top = 344
    Width = 97
    Height = 25
    Caption = #1057#1083#1091#1095#1072#1081#1085#1086
    OnClick = SpeedButton7Click
  end
  object Label3: TLabel
    Left = 600
    Top = 128
    Width = 135
    Height = 13
    Caption = #1057#1083#1091#1095#1072#1081#1085#1086#1077' '#1079#1072#1087#1086#1083#1085#1077#1085#1080#1077' %%'
  end
  object DrawGrid1: TDrawGrid
    Left = 0
    Top = 0
    Width = 569
    Height = 481
    ColCount = 10
    DefaultColWidth = 40
    DefaultRowHeight = 40
    FixedCols = 0
    RowCount = 10
    FixedRows = 0
    GridLineWidth = 0
    TabOrder = 0
    OnDrawCell = DrawGrid1DrawCell
    OnMouseDown = DrawGrid1MouseDown
  end
  object SpinEdit1: TSpinEdit
    Left = 600
    Top = 40
    Width = 121
    Height = 22
    MaxValue = 25
    MinValue = 5
    TabOrder = 1
    Value = 10
  end
  object SpinEdit2: TSpinEdit
    Left = 600
    Top = 96
    Width = 121
    Height = 22
    MaxValue = 25
    MinValue = 5
    TabOrder = 2
    Value = 10
  end
  object SpinEdit3: TSpinEdit
    Left = 600
    Top = 152
    Width = 121
    Height = 22
    MaxValue = 99
    MinValue = 1
    TabOrder = 3
    Value = 50
  end
end
