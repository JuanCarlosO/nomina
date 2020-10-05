<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">AGREGAR PERSONAL DE ASUNTOS INTERNOS</h3>
                </div>
                <form action="#" id="frm_add_personal" method="post">
                    <input type="hidden" name="option" value="5">
                    <div class="box-body">
                        <div id="add_person"></div>
                        <div class="row">
                            <div class="col-md-7"></div>
                           <div class="col-md-3">
                                <div class="form-group">
                                    <label>FECHA DE INGRESO A LA U.A.I</label>
                                    <input type="date" name="f_ingreso" value="" class="form-control" required="">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>NÚMERO DE TARJETA</label>
                                    <input type="number" name="n_tarjeta" value="" class="form-control" min="1" max="200" required="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>DEPENDENCIA</label>
                                    <select name="depe" id="depe" class="form-control">
                                        <option value="">...</option>
                                        <option value="1">UNIDAD DE ASUNTOS INTERNOS</option>
                                        <option value="2">SECRETARÍA DE SEGURIDAD</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>ORGANISMO/SUBSECRETARÍA</label>
                                    <select name="orga" id="orga" class="form-control">
                                        <option value="">...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>DIRECCIÓN</label>
                                    <select name="dir_e" id="dir_e" class="form-control">
                                        <option value="">...</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>DIRECCIÓN DE ÁREA</label>
                                    <select name="dir" id="dir" class="form-control">
                                        <option value="">...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>SUBDIRECCIÓN</label>
                                    <select name="subdir" id="subdir" class="form-control">
                                        <option value="">...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>DEPARTAMENTO</label>
                                    <select name="depto" id="depto" class="form-control">
                                        <option value="">...</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>NOMBRE(S)</label>
                                    <input type="text" name="nombre" id="nombre" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>APELLIDO PATERNO</label>
                                    <input type="text" id="ap_pat" name="ap_pat" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>APELLIDO MATERNO</label>
                                    <input type="text" name="ap_mat" id="ap_mat" value="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>DOMICILIO</label>
                                    <input type="text" name="domicilio" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>MUNICIPIO</label>
                                    <select name="municipios" id="municipio" class="form-control">
                                        <option value="">...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>NIVEL-RANGO</label>
                                    <select name="nivel" id="nivel" class="form-control">
                                        <option value="">...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>ENTIDAD DE NACIMIENTO</label>
                                    <input type="text" name="entidad" value="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>COLONIA</label>
                                    <input type="text" name="colonia" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>C.P.</label>
                                    <input type="text" name="cp" value="" class="form-control">
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>FECHA DE NACIMIENTO</label>
                                    <input type="date" name="f_nac" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>ESCOLARIDAD</label>
                                    <input type="text" name="escolaridad" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>ESTADO CIVIL</label>
                                    <select name="edo_civil" id="" class="form-control">
                                        <option value="">...</option>
                                        <option value="1">SOLTERO</option>
                                        <option value="2">CASADO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>R.F.C.</label>
                                    <input type="text" name="rfc" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>C.U.R.P.</label>
                                    <input type="text" name="curp" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Clave de ISSEMYM(opcional)</label>
                                    <input type="text" name="cve_issemym" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Seleccione un proyecto</label>
                                    <select name="pro" id="" class="form-control">
                                        <option value="">...</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Género</label>
                                    <select name="genero" id="" class="form-control">
                                        <option value="">...</option>
                                        <option value="1">Hombre</option>
                                        <option value="2">Mujer</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Banco</label>
                                    <select name="banco" id="banco" class="form-control">
                                        <option value="">...</option>
                                        <option value="1">BBVA</option>
                                        <option value="2">HSBC</option>
                                        <option value="3">BANAMEX</option>
                                        <option value="4">BANORTE</option>
                                        <option value="5">SANTANDER</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Número de tarjeta</label>
                                    <input type="text" name="num_tarjeta" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Número de cuenta</label>
                                    <input type="text" name="num_cuenta" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="reset" class="btn btn-default btn-flat">Limpiar formulario</button>
                        <button type="submit" class="btn btn-success btn-flat pull-right">
                            <i class="fa fa-floppy-o"></i> GUARDAR DATOS
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>