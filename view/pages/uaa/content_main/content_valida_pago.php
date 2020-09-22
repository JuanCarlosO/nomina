<?php
include_once 'model/UAAModel.php';
$uaa = new UAAModel;
#buscar el nombre de  las percepciones 
$names_per = array();
$names_ded = array();
$tot = 0;
for ($i=0; $i < count($_POST['criterio_per']); $i++) { 
    $names_per[$i] = $uaa->getNamePD($_POST['criterio_per'][$i]);
}
for ($i=0; $i < count($_POST['criterio_ded']); $i++) { 
    $names_ded[$i] = $uaa->getNamePD($_POST['criterio_ded'][$i]);
}
$sumaA = 0; $per = "";
for ($i=0; $i <  count($names_per); $i++) { 
    $sumaA += (float) $_POST['per_monto'][$i];
    $per .= '<tr>';
    $per .=    '<td>'.$names_per[$i]->cve_int .'</td>';
    $per .=    '<td>'.$names_per[$i]->nombre .'</td>';
    $per .=    '<td>'.$_POST['per_monto'][$i] .'</td>';
    $per .= '</tr>';
}
$sumaB = 0; $ded = "";
for ($i=0; $i <  count($names_ded); $i++) { 
    $sumaB += (float) $_POST['ded_monto'][$i];
    $ded .=  '<tr>';
    $ded .=     '<td>'.$names_ded[$i]->cve_int .'</td>';
    $ded .=     '<td>'.$names_ded[$i]->nombre  .'</td>';
    $ded .=     '<td>'.$_POST['ded_monto'][$i] .'</td>';
    $ded .=  '</tr>';
}
$tot = $sumaA - $sumaB;
#print_r($names_ded);
?>
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-dollar"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">TOTAL A PAGAR</span>
                    <span class="info-box-number"><?=$tot ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">REVISIÓN Y VALIDACIÓN DEL PAGO</h3>
                </div>
                <div class="box-body">		
                    <div id="alerta_validap"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3 style="letter-spacing: 12pt;word-spacing: 5pt;"> <center><?=$_POST['name_sp'] ?></center> </h3>
                            <input type="hidden" name="<?=$_POST['sp_id']?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered table-hover">
                                <caption class="text-center bg-gray">LISTA DE PERCEPCIONES</caption>
                                <thead class="bg-gray">
                                    <tr>
                                        <th class="text-center">Clave</th>
                                        <th class="text-center">Nombre de percepción</th>
                                        <th class="text-center">Importe</th>
                                        <th class="text-center"> <i class="fa fa-trash text-red"></i> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    echo $per; 
                                    ?>
                                    <tr>
                                        <td colspan="2" class="text-right"> <b>SUMA DE PERCEPCIONES:</b> </td>
                                        <td> <b><?=$sumaA;?></b> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <table class="table table-bordered table-hover">
                                    <caption class="text-center bg-gray">LISTA DE DEDUCCIONES</caption>
                                    <thead class="bg-gray">
                                       <tr id="Clave">
                                           <th class="text-center">Clave</th>
                                           <th class="text-center">Nombre de percepción</th>
                                           <th class="text-center">Importe</th>
                                           <th class="text-center"> <i class="fa fa-trash text-red"></i> </th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    echo $ded;
                                    ?>
                                    <tr>
                                        <td colspan="2" class="text-right"> <b>SUMA DE DEDUCCIONES:</b> </td>
                                        <td> <b><?=$sumaB;?></b> </td>
                                    </tr>
                                    </tbody> 
                                </table>
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <button class="btn btn-success btn-flat btn-block">
                                <i class="fa fa-money"></i> Guardar pago
                            </button>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>