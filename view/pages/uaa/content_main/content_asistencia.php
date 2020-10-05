<?php
require_once (getcwd().'/model/UAAModel.php');
$uaa = new UAAModel;
$p = $uaa->getPersonalByCard();
?>
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">REGISTRO DE ENTRADA / SALIDA </h3>
                </div>
                <div class="box-body">
                    <div id="alert_fump"></div>
                    <div class="row">
                    	<div class="col-md-12">
                    	  <!-- Custom Tabs -->
                    	  <div class="nav-tabs-custom">
                    	  	<ul class="nav nav-tabs">
                    	  		<li class="active"><a href="#entrada" data-toggle="tab">ENTRADA</a></li>
                    	  		<li><a href="#salida" data-toggle="tab">SALIDA</a></li>
                    	  	</ul>
                    	  	<div
                    	  	 class="tab-content">
                    	  		<div class="tab-pane active" id="entrada">
                                    <div id="alerta_entrada"></div>
                                    <form action="#" method="post" id="frm_registr_e">
                                        <input type="hidden" name="option" value="8">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Seleccione el dia</label>
                                                    <input type="date" name="dia_e" value="" class="form-control" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Seleccione la quincena</label>
                                                    <select name="quincena_e" id="quincenas" class="form-control" required>
                                                        <option value="">...</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table table-bordered border-table">
                                            <thead>
                                                <tr>
                                                    <th>ID_TARJETA</th>
                                                    <th>NOMBRE DEL SERVIDOR PUBLICO</th>
                                                    <th>HORA DE ENTRADA</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ( count($p)> 0 ): ?>
                                                    <?php foreach ($p as  $pe): ?>
                                                        <tr>
                                                            <td><?=$pe->id?></td>
                                                            <td><?=$pe->full_name?></td>
                                                            <td>
                                                                <input type="hidden" name="sp_id[]" value="<?=$pe->id?>">
                                                                <input type="text" class="form-control timepicker" name="hora_e[]" required>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                            </tbody>
                                        </table>
                                        <div class="row">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-4">
                                                <button class="btn btn-success btn-block btn-flat">
                                                    <i class="fa fa-floppy-o"></i> Guardar registro de entrada
                                                </button>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>
                                    </form>
                    	  		</div>
                    	  			<div class="tab-pane" id="salida">
                                        <div id="alerta_salida"></div>
                                        <form action="#" method="post" id="frm_registr_s">
                                            <input type="hidden" name="option" value="9">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Seleccione el dia</label>
                                                        <input type="date" name="dia_s" value="" class="form-control" required="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Seleccione la quincena</label>
                                                        <select name="quincena_s" id="quincenas_s" class="form-control" required>
                                                            <option value="">...</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <table class="table table-bordered border-table">
                                                <thead>
                                                    <tr>
                                                        <th>ID_TARJETA</th>
                                                        <th>NOMBRE DEL SERVIDOR PUBLICO</th>
                                                        <th> HORA DE SALIDA</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if ( count($p)> 0 ): ?>
                                                        <?php foreach ($p as  $pe): ?>
                                                            <tr>
                                                                <td><?=$pe->id?></td>
                                                                <td><?=$pe->full_name?></td>
                                                                <td>
                                                                    <input type="hidden" name="sp_id_s[]" value="<?=$pe->id?>">
                                                                    <input type="text" class="form-control timepicker" name="hora_s[]">
                                                                </td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                    <?php endif ?>
                                                </tbody>
                                            </table>
                                            <div class="row">
                                                <div class="col-md-4"></div>
                                                <div class="col-md-4">
                                                    <button class="btn btn-success btn-block btn-flat">
                                                        <i class="fa fa-floppy-o"></i> Guardar registro de salida 
                                                    </button>
                                                </div>
                                                <div class="col-md-4"></div>
                                            </div>
                                        </form>
                    	  				
                    	  			</div>
                    	  		</div>
                    	  	</div>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>