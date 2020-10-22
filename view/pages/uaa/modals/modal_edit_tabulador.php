<form action="#" id="frm_editar_tab" method="post">
	<input type="hidden" id="" name="option" value="25">
	<input type="hidden" id="option_tab" name="id" value="">
	<div class="modal fade" id="modal_editar_tabulador">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">EDICIÓN DE TABULADOR DE VALORES PARA CALCULO DE ISR</h4>
				</div>
				<div class="modal-body">
					<div id="alerta_tab"></div>
					<div class="row">
                		<div class="col-md-4">
                			<div class="form-group">
                				<label>Limite inferior 1</label>
                				<input type="text" required="" id="e_li1" name="lim_inf1" value="" class="form-control" onkeypress="return event.charCode >= 45 && event.charCode <= 57">
                			</div>
                		</div>
                		<div class="col-md-4">
                			<div class="form-group">
                				<label>Limite inferior 2</label>
                				<input type="text" required="" id="e_li2" name="lim_inf2" value="" class="form-control" onkeypress="return event.charCode >= 45 && event.charCode <= 57">
                			</div>
                		</div>
                		<div class="col-md-4">
                			<div class="form-group">
                				<label>Limite superior</label>
                				<input type="text" required="" id="e_ls" name="lim_supe" value="" class="form-control" onkeypress="return event.charCode >= 45 && event.charCode <= 57">
                			</div>
                		</div>
                	</div>
                	<div class="row">
                		<div class="col-md-4">
                			<div class="form-group">
                				<label>Cuota fija</label>
                				<input type="text" required="" id="e_cf" name="cuota_fija" value="" class="form-control" onkeypress="return event.charCode >= 45 && event.charCode <= 57">
                			</div>
                		</div>
                		<div class="col-md-4">
                			<div class="form-group">
                				<label>Porcentaje para el excedente</label>
                				<input type="text" required="" id="e_pe" name="porcentaje" value="" class="form-control" onkeypress="return event.charCode >= 45 && event.charCode <= 57">
                			</div>
                		</div>
                		<div class="col-md-4">
                			<div class="form-group">
                				<label>Subsidio del empleo</label>
                				<input type="text" required="" id="e_se" name="subsidio" value="" class="form-control" onkeypress="return event.charCode >= 45 && event.charCode <= 57">
                			</div>
                		</div>
                	</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-flat btn-defaul pull-left" data-dismiss="modal">
						Cerrar
					</button>
					<button type="submit" class="btn btn-flat btn-success">
						<i class="fa fa-edit"></i> Editar 
					</button>
				</div>
			</div>
		</div>
	</div>
</form>
