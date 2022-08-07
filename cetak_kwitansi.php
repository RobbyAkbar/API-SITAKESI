<?php
include 'con.php';
require('pdf/fpdf.php');

$nama='Robby Akbar';//$_POST['nama'];
$uang='150000';//$_POST['uang'];
$untuk='Pembuatan Baju Angkatan';//$_POST['untuk'];
$bendahara='Asry Yuniarty';//$_POST['bendahara'];

function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}
		return $temp;
	}

	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}
		return $hasil;
	}

$pdf=new FPDF('L','mm','A5');/*L untuk tampilan Landscape, A5 adalah ukuran kertasnya*/
$arraybln=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
$bln=$arraybln[date('n')-1];
$thn=date('Y');
$tgl=date('d');
/*membuat file PDF untuk dicetak*/
$pdf->setMargins(10,6,10);
$pdf->AddPage();
$pdf->SetFont('Arial','B',13);
$pdf->Image('logo_sitakesi.png',10,6,20,20);
$pdf->SetX(30);
$pdf->Cell(0,5,'PSTI B - 2018',0,1,'L');
$pdf->SetFont('Arial','',11);
$pdf->SetX(30);
$pdf->MultiCell(0,5,'Universitas Pendidikan Indonesia'." \n".'Jl. Veteran No. 8'." \n".'telp: +622188326678 | email : psti@upi.edu');
$pdf->SetLineWidth(0.8);
$pdf->Line(10,28,199,28);
$pdf->Ln(8);
$pdf->SetFont('Arial','B',13);
$pdf->Cell(55,5,'',0,0,'');
$pdf->Cell(0,5,'TANDA BUKTI PEMBAYARAN',0,1,'L');
$pdf->SetLineWidth(0.4);
$pdf->Rect(60,30,80,13);/*ubah ukuran Kotak Judul -> Rect(sumbu x, sumbu y, lebar kotak,tinggi kotak)*/
$pdf->SetFont('Arial','',11);
$pdf->Ln(10);
$pdf->Cell(40,5,'Telah Terima Dari :',0,0,'L');
$pdf->SetFont('Arial','',12);
$pdf->Cell(70,5,$nama,0,1,'J');
$pdf->Line(50,56,150,56);
$pdf->Rect(50,61,115,10);
$pdf->Rect(50,74,115,10);
$pdf->Ln(6);
$pdf->Cell(40,20,'Uang Sejumlah   :',0,0,'L');
$pdf->MultiCell(113,12,strtoupper(terbilang($uang))." RUPIAH",'J');
if(strlen(terbilang($uang))>40)
$lnBreak=6;
else
$lnBreak=16;
$pdf->Ln($lnBreak);
$pdf->Cell(40,5,'Untuk Pembayaran :',0,0,'L');
$pdf->Cell(70,7,$untuk,0,1,'J');
$pdf->Line(50,97,150,97);
$pdf->Ln(6);
$pdf->Cell(116,5,'',0,0,'');
$pdf->SetFont('Arial','U',12);
$pdf->Cell(0,5,'Purwakarta'.', '.$tgl.' '.$bln.' '.$thn,0,1,'L');
$pdf->SetFont('Arial','',14);
$pdf->Cell(116,7,'Rp. '.number_format($uang,0,",",".").',-',0,1,'L');
$pdf->Ln(5);
$pdf->Rect(8,106,50,10);
$pdf->SetFont('Arial','',12);
$pdf->Cell(140-strlen($bendahara),5,'',0,0,'L');
$pdf->SetFont('Arial','BU',14);
$pdf->Cell(30,5,'( '.$bendahara.' )',0,1,'L');

$pdf->Output("kwitansi_tagihan.pdf","I");

?>
