object Form1: TForm1
  Left = 192
  Top = 111
  Width = 696
  Height = 476
  Color = clBtnFace
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'MS Sans Serif'
  Font.Style = []
  KeyPreview = True
  OldCreateOrder = False
  OnKeyDown = FormKeyDown
  PixelsPerInch = 96
  TextHeight = 13
  object Label1: TLabel
    Left = 16
    Top = 144
    Width = 305
    Height = 17
    AutoSize = False
    Caption = #1051#1086#1075
    Color = clSilver
    ParentColor = False
  end
  object Label2: TLabel
    Left = 344
    Top = 208
    Width = 65
    Height = 17
    AutoSize = False
    Caption = #1069#1076#1080#1090
    Color = clSilver
    ParentColor = False
  end
  object SpeedButton1: TSpeedButton
    Left = 16
    Top = 8
    Width = 193
    Height = 33
    Caption = #1053#1072#1095#1072#1090#1100' '#1079#1072#1087#1080#1089#1100' (F2)'
    OnClick = keymouse_record
  end
  object SpeedButton2: TSpeedButton
    Left = 216
    Top = 8
    Width = 193
    Height = 33
    Caption = #1053#1072#1095#1072#1090#1100' '#1074#1086#1089#1087#1088#1086#1080#1079#1074#1077#1076#1077#1085#1080#1077' (F3)'
    OnClick = keymouse_repeat
  end
  object SpeedButton3: TSpeedButton
    Left = 424
    Top = 8
    Width = 193
    Height = 33
    Caption = #1057#1090#1086#1087' (ESC)'
    OnClick = stop_click
  end
  object Label3: TLabel
    Left = 344
    Top = 240
    Width = 65
    Height = 17
    AutoSize = False
    Caption = #1052#1077#1084#1086
    Color = clSilver
    ParentColor = False
  end
  object Label4: TLabel
    Left = 336
    Top = 400
    Width = 65
    Height = 17
    AutoSize = False
    Caption = #1050#1086#1084#1073#1086#1073#1086#1082#1089
    Color = clSilver
    ParentColor = False
  end
  object SpeedButton4: TSpeedButton
    Left = 344
    Top = 144
    Width = 289
    Height = 33
    Caption = #1057#1090#1077#1088#1077#1090#1100' '#1087#1088#1086#1090#1086#1082#1086#1083
    OnClick = delete_protocol
  end
  object Memo1: TMemo
    Left = 16
    Top = 168
    Width = 305
    Height = 257
    Enabled = False
    TabOrder = 0
  end
  object Edit1: TEdit
    Left = 416
    Top = 208
    Width = 225
    Height = 21
    TabOrder = 1
  end
  object Memo2: TMemo
    Left = 416
    Top = 240
    Width = 225
    Height = 137
    TabOrder = 2
  end
  object ComboBox1: TComboBox
    Left = 416
    Top = 400
    Width = 225
    Height = 21
    ItemHeight = 13
    TabOrder = 3
    Items.Strings = (
      '1'
      '2'
      '3')
  end
end
