<form action="#" id="frm_add_justificante" method="post" enctype="multipart/form-data">
	<input type="hidden" name="option" value="22">
	<input type="hidden" name="registro_id" id="registro_id" value="">
	<div class="modal fade" id="modal_add_justificante">
		<div class="modal-dialog ">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">JUSTIFICAR FALTA POR ENTRADA O SALIDA</h4>
				</div>
				<div class="modal-body">
					<div id="alerta_justificante"></div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Asunto</label>
								<input type="text" name="asunto" value="" required="" class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Adjuntar justificante</label>
								<input type="file" name="file" id="file" value=""class="form-control" accept=".pdf" required="">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Descripción del documento</label>
								<textarea name="comentario" id="comentario" class="form-control textarea_size"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-flat btn-defaul pull-left" data-dismiss="modal">
						Cerrar
					</button>
					<button type="submit" class="btn btn-flat btn-success">
						<i class="fa fa-floppy-o"></i> Guardar justificante 
					</button>
				</div>
			</div>
		</div>
	</div>
</form>
