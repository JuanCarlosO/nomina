<?php
require_once (getcwd().'/model/UAAModel.php');
?>
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">DATOS DEL FORMATO ÚNICO DE MOVIMIENTOS DE PERSONAL.</h3>
                </div>
                <div class="box-body">
                    <div id="alerta_vista_fump"></div>
                    <div class="row">
                    	<div class="col-md-12">
                    		<fieldset>
                    			<legend> <CENTER>DATOS DE LA ADSCRIPCIÓN</CENTER> </legend>
                    			<div class="row">
                    				<div class="col-md-6">
                    					<table class="table table-bordered">
                    						<tr>
                    							<td class="bg-gray">DEPENDENCIA</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">ORGANISMO/SUBSECRETARIA</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">DIRECCIÓN</td>
                    							<td></td>
                    						</tr>
                    					</table>
                    				</div>
                    				<div class="col-md-6">
                    					<table class="table table-bordered">
                    						<tr>
                    							<td class="bg-gray">DIRECCIÓN DE ÁREA</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">SUBDIRECCIÓN</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">DEPARTAMENTO</td>
                    							<td></td>
                    						</tr>
                    					</table>
                    				</div>
                    			</div>
                    		</fieldset>
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="col-md-12">
                    		<fieldset>
                    			<legend> <CENTER>DATOS GENERALES</CENTER> </legend>
                    			<div class="row">
                    				<div class="col-md-6">
                    					<table class="table table-bordered">
                    						<tr>
                    							<td class="bg-gray">NOMBRE</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">DOMICILIO</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">MUNICIPIO</td>
                    							<td></td>
                    						</tr>
                    					</table>
                    				</div>
                    				<div class="col-md-6">
                    					<table class="table table-bordered">
                    						<tr>
                    							<td class="bg-gray">ENTIDAD DE NACIMIENTO</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">RFC</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">COLONIA</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">CP</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">FECHA DE NACIEMIENTO</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">ESCOLARIDAD</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">ESTADO CIVIL</td>
                    							<td></td>
                    						</tr>
                    						
                    					</table>
                    				</div>
                    			</div>
                    		</fieldset>
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="col-md-12">
                    		<fieldset>
                    			<legend> <CENTER>DATOS DEL TRÁMITE</CENTER> </legend>
                    			<div class="row">
                    				<div class="col-md-1">
                    					<div class="form-group">
                    						<label>
                    							<input type="checkbox" class="minimal" checked> ALTA
    						                </label>
                    					</div>
                    				</div>
                    				<div class="col-md-1">
                    					<div class="form-group">
                    						<label>
                    							<input type="checkbox" class="minimal" checked> BAJA
    						                </label>
                    					</div>
                    				</div>
                    				<div class="col-md-2">
                    					<div class="form-group">
                    						<label>
                    							<input type="checkbox" class="minimal" checked> ALTA/BAJA
    						                </label>
                    					</div>
                    				</div>
                    				<div class="col-md-2 ">
                    					<div class="form-group">
                    						<label>
                    							<input type="checkbox" class="minimal" checked> CAMBIO
    						                </label>
                    					</div>
                    				</div>
                    				<div class="col-md-3">
                    					<div class="form-group">
                    						<label>
                    							<input type="checkbox" class="minimal" checked> CAMBIO DE PERCEPCIONES
    						                </label>
                    					</div>
                    				</div>
                    			</div>
                    			<div class="row">
                    				<div class="col-md-4">
                    					<div class="form-group">
                    						<label>
                    							<input type="checkbox" class="minimal" checked> PERCEPCIONES Y DEDUCCIONES VARIABLE
    						                </label>
                    					</div>
                    				</div>
                    				<div class="col-md-2">
                    					<div class="form-group">
                    						<label>
                    							<input type="checkbox" class="minimal" checked> LICENCIA
    						                </label>
                    					</div>
                    				</div>
                    				<div class="col-md-3">
                    					<div class="form-group">
                    						<label>
                    							<input type="checkbox" class="minimal" checked> PENSIÓN ALIMENTICIA
    						                </label>
                    					</div>
                    				</div>
                    				<div class="col-md-3">
                    					<div class="form-group">
                    						<label>
                    							<input type="checkbox" class="minimal" checked> CAMBIO DE DATOS
    						                </label>
                    					</div>
                    				</div>
                    			</div>
                    		</fieldset>
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="col-md-12">
                    		<fieldset>
                    			<legend> <CENTER>DATOS DE LA PLAZA</CENTER> </legend>
                    			<div class="row">
                    				<div class="col-md-6">
                    					<table class="table table-bordered">
                    						<tr>
                    							<td class="bg-gray">NÚMERO DE LA PLAZA</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">TIPO DE PLAZA</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">CÓDIGO DEL PUESTO ANTERIOR</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray"> CÓDIGO DEL PUESTO ACTUAL</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">VIGENCIA</td>
                    							<td></td>
                    						</tr>
                    					</table>
                    				</div>
                    				<div class="col-md-6">
                    					<table class="table table-bordered">
                    						<tr>
                    							<td class="bg-gray">PUESTO FUNCIONAL ANTERIOR</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">PUESTO FUNCIONAL ACTUAL</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">CLAVE DE CENTRO DE TRABAJO</td>
                    							<td></td>
                    						</tr>
                    						
                    					</table>
                    				</div>
                    			</div>
                    		</fieldset>
                    	</div>
                    </div>                    
                    <div class="row">
                    	<div class="col-md-12">
                    		<fieldset>
                    			<legend> <CENTER>PERCEPCIONES</CENTER> </legend>
                    			<div class="row">
                    				<div class="col-md-12">
                    					<table class="table table-bordered">
                    						<thead>
                    							<tr class="bg-gray">
                    								<th class="text-center">CONCEPTO</th>
                    								<th class="text-center">CLAVE</th>
                    								<th class="text-center">IMPORTE</th>
                    							</tr>
                    						</thead>
                    					</table>
                    				</div>
                    			</div>
                    		</fieldset>
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="col-md-12">
                    		<fieldset>
                    			<legend> <CENTER>DEDUCCIONES</CENTER> </legend>
                    			<div class="row">
                    				<div class="col-md-12">
                    					<table class="table table-bordered">
                    						<thead>
                    							<tr class="bg-gray">
                    								<th class="text-center">CONCEPTO</th>
                    								<th class="text-center">CLAVE</th>
                    								<th class="text-center">IMPORTE</th>
                    							</tr>
                    						</thead>
                    					</table>
                    				</div>
                    			</div>
                    		</fieldset>
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="col-md-12">
                    		<fieldset>
                    			<legend> <CENTER>RADICACIÓN DEL PAGO</CENTER> </legend>
                    			<div class="row">
                    				<div class="col-md-3"></div>
                    				<div class="col-md-6">
                    					<table class="table table-bordered">
                    						<tr>
                    							<td class="bg-gray">MPIO. A.</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">MPIO. P.</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">L.P.</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">C.C.T.</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">S.P.</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">B.</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">T.P.</td>
                    							<td></td>
                    						</tr>
                    						
                    					</table>
                    				</div>
                    				<div class="col-md-3"></div>
                    			</div>
                    		</fieldset>
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="col-md-12">
                    		<fieldset>
                    			<legend> <CENTER>DATOS LABORALES DEL SERVIDOR PÚBLICO</CENTER> </legend>
                    			<div class="row">
                    				<div class="col-md-6">
                    					<table class="table table-bordered">
                    						<tr>
                    							<td class="bg-gray">FECHA DE INGRESO AL GEM.</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">ANTIGÜEDAD EFECTIVA</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">HORARIO</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">TIPO DE RELACIÓN LABORAL</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">TIPO DE SINDICATO</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">VIGENCIA</td>
                    							<td></td>
                    						</tr>
                    					</table>
                    				</div>
                    				<div class="col-md-6">
                    					<table class="table table-bordered">
                    						<tr>
                    							<td class="bg-gray">FECHA DE ÚLTIMO EGRESO  DEL GEM.</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">FECHA DE LA ÚLTIMA PROMOCIÓN</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">CLAVE DEL SERVIDOR PÚBLICO</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">TIPO DE APORTACIÓN</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">TIPO DE IMPUESTO</td>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<td class="bg-gray">C.U.R.P.</td>
                    							<td></td>
                    						</tr>
                    						                    						
                    					</table>
                    				</div>
                    			</div>
                    		</fieldset>
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="col-md-12">
                    		<fieldset>
                    			<legend> <CENTER>DATOS DEL CAMBIO </CENTER> </legend>
                    			<div class="row">
                    				<div class="col-md-4">
                    					<div class="form-group">
                    						<label>TIPO DEL CAMBIO</label>
                    						<input type="text" class="form-control" value="" >
                    					</div>
                    				</div>
                    				<div class="col-md-4">
                    					<div class="form-group">
                    						<label> VIGENCIA DEL: </label>
                    						<input type="date" class="form-control" value="" >
                    					</div>
                    				</div>
                    				<div class="col-md-4">
                    					<div class="form-group">
                    						<label>AL: </label>
                    						<input type="date" class="form-control" value="" >
                    					</div>
                    				</div>
                    			</div>
                    		</fieldset>
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="col-md-12">
                    		<fieldset>
                    			<legend> <CENTER>DATOS DE LA BAJA</CENTER> </legend>
                    			<div class="row">
                    				<div class="col-md-6">
                    					<div class="form-group">
                    						<label>FECHA DE LA BAJA:</label>
                    						<input type="date" name="" value=""  class="form-control">
                    					</div>
                    				</div>
                    				<div class="col-md-6">
                    					<div class="form-group">
                    						<label>MOTIVO:</label>
                    						<input type="text" name="" value="UNA DE MUCHAS" class="form-control">
                    					</div>
                    				</div>
                    			</div>
                    		</fieldset>
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="col-md-12">
                    		<fieldset>
                    			<legend> <CENTER>FINIQUITO</CENTER> </legend>
                    			<div class="row">
                    				<div class="col-md-6">
                    					<table class="table table-bordered">
                    						<thead>
                    							<tr class="bg-gray">
                    								<th>CONCEPTO A</th>
                    								<th>CLAVE</th>
                    								<th>IMPORTE</th>
                    							</tr>
                    						</thead>
                    						<tbody>
                    							<tr>
                    								<td>SUELDO</td>
                    								<td></td>
                    								<td></td>
                    							</tr>
                    							<tr>
                    								<td>PRIMA POR PREM. EN EL SERVICIO</td>
                    								<td></td>
                    								<td></td>
                    							</tr>
                    							<tr>
                    								<td>PRIMA VACACIONAL</td>
                    								<td></td>
                    								<td></td>
                    							</tr>
                    							<tr>
                    								<td>AGUINALDO PROPORCIONAL</td>
                    								<td></td>
                    								<td></td>
                    							</tr>
                    							<tr>
                    								<td>OTRO</td>
                    								<td></td>
                    								<td></td>
                    							</tr>
                    							<tr>
                    								<td>SUMA A</td>
                    								<td></td>
                    								<td></td>
                    							</tr>
                    						</tbody>
                    					</table>
                    				</div>
                    				<div class="col-md-6">
                    					<table class="table table-bordered">
                    						<thead>
                    							<tr class="bg-gray">
                    								<th>CONCEPTO A</th>
                    								<th>CLAVE</th>
                    								<th>IMPORTE</th>
                    							</tr>
                    						</thead>
                    						<tbody>
                    							<tr>
                    								<td>PAGO IMPORCEDENTE</td>
                    								<td></td>
                    								<td></td>
                    							</tr>
                    							<tr>
                    								<td>PRÉSTAMO DIRECTO</td>
                    								<td></td>
                    								<td></td>
                    							</tr>
                    							<tr>
                    								<td>OTROS</td>
                    								<td></td>
                    								<td></td>
                    							</tr>
                    							<tr>
                    								<td></td>
                    								<td></td>
                    								<td></td>
                    							</tr>
                    							<tr>
                    								<td></td>
                    								<td></td>
                    								<td></td>
                    							</tr>
                    							<tr>
                    								<td>SUMA B</td>
                    								<td></td>
                    								<td></td>
                    							</tr>
                    							<tr>
                    								<td>TOTAL NETO </td>
                    								<td></td>
                    								<td></td>
                    							</tr>
                    						</tbody>
                    					</table>
                    				</div>
                    				
                    			</div>
                    		</fieldset>
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="col-md-12">
                    		<fieldset>
                    			<legend> <CENTER>LICENCIA</CENTER> </legend>
                    			<div class="row">
                    				<div class="col-md-3">
                    					<div class="form-group">
                    						<label>GOCE DE SUELDO</label>
                    						<input type="text" name="" value="" class="form-control">
                    					</div>
                    				</div>
                    				<div class="col-md-3">
                    					<div class="form-group">
                    						<label>ESTADO</label>
                    						<input type="text" name="" value="" class="form-control">
                    					</div>
                    				</div>
                    				<div class="col-md-3">
                    					<div class="form-group">
                    						<label>VIGENCIA DEL </label>
                    						<input type="date" name="" value="" class="form-control">
                    					</div>
                    				</div>
                    				<div class="col-md-3">
                    					<div class="form-group">
                    						<label>AL</label>
                    						<input type="date" name="" value="" class="form-control">
                    					</div>
                    				</div>
                    				
                    			</div>
                    		</fieldset>
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="col-md-12">
                    		<fieldset>
                    			<legend> <CENTER>PENSIÓN ALIMENTICIA</CENTER> </legend>
                    			<div class="row">
                    				<div class="col-md-6">
                    					<table class="table table-bordered">
                    						<tr>
                    							<th class="bg-gray">TIPO DE MOVIEMIENTO</th>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<th class="bg-gray">BENEFICIARIO (NOMBRE)</th>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<th class="bg-gray">IMPORTE DEL DESCUENTO</th>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<th class="bg-gray">QUINCENA</th>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<th class="bg-gray">RFC</th>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<th class="bg-gray">% DEL DESCUENTO</th>
                    							<td></td>
                    						</tr>
                    						<tr>
                    							<th class="bg-gray">AÑO</th>
                    							<td></td>
                    						</tr>
                    					</table>
                    				</div>
                    			</div>
                    		</fieldset>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>