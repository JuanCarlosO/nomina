<section class="content container-fluid">
	<div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Alta de parametros para el tablero</h3>
                </div>
                <div class="box-body">
                    <div id="alerta_tablero"></div>
                    <form action="#" id="frm_add_tabulador" method="post">
                    	<input type="hidden" id="option" name="option" value="24">
                    	<div class="row">
                    		<div class="col-md-4">
                    			<div class="form-group">
                    				<label>Limite inferior 1</label>
                    				<input type="text" required="" id="" name="lim_inf1" value="" class="form-control" onkeypress="return event.charCode >= 45 && event.charCode <= 57">
                    			</div>
                    		</div>
                    		<div class="col-md-4">
                    			<div class="form-group">
                    				<label>Limite inferior 2</label>
                    				<input type="text" required="" id="" name="lim_inf2" value="" class="form-control" onkeypress="return event.charCode >= 45 && event.charCode <= 57">
                    			</div>
                    		</div>
                    		<div class="col-md-4">
                    			<div class="form-group">
                    				<label>Limite superior</label>
                    				<input type="text" required="" id="" name="lim_supe" value="" class="form-control" onkeypress="return event.charCode >= 45 && event.charCode <= 57">
                    			</div>
                    		</div>
                    	</div>
                    	<div class="row">
                    		<div class="col-md-4">
                    			<div class="form-group">
                    				<label>Cuota fija</label>
                    				<input type="text" required="" id="" name="cuota_fija" value="" class="form-control" onkeypress="return event.charCode >= 45 && event.charCode <= 57">
                    			</div>
                    		</div>
                    		<div class="col-md-4">
                    			<div class="form-group">
                    				<label>Porcentaje para el excedente</label>
                    				<input type="text" required="" id="" name="porcentaje" value="" class="form-control" onkeypress="return event.charCode >= 45 && event.charCode <= 57">
                    			</div>
                    		</div>
                    		<div class="col-md-4">
                    			<div class="form-group">
                    				<label>Subsidio del empleo</label>
                    				<input type="text" required="" id="" name="subsidio" value="" class="form-control" onkeypress="return event.charCode >= 45 && event.charCode <= 57">
                    			</div>
                    		</div>
                    	</div>
                    	<div class="row">
                    		<div class="col-md-5"></div>
                    		<div class="col-md-2">
                    			<button type="submit" class="btn btn-success btn-flat btn-block">
                    				<i class="fa fa-floppy-o"></i> Guardar
                    			</button>
                    		</div>
                    		<div class="col-md-5"></div>
                    	</div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Tarifa de ISR</h3>
                </div>
                <div class="box-body">
                    <div id="h_asistencia"></div>

                    <div class="row">
                    	<div class="col-md-12">
                    		<div id="tbl_tabulador"></div>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>