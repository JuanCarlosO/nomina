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
	public function getColumnPD()
	{
		return $this->model->getColumnPD();
	}
	public function getCatSAT()
	{
		return $this->model->getCatSAT();
	}
	
	public function generatePDF()
	{
		$data_user = $this->model->getDataUser();
		$full_name = $data_user['data']->nombre.' '.$data_user['data']->ap_pat.' '.$data_user['data']->ap_mat;
		#fECHA DEL PAGO 
		$f_pago = $this->model->getDatePago()['data']->f_pago;
		#LAS PERCEPCIONES
		$percepciones = $this->model->getPercepcionesQuincena()['data'];
		#LAS DEDUCCIONES 
		$deducciones = $this->model->getDeduccionesQuincena()['data'];
		$total_per = 0;
		$total_ded = 0;
		$neto = 0;
		foreach ($percepciones as $key => $per){
			$total_per += $per->importe;
		}
		foreach ($deducciones as $key => $ded){
			$total_ded += $ded->importe;
		}
		$neto = $total_per - $total_ded;
		#datos periodo de la quincena
		$per = $this->model->getPeriodo()['data'];
		$per = $per->periodo. ' DEL '.date('Y');
		$pdf = new PDF('P','mm','Letter');
		$pdf->AliasNbPages();
		$pdf->AddPage();
		//$pdf->SetLeftMargin(5);
		$pdf->Ln(15);
		$pdf->SetFont('Times','',12);
		#imagenes de marca de agua
		$pdf->Image('pdf/img/escudo_opaco.png',35,85,40,35,'PNG');
		$pdf->Image('pdf/img/escudo_opaco.png',130,85,40,35);
		$pdf->Ln(7);
		$pdf->SetX(15);
		$pdf->Cell(185,8,'COMPROBANTE DE PERCEPCIONES Y DEDUCCIONES',1,0,'C');
		$pdf->Ln();
		$pdf->SetFont('Times','',10);
		$pdf->Cell(25,6,'Nombre: ',0,0,'C');
		$pdf->Cell(80,6,utf8_decode($full_name),0,0,'L');
		$pdf->Cell(35,6,'Clave de ISSEMYM:',0,0,'C');
		$pdf->Cell(55,6,$data_user['data']->issemym,0,0,'L');
		$pdf->Ln();
		$pdf->Cell(25,6,'C.U.R.P:',0,0,'C');
		$pdf->Cell(80,6,$data_user['data']->curp,0,0,'L');
		$pdf->Cell(35,6,'Quincena: ',0,0,'C');
		$pdf->Cell(55,6,$_POST['c_quincena'],0,0,'L');
		$pdf->Ln();
		$pdf->Cell(25,6,'R.F.C.:',0,0,'C');
		$pdf->Cell(80,6,$data_user['data']->rfc,0,0,'L');
		$pdf->Cell(35,6,'Fecha del pago: ',0,0,'C');
		$pdf->Cell(55,6,$f_pago,0,0,'L');
		$pdf->Ln();
		$pdf->Cell(25,6,'Puesto: ',0,0,'C');
		$pdf->Cell(80,6,'JEFE DE OFICINA',0,0,'L');
		$pdf->Cell(35,6,utf8_decode('Período de pago: '),0,0,'C');
		$pdf->Cell(55,6,$per,0,0,'L');
		$pdf->Ln();
		$pdf->Cell(25,6,'Departamento: ',0,0,'C');
		$pdf->Cell(170,6,utf8_decode($data_user['data']->name_area),0,0,'L');
		$pdf->Ln();
		$pdf->Cell(125,6,'',0,0,'C');
		$pdf->Cell(35,6,'Total Neto: ',0,0,'C');
		$pdf->Cell(55,6,$neto,0,0,'L');
		#Dibujando una tabla 
		$pdf->Ln();
		$pdf->SetX(11);
		$pdf->Cell(96,6,'PERCEPCIONES',1,0,'C');
		$pdf->Cell(96,6,'DEDUCCIONES',1,0,'C');
		$pdf->Ln();
		$w = array(15, 60, 21);
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
	    // Datos -- >el texto permitido es de 30 Caracteres
	    $pdf->SetFont('Times','',8);
	    $pdf->SetX(11);
	    // pintar los datos 
	    foreach ($percepciones as $key => $per) {
	    	
	    	$pdf->SetX(11);
	    	$name_per = utf8_decode($per->name_per);
	    	$name_per = substr($name_per, 0,30);
	    	$pdf->Cell($w[0],6,$per->cve_ext,'L');
	        $pdf->Cell($w[1],6,$name_per,'');
	        $pdf->Cell($w[2],6,$per->importe,'R',0,'R');
	        # pitar las deducciones
	        if ($key <= count($deducciones)) {
	        	
	        	$pdf->Cell($w[0],6,$deducciones[$key]->cve_ext,'L');
	        	$pdf->Cell($w[1],6,$deducciones[$key]->name_ded,'');
	        	$pdf->Cell($w[2],6,$deducciones[$key]->importe,'R',0,'R');
	        } 
	        
	        $pdf->Ln();
	    }
	    #pINTAR LAS DEDUCCIONES FALTANTES 
	    if ( count($percepciones) < count($deducciones) ) {
	    	$ini = count($percepciones);
	    	for ($i=$ini; $i < count($deducciones) ; $i++) { 
	    		
	    		$pdf->SetX(11);
	    		$pdf->Cell($w[0],6,'','L');
		        $pdf->Cell($w[1],6,'','');
		        $pdf->Cell($w[2],6,'','R',0,'R');

	    		$pdf->Cell($w[0],6,$deducciones[$i]->cve_ext,'L');
	        	$pdf->Cell($w[1],6,$deducciones[$i]->name_ded,'');
	        	$pdf->Cell($w[2],6,$deducciones[$i]->importe,'R',0,'R');
	        	$pdf->Ln();
	    	}
	    }
	    $pdf->SetX(11);
	    $pdf->Cell($w[0],6,'','L');
        $pdf->Cell($w[1],6,' TOTAL DE PERCEPCIONES ','');
        $pdf->Cell($w[2],6,$total_per,'R',0,'R');
        $pdf->Cell($w[0],6,'','L');
        $pdf->Cell($w[1],6,' TOTAL DE DEDUCCIONES ','');
        $pdf->Cell($w[2],6,$total_ded,'R',0,'R');
        $pdf->Ln();
	   	$pdf->SetX(11);
	    $pdf->Cell(array_sum($w),0,'','T');
	    $pdf->Cell(array_sum($w),0,'','T');
	    $pdf->Ln(10);
	    $pdf->SetFillColor(150,150,150);
	   	$pdf->SetX(11);
	    $pdf->MultiCell(192,50,' ',1,0,'C',TRUE);
		$pdf->Output();
	}
	public function generateALFGRAL()
	{
		$data = $this->model->ALFGRAL()['data'];
		$pdf = new PDFH('L','mm','Legal');#pdf horizontal
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->Ln(15);
		$pdf->SetFont('Times','',10);
		$pdf->Ln(7);
		$pdf->SetX(15);
		$pdf->Cell(325,7,utf8_decode('GOBIERNO DEL ESTADO DE MÉXICO'),'LRT',0,'C');$pdf->Ln();
		$pdf->SetX(15);$pdf->Cell(325,7,'UNIDAD DE ASUNTOS INTERNOS','LR',0,'C');$pdf->Ln();
		$pdf->SetX(15);$pdf->Cell(325,7,"ALFABETICO DE EMPLEADOS A LA QUINCENA: \t" .$_POST['c_quincena']." DEL ".$_POST['year'],'LRB',0,'C');
		$w = array(20, 70, 45, 23, 21, 30, 21, 21, 21, 21, 21);
		$pdf->Ln(10);
		$header = array('CVE-EMP', 'NOMBRE','CATEGORIA','RFC','ISSEMYM','ADSCRIPCIÓN','CVE','IMPORTE','CVE','IMPORTE','N E T O ');
		$pdf->SetX(15);
		$pdf->Cell(209,7,'',1,0,'C');
		$pdf->Cell(42,7,'PERCEPCIONES',1,0,'C');
		$pdf->Cell(42,7,'DEDUCCIONES',1,0,'C');
		$pdf->Ln();
		$pdf->SetX(15);
	    for($i=0;$i<count($header);$i++)
	    {
    	    $pdf->Cell($w[$i],7,utf8_decode($header[$i]),1,0,'C');
	    }
	    $pdf->Ln();
	    $pdf->SetX(15);
	    $pdf->SetFont('Times','',7);
	   
	    #Pintar los datos 
	    foreach ($data as $key => $sp) {
	    	$pdf->SetX(15);
	    	$pdf->Cell(20,7,utf8_decode($sp['nu_plaza']),1,0,'C');
	    	$pdf->Cell(70,7,utf8_decode($sp['nombre'].' '.$sp['ap_pat'].' '.$sp['ap_mat']),1,0,'C');
	    	$pdf->Cell(45,7,utf8_decode($sp['n_pu_act']),1,0,'C');
	    	$pdf->Cell(23,7,utf8_decode($sp['rfc']),1,0,'C');
	    	$pdf->Cell(21,7,utf8_decode($sp['issemym']),1,0,'C');
	    	$pdf->Cell(30,7,utf8_decode($sp['cve_area']),1,0,'C');
	    	$neto = 0;
	    	foreach ($sp['percepciones'] as $key => $per) {
	    		if ($key == 0) {
	    			$pdf->Cell(21,7,$per->cve_ext,'L',0,'C');
	    			$pdf->Cell(21,7,utf8_decode($per->importe),'R',0,'C');
	    		}else{
	    			$pdf->Ln();
	    			$pdf->SetX(15);
	    			$pdf->Cell(209,7,'','L',0,'C');
	    			$pdf->Cell(21,7,$per->cve_ext,'L',0,'C');
	    			$pdf->Cell(21,7,utf8_decode($per->importe),'R',0,'C');
	    		}
	    		$neto += $per->importe;
	    		#pintar las deducciones 
	    		if ( $key < count($sp['deducciones']) ) {
	    			$pdf->Cell(21,7,$sp['deducciones'][$key]->cve_ext,'L',0,'C');
	    			$pdf->Cell(21,7,utf8_decode($sp['deducciones'][$key]->importe),'R',0,'C');
	    			$neto -= $sp['deducciones'][$key]->importe;

	    		}
	    		$pdf->Cell(21,7,'','LR',0,'C');
	    	}
	    	if ( count($sp['percepciones']) < count($sp['deducciones']) ){
	    		$ini = count($sp['percepciones']);
	    		for ($i=$ini; $i < count($sp['deducciones']); $i++) { 
	    			$pdf->Ln();
	    			$pdf->SetX(15);
	    			$pdf->Cell(209,7,'','LR',0,'C');
	    			$pdf->Cell(42,7,'','LR',0,'C');
	    			$pdf->Cell(21,7,$sp['deducciones'][0]->cve_ext,'',0,'C');
	    			$pdf->Cell(21,7,utf8_decode($sp['deducciones'][0]->importe),'R',0,'C');
	    			$pdf->Cell(21,7,'','LR',0,'C');
	    		}
	    	}
	    	# colocar el precio neto 
	    	$pdf->Ln();
			$pdf->SetX(15);
			$pdf->Cell(209,7,'','LR',0,'C');
			$pdf->Cell(42,7,'','LR',0,'C');
			$pdf->Cell(42,7,'','LR',0,'C');
			$pdf->Cell(21,7,$neto,'R','C');

	    }
	    $pdf->Ln();
	    $pdf->SetX(15);$pdf->Cell(array_sum($w),0,'','T');
		$pdf->Output();
		#return $this->model->ALFGRAL();
	}
	public function FIRMAS()
	{
		#$data = $this->model->FIRMAS()['data'];
		$areas = json_decode($this->model->getAreas())->data;
		$pdf = new PDFH('L','mm','Legal');#pdf horizontal
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->Ln(15);
		$pdf->SetFont('Times','',10);
		$pdf->Ln(7);
		$pdf->SetX(15);
		$pdf->Cell(325,7,utf8_decode('GOBIERNO DEL ESTADO DE MÉXICO'),'LRT',0,'C');$pdf->Ln();
		$pdf->SetX(15);$pdf->Cell(325,7,'UNIDAD DE ASUNTOS INTERNOS','LR',0,'C');$pdf->Ln();
		$pdf->SetX(15);$pdf->Cell(325,7," LISTADO DE FIRMAS CORRESPONDIENTE A LA QUINCENA: \t" .$_POST['c_quincena']." DEL ".$_POST['year'],'LRB',0,'C');
		$w = array(90, 30, 30, 35, 35, 35, 70);
		$pdf->Ln(10);
		$header = array('NOMBRE', 'CVE-EMP', 'RFC', 'PERCEPCIONES','DEDUCCIONES','TOTAL', 'FIRMA');
		$pdf->SetX(15);
	    for($i=0;$i<count($header);$i++)
	    {
    	    $pdf->Cell($w[$i],7,utf8_decode($header[$i]),1,0,'C');
	    }
		$pdf->Ln();	    
	    foreach ($areas as $key => $a) {
	    	if ( count($this->model->FIRMAS($a->id)->data) > 0 ) {
	    		$datos = $this->model->FIRMAS($a->id)->data;
    	    	$pdf->SetX(15);$pdf->Cell(325,7,utf8_decode($a->nombre),1,0,'C');
    	    	$pdf->Ln(10);
    		    foreach ($datos as $key => $d) {
    		    	$pdf->SetX(15);
    		    	$full_name = $d['nombre'].' '.$d['ap_pat'].' '.$d['ap_mat'];
    	    	    $pdf->Cell(90,10,utf8_decode($full_name),'',0,'C');
    	    		$pdf->Cell(30,10,$d['nu_plaza'],'',0,'C');
    	    		$pdf->Cell(30,10,$d['rfc'],'',0,'C');
    	    		$pdf->Cell(35,10,$d['total_p'],'',0,'C');
    	    		$pdf->Cell(35,10,$d['total_d'],'',0,'C');
    	    		$pdf->Cell(35,10,$d['total'],'',0,'C');
    	    		$pdf->Cell(70,10,'______________________________________','',0,'R');
    	    		$pdf->Ln(10);
    		    }
	    	}
	    }
		$pdf->Output();
	}
	public function LISPEN()
	{
		$data = $this->model->LISPEN()['data'];
		$pdf = new PDFH('L','mm','Legal');#pdf horizontal
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->Ln(15);
		$pdf->SetFont('Times','',10);
		$pdf->Ln(7);
		$pdf->SetX(15);
		$pdf->Cell(325,7,utf8_decode('GOBIERNO DEL ESTADO DE MÉXICO'),'LRT',0,'C');$pdf->Ln();
		$pdf->SetX(15);$pdf->Cell(325,7,'UNIDAD DE ASUNTOS INTERNOS','LR',0,'C');$pdf->Ln();
		$pdf->SetX(15);$pdf->Cell(325,7,"LISTADO DE PENSION ALIMENTICIA DE LA QUINCENA: \t" .$_POST['c_quincena']." DEL ".$_POST['year'],'LRB',0,'C');
		$w = array(30, 90, 60, 35, 35, 35, 35);
		$pdf->Ln(10);
		$header = array('CVE-EMP', 'NOMBRE','CATEGORIA', 'RFC', 'ISSEMYM','ADSCRIPCION', 'MONTO');
		$pdf->SetX(15);
	    for($i=0;$i<count($header);$i++)
	    {
    	    $pdf->Cell($w[$i],7,utf8_decode($header[$i]),1,0,'C');
	    }
	    $pdf->Ln();
	    $pdf->SetFont('Times','',8);
	    # pintar los datos
	    foreach ($data as $key => $ben) {
	    	$pdf->SetX(15);
	    	$pdf->Cell(30,7,$ben->id,1,0,'C');
	    	$pdf->Cell(90,7,$ben->beneficiario,1,0,'C');
	    	$pdf->Cell(60,7,utf8_decode('Y0088800 PENSIÓN ALIMENTICIA'),1,0,'C');
	    	$pdf->Cell(35,7,$ben->rfc,1,0,'C');
	    	$pdf->Cell(35,7,'0000000',1,0,'C');
	    	$pdf->Cell(35,7,$ben->clave,1,0,'C');
	    	$pdf->Cell(35,7,$ben->descuento,1,0,'C');
	    	$pdf->Ln();	   
	    }
		$pdf->Output();
	}
	public function LISPROYE()
	{
		$data = $this->model->LISPROYE()['data'];

		$pdf = new PDFH('L','mm','Legal');#pdf horizontal
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->Ln(15);
		$pdf->SetFont('Times','',10);
		$pdf->Ln(7);
		$pdf->SetX(15);
		$pdf->Cell(325,7,utf8_decode('GOBIERNO DEL ESTADO DE MÉXICO'),'LRT',0,'C');$pdf->Ln();
		$pdf->SetX(15);$pdf->Cell(325,7,'UNIDAD DE ASUNTOS INTERNOS','LR',0,'C');$pdf->Ln();
		$pdf->SetX(15);$pdf->Cell(325,7,"ALFABETICO DE EMPLEADOS A LA QUINCENA: \t" .$_POST['c_quincena']." DEL ".$_POST['year'],'LRB',0,'C');
		$w = array(20, 70, 45, 23, 21, 30, 21, 21, 21, 21, 21);
		$pdf->Ln(10);
		$header = array('CVE-EMP', 'DESCRIPCIÓN','IMPORTE');
		
		$pdf->Ln();
		$pdf->SetX(15);
	    for($i=0;$i<count($header);$i++)
	    {
    	    $pdf->Cell($w[$i],7,utf8_decode($header[$i]),1,0,'C');
	    }
	    $pdf->Ln();
	    $pdf->SetX(15);
	    $pdf->SetFont('Times','',7);
	   $total = 0;
	    #Pintar los datos 
	    foreach ($data as $key => $sp) {
	    	$pdf->SetX(15);
	    	$pdf->Cell(20,7,utf8_decode($sp['cve_ext']),1,0,'C');
	    	$pdf->Cell(70,7,utf8_decode($sp['nombre']),1,0,'C');
	    	$pdf->Cell(45,7,utf8_decode($sp['importe']),1,0,'C');
	    	$pdf->Ln();
	    	$total += $sp['importe']; 
	    }
		$pdf->SetX(15);
		$pdf->Cell(90,7,'TOTAL ',1,0,'C');
		$pdf->Cell(45,7,$total,1,0,'C');
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
	    $this->Cell(0,1,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'C');
	    $this->Ln();
	    $this->Cell(195,8,'UNIDAD DE ASUNTOS INTERNOS',10,10,'C');

	    $this->Cell(20,6,utf8_decode('COMPROBANTE PARA EL SERVIDOR PÚBLICO'),10,10,'L');
	}
}
class PDFH extends FPDF
{
	// Cabecera de página
	function Header()
	{
	    // Logo
	    $this->Image('pdf/img/escudo.jpg',2,7,90,40);
	    // Arial bold 15
	    $this->SetFont('Arial','B',15);
	    
	    // Salto de línea
	    $this->Ln(7);
	    $this->Rect(13,12,330,193,'D');
	}

	// Pie de página
	function Footer(){
	    // Posición: a 1,5 cm del final
	    $this->SetY(-8);
	    // Arial italic 8
	    $this->SetFont('Arial','I',8);
	    $this->Cell(0,1,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'C');
	    
	    $this->SetX(12);
	    #$this->Cell(330,8,'UNIDAD DE ASUNTOS INTERNOS',10,10,'C');
	    #$this->Cell(20,6,utf8_decode('COMPROBANTE PARA EL SERVIDOR PÚBLICO'),10,10,'L');
	}
}
?>