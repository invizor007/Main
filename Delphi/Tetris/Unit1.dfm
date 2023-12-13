object Form1: TForm1
  Left = 188
  Top = 116
  Width = 696
  Height = 441
  Color = clBtnFace
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'MS Sans Serif'
  Font.Style = []
  OldCreateOrder = False
  OnClose = FormClose
  OnCreate = FormCreate
  OnKeyDown = FormKeyDown
  OnPaint = FormPaint
  PixelsPerInch = 96
  TextHeight = 13
  object SpeedButton1: TSpeedButton
    Left = 392
    Top = 0
    Width = 73
    Height = 25
    Caption = 'Start'
    OnClick = SpeedButton1Click
  end
  object SpeedButton2: TSpeedButton
    Left = 464
    Top = 0
    Width = 73
    Height = 25
    Caption = 'Pause'
    OnClick = SpeedButton2Click
  end
  object SpeedButton3: TSpeedButton
    Left = 392
    Top = 24
    Width = 145
    Height = 25
    Caption = 'Restart Game'
    OnClick = SpeedButton3Click
  end
  object Label1: TLabel
    Left = 400
    Top = 248
    Width = 273
    Height = 81
    AutoSize = False
    WordWrap = True
  end
  object Label2: TLabel
    Left = 544
    Top = 80
    Width = 129
    Height = 25
    AutoSize = False
    Caption = #1057#1095#1077#1090': 0'
  end
  object SpeedButton4: TSpeedButton
    Left = 392
    Top = 168
    Width = 145
    Height = 25
    Caption = 'ShowFigure'
    OnClick = SpeedButton4Click
  end
  object DrawGrid1: TDrawGrid
    Left = 0
    Top = 0
    Width = 385
    Height = 385
    ColCount = 15
    DefaultColWidth = 24
    FixedCols = 0
    RowCount = 15
    FixedRows = 0
    Options = [goVertLine, goHorzLine]
    TabOrder = 0
    OnDrawCell = DrawGrid1DrawCell
    OnKeyDown = FormKeyDown
  end
  object LabeledEdit1: TLabeledEdit
    Left = 544
    Top = 16
    Width = 129
    Height = 21
    EditLabel.Width = 14
    EditLabel.Height = 13
    EditLabel.Caption = 'XC'
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 1
    Text = '15'
  end
  object LabeledEdit2: TLabeledEdit
    Left = 544
    Top = 56
    Width = 129
    Height = 21
    EditLabel.Width = 14
    EditLabel.Height = 13
    EditLabel.Caption = 'YC'
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 2
    Text = '15'
  end
  object DrawGrid2: TDrawGrid
    Left = 544
    Top = 104
    Width = 129
    Height = 129
    DefaultColWidth = 24
    FixedCols = 0
    FixedRows = 0
    Options = [goVertLine, goHorzLine]
    TabOrder = 3
    OnDrawCell = DrawGrid2DrawCell
    OnKeyDown = FormKeyDown
  end
  object CheckBox1: TCheckBox
    Left = 392
    Top = 48
    Width = 145
    Height = 25
    Caption = 'AI (On/Off)'
    TabOrder = 4
  end
  object LabeledEdit3: TLabeledEdit
    Left = 392
    Top = 104
    Width = 145
    Height = 21
    EditLabel.Width = 69
    EditLabel.Height = 13
    EditLabel.Caption = 'Figure Number'
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 5
  end
  object LabeledEdit4: TLabeledEdit
    Left = 392
    Top = 144
    Width = 145
    Height = 21
    EditLabel.Width = 64
    EditLabel.Height = 13
    EditLabel.Caption = 'Figure Rotate'
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 6
  end
  object Timer1: TTimer
    Interval = 500
    OnTimer = Timer1Timer
    Left = 400
    Top = 344
  end
end
