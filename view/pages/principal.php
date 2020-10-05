<?php
#recuperar el perfil al que pertenece
$perfil = $_SESSION['perfil'];

if ( isset($_GET['menu']) ) {
	$menu = $_GET['menu'];

	switch ($perfil) {
		case 'UAA':
			switch ($menu) {
				case 'cedula':#
					include 'view/pages/uaa/content_header/header_fump.php';
					include 'view/pages/uaa/content_main/content_fump.php';
					break;
				case 'add_personal':#
				case 'general':#
					include 'view/pages/uaa/content_header/header_add_personal.php';
					include 'view/pages/uaa/content_main/content_add_personal.php';
					break;

				case 'list_personal':#
					include 'view/pages/uaa/content_header/header_list_personal.php';
					include 'view/pages/uaa/content_main/content_list_personal.php';
					#Seccion de modal
					include 'view/pages/uaa/modals/modal_add_doc.php';
					break;
				case 'add_fump':#
					include 'view/pages/uaa/content_header/header_add_fump.php';
					include 'view/pages/uaa/content_main/content_add_fump.php';
					#Seccion de modal
					include 'view/pages/uaa/modals/modal_add_doc.php';
					break;
				case 'asistencia':#
					include 'view/pages/uaa/content_header/header_fump.php';
					include 'view/pages/uaa/content_main/content_asistencia.php';
					#Seccion de modal
					#include 'view/pages/uaa/modals/modal_add_doc.php';
					break;
				case 'ver_asistencia':#
					include 'view/pages/uaa/content_header/header_ver_a.php';
					include 'view/pages/uaa/content_main/content_ver_a.php';
					#Seccion de modal
					#include 'view/pages/uaa/modals/modal_add_doc.php';
					break;
					
				case 'retardos':#
					include 'view/pages/uaa/content_header/header_fump.php';
					include 'view/pages/uaa/content_main/content_asistencia.php';
					#Seccion de modal
					#include 'view/pages/uaa/modals/modal_add_doc.php';
					break;
				case 'h_asistencia':#historico de asitencia
					include 'view/pages/uaa/content_header/header_as_historico.php';
					include 'view/pages/uaa/content_main/content_as_historico.php';
					#Seccion de modal
					#include 'view/pages/uaa/modals/modal_add_doc.php';
					break;
				case 'edit_fump':#historico de asitencia
					include 'view/pages/uaa/content_header/header_edit_fump.php';
					include 'view/pages/uaa/content_main/content_edit_fump.php';
					#Seccion de modal
					#include 'view/pages/uaa/modals/modal_add_doc.php';
					break;
				case 'pagar':#pago de nomina
					include 'view/pages/uaa/content_header/header_pagar.php';
					include 'view/pages/uaa/content_main/content_pagar.php';
					#Seccion de modal
					#include 'view/pages/uaa/modals/modal_add_doc.php';
					break;
				case 'add_pd':#alta de percep y deduccion
					include 'view/pages/uaa/content_header/header_add_pd.php';
					include 'view/pages/uaa/content_main/content_add_pd.php';
					#Seccion de modal
					include 'view/pages/uaa/modals/modal_editar_pd.php';
					break;
				case 'add_regla':
					include 'view/pages/uaa/content_header/header_add_regla.php';
					include 'view/pages/uaa/content_main/content_add_regla.php';
					break;
				case 'r_criterio':
					include 'view/pages/uaa/content_header/header_reporte_criterio.php';
					include 'view/pages/uaa/content_main/content_reporte_criterio.php';
					break;
				case 'comprobante_sp':
					include 'view/pages/uaa/content_header/header_recibo_sp.php';
					include 'view/pages/uaa/content_main/content_recibo_sp.php';
					break;
				case 'niveles':
					include 'view/pages/uaa/content_header/header_niveles.php';
					include 'view/pages/uaa/content_main/content_niveles.php';
					break;
				case 'validar_pagar':
					include 'view/pages/uaa/content_header/header_valida_pago.php';
					include 'view/pages/uaa/content_main/content_valida_pago.php';
					break;
				case 'timbre':
					include 'view/pages/uaa/content_header/header_timbre.php';
					include 'view/pages/uaa/content_main/content_timbre.php';
					break;
				case 'osfem':
					include 'view/pages/uaa/content_header/header_osfem.php';
					include 'view/pages/uaa/content_main/content_osfem.php';
					break;
				case 'dispersion':
					include 'view/pages/uaa/content_header/header_dispersion.php';
					include 'view/pages/uaa/content_main/content_dispersion.php';
					break;
				case 'dispersion':
					include 'view/pages/uaa/content_header/header_dispersion.php';
					include 'view/pages/uaa/content_main/content_dispersion.php';
					break;
				case 'quincenas_p':
					include 'view/pages/uaa/content_header/header_quincenas_p.php';
					include 'view/pages/uaa/content_main/content_quincenas_p.php';
					break;
					
				default:
					header("Location: ../../login.php");
					break;
			}
			break;
		
		case 'sys':#perfil de sistemas
			switch ($menu) {
				case 'general':
					# code...
					break;
				default:
					header("Location: ../../login.php");
					break;
			}
			break;
		default:
			# code...
			break;
	}
}
?>