object Form1: TForm1
  Left = 192
  Top = 117
  Width = 836
  Height = 563
  Caption = 'Camel trip calculation'
  Color = 15395278
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
  object Main_SB1: TSpeedButton
    Left = 8
    Top = 232
    Width = 121
    Height = 38
    Caption = #1041#1088#1086#1089#1086#1082' '#1082#1091#1073#1080#1082#1072
    OnClick = Main_SB1Click
  end
  object Main_La1: TLabel
    Left = 16
    Top = 408
    Width = 217
    Height = 25
    AutoSize = False
  end
  object Main_SB2: TSpeedButton
    Left = 128
    Top = 232
    Width = 113
    Height = 38
    Caption = #1053#1086#1074#1099#1081' '#1088#1072#1091#1085#1076
    OnClick = Main_SB2Click
  end
  object SpeedButton1: TSpeedButton
    Left = 240
    Top = 232
    Width = 89
    Height = 38
    Caption = #1057#1085#1103#1090#1100' '#1086#1072#1079#1080#1089#1099
    OnClick = SpeedButton1Click
  end
  object Main_VLE: TValueListEditor
    Left = 8
    Top = 272
    Width = 321
    Height = 129
    Strings.Strings = (
      #1053#1086#1084#1077#1088'1 ('#1057#1080#1085#1080#1081') = 0, 0'
      #1053#1086#1084#1077#1088'2 ('#1046#1077#1083#1090#1099#1081')= 0, 1'
      #1053#1086#1084#1077#1088'3 ('#1047#1077#1083#1077#1085#1099#1081') = 0, 2'
      #1053#1086#1084#1077#1088'4 ('#1050#1088#1072#1089#1085#1099#1081') = 0, 3'
      #1053#1086#1084#1077#1088'5 ('#1041#1077#1083#1099#1081') = 0, 4')
    TabOrder = 0
    TitleCaptions.Strings = (
      #1042#1077#1088#1073#1083#1102#1076
      #1055#1072#1088#1072#1084#1077#1090#1088#1099)
    ColWidths = (
      119
      196)
  end
  object Main_DG: TDrawGrid
    Left = 376
    Top = 8
    Width = 433
    Height = 425
    DefaultColWidth = 80
    DefaultRowHeight = 80
    FixedCols = 0
    FixedRows = 0
    TabOrder = 1
    OnDrawCell = Main_DGDrawCell
  end
  object CamSet_GB: TGroupBox
    Left = 440
    Top = 448
    Width = 369
    Height = 73
    Caption = #1059#1089#1090#1072#1085#1086#1074#1080#1090#1100' '#1074#1077#1088#1073#1083#1102#1076#1072' '#1085#1072' '#1092#1080#1082#1089#1080#1088#1086#1074#1072#1085#1085#1091#1102' '#1103#1095#1077#1081#1082#1091
    TabOrder = 2
    object CamSet_Sb3: TSpeedButton
      Left = 332
      Top = 19
      Width = 33
      Height = 33
      Caption = 'OK'
      OnClick = CamSet_Sb3Click
    end
    object CamSet_Sb1: TSpeedButton
      Left = 276
      Top = 19
      Width = 57
      Height = 17
      GroupIndex = 1
      Down = True
      Caption = #1053#1072#1074#1077#1088#1093
    end
    object CamSet_Sb2: TSpeedButton
      Left = 276
      Top = 35
      Width = 57
      Height = 17
      GroupIndex = 1
      Caption = #1055#1086#1076' '#1085#1080#1079
    end
    object CamSet_La1: TLabel
      Left = 4
      Top = 16
      Width = 65
      Height = 33
      AutoSize = False
      Caption = #1059#1089#1090#1072#1085#1086#1074#1080#1090#1100' '#1074#1077#1088#1073#1083#1102#1076#1072
      WordWrap = True
    end
    object CamSet_La2: TLabel
      Left = 172
      Top = 19
      Width = 57
      Height = 33
      AutoSize = False
      Caption = #1053#1072' '#1103#1095#1077#1081#1082#1091
    end
    object CamSet_Cb1: TComboBox
      Left = 68
      Top = 19
      Width = 105
      Height = 21
      ItemHeight = 13
      TabOrder = 0
      Items.Strings = (
        #1089#1080#1085#1077#1075#1086
        #1078#1077#1083#1090#1086#1075#1086
        #1079#1077#1083#1077#1085#1086#1075#1086
        #1082#1088#1072#1089#1085#1086#1075#1086
        #1073#1077#1083#1086#1075#1086)
    end
    object CamSet_SE1: TSpinEdit
      Left = 228
      Top = 19
      Width = 49
      Height = 22
      MaxValue = 0
      MinValue = 0
      TabOrder = 1
      Value = 0
    end
  end
  object OaSet_GB: TGroupBox
    Left = 248
    Top = 448
    Width = 177
    Height = 73
    Caption = #1055#1086#1089#1090#1072#1074#1080#1090#1100' '#1086#1072#1079#1080#1089'\ '#1087#1091#1089#1090#1099#1085#1102
    TabOrder = 3
    object OaSet_La1: TLabel
      Left = 24
      Top = 43
      Width = 57
      Height = 22
      AutoSize = False
      Caption = #1053#1072' '#1103#1095#1077#1081#1082#1091
    end
    object OaSet_SB1: TSpeedButton
      Left = 24
      Top = 19
      Width = 65
      Height = 17
      GroupIndex = 2
      Down = True
      Caption = #1054#1072#1079#1080#1089' (+1)'
    end
    object OaSet_SB2: TSpeedButton
      Left = 88
      Top = 19
      Width = 73
      Height = 17
      GroupIndex = 2
      Caption = #1055#1091#1089#1090#1099#1085#1102'(-1)'
    end
    object OaSet_SB3: TSpeedButton
      Left = 136
      Top = 44
      Width = 29
      Height = 20
      Caption = 'OK'
      OnClick = OaSet_SB3Click
    end
    object OaSet_SE1: TSpinEdit
      Left = 80
      Top = 43
      Width = 49
      Height = 22
      MaxValue = 0
      MinValue = 0
      TabOrder = 0
      Value = 0
    end
  end
  object Forec_GB: TGroupBox
    Left = 8
    Top = 8
    Width = 249
    Height = 217
    Caption = #1055#1088#1086#1075#1085#1086#1079#1080#1088#1086#1074#1072#1085#1080#1077' '#1085#1072' '#1082#1086#1085#1077#1094' '#1088#1072#1091#1085#1076#1072
    TabOrder = 4
    object Forec_SB1: TSpeedButton
      Left = 8
      Top = 16
      Width = 185
      Height = 22
      Caption = #1057#1086#1089#1090#1072#1074#1080#1090#1100' '#1087#1088#1086#1075#1085#1086#1079
      OnClick = Forec_SB1Click
    end
    object Forec_SG: TStringGrid
      Left = 8
      Top = 48
      Width = 233
      Height = 161
      ColCount = 6
      DefaultColWidth = 36
      RowCount = 6
      TabOrder = 0
      ColWidths = (
        36
        36
        36
        36
        36
        36)
    end
  end
  object CheatThr_GB: TGroupBox
    Left = 8
    Top = 448
    Width = 217
    Height = 73
    Caption = #1042#1099#1082#1080#1085#1091#1090#1100' '#1086#1087#1088#1077#1076#1077#1083#1077#1085#1085#1099#1081' '#1082#1091#1073#1080#1082
    TabOrder = 5
    object CheatThr_SB1: TSpeedButton
      Left = 168
      Top = 25
      Width = 29
      Height = 20
      Caption = 'OK'
      OnClick = CheatThr_SB1Click
    end
    object CheatThr_La1: TLabel
      Left = 112
      Top = 27
      Width = 25
      Height = 22
      AutoSize = False
      Caption = #1085#1072
    end
    object CheatThr_SE1: TSpinEdit
      Left = 128
      Top = 24
      Width = 41
      Height = 22
      MaxValue = 0
      MinValue = 0
      TabOrder = 0
      Value = 0
    end
    object CheatThr_CB1: TComboBox
      Left = 8
      Top = 24
      Width = 97
      Height = 21
      ItemHeight = 13
      TabOrder = 1
      Items.Strings = (
        #1057#1080#1085#1080#1081
        #1046#1077#1083#1090#1099#1081
        #1047#1077#1083#1077#1085#1099#1081
        #1050#1088#1072#1089#1085#1099#1081
        #1041#1077#1083#1099#1081)
    end
  end
end
