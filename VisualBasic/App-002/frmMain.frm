Imports System.Windows.Forms

Public Class MainForm
    Private Sub selectImageButton_Click(sender As Object, e As EventArgs) Handles selectImageButton.Click
        Dim openFileDialog As New OpenFileDialog()

        ' Set the file dialog properties
        openFileDialog.Filter = "Image Files|*.jpg;*.png;*.gif|All Files|*.*"
        openFileDialog.Title = "Select an Image"
        openFileDialog.Multiselect = False

        ' Show the file dialog and check if a file was selected
        If openFileDialog.ShowDialog() = DialogResult.OK Then
            ' Get the selected file's path
            Dim selectedImagePath As String = openFileDialog.FileName

            ' Check if the selected file is an image
            If IsImageFile(selectedImagePath) Then
                ' Load and display the selected image in the PictureBox
                pictureBox1.Image = Image.FromFile(selectedImagePath)
            Else
                MessageBox.Show("Please select a valid image file (JPG, PNG, or GIF).", "Invalid File", MessageBoxButtons.OK, MessageBoxIcon.Error)
            End If
        End If
    End Sub

    Private Function IsImageFile(filePath As String) As Boolean
        ' Check if the file extension is one of the allowed image formats
        Dim allowedExtensions As String() = {".jpg", ".png", ".gif"}
        Dim extension As String = IO.Path.GetExtension(filePath).ToLower()
        Return allowedExtensions.Contains(extension)
    End Function
End Class
