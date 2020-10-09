<form action="#" method="post" id="frm_complete_fump">
    <input type="hidden" name="option" value="6">
    <input type="hidden" name="sp_id" value="<?=$_GET['fump_id']?>">
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">DATOS COMPLEMENTARIOS DEL FORMATO ÚNICO PARA MOVIEMIENTOS DEL PERSONAL (F.U.M.P).</h3>
                    </div>
                    <div class="box-body">
                        <div id="complete_fump"></div>

                        <fieldset>
                            <legend>TRÁMITE</legend>
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>
                                            <input type="radio" name="r_tramite" class="minimal" value="1" checked>
                                            Alta
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>
                                            <input type="radio" name="r_tramite" class="minimal" value="2">
                                            Baja
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>
                                            <input type="radio" name="r_tramite" class="minimal" value="3">
                                            Alta/Baja
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>
                                            <input type="radio" name="r_tramite" class="minimal" value="4">
                                            Cambio
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>
                                            <input type="radio" name="r_tramite" class="minimal" value="6">
                                            Percepciones y Deducciones variables
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>
                                            <input type="radio" name="r_tramite" class="minimal" value="7">
                                            Licencia
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>
                                            <input type="radio" name="r_tramite" class="minimal" value="8">
                                            Pensión alimenticia
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>
                                            <input type="radio" name="r_tramite" class="minimal" value="9">
                                            Cambio de datos
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>
                                            <input type="radio" name="r_tramite" class="minimal" value="10">
                                            Cambio de percepciones
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>DATOS DE LA PLAZA</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-condensed  table-hover table-striped table-bordered border-table">
                                        <tr>
                                            <th width="150px">No. de plaza: </th>
                                            <td>
                                                <select name="n_plaza" class="form-control" required="">
                                                    <option value="">...</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th width="150px">Tipo de plaza </th>
                                            <td><input type="text" name="t_plaza" value="" class="form-control"></td>
                                            
                                            
                                        </tr>
                                        <tr>
                                            <th width="150px">Código del puesto anterior</th>
                                            <td><input type="text" name="cod_anterior" value="" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th width="150px">Código del puesto actual</th>
                                            <td><input type="text" name="cod_actual" value="" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th width="150px">Vigencia</th>
                                            <td>
                                                DE 
                                                <input type="date" name="vigencia_ini" value="" class="form-control"> 
                                                Al 
                                                <input type="date"  name="vigencia_fin" value="" class="form-control"> 
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-condensed  table-hover table-striped table-bordered border-table">
                                        <tr>
                                            <th width="150px">Puesto funcional anterior</th>
                                            <td><input type="text" name="puesto_anterior" value="" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th width="150px">Puesto funcional actual</th>
                                            <td><input type="text" name="puesto_actual" value="" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th width="150px">Clave del centro de trabajo</th>
                                            <td><input type="text" name="cct" value="" class="form-control"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>PERCEPCIONES</legend>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Concepto</label>
                                        <select name="percepiones[]" id="percepciones" class="form-control percepciones" >
                                            <option value="">...</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Importe</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                            </span>
                                            <input type="text" name="per_importe[]" class="form-control" placeholder="">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-success btn-flat" onclick="add_percepcion('div_percepciones');">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="div_percepciones"></div>
                        </fieldset>
                        <fieldset>
                            <legend>DEDUCCIONES</legend>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Concepto</label>
                                        <select name="deducciones[]" id="deducciones" class="form-control" >
                                            <option value="">...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Importe</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                            </span>
                                            <input type="text" name="ded_importe[]" class="form-control" placeholder="">
                                            <span class="input-group-btn">
                                                <button onclick="add_deduccion('div_deducciones');" type="button" class="btn btn-success btn-flat">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="div_deducciones"></div>
                        </fieldset>
                        <fieldset>
                            <legend>RADICACIÓN DEL PAGO</legend>
                            <div class="row">
                                <div class="col-md-1" >
                                    <div class="form-group">
                                        <label>MPIO. A</label>
                                        <input type="text" class="form-control" name="mpioa">
                                    </div>
                                </div>
                                <div class="col-md-1" >
                                    <div class="form-group">
                                        <label>MPIO. P</label>
                                        <input type="text" class="form-control" name="mpiop">
                                    </div>
                                </div>
                                <div class="col-md-1" >
                                    <div class="form-group">
                                        <label>L.P.</label>
                                        <input type="text" class="form-control" name="lp">
                                    </div>
                                </div>
                                <div class="col-md-1" >
                                    <div class="form-group">
                                        <label>C.C.T.</label>
                                        <input type="text" class="form-control" name="cct_rp">
                                    </div>
                                </div>
                                <div class="col-md-1" >
                                    <div class="form-group">
                                        <label>S.P.</label>
                                        <input type="text" class="form-control" name="sp_rp">
                                    </div>
                                </div>
                                <div class="col-md-1" >
                                    <div class="form-group">
                                        <label>B.</label>
                                        <input type="text" class="form-control" name="b_rp">
                                    </div>
                                </div>
                                <div class="col-md-1" >
                                    <div class="form-group">
                                        <label>T.P.</label>
                                        <input type="text" class="form-control" name="tp_rp">
                                    </div>
                                </div>
                                
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>DATOS LABORABLES DEL SERVIDOR PÚBLICO</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-bordered table-hover table-striped border-table">
                                        <tr>
                                            <td><label>FECHA DE INGRESO AL G.E.M.:</label></td>
                                            <td>
                                                <input type="date" class="form-control" name="f_ingreso_gem">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label>ANTIGÜEDAD EFECTIVA:</label></td>
                                            <td>
                                                <input type="text" class="form-control" name="antig">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label>HORARIO: </label></td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-1">
                                                        <label> DE </label>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="text" name="hora_ini" value="" class="form-control timepicker">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label> A </label>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="text" name="hora_fin" value="" class="form-control timepicker">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label>TIPO DE RELACIÓN LABORAL: </label></td>
                                            <td>
                                                <select name="r_laboral" class="form-control">
                                                    <option value="">...</option>
                                                    <option value="1">PERMANENTE</option>
                                                    <option value="2">TEMPORAL</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label>TIPO DE SINDICATO: </label></td>
                                            <td>
                                                <select name="t_sindi" id="t_sindi" class="form-control">
                                                    <option value="">...</option>
                                                    <option value="1">SINDICALIZADO</option>
                                                    <option value="2">NO SINDICALIZADO</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label>VIGENCIA:</label></td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-1">
                                                        <label> DEL</label>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="date" name="fecha_ini" value="" placeholder="" class="form-control">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label> AL</label>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="date" name="fecha_fin" value="" placeholder="" class="form-control">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-bordered table-hover table-striped border-table">
                                        <tr>
                                            <td><label>FECHA DEL ÚLTIMO EGRESO DEL G.E.M:</label></td>
                                            <td>
                                                <input type="date" class="form-control" name="f_egreso">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label>FECHA DE LA ÚLTIMA PROMOCIÓN: </label></td>
                                            <td>
                                                <input type="date" class="form-control" name="f_promocion">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label>CLAVE DEL SERVIDOR PÚBLICO:</label></td>
                                            <td>
                                                <input type="text" class="form-control" name="cve_sp" maxlength="50">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label>TIPO DE APORTACIÓN: </label></td>
                                            <td>
                                                <input type="text" class="form-control" name="t_aportacion">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label>TIPO DE IMPUESTO:</label></td>
                                            <td>
                                                <select name="t_imp" id="t_imp" class="form-control">
                                                    <option value="">...</option>
                                                    <option value="1">SI PAGA</option>
                                                    <option value="2">NO PAGA</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>                            
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>DATOS DEL SUSTITUIDO</legend>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>CVE. ISSEMYM:</label>
                                        <input type="text" class="form-control" id="cve_issemym" name="cve_issemym"  readonly>
                                        <input type="hidden" class="form-control" id="id_cve_issemym" name="id_cve_issemym">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>NOMBRE:</label>
                                        <input type="text" class="form-control"  id="nombre_ds" name="nombre_ds">
                                        <input type="hidden" class="form-control" id="id_nombre_ds" name="id_nombre_ds">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>R.F.C.:</label>
                                        <input type="text" class="form-control" id="rfc_ds" name="rfc_ds"  readonly>
                                        <input type="hidden" class="form-control" id="id_rfc_ds" name="id_rfc_ds" >
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>DATOS DEL CAMBIO</legend>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>TIPO DE CAMBIO:</label>
                                        <select name="t_cambio" id="" class="form-control input-sm">
                                            <option value="">...</option>
                                            <option value="1">PROMOCIÓN</option>
                                            <option value="2">TRANSFERENCIA</option>
                                            <option value="3">DEMOCIÓN</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>MOVIMIENTO:</label>
                                        <select name="duracion" id="" class="form-control input-sm">
                                            <option value="">...</option>
                                            <option value="1">INDEFINIDO</option>
                                            <option value="2">TEMPORAL</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>VIGENCIA</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-1">
                                    <label>DEL:</label>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="date" name="c_f_ini" value="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <label>AL:</label>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="date" name="c_f_fin" value="" class="form-control ">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>DATOS DE LA BAJA</legend>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>FECHA DE LA BAJA: </label>
                                        <input type="date" name="f_baja" value="" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>MOTIVO:</label>
                                        <select name="motivo" id="" class="form-control">
                                            <option value="">...</option>
                                            <option value="1">RENUNCIA</option>
                                            <option value="2">RESCISIÓN</option>
                                            <option value="3">RESOLUCIÓN DE LA SRIA. DE LA CONTRALORIA</option>
                                            <option value="4">JUBILACIÓN</option>
                                            <option value="5">INHABILITACIÓN MÉDICA</option>
                                            <option value="6">FALLECIMIENTO</option>
                                            <option value="7">OTROS</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>FINIQUITO</legend>
                            <div class="row">
                                <div class="col-md-6">

                                    <table class="table table-bordered table-condensed">
                                        <thead>
                                            <tr class="bg-gray">
                                                <th>CONCEPTO A:</th>
                                                <th>CLAVE</th>
                                                <th>IMPORTE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>SUELDO</td>
                                                <td>
                                                    <input type="text" class="form-control" name="c_sueldo">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="i_sueldo">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>PRIMA POR PREM. EN EL SERVICIO </td>
                                                <td>
                                                    <input type="text" class="form-control" name="c_prima">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="i_prima">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>PRIMA VACACIONAL</td>
                                                <td>
                                                    <input type="text" class="form-control" name="c_primav">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="i_primav">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>AGUINALDO PROPORCIONAL</td>
                                                <td>
                                                    <input type="text" class="form-control" name="c_aguinaldo">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="i_aguinaldo">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>OTRO</td>
                                                <td>
                                                    <input type="text" class="form-control" name="c_otro">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="i_otro">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>SUMA A: </td>
                                                <td colspan="2">
                                                    <input type="text" class="form-control" id="suma_a" name="suma_a">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-bordered table-condensed">
                                        <thead>
                                            <tr class="bg-gray">
                                                <th>CONCEPTO A:</th>
                                                <th>CLAVE</th>
                                                <th>IMPORTE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>PAGO IMPROCEDENTE</td>
                                                <td>
                                                    <input type="text" class="form-control" name="c_pagoi">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="i_pagoi">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>PRÉSTAMO DIRECTO</td>
                                                <td>
                                                    <input type="text" class="form-control" name="c_prestamo">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="i_prestamo">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>OTROS</td>
                                                <td>
                                                    <input type="text" class="form-control" name="c_otros">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="i_otros">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>SUMA B: </td>
                                                
                                                <td colspan="2">
                                                    <input type="text" class="form-control" id="suma_b" name="suma_b">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>TOTAL NETO: </td>
                                                <td colspan="2">
                                                    <input type="text" class="form-control" id="t_neto" name="t_neto" onclick="total_neto();">
                                                </td>
                                                
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>LICENCIA</legend>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>GOCE DE SUELDO</label>
                                        <select name="goce_s" id="" class="form-control">
                                            <option value="">...</option>
                                            <option value="1">CON GOCE DE SUELDO</option>
                                            <option value="2">SIN GOCE DE SUELDO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <label>
                                        ALTA <input type="radio" name="edo_licencia" class="minimal" value="1" >
                                    </label>
                                </div>
                                <div class="col-md-1">
                                    <label>
                                        BAJA <input type="radio" name="edo_licencia" class="minimal" value="2" >
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>POR EL PERÍODO COMPRENDIDO DEL </label>
                                </div>
                                <div class="col-md-3">
                                    <input type="date" name="f_ini_lic" value="" class="form-control">
                                </div>
                                <div class="col-md-1 text-center">
                                    AL
                                </div>
                                <div class="col-md-3">
                                    <input type="date" name="f_fin_lic" value="" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-11">
                                    <label>Motivo:</label>
                                    <textarea class="form-control textarea_size" name="motivo"></textarea>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>PENSIÓN ALIMENTICIA</legend>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tipo de moviento</label>
                                        <select name="t_movi_pen" id="" class="form-control">
                                            <option value="1">ALTA</option>
                                            <option value="2">BAJA</option>
                                            <option value="3">CAMBIO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>QUINCENA:</label>
                                        <select id="quincena_pension" name="quincena_pension" class="form-control">
                                            <option value="">...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>AÑO:</label>
                                        <input type="text" name="year" id="year" value="" class="form-control" onkeypress="return event.charCode >= 45 && event.charCode <= 57">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>BENEFICIARIO(NOMBRE):</label>
                                        <input type="text" name="beneficiario" value="" class="form-control">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>R.F.C.:</label>
                                        <input type="text" name="rfc_beneficiario" value="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>IMPORTE DEL DESCUENTO:</label>
                                        <input type="text" name="importe" value="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>% DEL DESCUENTO:</label>
                                        <input type="text" name="porcentaje" value="" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        
                    </div>
                    <div class="box-footer">
                        <button type="reset" class="btn btn-default btn-flat pull-rigth">
                            <i class="glyphicon glyphicon-erase"></i> Limpiar formulario
                        </button>
                        <button type="submit" class="btn btn-success btn-flat pull-right">
                            <i class="fa fa-floppy-o"></i> Guardar información
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>