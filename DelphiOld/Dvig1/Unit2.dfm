object Form2: TForm2
  Left = 0
  Top = 600
  Width = 1024
  Height = 140
  Color = clBtnFace
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'MS Sans Serif'
  Font.Style = []
  OldCreateOrder = False
  PopupMenu = PopupMenu1
  OnClose = FormClose
  OnCreate = FormCreate
  PixelsPerInch = 96
  TextHeight = 13
  object Label1: TLabel
    Left = 0
    Top = 96
    Width = 337
    Height = 17
    AutoSize = False
    Caption = #1047#1072#1075#1088#1091#1079#1080#1090#1100
    Color = clYellow
    ParentColor = False
    OnClick = Label1Click
  end
  object Label2: TLabel
    Left = 640
    Top = 96
    Width = 73
    Height = 17
    AutoSize = False
    Color = clYellow
    ParentColor = False
  end
  object LabeledEdit1: TLabeledEdit
    Left = 0
    Top = 16
    Width = 80
    Height = 21
    EditLabel.Width = 77
    EditLabel.Height = 13
    EditLabel.Caption = #1091#1088#1086#1074#1077#1085#1100' '#1047#1077#1084#1083#1080
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 0
    Text = '550'
    OnKeyPress = LabeledEdit1KeyPress
  end
  object LabeledEdit2: TLabeledEdit
    Left = 80
    Top = 16
    Width = 80
    Height = 21
    EditLabel.Width = 63
    EditLabel.Height = 13
    EditLabel.Caption = #1053#1072#1095#1042#1099#1089#1086#1090#1072'+'
    EditLabel.OnClick = LabeledEdit2SubLabelClick
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 1
    Text = '50'
    OnKeyPress = LabeledEdit2KeyPress
  end
  object LabeledEdit3: TLabeledEdit
    Left = 160
    Top = 16
    Width = 80
    Height = 21
    EditLabel.Width = 67
    EditLabel.Height = 13
    EditLabel.Caption = #1053#1072#1095#1057#1082#1086#1088#1086#1089#1090#1100
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 2
    Text = '20'
    OnKeyPress = LabeledEdit3KeyPress
  end
  object LabeledEdit4: TLabeledEdit
    Left = 240
    Top = 16
    Width = 80
    Height = 21
    EditLabel.Width = 51
    EditLabel.Height = 13
    EditLabel.Caption = #1053#1072#1095' '#1091#1075#1086#1083'V'
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 3
    Text = '0'
    OnKeyPress = LabeledEdit4KeyPress
  end
  object LabeledEdit5: TLabeledEdit
    Left = 320
    Top = 16
    Width = 80
    Height = 21
    EditLabel.Width = 7
    EditLabel.Height = 13
    EditLabel.Caption = #1040
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 4
    OnKeyPress = LabeledEdit5KeyPress
  end
  object LabeledEdit6: TLabeledEdit
    Left = 400
    Top = 16
    Width = 80
    Height = 21
    EditLabel.Width = 16
    EditLabel.Height = 13
    EditLabel.Caption = '   '#1042
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 5
    OnKeyPress = LabeledEdit6KeyPress
  end
  object LabeledEdit7: TLabeledEdit
    Left = 480
    Top = 16
    Width = 80
    Height = 21
    EditLabel.Width = 6
    EditLabel.Height = 13
    EditLabel.Caption = 'g'
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 6
    Text = '10'
    OnKeyPress = LabeledEdit7KeyPress
  end
  object LabeledEdit9: TLabeledEdit
    Left = 640
    Top = 16
    Width = 80
    Height = 21
    EditLabel.Width = 36
    EditLabel.Height = 13
    EditLabel.Caption = 'Pixel('#1084')'
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 7
    Text = '0.1'
    OnKeyPress = LabeledEdit9KeyPress
  end
  object LabeledEdit10: TLabeledEdit
    Left = 720
    Top = 16
    Width = 80
    Height = 21
    EditLabel.Width = 33
    EditLabel.Height = 13
    EditLabel.Caption = #1042#1088#1077#1084#1103
    EditLabel.Font.Charset = DEFAULT_CHARSET
    EditLabel.Font.Color = clWindowText
    EditLabel.Font.Height = -11
    EditLabel.Font.Name = 'MS Sans Serif'
    EditLabel.Font.Style = []
    EditLabel.ParentFont = False
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 8
    Text = '1'
    OnKeyPress = LabeledEdit10KeyPress
  end
  object LabeledEdit8: TLabeledEdit
    Left = 560
    Top = 16
    Width = 80
    Height = 21
    EditLabel.Width = 34
    EditLabel.Height = 13
    EditLabel.Caption = #1059#1075#1086#1083' g'
    LabelPosition = lpAbove
    LabelSpacing = 3
    TabOrder = 9
    Text = '270'
    OnKeyPress = LabeledEdit8KeyPress
  end
  object StringGrid1: TStringGrid
    Left = 0
    Top = 40
    Width = 1009
    Height = 57
    ColCount = 12
    DefaultColWidth = 81
    RowCount = 2
    FixedRows = 0
    Options = [goFixedVertLine, goFixedHorzLine, goVertLine, goHorzLine]
    TabOrder = 10
  end
  object BitBtn1: TBitBtn
    Left = 488
    Top = 96
    Width = 49
    Height = 17
    Caption = 'New'
    TabOrder = 11
    OnClick = BitBtn1Click
    NumGlyphs = 2
  end
  object CheckBox1: TCheckBox
    Left = 336
    Top = 96
    Width = 73
    Height = 15
    Caption = 'Start/Stop'
    TabOrder = 12
    OnClick = CheckBox1Click
  end
  object CheckBox2: TCheckBox
    Left = 408
    Top = 96
    Width = 81
    Height = 15
    Caption = #1056#1080#1089#1086#1074#1072#1085#1080#1077
    TabOrder = 13
    OnClick = CheckBox2Click
  end
  object BitBtn2: TBitBtn
    Left = 536
    Top = 96
    Width = 49
    Height = 17
    Caption = 'Clear'
    TabOrder = 14
    OnClick = BitBtn2Click
  end
  object BitBtn3: TBitBtn
    Left = 584
    Top = 96
    Width = 57
    Height = 17
    Caption = 'Save'
    TabOrder = 15
    OnClick = BitBtn3Click
  end
  object ComboBox1: TComboBox
    Left = 800
    Top = 16
    Width = 41
    Height = 21
    ItemHeight = 13
    ItemIndex = 9
    TabOrder = 16
    Text = 'y'
    Items.Strings = (
      'vx'
      'vy'
      'va'
      'vm'
      'ax'
      'ay'
      'aa'
      'am'
      'x'
      'y'
      't')
  end
  object Edit1: TEdit
    Left = 840
    Top = 16
    Width = 97
    Height = 21
    TabOrder = 17
    Text = '0'
    OnKeyPress = Edit1KeyPress
  end
  object CheckBox3: TCheckBox
    Left = 712
    Top = 96
    Width = 81
    Height = 17
    Caption = 'SaveTraec'
    TabOrder = 18
  end
  object OpenPictureDialog1: TOpenPictureDialog
    Left = 823
    Top = 40
  end
  object Timer1: TTimer
    Interval = 1
    OnTimer = Timer1Timer
    Left = 855
    Top = 40
  end
  object SavePictureDialog1: TSavePictureDialog
    Left = 896
    Top = 40
  end
  object ColorDialog1: TColorDialog
    Ctl3D = True
    Left = 936
    Top = 40
  end
  object PopupMenu1: TPopupMenu
    Left = 784
    Top = 48
    object PmColor1: TMenuItem
      Caption = 'PenColor'
      OnClick = PmColor1Click
    end
    object PmColor2: TMenuItem
      Caption = 'BrushColor'
      OnClick = PmColor2Click
    end
    object Line1: TMenuItem
      Caption = 'Line'
      OnClick = Line1Click
    end
    object Rectangle1: TMenuItem
      Caption = 'Rectangle'
      OnClick = Rectangle1Click
    end
    object Circle1: TMenuItem
      Caption = 'Circle'
      OnClick = Circle1Click
    end
    object Ellipse1: TMenuItem
      Caption = 'Ellipse'
      OnClick = Ellipse1Click
    end
    object Carandash1: TMenuItem
      Caption = 'Carandash'
      OnClick = Carandash1Click
    end
    object Brush1: TMenuItem
      Caption = 'Brush'
      OnClick = Brush1Click
    end
  end
end
