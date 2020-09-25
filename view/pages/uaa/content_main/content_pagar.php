<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Formulario de pago de nómina</h3>
                </div>
                <div class="box-body">
                    <div id="p_nomina"></div>
                    <form action="" id="frm_inicio_pago" method="post"  >
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Quincena a pagar</label>
                                    <select name="c_quincena" id="c_quincena" class="form-control" required=""></select>
                                </div>      
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Pagar a </label>
                                    <select name="a_pago" id="a_pago" class="form-control" required="">
                                        <option value="">...</option>
                                        <option value="1">Todo el personal de manera individual</option>
                                        <option value="2">Uno o varios servidores públicos</option>
                                        <option value="3">Personal sindicalizado aplicando los mismos criterios</option>
                                        <option value="4">Personal no sindicalizado aplicando los mismos criterios</option>
                                        <option value="5">Personal de estructura aplicando los mismos criterios</option>
                                    </select>
                                </div>      
                            </div>  
                        </div>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-success btn-flat btn-block">
                                    <i class="fa fa-floppy-o"></i> Iniciar proceso
                                </button>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                    </form>
                    
                    <div id="aplica_all" class="hidden">
                        <form action="index.php?menu=validar_pagar" method="post" id="frm_validar_pagar" target="__blank">
                            <input type="hidden" id="name_quincena" name="name_quincena" value="">
                            <input type="hidden" id="num_quincena" name="num_quincena" value="">
                            <div id="a_all"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Servidor público seleccionado para pagar</label>
                                        <input type="text" name="name_sp" id="name_sp" value="" class="form-control" >
                                        <input type="hidden" name="sp_id" id="sp_id" value="">
                                    </div>
                                </div>
                            </div>
                            <fieldset>
                                <legend> <center>Percepciones fijas para el servidor público</center> </legend>
                                <div id="per_predeterminadas"></div>
                            </fieldset>
                            <fieldset>
                                <legend> <center>Deducciones fijas para el servidor público</center> </legend>
                                <div id="ded_predeterminadas"></div>
                            </fieldset>
                            <fieldset>
                                <legend> <center>Descuentos por retardos</center> </legend>
                                <div id="div_retardos">
                                    
                                </div>
                            </fieldset>
                            
                            <fieldset>
                                <legend> <center>Percepciones y Deducciones extraordinarias</center> </legend>
                                <div class="row">
                                    <div class="col-md-1 pull-right">
                                        <button type="button" id="btn_add_deduccion" class="btn btn-success btn-flat pull-right btn-lg" onclick="add_criterio('criterio');">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </fieldset>
                            
                            <div id="criterio"></div>
                            <div class="row">
                                <div class="col-md-5"></div>
                                <div class="col-md-2">
                                    <button class="btn btn-success btn-flat btn-block">
                                        <i class="fa fa-money" style="font-size: 70px;"></i>
                                        <br>
                                        PAGAR
                                    </button>
                                </div>
                                <div class="col-md-5"></div>
                            </div>
                        </form>
                        
                    </div>
                    <div id="aplica_some" class="hidden">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="personal_pagar" class="table border-table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox" name="" value="">
                                                </th>
                                                <th>#</th>
                                                <th>Servidor público</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="checkbox" name="" value=""></td>
                                                <td>1</td>
                                                <td>Juan Carlos Ovando Quintana</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="" value=""></td>
                                                <td>2</td>
                                                <td> Estefany Ariadna Marin Vilchis</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="aplica_sindicalizados" class="hidden">
                        <form action="#" method="post" id="frm_pagar_sind">
                            <input type="hidden" name="sp_id" id="sp_id" value="">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Percepción o deducción</label>
                                        <select name="" id="" class="form-control" required>
                                            <option value=""></option>
                                            <option value="1">Percepción</option>
                                            <option value="2">Deducción</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Criterio</label>
                                        <select name="" id="" class="form-control" required>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Monto</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                            </span>
                                            <input type="text" class="form-control" placeholder="500" onkeypress='return event.charCode >= 45 && event.charCode <= 57'>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" id="btn_add_deduccion" class="btn btn-success btn-flat pull-right btn-lg" onclick="add_criterio('criterio_sind');">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="criterio_sind"></div>
                        </form>
                    </div>
                    <div id="aplica_not_sindicalizados" class="hidden">
                        <form action="#" method="post" id="frm_pagar_not_sind">
                            <input type="hidden" name="sp_id" id="sp_id" value="">
                            <input type="hidden" name="quincena" value="">
                            <input type="hidden" name="tipo_personal" value="">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Percepción o deducción</label>
                                        <select name="" id="" class="form-control" required>
                                            <option value=""></option>
                                            <option value="1">Percepción</option>
                                            <option value="2">Deducción</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Criterio</label>
                                        <select name="" id="" class="form-control" required>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Monto</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                            </span>
                                            <input type="text" class="form-control" placeholder="500" onkeypress='return event.charCode >= 45 && event.charCode <= 57'>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" id="btn_add_deduccion" class="btn btn-success btn-flat pull-right btn-lg" onclick="add_criterio('criterio_not_sind');">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="criterio_not_sind"></div>
                        </form>
                    </div>
                    <div id="aplica_jefes" class="hidden">
                        <div class="row">
                            <div class="col-md-12">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>