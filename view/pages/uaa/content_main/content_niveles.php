<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">ALTA DE NIVELES Y RANGOS </h3>
                </div>
                <form action="#" id="frm_add_nivel" method="post">
                	<input type="hidden" name="option" value="4">
	                <div class="box-body">
	                    <div id="nivel_rango"></div>
                    	<div class="row">
                    		<div class="col-md-6">
                    			<div class="form-group">
                    				<label>Nombre del nivel o rango</label>
                    				<input type="text" class="form-control" name="nombre" required>
                    			</div>
                    		</div>
                    		<div class="col-md-3">
                    			<div class="form-group">
                    				<label>Clave de nivel o rango</label>
                    				<input type="text" class="form-control" name="clave" required>
                    			</div>
                    		</div>
                    		<div class="col-md-3">
                    			<div class="form-group">
                    				<label></label>
                    			</div>
                    		</div>
                    	</div>
	                </div>
	                <div class="box-footer">
	                    <button type="reset" class="btn btn-default btn-flat">Limpiar</button>
	                    <button type="submit" class="btn btn-success btn-flat pull-right">
	                    	<i class="fa fa-floppy-o"></i> Guardar información
	                    </button>
	                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">LISTADO DE NIVELES Y RANGOS </h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-primary" title="ACTULIZAR LISTADO DE NIVELES Y RANGOS" onclick="getNivelesRangos();">
                            <i class="fa fa-refresh fa-spin"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="list_nr"></div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>
