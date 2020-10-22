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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo de rango</label>
                                    <select id="t_rango" name="t_rango" id="" class="form-control">
                                        <option value="">...</option>
                                        <option value="7">Mando superior</option>
                                        <option value="1">Mandos medios de estructura</option>
                                        <option value="2">Personal de enlace y apoyo técnico</option>
                                        <option value="3">Rango 1</option>
                                        <option value="4">Rango 2</option>
                                        <option value="5">Rango 3</option>
                                        <option value="6">Rango 4</option>
                                    </select>
                                </div>
                            </div>
                        </div>
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
                       <div class="row">
                            <div class="col-md-2">
                                <div id="sb" class="hidden">
                                    <label>Sueldo base</label>
                                    <input type="text" id="su_ba" name="sb" value="" class="form-control "  onkeypress="return event.charCode >= 45 && event.charCode <= 57">
                                </div>
                            </div>
                            <div id="grat" id="gratificacion" class="col-md-2 hidden">
                                <label>Gratificación</label>
                                <input type="text" id="gra" name="grat" value="" class="form-control "  onkeypress="return event.charCode >= 45 && event.charCode <= 57">
                            </div>
                            <div id="forta" class="col-md-3 hidden">
                                <label>Fortalecimiento al salario</label>
                                <input type="text" id="for" name="forta" value="" class="form-control "  onkeypress="return event.charCode >= 45 && event.charCode <= 57">
                            </div>
                            <div id="despensa" class="col-md-2 hidden">
                                <label>Despensa</label>
                                <input type="text" id="des" name="despensa" value="" class="form-control "  onkeypress="return event.charCode >= 45 && event.charCode <= 57">
                            </div>
                            <div id="tb" class="col-md-2 hidden"><div class="form-group">
                                <label>Total bruto</label>
                                <input type="text" id="tot_bru" name="tb" value="" class="form-control " onfocus="getBruto();"  onkeypress="return event.charCode >= 45 && event.charCode <= 57">
                            </div></div>
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
