object Form2: TForm2
  Left = 846
  Top = 0
  Width = 180
  Height = 738
  Color = clBtnFace
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'MS Sans Serif'
  Font.Style = []
  OldCreateOrder = False
  OnClose = FormClose
  PixelsPerInch = 96
  TextHeight = 13
  object Label1: TLabel
    Left = 8
    Top = 120
    Width = 153
    Height = 25
    AutoSize = False
  end
  object LabeledEdit1: TLabeledEdit
    Left = 8
    Top = 24
    Width = 153
    Height = 25
    EditLabel.Width = 14
    EditLabel.Height = 13
    EditLabel.Caption = 'vm'
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 0
    OnKeyPress = LabeledEdit1KeyPress
  end
  object LabeledEdit2: TLabeledEdit
    Left = 8
    Top = 72
    Width = 153
    Height = 25
    EditLabel.Width = 9
    EditLabel.Height = 13
    EditLabel.Caption = 'vr'
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 1
    OnKeyPress = LabeledEdit2KeyPress
  end
  object BitBtn1: TBitBtn
    Left = 8
    Top = 184
    Width = 153
    Height = 33
    TabOrder = 2
    OnClick = BitBtn1Click
    Kind = bkOK
  end
  object BitBtn2: TBitBtn
    Left = 8
    Top = 232
    Width = 153
    Height = 33
    Caption = 'Stop'
    Enabled = False
    TabOrder = 3
    OnClick = BitBtn2Click
    Kind = bkNo
  end
  object CheckBox1: TCheckBox
    Left = 8
    Top = 280
    Width = 153
    Height = 33
    Caption = 'Use LabeledEdits(3-6)'
    TabOrder = 4
    OnClick = CheckBox1Click
  end
  object LabeledEdit3: TLabeledEdit
    Left = 8
    Top = 336
    Width = 153
    Height = 25
    EditLabel.Width = 13
    EditLabel.Height = 13
    EditLabel.Caption = 'xm'
    Enabled = False
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 5
    OnKeyPress = LabeledEdit3KeyPress
  end
  object LabeledEdit4: TLabeledEdit
    Left = 8
    Top = 384
    Width = 153
    Height = 25
    EditLabel.Width = 13
    EditLabel.Height = 13
    EditLabel.Caption = 'ym'
    Enabled = False
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 6
    OnKeyPress = LabeledEdit4KeyPress
  end
  object LabeledEdit5: TLabeledEdit
    Left = 8
    Top = 432
    Width = 153
    Height = 25
    EditLabel.Width = 8
    EditLabel.Height = 13
    EditLabel.Caption = 'xr'
    Enabled = False
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 7
    OnKeyPress = LabeledEdit5KeyPress
  end
  object LabeledEdit6: TLabeledEdit
    Left = 8
    Top = 480
    Width = 153
    Height = 25
    EditLabel.Width = 8
    EditLabel.Height = 13
    EditLabel.Caption = 'yr'
    Enabled = False
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 8
    OnKeyPress = LabeledEdit6KeyPress
  end
end
