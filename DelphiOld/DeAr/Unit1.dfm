object Form1: TForm1
  Left = 0
  Top = 0
  BorderStyle = bsNone
  ClientHeight = 718
  ClientWidth = 1021
  Color = clBtnFace
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'MS Sans Serif'
  Font.Style = []
  OldCreateOrder = False
  WindowState = wsMaximized
  OnCreate = FormCreate
  OnMouseMove = FormMouseMove
  OnPaint = FormPaint
  PixelsPerInch = 96
  TextHeight = 13
  object Label1: TLabel
    Left = 10
    Top = 640
    Width = 96
    Height = 25
    AutoSize = False
    Color = clYellow
    ParentColor = False
  end
  object Label2: TLabel
    Left = 10
    Top = 700
    Width = 96
    Height = 25
    AutoSize = False
    Color = clYellow
    ParentColor = False
  end
  object Label3: TLabel
    Left = 176
    Top = 648
    Width = 57
    Height = 25
    AutoSize = False
    Color = clBtnFace
    ParentColor = False
  end
  object Label4: TLabel
    Left = 152
    Top = 676
    Width = 113
    Height = 25
    AutoSize = False
    Color = clBtnFace
    ParentColor = False
  end
  object Label5: TLabel
    Left = 826
    Top = 656
    Width = 96
    Height = 25
    AutoSize = False
    Color = clYellow
    ParentColor = False
  end
  object Label6: TLabel
    Left = 824
    Top = 688
    Width = 97
    Height = 25
    AutoSize = False
    Color = clYellow
    ParentColor = False
  end
  object Button1: TButton
    Left = 528
    Top = 704
    Width = 75
    Height = 25
    Caption = 'OK'
    TabOrder = 0
    OnClick = Button1Click
  end
  object LabeledEdit1: TLabeledEdit
    Left = 352
    Top = 648
    Width = 121
    Height = 21
    EditLabel.Width = 6
    EditLabel.Height = 13
    EditLabel.Caption = '1'
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 1
    Text = '500'
    OnKeyPress = LabeledEdit1KeyPress
  end
  object LabeledEdit2: TLabeledEdit
    Left = 352
    Top = 704
    Width = 121
    Height = 21
    EditLabel.Width = 6
    EditLabel.Height = 13
    EditLabel.Caption = '2'
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 2
    Text = '400'
    OnKeyPress = LabeledEdit2KeyPress
  end
  object LabeledEdit3: TLabeledEdit
    Left = 496
    Top = 648
    Width = 121
    Height = 21
    EditLabel.Width = 6
    EditLabel.Height = 13
    EditLabel.Caption = 'k'
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 3
    Text = '0.001'
    OnKeyPress = LabeledEdit3KeyPress
  end
  object Button2: TButton
    Left = 696
    Top = 656
    Width = 75
    Height = 25
    Caption = 'Stop'
    TabOrder = 4
    OnClick = Button2Click
  end
  object Timer1: TTimer
    Enabled = False
    Interval = 1
    OnTimer = Timer1Timer
    Left = 640
    Top = 672
  end
end
