//import moment from 'moment';
moment.locale('es');
$(document).ready(function() {
	//iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    });
    //Initialize Select2 Elements
	$('.select2').select2({
		language: {
			noResults: function() {
		      return "No hay elementos para seleccionar";        
		    }
		}
	});
	//Timepicker
	$('.timepicker').timepicker({
	  showInputs: true,
	  minuteStep: 1,
	  showMeridian: false,
	});
    url = window.location.search;
	url = url.split('&');
	getURL(url[0]);
});
function getURL(url) {
	if ( url == '?menu=general' || url == '?menu=add_personal' ) {
		$('#option_1').addClass('active');		
		$('#option_1_1').addClass('active');	
		load_catalogo('depe','dependencias','select','');
		load_catalogo('orga','orga_subs','select','');
		load_catalogo('dir_e','direcciones','select','');
		//CARGAR CATALOGOS DE AREAS INTERNOS
		load_catalogo('dir','direcciones_int','select','');
		load_catalogo('subdir','subdirecciones_int','select','');
		load_catalogo('depto','departamentos_int','select','');
		load_catalogo('municipio','municipios','select','');
		load_catalogo('nivel','niveles_rangos','select','');
		form_smart('frm_add_personal',false,false,'add_person');

	}
	if ( url == '?menu=list_personal' ) {
		$('#option_1').addClass('active');		
		getPersonal();
	}
	if ( url == '?menu=asistencia' ) {
		$('#option_2').addClass('active');		
		$('#option_2_1').addClass('active');		
		$('.timepicker').timepicker({ showInputs: false });
		load_catalogo('quincenas','c_quincenas','select','');
		load_catalogo('quincenas_s','c_quincenas','select','');
		form_smart('frm_registr_e',false,true,'alerta_entrada');
		form_smart('frm_registr_s',false,true,'alerta_salida');
	}
	if ( url == '?menu=retardos' ) {
		$('#option_2').addClass('active');		
		$('#option_2_2').addClass('active');		 
	}
	if ( url == '?menu=h_asistencia' ) {
		$('#option_2').addClass('active');		
		$('#option_2_3').addClass('active');		 
	}
	
	if ( url == '?menu=ver_asistencia' ) {
		$('#option_2').addClass('active');		
		$('#option_2_4').addClass('active');		
		load_catalogo('quincenas','c_quincenas','select','');
		$('#quincenas').change(function(e) {
			e.preventDefault();
			registro_asistencia($(this).val());
		});
	}
	
	if ( url == '?menu=pagar' ) {
		$('#option_3').addClass('active');		
		$('#option_3_1').addClass('active');	
		//getPersonalBy('');	
		load_catalogo('c_quincena','c_quincenas','select','');
		frm_inicio_pago();
		autocompletado('name_sp','sp_id');
		change('c_per_ded','per_ded','criterio');
		window.onbeforeunload = function(e) {
			return "¿Esta seguro que desea actualizar la página?";
		};
	}
	if ( url == '?menu=add_pd' ) {
		$('#option_3').addClass('active');		
		$('#option_3_2').addClass('active');
		getPerDed();	
		$('#metodo').change(function(e) {
			e.preventDefault();
			if ($(this).val() == '1') { $('#monto').removeClass('hidden');$('#porcentaje').addClass('hidden'); }
			if ($(this).val() == '2') {$('#porcentaje').removeClass('hidden');$('#monto').addClass('hidden');}
		});
		$('#condicion').change(function(e) {
			e.preventDefault();
			if ( $(this).val() == "2" ) {
				$('#div_funciones').removeClass('hidden');
				load_catalogo('funciones','formulas','select','');
			}else{
				$('#div_funciones').addClass('hidden');
			}
		});
		
		form_smart('frm_add_pd',false,false,'alerta_pd');
	}
	if ( url == '?menu=add_regla' ) {
		$('#option_3').addClass('active');		
		$('#option_3_3 ').addClass('active');	
		autocompletado('name_sp','sp_id');
		change('t_concepto','per_ded','concepto');
		form_smart('frm_add_regla',false,false,'alerta_regla');
	}
	if ( url == '?menu=quincenas_p' ) {
		$('#option_3').addClass('active');		
		$('#option_3_4 ').addClass('active');
		load_catalogo('quincenas','c_quincenas','select','');
		frm_quincena_p();
	}
	if ( url == '?menu=comprobante_sp' ) {
		$('#option_4').addClass('active');		
		$('#option_4_2').addClass('active');
		load_catalogo('c_quincena','c_quincenas','select','');	
		autocompletado('servidor','servidor_id');
	}
	if ( url == '?menu=r_criterio' ) {
		$('#option_4').addClass('active');		
		$('#option_4_1').addClass('active');
		load_catalogo('c_quincena','c_quincenas','select','');	
	}
	if ( url == '?menu=niveles' ) {
		$('#option_1').addClass('active');		
		$('#option_1_3 ').addClass('active');
		form_smart('frm_add_nivel',false,false,'nivel_rango');
		getNivelesRangos();
	}
	if ( url == '?menu=add_fump' ) {
		$('#option_1').addClass('active');		
		$('#option_1_3 ').addClass('active');
		form_smart('frm_complete_fump',false,false,'complete_fump');
		autompletado_sustituido();
		load_catalogo('percepciones','per_ded','select',1);	
		load_catalogo('deducciones','per_ded','select',2);	
		load_catalogo('n_plaza','catalogo_plazas','select','');	
	}
	if ( url == '?menu=validar_pagar' ) {
		$('#option_3').addClass('active');		
		$('#option_3_1 ').addClass('active');
		form_smart('frm_realiza_pago',false,false,'alerta_pagar');
	}
	if ( url == '?menu=timbre' ) {
		$('#option_5').addClass('active');		
		$('#option_5_1 ').addClass('active');
		load_catalogo('quincenas','c_quincenas','select','');
		frm_reporte_timbre();
		
	}
	if ( url == '?menu=osfem' ) {
		$('#option_5').addClass('active');		
		$('#option_5_2 ').addClass('active');
		load_catalogo('quincenas','c_quincenas','select','');
		frm_osfem();
	}
	if ( url == '?menu=dispersion' ) {
		$('#option_5').addClass('active');		
		$('#option_5_3 ').addClass('active');
		load_catalogo('quincenas','c_quincenas','select','');
		frm_dispersion();
	}
	
	
	return false;
}
function getPersonal() {
	var datos = {
	    class: 'table-striped table-bordered table-hover border-table',
	    columnas: [
	    	{ leyenda: 'Acciones', class:'text-center',ordenable:false},
	        { leyenda: 'ID', class:'text-center',ordenable:true,columna:'id'},
	        { leyenda: 'Nombre_completo',class:'text-center', columna:'full_name',ordenable:false,filtro:true},
	        { leyenda: 'Areas',class:'text-center', columna:'name_area',ordenable:true,filtro:true},
	        { leyenda: 'No. plaza/Nivel-Rango',class:'text-center', columna:'num_plaza',ordenable:true,filtro:true},
	        { leyenda: 'CURP-RFC',class:'text-center', columna:'curp_rfc',ordenable:true,filtro:true},
	        { leyenda: 'Clave serv. público',class:'text-center', columna:'cve_sp',ordenable:true,filtro:true},
	        { leyenda: 'Años de serv.',class:'text-center', columna:'cve_sp',ordenable:false,filtro:true},
	        { leyenda: 'Tipo de personal',class:'text-center', columna:'d.t_sindicato',ordenable:false,filtro:function(){
	        	return anexGrid_select({
	        		data:[
		        		{valor:'',contenido:'TODOS'},
		        		{valor:'1',contenido:'SINDICALIZADO'},
		        		{valor:'2',contenido:'NO SINDICALIZADO'}
	        		]
	        	});
	        }},
	        { leyenda: 'Estado',class:'text-center', columna:'p.estado',ordenable:false,filtro:function(){
	        	return anexGrid_select({
	        		data:[
		        		{valor:'',contenido:'TODOS'},
		        		{valor:'1',contenido:'ACTIVOS'},
		        		{valor:'2',contenido:'INACTIVOS'},
		        		{valor:'3',contenido:'BAJAS'}
	        		]
	        	});
	        }},
	        
	    ],
	    modelo: [
	    	{ class:'',formato: function(tr, obj, valor){
	            return anexGrid_dropdown({
                    contenido: '<i class="glyphicon glyphicon-cog"></i>',
                    class: 'btn btn-primary opciones',
                    target: '_blank',
                    id: 'editar-' + obj.id,
                    data: acciones = [
	    				{ href: "index.php?menu=add_fump&fump_id="+obj.id, contenido: '<i class="fa fa-pencil"></i>Completar F.U.M.P.' },
	    				//{ href: "index.php?menu=cedula&persona_id="+obj.id, contenido: '<i class="glyphicon glyphicon-eye-open "></i>Ver F.U.M.P.' },
	    				//{ href: "index.php?menu=edit_fump&person="+obj.id, contenido: '<i class="glyphicon glyphicon-cloud"></i> Editar F.U.M.P.' },
	    				{ href: "javascript:open_modal('modal_add_file',"+obj.id+");", contenido: '<i class="fa fa-edit"></i> Adjuntar documento' },
                    ]
                });
	        }}, 
	        {class:'text-center', formato: function(tr, obj, valor){
	            return obj.id;
	        }}, 
	        {class:'text-center', formato: function(tr, obj, valor){
	            return obj.nombre+ " "+ obj.ap_pat+" "+obj.ap_mat;
	        }}, 
	        {class:'text-left', formato: function(tr, obj, valor){
	        	var lista = "", direccion = "", subdireccion = "", departamento = "";
	        	direccion = ( obj.direccion != null ? obj.direccion : 'NO REGISTRADO' );
	        	subdireccion = ( obj.subdireccion != null ? obj.subdireccion : 'NO REGISTRADO' );
	        	departamento = ( obj.departamento != null ? obj.departamento : 'NO REGISTRADO' );
	        	lista+="<ul>";
	        		lista +="<li><b>DIRECCIÓN:</b>"+direccion+"</li>";
	        		lista +="<li><b>SUBDIRECCIÓN:</b>"+subdireccion+"</li>";
	        		lista +="<li><b>DEPARTAMENTO:</b>"+departamento+"</li>";
	        	lista+="</ul>";
	            return lista;
	        }}, 
	        {class:'text-center', formato: function(tr, obj, valor){
	            return obj.nivel_rango;
	        }}, 
	        {class:'text-left', formato: function(tr, obj, valor){
            	var lista = "";
            	lista+="<ul>";
            		lista +="<li><b>C.U.R.P.:</b>"+obj.curp+"</li>";
            		lista +="<li><b>R.F.C.:</b>"+obj.rfc+"</li>";
            	lista+="</ul>";
                return lista;
	        }}, 
	        {class:'text-center', formato: function(tr, obj, valor){
	            return obj.clave;
	        }}, 
	        {class:'text-center', formato: function(tr, obj, valor){
	            return obj.y_ser;
	        }}, 
	        {class:'text-center', formato: function(tr, obj, valor){
	            return obj.t_sindicato;
	        }},
	        {class:'text-center', formato: function(tr, obj, valor){
	            return obj.estado;
	        }}, 
	        
	         
	    ],
	    url: 'controller/puente.php?option=1',
	    columna: 'id',
	    columna_orden: 'DESC',
	    ordenable: true,
	    type:'POST',
	    paginable:true,
	    limite:[25,50,100,200,500],
	    filtrable:true
	    
	};
	var tabla = $("#listado_personal").anexGrid(datos);
	return tabla;
}
//ver el registro de asistencia 
function registro_asistencia(quincena) {
	//console.log(quincena);
	var datos = {
	    class: 'table-striped table-bordered table-hover border-table',
	    columnas: [
	    	{ leyenda: 'Acciones', class:'text-center',ordenable:false},
	        { leyenda: 'Núm. tarjeta', class:'text-center',ordenable:true,columna:'p.num_tarjeta', filtro:true, style:'width:100px;'},
	        { leyenda: 'Nombre_completo',class:'text-center', columna:'full_name',ordenable:false,filtro:true},
	        { leyenda: 'Fecha de asistencia',class:'text-center', columna:'r.f_asistencia',ordenable:false,filtro:true},
	        { leyenda: 'Registro de asistencia',class:'text-center', columna:'name_area',ordenable:false,filtro:false},
	    ],
	    modelo: [
	    	{ class:'',formato: function(tr, obj, valor){
	            return anexGrid_dropdown({
                    contenido: '<i class="glyphicon glyphicon-cog"></i>',
                    class: 'btn btn-primary opciones',
                    target: '_blank',
                    id: 'editar-' + obj.id,
                    data: acciones = [
	    				//{ href: "index.php?menu=add_fump&fump_id="+obj.id, contenido: '<i class="fa fa-pencil"></i>Completar F.U.M.P.' },
	    				//{ href: "javascript:open_modal('modal_add_file',"+obj.id+");", contenido: '<i class="fa fa-edit"></i> Adjuntar documento' },
                    ]
                });
	        }}, 
	        {class:'text-center ',style:'color: black;', formato: function(tr, obj, valor){
	            return obj.num_tarjeta;
	        }}, 
	        
	        {class:'text-center',style:'color: black;', formato: function(tr, obj, valor){
	            return obj.full_name;
	        }}, 
	        {class:'text-center',style:'color: black;', formato: function(tr, obj, valor){
	            return obj.f_asistencia;
	        }}, 
	        {class:'text-center',style:'color: black;', formato: function(tr, obj, valor){
	        	var sph_salida;var estado; var diff; 

	        	if ( obj.h_salida === null ) {
	        		sph_salida = "TIENE FALTA.";
	        	}else{
	        		sph_salida = obj.h_salida;
	        	}
	        	var he = moment(obj.h_entrada, 'HH:mm:ss');
	        	var hora_e = moment('9:00:00', 'HH:mm:ss');
				var hora_s = moment('18:00:00','HH:mm:ss');
				var he_tolerancia = moment('09:10:00','HH:mm:ss');
				var he_retardo = moment('09:11:00','HH:mm:ss');
				var he_retardo_l = moment('09:30:00','HH:mm:ss');//Hora de retardo limite 
				var he_falta = moment('09:31:00','HH:mm:ss');//Hora de entrada con falta
				if (/*he.isBefore(hora_e) || ||*/he.isSameOrBefore(hora_e) ) {
					estado = 'OK';
					tr.addClass('bg-green');
				}else{
					if( he.isSameOrBefore(he_tolerancia) && he.isAfter(hora_e)){
						estado = 'NO HAY RETARDO, NO HAY PREMIO.';
						tr.addClass('bg-aqua');
					}else if ( he.isBetween(he_retardo,he_retardo_l) ){
						diff = he.diff( he_retardo ,'minutes') ;
						estado = 'TIENE RETARDO DE '+diff+' MINUTOS';
						tr.addClass('bg-yellow');
					}else if (he.isSameOrAfter(he_falta)) {
						tr.addClass('bg-red');
						estado = 'TIENE FALTA';
					}
					if (estado == undefined) {
						tr.addClass('bg-red');
						estado = "";
					}
				}	        	
	            return "ENTRADA: <b>"+obj.h_entrada+"</b> SALIDA: <b>"+sph_salida+"</b><br> <b>"+estado+"</b>";
	        }}, 
	    ],
	    url: 'controller/puente.php?option=6',
	    columna: 'id',
	    columna_orden: 'DESC',
	    ordenable: true,
	    type:'POST',
	    paginable:true,
	    limite:[25,50,100,200,500],
	    filtrable:true,
	    parametros: [{q:quincena}]
	    
	};
	var tabla = $("#tbl_registro").anexGrid(datos);
	return tabla;
}
//funcion para abrir modal 
function open_modal(modal_id) {
	$('#'+modal_id).modal('show');
	return false;
}

//Agregar campos de criterio de percepcion/deduccion para el pago de nomina
function add_criterio(div_personal) {
	var divs = document.getElementsByClassName("criterio").length;
	//genera nombre del ID 
	var name_id = "c_per_ded_"+divs;
	//Nombre del destino
	var name_destino = "criterio_"+divs;
	//Nombre del input_monto
	var name_id_destino = "monto_"+divs;
	//genera evento onchange
	var evento = "change('"+name_id+"','per_ded','"+name_destino+"');";
	
	var criterio = "";
	criterio += '<div class="row criterio '+divs+'">';
		criterio += '<div class="col-md-2">';
			criterio += '<div class="form-group">';
				criterio += '<label>Percepción o deducción</label>';
				criterio += '<select name="t_per_ded[]" id="'+name_id+'" class="form-control" onchange="'+evento+'">';
					criterio += '<option value="">...</option>';
					criterio += '<option value="1">Percepción</option>';
					criterio += '<option value="2">Deducción</option>';
				criterio += '</select>';
			criterio += '</div>';
		criterio += '</div>';
		criterio += '<div class="col-md-4">';
			criterio += '<div class="form-group">';
				criterio += '<label>Crieterio a aplicar</label>';
				criterio += '<select name="criterio_e[]" id="'+name_destino+'" class="form-control">';
					criterio += '<option value="">...</option>';
				criterio += '</select>';
			criterio += '</div>';
		criterio += '</div>';
			criterio += '<div class="col-md-3">';
				criterio += '<div class="form-group">';
					criterio += '<label>Monto</label>';
					criterio += '<div class="input-group">';
					    criterio += '<span class="input-group-addon">';
					        criterio += '<i class="fa fa-dollar"></i>';
					    criterio += '</span>';
					    criterio += '<input type="text" class="form-control" id="'+name_id_destino+'" name="monto[]"  placeholder="500" onkeypress="return event.charCode >= 45 && event.charCode <= 57">';
		    			criterio += '<span class="input-group-btn">';
		    				criterio += '<i class="fa fa-dollar"></i>';
		                	criterio += '<button type="button" class="btn btn-danger btn-flat" onclick="remove_criterio('+divs+')"> <i class="fa fa-minus"></i> </button>';
		                	//criterio += '<button type="button" class="btn btn-primary btn-flat" onclick="alert('+"'Buscar en la calcu financiera'"+');"> <i class="fa fa-search"></i> </button>';
		                criterio += '</span>';
					criterio += '</div>';
				criterio += '</div>';
			criterio += '</div>';
	criterio += '</div>';

	//Contar los elementos
	if ( divs >= 20 ) {
		$('#btn_add_criterio').addClass('hidden');
	}else{
		$('div#'+div_personal).append(criterio);
	}
	change(name_id,'per_ded',name_destino);
	getInfoPerDed(name_destino,name_id_destino);
	return false;
}
//Remover un criterio 	
function remove_criterio(elemento) {
	$('.'+elemento).remove();
	return false;
}

//Carga de catalogos
function load_catalogo(campo,catalogo, t_campo,extra) {
	$.ajax({
		url: 'controller/puente.php',
		type: 'POST',
		dataType: 'json',
		data: {option: '3',catalogo:catalogo, e:extra},
		async:false,
		cache:false
	})
	.done(function(response) {
		$("#"+campo).html("");
		$("#"+campo).append('<option value="">...</option>');
		$.each(response, function(i, val) {
			$("#"+campo).append('<option value="'+val.id+'">'+val.value+'</option>');
		});
	})
	.fail(function(jqXHR,textStatus,errorThrown) {
		console.log(jqXHR.responseText);
	});
	return false;
}
//frm_inicio_pago
function frm_inicio_pago() {
	$('#frm_inicio_pago').submit(function(e) {
		e.preventDefault();
		var tipo_pago = $('#a_pago').val();
		switch(tipo_pago){
			case '1':
				$('#aplica_all').removeClass('hidden');
				$('#name_quincena').val( $('#c_quincena :selected').text() );
				$('#num_quincena').val( $('#c_quincena :selected').val() );
				$('#aplica_some').addClass('hidden');
				$('#aplica_sindicalizados').addClass('hidden');
				$('#aplica_not_sindicalizados').addClass('hidden');
				$('#aplica_jefes').addClass('hidden');
				break;
			case '2':
				$('#aplica_all').addClass('hidden');
				$('#aplica_some').removeClass('hidden');
				$('#aplica_sindicalizados').addClass('hidden');
				$('#aplica_not_sindicalizados').addClass('hidden');
				$('#aplica_jefes').addClass('hidden');
				break;
			case '3':
				$('#aplica_all').addClass('hidden');
				$('#aplica_some').addClass('hidden');
				$('#aplica_sindicalizados').removeClass('hidden');
				$('#aplica_not_sindicalizados').addClass('hidden');
				$('#aplica_jefes').addClass('hidden');
				break;
			case '4':
				
				$('#aplica_all').addClass('hidden');
				$('#aplica_some').addClass('hidden');
				$('#aplica_sindicalizados').addClass('hidden');
				$('#aplica_not_sindicalizados').removeClass('hidden');
				$('#aplica_jefes').addClass('hidden');
				break;
			case '5':
				$('#aplica_all').addClass('hidden');
				$('#aplica_some').addClass('hidden');
				$('#aplica_sindicalizados').addClass('hidden');
				$('#aplica_not_sindicalizados').addClass('hidden');
				$('#aplica_jefes').removeClass('hidden');
				break;
			default:
				alert('No existe esa opción');
				break	
		}
	});
}
//Carga de formulario inteligente
function form_smart(frm,upFile,multiple,d_alerta) {
	var params ;
	
	$('#'+frm).submit(function(e) {
		e.preventDefault();
		
		if ( upFile == true && multiple == false ) {
			var formData = new FormData(document.getElementById(frm));
			params = {
				url: 'controller/puente.php',
				type: 'POST',
				dataType: 'json',
				data: formData,
				async: false,
				cache: false,
				contentType: false,
	    		processData: false
			}
		}else if ( upFile == false && multiple == true ) {
			var formData = $('#'+frm).serializeArray();
			params = {
				url: 'controller/puente.php',
				type: 'POST',
				dataType: 'json',
				data: formData,
				async: false,
				cache: false,
			}
		}else{
			var formData = $('#'+frm).serialize();
			params = {
				url: 'controller/puente.php',
				type: 'POST',
				dataType: 'json',
				data: formData,
				async: false,
				cache: false,
			}
		}
		$.ajax(params)
		.done(function(response) {
			alerta(d_alerta,response.status,response.message,'');
			if ( frm == 'frm_add_pd' ) { getPerDed(); }
		})
		.fail(function(jqXHR,textStatus,errorThrown) {
			alerta(d_alerta,'error',jqXHR.responseText,'');
		});
		
	});
	return false;
}
//Creador de alertas automatico
function alerta(div,estado,mensaje,modal)
{
	var clase,icono,msj,edo;
	if ( estado == 'error' ) {
		icono = "fa-times";
		clase = "alert-danger";
		msj = mensaje;
		edo = "Error!";
		time = 10000;
	}
	if ( estado == 'success') {
		icono = "fa-check";
		clase = "alert-success";
		msj = mensaje;
		edo = "Éxito!";
		time = 10000;
	}
	var contenedor = 
	'<div class="row">'+
		'<div class="col-md-12">'+
			'<div class="alert '+clase+' ">'+
				'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+
				'<h4><i class="icon fa '+icono+'"></i> '+edo+'</h4>'+
				'<p> '+msj+' </p>'+
			'</div>'+
		'</div>'+
	'</div>';
	$('#'+div).html(contenedor);
	location.href = "#"+div;
	setTimeout(function() {
		$('#'+div).html("");
		if ( modal != '' ) {
			$('#'+modal).modal('hide');
		}
	},time);
	return false;
}

function getPerDed() {// Recuperar las percepciones y deducciones
	var datos = {
	    class: 'table-bordered table-hover',
	    columnas: [
	        { leyenda: 'ID', class:'text-center',ordenable:true,columna:''},
	        { leyenda: 'Nombre del concepto',class:'text-center', columna:'nombre',ordenable:false,filtro:true},
	        { leyenda: 'Tipo',class:'text-center', columna:'tipo',ordenable:false,filtro:function () {
	        	return anexGrid_select({
    	            data: [
    	               { valor: '', contenido: 'Todos' },
    	               { valor: '1', contenido: 'Percepción' },
    	               { valor: '2', contenido: 'Deducción' },
    	           ]
    	       });
	        }},
	        { leyenda: 'Monto',class:'text-center', columna:'',ordenable:true,filtro:false},
	        { leyenda: 'Cve. interna',class:'text-center', columna:'cve_int',ordenable:true,filtro:true,style:'width:100px;'},
	        { leyenda: 'Cve. externa',class:'text-center', columna:'cve_ext',ordenable:true,filtro:true,style:'width:100px;'},
	    	{ leyenda: 'Editar', class:'text-center',ordenable:false,style:'width:50px;'},
	    ],
	    modelo: [
	    	
	        {class:'text-center', formato: function(tr, obj, valor){
	            return obj.id;
	        }}, 
	        {class:'text-center', formato: function(tr, obj, valor){
	            return obj.nombre;
	        }},
	        {class:'text-center', formato: function(tr, obj, valor){
	        	if ( obj.tipo == 'PERCEPCION' ) { return 'PERCEPCIÓN'}
	        	if ( obj.tipo == 'DEDUCCION' ) { return 'DEDUCCIÓN'}
	        }},
	        {class:'text-center', formato: function(tr, obj, valor){
	            return obj.monto;
	        }}, 
	        {class:'text-center', formato: function(tr, obj, valor){
	            return obj.cve_int;
	        }}, 
	        {class:'text-center', formato: function(tr, obj, valor){
	            return obj.cve_ext;
	        }}, 
	        
	        { class:'',formato: function(tr, obj, valor){
	            var fila_id = tr.data('fila');
	            return '<button value="' + fila_id + '" type="button" class="btn btn-primary btn-editar"> <i class="fa fa-pencil"></i></button>';
	        }}, 
	        
	    ],
	    url: 'controller/puente.php?option=3',
	    columna: 'id',
	    columna_orden: 'DESC',
	    ordenable: true,
	    type:'POST',
	    paginable:true,
	    limite:[25,50,100,200,500],
	    filtrable:true
	    
	};
	var tabla = $("#listado_pd").anexGrid(datos);
	tabla.tabla().on('click', '.btn-editar', function(){
		var obj = tabla.obtener($(this).val());
		open_modal('modal_editar_pd');
	});
	return tabla;
}
//autompletado
function autocompletado(campo,campo_hidden) {
	$( "#"+campo ).autocomplete({
		source: "controller/puente.php?option=4",
		minLength: 2,
		select: function( event, ui ) {
			$('#'+campo_hidden).val( ui.item.id );
			if (campo == 'name_sp') {
				cargar_per_ded_predeterminadas(ui.item.id);
				cargar_retardos(ui.item.id);
			}
		}
	});
	return false;
}
//funcion para eventos change
function change(campo,catalogo,destino) {
	$('#'+campo).change(function(e) {
		e.preventDefault();
		var tipo = $('#'+campo).val();
		$.ajax({
			url: 'controller/puente.php',
			type: 'POST',
			dataType: 'json',
			data: {option: '3', catalogo:catalogo, tipo:tipo},
			async:false,
			cache:false,
		})
		.done(function(response) {
			$('#'+destino).html("");
			$('#'+destino).append('<option value="">...</option>');
			$.each(response, function(i, val) {
				$('#'+destino).append('<option value="'+val.id+'">'+val.value+'</option>');
			});
		})
		.fail(function(jqXHR,textStatus,errorThrown) {
			console.log("error");
		});
	});
	return false;
}
//Recuperar el listado de niveles y rangos 
function getNivelesRangos() {
	var datos = {
	    class: 'table-bordered table-hover',
	    columnas: [
	        { leyenda: 'ID', class:'text-center',ordenable:true,columna:''},
	        { leyenda: 'Nombre del concepto',class:'text-center', columna:'nombre',ordenable:false,filtro:true},
	        { leyenda: 'Clave',class:'text-center', columna:'tipo',ordenable:false,filtro:false},
	    	{ leyenda: 'Editar', class:'text-center',ordenable:false,style:'width:50px;'},
	    ],
	    modelo: [
	    	
	        {class:'text-center', formato: function(tr, obj, valor){
	            return obj.id;
	        }}, 
	        {class:'text-center', formato: function(tr, obj, valor){
	            return obj.nombre;
	        }},
	        {class:'text-center', formato: function(tr, obj, valor){
	            return obj.clave;
	        }},
	        { class:'',formato: function(tr, obj, valor){
	            var fila_id = tr.data('fila');
	            return '<button value="' + fila_id + '" type="button" class="btn btn-primary btn-editar"> <i class="fa fa-pencil"></i></button>';
	        }}, 
	        
	    ],
	    url: 'controller/puente.php?option=5',
	    columna: 'id',
	    columna_orden: 'DESC',
	    ordenable: true,
	    type:'POST',
	    paginable:true,
	    limite:[25,50,100,200,500],
	    filtrable:true
	    
	};
	var tabla = $("#list_nr").anexGrid(datos);
	tabla.tabla().on('click', '.btn-editar', function(){
		var obj = tabla.obtener($(this).val());
		alert('Aún no se puede editar');
		//open_modal('modal_editar_pd');
	});
	return tabla;
}
//autompletado para el completado del FUMP
function autompletado_sustituido() {
	$('#nombre_ds').autocomplete({
		source: "controller/puente.php?option=4",
		minLength: 2,
		select: function( event, ui ) {
			$('#id_nombre_ds').val( ui.item.id );
			find_data(ui.item.id);
		}
	});
	return false;
}
//encontrar clave issemym y rfc
function find_data(id) {
	$.ajax({
		url: 'controller/puente.php',
		type: 'POST',
		dataType: 'json',
		data: {option: '7', id:id},
		async:false,
		cache:false,
	})
	.done(function(response) {
		$('#cve_issemym').val(response.issemym);
		$('#rfc_ds').val(response.rfc);
	})
	.fail(function(jqXHR,textStatus,errorThrown) {
		console.log("Error: "+jqXHR.responseText);
	});
	
}
function total_neto() {
	var a = $('#suma_a').val();
	a = parseFloat(a);
	var b = $('#suma_b').val();
	b = parseFloat(b);
	t = a+b;
	$('#t_neto').val(t);
	return false;
}
//cargar las percepciones y deducciones predeterminadas de un SP.
function cargar_per_ded_predeterminadas(sp) {
	var percepciones = "";
	var deducciones = "";
	var fila = "";
	$.ajax({
		url: 'controller/puente.php',
		type: 'POST',
		dataType: 'json',
		data: {option: '10',sp_id:sp},
		async:false,
		cache:false,
	})
	.done(function(response) {
		$('#per_predeterminadas').html("");
		$('#ded_predeterminadas').html("");
		$.each(response.percepciones, function(i, val) {
			var monto = 0; var fila = "";
			if ( val.monto_regla == ''|| val.monto_regla == null || val.monto_regla == '0.00' || val.monto_regla == '0' ) {
				monto = val.monto_origen;
			}else{
				monto = val.monto_regla; 
			}
			fila += "<div class='row'>";
				fila += '<div class="col-md-2">';
				    fila += '<div class="form-group">';
				        fila += '<label>Percepción o deducción</label>';
				        fila += '<select name="c_per_ded" id="" class="form-control" required>';
				            fila += '<option value="1">Percepción</option>';
				        fila += '</select>';
				    fila += '</div>';
				fila += '</div>';
				fila +='<div class="col-md-4">';
				    fila +='<div class="form-group">';
				        fila +='<label>Criterio</label>';
				        fila +='<select name="criterio_per[]" id="" class="form-control" required>';
				            fila +='<option value="'+val.pd_id+'">'+val.nombre+'</option>';
				        fila +='</select>';
				    fila +='</div>';
				fila +='</div>';
				fila +='<div class="col-md-3">';
				    fila +='<div class="form-group">';
				        fila +='<label>Monto</label>';
				        fila +='<div class="input-group">';
				            fila +='<span class="input-group-addon">';
				                fila +='<i class="fa fa-dollar"></i>';
				            fila +='</span>';
				            fila +='<input type="text" name="per_monto[]" value="'+monto+'" class="form-control" placeholder="500" onkeypress="return event.charCode >= 45 && event.charCode <= 57">';
				        fila +='</div>';
				    fila +='</div>';
				fila +='</div>';
			fila += "</div>";
			
			$('#per_predeterminadas').append(fila);
			
			
			//Sueldo base.
		});
		$.each(response.deducciones, function(i, val) {
			var monto = 0; var fila = "";
			if ( val.monto_regla == ''|| val.monto_regla == null || val.monto_regla == '0.00' || val.monto_regla == '0' ) {
				monto = val.monto_origen;
			}else{
				monto = val.monto_regla; 
			}
			fila += "<div class='row'>";
				fila += '<div class="col-md-2">';
				    fila += '<div class="form-group">';
				        fila += '<label>Percepción o deducción</label>';
				        fila += '<select name="c_per_ded" id="" class="form-control" required>';
				            fila += '<option value="2">Deducción</option>';
				        fila += '</select>';
				    fila += '</div>';
				fila += '</div>';
				fila +='<div class="col-md-4">';
				    fila +='<div class="form-group">';
				        fila +='<label>Criterio</label>';
				        fila +='<select name="criterio_ded[]" id="" class="form-control" required>';
				            fila +='<option value="'+val.pd_id+'">'+val.nombre+'</option>';
				        fila +='</select>';
				    fila +='</div>';
				fila +='</div>';
				fila +='<div class="col-md-3">';
				    fila +='<div class="form-group">';
				        fila +='<label>Monto</label>';
				        fila +='<div class="input-group">';
				            fila +='<span class="input-group-addon">';
				                fila +='<i class="fa fa-dollar"></i>';
				            fila +='</span>';
				            fila +='<input type="text" name="ded_monto[]" value="'+monto+'" class="form-control" placeholder="500" onkeypress="return event.charCode >= 45 && event.charCode <= 57">';
				        fila +='</div>';
				    fila +='</div>';
				fila +='</div>';
			fila += "</div>";
			
			$('#ded_predeterminadas').append(fila);
		});
	})
	.fail(function(jqXHR,textStatus,errorThrown) {
		console.log("error");
	});
	
	return false;
}
//agregar una percepcion
function add_percepcion(contenedor) {
	var divs = document.getElementsByClassName("div_per").length
	if ( divs < 31 ) {
		var id_val = "percepciones_"+divs;
		var fila = "";
		fila += '<div class="row div_per">';
		    fila += '<div class="col-md-3">';
		        fila += '<div class="form-group">';
		            fila += '<label>Concepto</label>';
		            fila += '<select name="percepiones[]" id="'+id_val+'" class="form-control" >';
		                fila += '<option value="">...</option>';
		            fila += '</select>';
		        fila += '</div>';
		    fila += '</div>';
		    fila += '<div class="col-md-3">';
		        fila += '<div class="form-group">';
		            fila += '<label>Importe</label>';
		            fila += '<div class="input-group">';
		                fila += '<span class="input-group-addon">';
		                    fila += '<i class="fa fa-dollar"></i>';
		                fila += '</span>';
		                fila += '<input type="text" name="per_importe[]" value="" class="form-control" placeholder="">';
		            fila += '</div>';
		        fila += '</div>';
		    fila += '</div>';
		fila += '</div>';
		$('#'+contenedor).append(fila);
		load_catalogo(id_val,'per_ded','select',1);	
	}else{
		alert('LIMITE ALCANZADO. INTENTE AGREGAR MÁS ELMENTOS EN EL MÓDULO NÓMINA/APLICAR REGLAS.');
	}
	return false;
}
//agregar una seccion de deduccion
function add_deduccion(contenedor) {
	var divs = document.getElementsByClassName("div_ded").length
	if (divs < 31) {
		var id_val = "deducciones_"+divs;
		var fila = "";
		fila += '<div id="'+divs+'" class="row div_ded">';
		    fila += '<div class="col-md-3">';
		        fila += '<div class="form-group">';
		            fila += '<label>Concepto</label>';
		            fila += '<select name="deducciones[]" id="'+id_val+'" class="form-control" >';
		                fila += '<option value="">...</option>';
		            fila += '</select>';
		        fila += '</div>';
		    fila += '</div>';
		    fila += '<div class="col-md-3">';
		        fila += '<div class="form-group">';
		            fila += '<label>Importe</label>';
		            fila += '<div class="input-group">';
		                fila += '<span class="input-group-addon">';
		                    fila += '<i class="fa fa-dollar"></i>';
		                fila += '</span>';
		                fila += '<input type="text" name="ded_importe[]" class="form-control" placeholder="">';
		            fila += '</div>';
		        fila += '</div>';
		    fila += '</div>';
		fila += '</div>';
		$('#'+contenedor).append(fila);
		load_catalogo(id_val,'per_ded','select',2);
	}else{
		alert('LIMITE ALCANZADO. INTENTE AGREGAR MÁS ELMENTOS EN EL MÓDULO NÓMINA/APLICAR REGLAS.');
	}
	return false;
}

function cargar_retardos(sp_id) {
	var quincena = $('#num_quincena').val();
	var descuento = 0;
	var fila = "";
	//Buscar y mostrar si la persona cuenta con retardos
	//1. 9:00 a 9:10 no hay retardo pero no hay premio.
	//2. 9:11 a 9:30 es retardo 
	//3. Despues de 9:30  ya es falta
	$.ajax({
		url: 'controller/puente.php',
		type: 'POST',
		dataType: 'json',
		data: {option: '14',sp:sp_id, q:quincena},
		async:false,
		cache:false,
	})
	.done(function(response) {
		if(response.status == 'error'){
			alerta('a_all',response.status,response.message,'');
		}else{
			//Limpiar 
			$('#div_retardos').html("");
			if ( response.tiempos.length > 0 ) {
				$.each(response.tiempos, function(i, val) {
					var he = moment(val.h_entrada,'HH:mm:ss');
					var hee = moment('09:00:00','HH:mm:ss');

					var diff = he.diff(hee,'minutes');
					if (diff > 0 && diff<=10) {
						alert('Es la hora de tolerancia');
					}else if ( diff >=11 && diff <=30 ){
						fila += '<div class="row">';
						    fila += '<div class="col-md-4">';
						        fila += '<div class="form-group">';
						            fila += '<label>Dia del retardo</label>';
						            fila += '<input type="text" name="f_retardo[]" value="'+val.f_asistencia+'" class="form-control">';
						        fila += '</div>';
						    fila += '</div>';
						    fila += '<div class="col-md-4">';
						        fila += '<div class="form-group">';
						            fila += '<label>Minutos de retardo</label>';
						            fila += '<input type="text" name="min_retraso[]" value="'+val.min_retardos+'" class="form-control">';
						        fila += '</div>';
						    fila += '</div>';
						    /*fila += '<div class="col-md-4">';
						        fila += '<div class="form-group">';
						            fila += '<label>Monto del retardo</label>';
						            fila += '<input type="text" name="mon_retardo[]" value="" class="form-control">';
						        fila += '</div>';
						    fila += '</div>';*/
						fila += '</div>';
						$('#div_retardos').append(fila);
					}else if (diff > 30){
						//alert('Se le debe de descontar el dia');
						fila += '<div class="row">';
						    fila += '<div class="col-md-4">';
						        fila += '<div class="form-group">';
						            fila += '<label>Dia de la falta</label>';
						            fila += '<input type="text" name="f_retardo[]" value="'+val.f_asistencia+'" class="form-control">';
						        fila += '</div>';
						    fila += '</div>';
						    fila += '<div class="col-md-4">';
						        fila += '<div class="form-group">';
						            fila += '<label>Hora de entrada</label>';
						            fila += '<input type="text" name="min_retraso[]" value="'+he.format('HH:mm:ss')+'" class="form-control">';
						        fila += '</div>';
						    fila += '</div>';
						    fila += '<div class="col-md-4">';
						        fila += '<div class="form-group">';
						            fila += '<label>Monto del retardo</label>';
						            fila += '<input type="text" name="mon_retardo[]" value="" class="form-control">';
						        fila += '</div>';
						    fila += '</div>';
						fila += '</div>';
						$('#div_retardos').append(fila);
					}else if (diff < 0){
						console.log('anda bien de tiempos');
					}
				});
			}else{
				$('#div_retardos').append('<label> NO SE ENCONTRARON RETARDOS NI INASISTENCIAS. </label>');
			}
		}
	})
	.fail(function(jqXHR,textStatus,errorThrown) {
		console.log("Error en la carga de retardos: "+ jqXHR.responseText);
	});
	
}
//recuperar info de la per_ded 
function getInfoPerDed(campo,destino) {
	$('#'+campo).change(function(e) {
		e.preventDefault();
		var pd = $(this).val();
		var sp_id = $("#sp_id").val();
		if (pd == '' || pd == null) {
			alert('DEBER SELECCIONAR OTRA OPCIÓN.');
		}else{
			$.post('controller/puente.php', {option: '15',pd:pd,sp:sp_id}, function(data, textStatus, xhr) {
				if (data.cond == 'error') {
					alert(' NO SE DETECTO UNA PERCEPCIÓN/DEDUCCIÓN VALIDA.');
				}else{
					$('#'+destino).val(data.valor);
				}
			},'json');
		}
		
	});
	return false;
}
// buscar las quincenas pagadas
function frm_quincena_p() {
	$('#frm_quincena_p').submit(function(e) {
		e.preventDefault();
		//
		var y , q;
		y = $('#year').val();
		q = $('#quincenas').val();
		//limpiar el div
		$('#tbl_qp').html("");
		var datos = {
		    class: 'table-striped table-bordered table-hover',
		    columnas: [
		    	{ leyenda: 'Acciones', class:'text-center',ordenable:false},
		        { leyenda: 'ID', class:'text-center',ordenable:true,columna:'id'},
		        { leyenda: 'Nombre_completo',class:'text-center', columna:'full_name',ordenable:false,filtro:true},
		        { leyenda: 'Área',class:'text-center', columna:'n_area',ordenable:true,filtro:true},
		        { leyenda: 'Nivel-Rango',class:'text-center', columna:'nivel',ordenable:true,filtro:true},
		        { leyenda: 'Tipo de personal',class:'text-center', columna:'',ordenable:true,filtro:function(){
		        	return anexGrid_select({
		        	    data: [
								{ valor: '', contenido: 'Todos' },
								{ valor: '1', contenido: 'Sindicalizado' },
								{ valor: '2', contenido: 'No sindicalizado' },
	        	            ]
	        	        });
		        }},
		        { leyenda: 'Tot. Deducciones',class:'text-center', columna:'',ordenable:false,filtro:false},
		        { leyenda: 'Tot. Percepciones',class:'text-center', columna:'',ordenable:false,filtro:false},
		        { leyenda: 'Tot. General',class:'text-center', columna:'',ordenable:false,filtro:false},	        
		    ],
		    modelo: [
		    	{ class:'',formato: function(tr, obj, valor){
		            return anexGrid_dropdown({
	                    contenido: '<i class="glyphicon glyphicon-cog"></i>',
	                    class: 'btn btn-primary opciones',
	                    target: '_blank',
	                    id: 'editar-' + obj.id,
	                    data: acciones = [
		    				{ href: "index.php?menu=edit_pd&sp_id="+obj.id, contenido: '<i class="fa fa-pencil"></i> Editar percepciones/deducciones' },
	                    ]
	                });
		        }}, 
		        {class:'text-center', formato: function(tr, obj, valor){
		            return obj.id;
		        }}, 
		        {class:'text-center', formato: function(tr, obj, valor){
		            return obj.full_name;
		        }}, 
		        
		        {class:'text-center', formato: function(tr, obj, valor){
		            return obj.n_area;
		        }}, 
		        
		        {class:'text-center', formato: function(tr, obj, valor){
		            return obj.n_nivel;
		        }}, 
		        {class:'text-center', formato: function(tr, obj, valor){
		        	var t_sindicato = "";
		        	if (obj.t_sindicato == null) {
		        		t_sindicato = "SIN DEFINIR";
		        	}else{
		        		t_sindicato = obj.t_sindicato;
		        	}
		            return t_sindicato;
		        }}, 
		        {class:'text-center', formato: function(tr, obj, valor){
		            return obj.t_ded;
		        }}, 
		        {class:'text-center', formato: function(tr, obj, valor){
		            return obj.t_per;
		        }},
		        {class:'text-center', formato: function(tr, obj, valor){
		            return obj.t_general;
		        }}, 
		    ],
		    url: 'controller/puente.php?option=7',
		    columna: 'id',
		    columna_orden: 'DESC',
		    ordenable: true,
		    type:'POST',
		    parametros:[{'year':y},{'quincena':q}],
		    paginable:true,
		    limite:[25,50,100,200,500],
		    filtrable:true
		    
		};
		var tabla = $("#tbl_qp").anexGrid(datos);
	});
}
function apply_datatables(tabla, name_tbl) {
	if ( ! $.fn.DataTable.isDataTable( '#'+name_tbl ) ) {
		
		tabla.DataTable({
			dom: "<'row'<'col-md-5'l><'col-sm-2 'B><'col-sm-5 pull-right'f>>"+ 'rtip',
	        buttons: [ 
	        	{ 
	        		extend: 'excel', 
	        		className: 'btn btn-success btn-flat' ,
	        		text: '<i class="fa fa-file-excel-o"></i> Excel',
	        		titleAttr: 'Exportar a excel'
	        	},{ 
	        		extend: 'csv', 
	        		className: 'btn btn-success btn-flat' ,
	        		text: '<i class="fa fa-file-excel-o"></i> CSV',
	        		titleAttr: 'Exportar a un archivo CSV'
	        	}
	        ],
	        "language": {
	        	"url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
	      	},
	      	"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "TODOS"]]
		});
	}
	
	return false;
	// body...
}
function frm_reporte_timbre() {
	$('#t_reporte').change(function(e) {
		e.preventDefault();
		if ( $(this).val() == '1' ) {
			$('#div_sat_per').removeClass('hidden');
			$('#div_sat_ded').addClass('hidden');
			$('#div_sat_otros').addClass('hidden');
		}
		if ( $(this).val() == '2' ) {
			$('#div_sat_ded').removeClass('hidden');
			$('#div_sat_per').addClass('hidden');
			$('#div_sat_otros').addClass('hidden');
		}
		if ( $(this).val() == '3' ) {
			$('#div_sat_ded').addClass('hidden');
			$('#div_sat_per').addClass('hidden');
			$('#div_sat_otros').addClass('hidden');
		}
		
		if ($(this).val() == '4' ) {
			$('#div_xml').removeClass('hidden');
			$('#div_sat_otros').removeClass('hidden');
			$('#div_sat_ded').addClass('hidden');
			$('#div_sat_per').addClass('hidden');
		}else{
			$('#div_xml').addClass('hidden');
		}
	});
	//apply_datatables($('#tbl_sat'));
	$('#frm_reporte_timbre').submit(function(e) {
		e.preventDefault();
		$('#tbl_sat>tbody').html("");
		if ( $('#t_reporte').val() == '1' ) {
			var dataForm = $(this).serialize();
			$.ajax({
				url: 'controller/puente.php',
				type: 'POST',
				dataType: 'json',
				data: dataForm,
				cache:false,
				async:false,
			})
			.done(function(response) {

				$.each(response.data, function(i, val) {
					var fila = "";
					var importe = val.importe+'0000';
					fila += '<tr class="bg-gray text-center">';
						fila += '<td>'+val.clave_sp+'</td>';
						fila += '<td>'+val.cve_ext+':'+val.pd_name+'</td>';
						fila += '<td>'+val.cve_ext+'</td>';
						fila += '<td>'+val.pd_name+'</td>';
						fila += '<td>'+importe+'</td>';
						fila += '<td>'+importe+'</td>';
						fila += '<td>03</td>';
					fila += '</tr>';
					console.log(fila);
					$('#tbl_sat').append(fila);
				});
				apply_datatables($('#tbl_sat'),'tbl_sat');
			})
			.fail(function(jqXHR,textStatus,errorThrown) {
				console.log("error");
			});
		}else if( $('#t_reporte').val() == '2' ){
			var dataForm = $(this).serialize();
			$.ajax({
				url: 'controller/puente.php',
				type: 'POST',
				dataType: 'json',
				data: dataForm,
				cache:false,
				async:false,
			})
			.done(function(response) {
				$('#tbl_sat_ded tbody').html('');
				$.each(response.data, function(i, val) {
					var fila = "";
					var importe = val.importe+'0000';
					fila += '<tr class="bg-gray text-center">';
						fila += '<td>'+val.clave_sp+'</td>';
						fila += '<td>'+val.cve_sat+':'+val.name_sat+'</td>';
						fila += '<td>'+val.cve_ext+'</td>';
						fila += '<td>'+val.name_sat+'</td>';
						fila += '<td>'+importe+'</td>';
						//fila += '<td>'+importe+'</td>';
						//fila += '<td>03</td>';
					fila += '</tr>';
					console.log(fila);
					
					$('#tbl_sat_ded').append(fila);
				});
				apply_datatables($('#tbl_sat_ded'),'tbl_sat_ded');
			})
			.fail(function(jqXHR,textStatus,errorThrown) {
				console.log("error");
			});
		}else{
			var dataForm = new FormData(document.getElementById('frm_reporte_timbre'));
			$.ajax({
				url: 'controller/puente.php',
				type: 'POST',
				dataType: 'json',
				data: dataForm,
				cache:false,
				async:false,
				contentType: false,
	    		processData: false
			})
			.done(function(response) {
				console.log(response);
				if( response.status == 'error' ){
					alerta('a_timbre','error',response.message,'');
				}else{
					$.each(response.data, function(i, val) {
						var fila = "",sindicato = "";
						var importe = val.importe+'0000';
						console.log(val.t_sindicato);
						if ( val.t_sindicato == 'SINDICALIZADO'  ) { sindicato = 'SI'; }
						if ( val.t_sindicato == 'NO SINDICALIZADO'  ) { sindicato = 'NO'; }
						fila += '<tr class="bg-gray text-center">';
							fila += '<td>'+val.clave+'</td>';
							fila += '<td>'+val.nombre+' '+val.ap_pat+' '+val.ap_mat+'</td>';
							fila += '<td>'+val.rfc+'</td>';
							fila += '<td>'+val.curp+'</td>';
							fila += '<td>rh.timbradouai@gmail.com</td>';
							fila += '<td>02 : Sueldos</td>';
							fila += '<td>04 : Quincenal</td>';
							fila += '<td>'+val.issemym+'</td>';
							fila += '<td>'+val.importe+'</td>';
							fila += '<td>'+(val.importe/15.2).toFixed(2)+'</td>';
							fila += '<td>'+val.name_area+'</td>';
							fila += '<td>'+val.puesto+'</td>';
							fila += '<td>'+val.f_ingreso_gem+'</td>';
							fila += '<td>01 : Contrato de trabajo por tiempo indeterminado</td>';
							fila += '<td>MEX : Estado de México</td>';
							fila += '<td>1 : Clase I</td>';
							fila += '<td>'+sindicato+'</td>';
							fila += '<td>01 : Diurna</td>';
							fila += '<td>'+val.uuid+'</td>';
						fila += '</tr>';
						
						$('#tbl_sat_empleados tbody').html('');
						$('#tbl_sat_empleados').append(fila);
					});
					apply_datatables($('#tbl_sat_empleados'),'tbl_sat_empleados');
				}
				
			})
			.fail(function(jqXHR,textStatus,errorThrown) {
				console.log("error: "+jqXHR.responseText);
			});
		}
		
		
	});
}
function frm_dispersion() {
	var tbl =  $('#tbl_dispersion');
	$('#frm_dispersion').submit(function(e) {
		e.preventDefault();
		var dataForm = $(this).serialize();
		$.ajax({
			url: 'controller/puente.php',
			type: 'POST',
			dataType: 'json',
			data: dataForm,
			async:false,
			cache: false,
		})
		.done(function(response) {
			$.each(response.data, function(i, val) {
				var fila = "";
				fila += "<tr>";
					fila += "<td>Cuenta CLABE</td>";	
					fila += "<td>"+val.clave+"</td>";	
					fila += "<td>"+val.importe+"</td>";	
					fila += "<td>"+val.full_name+"</td>";	
				fila += "</tr>";
				tbl.append(fila);
			});
			apply_datatables($('#tbl_dispersion'),'tbl_dispersion');
		})
		.fail(function(jqXHR,textStatus,errorThrown) {
			console.log("Error: "+jqXHR.responseText);
		});
	});
}
function frm_osfem() {
	var tbl =  $('#tbl_osfem');
	$('#frm_osfem').submit(function(e) {
		e.preventDefault();
		var dataForm = $(this).serialize();
		$('.percepciones, .deducciones, .neto').remove();
		$('#tbl_osfem tbody').html('');
		//Buscar  las  columnas
		$.ajax({
			url: 'controller/puente.php',
			type: 'POST',
			dataType: 'json',
			data: dataForm,
			async:false,
			cache: false,
		})
		.done(function(response) {
			//apply_datatables($('#tbl_osfem'),'tbl_osfem');
			//Dibujar las columnas de percepciones
			var c = 1;
			for(i = 0; i < response.data.percepciones_sp.length ; i++){
				$('#tbl_osfem thead tr').append('<th class="percepciones">Percepción '+(c)+'</th>');
				c++;
			}
			$('#tbl_osfem thead tr').append('<th class="percepciones">Total Bruto</th>');
			var c = 1;
			for(i = 0; i < response.data.deducciones_sp.length ; i++){
				$('#tbl_osfem thead tr').append('<th class="deducciones">Deducción '+(c)+'</th>');
				c++;
			}
			$('#tbl_osfem thead tr').append('<th class="deducciones">Deducciones</th>');
			$('#tbl_osfem thead tr').append('<th class="neto">Total neto</th>');
			var conta = 1;
			$.each(response.data.info_sp, function(i, val) {
				var fila = "", bruto = 0, deducciones = 0, neto = 0;
				fila += "<tr id='fila_"+i+"'>";
					fila += "<td id='con_"+i+"'>"+conta+"</td>";
					fila += "<td id='cat_"+i+"'>"+val.categoria+"</td>";
					fila += "<td id='niv_"+i+"'>"+val.nivel+"</td>";
					fila += "<td id='issemym_"+i+"'>"+val.issemym+"</td>";
					fila += "<td id='curp_"+i+"'>"+val.curp+"</td>";
					fila += "<td id='ap_"+i+"'>"+val.ap_pat+"</td>";
					fila += "<td id='am_"+i+"'>"+val.ap_mat+"</td>";
					fila += "<td id='name_"+i+"'>"+val.nombre+"</td>";
					fila += "<td id='rfc_"+i+"'>"+val.rfc+"</td>";
					$.each(response.data.percepciones_sp, function(ii, vall) {
						if ( val.percepciones_sp != null ) {
							var per_sp = val.percepciones_sp;
							for (var i = 0; i < per_sp.length; i++) {
								if (per_sp[i].cve_ext == vall.cve_ext) {
									bruto = bruto + parseFloat(val.percepciones_sp[i].importe);
									fila += "<td id='per"+vall.cve_ext+"'>"+val.percepciones_sp[i].importe+"</td>";
								}
							}
						}else{
							fila += "<td>0</td>";
						}
					});
					fila += "<td id='bruto_"+i+"'>"+bruto+"</td>";
					
					$.each(response.data.deducciones_sp, function(a, valor) {
						if ( val.deducciones_sp != null ) {
							var ded_sp = val.deducciones_sp;
							for (var i = 0; i < ded_sp.length; i++) {
								if (ded_sp[i].cve_ext == valor.cve_ext) {
									deducciones = deducciones + parseFloat(val.deducciones_sp[i].importe);
									fila += "<td id='per"+valor.cve_ext+"'>"+val.deducciones_sp[i].importe+"</td>";
								}
							}
						}else{
							fila += "<td>0</td>";
						}
					});
					fila += "<td id='deducciones_"+i+"'>"+deducciones+"</td>";
					neto = bruto - deducciones;
					neto = neto.toFixed(2);
					fila += "<td id='neto_"+i+"'>"+neto+"</td>";
				fila += "</tr>";
				tbl.append(fila);
				conta ++;
			});
			apply_datatables($('#tbl_osfem'),'tbl_osfem');
		})
		.fail(function(jqXHR,textStatus,errorThrown) {
			console.log("Error: "+jqXHR.responseText);
		});
	});
}
function load_cat_sat(catalogo) {
	$.ajax({
		url: 'controller/puente.php',
		type: 'POST',
		dataType: 'json',
		data: {option: '20', c:catalogo},
		cache: false,
		async: false,
	})
	.done(function(response) {
		$("#c_sat").html("");
		$("#c_sat").append('<option value="">...</option>');
		$.each(response.data, function(i, val) {
			$("#c_sat").append('<option value="'+val.id+'">'+val.nombre+'</option>');
		});
	})
	.fail(function(jqXHR,textStatus,errorThrown) {
		console.log("Error:"+jqXHR.responseText);
	});
	
	return false;
}