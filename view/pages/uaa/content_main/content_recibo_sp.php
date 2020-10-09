<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Generador de recibos de nómina por servidor público</h3>
                </div>
                <div class="box-body">
                    <form action="controller/puente.php" id="frm_generate_recibo" target="_blank"  method="post">
                        <input type="hidden" id="option" name="option" value="17" >
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
                    		<div class="col-md-6">
                    			<div class="form-group">
                    				<label>Servidor público</label>
                    				<input type="text" id="servidor" name="sp" value="" class="form-control">
                    				<input type="hidden" id="servidor_id" name="sp_id" value="">
                    			</div>
                    		</div>
                    	</div>
                    	<div class="row">
                    		<div class="col-md-5"></div>
                    		<div class="col-md-2">
                    			<button type="submit" class="btn btn-success btn-flat btn-block">
                    				<i class="fa fa-file-pdf-o"></i> Generar recibo
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