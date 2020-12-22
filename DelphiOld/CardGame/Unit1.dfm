object Form1: TForm1
  Left = 189
  Top = 123
  Width = 735
  Height = 549
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
    Left = 576
    Top = 17
    Width = 113
    Height = 23
    Caption = #1054#1090#1073#1088#1086#1089#1080#1090#1100
    OnClick = SpeedButton1Click
  end
  object SpeedButton2: TSpeedButton
    Left = 576
    Top = 40
    Width = 113
    Height = 25
    Caption = #1054#1090#1073#1080#1090#1100
    OnClick = SpeedButton2Click
  end
  object SpeedButton3: TSpeedButton
    Left = 576
    Top = 64
    Width = 113
    Height = 25
    Caption = #1047#1072#1073#1088#1072#1090#1100
    OnClick = SpeedButton3Click
  end
  object SpeedButton4: TSpeedButton
    Left = 576
    Top = 88
    Width = 113
    Height = 25
    Caption = #1055#1077#1088#1074#1099#1081' '#1093#1086#1076
    Visible = False
    OnClick = SpeedButton4Click
  end
  object Label1: TLabel
    Left = 544
    Top = 376
    Width = 161
    Height = 33
    AutoSize = False
  end
  object SpeedButton5: TSpeedButton
    Left = 576
    Top = 112
    Width = 113
    Height = 25
    Caption = #1055#1086#1076#1090#1074#1077#1088#1078#1076#1072#1102
    Visible = False
    OnClick = SpeedButton5Click
  end
  object SpeedButton6: TSpeedButton
    Left = 576
    Top = 152
    Width = 113
    Height = 25
    Caption = #1057#1086#1093#1088#1072#1085#1080#1090#1100
    OnClick = SpeedButton6Click
  end
  object SpeedButton7: TSpeedButton
    Left = 576
    Top = 176
    Width = 113
    Height = 25
    Caption = #1047#1072#1075#1088#1091#1079#1080#1090#1100
    OnClick = SpeedButton7Click
  end
  object SpeedButton8: TSpeedButton
    Left = 584
    Top = 256
    Width = 105
    Height = 33
    Caption = #1058#1072#1081#1084#1077#1088
    OnClick = SpeedButton8Click
  end
  object DrawGrid1: TDrawGrid
    Left = 0
    Top = 0
    Width = 521
    Height = 121
    ColCount = 7
    DefaultColWidth = 72
    DefaultRowHeight = 96
    FixedCols = 0
    RowCount = 1
    FixedRows = 0
    TabOrder = 0
    OnDblClick = DrawGrid1DblClick
    OnDrawCell = DrawGrid1DrawCell
  end
  object DrawGrid2: TDrawGrid
    Left = 0
    Top = 128
    Width = 521
    Height = 121
    ColCount = 7
    DefaultColWidth = 72
    DefaultRowHeight = 96
    FixedCols = 0
    RowCount = 1
    FixedRows = 0
    TabOrder = 1
    OnDblClick = DrawGrid2DblClick
    OnDrawCell = DrawGrid2DrawCell
  end
  object DrawGrid3: TDrawGrid
    Left = 0
    Top = 264
    Width = 521
    Height = 121
    ColCount = 1
    DefaultColWidth = 72
    DefaultRowHeight = 96
    FixedCols = 0
    RowCount = 1
    FixedRows = 0
    TabOrder = 2
    OnDblClick = DrawGrid3DblClick
    OnDrawCell = DrawGrid3DrawCell
  end
  object DrawGrid4: TDrawGrid
    Left = 0
    Top = 392
    Width = 521
    Height = 121
    ColCount = 1
    DefaultColWidth = 72
    DefaultRowHeight = 96
    FixedCols = 0
    RowCount = 1
    FixedRows = 0
    TabOrder = 3
    OnDblClick = DrawGrid4DblClick
    OnDrawCell = DrawGrid4DrawCell
  end
  object CheckBox1: TCheckBox
    Left = 576
    Top = 296
    Width = 121
    Height = 25
    Caption = #1048#1075#1088#1086#1082' 1 '#1048#1048
    TabOrder = 4
    OnClick = CheckBox1Click
  end
  object CheckBox2: TCheckBox
    Left = 576
    Top = 328
    Width = 121
    Height = 25
    Caption = #1048#1075#1088#1086#1082' 2 '#1048#1048
    TabOrder = 5
    OnClick = CheckBox2Click
  end
  object OpenDialog1: TOpenDialog
    Left = 584
    Top = 224
  end
  object SaveDialog1: TSaveDialog
    Left = 624
    Top = 224
  end
  object Timer1: TTimer
    Enabled = False
    Interval = 10
    OnTimer = Timer1Timer
    Left = 656
    Top = 224
  end
end
