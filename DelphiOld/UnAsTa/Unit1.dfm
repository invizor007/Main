object Form1: TForm1
  Left = 192
  Top = 107
  Width = 526
  Height = 542
  Caption = 
    #1058#1072#1073#1083#1080#1094#1072' '#1089#1080#1084#1074#1086#1083#1086#1074' unicode\ascii('#1086#1090#1086#1073#1088#1072#1078#1072#1077#1090#1089#1103' '#1090#1086' '#1095#1090#1086' '#1087#1086#1079#1074#1086#1083#1103#1077#1090#31' de' +
    'lphi)'
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
  object SpeedButton1: TSpeedButton
    Left = 0
    Top = 480
    Width = 105
    Height = 25
    GroupIndex = 1
    Down = True
    Caption = 'ascii'
    OnClick = SpeedButton1Click
  end
  object SpeedButton2: TSpeedButton
    Tag = 1
    Left = 104
    Top = 480
    Width = 105
    Height = 25
    GroupIndex = 1
    Caption = 'unicode'
    OnClick = SpeedButton1Click
  end
end
