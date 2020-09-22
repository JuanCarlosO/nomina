<?php 
/**
 * Modelo para los Usuarios 
 */
include_once 'Connection.php';
include_once 'CalculadoraModel.php';
include_once 'anexgrid.php';
class UAAModel extends Connection
{
	public $sql;
	public $stmt;
	public $result;
	public function getPersonal()
	{
		try {
			$anexgrid = new AnexGrid();
			$wh = "";
			foreach ($anexgrid->filtros as $filter) {
				if ( $filter['columna'] != '' ) {
					if ( $filter['columna'] == 'full_name') {
						$wh .= " AND CONCAT(p.nombre,' ',p.ap_pat,' ',p.ap_mat) LIKE '%".$filter['valor']."%'";
					}else{
						$wh .= " AND ".$filter['columna']." = ".$filter['valor'];
					}
				}
			}
			$this->sql = "SELECT p.*,CONCAT(nr.clave, ' - ',nr.nombre) AS nivel_rango FROM personal AS p
			INNER JOIN niveles_rangos AS nr ON nr.id = p.nivel
			WHERE 1=1 $wh ORDER BY p.$anexgrid->columna $anexgrid->columna_orden LIMIT $anexgrid->pagina , $anexgrid->limite";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->execute();
			$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			$total = 0;
			$this->sql = "SELECT COUNT(*) AS total FROM personal AS p 
			INNER JOIN niveles_rangos AS nr ON nr.id = p.nivel
			WHERE 1=1 $wh";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->execute();
			$total = $this->stmt->fetch(PDO::FETCH_OBJ)->total;
			return $anexgrid->responde($this->result,$total);
		} catch (Exception $e) {
			return json_encode( array('status'=>'error','message'=>$e->getMessage()) );
		}
	}
	public function getPersonalBy()
	{
		try {
			
			$this->sql = "SELECT * FROM personal ";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->execute();
			$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			
			return json_encode($this->result);
		} catch (Exception $e) {
			return json_encode( array('status'=>'error','message'=>$e->getMessage()) );
		}
	}
	public function getPersonalByCard()
	{
		try {
			$this->sql ="SELECT *, CONCAT(nombre,' ',ap_pat,' ',ap_mat) AS full_name FROM personal WHERE estado = 1 AND num_tarjeta IS NOT NULL ORDER BY num_tarjeta";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->execute();
			$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			return $this->result;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	public function getCatalogo($catalogo)
	{
		try {
			$wh = "";
			
			if ($catalogo == 'c_quincenas' || $catalogo == 'per_ded') {
				$params = "id AS id, UPPER(nombre) AS value";
				if ($catalogo != 'per_ded') {
					$table = "catalogo_quincenas";
				}else{
					$table = $catalogo;
					if ( $table == 'per_ded' ) {
						$wh = " AND tipo = ".$_POST['tipo'];
					}
					
				}
			}elseif ($catalogo == 'direcciones_int' || $catalogo == 'subdirecciones_int' || $catalogo == 'departamentos_int') {
				$table = 'areas';
				$params = "id AS id, CONCAT(clave,' - ',nombre) AS value";
				if ($catalogo == 'direcciones_int') {
					$wh = " AND nivel <= 2 ";
				}
				if ($catalogo == 'subdirecciones_int') {
					$wh = " AND nivel = 3 ";
				}
				if ( $catalogo == 'departamentos_int') {
					$wh = " AND nivel = 4 ";
				}
			}else{
				$params = "id AS id, UPPER(nombre) AS value";
				$table = $catalogo;
			}
			$this->sql ="SELECT $params FROM $table WHERE 1=1 $wh";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->execute();
			$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			return json_encode($this->result);
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}
	public function getPerDed()
	{
		try {
			$anexgrid = new AnexGrid();
			$wh = "";
			foreach ($anexgrid->filtros as $filter) {
				if ( $filter['columna'] != '' ) {
					if ( $filter['columna'] == 'nombre' ) {
						$wh .= " AND ".$filter['columna']." LIKE '%".$filter['valor']."%'";
					}else{
						$wh .= " AND ".$filter['columna']." = ".$filter['valor'];
					}
				}
			}
			$this->sql ="SELECT * FROM per_ded WHERE 1=1 $wh ORDER BY $anexgrid->columna $anexgrid->columna_orden LIMIT $anexgrid->pagina , $anexgrid->limite";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->execute();
			$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			$total = 0;
			$this->sql = "SELECT COUNT(*) AS total FROM per_ded ";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->execute();
			$total = $this->stmt->fetch(PDO::FETCH_OBJ)->total;
			return $anexgrid->responde($this->result,$total);
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}
	public function getNR()
	{
		try {
			$anexgrid = new AnexGrid();
			$wh = "";
			foreach ($anexgrid->filtros as $filter) {
				if ( $filter['columna'] != '' ) {
					if ( $filter['columna'] == 'nombre' ) {
						$wh .= " AND ".$filter['columna']." LIKE '%".$filter['valor']."%'";
					}else{
						$wh .= " AND ".$filter['columna']." = ".$filter['valor'];
					}
				}
			}
			$this->sql ="SELECT * FROM niveles_rangos WHERE 1=1 $wh ORDER BY $anexgrid->columna $anexgrid->columna_orden LIMIT $anexgrid->pagina , $anexgrid->limite";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->execute();
			$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			$total = 0;
			$this->sql = "SELECT COUNT(*) AS total FROM niveles_rangos ";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->execute();
			$total = $this->stmt->fetch(PDO::FETCH_OBJ)->total;
			return $anexgrid->responde($this->result,$total);
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}
	
	public function getNamesPersonal()
	{
		try {
			$term = "%".$_REQUEST['term']."%";
			$this->sql ="SELECT id, CONCAT( nombre,' ',ap_pat,' ',ap_mat ) AS value 
			FROM personal 
			WHERE CONCAT( nombre,' ',ap_pat,' ',ap_mat ) LIKE ? LIMIT 10";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(1, $term, PDO::PARAM_STR );
			$this->stmt->execute();
			$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			return json_encode($this->result);
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	public function saveNivel()
	{
		try {
			$name = ( isset($_POST['nombre']) ) ? mb_strtoupper($_POST['nombre'],'utf-8') : false ;
			$cve = ( isset($_POST['clave']) ) ? mb_strtoupper($_POST['clave'],'utf-8') : false ;
			$this->sql ="INSERT INTO niveles_rangos (id, nombre, clave) VALUES ('',?,?);";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(1, $name, PDO::PARAM_STR );
			$this->stmt->bindParam(2, $cve, PDO::PARAM_STR );
			$this->stmt->execute();
			$alerta = array( 'status'=>'success','message'=>'EL NIVEL/RANGO A SIDO REGISTRADO DE MANERA EXITOSA.' );
			return json_encode( $alerta );
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	public function savePersonal()
	{
		try {
			$nombre = ( isset($_POST['nombre']) ) ? mb_strtoupper($_POST['nombre'],'utf-8') : false ;
			$ap = ( isset($_POST['ap_pat']) ) ? mb_strtoupper($_POST['ap_pat'],'utf-8') : false ;
			$am = ( isset($_POST['ap_mat']) ) ? mb_strtoupper($_POST['ap_mat'],'utf-8') : false ;
			$rfc = ( isset($_POST['rfc']) ) ? mb_strtoupper($_POST['rfc'],'utf-8') : false ;
			$curp = ( isset($_POST['curp']) ) ? mb_strtoupper($_POST['curp'],'utf-8') : false ;
			$genero = ( isset($_POST['genero']) ) ? mb_strtoupper($_POST['genero'],'utf-8') : false ;
			$issemym = ( isset($_POST['cve_issemym']) ) ? mb_strtoupper($_POST['cve_issemym'],'utf-8') : false ;
			$edo_c = ( isset($_POST['edo_civil']) ) ? mb_strtoupper($_POST['edo_civil'],'utf-8') : false ;
			$fn = ( isset($_POST['f_nac']) ) ? mb_strtoupper($_POST['f_nac'],'utf-8') : false ;
			$nivel = ( isset($_POST['nivel']) ) ? mb_strtoupper($_POST['nivel'],'utf-8') : false ;
			$escolaridad = ( isset($_POST['escolaridad']) ) ? mb_strtoupper($_POST['escolaridad'],'utf-8') : false ;
			$pro = ( isset($_POST['pro']) ) ? mb_strtoupper($_POST['pro'],'utf-8') : false ;
			$area_id = ( isset($_POST['depto']) ) ? mb_strtoupper($_POST['depto'],'utf-8') : false ;
			$tarjeta = ( isset($_POST['n_tarjeta']) ) ? mb_strtoupper($_POST['n_tarjeta'],'utf-8') : false ;
			
			$this->sql ="INSERT INTO personal(
			    id,
			    nombre,
			    ap_pat,
			    ap_mat,
			    curp,
			    rfc,
			    genero,
			    clave,
			    issemym,
			    edo_civil,
			    f_nac,
			    nivel,
			    escolaridad,
			    proyecto,
			    area_id,
			    estado,
			    num_tarjeta
			)
			VALUES 
			('',:nombre,:ap,:am,:curp, :rfc, :genero, NULL, :issemym, :edo_c, :fn, :nivel, :escolaridad, 
			:pro, :area_id, 1, :tarjeta);";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR );
			$this->stmt->bindParam(':ap', $ap, PDO::PARAM_STR );
			$this->stmt->bindParam(':am', $am, PDO::PARAM_STR );
			$this->stmt->bindParam(':curp', $curp, PDO::PARAM_STR );
			$this->stmt->bindParam(':rfc', $rfc, PDO::PARAM_STR );
			$this->stmt->bindParam(':genero', $genero, PDO::PARAM_INT );
			$this->stmt->bindParam(':issemym', $issemym, PDO::PARAM_STR );
			$this->stmt->bindParam(':edo_c', $edo_c, PDO::PARAM_INT );
			$this->stmt->bindParam(':fn', $fn, PDO::PARAM_STR );
			$this->stmt->bindParam(':nivel', $nivel, PDO::PARAM_INT );
			$this->stmt->bindParam(':escolaridad', $escolaridad, PDO::PARAM_STR );
			$this->stmt->bindParam(':pro', $pro, PDO::PARAM_INT );
			$this->stmt->bindParam(':area_id', $area_id, PDO::PARAM_INT );
			$this->stmt->bindParam(':tarjeta', $tarjeta, PDO::PARAM_INT );
			$this->stmt->execute();
			$persona = $this->pdo->lastInsertId();
			#Insertar los datos de la ubicacion 
			$municipios = ( isset($_POST['municipios']) ) ? mb_strtoupper($_POST['municipios'],'utf-8') : NULL ;
			$domicilio = ( isset($_POST['domicilio']) ) ? mb_strtoupper($_POST['domicilio'],'utf-8') : NULL ;
			$entidad = ( isset($_POST['entidad']) ) ? mb_strtoupper($_POST['entidad'],'utf-8') : NULL ;
			$colonia = ( isset($_POST['colonia']) ) ? mb_strtoupper($_POST['colonia'],'utf-8') : NULL ;
			$cp = ( isset($_POST['cp']) ) ? mb_strtoupper($_POST['cp'],'utf-8') : NULL ;
			$this->sql ="INSERT INTO ubicaciones(
			    id,
			    personal_id,
			    municipio,
			    localidad,
			    entidad,
			    colonia,
			    cp
			)
			VALUES
			('',:persona, :mun, :local, :entidad, :colonia, :cp );";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':persona', $persona, PDO::PARAM_INT );
			$this->stmt->bindParam(':mun', $municipios, PDO::PARAM_INT );
			$this->stmt->bindParam(':local', $domicilio, PDO::PARAM_STR );
			$this->stmt->bindParam(':entidad', $entidad, PDO::PARAM_STR );
			$this->stmt->bindParam(':colonia', $colonia, PDO::PARAM_STR );
			$this->stmt->bindParam(':cp', $cp, PDO::PARAM_STR );
			$this->stmt->execute();
			# INSERTAR LOS DATOS DE LA ADSCRIPCION
			$depe = ( isset($_POST['depe']) ) ? mb_strtoupper($_POST['depe'],'utf-8') : NULL ;
			$orga = ( isset($_POST['orga']) ) ? mb_strtoupper($_POST['orga'],'utf-8') : NULL ;
			$dir_e = ( isset($_POST['dir_e']) ) ? mb_strtoupper($_POST['dir_e'],'utf-8') : NULL ;
			$dir = ( isset($_POST['dir']) ) ? mb_strtoupper($_POST['dir'],'utf-8') : NULL ;
			$subdir = ( isset($_POST['subdir']) ) ? mb_strtoupper($_POST['subdir'],'utf-8') : NULL ;
			$depto = ( isset($_POST['depto']) ) ? mb_strtoupper($_POST['depto'],'utf-8') : NULL ;
			$this->sql ="INSERT INTO adscripciones(
			    id,
			    personal_id,
			    dependencia_id,
			    org_subs_id,
			    direccion_id,
			    direccion_a,
			    subdireccion,
			    departamento
			)
			VALUES
			('',:persona, :depe, :orga, :dir_e, :dir, :subdir, :depto );";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':persona', $persona, PDO::PARAM_INT );
			$this->stmt->bindParam(':depe', $depe, PDO::PARAM_INT );
			$this->stmt->bindParam(':orga', $orga, PDO::PARAM_INT );
			$this->stmt->bindParam(':dir_e', $dir_e, PDO::PARAM_INT );
			$this->stmt->bindParam(':dir', $dir, PDO::PARAM_INT );
			$this->stmt->bindParam(':subdir', $subdir, PDO::PARAM_INT );
			$this->stmt->bindParam(':depto', $depto, PDO::PARAM_INT );
			$this->stmt->execute();
			$alerta = array( 'status'=>'success','message'=>'EL SERVIDOR PÚBLICO: '.$nombre.' A SIDO REGISTRADO DE MANERA EXITOSA.' );
			return json_encode( $alerta );
		} catch (Exception $e) {
			if (strpos($e->getMessage(),'Duplicate entry') != false ) {
				return json_encode( array('status' =>'error', 'message' => $nombre.' YA EXISTE EN LA BASE DE DATOS.' ) );
			}else{
				return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
			}
			
		}
	}
	public function saveDataFUMP()
	{
		try {
			$sp_id = ( isset($_POST['sp_id']) ) ? mb_strtoupper($_POST['sp_id'],'utf-8') : false ;
			if ($sp_id == false) {
				throw new Exception("NO SE RECIBIO EL NOMBRE DEL SERVIDOR PÚBLICO", 1);
			}
			$r_tramite = ( isset($_POST['r_tramite']) ) ? mb_strtoupper($_POST['r_tramite'],'utf-8') : false ;
			$n_plaza = ( isset($_POST['n_plaza']) ) ? mb_strtoupper($_POST['n_plaza'],'utf-8') : false ;
			$t_plaza = ( isset($_POST['t_plaza']) ) ? mb_strtoupper($_POST['t_plaza'],'utf-8') : false ;
			$cod_anterior = ( isset($_POST['cod_anterior']) ) ? mb_strtoupper($_POST['cod_anterior'],'utf-8') : false ;
			$cod_actual = ( isset($_POST['cod_actual']) ) ? mb_strtoupper($_POST['cod_actual'],'utf-8') : false ;
			$vigencia_ini = ( isset($_POST['vigencia_ini']) ) ? mb_strtoupper($_POST['vigencia_ini'],'utf-8') : false ;
			$vigencia_fin = ( isset($_POST['vigencia_fin']) ) ? mb_strtoupper($_POST['vigencia_fin'],'utf-8') : false ;
			$puesto_anterior = ( isset($_POST['puesto_anterior']) ) ? mb_strtoupper($_POST['puesto_anterior'],'utf-8') : false ;
			$puesto_actual = ( isset($_POST['puesto_actual']) ) ? mb_strtoupper($_POST['puesto_actual'],'utf-8') : false ;
			$cct = ( isset($_POST['cct']) ) ? mb_strtoupper($_POST['cct'],'utf-8') : false ;
			
			#var_dump($_POST['vigencia_ini']);exit;
			$this->sql ="INSERT INTO datos_plaza(
				id, 
				personal_id, 
				nu_plaza, 
				t_plaza, 
				cod_pu_ant, 
				cod_pu_act, 
				f_ini, 
				f_fin, 
				n_pu_ant, 
				n_pu_act, 
				cct, 
				t_tramite
			) VALUES ('',
			:personal_id, 
			:nu_plaza, 
			:t_plaza, 
			:cod_pu_ant, 
			:cod_pu_act, 
			:f_ini, 
			:f_fin, 
			:n_pu_ant, 
			:n_pu_act, 
			:cct, 
			:t_tramite
			);";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':personal_id', $sp_id, PDO::PARAM_INT );
			$this->stmt->bindParam(':nu_plaza', $n_plaza, PDO::PARAM_STR );
			$this->stmt->bindParam(':t_plaza', $t_plaza, PDO::PARAM_STR );
			$this->stmt->bindParam(':cod_pu_ant', $cod_anterior, PDO::PARAM_STR );
			$this->stmt->bindParam(':cod_pu_act', $cod_actual, PDO::PARAM_STR );
			$this->stmt->bindParam(':f_ini', $vigencia_ini, PDO::PARAM_STR );
			$this->stmt->bindParam(':f_fin', $vigencia_fin, PDO::PARAM_STR );
			$this->stmt->bindParam(':n_pu_ant', $puesto_anterior, PDO::PARAM_STR );
			$this->stmt->bindParam(':n_pu_act', $puesto_actual, PDO::PARAM_STR );
			$this->stmt->bindParam(':cct', $cct, PDO::PARAM_STR );
			$this->stmt->bindParam(':t_tramite', $r_tramite, PDO::PARAM_STR );
			#$this->stmt->execute();
			#datos de la radicacion del pago 
			$mpioa = ( isset($_POST['mpioa']) ) ? mb_strtoupper($_POST['mpioa'],'utf-8') : false ;
			$mpiop = ( isset($_POST['mpiop']) ) ? mb_strtoupper($_POST['mpiop'],'utf-8') : false ;
			$lp = ( isset($_POST['lp']) ) ? mb_strtoupper($_POST['lp'],'utf-8') : false ;
			$cct_rp = ( isset($_POST['cct_rp']) ) ? mb_strtoupper($_POST['cct_rp'],'utf-8') : false ;
			$sp_rp = ( isset($_POST['sp_rp']) ) ? mb_strtoupper($_POST['sp_rp'],'utf-8') : false ;
			$b_rp = ( isset($_POST['b_rp']) ) ? mb_strtoupper($_POST['b_rp'],'utf-8') : false ;
			$tp_rp = ( isset($_POST['tp_rp']) ) ? mb_strtoupper($_POST['tp_rp'],'utf-8') : false ;
			$this->sql = "INSERT INTO radicacion_pago(
			    id,
			    personal_id,
			    mpioa,
			    mpiop,
			    lp,
			    cct,
			    sp,
			    b,
			    tp
			)
			VALUES (
			'',
			:personal_id,
		    :mpioa,
		    :mpiop,
		    :lp,
		    :cct,
		    :sp,
		    :b,
		    :tp
			);";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':personal_id', $sp_id, PDO::PARAM_INT );
			$this->stmt->bindParam(':mpioa', $mpioa, PDO::PARAM_STR );
			$this->stmt->bindParam(':mpiop', $mpiop, PDO::PARAM_STR );
			$this->stmt->bindParam(':lp', $lp, PDO::PARAM_STR );
			$this->stmt->bindParam(':cct', $cct_rp, PDO::PARAM_STR );
			$this->stmt->bindParam(':sp', $sp_rp, PDO::PARAM_STR );
			$this->stmt->bindParam(':b', $b_rp, PDO::PARAM_STR );
			$this->stmt->bindParam(':tp', $tp_rp, PDO::PARAM_STR );
			#$this->stmt->execute();
			#DATOS LABORABLES DEL SERVIDOR PÚBLICO
			$f_ingreso_gem = ( isset($_POST['f_ingreso_gem']) ) ? mb_strtoupper($_POST['f_ingreso_gem'],'utf-8') : false ;
			$antig = ( isset($_POST['antig']) ) ? mb_strtoupper($_POST['antig'],'utf-8') : false ;
			$hora_ini = ( isset($_POST['hora_ini']) ) ? mb_strtoupper($_POST['hora_ini'],'utf-8') : false ;
			$hora_fin = ( isset($_POST['hora_fin']) ) ? mb_strtoupper($_POST['hora_fin'],'utf-8') : false ;
			$r_laboral = ( isset($_POST['r_laboral']) ) ? mb_strtoupper($_POST['r_laboral'],'utf-8') : false ;
			$t_sindi = ( isset($_POST['t_sindi']) ) ? mb_strtoupper($_POST['t_sindi'],'utf-8') : false ;
			$fecha_ini = ( isset($_POST['fecha_ini']) ) ? mb_strtoupper($_POST['fecha_ini'],'utf-8') : false ;
			$fecha_fin = ( isset($_POST['fecha_fin']) ) ? mb_strtoupper($_POST['fecha_fin'],'utf-8') : false ;
			$f_egreso = ( isset($_POST['f_egreso']) ) ? mb_strtoupper($_POST['f_egreso'],'utf-8') : false ;
			$f_promocion = ( isset($_POST['f_promocion']) ) ? mb_strtoupper($_POST['f_promocion'],'utf-8') : false ;
			$cve_sp = ( isset($_POST['cve_sp']) ) ? mb_strtoupper($_POST['cve_sp'],'utf-8') : false ;
			$t_aportacion = ( isset($_POST['t_aportacion']) ) ? mb_strtoupper($_POST['t_aportacion'],'utf-8') : false ;
			$t_imp = ( isset($_POST['t_imp']) ) ? mb_strtoupper($_POST['t_imp'],'utf-8') : false ;
			$this->sql = "INSERT INTO datos_laborables_sp(
			    id,
			    persona_id,
			    f_ingreso_gem,
			    an_efe,
			    h_entrada,
			    h_salida,
			    r_laboral,
			    t_sindicato,
			    f_ini,
			    f_fin,
			    u_ingreso_gem,
			    u_promo,
			    clave_sp,
			    t_aporta,
			    t_imp
			)
			VALUES(
			'',
			:personal_id,
			:f_ingreso_gem,
			:antig,
			:hora_ini,
			:hora_fin,
			:r_laboral,
			:t_sindi,
			:fecha_ini,
			:fecha_fin,
			:f_egreso,
			:f_promocion,
			:cve_sp,
			:t_aportacion,
			:t_imp
			);";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':personal_id', $sp_id, PDO::PARAM_INT );
			$this->stmt->bindParam(':f_ingreso_gem', $f_ingreso_gem, PDO::PARAM_STR );
			$this->stmt->bindParam(':antig', $antig, PDO::PARAM_STR );
			$this->stmt->bindParam(':hora_ini', $hora_ini, PDO::PARAM_STR );
			$this->stmt->bindParam(':hora_fin', $hora_fin, PDO::PARAM_STR );
			$this->stmt->bindParam(':r_laboral', $r_laboral, PDO::PARAM_INT );
			$this->stmt->bindParam(':t_sindi', $t_sindi, PDO::PARAM_INT );
			$this->stmt->bindParam(':fecha_ini', $fecha_ini, PDO::PARAM_STR );
			$this->stmt->bindParam(':fecha_fin', $fecha_fin, PDO::PARAM_STR );
			$this->stmt->bindParam(':f_egreso', $f_egreso, PDO::PARAM_STR );
			$this->stmt->bindParam(':f_promocion', $f_promocion, PDO::PARAM_STR );
			$this->stmt->bindParam(':cve_sp', $cve_sp, PDO::PARAM_STR );
			$this->stmt->bindParam(':t_aportacion', $t_aportacion, PDO::PARAM_STR );
			$this->stmt->bindParam(':t_imp', $t_imp, PDO::PARAM_INT );
			$this->stmt->execute();
			#DATOS DEL SUSTITUIDO
			#datos de la radicacion del pago 
			$cve_issemym = ( isset($_POST['cve_issemym']) ) ? mb_strtoupper($_POST['cve_issemym'],'utf-8') : false ;
			$nombre_ds = ( isset($_POST['id_nombre_ds']) ) ? mb_strtoupper($_POST['id_nombre_ds'],'utf-8') : false ;
			$rfc_ds = ( isset($_POST['rfc_ds']) ) ? mb_strtoupper($_POST['rfc_ds'],'utf-8') : false ;
			$t_cambio = ( isset($_POST['t_cambio']) ) ? mb_strtoupper($_POST['t_cambio'],'utf-8') : false ;
			$duracion = ( isset($_POST['duracion']) ) ? mb_strtoupper($_POST['duracion'],'utf-8') : false ;
			$c_f_ini = ( isset($_POST['c_f_ini']) ) ? mb_strtoupper($_POST['c_f_ini'],'utf-8') : false ;
			$c_f_fin = ( isset($_POST['c_f_fin']) ) ? mb_strtoupper($_POST['c_f_fin'],'utf-8') : false ;
			
			$this->sql = "INSERT INTO datos_sustituido(
			    id,
			    cve_issemym,
			    personal_id,
			    rfc,
			    t_cambio,
			    duracion,
			    f_ini,
			    f_fin
			)
			VALUES (
			'',
			:cve_issemym,
		    :personal_id,
		    :rfc,
		    :t_cambio,
		    :duracion,
		    :f_ini,
		    :f_fin
			);";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':cve_issemym', $cve_issemym, PDO::PARAM_STR );
			$this->stmt->bindParam(':personal_id', $nombre_ds, PDO::PARAM_INT );
			$this->stmt->bindParam(':rfc', $rfc_ds, PDO::PARAM_STR );
			$this->stmt->bindParam(':t_cambio', $t_cambio, PDO::PARAM_INT );
			$this->stmt->bindParam(':duracion', $duracion, PDO::PARAM_INT );
			$this->stmt->bindParam(':f_ini', $c_f_ini, PDO::PARAM_STR );
			$this->stmt->bindParam(':f_fin', $c_f_fin, PDO::PARAM_STR );
			$this->stmt->execute();
			#DATOS DE LA BAJA
			$f_baja = ( isset($_POST['f_baja']) ) ? mb_strtoupper($_POST['f_baja'],'utf-8') : false ;
			$motivo = ( isset($_POST['motivo']) ) ? mb_strtoupper($_POST['motivo'],'utf-8') : false ;
			
			$this->sql = "INSERT INTO datos_baja(
			    id,
			    personal_id,
			    fecha,
			    motivo
			)
			VALUES (
			'',
			:personal_id,
			:fecha,
		    :motivo
			);";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':personal_id', $sp_id, PDO::PARAM_INT );
			$this->stmt->bindParam(':fecha', $f_baja, PDO::PARAM_STR );
			$this->stmt->bindParam(':motivo', $motivo, PDO::PARAM_INT );
			$this->stmt->execute();
			#DATOS DEL FINIQUITO
			$c_sueldo = ( isset($_POST['c_sueldo']) ) ? mb_strtoupper($_POST['c_sueldo'],'utf-8') : false ;
			$i_sueldo = ( isset($_POST['i_sueldo']) ) ? mb_strtoupper($_POST['i_sueldo'],'utf-8') : false ;
			if($c_sueldo!=false  AND $i_sueldo != false){
				$this->sql = "INSERT INTO finiquitos(
				   id,
				   personal_id,
				   concepto,
				   clave,
				   importe
				)
				VALUES (
				'',
				:personal_id,
				'SUELDO',
			    :clave,
			    :importe
				);";
				$this->stmt = $this->pdo->prepare($this->sql);
				$this->stmt->bindParam(':personal_id', $sp_id, PDO::PARAM_INT );
				$this->stmt->bindParam(':clave', $c_sueldo, PDO::PARAM_STR );
				$this->stmt->bindParam(':importe', $i_sueldo, PDO::PARAM_STR );
				$this->stmt->execute();
			}
			$c_prima = ( isset($_POST['c_prima']) ) ? mb_strtoupper($_POST['c_prima'],'utf-8') : false ;
			$i_prima = ( isset($_POST['i_prima']) ) ? mb_strtoupper($_POST['i_prima'],'utf-8') : false ;
			if($c_prima!=false  AND $i_prima != false){
				$this->sql = "INSERT INTO finiquitos(
				   id,
				   personal_id,
				   concepto,
				   clave,
				   importe
				)
				VALUES (
				'',
				:personal_id,
				'PRIMA POR PREM. EN EL SERVICIO',
			    :clave,
			    :importe
				);";
				$this->stmt = $this->pdo->prepare($this->sql);
				$this->stmt->bindParam(':personal_id', $sp_id, PDO::PARAM_INT );
				$this->stmt->bindParam(':clave', $c_sueldo, PDO::PARAM_STR );
				$this->stmt->bindParam(':importe', $i_sueldo, PDO::PARAM_STR );
				$this->stmt->execute();
			}
			$c_primav = ( isset($_POST['c_primav']) ) ? mb_strtoupper($_POST['c_primav'],'utf-8') : false ;
			$i_primav = ( isset($_POST['i_primav']) ) ? mb_strtoupper($_POST['i_primav'],'utf-8') : false ;
			if($c_primav!=false  AND $i_primav != false){
				$this->sql = "INSERT INTO finiquitos(
				   id,
				   personal_id,
				   concepto,
				   clave,
				   importe
				)
				VALUES (
				'',
				:personal_id,
				'PRIMA VACACIONAL',
			    :clave,
			    :importe
				);";
				$this->stmt = $this->pdo->prepare($this->sql);
				$this->stmt->bindParam(':personal_id', $sp_id, PDO::PARAM_INT );
				$this->stmt->bindParam(':clave', $c_primav, PDO::PARAM_STR );
				$this->stmt->bindParam(':importe', $i_primav, PDO::PARAM_STR );
				$this->stmt->execute();
			}
			$c_aguinaldo = ( isset($_POST['c_aguinaldo']) ) ? mb_strtoupper($_POST['c_aguinaldo'],'utf-8') : false ;
			$i_aguinaldo = ( isset($_POST['i_aguinaldo']) ) ? mb_strtoupper($_POST['i_aguinaldo'],'utf-8') : false ;
			if($c_aguinaldo!=false  AND $i_aguinaldo != false){
				$this->sql = "INSERT INTO finiquitos(
				   id,
				   personal_id,
				   concepto,
				   clave,
				   importe
				)
				VALUES (
				'',
				:personal_id,
				'AGUINALDO PROPORCIONAL',
			    :clave,
			    :importe
				);";
				$this->stmt = $this->pdo->prepare($this->sql);
				$this->stmt->bindParam(':personal_id', $sp_id, PDO::PARAM_INT );
				$this->stmt->bindParam(':clave', $c_aguinaldo, PDO::PARAM_STR );
				$this->stmt->bindParam(':importe', $i_aguinaldo, PDO::PARAM_STR );
				$this->stmt->execute();
			}
			$c_otro = ( isset($_POST['c_otro']) ) ? mb_strtoupper($_POST['c_otro'],'utf-8') : false ;
			$i_otro = ( isset($_POST['i_otro']) ) ? mb_strtoupper($_POST['i_otro'],'utf-8') : false ;
			if($c_otro!=false  AND $i_otro != false){
				$this->sql = "INSERT INTO finiquitos(
				   id,
				   personal_id,
				   concepto,
				   clave,
				   importe
				)
				VALUES (
				'',
				:personal_id,
				'OTRO',
			    :clave,
			    :importe
				);";
				$this->stmt = $this->pdo->prepare($this->sql);
				$this->stmt->bindParam(':personal_id', $sp_id, PDO::PARAM_INT );
				$this->stmt->bindParam(':clave', $c_otro, PDO::PARAM_STR );
				$this->stmt->bindParam(':importe', $i_otro, PDO::PARAM_STR );
				$this->stmt->execute();
			}
			$suma_a = ( isset($_POST['suma_a']) ) ? mb_strtoupper($_POST['suma_a'],'utf-8') : false ;
			if($suma_a!=false  ){
				$this->sql = "INSERT INTO finiquitos(
				   id,
				   personal_id,
				   concepto,
				   clave,
				   importe
				)
				VALUES (
				'',
				:personal_id,
				'SUMA A',
			    'N/A',
			    :importe
				);";
				$this->stmt = $this->pdo->prepare($this->sql);
				$this->stmt->bindParam(':personal_id', $sp_id, PDO::PARAM_INT );
				$this->stmt->bindParam(':importe', $i_sueldo, PDO::PARAM_STR );
				$this->stmt->execute();
			}
			$c_pagoi = ( isset($_POST['c_pagoi']) ) ? mb_strtoupper($_POST['c_pagoi'],'utf-8') : false ;
			$i_pagoi = ( isset($_POST['i_pagoi']) ) ? mb_strtoupper($_POST['i_pagoi'],'utf-8') : false ;
			if($c_pagoi!=false  AND $i_pagoi != false){
				$this->sql = "INSERT INTO finiquitos(
				   id,
				   personal_id,
				   concepto,
				   clave,
				   importe
				)
				VALUES (
				'',
				:personal_id,
				'PAGO IMPROCEDENTE',
			    :clave,
			    :importe
				);";
				$this->stmt = $this->pdo->prepare($this->sql);
				$this->stmt->bindParam(':personal_id', $sp_id, PDO::PARAM_INT );
				$this->stmt->bindParam(':clave', $c_pagoi, PDO::PARAM_STR );
				$this->stmt->bindParam(':importe', $i_pagoi, PDO::PARAM_STR );
				$this->stmt->execute();
			}
			$c_prestamo = ( isset($_POST['c_prestamo']) ) ? mb_strtoupper($_POST['c_prestamo'],'utf-8') : false ;
			$i_prestamo = ( isset($_POST['i_prestamo']) ) ? mb_strtoupper($_POST['i_prestamo'],'utf-8') : false ;
			if($c_prestamo!=false  AND $i_prestamo != false){
				$this->sql = "INSERT INTO finiquitos(
				   id,
				   personal_id,
				   concepto,
				   clave,
				   importe
				)
				VALUES (
				'',
				:personal_id,
				'PAGO IMPROCEDENTE',
			    :clave,
			    :importe
				);";
				$this->stmt = $this->pdo->prepare($this->sql);
				$this->stmt->bindParam(':personal_id', $sp_id, PDO::PARAM_INT );
				$this->stmt->bindParam(':clave', $c_prestamo, PDO::PARAM_STR );
				$this->stmt->bindParam(':importe', $i_prestamo, PDO::PARAM_STR );
				$this->stmt->execute();
			}
			$c_otros = ( isset($_POST['c_otros']) ) ? mb_strtoupper($_POST['c_otros'],'utf-8') : false ;
			$i_otros = ( isset($_POST['i_otros']) ) ? mb_strtoupper($_POST['i_otros'],'utf-8') : false ;
			if($c_otros!=false  AND $i_otros != false){
				$this->sql = "INSERT INTO finiquitos(
				   id,
				   personal_id,
				   concepto,
				   clave,
				   importe
				)
				VALUES (
				'',
				:personal_id,
				'PAGO IMPROCEDENTE',
			    :clave,
			    :importe
				);";
				$this->stmt = $this->pdo->prepare($this->sql);
				$this->stmt->bindParam(':personal_id', $sp_id, PDO::PARAM_INT );
				$this->stmt->bindParam(':clave', $c_otros, PDO::PARAM_STR );
				$this->stmt->bindParam(':importe', $i_otros, PDO::PARAM_STR );
				$this->stmt->execute();
			}
			
			#TOTAL NETO 
			$t_neto = ( isset($_POST['t_neto']) ) ? mb_strtoupper($_POST['t_neto'],'utf-8') : false ;
			if($t_neto!=false  ){
				$this->sql = "INSERT INTO finiquitos(
				   id,
				   personal_id,
				   concepto,
				   clave,
				   importe
				)
				VALUES (
				'',
				:personal_id,
				'TOTAL NETO',
			    'N/A',
			    :importe
				);";
				$this->stmt = $this->pdo->prepare($this->sql);
				$this->stmt->bindParam(':personal_id', $sp_id, PDO::PARAM_INT );
				$this->stmt->bindParam(':importe', $t_neto, PDO::PARAM_STR );
				$this->stmt->execute();
			}
			#DATOS DE LICENCIA
			$goce_s = ( isset($_POST['goce_s']) ) ? mb_strtoupper($_POST['goce_s'],'utf-8') : false ;
			$edo_licencia = ( isset($_POST['edo_licencia']) ) ? mb_strtoupper($_POST['edo_licencia'],'utf-8') : false ;
			$f_ini_lic = ( isset($_POST['f_ini_lic']) ) ? mb_strtoupper($_POST['f_ini_lic'],'utf-8') : false ;
			$f_fin_lic = ( isset($_POST['f_fin_lic']) ) ? mb_strtoupper($_POST['f_fin_lic'],'utf-8') : false ;
			$motivo = ( isset($_POST['motivo']) ) ? mb_strtoupper($_POST['motivo'],'utf-8') : false ;

			$this->sql = "INSERT INTO licencias(
			    id,
			    personal_id,
			    goce_sueldo,
			    estado,
			    f_inicio,
			    f_fin,
			    motivo
			)
			VALUES(
				'',
				:personal_id,
				:goce_sueldo,
				:estado,
				:f_inicio,
				:f_fin,
				:motivo
			);";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':personal_id', $sp_id, PDO::PARAM_INT );
			$this->stmt->bindParam(':goce_sueldo', $goce_s, PDO::PARAM_INT );
			$this->stmt->bindParam(':estado', $edo_licencia, PDO::PARAM_INT );
			$this->stmt->bindParam(':f_inicio', $f_ini_lic, PDO::PARAM_STR );
			$this->stmt->bindParam(':f_fin', $f_fin_lic, PDO::PARAM_STR );
			$this->stmt->bindParam(':motivo', $motivo, PDO::PARAM_STR );
			$this->stmt->execute();
			#DATOS DE LAS PENSIONES 
			$t_movi_pen = ( isset($_POST['t_movi_pen']) ) ? mb_strtoupper($_POST['t_movi_pen'],'utf-8') : false ;
			$quincena_pension = ( isset($_POST['quincena_pension']) ) ? mb_strtoupper($_POST['quincena_pension'],'utf-8') : false ;
			$year = ( isset($_POST['year']) ) ? mb_strtoupper($_POST['year'],'utf-8') : false ;
			$beneficiario = ( isset($_POST['beneficiario']) ) ? mb_strtoupper($_POST['beneficiario'],'utf-8') : false ;
			$rfc_beneficiario = ( isset($_POST['rfc_beneficiario']) ) ? mb_strtoupper($_POST['rfc_beneficiario'],'utf-8') : false ;
			$importe = ( isset($_POST['importe']) ) ? mb_strtoupper($_POST['importe'],'utf-8') : false ;
			$porcentaje = ( isset($_POST['porcentaje']) ) ? mb_strtoupper($_POST['porcentaje'],'utf-8') : false ;

			$this->sql = "INSERT INTO pensiones(
			    id,
			    personal_id,
			    t_movimiento,
			    quincena_id,
			    anio,
			    beneficiario,
			    rfc,
			    descuento,
			    porcentaje
			)
			VALUES(
				'',
				:personal_id,
			    :t_movimiento,
			    :quincena_id,
			    :anio,
			    :beneficiario,
			    :rfc,
			    :descuento,
			    :porcentaje
			);";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':personal_id', $sp_id, PDO::PARAM_INT );
			$this->stmt->bindParam(':t_movimiento', $t_movi_pen, PDO::PARAM_INT );
			$this->stmt->bindParam(':quincena_id', $quincena_pension, PDO::PARAM_INT );
			$this->stmt->bindParam(':anio', $year, PDO::PARAM_STR );
			$this->stmt->bindParam(':beneficiario', $beneficiario, PDO::PARAM_STR );
			$this->stmt->bindParam(':rfc', $rfc_beneficiario, PDO::PARAM_STR );
			$this->stmt->bindParam(':descuento', $importe, PDO::PARAM_STR );
			$this->stmt->bindParam(':porcentaje', $porcentaje, PDO::PARAM_STR );
			$this->stmt->execute();
			$alerta = array( 'status'=>'success','message'=>'DATOS COMPLEMENTARIOS DEL FORMATO ÚNICO DE MOVIMIENTO DE PERSONAL A SIDO GUARDADO DE MANERA EXITOSA.' );
			return json_encode( $alerta );
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	public function get_CVE_RFC()
	{
		try {
			$id = ( isset($_POST['id']) ) ? $_POST['id'] : false ;
			
			$this->sql ="SELECT id, rfc ,issemym FROM personal WHERE id = ?";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(1, $id, PDO::PARAM_INT );
			$this->stmt->execute();
			$this->result = $this->stmt->fetch(PDO::FETCH_OBJ);
			return json_encode( $this->result );
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	public function saveEntrada()
	{
		try {
			$dia_e = ( isset($_POST['dia_e']) ) ? $_POST['dia_e'] : false ;
			$quincena_e = ( isset($_POST['quincena_e']) ) ? $_POST['quincena_e'] : false ;
			$this->sql ="INSERT INTO registro_es(
			    id,
			    personal_id,
			    f_asistencia,
			    quincena_id,
			    h_entrada,
			    h_salida
			)
			VALUES (
			'',
			:personal_id,
		    :f_asistencia,
		    :quincena_id,
		    :h_entrada,
		    NULL
			);";
			for ($i=0; $i < count($_POST['sp_id']) ; $i++) {
				$sp = $_POST['sp_id'][$i]; 
				$he = $_POST['hora_e'][$i]; 
				$this->stmt = $this->pdo->prepare($this->sql);
				$this->stmt->bindParam(':personal_id', $sp, PDO::PARAM_INT );
				$this->stmt->bindParam(':f_asistencia', $dia_e, PDO::PARAM_STR );
				$this->stmt->bindParam(':quincena_id', $quincena_e, PDO::PARAM_INT );
				$this->stmt->bindParam(':h_entrada', $he, PDO::PARAM_STR);
				$this->stmt->execute();
			}
			$alerta = array( 'status'=>'success','message'=>'REGISTRO DE ENTRADA GUARDADO DE MANERA EXITOSA.' );
			return json_encode( $alerta );
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	public function saveSalida()
	{
		try {
			$dia_s = ( isset($_POST['dia_s']) ) ? $_POST['dia_s'] : false ;
			$quincena_s = ( isset($_POST['quincena_s']) ) ? $_POST['quincena_s'] : false ;
			#Buscar el registro
			$this->sql ="UPDATE registro_es  SET 
			    h_salida = :h_salida
			    WHERE personal_id  = :personal_id AND f_asistencia = :dia_s AND quincena_id = :quincena_s
			";
			for ($i=0; $i < count($_POST['sp_id_s']) ; $i++) {
				$sp = $_POST['sp_id_s'][$i]; 
				$hs = $_POST['hora_s'][$i];

				$this->stmt = $this->pdo->prepare($this->sql);
				$this->stmt->bindParam(':h_salida', $hs, PDO::PARAM_STR);
				$this->stmt->bindParam(':personal_id', $sp, PDO::PARAM_INT );
				$this->stmt->bindParam(':dia_s', $dia_s, PDO::PARAM_STR );
				$this->stmt->bindParam(':quincena_s', $quincena_s, PDO::PARAM_INT );
				$this->stmt->execute();
			}
			
			$alerta = array( 'status'=>'success','message'=>'REGISTRO DE SALIDA GUARDADO DE MANERA EXITOSA.' );
			return json_encode( $alerta );
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	public function getRegistroAsistencia($quincena,$personal)
	{
		try {
			$this->sql = "SELECT * FROM registro_es WHERE quincena_id = :quincena AND personal_id = :personal";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':personal',$personal,PDO::PARAM_INT);
			$this->stmt->bindParam(':quincena',$quincena,PDO::PARAM_INT);
			$this->stmt->execute();
			$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}

	//Registro de entrada y salida por servidor publico 
	public function getRegistroSP()
	{
		try {
			$anexgrid = new AnexGrid();
			$wh = "";
			foreach ($anexgrid->filtros as $filter) {
				if ( $filter['columna'] != '' ) {
					if ( $filter['columna'] == 'q.cve_ref' || $filter['columna'] == 'q.cve_exp' ) {
						$wh .= " AND ".$filter['columna']." LIKE '%".$filter['valor']."%'";
					}
				}
			}
			foreach ($anexgrid->parametros as $key => $p) {
				$wh .= " AND r.quincena_id = ".$p['q'];
			}
			$this->sql = "
			SELECT p.id, CONCAT(p.nombre,' ',p.ap_pat,' ',p.ap_mat) AS full_name, 
			r.h_entrada, r.h_salida, r.f_asistencia 
			FROM personal AS p 
			INNER JOIN registro_es AS r 
				ON r.personal_id = p.id 
			WHERE 1=1 $wh 
			ORDER BY p.$anexgrid->columna $anexgrid->columna_orden 
			LIMIT $anexgrid->pagina , $anexgrid->limite";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->execute();
			$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			
			$total = 0;
			$this->sql = "SELECT count(*) as total
			FROM personal AS p 
			INNER JOIN registro_es AS r 
				ON r.personal_id = p.id 
			WHERE 1=1 $wh";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->execute();
			$total = $this->stmt->fetch(PDO::FETCH_OBJ)->total;
			return $anexgrid->responde($this->result,$total);
		} catch (Exception $e) {
			return json_encode( array('status'=>'error','message'=>$e->getMessage()) );
		}
	}
	public function getPerDedBySP()
	{
		try {
			$conceptos = array();
			$sp_id = $_POST['sp_id'];
			#recuperar las percepciones 
			$this->sql = "
			SELECT
			    pd.nombre,
			    pd.id AS id_pd,
			    pd.monto,
			    pd.porcentaje,
			    pd.cve_int,
			    pd.cve_ext,
			    CONCAT(
			        p.nombre,
			        ' ',
			        p.ap_pat,
			        ' ',
			        p.ap_mat
			    ) AS full_name
			FROM
			    percepciones_sp AS psp
			INNER JOIN per_ded AS pd
			ON
			    pd.id = psp.percepcion_id
			INNER JOIN personal AS p
			ON
			    p.id = psp.personal_id
			WHERE
			    psp.personal_id = :sp_id
			";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':sp_id',$sp_id,PDO::PARAM_INT);
			$this->stmt->execute();
			$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			$conceptos['percepciones'] = $this->result;
			#recuperar las percepciones 
			$this->sql = "
			SELECT
			    pd.nombre,
			    pd.id AS id_pd,
			    pd.monto,
			    pd.porcentaje,
			    pd.cve_int,
			    pd.cve_ext,
			    CONCAT(
			        p.nombre,
			        ' ',
			        p.ap_pat,
			        ' ',
			        p.ap_mat
			    ) AS full_name
			FROM
			    deducciones_sp AS psp
			INNER JOIN per_ded AS pd
			ON
			    pd.id = psp.deduccion_id
			INNER JOIN personal AS p
			ON
			    p.id = psp.personal_id
			WHERE
			    psp.personal_id = :sp_id
			";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':sp_id',$sp_id,PDO::PARAM_INT);
			$this->stmt->execute();
			$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			$conceptos['deducciones'] = $this->result;
			
			return json_encode($conceptos);
		} catch (Exception $e) {
			return json_encode( array('status'=>'error','message'=>$e->getMessage()) );
		}
	}
	public function savePD()
	{
		try {
			$nombre	= (isset($_POST['n_concepto'])) ? mb_strtoupper($_POST['n_concepto']) : NULL ;	
			$tipo	= (isset($_POST['concepto'])) ? mb_strtoupper($_POST['concepto']) : NULL ;	
			$monto	= (isset($_POST['monto'])) ? mb_strtoupper($_POST['monto']) : NULL ;	
			$porce	= (empty($_POST['percent'])) ? mb_strtoupper($_POST['percent']) : NULL ;	
			$ci		= (isset($_POST['cve_int'])) ? mb_strtoupper($_POST['cve_int']) : NULL ;
			$ce		= (isset($_POST['cve_ext'])) ? mb_strtoupper($_POST['cve_ext']) : NULL ;
			$this->sql = "INSERT INTO per_ded (id, nombre, tipo, monto, porcentaje, cve_int, cve_ext) 
			VALUES ('', :nombre, :tipo, :monto, :porce, :ci, :ce);";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':nombre',$nombre,PDO::PARAM_STR);
			$this->stmt->bindParam(':tipo',$tipo,PDO::PARAM_INT);
			$this->stmt->bindParam(':monto',$monto,PDO::PARAM_STR);
			$this->stmt->bindParam(':porce',$porce,PDO::PARAM_INT|PDO::PARAM_BOOL);
			$this->stmt->bindParam(':ci',$ci,PDO::PARAM_STR);
			$this->stmt->bindParam(':ce',$ce,PDO::PARAM_STR);
			$this->stmt->execute();
			$alerta = array( 'status'=>'success','message'=>'EL REGISTRO A SIDO GUARDADO DE MANERA EXITOSA.' );
			return json_encode( $alerta );
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	public function saveRegla()
	{
		try {
			$t_concepto	= (!empty($_POST['t_concepto'])) ? mb_strtoupper($_POST['t_concepto']) : NULL ;	
			if ( $t_concepto == '1' ) {
				$this->sql = "INSERT INTO percepciones_sp(
				    id,
				    percepcion_id,
				    personal_id,
				    importe,
				    n_quin,
				    f_ini,
				    f_fin
				) VALUES (
					'',
					:concepto,
					:personal_id,
					:importe,
					:n_quin,
					:f_ini,
					:f_fin
				);
				";
			}elseif ( $t_concepto == '2' ) {
				$this->sql = "INSERT INTO deducciones_sp(
				    id,
				    deduccion_id,
				    personal_id,
				    importe,
				    n_quin,
				    f_ini,
				    f_fin
				) VALUES (
					'',
					:concepto,
					:personal_id,
					:importe,
					:n_quin,
					:f_ini,
					:f_fin
				);";
			}else{
				throw new Exception("EL TIPO DE CONCEPTO (PERCEPCIÓN O DEDUCCIÓN) NO ESTA DEFINIDO.", 1);
			}
			$sp_id	= (isset($_POST['sp_id'])) ? mb_strtoupper($_POST['sp_id']) : NULL ;	
			$num_quin	= (isset($_POST['num_quin'])) ? mb_strtoupper($_POST['num_quin']) : NULL ;	
			$f_ini	= (isset($_POST['f_ini'])) ? mb_strtoupper($_POST['f_ini']) : NULL ;	
			$f_fin	= (isset($_POST['f_fin'])) ? mb_strtoupper($_POST['f_fin']) : NULL ;	
			$concepto	= (isset($_POST['concepto'])) ? mb_strtoupper($_POST['concepto']) : NULL ;	
			$importe	= (isset($_POST['importe'])) ? mb_strtoupper($_POST['importe']) : NULL ;	
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':concepto',$concepto,PDO::PARAM_INT);
			$this->stmt->bindParam(':personal_id',$sp_id,PDO::PARAM_INT);
			$this->stmt->bindParam(':importe',$importe,PDO::PARAM_STR);
			$this->stmt->bindParam(':n_quin',$num_quin,PDO::PARAM_INT);
			$this->stmt->bindParam(':f_ini',$f_ini,PDO::PARAM_STR);
			$this->stmt->bindParam(':f_fin',$f_fin,PDO::PARAM_STR);
			$this->stmt->execute();
			$alerta = array( 'status'=>'success','message'=>'EL REGISTRO A SIDO GUARDADO DE MANERA EXITOSA.' );
			return json_encode( $alerta );
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	public function getNamePD($pd=null)#Recuperar el nombre de la percepcion o deduccion
	{
		try {
			if (is_null($pd)) {
				throw new Exception("A OCURRIDO UN ERROR!", 1);				
			}
			$this->sql = "SELECT *  FROM  per_ded WHERE id = :id ";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':id',$pd, PDO::PARAM_INT);
			$this->stmt->execute();
			$this->result = $this->stmt->fetch(PDO::FETCH_OBJ);
			return $this->result;
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
}
?>