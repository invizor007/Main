object Form1: TForm1
  Left = 192
  Top = 117
  Width = 716
  Height = 420
  Caption = #1044#1086#1084#1080#1085#1080#1086#1085
  Color = clAqua
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
  object SBGameStart: TSpeedButton
    Left = 536
    Top = 8
    Width = 153
    Height = 25
    Caption = #1053#1072#1095#1072#1090#1100' '#1080#1075#1088#1091
    OnClick = SBGameStartClick
  end
  object SBEditSet: TSpeedButton
    Left = 536
    Top = 32
    Width = 153
    Height = 25
    Caption = #1056#1077#1076#1072#1082#1090#1080#1088#1086#1074#1072#1090#1100' '#1089#1077#1090
    OnClick = SBEditSetClick
  end
  object SBGameEnd: TSpeedButton
    Left = 536
    Top = 56
    Width = 153
    Height = 25
    Caption = #1047#1072#1074#1077#1088#1096#1080#1090#1100' '#1080#1075#1088#1091
    OnClick = SBGameEndClick
  end
  object Label7: TLabel
    Left = 16
    Top = 211
    Width = 289
    Height = 25
    AutoSize = False
    Caption = #1055#1086#1073#1077#1076#1085#1099#1077' '#1086#1095#1082#1080':'
    Color = clLime
    ParentColor = False
    Visible = False
  end
  object Panel1: TPanel
    Left = 8
    Top = 8
    Width = 521
    Height = 201
    TabOrder = 0
    Visible = False
  end
  object DrawGrid1: TDrawGrid
    Left = 8
    Top = 240
    Width = 521
    Height = 129
    DefaultColWidth = 65
    DefaultRowHeight = 100
    FixedCols = 0
    RowCount = 1
    FixedRows = 0
    Options = [goFixedVertLine, goFixedHorzLine, goVertLine, goHorzLine]
    TabOrder = 1
    Visible = False
    OnDrawCell = DrawGrid1DrawCell
    OnMouseDown = DrawGrid1MouseDown
  end
  object Panel2: TPanel
    Left = 536
    Top = 280
    Width = 153
    Height = 89
    TabOrder = 2
    Visible = False
    object Label1: TLabel
      Left = 8
      Top = 8
      Width = 137
      Height = 25
      AutoSize = False
      Caption = #1044#1077#1081#1089#1090#1074#1080#1081
      Color = clLime
      ParentColor = False
    end
    object Label2: TLabel
      Left = 8
      Top = 32
      Width = 137
      Height = 25
      AutoSize = False
      Caption = #1055#1086#1082#1091#1087#1086#1082
      Color = clLime
      ParentColor = False
    end
    object Label3: TLabel
      Left = 8
      Top = 56
      Width = 137
      Height = 25
      AutoSize = False
      Caption = #1044#1077#1085#1077#1075
      Color = clLime
      ParentColor = False
    end
  end
  object Panel3: TPanel
    Left = 536
    Top = 88
    Width = 153
    Height = 89
    TabOrder = 3
    Visible = False
    object SBAction1: TSpeedButton
      Left = 16
      Top = 8
      Width = 113
      Height = 25
      Caption = #1042#1099#1090#1072#1097#1080#1090#1100' '#1082#1072#1088#1090#1099
      OnClick = SBAction1Click
    end
    object SBAction3: TSpeedButton
      Left = 16
      Top = 56
      Width = 113
      Height = 25
      Caption = #1055#1077#1088#1077#1093#1086#1076' '#1093#1086#1076#1072
      Enabled = False
      OnClick = SBAction3Click
    end
    object SBAction2: TSpeedButton
      Left = 16
      Top = 32
      Width = 113
      Height = 25
      Caption = #1055#1077#1088#1077#1081#1090#1080' '#1074' '#1087#1086#1082#1091#1087#1082#1072#1084
      Enabled = False
      OnClick = SBAction2Click
    end
  end
  object Panel4: TPanel
    Left = 536
    Top = 184
    Width = 153
    Height = 89
    TabOrder = 4
    Visible = False
    object Label5: TLabel
      Left = 8
      Top = 32
      Width = 137
      Height = 25
      AutoSize = False
      Caption = #1057#1087#1077#1094#1076#1077#1081#1089#1090#1074#1080#1077
      Color = clLime
      ParentColor = False
      OnClick = Label5Click
    end
    object Label4: TLabel
      Left = 8
      Top = 8
      Width = 137
      Height = 25
      AutoSize = False
      Caption = #1061#1086#1076#1080#1090' '#1080#1075#1088#1086#1082
      Color = clLime
      ParentColor = False
    end
    object Label6: TLabel
      Left = 8
      Top = 56
      Width = 137
      Height = 25
      AutoSize = False
      Caption = #1050#1086#1083#1080#1095#1077#1089#1090#1074#1086' '#1087#1088#1086#1082#1083#1103#1090#1080#1081'='
      Color = clLime
      ParentColor = False
      OnClick = Label5Click
    end
  end
end
