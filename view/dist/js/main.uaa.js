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
		form_smart('frm_add_pd',false,false,'alerta_pd');
	}
	if ( url == '?menu=add_regla' ) {
		$('#option_3').addClass('active');		
		$('#option_3_3 ').addClass('active');	
		autocompletado('name_sp','sp_id');
		change('t_concepto','per_ded','concepto');
		form_smart('frm_add_regla',false,false,'alerta_regla');
	}
	if ( url == '?menu=comprobante_sp' ) {
		$('#option_4').addClass('active');		
		$('#option_4_2').addClass('active');
		load_catalogo('c_quincena','c_quincenas','select','');	
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
		load_catalogo('quincena_pension','c_quincenas','select','');	
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
	        { leyenda: 'Personal',class:'text-center', columna:'cve_sp',ordenable:false,filtro:true},
	        { leyenda: 'Estado',class:'text-center', columna:'p.estado',ordenable:false,filtro:function(){
	        	return anexGrid_select({
	        		data:[
		        		{valor:'',contenido:'TODOS'},
		        		{valor:'1',contenido:'ACTIVOS'},
		        		{valor:'2',contenido:'INACTIVOS'}
	        		]
	        	});
	        }},
	        
	    ],
	    modelo: [
	    	{ class:'',formato: function(tr, obj, valor){
	            return anexGrid_dropdown({
                    contenido: '<i class="glyphicon glyphicon-cog"></i>',
                    class: 'btn btn-primary opciones',
                    target: '__blank',
                    id: 'editar-' + obj.id,
                    data: acciones = [
	    				{ href: "index.php?menu=add_fump&fump_id="+obj.id, contenido: '<i class="fa fa-pencil"></i>Completar F.U.M.P.' },
	    				{ href: "index.php?menu=cedula&persona_id="+obj.id, contenido: '<i class="glyphicon glyphicon-eye-open "></i>Ver F.U.M.P.' },
	    				{ href: "index.php?menu=edit_fump&person="+obj.id, contenido: '<i class="glyphicon glyphicon-cloud"></i> Editar F.U.M.P.' },
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
	        	var lista = "";
	        	lista+="<ul>";
	        		lista +="<li><b>DEPENDENCIA:</b>"+obj.id+"</li>";
	        		lista +="<li><b>DIRECCIÓN:</b>"+obj.id+"</li>";
	        		lista +="<li><b>SUBDIRECCIÓN:</b>"+obj.id+"</li>";
	        		lista +="<li><b>DEPARTAMENTO:</b>"+obj.id+"</li>";
	        	lista+="</ul>";
	            return lista;
	        }}, 
	        {class:'text-center', formato: function(tr, obj, valor){
	            return obj.nivel_rango;
	        }}, 
	        {class:'text-left', formato: function(tr, obj, valor){
            	var lista = "";
            	lista+="<ul>";
            		lista +="<li><b>C.U.R.P.:</b>"+obj.id+"</li>";
            		lista +="<li><b>R.F.C.:</b>"+obj.rfc+"</li>";
            	lista+="</ul>";
                return lista;
	        }}, 
	        {class:'text-center', formato: function(tr, obj, valor){
	            return obj.id;
	        }}, 
	        {class:'text-center', formato: function(tr, obj, valor){
	            return obj.id;
	        }}, 
	        {class:'text-center', formato: function(tr, obj, valor){
	            return obj.id;
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
	        { leyenda: 'ID', class:'text-center',ordenable:true,columna:'id'},
	        { leyenda: 'Nombre_completo',class:'text-center', columna:'full_name',ordenable:false,filtro:false},
	        { leyenda: 'Fecha de asistencia',class:'text-center', columna:'',ordenable:false,filtro:false},
	        { leyenda: 'Registro de asistencia',class:'text-center', columna:'name_area',ordenable:false,filtro:false},
	    ],
	    modelo: [
	    	{ class:'',formato: function(tr, obj, valor){
	            return anexGrid_dropdown({
                    contenido: '<i class="glyphicon glyphicon-cog"></i>',
                    class: 'btn btn-primary opciones',
                    target: '__blank',
                    id: 'editar-' + obj.id,
                    data: acciones = [
	    				//{ href: "index.php?menu=add_fump&fump_id="+obj.id, contenido: '<i class="fa fa-pencil"></i>Completar F.U.M.P.' },
	    				//{ href: "javascript:open_modal('modal_add_file',"+obj.id+");", contenido: '<i class="fa fa-edit"></i> Adjuntar documento' },
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
	            return obj.f_asistencia;
	        }}, 
	        {class:'text-center', formato: function(tr, obj, valor){
	        	var sph_salida;var estado; 

	        	if ( obj.h_salida === null ) {
	        		sph_salida = "NO SE REGISTRÓ HORA DE SALIDA.";
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
				if (/*he.isBefore(hora_e) */he.isBetween('6:00:00',hora_e) ) {
					estado = 'OK';
					tr.addClass('bg-green');
				}else{
					if( he.isSameOrBefore(he_tolerancia) && he.isAfter(hora_e)){
						estado = 'NO HAY RETARDO, NO HAY PREMIO.';
						tr.addClass('bg-navy');
					}else if ( he.isBetween(he_retardo,he_retardo_l) ){
						estado = 'TIENE RETARDO';
						tr.addClass('bg-yellow');
					}else if (he.isAfter(he_falta)) {
						tr.addClass('bg-red');
						estado = 'TIENE FALTA';
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
	    filtrable:false,
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
	//genera evento onchange
	var evento = "change('"+name_id+"','per_ded','"+name_destino+"');";
	
	var criterio = "";
	criterio += '<div class="row criterio '+divs+'">';
		criterio += '<div class="col-md-2">';
			criterio += '<div class="form-group">';
				criterio += '<label>Percepción o deducción</label>';
				criterio += '<select name="t_per_ded" id="'+name_id+'" class="form-control" onchange="'+evento+'">';
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
					    criterio += '<input type="text" class="form-control" name="monto[]"  placeholder="500" onkeypress="return event.charCode >= 45 && event.charCode <= 57">';
		    			criterio += '<span class="input-group-btn">';
		    				criterio += '<i class="fa fa-dollar"></i>';
		                	criterio += '<button type="button" class="btn btn-danger btn-flat" onclick="remove_criterio('+divs+')"> <i class="fa fa-minus"></i> </button>';
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
	            return obj.cve_exp;
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
		$.each(response.percepciones, function(i, val) {
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
				            fila +='<option value="'+val.id_pd+'">'+val.nombre+'</option>';
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
				            fila +='<input type="text" name="per_monto[]" value="'+val.monto+'" class="form-control" placeholder="500" onkeypress="return event.charCode >= 45 && event.charCode <= 57">';
				        fila +='</div>';
				    fila +='</div>';
				fila +='</div>';
			fila += "</div>";
			$('#per_predeterminadas').append(fila);
			fila = "";
			$.each(response.deducciones, function(i, val) {
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
					            fila +='<option value="'+val.id_pd+'">'+val.nombre+'</option>';
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
					            fila +='<input type="text" name="ded_monto[]" value="'+val.monto+'" class="form-control" placeholder="500" onkeypress="return event.charCode >= 45 && event.charCode <= 57">';
					        fila +='</div>';
					    fila +='</div>';
					fila +='</div>';
				fila += "</div>";
				$('#ded_predeterminadas').append(fila);
			});
			//Sueldo base.
		});
	})
	.fail(function(jqXHR,textStatus,errorThrown) {
		console.log("error");
	});
	
	return false;
}
//agregar una percepcion
function add_percepcion(contenedor) {
	var fila = "";
	fila += '<div class="row">';
	    fila += '<div class="col-md-3">';
	        fila += '<div class="form-group">';
	            fila += '<label>Concepto</label>';
	            fila += '<select name="percepiones[]" id="percepciones" class="form-control" >';
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
	                fila += '<input type="text" class="form-control" placeholder="">';
	            fila += '</div>';
	        fila += '</div>';
	    fila += '</div>';
	fila += '</div>';
	$('#'+content).append(fila);
	return false;
}