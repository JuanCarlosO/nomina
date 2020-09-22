<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Conceptos quincenales adicionales por servidor público </h3>
                </div>
                <div class="box-body">
                    <div id="alerta_regla"></div>
                    <form action="#" id="frm_add_regla" method="post">
                        <input type="hidden" name="option" value="12">  
                    	<div class="row">
                    		<div class="col-md-6">
                    			<div class="form-group">
                    				<label>Aplicar a</label>
                    				<input type="text" class="form-control" name="name_sp" id="name_sp" placeholder="Ej: Juan Carlos ... ">
                    				<input type="hidden" name="sp_id" id="sp_id">
                    			</div>
                    		</div>
                    		<div class="col-md-2">
                    			<div class="form-group">
                    				<label>Núm. de quincenas</label>
                    				<input type="number" name="num_quin" value="" class="form-control">
                    			</div>
                    		</div>
                    		<div class="col-md-2">
                    			<div class="form-group">
                    				<label>Fecha inicio</label>
                    				<input type="date" name="f_ini" value="" class="form-control">
                    			</div>
                    		</div>
                    		<div class="col-md-2">
                    			<div class="form-group">
                    				<label>Fecha fin</label>
                    				<input type="date" name="f_fin" value="" class="form-control">
                    			</div>
                    		</div>
                    	</div>
                    	<div class="row">
	                    	
	                    	<div class="col-md-2">
	                    		<div class="form-group">
	                    			<label>Percepción o Deducción</label>
	                    			<select name="t_concepto" id="t_concepto" class="form-control">
	                    				<option value="">...</option>
	                    				<option value="1">Percepción</option>
	                    				<option value="2">Deducción</option>
	                    			</select>
	                    		</div>
	                    	</div>
	                    	<div class="col-md-4">
	                    		<div class="form-group">
	                    			<label>Concepto</label>
	                    			<select name="concepto" id="concepto" class="form-control">
	                    				<option value="">...</option>
	                    			</select>
	                    		</div>
	                    	</div>
	                    	<div class="col-md-3">
	                    		<div class="form-group">
	                    			<label>Monto quincenal</label>
	                    			<div class="input-group">
		                                <span class="input-group-addon">
		                                    <i class="fa fa-dollar"></i>
		                                </span>
		                                <input type="text" name="importe" class="form-control" placeholder="500" onkeypress='return event.charCode >= 45 && event.charCode <= 57'>
		                            </div>
	                    		</div>
	                    	</div>
	                    </div>
	                    <div class="row">
	                    	<div class="col-md-5"></div>
	                    	<div class="col-md-2">
	                    		<button type="submit" class="btn btn-block btn-success btn-flat">
	                    			<i class="fa fa-floppy-o"></i> Aplicar regla 
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