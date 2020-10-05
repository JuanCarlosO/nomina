<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">SECCIÓN DE TIMBRADO</h3>
                </div>
                <div class="box-body">
                    <div id="a_timbre"></div>
                    <form id="frm_reporte_timbre" method="post" action="#">
                    	<input type="hidden" name="option" value="16">
                    	<div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Año</label>
                                    <input type="text" id="year" name="year" value="<?=date('Y')?>" class="form-control" maxlength="4" minlength="4" min="2020" max="<?=date('Y')?>" onkeypress="return event.charCode >= 45 && event.charCode <= 57"  required="" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Quincena</label>
                                    <select class="form-control" id="quincenas" name="quincena" required="">
                                        <option value="">...</option>
                                    </select>
                                </div>
                            </div>
                    		<div class="col-md-3">
                    			<div class="form-group">
                    				<label>Tipo de reporte</label>
                    				<select class="form-control" name="t_reporte" required="">
                    					<option value="">...</option>
                    					<option value="1">Percepciones</option>
                    					<option value="2">Deducciones</option>
                    					<!-- <option value="3">Otros pagos</option>
                    					<option value="4">Empleados</option> -->
                    				</select>
                    			</div>
                    		</div>
                    	</div>
                        <div class="row">
                            <div class="col-md-5"></div>
                            <div class="col-md-2">
                                <button class="btn btn-success btn-flat btn-block">
                                    <i class="fa fa-table"> Generar </i>
                                </button>
                            </div>
                            <div class="col-md-5"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="tbl_timbrado" class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Tabla para timbrado de nómina 
                        <label id="tipo_rep"></label>
                    </h3>
                </div>
                <div class="box-body">
                    <div id="a_timbre"></div>
                    <div class="table-responsive">
                        <table id="tbl_sat" class="table table-striped table-condesed borde-blanco">
                            <thead>
                                <tr class="bg-navy">
                                    <th class="text-center">Número de Empleado</th>
                                    <th class="text-center">Concepto en Catálogo SAT</th>
                                    <th class="text-center">ID Concepto Personalizado </th>
                                    <th class="text-center">Descripción del Concepto</th>
                                    <th class="text-center">Cantidad a Pagar</th>
                                    <th class="text-center">Importe Gravado</th>
                                    <th class="text-center">Método Pago</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="tbl_sat_ded" class="table table-striped table-condesed borde-blanco">
                                    <thead>
                                        <tr class="bg-navy">
                                            <th class="text-center">Número de Empleado</th>
                                            <th class="text-center">Concepto en Catálogo SAT</th>
                                            <th class="text-center">ID Concepto Personalizado </th>
                                            <th class="text-center">Descripción del Concepto</th>
                                            <th class="text-center">Cantidad del descuento</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="tbl_sat_empleados" class="table table-striped table-condesed borde-blanco">
                                    <thead>
                                        <tr class="bg-navy">
                                            <th class="text-center">Número de Empleado</th>
                                            <th class="text-center">Nombre Completo</th>
                                            <th class="text-center">RFC con Homoclave </th>
                                            <th class="text-center">CURP</th>
                                            <th class="text-center">Correo Electrónico</th>
                                            <th class="text-center">Régimen de Pago</th>
                                            <th class="text-center">Periodo de Pago</th>
                                            <th class="text-center">No. de Seguridad Social</th>
                                            <th class="text-center">Salario Base de Cotización</th>
                                            <th class="text-center">Salario Diario Integrado</th>
                                            <th class="text-center">Departamento</th>
                                            <th class="text-center">Puesto</th>
                                            <th class="text-center">Fecha Inicio Real Laboral</th>
                                            <th class="text-center">Tipo Contrato</th>
                                            <th class="text-center">Clave Entidad Federativa</th>
                                            <th class="text-center">Riesgo Puesto</th>
                                            <th class="text-center">Sindicalizado</th>
                                            <th class="text-center">Tipo de Jornada</th>
                                            <th class="text-center">UUID Relacional</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="tbl_sat_ded" class="table table-striped table-condesed borde-blanco">
                                    <thead>
                                        <tr class="bg-navy">
                                            <th class="text-center">Número de Empleado</th>
                                            <th class="text-center">"Concepto en Catálogo SAT"</th>
                                            <th class="text-center">ID Concepto Personalizado</th>
                                            <th class="text-center">Descripción del Concepto</th>
                                            <th class="text-center"> Cantidad a Pagar </th>
                                            <th class="text-center">Método Pago</th>
                                            <th class="text-center">Monto del Subsidio Causado (Anexo8)</th>
                                            <th class="text-center">Año Determinación del Saldo Favor </th>
                                            <th class="text-center">Monto de Remanente de Saldo a Favor</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
