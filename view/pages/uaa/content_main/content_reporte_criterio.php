<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Generador de reportes por concepto de pago</h3>
                </div>
                <div class="box-body">
                    <form action="controller/puente.php" id="frm_generate_reporte" method="post" target="_blank">
                        <input type="hidden" name="option" value="21">
                    	<div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Seleccionar año</label>
                                    <select name="year" id="year" class="form-control" required="">
                                        <option value="">...</option>
                                        <option value="2020">2020</option>
                                    </select>
                                </div>
                            </div>
                    		<div class="col-md-4">
                    			<div class="form-group">
                    				<label>Seleccione la quincena</label>
                    				<select name="c_quincena" id="c_quincena" class="form-control">
                    					<option value="">...</option>
                    				</select>
                    			</div>
                    		</div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Seleccione un tipo de reporte</label>
                                    <select name="t_reporte" id="t_reporte" class="form-control" required="">
                                        <option value="">...</option>
                                        <option value="1">ALFABETICO DE EMPLEADO</option>
                                        <option value="2">LISTADO DE FIRMAS</option>
                                        <option value="3">LISTADO DE PENSION ALIMENTICIA</option>
                                        <option value="4">LISTADO Y RESUMEN DE PERCEPCIONES Y DEDUCCIONES</option>
                                    </select>
                                </div>
                            </div>
                    	</div>
                    	<div class="row">
                    		<div class="col-md-5"></div>
                    		<div class="col-md-2">
                    			<button type="submit" class="btn btn-success btn-flat btn-block">
                    				<i class="fa fa-file-pdf-o"></i> Generar reporte
                    			</button>
                    		</div>
                    		<div class="col-md-5"></div>
                    	</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>