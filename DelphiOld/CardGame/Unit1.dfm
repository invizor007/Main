object Form1: TForm1
  Left = 189
  Top = 123
  Width = 673
  Height = 522
  Color = 16752800
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'MS Sans Serif'
  Font.Style = []
  OldCreateOrder = False
  OnClick = FormClick
  OnClose = FormClose
  OnCreate = FormCreate
  PixelsPerInch = 96
  TextHeight = 13
  object SpeedButton1: TSpeedButton
    Left = 544
    Top = 1
    Width = 113
    Height = 23
    Caption = #1054#1090#1073#1088#1086#1089#1080#1090#1100
    OnClick = SpeedButton1Click
  end
  object SpeedButton2: TSpeedButton
    Left = 544
    Top = 24
    Width = 113
    Height = 25
    Caption = #1054#1090#1073#1080#1090#1100
    OnClick = SpeedButton2Click
  end
  object SpeedButton3: TSpeedButton
    Left = 544
    Top = 48
    Width = 113
    Height = 25
    Caption = #1047#1072#1073#1088#1072#1090#1100
    OnClick = SpeedButton3Click
  end
  object SpeedButton4: TSpeedButton
    Left = 544
    Top = 72
    Width = 113
    Height = 25
    Caption = #1055#1077#1088#1074#1099#1081' '#1093#1086#1076
    Visible = False
    OnClick = SpeedButton4Click
  end
  object Label1: TLabel
    Left = 544
    Top = 348
    Width = 113
    Height = 37
    AutoSize = False
  end
  object SpeedButton5: TSpeedButton
    Left = 544
    Top = 96
    Width = 113
    Height = 25
    Caption = #1055#1086#1076#1090#1074#1077#1088#1078#1076#1072#1102
    Visible = False
    OnClick = SpeedButton5Click
  end
  object SpeedButton6: TSpeedButton
    Left = 544
    Top = 136
    Width = 113
    Height = 25
    Caption = #1057#1086#1093#1088#1072#1085#1080#1090#1100
    OnClick = SpeedButton6Click
  end
  object SpeedButton7: TSpeedButton
    Left = 544
    Top = 160
    Width = 113
    Height = 25
    Caption = #1047#1072#1075#1088#1091#1079#1080#1090#1100
    OnClick = SpeedButton7Click
  end
  object SpeedButton8: TSpeedButton
    Left = 552
    Top = 240
    Width = 105
    Height = 33
    Caption = #1042#1082#1083#1102#1095#1080#1090#1100' '#1090#1072#1081#1084#1077#1088
    OnClick = SpeedButton8Click
  end
  object SpeedButton9: TSpeedButton
    Left = 552
    Top = 400
    Width = 105
    Height = 33
    Caption = #1064#1072#1075
    OnClick = SpeedButton9Click
  end
  object DrawGrid1: TDrawGrid
    Left = 0
    Top = 0
    Width = 521
    Height = 113
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
    Height = 113
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
    Top = 248
    Width = 521
    Height = 113
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
    Top = 368
    Width = 521
    Height = 113
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
    Left = 544
    Top = 280
    Width = 121
    Height = 25
    Caption = #1048#1075#1088#1086#1082' 1 '#1048#1048
    TabOrder = 4
    OnClick = CheckBox1Click
  end
  object CheckBox2: TCheckBox
    Left = 544
    Top = 312
    Width = 121
    Height = 25
    Caption = #1048#1075#1088#1086#1082' 2 '#1048#1048
    TabOrder = 5
    OnClick = CheckBox2Click
  end
  object OpenDialog1: TOpenDialog
    Left = 552
    Top = 208
  end
  object SaveDialog1: TSaveDialog
    Left = 592
    Top = 208
  end
  object Timer1: TTimer
    Enabled = False
    Interval = 10
    OnTimer = Timer1Timer
    Left = 624
    Top = 208
  end
end
