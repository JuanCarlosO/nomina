<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Generador de reporte para OSFEM.</h3>
                </div>
                <div class="box-body">
                    <div id="a_osfem"></div>
                    <form action="#" method="post" id="frm_osfem" class="form-horizontal">
                        <input type="hidden" name="option" value="19">
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
                                <table id="tbl_osfem" class="table table-striped table-condesed borde-blanco">
                                    <thead>
                                        <tr class="bg-navy">
                                            <th class="text-center">Concecutivo</th>
                                            <th class="text-center">Categoría</th>
                                            <th class="text-center">Nivel y Rango</th>
                                            <th class="text-center">No. ISSEMYM</th>
                                            <th class="text-center">CURP</th>
                                            <th class="text-center">Apellido Paterno</th>
                                            <th class="text-center">Apellido Materno</th>
                                            <th class="text-center">Nombres</th>
                                            <th class="text-center">RFC</th>
                                            <!-- <th class="text-center">SUELDO BRUTO</th>
                                            <th class="text-center">DEDUCCIONES</th>
                                            <th class="text-center">SUELDO NETO</th> -->
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