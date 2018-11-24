object Form1: TForm1
  Left = 170
  Top = 108
  Width = 861
  Height = 637
  Caption = 'Form1'
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
    Width = 700
    Height = 600
    OnMouseDown = Image1MouseDown
    OnMouseMove = Image1MouseMove
    OnMouseUp = Image1MouseUp
  end
  object SpeedButton1: TSpeedButton
    Left = 720
    Top = 432
    Width = 89
    Height = 49
    Caption = #1057#1090#1072#1088#1090
    OnClick = SpeedButton1Click
  end
  object Button1: TButton
    Left = 712
    Top = 56
    Width = 97
    Height = 33
    Caption = #1047#1072#1075#1088#1091#1079#1080#1090#1100' '#1087#1086#1083#1077
    TabOrder = 0
    OnClick = Button1Click
  end
  object Button2: TButton
    Left = 712
    Top = 96
    Width = 97
    Height = 33
    Caption = #1057#1086#1093#1088#1072#1085#1080#1090#1100' '#1087#1086#1083#1077
    TabOrder = 1
    OnClick = Button2Click
  end
  object Button3: TButton
    Left = 808
    Top = 240
    Width = 41
    Height = 33
    Caption = ' OK'
    Enabled = False
    TabOrder = 2
    OnClick = Button3Click
  end
  object Button4: TButton
    Left = 712
    Top = 176
    Width = 97
    Height = 33
    Caption = #1056#1080#1089#1086#1074#1072#1090#1100' '#1089#1072#1084#1086#1084#1091
    TabOrder = 3
    OnClick = Button4Click
  end
  object Button5: TButton
    Left = 712
    Top = 280
    Width = 97
    Height = 33
    Caption = #1057#1083#1091#1095#1072#1081#1085#1099#1081' '#1082#1086#1101#1092#1092
    TabOrder = 4
    OnClick = Button5Click
  end
  object LabeledEdit1: TLabeledEdit
    Left = 720
    Top = 248
    Width = 81
    Height = 21
    EditLabel.Width = 69
    EditLabel.Height = 13
    EditLabel.Caption = #1082#1086#1101#1092#1092#1080#1094#1080#1077#1085#1090
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 5
    OnChange = LabeledEdit1Change
  end
  object Button6: TButton
    Left = 704
    Top = 328
    Width = 121
    Height = 33
    Caption = #1053#1072#1088#1080#1089#1086#1074#1072#1090#1100' '#1089#1083#1091#1095#1072#1081#1085#1086' '
    TabOrder = 6
    OnClick = Button6Click
  end
  object LabeledEdit2: TLabeledEdit
    Left = 720
    Top = 560
    Width = 105
    Height = 21
    EditLabel.Width = 37
    EditLabel.Height = 13
    EditLabel.Caption = #1056#1077#1082#1086#1088#1076
    EditLabel.Font.Charset = DEFAULT_CHARSET
    EditLabel.Font.Color = clWindowText
    EditLabel.Font.Height = -11
    EditLabel.Font.Name = 'MS Sans Serif'
    EditLabel.Font.Style = []
    EditLabel.ParentFont = False
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 7
  end
  object LabeledEdit3: TLabeledEdit
    Left = 720
    Top = 512
    Width = 89
    Height = 21
    EditLabel.Width = 59
    EditLabel.Height = 13
    EditLabel.Caption = #1050#1086#1083#1080#1095#1077#1089#1090#1074#1086
    EditLabel.Font.Charset = DEFAULT_CHARSET
    EditLabel.Font.Color = clWindowText
    EditLabel.Font.Height = -11
    EditLabel.Font.Name = 'MS Sans Serif'
    EditLabel.Font.Style = []
    EditLabel.ParentFont = False
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 8
  end
  object Button7: TButton
    Left = 712
    Top = 136
    Width = 97
    Height = 33
    Caption = #1054#1095#1080#1089#1090#1080#1090#1100' '#1087#1086#1083#1077
    TabOrder = 9
    OnClick = Button7Click
  end
  object OpenDialog1: TOpenDialog
    Filter = #1088#1080#1089#1091#1085#1082#1080'|*.bmp*'
    Left = 712
    Top = 16
  end
  object SaveDialog1: TSaveDialog
    Filter = #1088#1080#1089#1091#1085#1082#1080'|*.bmp*'
    Left = 744
    Top = 16
  end
  object Timer1: TTimer
    Interval = 1
    OnTimer = Timer1Timer
    Left = 776
    Top = 16
  end
  object Timer2: TTimer
    Enabled = False
    Interval = 1
    OnTimer = Timer2Timer
    Left = 808
    Top = 16
  end
end
