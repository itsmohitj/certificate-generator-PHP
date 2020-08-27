<!DOCTYPE HTML>
<html>
<head>
	<title>Certificate Generator</title>
</head>
<body>
	<h1>Certificate Generator</h1>
	<?php
		use setasign\Fpdi\Fpdi;
		ob_start ();
		require("fpdf.php");
		require("../../../home/itsmohitj/Downloads/FPDI-2.2.0/src/autoload.php");
		 class pdf extends FPDF {
			 function __construct() {
				 parent::FPDF();
 			}
		 }			
		$servername="";   #Insert the name of the server
		$username=""; #Insert the username of the mysql server
		$password=""; #Insert the password
		$databasename=""; #Insert the database name
		$connection=new mysqli($servername, $username, $password, $databasename);
		if($connection->connect_error){
            		echo "Connection Failed" . $connection->connect_error;
		}

		$sql="select * from student_details";
		$today=date("D M j Y");
		$result=$connection->query($sql);
		if (!$result) {
			trigger_error('Invalid query: ' . $connection->error);
		}
	
		$pdf=new Fpdi();
		if($result->num_rows >0){
			while($row=$result->fetch_assoc()){
				$pdf->AddPage();
				$pdf->AddFont('englisht','','englisht.php');
				$pdf->setSourceFile('/home/itsmohitj/Documents/CFormat.pdf'); #The path of the source file		
				$page=$pdf->importPage(1);
				$pdf->useTemplate($page,10,10,200);
				$pdf->SetFont('englisht','',32);
				$pdf->SetTextColor(0,0,0);
				$pdf->SetXY(120,70);
				$pdf->Write(0,''.$row['name']);
				$pdf->SetFont('Helvetica','B',22);
				$pdf->SetXY(130,80);
				$pdf->Write(0,''.$row['roll_no']);
			}
		}

		$pdf->output();
		ob_end_flush();
$connection->close();
?>
</body>
<html>
