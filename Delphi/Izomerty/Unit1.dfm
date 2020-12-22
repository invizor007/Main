object Form1: TForm1
  Left = 300
  Top = 116
  Width = 748
  Height = 444
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
  object Image1: TImage
    Left = 0
    Top = 0
    Width = 401
    Height = 401
    OnMouseDown = Image1MouseDown
    OnMouseMove = Image1MouseMove
  end
  object ImageL: TImage
    Left = 440
    Top = 40
    Width = 129
    Height = 257
    OnClick = ImageLClick
  end
  object ImageR: TImage
    Left = 576
    Top = 40
    Width = 129
    Height = 257
    OnClick = ImageRClick
  end
  object ImageUp: TImage
    Left = 440
    Top = 16
    Width = 265
    Height = 25
    OnClick = ImageUpClick
  end
  object ImageDown: TImage
    Left = 440
    Top = 296
    Width = 265
    Height = 25
    OnClick = ImageDownClick
  end
  object SpeedButton1: TSpeedButton
    Left = 440
    Top = 320
    Width = 89
    Height = 25
    GroupIndex = 2
    Caption = #1055#1086#1089#1090#1072#1074#1080#1090#1100
  end
  object SpeedButton2: TSpeedButton
    Left = 616
    Top = 320
    Width = 89
    Height = 25
    GroupIndex = 2
    Caption = #1057#1090#1077#1088#1077#1090#1100
  end
  object SpeedButton3: TSpeedButton
    Left = 528
    Top = 320
    Width = 89
    Height = 25
    GroupIndex = 2
    Down = True
    Caption = #1048#1085#1092#1086#1088#1084#1072#1094#1080#1103
  end
  object Label1: TLabel
    Left = 456
    Top = 352
    Width = 241
    Height = 25
    AutoSize = False
  end
  object SpeedButton4: TSpeedButton
    Left = 440
    Top = 384
    Width = 89
    Height = 25
    Caption = #1047#1072#1087#1086#1083#1085#1080#1090#1100
    OnClick = SpeedButton4Click
  end
  object SpeedButton5: TSpeedButton
    Left = 528
    Top = 384
    Width = 89
    Height = 25
    Caption = #1054#1095#1080#1089#1090#1080#1090#1100
    OnClick = SpeedButton5Click
  end
  object SpeedButton6: TSpeedButton
    Left = 616
    Top = 384
    Width = 89
    Height = 25
    Caption = #1057#1083#1091#1095#1072#1081#1085#1086
    OnClick = SpeedButton6Click
  end
end
