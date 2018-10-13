object Form1: TForm1
  Left = 204
  Top = 143
  Width = 1017
  Height = 380
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
  object SpeedButton1: TSpeedButton
    Left = 152
    Top = 19
    Width = 105
    Height = 25
    Caption = #1053#1072#1095#1072#1090#1100' '#1080#1075#1088#1091
    OnClick = SpeedButton1Click
  end
  object SpeedButton2: TSpeedButton
    Left = 264
    Top = 19
    Width = 105
    Height = 25
    Caption = #1047#1072#1074#1077#1088#1096#1080#1090#1100' '#1080#1075#1088#1091
    OnClick = SpeedButton2Click
  end
  object LaBankArrows: TLabel
    Left = 824
    Top = 288
    Width = 169
    Height = 41
    AutoSize = False
    Caption = #1050#1086#1083#1080#1095#1077#1089#1090#1074#1086' '#1089#1090#1088#1077#1083' '#1074' '#1073#1072#1085#1082#1077
    Color = clTeal
    ParentColor = False
    Visible = False
    WordWrap = True
  end
  object LaSpecOptions: TLabel
    Left = 488
    Top = 288
    Width = 329
    Height = 41
    AutoSize = False
    Caption = #1057#1087#1077#1094#1080#1072#1083#1100#1085#1086#1077' '#1089#1074#1086#1081#1089#1090#1074#1086
    Color = clTeal
    ParentColor = False
    Visible = False
    WordWrap = True
    OnClick = LaSpecOptionsClick
  end
  object LabeledEdit1: TLabeledEdit
    Left = 24
    Top = 24
    Width = 121
    Height = 21
    EditLabel.Width = 103
    EditLabel.Height = 13
    EditLabel.Caption = #1050#1086#1083#1080#1095#1077#1089#1090#1074#1086' '#1080#1075#1088#1086#1082#1086#1074
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 0
    Text = '4'
  end
  object Panel1: TPanel
    Left = 24
    Top = 56
    Width = 185
    Height = 273
    TabOrder = 1
    Visible = False
    object Image1: TImage
      Left = 16
      Top = 136
      Width = 150
      Height = 100
    end
    object laCurrPl2: TLabel
      Left = 16
      Top = 72
      Width = 145
      Height = 25
      AutoSize = False
      Caption = #1050#1086#1083#1080#1095#1077#1089#1090#1074#1086' '#1078#1080#1079#1085#1077#1081' = '
      Color = clTeal
      ParentColor = False
    end
    object laCurrPl3: TLabel
      Left = 16
      Top = 104
      Width = 145
      Height = 25
      AutoSize = False
      Caption = #1050#1086#1083#1080#1095#1077#1089#1090#1074#1086' '#1089#1090#1088#1077#1083' ='
      Color = clTeal
      ParentColor = False
    end
    object laCurrPl1: TLabel
      Left = 16
      Top = 8
      Width = 145
      Height = 25
      AutoSize = False
      Caption = #1048#1075#1088#1086#1082' '#1085#1086#1084#1077#1088' '
      Color = clTeal
      ParentColor = False
    end
    object SBShowRole: TSpeedButton
      Left = 16
      Top = 240
      Width = 145
      Height = 25
      Caption = #1055#1086#1082#1072#1079#1072#1090#1100' '#1088#1086#1083#1100
      OnClick = SBShowRoleClick
    end
    object Edit1: TEdit
      Left = 16
      Top = 40
      Width = 145
      Height = 21
      TabOrder = 0
    end
  end
  object Panel2: TPanel
    Left = 488
    Top = 56
    Width = 500
    Height = 185
    TabOrder = 2
    Visible = False
    object SpeedButton3: TSpeedButton
      Left = 19
      Top = 152
      Width = 145
      Height = 25
      Caption = #1041#1088#1086#1089#1080#1090#1100' '#1082#1091#1073#1080#1082#1080
      OnClick = SpeedButton3Click
    end
    object SpeedButton4: TSpeedButton
      Left = 179
      Top = 152
      Width = 145
      Height = 25
      Caption = #1055#1088#1080#1084#1077#1085#1080#1090#1100' '#1082#1091#1073#1080#1082#1080
      OnClick = SpeedButton4Click
    end
    object SpeedButton5: TSpeedButton
      Left = 339
      Top = 152
      Width = 145
      Height = 25
      Caption = #1055#1077#1088#1077#1093#1086#1076' '#1093#1086#1076#1072
      OnClick = SpeedButton5Click
    end
  end
  object Panel3: TPanel
    Left = 216
    Top = 56
    Width = 265
    Height = 273
    TabOrder = 3
    Visible = False
  end
  object Panel4: TPanel
    Left = 728
    Top = 16
    Width = 97
    Height = 25
    Caption = 'Panel4'
    TabOrder = 4
    Visible = False
    OnClick = Panel4Click
  end
  object CheckBox1: TCheckBox
    Left = 488
    Top = 248
    Width = 313
    Height = 17
    Caption = #1057#1073#1088#1072#1089#1099#1074#1072#1090#1100' '#1089#1090#1088#1077#1083#1091' '#1087#1088#1080' '#1087#1086#1083#1091#1095#1077#1085#1080#1080' '#1091#1088#1086#1085#1072
    TabOrder = 5
    Visible = False
  end
  object CheckBox2: TCheckBox
    Left = 488
    Top = 264
    Width = 321
    Height = 17
    Caption = #1041#1088#1072#1090#1100' '#1089#1090#1088#1077#1083#1099' '#1074#1084#1077#1089#1090#1086' '#1087#1086#1083#1091#1095#1077#1085#1080#1103' '#1091#1088#1086#1085#1072
    TabOrder = 6
    Visible = False
  end
end
