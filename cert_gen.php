<!DOCTYPE HTML>
<html>
<head>
	<title>Certificate Generator</title>
</head>
<body>
	<h1>Certificate Generator</h1>
	<?php
		use setasign\Fpdi\Fpdi; # Import the Fpdi class
		# ob_start() will turn output buffering on. While output buffering is active no output is sent from the script (other than headers), instead the output is stored in an internal buffer.
		ob_start (); 
		require("fpdf.php"); #include the fpdf.php 
		require("/FPDI-2.2.0/src/autoload.php"); # Include the fpdi autoload.php
		 class pdf extends FPDF {
			 function __construct() {
				 parent::FPDF();
 			}
		 }			
		$servername="";   #Insert the name of the server
		$username=""; #Insert the username of the mysql server
		$password=""; #Insert the password
		$databasename=""; #Insert the database name
		
		# mysqli will open a new connection to the MYSQL server.
		$connection=new mysqli($servername, $username, $password, $databasename);
		
		# check if there is any error in connection. If any error is there, connect_error will return the error description.
		if($connection->connect_error){
            		echo "Connection Failed" . $connection->connect_error;
		}
		
		# Store the query to be performed on the table in a variable. Here variable sql is used to store the query.	
		$sql="select * from student_details";
		$today=date("D M j Y");
		# Perform the query and store the result.
		$result=$connection->query($sql);

		# trigger_error generates an error or warning. Here, if there is some error with result, it will throw the error.
		if (!$result) {
			trigger_error('Invalid query: ' . $connection->error);
		}
		
		#Initiate FPDI
		$pdf=new Fpdi();

		if($result->num_rows >0){
			# fetch_assoc() fetches a result row as an associative array
			while($row=$result->fetch_assoc()){
				$pdf->AddPage();
				$pdf->setSourceFile(''); #The path of the source file		
				# Import a page
				$page=$pdf->importPage(1);
				# Use the imported page and place it at a point 10,10 with a width of 200mm.
				$pdf->useTemplate($page,10,10,200);
				$pdf->SetFont('englisht','',32);
				$pdf->SetTextColor(0,0,0);
				$pdf->SetXY(120,70);
				# write the name on the marked location by SetXY
				$pdf->Write(0,''.$row['name']);
				$pdf->SetFont('Helvetica','B',22);
				$pdf->SetXY(130,80);
				$pdf->Write(0,''.$row['roll_no']);
			}
		}

		$pdf->output();

		# ob_end_flush() flushes the output buffer and turn off the output buffering
		ob_end_flush();
$connection->close();
?>
</body>
<html>
