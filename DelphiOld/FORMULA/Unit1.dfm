object Form1: TForm1
  Left = 2
  Top = 0
  Width = 986
  Height = 737
  Caption = 'Form1'
  Color = clBtnFace
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'MS Sans Serif'
  Font.Style = []
  OldCreateOrder = False
  OnCreate = FormCreate
  OnPaint = FormPaint
  PixelsPerInch = 96
  TextHeight = 13
  object SpeedButton1: TSpeedButton
    Left = 752
    Top = 0
    Width = 41
    Height = 25
    Caption = 'OK'
    OnClick = SpeedButton1Click
  end
  object PaintBox1: TPaintBox
    Left = 0
    Top = 0
    Width = 701
    Height = 701
  end
  object SpeedButton2: TSpeedButton
    Left = 792
    Top = 0
    Width = 49
    Height = 25
    Caption = 'Clear'
    OnClick = SpeedButton2Click
  end
  object Shape1: TShape
    Left = 840
    Top = 0
    Width = 33
    Height = 25
    Brush.Color = clBlack
    OnMouseDown = Shape1MouseDown
  end
  object LabeledEdit1: TLabeledEdit
    Left = 704
    Top = 24
    Width = 273
    Height = 21
    EditLabel.Width = 37
    EditLabel.Height = 13
    EditLabel.Caption = 'Formula'
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 0
    Text = '2*x'
    OnChange = LabeledEdit1Change
  end
  object CheckBox1: TCheckBox
    Left = 880
    Top = 0
    Width = 97
    Height = 25
    Caption = #1055#1086#1074#1077#1088#1093' '#1080#1083#1080' '#1085#1077#1090
    TabOrder = 1
  end
  object LabeledEdit3: TLabeledEdit
    Left = 704
    Top = 104
    Width = 41
    Height = 21
    EditLabel.Width = 38
    EditLabel.Height = 13
    EditLabel.Caption = #1064#1090#1088#1080#1093'X'
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 2
    Text = '20'
  end
  object LabeledEdit4: TLabeledEdit
    Left = 744
    Top = 104
    Width = 41
    Height = 21
    EditLabel.Width = 38
    EditLabel.Height = 13
    EditLabel.Caption = #1064#1090#1088#1080#1093'Y'
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 3
    Text = '20'
  end
  object LabeledEdit5: TLabeledEdit
    Left = 704
    Top = 64
    Width = 129
    Height = 21
    EditLabel.Width = 44
    EditLabel.Height = 13
    EditLabel.Caption = 'ShtrihEIX'
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 4
    Text = '1'
  end
  object LabeledEdit6: TLabeledEdit
    Left = 832
    Top = 64
    Width = 145
    Height = 21
    EditLabel.Width = 44
    EditLabel.Height = 13
    EditLabel.Caption = 'ShtrihEIY'
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 5
    Text = '1'
  end
  object LabeledEdit2: TLabeledEdit
    Left = 792
    Top = 104
    Width = 89
    Height = 21
    EditLabel.Width = 70
    EditLabel.Height = 13
    EditLabel.Caption = #1084#1072#1089#1096#1090#1072#1073' '#1087#1086' X'
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 6
    Text = '1'
  end
  object LabeledEdit7: TLabeledEdit
    Left = 880
    Top = 104
    Width = 97
    Height = 21
    EditLabel.Width = 71
    EditLabel.Height = 13
    EditLabel.Caption = #1052#1072#1089#1096#1090#1072#1073' '#1087#1086' Y'
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 7
    Text = '1'
  end
  object ColorDialog1: TColorDialog
    Ctl3D = True
    Left = 808
    Top = 176
  end
end
