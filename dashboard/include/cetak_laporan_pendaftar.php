<?php
require '../../assets/libs/fpdf/fpdf.php';
require '../../koneksi/koneksi.php';

error_reporting(E_ALL);
ini_set('display_errors', 1); 

// Instansiasi kelas FPDF
//edit new fpdf & tambah margin
$pdf = new FPDF('L', 'mm', 'Legal');
$pdf->SetMargins(5, 5, 5, 5);
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

//edit teks judul
$pdf->Cell(0, 10, 'Laporan Pendaftar Magang Diskominfo Kota Semarang', 0, 1, 'C');
$pdf->Ln(10);

//tambah bidang
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 10, 'No', 1);
$pdf->Cell(30, 10, 'Nama', 1);
$pdf->Cell(10, 10, 'JK', 1);
$pdf->Cell(25, 10, 'Telepon', 1);
$pdf->Cell(25, 10, 'Tanggal Daftar', 1);
$pdf->Cell(40, 10, 'Asal Akademik', 1);
$pdf->Cell(40, 10, 'Jurusan', 1);
$pdf->Cell(80, 10, 'Bidang', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);

//edit query utk join dinas
$query = "SELECT * FROM pendaftaran a
          JOIN detail_pendaftaran c ON a.Id = c.id_user
          JOIN akun b ON b.id_user = a.Id
          JOIN dinas d ON d.Id = a.id_dinas";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

//tambah nama bidang
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(10, 10, $no++, 1);
    $pdf->Cell(30, 10, $row['nama'], 1);
    $pdf->Cell(10, 10, $row['jenis_kelamin'], 1);
    $pdf->Cell(25, 10, $row['telepon'], 1);
    $pdf->Cell(25, 10, $row['tanggal_daftar'], 1);
    $pdf->Cell(40, 10, $row['nama_akademik'], 1);
    $pdf->Cell(40, 10, $row['jurusan_akademik'], 1);
    $pdf->Cell(80, 10, $row['nama_bidang'], 1);
    $pdf->Ln();
}

$pdf->Output('D', 'laporan_pendaftar.pdf');
?>
