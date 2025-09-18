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
foreach(AbstractMessage::getApprovedAbstracts(true) as $abstract) {
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(0,10,'Date: ',0,1);
	$pdf->SetFont('Times','',12);
	$pdf->Cell(0,10,$abstract->getDate(),0,1);
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(0,10,'Authors and affiliations:',0,1);
	$pdf->SetFont('Times','',12);
	$names = explode("<br />", nl2br(" ".$abstract->getName()));
	foreach($names as $name) {
		$namewords = explode(" ",$name);
		$i = 0;
		while($i<sizeof($namewords)) {
			$nameline = $namewords[$i];
			while($i<sizeof($namewords) && strlen($nameline." ".$namewords[($i+1)])<100) {
				$i++;
				$nameline .= " ".$namewords[$i]; 
			}
			$pdf->Cell(0,5,$nameline,0,1);
			$i++;
		}
	}
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(0,10,'Type:',0,1);
	$pdf->SetFont('Times','',12);
	$pdf->Cell(0,10,$abstract->getType(),0,1);
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(0,10,'Title:',0,1);
	$pdf->SetFont('Times','',12);
	$titles = explode("<br />", nl2br(" ".$abstract->getTitle()));
	foreach($titles as $title) {
		$titlewords = explode(" ",$title);
		$i = 0;
		while($i<sizeof($titlewords)) {
			$titleline = $titlewords[$i];
			while($i<sizeof($titlewords) && strlen($titleline." ".$titlewords[($i+1)])<100) {
				$i++;
				$titleline .= " ".$titlewords[$i]; 
			}
			$pdf->Cell(0,5,$titleline,0,1);
			$i++;
		}
	}
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(0,10,'Abstract:',0,1);
	$pdf->SetFont('Times','',12);
	$messages = explode("<br />", nl2br(" ".$abstract->getMessage()));
	foreach($messages as $message) {
		$messagewords = explode(" ",$message);
		$i = 0;
		while($i<sizeof($messagewords)) {
			$messageline = $messagewords[$i];
			while($i<sizeof($messagewords) && strlen($messageline." ".$messagewords[($i+1)])<100) {
				$i++;
				$messageline .= " ".$messagewords[$i]; 
			}
			$pdf->Cell(0,5,$messageline,0,1);
			$i++;
		}
	}
	$pdf->Cell(0,10,'------------------------------------------------------------------------------------------------------------------------------------',0,1);
}
$pdf->Cell(0,10,'------------------------------------------------------------------------------------------------------------------------------------',0,1);

$pdf->Output();
?>

