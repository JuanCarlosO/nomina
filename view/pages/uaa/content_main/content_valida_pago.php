<?php
include_once 'model/UAAModel.php';
$uaa = new UAAModel;
#buscar el nombre de  las percepciones 
$names_per = array();
$names_ded = array();
$names_pd = array();
$tot = 0;
for ($i=0; $i < count($_POST['criterio_per']); $i++) { 
    $names_per[$i] = $uaa->getNamePD($_POST['criterio_per'][$i]);
}
if ( isset($_POST['criterio_ded']) > 0 ) {
    for ($i=0; $i < count($_POST['criterio_ded']); $i++) { 
        $names_ded[$i] = $uaa->getNamePD($_POST['criterio_ded'][$i]);
    }
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

#las per o ded extras 
if ( isset($_POST['t_per_ded']) ) {
    for ($i=0; $i < count($_POST['t_per_ded']); $i++) { 
        if ( $_POST['t_per_ded'][$i] == 1 ) {
            $sumaA = $sumaA + ((float)$_POST['monto'][$i]); 
        }elseif ( $_POST['t_per_ded'][$i] == 1 ) {
            $sumaB = $sumaB + ((float)$_POST['monto'][$i]); 
        }
        $names_pd[$i] = $uaa->getNamePD($_POST['criterio_e'][$i]);
    }
}

$tot = $sumaA - $sumaB;
#integrar las percepciones y las deducciones
$percepciones = array();
$deducciones = array();
$suma_retardos =0 ;
if ( isset($_POST['mon_retardo']) ) {
    for ($i=0; $i < count($_POST['mon_retardo']); $i++) { 
        $suma_retardos = $suma_retardos + (int) $_POST['mon_retardo'][$i];
    }
}
$tot = $tot -$suma_retardos;
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
                        </div>
                    </div>
                    <div id="alerta_pagar"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <b>
                                EL PAGO SERA APLICADO A LA QUINCENA: 
                                <big><?=$_POST['name_quincena'];?></big>
                            </b>
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
                                        <!-- <th class="text-center"> <i class="fa fa-trash text-red"></i> </th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    echo $per; 
                                    if (isset($_POST['t_per_ded'])) {
                                        for ($i=0; $i < count($_POST['t_per_ded']) ; $i++) { 
                                            if ($_POST['t_per_ded'][$i] == 1) {
                                                echo  '<tr>';
                                                echo     '<td>'.$names_pd[$i]->cve_int .'</td>';
                                                echo     '<td>'.$names_pd[$i]->nombre  .'</td>';
                                                echo     '<td>'.$_POST['monto'][$i] .'</td>';
                                                echo  '</tr>';
                                            }
                                        }
                                    }
                                    
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
                                           <!-- <th class="text-center"> <i class="fa fa-trash text-red"></i> </th> -->
                                       </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    echo $ded;
                                    if (isset($_POST['t_per_ded'])) {
                                        for ($i=0; $i < count($_POST['t_per_ded']) ; $i++) { 
                                            if ($_POST['t_per_ded'][$i] == 2) {
                                                echo  '<tr>';
                                                echo     '<td>'.$names_ded[$i]->cve_int .'</td>';
                                                echo     '<td>'.$names_ded[$i]->nombre  .'</td>';
                                                echo     '<td>'.$_POST['monto'][$i] .'</td>';
                                                echo  '</tr>';
                                            }
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td>S/C</td>
                                        <td>DESCUENTO POR RETARDOS</td>
                                        <td><?=$suma_retardos; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-right"> <b>SUMA DE DEDUCCIONES:</b> </td>
                                        <td> <b><?=$sumaB;?></b> </td>
                                    </tr>
                                    </tbody> 
                                </table>
                                
                            </div>
                        </div>
                    </div>
                    <form action="#" method="post" id="frm_realiza_pago">
                        <input type="hidden" name="option" value="13">
                        <input type="hidden" name="num_quincena" value="<?=$_POST['num_quincena']?>">
                        <input type="hidden" name="sp_id" value="<?=$_POST['sp_id']?>">
                        <?php
                        $per_list = array();
                        $ded_list = array();
                        for ($i=0; $i < count($_POST['criterio_per']); $i++) { 
                            $aux['criterio'] = $_POST['criterio_per'][$i];
                            $aux['monto'] = $_POST['per_monto'][$i];
                            array_push($per_list, $aux) ;
                        }
                        if ( isset($_POST['criterio_ded']) ) {
                            for ($i=0; $i < count($_POST['criterio_ded']); $i++) { 
                                $aux['criterio'] = $_POST['criterio_ded'][$i];
                                $aux['monto'] = $_POST['ded_monto'][$i];
                                array_push($ded_list, $aux) ;
                            }
                        }
                        
                        if (isset($_POST['criterio_e']) ) {
                            for ($i=0; $i < count($_POST['criterio_e']); $i++) { 
                                $aux['criterio'] = $_POST['criterio_e'][$i];
                                $aux['monto'] = $_POST['monto'][$i];
                                if ($_POST['t_per_ded'][$i] == '1') {
                                    array_push($per_list, $aux) ;
                                }else{
                                    array_push($ded_list, $aux) ;
                                }
                            }
                        }
                        for ($i=0; $i < count($per_list); $i++) { 
                            echo '<input type="hidden" name="percepciones[]" value="'.$per_list[$i]['criterio'].'">';
                            echo '<input type="hidden" name="per_monto[]" value="'.$per_list[$i]['monto'].'">';
                        }
                        for ($i=0; $i < count($ded_list); $i++) { 
                            echo '<input type="hidden" name="deducciones[]" value="'.$ded_list[$i]['criterio'].'">';
                            echo '<input type="hidden" name="ded_monto[]" value="'.$ded_list[$i]['monto'].'">';
                        }
                        ?>
                        <!-- <code>
                            <pre><?php print_r($ded_list) ?></pre>
                        </code> -->
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <button class="btn btn-success btn-flat btn-block">
                                    <i class="fa fa-money"></i> Guardar pago
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