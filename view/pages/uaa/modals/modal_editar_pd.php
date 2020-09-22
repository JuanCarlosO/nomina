<form action="#" id="frm_editar_pd">
	<input type="hidden" name="option" value="4">
</form>
<div class="modal fade" id="modal_editar_pd">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">EDICIÓN DE PERCEPCIÓN/DEDUCCIÓN</h4>
			</div>
			<div class="modal-body">
				<div id="div_editar_pd"></div>
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label>Tipo</label>
							<select class="form-control">
								<option value="">...</option>
								<option value="">Percepción</option>
								<option value="">Deducción</option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Nombre del concepto</label>
							<input type="text" name="" value="" placeholder="" class="form-control">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Cantidad</label>
							<input type="text" name="" value="" placeholder="" class="form-control">
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-flat btn-defaul pull-left" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-flat btn-success">
					<i class="fa fa-edit"></i> Editar 
				</button>
			</div>
		</div>
	</div>
</div>