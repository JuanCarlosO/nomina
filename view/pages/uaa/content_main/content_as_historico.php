<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">HISTÓRICO DE ASISTENCIAS</h3>
                </div>
                <div class="box-body">
                	<div class="row">
                		<div class="col-md-3">
                			<div class="form-group">
                				<label>Elegir un número de quincena</label>
                				<select name="" id="" class="form-control">
                					<option value="">...</option>
                					<option value="1">1ra de Enero</option>
                				</select>
                			</div>
                		</div>
                        
                        
                	</div>

                    <div id="h_asistencia"></div>

                    <div class="row">
                    	<div class="col-md-12">
                    		<div class="table-responsive">
                    			<table class="table table-striped border-table">
                    				<thead>
                    					<tr>
                    						<th>#</th>
                    						<th>Servidor público</th>
                    						<th>Asistencias</th>
                    						<th>Retardos</th>
                    					</tr>
                    				</thead>
                    				<tbody>
                    					<tr>
                    						<td>1</td>
                    						<td>Juan Carlos Ovando Quintana</td>
                    						<td>
                    							<ol>
                    								<li>Dia: <?=date('Y-m-d');?> Entrada: <?=date('H:m:s');?> Salida: <?=date('H:m:s');?>  </li>
                    							</ol>
                    						</td>
                    						<td>
                    							<ol>
                    								<li>Dia: <?=date('Y-m-d');?> Entrada: <?=date('H:m:s');?> Salida: <?=date('H:m:s');?>  </li>
                    							</ol>
                    						</td>
                    					</tr>
                    				</tbody>
                    			</table>
                    		</div>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>