object Form2: TForm2
  Left = 192
  Top = 117
  Width = 423
  Height = 337
  Caption = #1056#1077#1076#1072#1082#1090#1080#1088#1086#1074#1072#1090#1100' '#1089#1077#1090
  Color = clAqua
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'MS Sans Serif'
  Font.Style = []
  OldCreateOrder = False
  OnCreate = FormCreate
  PixelsPerInch = 96
  TextHeight = 13
  object SBMoveTo: TSpeedButton
    Left = 184
    Top = 32
    Width = 41
    Height = 25
    Caption = '=>'
    OnClick = SBMoveToClick
  end
  object SBMoveFrom: TSpeedButton
    Left = 184
    Top = 64
    Width = 41
    Height = 25
    Caption = '<='
    OnClick = SBMoveFromClick
  end
  object SBOK: TSpeedButton
    Left = 64
    Top = 208
    Width = 89
    Height = 33
    Caption = 'OK'
    OnClick = SBOKClick
  end
  object SBCancel: TSpeedButton
    Left = 248
    Top = 208
    Width = 89
    Height = 33
    Caption = #1054#1090#1084#1077#1085#1072
    OnClick = SBCancelClick
  end
  object LaLB2Count: TLabel
    Left = 184
    Top = 104
    Width = 41
    Height = 25
    Alignment = taCenter
    AutoSize = False
    Caption = '10'
    Font.Charset = DEFAULT_CHARSET
    Font.Color = clWindowText
    Font.Height = -16
    Font.Name = 'MS Sans Serif'
    Font.Style = []
    ParentFont = False
  end
  object SBFileLoad: TSpeedButton
    Left = 120
    Top = 248
    Width = 193
    Height = 25
    Caption = #1047#1072#1075#1088#1091#1079#1082#1072' '#1080#1079' '#1092#1072#1081#1083#1072
    OnClick = SBFileLoadClick
  end
  object SBFileSave: TSpeedButton
    Left = 120
    Top = 272
    Width = 193
    Height = 25
    Caption = #1057#1086#1093#1088#1072#1085#1077#1085#1080#1077' '#1074' '#1092#1072#1081#1083
    OnClick = SBFileSaveClick
  end
  object ListBox1: TListBox
    Left = 16
    Top = 8
    Width = 161
    Height = 129
    ItemHeight = 13
    TabOrder = 0
  end
  object ListBox2: TListBox
    Left = 232
    Top = 8
    Width = 161
    Height = 129
    ItemHeight = 13
    TabOrder = 1
  end
  object LEPlayerCount: TLabeledEdit
    Left = 240
    Top = 168
    Width = 121
    Height = 21
    EditLabel.Width = 103
    EditLabel.Height = 13
    EditLabel.Caption = #1050#1086#1083#1080#1095#1077#1089#1090#1074#1086' '#1080#1075#1088#1086#1082#1086#1074
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 2
    Text = '3'
  end
  object CBNameSet: TComboBox
    Left = 32
    Top = 168
    Width = 145
    Height = 21
    ItemHeight = 13
    ItemIndex = 0
    TabOrder = 3
    Text = #1055#1077#1088#1074#1072#1103' '#1080#1075#1088#1072
    OnChange = CBNameSetChange
    Items.Strings = (
      #1055#1077#1088#1074#1072#1103' '#1080#1075#1088#1072
      #1041#1086#1083#1100#1096#1080#1077' '#1076#1077#1085#1100#1075#1080
      #1054#1087#1072#1089#1085#1099#1077' '#1089#1074#1103#1079#1080
      #1053#1072#1088#1091#1096#1077#1085#1080#1077' '#1088#1072#1074#1085#1086#1074#1077#1089#1080#1103
      #1044#1077#1088#1077#1074#1077#1085#1089#1082#1072#1103' '#1087#1083#1086#1097#1072#1076#1100
      #1055#1086#1083#1100#1079#1086#1074#1072#1090#1077#1083#1100#1089#1082#1080#1081'1'
      #1055#1086#1083#1100#1079#1086#1074#1072#1090#1077#1083#1100#1089#1082#1080#1081'2'
      #1055#1086#1083#1100#1079#1086#1074#1072#1090#1077#1083#1100#1089#1082#1080#1081'3'
      #1055#1086#1083#1100#1079#1086#1074#1072#1090#1077#1083#1100#1089#1082#1080#1081'4'
      #1055#1086#1083#1100#1079#1086#1074#1072#1090#1077#1083#1100#1089#1082#1080#1081'5')
  end
  object OpenDialog1: TOpenDialog
    Left = 176
    Top = 216
  end
  object SaveDialog1: TSaveDialog
    Left = 208
    Top = 216
  end
end
