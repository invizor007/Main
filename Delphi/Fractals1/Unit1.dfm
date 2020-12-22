object Form1: TForm1
  Left = 192
  Top = 118
  Width = 424
  Height = 532
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
  object Image1: TImage
    Left = 0
    Top = 88
    Width = 401
    Height = 401
  end
  object Label1: TLabel
    Left = 224
    Top = 16
    Width = 113
    Height = 25
    AutoSize = False
    Caption = #1043#1083#1091#1073#1080#1085#1072' '#1088#1077#1082#1091#1088#1089#1080#1080
    Color = clAqua
    ParentColor = False
  end
  object RadioGroup1: TRadioGroup
    Left = 0
    Top = 8
    Width = 217
    Height = 73
    Color = clAqua
    ItemIndex = 0
    Items.Strings = (
      #1050#1088#1080#1074#1072#1103' '#1050#1086#1093#1072
      #1057#1085#1077#1078#1085#1080#1082#1072' '#1050#1086#1093#1072' '
      #1058#1088#1077#1091#1075#1086#1083#1100#1085#1080#1082#1080' '#1050#1086#1093#1072)
    ParentColor = False
    TabOrder = 0
    OnClick = RadioGroup1Click
  end
  object SpinEdit1: TSpinEdit
    Left = 224
    Top = 48
    Width = 121
    Height = 22
    MaxValue = 6
    MinValue = 0
    TabOrder = 1
    Value = 6
    OnChange = SpinEdit1Change
  end
end
