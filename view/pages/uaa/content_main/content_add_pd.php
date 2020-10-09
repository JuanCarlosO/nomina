<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Conceptos quincenales adicionales por servidor público </h3>
                </div>
                <div class="box-body">
                    <div id="alerta_pd"></div>
                    <form action="#" id="frm_add_pd" method="post">
                    	<input type="hidden" name="option" value="11">
                    	<div class="row">
                    		<div class="col-md-6">
                    			<div class="form-group">
                    				<label>Nombre de concepto</label>
                    				<input type="text" name="n_concepto" value="" class="form-control" placeholder="Ej: Beca por promedio..." required="">
                    			</div>
                    		</div>
                    		<div class="col-md-2">
                    			<div class="form-group">
                    				<label>Percepción o Deducción</label>
                    				<select id="concepto" name="concepto" class="form-control" required="" onchange="load_cat_sat(this.value)">
                    					<option value="">...</option>
                    					<option value="1">Percepción</option>
                    					<option value="2">Deducción</option>
                    				</select>
                    			</div>
                    		</div>
                    		<div class="col-md-2">
                    			<div class="form-group">
                    				<label>Condición</label>
                    				<select name="condicion" id="condicion" class="form-control" required="">
                    					<option value="">...</option>
                    					<option value="1">Fija</option>
                    					<option value="2">Calculable</option>
                    				</select>
                    			</div>
                    		</div>
                    		<div class="col-md-2 hidden" id="div_funciones">
                    			<div class="form-group">
                    				<label>Funciones</label>
                    				<select name="funciones" id="funciones" class="form-control">
                    					<option value="">...</option>
                    				</select>
                    			</div>
                    		</div>
                    		
                    	</div>
                    	<div class="row">
	                    	
	                    	<div class="col-md-2">
	                    		<div class="form-group">
	                    			<label>Clave interna</label>
	                    			<input type="text" name="cve_int" value="" class="form-control" placeholder="Ej: Beca por promedio..." required="">
	                    		</div>
	                    	</div>
	                    	<div class="col-md-2">
	                    		<div class="form-group">
	                    			<label>Clave externa</label>
	                    			<input type="text" name="cve_ext" value="" class="form-control" placeholder="Ej: Beca por promedio..." required="">
	                    		</div>
	                    	</div>
	                    	<div class="col-md-2">
	                    		<div class="form-group">
	                    			<label>Método del importe</label>
	                    			<select id="metodo" name="metodo" class="form-control" required="">
                    					<option value="">...</option>
                    					<option value="1">Monto</option>
                    					<option value="2">Porcentaje</option>
                    				</select>
	                    		</div>
	                    	</div>
	                    	<div class="col-md-2 hidden" id="monto">
	                    		<div class="form-group">
	                    			<label>Monto quincenal</label>
	                    			<div class="input-group">
		                                <span class="input-group-addon">
		                                    <i class="fa fa-dollar"></i>
		                                </span>
		                                <input type="text" class="form-control" name="monto" placeholder="500" onkeypress='return event.charCode >= 45 && event.charCode <= 57'>
		                            </div>
	                    		</div>
	                    	</div>
	                    	<div class="col-md-2 hidden" id="porcentaje">
	                    		<div class="form-group">
	                    			<label>Procentaje</label>
	                    			<div class="input-group">
		                                <span class="input-group-addon">
		                                    <i class=""> <b>%</b> </i>
		                                </span>
		                                <input type="text" name="percent" class="form-control" placeholder="16" onkeypress='return event.charCode >= 45 && event.charCode <= 57'>
		                            </div>
	                    		</div>
	                    	</div>
	                    </div>
                        <div id="cat_sat" class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Catalógo del SAT.</label>
                                    <select name="c_sat" id="c_sat" class="form-control" required>
                                        <option value="">...</option>
                                    </select>
                                </div>
                            </div>
                        </div>
	                    <div class="row">
	                    	<div class="col-md-4"></div>
	                    	<div class="col-md-4">
	                    		<button type="submit" class="btn btn-block btn-success btn-flat">
	                    			<i class="fa fa-floppy-o"></i> Agregar al catálogo 
	                    		</button>
	                    	</div>
	                    	<div class="col-md-4"></div>
	                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Catálogo de percepciones y deducciones</h3>
                </div>
                <div class="box-body">
                    <div id="listado_pd"></div>
                </div>
            </div>
        </div>
    </div>
</section>