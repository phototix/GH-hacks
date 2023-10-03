Option Explicit

Private Declare Function SetWindowPos Lib "user32" (ByVal hWnd As Long, ByVal hWndInsertAfter As Long, ByVal x As Long, ByVal Y As Long, ByVal cx As Long, ByVal cy As Long, ByVal wFlags As Long) As Long

Private Const HWND_TOPMOST = -1 'bring to top and stay there
Private Const HWND_NOTOPMOST = -2 'put the window into a normal position

Private Const SWP_NOMOVE = &H2 'don't move window
Private Const SWP_NOSIZE = &H1 'don't size window

Private Declare Function GetForegroundWindow Lib "user32" () As Long

Dim costAmount As Currency
Dim marginAmount As Currency
Dim salesAmount As Currency
Dim qtySalesAmount As Currency
Dim qtyCostAmount As Currency

Dim SumSalesAmount As Currency
Dim SumCostAmount As Currency
Dim SumMarginAmount As Currency
Dim PerMarginAmount As Currency

Dim TemMarginValue As Currency

Private Function FullCalculator()

costAmount = Val(frmMain.txtCost.Text)
marginAmount = Val(frmMain.txtMargin.Text)
salesAmount = Val(frmMain.txtSales.Text)
qtyCostAmount = Val(frmMain.txtCostQTY.Text)

If fraCost.Enabled = True And fraMargin.Enabled = True And fraSales.Enabled = False Then
    If cmbMargin.ListIndex = 0 Then
        SumSalesAmount = (costAmount + marginAmount)
        SumMarginAmount = marginAmount
        If SumSalesAmount = 0 Then
            SumSalesAmount = 1
        End If
        txtSales.Text = Format(SumSalesAmount, "#,##0.00")
        PerMarginAmount = (SumSalesAmount - costAmount) / SumSalesAmount * 100
        txtSales.Text = Format(SumSalesAmount, "#,##0.00")
    ElseIf cmbMargin.ListIndex = 1 Then
        If marginAmount = 100 Then
        Else
        PerMarginAmount = marginAmount
        TemMarginValue = marginAmount / 100
        SumSalesAmount = (costAmount / (1 - TemMarginValue))
        SumMarginAmount = (SumSalesAmount - costAmount)
        txtSales.Text = Format(SumSalesAmount, "#,##0.00")
        End If
    End If
    lblDisplay.Caption = Format(SumSalesAmount, "#,##0.00")
    lblTitle.Caption = "SALES AMOUNT"
    If qtyCostAmount = 0 Then
        qtyCostAmount = 1
    End If
    lblMarginMini.Caption = " " & Format(SumMarginAmount * qtyCostAmount, "#,##0.00")
    lblSalesMini.Visible = False
    lblTotalMini.Visible = True
    lblTotalMini.Caption = " " & Format(SumSalesAmount * qtyCostAmount, "#,##0.00")
ElseIf fraCost.Enabled = True And fraMargin.Enabled = False And fraSales.Enabled = True Then
    cmbMargin.ListIndex = 0
    If costAmount = 0 Then
        costAmount = 1
    End If
    If salesAmount = 0 Then
        salesAmount = 1
    End If
    SumMarginAmount = salesAmount - costAmount
    PerMarginAmount = (salesAmount - costAmount) / salesAmount * 100
    SumSalesAmount = (SumMarginAmount + costAmount) * qtyCostAmount
    txtMargin.Text = Format(SumMarginAmount, "#,##0.00")
    lblDisplay.Caption = Format(SumMarginAmount, "#,##0.00")
    lblTitle.Caption = "MARGIN AMOUNT"
    lalMarginPer.Caption = " " & Format(PerMarginAmount, "#,##0.00") & "%"
    If qtyCostAmount = 0 Then
        qtyCostAmount = 1
    End If
    lblMarginMini.Caption = " " & Format(SumMarginAmount * qtyCostAmount, "#,##0.00")
    lblSalesMini.Visible = False
    lblTotalMini.Visible = True
    lblTotalMini.Caption = " " & Format(SumMarginAmount * qtyCostAmount, "#,##0.00")
ElseIf fraCost.Enabled = False And fraMargin.Enabled = True And fraSales.Enabled = True Then
    If cmbMargin.ListIndex = 0 Then
        SumCostAmount = salesAmount - marginAmount
        SumMarginAmount = marginAmount
        If salesAmount = 0 Then
            salesAmount = 1
        End If
        PerMarginAmount = (salesAmount - SumCostAmount) / salesAmount * 100
        SumSalesAmount = salesAmount
        txtCost.Text = Format(SumCostAmount, "#,##0.00")
    ElseIf cmbMargin.ListIndex = 1 Then
        If marginAmount = 100 Then
        Else
            PerMarginAmount = marginAmount
            TemMarginValue = marginAmount / 100
            SumSalesAmount = salesAmount
            SumCostAmount = salesAmount - (salesAmount * TemMarginValue)
            txtCost.Text = Format(SumCostAmount, "#,##0.00")
            SumMarginAmount = SumSalesAmount - SumCostAmount
        End If
    End If
    lblDisplay.Caption = Format(SumCostAmount, "#,##0.00")
    lblTitle.Caption = "COST AMOUNT"
    If qtyCostAmount = 0 Then
        qtyCostAmount = 1
    End If
    lblMarginMini.Caption = " " & Format(SumMarginAmount * qtyCostAmount, "#,##0.00")
    lblSalesMini.Visible = False
    lblTotalMini.Visible = False
End If

lblCost.Caption = Format(SumCostAmount, "#,##0.00")
If fraCost.Enabled = True And fraMargin.Enabled = True And fraSales.Enabled = False Then
    If cmbMargin.ListIndex = 0 Then
        lblMargin.Caption = Format(PerMarginAmount, "#,##0.00") & " %"
    ElseIf cmbMargin.ListIndex = 1 Then
        lblMargin.Caption = Format(SumMarginAmount, "#,##0.00")
        
    End If
ElseIf fraCost.Enabled = False And fraMargin.Enabled = True And fraSales.Enabled = True Then
    If cmbMargin.ListIndex = 0 Then
        lblMargin.Caption = Format(PerMarginAmount, "#,##0.00") & " %"
    ElseIf cmbMargin.ListIndex = 1 Then
        lblMargin.Caption = Format(SumMarginAmount, "#,##0.00")
        
    End If
End If
lblSales.Caption = Format(SumSalesAmount, "#,##0.00")

End Function

Private Function SalesCal()

End Function

Private Function MarginCal()

End Function

Private Function CostCal()

SumCostAmount = costAmount * qtyCostAmount
Call FullCalculator

End Function

Private Sub chkCost_Click()

Call FullCalculator
Call CostCal

End Sub

Private Sub chkMargin_Click()

Call FullCalculator
Call CostCal

End Sub

Private Sub chkSales_Click()

Call FullCalculator
Call CostCal

End Sub

Private Sub cmbMargin_Change()
Call FullCalculator
Call CostCal
End Sub

Private Sub Timer1_Timer()
'If the window on top is not this window...
If Me.hWnd <> GetForegroundWindow Then
'Make this form be on top
Call SetWindowPos(GetForegroundWindow, HWND_NOTOPMOST, 0, 0, 0, 0, SWP_NOMOVE Or SWP_NOSIZE)
'Make the window on top below this form
Call SetWindowPos(hWnd, HWND_TOPMOST, 0, 0, 0, 0, SWP_NOMOVE Or SWP_NOSIZE)
End If
End Sub

Private Sub txtCost_Change()
Call FullCalculator
Call CostCal
End Sub

Private Sub txtCost_GotFocus()

   With txtCost
      .SelStart = 0
      .SelLength = Len(.Text)
   End With

End Sub

Private Sub txtMargin_Change()
Call FullCalculator
Call CostCal
End Sub

Private Sub txtMargin_GotFocus()

   With txtMargin
      .SelStart = 0
      .SelLength = Len(.Text)
   End With

End Sub

Private Sub txtSales_Change()
Call FullCalculator
Call CostCal
End Sub

Private Sub txtSales_GotFocus()

   With txtSales
      .SelStart = 0
      .SelLength = Len(.Text)
   End With

End Sub

Private Sub txtCostQTY_Change()
Call FullCalculator
Call CostCal
End Sub

Private Sub txtCostQTY_GotFocus()

   With txtCostQTY
      .SelStart = 0
      .SelLength = Len(.Text)
   End With

End Sub


Private Sub cmdCost_Click()
fraCost.Left = 4200
fraCost.Top = 120
fraCost.Enabled = False
fraMargin.Left = 240
fraMargin.Top = 2760
fraMargin.Enabled = True
fraSales.Left = 240
fraSales.Top = 4440
fraSales.Enabled = True
lblTitle.Caption = "COST AMOUNT"
lalMarginPer.Left = 4320
lalMarginPer.Top = 7080
Call FullCalculator
End Sub

Private Sub cmdMargin_Click()
fraCost.Left = 240
fraCost.Top = 2760
fraCost.Enabled = True
fraMargin.Left = 4200
fraMargin.Top = 1800
fraMargin.Enabled = False
fraSales.Left = 240
fraSales.Top = 4440
fraSales.Enabled = True
lblTitle.Caption = "MARGIN AMOUNT"
lalMarginPer.Left = 2880
lalMarginPer.Top = 7080
Call FullCalculator
End Sub

Private Sub cmdSales_Click()
fraCost.Left = 240
fraCost.Top = 2760
fraCost.Enabled = True
fraMargin.Left = 240
fraMargin.Top = 4440
fraMargin.Enabled = True
fraSales.Left = 4200
fraSales.Top = 3480
fraSales.Enabled = False
lblTitle.Caption = "SALES AMOUNT"
lalMarginPer.Left = 4320
lalMarginPer.Top = 7080
Call FullCalculator
End Sub

Private Sub Form_Load()
frmMain.Width = 4275
fraCost.Left = 4200
fraCost.Top = 120
fraMargin.Left = 4200
fraMargin.Top = 1800
fraSales.Left = 4200
fraSales.Top = 3480
cmbMargin.ListIndex = 0
txtCost.Text = "1.00"
txtMargin.Text = "1.00"
cmbMargin.ListIndex = 0
Call FullCalculator
End Sub
