<?php
require('../fpdf.php');
require_once ('../../includes/connect.inc.php');
require_once ('../classes/login.class.php');
require_once ('../classes/abstract.class.php');
$login = (new Login())->getInstance();
$login->init("users");
if($login->isLogin()==false)
	header("location: ../nopermission.php");

class PDF extends FPDF
{
//Page header
function Header()
{
	//Arial bold 15
	$this->SetFont('Arial','B',15);
	//Move to the right
	$this->Cell(80);
	//Title
	$this->Cell(30,10,'Abstracts',0,0,'C');
	//Line break
	$this->Ln(20);
}

//Page footer
function Footer()
{
	//Position at 1.5 cm from bottom
	$this->SetY(-15);
	//Arial italic 8
	$this->SetFont('Arial','I',8);
	//Page number
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

//Instanciation of inherited class
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
foreach(AbstractMessage::getApprovedAbstracts(true) as $abstract) {
	$pdf->Cell(0,10,'Date: '.$abstract->getDate(),0,1);
	$pdf->Cell(0,10,'Authors:',0,1);
	$pdf->Cell(0,10,$abstract->getName(),0,1);
	$pdf->Cell(0,10,'Type: '.$abstract->getType(),0,1);
	$pdf->Cell(0,10,'Title:',0,1);
	$pdf->Cell(0,10,$abstract->getTitle(),0,1);
	$pdf->Cell(0,10,'Abstract:',0,1);
	$pdf->Cell(0,10,$abstract->getMessage(),0,1);
	$pdf->Cell(0,10,'',0,1);
	$pdf->Cell(0,10,'',0,1);
}
	$pdf->Cell(0,10,'------------------------------------------------------------------------------------------------------------------------------------',0,1);

$pdf->Output();
?>

