import subprocess, time, os

# Buka browser Chrome/Edge ke file HTML lalu screenshot via PowerShell
script = r"""
Add-Type -AssemblyName System.Windows.Forms
Add-Type -AssemblyName System.Drawing

# Buka file di browser default
Start-Process "file:///c:/web-copy-php/laporan-folder2/struktur-mvc.html"
Start-Sleep -Seconds 4

# Ambil screenshot layar penuh
$screen = [System.Windows.Forms.Screen]::PrimaryScreen.Bounds
$bmp = New-Object System.Drawing.Bitmap $screen.Width, $screen.Height
$g = [System.Drawing.Graphics]::FromImage($bmp)
$g.CopyFromScreen($screen.Location, [System.Drawing.Point]::Empty, $screen.Size)
$bmp.Save("c:\web-copy-php\laporan-folder2\ss_mvc.png")
$g.Dispose()
$bmp.Dispose()
Write-Host "Screenshot saved"
"""

result = subprocess.run(
    ["powershell", "-Command", script],
    capture_output=True, text=True, timeout=30
)
print(result.stdout)
print(result.stderr)
