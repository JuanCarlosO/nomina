<?php
include_once 'model/UAAModel.php';
include_once 'model/CalculadoraModel.php';
$uaa = new UAAModel;
$calc = new CalculadoraModel;
$personal = json_decode($uaa->getPersonalBy());
$quincena = json_decode($uaa->getInfoQuincena($_POST['c_quincena']));
$result = array();

?>
<section class="content container-fluid">

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">REVISIÓN Y VALIDACIÓN DEL PAGO GLOBAL</h3>
                </div>
                <div class="box-body">		
                    <div id="alerta_validap"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3 style="letter-spacing: 12pt;word-spacing: 5pt;"> <center></center> </h3>
                        </div>
                    </div>
                    <div id="alerta_pagar"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <b>
                                EL PAGO SERA APLICADO A LA QUINCENA: 
                                <big> <?=$quincena->nombre ?> </big>
                            </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                        	<div class="table-responsive">
                        		<table class="table table-bordered">
                        			<caption class="bg-gray"> <center> TABLA RESUMEN DE PAGO </center> </caption>
                        			<thead>
                        				<tr class="bg-gray">
                        					<th>NOMBRE DEL SERVIDOR PÚBLICO</th>
                        					<th>PERCEPCIONES / DEDUCCIONES</th>
                        					<th>NETO</th>
                        				</tr>
                        			</thead>
                        			<tbody>
                        				<?php foreach ($personal as $key => $p): ?>
                    					<tr class="text-left">
                    						<td><?=$p->nombre.' '.$p->ap_pat.' '.$p->ap_mat?></td>
                    						<td>
                    						<?php
                    						$reglas = $uaa->getReglasArray($p->id);
                                            #print_r($reglas);exit;
                    						?>
                    							<ol>
                    								<?php 
                    								$total = 0; $suma_isr = 0;
                    								foreach ($reglas as $key => $per): 
                    									if ((is_null($per->f_ini) && is_null($per->f_fin)) ) {
                    										if ($per->tipo_pd == 'PERCEPCION') {
                    											$total += $per->monto;
                    										}elseif($per->tipo_pd == 'DEDUCCION'){
                    											$total -= $per->monto;
                    										}
                    									}elseif ( (( $quincena->fecha_ini >= $per->f_ini ) && ($quincena->fecha_fin <= $per->f_fin)) ) {
                    										if ($per->tipo_pd == 'PERCEPCION') {
                    											$total += $per->monto;
                    										}elseif($per->tipo_pd == 'DEDUCCION'){
                    											$total -= $per->monto;
                    										}
                    									}
                    									if ( $per->g_isr == 'SI' ) {
                                                            $suma_isr += $per->monto;
                                                        }
                    								?>
                    								<?php if ( is_null($per->f_ini) && is_null($per->f_fin) ): ?>
                    									<li> 
                    										<label> <?=$per->tipo_pd?> - <?=$per->pd_name?>:</label>
                    									 	<i class="fa fa-dollar"></i> <?=$per->monto?>
                    									</li>
                    								<?php elseif(( $quincena->fecha_ini >= $per->f_ini ) && ($quincena->fecha_fin <= $per->f_fin)): ?>
                    									<li> 
                    										<label> <?=$per->tipo_pd?> - <?=$per->pd_name?>:</label>
                    									 	<i class="fa fa-dollar"></i> <?=$per->monto?>
                    									</li>
                    								<?php endif ?>
                    								<?php endforeach ?>
                                                    <li> 
                                                        <label> ISR </label>
                                                        <i class="fa fa-dollar"></i> <?=$isr_periodo = round($calc->getISR($suma_isr),2,PHP_ROUND_HALF_ODD) ;?>
                                                    </li>
                    							</ol>
                    						</td>
                    						<td>
                    							<i class="fa fa-dollar"></i> <?=($total-$isr_periodo)?>
                    						</td>
                    					</tr>
                        				<?php endforeach ?>
                        			</tbody>
                        		</table>
                        	</div>
                        </div>
                    </div>
                    <form action="#" method="post" id="frm_save_pago">
                    	<input type="hidden" name="option" value="23">
                    	<input type="hidden" name="quincena" value="<?=$_POST['c_quincena']?>">
                    	<div class="row">
                    		<div class="col-md-4"></div>
                    		<div class="col-md-4">
                    			<button type="submit" class="btn btn-success btn-flat btn-block">
                    				<i class="fa fa-floppy-o"></i> Pagar
                    			</button>
                    		</div>
                    		<div class="col-md-4"></div>
                    	</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>