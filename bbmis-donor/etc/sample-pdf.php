<?php
	include "../connection.php";
	session_start();
	$varDbId = $_SESSION["sessId"];
	
	require('../assets/fpdf/fpdf.php');
	
	$pdf = new FPDF('P', 'in', 'Letter');
	$pdf -> SetMargins(0, 0.5, 0);
	$pdf -> SetFont('Times','',12);
	$pdf -> AddPage();
	
	$pdf -> SetFont('Arial', '', 11.5);
	$pdf -> SetTextColor(0, 0, 0);
	$pdf -> SetX(0.5);
	$pdf -> MultiCell(0.35, 0.3, 'yay', 1, 'C', false);
	$pdf -> SetX(0.85);
	$pdf -> MultiCell(3.575, 0.3, 'noice', 1, false);
	$pdf -> SetX(4.425);
	$pdf -> MultiCell(3.575, 0.3, 'Answer', 1, 'C', false);
	
	$pdf -> SetX(0.5);
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$width = 2.36;
	$pdf->MultiCell($width, 0.236, 'particular', 1, 'L', FALSE);
	$pdf->SetXY($x + $width, $y);
	$pdf->Cell(1.57,1.969, 'quantity', 1, 0, "l");
	
	$pdf -> Output();
?>