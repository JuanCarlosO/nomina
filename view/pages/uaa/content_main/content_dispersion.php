<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">GENERAR REPORTE DE DISPERSIÓN</h3>
                </div>
                <div class="box-body">
                    <div id="a_dispersion"></div>
                    <form action="#" method="post" id="frm_dispersion" class="form-horizontal">
                        <input type="hidden" name="option" value="18">
                        <div class="form-group">
                            <label class="col-sm-1 control-label">Año:</label>
                            <div class="col-md-3">
                                <input type="text" id="year" name="year" value="<?=date('Y')?>" class="form-control" maxlength="4" minlength="4" min="2020" max="<?=date('Y')?>" onkeypress="return event.charCode >= 45 && event.charCode <= 57"  required >
                            </div>
                            <label class="col-sm-1 control-label">Quincena: </label>
                            <div class="col-md-3">
                                <select name="quincenas" id="quincenas" class="form-control" required=""></select>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-success btn-flat btn-block">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="tbl_dispersion" class="table table-striped table-condesed borde-blanco">
                                    <thead>
                                        <tr class="bg-navy">
                                            <th class="text-center">Tipo de cuenta</th>
                                            <th class="text-center">Cuenta</th>
                                            <th class="text-center">Importe</th>
                                            <th class="text-center">Nombre del trabajador</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>