<form action="#" id="frm_editar_res" method="post">
	<input type="hidden" id="" name="option" value="26">
	<input type="hidden" id="e_registro_id" name="id" value="">
	<div class="modal fade" id="modal_editar_res">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">EDICIÓN DE REGISTRO DE ENTRADA Y SALIDA</h4>
				</div>
				<div class="modal-body">
					<div id="alerta_res"></div>
					<div class="row">
						<div class="col-md-12">
							<center> <h1 id="name_sp"></h1> </center>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>HORA DE ENTRADA</label>
								<input type="text" id="h_entrada" name="h_entrada" value="" class="form-control timepicker">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>HORA DE SALIDA</label>
								<input type="text" id="h_salida" name="h_salida" value="" class="form-control timepicker" required="">
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
