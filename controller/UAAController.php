<?php
/**
 * Controlador de Usuarios 
 */
include_once '../model/UAAModel.php';
include 'pdf/fpdf.php';
class UAAController 
{
	protected $model;
	function __construct()
	{
		$this->model = new UAAModel();
	}
	public function getPersonal()
	{
		return $this->model->getPersonal();
	}
	public function getPersonalBy()
	{
		return $this->model->getPersonalBy();
	}
	public function getCatalogo($c_quincena)
	{
		return $this->model->getCatalogo($c_quincena);
	}
	public function getPerDed()
	{
		return $this->model->getPerDed();
	}
	public function getNamesPersonal()
	{
		return $this->model->getNamesPersonal();
	}
	public function saveNivel()
	{
		return $this->model->saveNivel();
	}
	public function getNR()
	{
		return $this->model->getNR();
	}
	public function savePersonal()
	{
		return $this->model->savePersonal();
	}
	public function saveDataFUMP()
	{
		return $this->model->saveDataFUMP();
	}
	public function get_CVE_RFC()
	{
		return $this->model->get_CVE_RFC();
	}
	public function saveEntrada()
	{
		return $this->model->saveEntrada();
	}
	public function saveSalida()
	{
		return $this->model->saveSalida();
	}
	public function getRegistroSP()
	{
		return $this->model->getRegistroSP();
	}
	public function getPerDedBySP()
	{
		return $this->model->getPerDedBySP();
	}
	public function savePD()
	{
		return $this->model->savePD();
	}
	public function saveRegla()
	{
		return $this->model->saveRegla();
	}
	public function savePago()
	{
		return $this->model->savePago();
	}
	public function getRetardos()
	{
		return $this->model->getRetardos();
	}
	public function getInfoPerDed()
	{
		return $this->model->getInfoPerDed();
	}
	public function getQuincenaPagada()
	{
		return $this->model->getQuincenaPagada();
	}
	public function getTimbrado()
	{
		return $this->model->getTimbrado();
	}
	public function getDispersion()
	{
		return $this->model->getDispersion();
	}
	
	public function generatePDF()
	{
		$pdf = new PDF('P','mm','Letter');
		$pdf->AliasNbPages();
		$pdf->AddPage();
//		$pdf->SetLeftMargin(5);
		$pdf->Ln(15);
		$pdf->SetFont('Times','',12);
		
		$pdf->Ln(7);
		$pdf->SetX(15);
		$pdf->Cell(185,8,'COMPROBANTE DE PERCEPCIONES Y DEDUCCIONES',1,0,'C');
		$pdf->Ln();
		$pdf->SetFont('Times','',10);
		$pdf->Cell(25,6,'Nombre: ',0,0,'C');
		$pdf->Cell(80,6,'JUAN CARLOS OVANDO QUINTANA',0,0,'L');
		$pdf->Cell(35,6,'Clave de ISSEMYM:',0,0,'C');
		$pdf->Cell(55,6,'01251758',0,0,'L');
		$pdf->Ln();
		$pdf->Cell(25,6,'C.U.R.P:',0,0,'C');
		$pdf->Cell(80,6,'OAQJ950424HMCVNN09',0,0,'L');
		$pdf->Cell(35,6,'Quincena: ',0,0,'C');
		$pdf->Cell(55,6,'12 del '.date('Y'),0,0,'L');
		$pdf->Ln();
		$pdf->Cell(25,6,'R.F.C.:',0,0,'C');
		$pdf->Cell(80,6,'OAQJ9504247I6',0,0,'L');
		$pdf->Cell(35,6,'Fecha del pago: ',0,0,'C');
		$pdf->Cell(55,6,date('d-m-Y'),0,0,'L');
		$pdf->Ln();
		$pdf->Cell(25,6,'Puesto: ',0,0,'C');
		$pdf->Cell(80,6,'JEFE DE OFICINA',0,0,'L');
		$pdf->Cell(35,6,utf8_decode('Período de pago: '),0,0,'C');
		$pdf->Cell(55,6,'16 al 31 de diciembre del 2019',0,0,'L');
		$pdf->Ln();
		$pdf->Cell(25,6,'Departamento: ',0,0,'C');
		$pdf->Cell(170,6,strtoupper('Departamento de Desarrollo de Sistemas'),0,0,'L');
		$pdf->Ln();
		$pdf->Cell(125,6,'',0,0,'C');
		$pdf->Cell(35,6,'Total Neto: ',0,0,'C');
		$pdf->Cell(55,6,'6,190.78',0,0,'L');
		#Dibujando una tabla 
		
		$pdf->Ln();
		$pdf->SetX(11);
		$pdf->Cell(96,6,'PERCEPCIONES',1,0,'C');
		$pdf->Cell(96,6,'DEDUCCIONES',1,0,'C');
		$pdf->Ln();
		$w = array(20, 43, 33);
		$header = array('CLAVE', 'CONCEPTO', 'IMPORTE');
		//Cabeceras
		$pdf->SetX(11);
	    for($i=0;$i<count($header);$i++)
	    {
    	    $pdf->Cell($w[$i],7,$header[$i],1,0,'C');
	    }	
	  	for($i=0;$i<count($header);$i++)
	  	{
			$pdf->Cell($w[$i],7,$header[$i],1,0,'C');
	  	}
	    $pdf->Ln();
	    // Datos
	    $pdf->SetX(11);
	    $pdf->Cell($w[0],6,'0102','LR');
        $pdf->Cell($w[1],6,'TEXTO TO FILL','LR');
        $pdf->Cell($w[2],6,'TEXTO TO FILL','LR',0,'R');
        
        $pdf->Cell($w[0],6,'0102','LR');
        $pdf->Cell($w[1],6,'TEXTO TO FILL','LR');
        $pdf->Cell($w[2],6,'TEXTO TO FILL','LR',0,'R');
        $pdf->Ln();
	    /*foreach($data as $row)
	    {
	        $this->Cell($w[0],6,$row[0],'LR');
	        $this->Cell($w[1],6,$row[1],'LR');
	        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
	        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
	        $this->Ln();
	    }*/
	    // Línea de cierre
	    $pdf->SetX(11);
	    $pdf->Cell(array_sum($w),0,'','T');
	    $pdf->Cell(array_sum($w),0,'','T');
		/*$pdf->SetY(30);
		$pdf->Ln();
		for($i=1;$i<=40;$i++){
			$pdf->SetX(10);
			$pdf->Cell(20,10,utf8_decode('Imprimiendo línea número ') .$i,0,1);
		}*/
		$pdf->Output();
	}
	
}

class PDF extends FPDF
{
	// Cabecera de página
	function Header()
	{
	    // Logo
	    $this->Image('pdf/img/escudo.jpg',0,7,90,40);
	    // Arial bold 15
	    $this->SetFont('Arial','B',15);
	    
	    // Salto de línea
	    $this->Ln(7);
	    $this->Rect(10,12,195,255,'D');
	}

	// Pie de página
	function Footer(){
	    // Posición: a 1,5 cm del final
	    $this->SetY(-15);
	    // Arial italic 8
	    $this->SetFont('Arial','I',8);
	    // Número de página
	    //$this->Image('pdf/img/footer.png',1,252,217,25);
	    //$this->Image('pdf/img/footer.png',1,250,217,30);
	    //$this->Cell(0,5,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'C');
	    $this->SetX(10);
	    $this->SetY(-20);
	    $this->Cell(195,8,'UNIDAD DE ASUNTOS INTERNOS',10,10,'C');
	    $this->Cell(20,6,utf8_decode('COMPROBANTE PARA EL SERVIDOR PÚBLICO'),10,10,'L');
	}
}
?>