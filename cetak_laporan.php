<?php
include 'con.php';
require('pdf/fpdf.php');

$idOrganisasi=$_POST['idOrganisasi'];

$pdf = new FPDF("L","cm","A4");

$pdf->SetMargins(2,1,1);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','B',11);
$pdf->Image('logo_sitakesi.png',1,1,2,2);
$pdf->SetX(3.2);
$pdf->MultiCell(19.5,0.5,'PSTI B - 2018',0,'L');
$pdf->SetX(3.2);
$pdf->MultiCell(19.5,0.5,'Universitas Pendidikan Indonesia',0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->SetX(3.2);
$pdf->MultiCell(19.5,0.5,'Jl. Veteran No. 8',0,'L');
$pdf->SetX(3.2);
$pdf->MultiCell(19.5,0.5,'telp: +622188326678 | email : psti@upi.edu',0,'L');
$pdf->Line(1,3.1,28.5,3.1);
$pdf->SetLineWidth(0.1);
$pdf->Line(1,3.2,28.5,3.2);
$pdf->SetLineWidth(0);
$pdf->ln(1);
$pdf->SetFont('Arial','B',16);
$pdf->Cell(25.5,0.7,"Laporan Keuangan",0,10,'C');
$pdf->SetFont('Arial','B',11);
$pdf->Cell(25.5,0.5,"Bulan 11 - 2019",0,0,'C');
$pdf->ln(1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(4.5,0.7,"Di cetak pada : ".date("d/m/Y"),0,0,'C');
$pdf->ln(1);

$pdf->Cell(0,0,"Pemasukan",0,0,'L');
$pdf->ln(0.5);
$pdf->Cell(1, 0.8, 'NO', 1, 0, 'C');
$pdf->Cell(12, 0.8, 'Keterangan Pemasukan', 1, 0, 'C');
$pdf->Cell(7, 0.8, 'Besar Pemasukan', 1, 0, 'C');
$pdf->Cell(5, 0.8, 'Tanggal', 1, 1, 'C');
$pdf->SetFont('Arial','',10);
$no=1;
$query = "SELECT ketLaporan, jumlah, dtBuat FROM laporan WHERE idOrganisasi = $idOrganisasi AND jenisLaporan = 'pemasukan'";
$result = mysqli_query($connect,$query);
$masuk = 0;
while($lihat=mysqli_fetch_array($result)){
	$date = explode(" ",$lihat['dtBuat']);
	$pdf->Cell(1, 0.8, $no, 1, 0, 'C');
	$pdf->Cell(12, 0.8, $lihat['ketLaporan'], 1, 0, '');
	$pdf->Cell(7, 0.8, 'Rp. '.number_format($lihat['jumlah']), 1, 0, 'R');
	$pdf->Cell(5, 0.8, $date[0], 1, 1, 'C');
	$no++;
	$masuk += $lihat['jumlah'];
}
$pdf->SetFont('Arial','B',10);
$pdf->Cell(13, 0.8, 'Sub Total', 1, 0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(7, 0.8, 'Rp. '.number_format($masuk), 1, 1, 'R');

$pdf->SetFont('Arial','B',10);
$pdf->ln(1);
$pdf->Cell(0,0,"Pengeluaran",0,0,'L');
$pdf->ln(0.5);
$pdf->Cell(1, 0.8, 'NO', 1, 0, 'C');
$pdf->Cell(12, 0.8, 'Keterangan Pengeluaran', 1, 0, 'C');
$pdf->Cell(7, 0.8, 'Besar Pengeluaran', 1, 0, 'C');
$pdf->Cell(5, 0.8, 'Tanggal', 1, 1, 'C');
$pdf->SetFont('Arial','',10);
$no=1;
$query = "SELECT ketLaporan, jumlah, dtBuat FROM laporan WHERE idOrganisasi = $idOrganisasi AND jenisLaporan = 'pengeluaran'";
$result = mysqli_query($connect,$query);
$keluar = 0;
while($lihat=mysqli_fetch_array($result)){
	$date = explode(" ",$lihat['dtBuat']);
	$pdf->Cell(1, 0.8, $no, 1, 0, 'C');
	$pdf->Cell(12, 0.8, $lihat['ketLaporan'], 1, 0, '');
	$pdf->Cell(7, 0.8, 'Rp. '.number_format($lihat['jumlah']), 1, 0, 'R');
	$pdf->Cell(5, 0.8, $date[0], 1, 1, 'C');
	$no++;
	$keluar += $lihat['jumlah'];
}
$pdf->SetFont('Arial','B',10);
$pdf->Cell(13, 0.8, 'Sub Total', 1, 0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(7, 0.8, 'Rp. '.number_format($keluar), 1, 1, 'R');

$pdf->SetFont('Arial','B',10);
$pdf->ln(1);
$pdf->Cell(0,0,"Tagihan",0,0,'L');
$pdf->ln(0.5);
$pdf->Cell(0,0,"Jumlah Anggota : 30",0,0,'L');
$pdf->ln(0.5);
$pdf->Cell(1, 0.8, 'NO', 1, 0, 'C');
$pdf->Cell(9, 0.8, 'Nama Tagihan', 1, 0, 'C');
$pdf->Cell(5.5, 0.8, 'Besar Tagihan', 1, 0, 'C');
$pdf->Cell(6.5, 0.8, 'Total Terbayar', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Status Tagihan', 1, 1, 'C');
$pdf->SetFont('Arial','',10);
$no=1;
$query = "SELECT tagihan.namaTagihan, tagihan.jumlahTagihan, tagihan.statusTagihan,
(SELECT SUM(pembayaran.jumlahBayar) FROM pembayaran WHERE pembayaran.idTagihan = tagihan.idTagihan) AS totalPembayaran
FROM tagihan LEFT JOIN pembayaran ON tagihan.idTagihan = pembayaran.idTagihan
WHERE tagihan.idOrganisasi = $idOrganisasi GROUP BY tagihan.idTagihan";
$result = mysqli_query($connect,$query);
$tagihan = 0;
while($lihat=mysqli_fetch_array($result)){
	$pdf->Cell(1, 0.8, $no, 1, 0, 'C');
	$pdf->Cell(9, 0.8, $lihat['namaTagihan'], 1, 0, '');
	$pdf->Cell(5.5, 0.8, 'Rp. '.number_format($lihat['jumlahTagihan']), 1, 0, 'R');
	$pdf->Cell(6.5, 0.8, 'Rp. '.number_format($lihat['totalPembayaran']), 1, 0, 'R');
	$pdf->Cell(3, 0.8, $lihat['statusTagihan'], 1, 1, 'C');
	$no++;
	$tagihan += $lihat['totalPembayaran'];
}
$pdf->SetFont('Arial','B',10);
$pdf->Cell(15.5, 0.8, 'Sub Total', 1, 0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(6.5, 0.8, 'Rp. '.number_format($tagihan), 1, 1, 'R');

$pdf->SetFont('Arial','B',10);
$pdf->ln(1);
$pdf->Cell(0,0,"Jumlah Total Uang",0,0,'L');
$pdf->ln(0.5);
$pdf->Cell(1, 0.8, 'NO', 1, 0, 'C');
$pdf->Cell(10, 0.8, 'Jenis', 1, 0, 'C');
$pdf->Cell(5.5, 0.8, 'Jumlah', 1, 1, 'C');
$pdf->SetFont('Arial','',10);
$pdf->Cell(1, 0.8, '1', 1, 0, 'C');
$pdf->Cell(10, 0.8, 'Pemasukan', 1, 0, '');
$pdf->Cell(5.5, 0.8, 'Rp. '.number_format($masuk), 1, 1, 'R');
$pdf->Cell(1, 0.8, '2', 1, 0, 'C');
$pdf->Cell(10, 0.8, 'Pengeluaran', 1, 0, '');
$pdf->Cell(5.5, 0.8, 'Rp. '.number_format($keluar), 1, 1, 'R');
$pdf->Cell(1, 0.8, '3', 1, 0, 'C');
$pdf->Cell(10, 0.8, 'Tagihan', 1, 0, '');
$pdf->Cell(5.5, 0.8, 'Rp. '.number_format($tagihan), 1, 1, 'R');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(11, 0.8, 'Jumlah Total', 1, 0, 'R');
$pdf->SetFont('Arial','',10);
$total = $masuk-$keluar+$tagihan;
$pdf->Cell(5.5, 0.8, 'Rp. '.number_format($total), 1, 1, 'R');

$pdf->Output("laporan_keuangan.pdf","I");

?>
