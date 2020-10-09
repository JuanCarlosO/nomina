<?php 
include 'Security.php';
spl_autoload_register(function ($class) {
    include $class.'.php';
});
/*DECLARACIÓN DE LAS CLASES*/
$u = new UserController();
$uaa = new UAAController();
/***/
if ( isset($_POST['option']) ) {
	$o = $_POST['option'];
	switch ( $o ) {
		case '1':
			$access = $u->validateAccess();
			
			if ( is_object($access) ) {
					
				session_start();
				$_SESSION['id']			= $access->personal_id;
				$_SESSION['name'] 		= $access->name;
				$_SESSION['n_completo'] = $access->n_completo;
				$_SESSION['area_id'] 	= $access->area_id;
				$_SESSION['n_area'] 	= $access->n_area;
				$_SESSION['perfil'] 	= $access->perfil;
				$_SESSION['nivel'] 	= $access->nivel;
				if ( isset($_SESSION) ) {
					header('Location: ../index.php?menu=general');
				}
			}else if( is_array($access) ){
				if ( isset( $access['status'] ) ) {
					if ( $access['status'] == 'error' ) {
						header('Location: ../login.php?edo=error&e_message='.$access['message']);
					}
				}
			}
			break;
		case '2':
			$uaa->getPersonalBy();
			break;
		case '3':
			echo $uaa->getCatalogo($_POST['catalogo']);
			break;
		case '4':
			echo $uaa->saveNivel();
			break;
		case '5':
			echo $uaa->savePersonal();
			break;
		case '6':
			echo $uaa->saveDataFUMP();
			break;
		case '7':
			echo $uaa->get_CVE_RFC();
			break;			
		case '8':
			echo $uaa->saveEntrada();
			break;			
		case '9':
			echo $uaa->saveSalida();
			break;			
		case '10':
			echo $uaa->getPerDedBySP();
			break;			
		case '11':
			echo $uaa->savePD();
			break;	
		case '12':
			echo $uaa->saveRegla();
			break;	
		case '13':
			echo $uaa->savePago();
			break;	
		case '14':
			echo $uaa->getRetardos();
			break;	
		case '15':
			echo $uaa->getInfoPerDed();
			break;	
		case '16':
			echo $uaa->getTimbrado();
			break;	
		case '17':
			#echo $uaa->getTimbrado();
			echo $uaa->generatePDF();
			break;	
		case '18':
			echo $uaa->getDispersion();
			break;	
		case '19':
			echo $uaa->getColumnPD();
			break;	
		case '20':
			echo $uaa->getCatSAT();
			break;	
		case '21':
			if ($_POST['t_reporte'] == '1') {
				echo $uaa->generateALFGRAL();
			}elseif ($_POST['t_reporte'] == '2') {
				echo $uaa->FIRMAS();
			}elseif ($_POST['t_reporte'] == '3') {
				echo $uaa->LISPEN();
			}elseif ($_POST['t_reporte'] == '4') {
				echo $uaa->LISPROYE();
			}
			
			break;	
					
		default:
			echo json_encode(array( 'status'=>'error','message'=>'NO SE A DEFINIDO LA OPCIÓN DEL MÉTODO A LA QUE DESEA ACCEDER SU FORMULARIO <br> INFORME ESTE PROBLEMA A DESARROLLO DE SISTEMAS (ext: 129).' ));
			break;
	}
}elseif ( isset($_GET['option']) ) {
	$o = $_GET['option'];	
	switch ( $o ) {
		case '1':#
			echo $uaa->getPersonal();
			break;
		case '2':#consulta de catalogos
			echo $uaa->getCatalogo($_GET['catalogo']);
			#header("Content-type: application/pdf");
			#echo $r->viewDoc($_GET['doc'],$_GET['tbl']);
			break;
		case '3':
			echo $uaa->getPerDed();
			break;
		case '4':
			echo $uaa->getNamesPersonal();
			break;
		case '5':
			echo $uaa->getNR();
			break;
		case '6':
			echo $uaa->getRegistroSP();
			break;
		# Buscar las quincena pagada
		case '7':
			echo $uaa->getQuincenaPagada();
			break;
		
			
		default:
			echo json_encode( array("status"=>'error','message'=>'La ruta seleccionada no existe. Verifique con el Depto. de Desarrollo de Sistemas.') );
			break;
	}
}

?>