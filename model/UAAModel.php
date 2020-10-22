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

			$this->sql = "SELECT p.*,CONCAT(nr.clave, ' - ',nr.nombre) AS nivel_rango,
			(YEAR(NOW())-YEAR(d.f_ingreso_gem)) AS y_ser, d.t_sindicato,
			a.nombre AS direccion, a2.nombre AS subdireccion,a3.nombre AS departamento
			FROM personal AS p
			LEFT JOIN niveles_rangos AS nr ON nr.id = p.nivel 	
			LEFT JOIN datos_laborables_sp AS d ON d.persona_id = p.id
			LEFT JOIN adscripciones AS ad ON ad.personal_id = p.id
			LEFT JOIN areas AS a ON a.id = ad.direccion_a
			LEFT JOIN areas AS a2 ON a2.id = ad.subdireccion
			LEFT JOIN areas AS a3 ON a3.id = ad.departamento
			WHERE 1=1 $wh ORDER BY p.$anexgrid->columna $anexgrid->columna_orden LIMIT $anexgrid->pagina , $anexgrid->limite";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->execute();
			$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			$total = 0;
			$this->sql = "SELECT COUNT(*) AS total FROM personal AS p 
			LEFT JOIN niveles_rangos AS nr ON nr.id = p.nivel 	
			LEFT JOIN datos_laborables_sp AS d ON d.persona_id = p.id
			LEFT JOIN adscripciones AS ad ON ad.personal_id = p.id
			LEFT JOIN areas AS a ON a.id = ad.direccion_a
			LEFT JOIN areas AS a2 ON a2.id = ad.subdireccion
			LEFT JOIN areas AS a3 ON a3.id = ad.departamento
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
			
			$this->sql = "SELECT * FROM personal WHERE estado =1";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->execute();
			$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			
			return json_encode($this->result);
		} catch (Exception $e) {
			return json_encode( array('status'=>'error','message'=>$e->getMessage()) );
		}
	}
	public function getItemTabulador($pm)
	{
		try {
			
			$this->sql = "SELECT * FROM tabulador_dof WHERE :pm >= limite_inf1   AND :pm <= limite_sup";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':pm',$pm,PDO::PARAM_STR);
			$this->stmt->execute();
			$this->result = $this->stmt->fetch(PDO::FETCH_OBJ);
			return $this->result;
		} catch (Exception $e) {
			return json_encode( array('status'=>'error','message'=>$e->getMessage()) );
		}
	}
	
	public function saveJustificante()
	{
		try {
			$registro_id = ( isset($_POST['registro_id']) ) ? mb_strtoupper($_POST['registro_id'],'utf-8') : false ;
			$this->sql = "SELECT * FROM justificantes WHERE r_id = :id ";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':id',$registro_id,PDO::PARAM_INT);
			$this->stmt->execute();
			if ( $this->stmt->rowCount() > 0 ) {
				throw new Exception("YA EXISTE UN JUSTIFICANTE", 1);				
			}

			$asunto = ( isset($_POST['asunto']) ) ? mb_strtoupper($_POST['asunto'],'utf-8') : false ;
			$comentario = ( isset($_POST['comentario']) ) ? mb_strtoupper($_POST['comentario'],'utf-8') : false ;
			if ( !empty($_FILES['file']['name']) ) {
		    	if ( $_FILES['file']['error'] > 0 ) {
		    		throw new Exception("DEBE DE SELECCIONAR UN DOCUMENTO.", 1);
		    	}
		    	if ( $_FILES['file']['size'] > 10485760 ) {
		    		throw new Exception("EL DOCUMENTO EXCEDE EL TAMAÑO DE ARCHIVO ADMITIDO.", 1);	
		    	}
		    	if ( $_FILES['file']['type'] != 'application/pdf' ) {
		    		throw new Exception("EL FORMATO DE ARCHIVO NO ES ADMITIDO (SOLO PDF). ", 1);
		    	}
		    	#Recuperar las variables necesarias
		    	$name = $_FILES['file']['name'];
		    	$type = $_FILES['file']['type'];
		    	$size = $_FILES['file']['size'];
		    	$destino  = $_SERVER['DOCUMENT_ROOT'].'/nomina/uploads/';
		    	#Mover el Doc
		    	move_uploaded_file($_FILES['file']['tmp_name'],$destino.$name);
		    	#abrir el archivo
		    	$file 		= fopen($destino.$name,'r');
		    	$content 	= fread($file, $size);
		    	$content 	= addslashes($content);
		    	fclose($file);
		    	#Eliminar  el archivo 
		    	unlink($_SERVER['DOCUMENT_ROOT'].'/nomina/uploads/'.$name);		# code...
		    }else{
		    	throw new Exception("DEBE DE SELECCIONAR UN EXPEDIENTE", 1);
		    }
		    
			$this->sql = "INSERT INTO  justificantes (id, r_id, asunto, comentario, file) VALUES ('', :r_id,  :asunto, :comentario, :file);";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':r_id',$registro_id,PDO::PARAM_INT);
			$this->stmt->bindParam(':asunto',$asunto,PDO::PARAM_STR);
			$this->stmt->bindParam(':comentario',$comentario,PDO::PARAM_STR);
			$this->stmt->bindParam(':file',$content,PDO::PARAM_LOB);
			$this->stmt->execute();
			$this->sql = "UPDATE  registro_es SET justificado = 1 WHERE id = :id";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':id',$registro_id,PDO::PARAM_INT);
			$this->stmt->execute();
			return json_encode( array('status'=>'success','message'=>'JUSTIFICANTE GUARDADO DE MANERA EXITOSA.') );
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
	public function savePagoGlobal()
	{
		try {
			$personal 	= json_decode($this->getPersonalBy());
			$info_quincena = json_decode($this->getInfoQuincena($_POST['quincena']));
			$quincena 	= $_POST['quincena'];
			
			$y = date('Y');
			
			foreach ($personal as $key => $p) {
				$sp = $p->id;
				#validar que la quincena aun no se haya pagado
				$this->sql = "SELECT COUNT(id) AS cuenta FROM percepciones_sp WHERE personal_id = :sp AND year = :y AND quincena = :q GROUP BY id ";
				$this->stmt = $this->pdo->prepare($this->sql);
				$this->stmt->bindParam(':sp', $sp, PDO::PARAM_INT);
				$this->stmt->bindParam(':y', $y, PDO::PARAM_INT);
				$this->stmt->bindParam(':q', $quincena, PDO::PARAM_INT);
				$this->stmt->execute();
				
				if ($this->stmt->rowCount() > 0 ) {
					#throw new Exception("LA QUINCENA YA HA SIDO PAGADA.", 1);
					$this->sql = "DELETE FROM percepciones_sp WHERE personal_id = :sp AND quincena = :q AND year = :y ";
					$this->stmt = $this->pdo->prepare($this->sql);
					$this->stmt->bindParam(':sp', $sp, PDO::PARAM_INT);
					$this->stmt->bindParam(':y', $y, PDO::PARAM_INT);
					$this->stmt->bindParam(':q', $quincena, PDO::PARAM_INT);
					$this->stmt->execute();
				}
				$this->sql = "SELECT COUNT(id) AS cuenta FROM deducciones_sp WHERE personal_id = :sp AND year = :y AND quincena = :q GROUP BY id ";
				$this->stmt = $this->pdo->prepare($this->sql);
				$this->stmt->bindParam(':sp', $sp, PDO::PARAM_INT);
				$this->stmt->bindParam(':y', $y, PDO::PARAM_INT);
				$this->stmt->bindParam(':q', $quincena, PDO::PARAM_INT);
				$this->stmt->execute();
				if ($this->stmt->rowCount() > 0) {
					$this->sql = "DELETE FROM deducciones_sp WHERE personal_id = :sp AND quincena = :q AND year = :y ";
					$this->stmt = $this->pdo->prepare($this->sql);
					$this->stmt->bindParam(':sp', $sp, PDO::PARAM_INT);
					$this->stmt->bindParam(':y', $y, PDO::PARAM_INT);
					$this->stmt->bindParam(':q', $quincena, PDO::PARAM_INT);
					$this->stmt->execute();
				}

				$reglas 	= $this->getReglasArray($sp);
				$total = 0;	$suma_isr = 0;
				foreach ($reglas as $key => $r) {
					if (is_null($r->f_ini) && is_null($r->f_fin)){
						if ($r->tipo_pd == 'PERCEPCION') {
							$this->sql ="INSERT INTO percepciones_sp (
								id,
							    percepcion_id,
							    personal_id,
							    importe,
							    quincena,
							    year
							) VALUES (
								'',
								:pd,
								:sp,
								:importe,
								:q,
								:y
							)";
							$this->stmt = $this->pdo->prepare($this->sql);
							$this->stmt->bindParam(':pd', $r->pd_id, PDO::PARAM_INT);
							$this->stmt->bindParam(':sp', $sp, PDO::PARAM_INT);
							$this->stmt->bindParam(':importe', $r->monto, PDO::PARAM_STR);
							$this->stmt->bindParam(':q', $quincena, PDO::PARAM_INT);
							$this->stmt->bindParam(':y', $y, PDO::PARAM_INT);
							$this->stmt->execute();
							
						}elseif($r->tipo_pd == 'DEDUCCION'){
							$this->sql ="INSERT INTO deducciones_sp (
							id,
						    deduccion_id,
						    personal_id,
						    importe,
						    quincena,
						    year
							) VALUES (
							'',
							:pd,
							:sp,
							:importe,
							:q,
							:y
							)";
							$this->stmt = $this->pdo->prepare($this->sql);
							$this->stmt->bindParam(':pd', $r->pd_id, PDO::PARAM_INT);
							$this->stmt->bindParam(':sp', $sp, PDO::PARAM_INT);
							$this->stmt->bindParam(':importe', $r->monto, PDO::PARAM_STR);
							$this->stmt->bindParam(':q', $quincena, PDO::PARAM_INT);
							$this->stmt->bindParam(':y', $y, PDO::PARAM_INT);
							$this->stmt->execute();
						}
					}elseif ( (( $info_quincena->fecha_ini >= $r->f_ini ) && ($info_quincena->fecha_fin <= $r->f_fin)) ){
						if ($r->tipo_pd == 'PERCEPCION') {
							$this->sql ="INSERT INTO percepciones_sp (
							id,
						    percepcion_id,
						    personal_id,
						    importe,
						    quincena,
						    year
							) VALUES (
							'',
							:pd,
							:sp,
							:importe,
							:q,
							:y
							)";
							$this->stmt = $this->pdo->prepare($this->sql);
							$this->stmt->bindParam(':pd', $r->pd_id, PDO::PARAM_INT);
							$this->stmt->bindParam(':sp', $sp, PDO::PARAM_INT);
							$this->stmt->bindParam(':importe', $r->monto, PDO::PARAM_STR);
							$this->stmt->bindParam(':q', $quincena, PDO::PARAM_INT);
							$this->stmt->bindParam(':y', $y, PDO::PARAM_INT);
							$this->stmt->execute();
							
						}elseif($r->tipo_pd == 'DEDUCCION'){
							$this->sql ="INSERT INTO deducciones_sp (
							id,
						    deduccion_id,
						    personal_id,
						    importe,
						    quincena,
						    year
							) VALUES (
							'',
							:pd,
							:sp,
							:importe,
							:q,
							:y
							)";
							$this->stmt = $this->pdo->prepare($this->sql);
							$this->stmt->bindParam(':pd', $r->pd_id, PDO::PARAM_INT);
							$this->stmt->bindParam(':sp', $sp, PDO::PARAM_INT);
							$this->stmt->bindParam(':importe', $r->monto, PDO::PARAM_STR);
							$this->stmt->bindParam(':q', $quincena, PDO::PARAM_INT);
							$this->stmt->bindParam(':y', $y, PDO::PARAM_INT);
							$this->stmt->execute();
						}
					}
					if ( $r->g_isr == 'SI' ) {
						$suma_isr += $r->monto;
					}
				}
				$this->sql ="INSERT INTO deducciones_sp (
					id,
				    deduccion_id,
				    personal_id,
				    importe,
				    quincena,
				    year
				) VALUES (
					'',
					2,
					:sp,
					:importe,
					:q,
					:y
				)";
				$calc = new CalculadoraModel;
				$monto_isr = $calc->getISR($suma_isr);
				$this->stmt = $this->pdo->prepare($this->sql);
				$this->stmt->bindParam(':sp', $sp, PDO::PARAM_INT);
				$this->stmt->bindParam(':importe', $monto_isr, PDO::PARAM_STR);
				$this->stmt->bindParam(':q', $quincena, PDO::PARAM_INT);
				$this->stmt->bindParam(':y', $y, PDO::PARAM_INT);
				$this->stmt->execute();
			}
			
			return json_encode( array('status'=>'success','message'=>'LA QUINCENA SELECCIONADA A SIDO PAGADA A TODO EL PERSONAL DE MANERA EXITOSA') );
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
						if ( isset($_POST['tipo']) || !empty($_POST['tipo']) ) {
							$wh = " AND tipo = ".$_POST['tipo'];
						}else if ( isset($_POST['e']) || !empty($_POST['e']) ) {
							$wh = " AND tipo = ".$_POST['e'];
						}
					}
					
				}
			}elseif ($catalogo == 'direcciones_int' || $catalogo == 'subdirecciones_int' || $catalogo == 'departamentos_int' ) {
				$table = 'areas';
				$params = "id AS id, CONCAT(clave,' - ',nombre) AS value";
				if ($catalogo == 'direcciones_int') {
					$wh = " AND nivel <= 2 ";
				}
				if ($catalogo == 'subdirecciones_int') {
					$wh = " AND nivel = 3 ";
				}
				if ( $catalogo == 'departamentos_int') {
					$wh = " AND nivel = 4 OR id = 4";
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
	public function  getTabulador()
	{
		try {
			$anexgrid = new AnexGrid();
			$wh = "";
			foreach ($anexgrid->filtros as $filter) {
				if ( $filter['columna'] != '' ) {
					$wh .= " AND ".$filter['columna']." = ".$filter['valor'];
				}
			}
			$this->sql ="SELECT * FROM tabulador_dof WHERE 1=1 $wh ORDER BY $anexgrid->columna $anexgrid->columna_orden LIMIT $anexgrid->pagina , $anexgrid->limite";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->execute();
			$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			$total = 0;
			$this->sql = "SELECT COUNT(*) AS total FROM tabulador_dof WHERE 1=1 $wh ";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->execute();
			$total = $this->stmt->fetch(PDO::FETCH_OBJ)->total;
			return $anexgrid->responde($this->result,$total);
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
			$sb = ( isset($_POST['sb']) ) ? mb_strtoupper($_POST['sb'],'utf-8') : NULL ;
			$grat = ( isset($_POST['grat']) ) ? mb_strtoupper($_POST['grat'],'utf-8') : NULL ;
			$forta = ( isset($_POST['forta']) ) ? mb_strtoupper($_POST['forta'],'utf-8') : NULL ;
			$despensa = ( isset($_POST['despensa']) ) ? mb_strtoupper($_POST['despensa'],'utf-8') : NULL ;
			$tb = ( isset($_POST['tb']) ) ? mb_strtoupper($_POST['tb'],'utf-8') : NULL ;
			$t_rango = ( isset($_POST['t_rango']) ) ? mb_strtoupper($_POST['t_rango'],'utf-8') : NULL ;

			$this->sql ="INSERT INTO niveles_rangos (
				id, 
				nombre, 
				clave, 
				sb, 
				grat, 
				forta, 
				despensa, 
				tb, 
				t_rango
			)
			VALUES 
			(
				'',
				:name,
				:cve, 
				:sb,
				:grat,
				:forta,
				:despensa,
				:tb,
				:t_rango
			);";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':name', $name, PDO::PARAM_STR );
			$this->stmt->bindParam(':cve', $cve, PDO::PARAM_STR|PDO::PARAM_BOOL );
			$this->stmt->bindParam(':sb', $sb, PDO::PARAM_STR|PDO::PARAM_BOOL );
			$this->stmt->bindParam(':grat', $grat, PDO::PARAM_STR|PDO::PARAM_BOOL);
			$this->stmt->bindParam(':forta', $forta, PDO::PARAM_STR|PDO::PARAM_BOOL);
			$this->stmt->bindParam(':despensa', $despensa, PDO::PARAM_STR|PDO::PARAM_BOOL);
			$this->stmt->bindParam(':tb', $tb, PDO::PARAM_STR|PDO::PARAM_BOOL);
			$this->stmt->bindParam(':t_rango', $t_rango, PDO::PARAM_INT);
			$this->stmt->execute();
			$alerta = array( 'status'=>'success','message'=>'EL NIVEL/RANGO A SIDO REGISTRADO DE MANERA EXITOSA.' );
			return json_encode( $alerta );
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	public function saveItemTabulador()
	{
		try {
			$lim_inf1 = ( isset($_POST['lim_inf1']) ) ? mb_strtoupper($_POST['lim_inf1'],'utf-8') : false ;
			$lim_inf2 = ( isset($_POST['lim_inf2']) ) ? mb_strtoupper($_POST['lim_inf2'],'utf-8') : false ;
			$lim_supe = ( isset($_POST['lim_supe']) ) ? mb_strtoupper($_POST['lim_supe'],'utf-8') : false ;
			$cuota_fija = ( isset($_POST['cuota_fija']) ) ? mb_strtoupper($_POST['cuota_fija'],'utf-8') : false ;
			$porce = ( isset($_POST['porcentaje']) ) ? mb_strtoupper($_POST['porcentaje'],'utf-8') : false ;
			$subsidio = ( isset($_POST['subsidio']) ) ? mb_strtoupper($_POST['subsidio'],'utf-8') : false ;

			$this->sql ="INSERT INTO tabulador_dof (
				id, limite_inf1, limite_inf2, limite_sup, cuota_fija, porce_excedente, subsidio
			) VALUES (
				'',?,?,?,?,?,?
			);";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(1, $lim_inf1, PDO::PARAM_STR );
			$this->stmt->bindParam(2, $lim_inf2, PDO::PARAM_STR );
			$this->stmt->bindParam(3, $lim_supe, PDO::PARAM_STR );
			$this->stmt->bindParam(4, $cuota_fija, PDO::PARAM_STR );
			$this->stmt->bindParam(5, $porce, PDO::PARAM_STR );
			$this->stmt->bindParam(6, $subsidio, PDO::PARAM_STR );
			$this->stmt->execute();
			$alerta = array( 'status'=>'success','message'=>'LOS DATOS HAN SIDO GUARDADOS DE MANERA EXITOSA.' );
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
			#Datos del banco del servidor publico
			$banco = ( isset($_POST['banco']) ) ? mb_strtoupper($_POST['banco'],'utf-8') : NULL ;
			$clave = ( isset($_POST['num_cuenta']) ) ? mb_strtoupper($_POST['num_cuenta'],'utf-8') : NULL ;
			$tarjeta = ( isset($_POST['num_tarjeta']) ) ? mb_strtoupper($_POST['num_tarjeta'],'utf-8') : NULL ;
			$this->sql ="INSERT INTO ibanco_sp(
			    id,
			    personal_id,
			    banco,
			    clave,
			    tarjeta
			)
			VALUES
			('',:persona, :banco, :clave, :tarjeta );";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':persona', $persona, PDO::PARAM_INT );
			$this->stmt->bindParam(':banco', $banco, PDO::PARAM_INT );
			$this->stmt->bindParam(':clave', $clave, PDO::PARAM_STR );
			$this->stmt->bindParam(':tarjeta', $tarjeta, PDO::PARAM_STR );
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
			$cve_sp = ( !empty($_POST['cve_sp']) ) ? mb_strtoupper($_POST['cve_sp'],'utf-8') : null ;
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
			if ( !empty($_POST['id_nombre_ds']) ) {
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
			}
			
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
			if (!empty($_POST['beneficiario'])) {
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
			}
			
			#DATOS DE LAS REGLAS
			$this->sql = "INSERT INTO reglas(
			    id,
			    personal_id,
			    tipo_pd,
			    pd_id,
			    monto,
			    n_quin,
			    f_ini,
			    f_fin
			)
			VALUES(
				'',
				:personal_id,
				1,
				:pd_id,
				:monto,
				NULL,
				NULL,
				NULL				
			);";
			for ($i=0; $i < count($_POST['percepiones']); $i++) { 
				$pd_id = $_POST['percepiones'][$i];
				if ($pd_id == '1') {
					$monto = ((float)$_POST['per_importe'][$i] / 2);
				}else{
					$monto = $_POST['per_importe'][$i];
				}
				
				$this->stmt = $this->pdo->prepare($this->sql);
				$this->stmt->bindParam(':personal_id', $sp_id, PDO::PARAM_INT );
				$this->stmt->bindParam(':pd_id', $pd_id, PDO::PARAM_INT );
				$this->stmt->bindParam(':monto', $monto, PDO::PARAM_STR );
				$this->stmt->execute();
			}
			$this->sql = "INSERT INTO reglas(
			    id,
			    personal_id,
			    tipo_pd,
			    pd_id,
			    monto,
			    n_quin,
			    f_ini,
			    f_fin
			)
			VALUES(
				'',
				:personal_id,
				2,
				:pd_id,
				:monto,
				NULL,
				NULL,
				NULL				
			);";
			for ($i=0; $i < count($_POST['deducciones']); $i++) { 
				$pd_id = $_POST['deducciones'][$i];
				$monto = $_POST['ded_importe'][$i];
				$this->stmt = $this->pdo->prepare($this->sql);
				$this->stmt->bindParam(':personal_id', $sp_id, PDO::PARAM_INT );
				$this->stmt->bindParam(':pd_id', $pd_id, PDO::PARAM_INT );
				$this->stmt->bindParam(':monto', $monto, PDO::PARAM_STR );
				$this->stmt->execute();
			}
			
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
	public function editRegistroES()
	{
		try {
			#Buscar el registro
			$this->sql ="UPDATE registro_es SET 
			    h_entrada = :h_entrada,
			    h_salida = :h_salida
			    WHERE id  = :id 
			";
			$id = $_POST['id']; 
			$he = $_POST['h_entrada'];
			$hs = $_POST['h_salida'];

			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':h_entrada', $he, PDO::PARAM_STR);
			$this->stmt->bindParam(':h_salida', $hs, PDO::PARAM_INT );
			$this->stmt->bindParam(':id', $id, PDO::PARAM_STR );
			$this->stmt->execute();
			
			$alerta = array( 'status'=>'success','message'=>'REGISTRO DE ENTRADA Y SALIDA ACTUALIZADO DE MANERA EXITOSA.' );
			return json_encode( $alerta );
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	
	public function editItemTabulador()
	{
		try {
			$limite_inf1 = ( isset($_POST['limite_inf1']) ) ? $_POST['limite_inf1'] : NULL ;
			$limite_inf2 = ( isset($_POST['limite_inf2']) ) ? $_POST['limite_inf2'] : NULL ;
			$limite_sup = ( isset($_POST['limite_sup']) ) ? $_POST['limite_sup'] : NULL ;
			$cuota_fija = ( isset($_POST['cuota_fija']) ) ? $_POST['cuota_fija'] : NULL ;
			$porce_excedente = ( isset($_POST['porce_excedente']) ) ? $_POST['porce_excedente'] : NULL ;
			$subsidio = ( isset($_POST['subsidio']) ) ? $_POST['subsidio'] : NULL ;
			$id = ( isset($_POST['id']) ) ? $_POST['id'] : NULL ;
			$this->sql ="UPDATE tabulador_dof  SET 
			limite_inf1=:limite_inf1,
			limite_inf2=:limite_inf2,
			limite_sup=:limite_sup,
			cuota_fija=:cuota_fija,
			porce_excedente=:porce_excedente,
			subsidio=:subsidio
			    WHERE id  = :id
			";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':limite_inf1', $limite_inf1, PDO::PARAM_STR);
			$this->stmt->bindParam(':limite_inf2', $limite_inf2, PDO::PARAM_STR);
			$this->stmt->bindParam(':limite_sup', $limite_sup, PDO::PARAM_STR);
			$this->stmt->bindParam(':cuota_fija', $cuota_fija, PDO::PARAM_STR);
			$this->stmt->bindParam(':porce_excedente', $porce_excedente, PDO::PARAM_STR);
			$this->stmt->bindParam(':subsidio', $subsidio, PDO::PARAM_STR);
			$this->stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$this->stmt->execute();
			$alerta = array( 'status'=>'success','message'=>'REGISTRO A SIDO EDITADO DE MANERA EXITOSA.' );
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
					if ( $filter['columna'] == 'full_name' || $filter['columna'] == 'q.cve_exp' ) {
						$wh .= " AND CONCAT(p.nombre,' ',p.ap_pat,' ',p.ap_mat) LIKE '%".$filter['valor']."%'";
					}else{
						$wh .= " AND ".$filter['columna']." = '".$filter['valor']."'";
					}
				}
			}
			$wh .= " AND r.quincena_id = ".$anexgrid->parametros[0]['q'];
			$wh .= " AND YEAR(r.created_at) = ".$anexgrid->parametros[1]['y'];
			
			$this->sql = "
			SELECT p.id, CONCAT(p.nombre,' ',p.ap_pat,' ',p.ap_mat) AS full_name, 
			r.h_entrada, r.h_salida, r.f_asistencia , p.num_tarjeta, r.id AS r_id,
			r.justificado
			FROM personal AS p 
			INNER JOIN registro_es AS r 
				ON r.personal_id = p.id 
			WHERE 1=1 $wh 
			ORDER BY $anexgrid->columna $anexgrid->columna_orden 
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

			$this->sql = "
			SELECT
			    r.id,
			    r.tipo_pd,
			    r.pd_id,
			    pd.nombre,
			    r.monto AS monto_regla,
			    pd.monto AS monto_origen
			FROM
			    reglas AS r
			INNER JOIN per_ded AS pd
			ON
			    pd.id = r.pd_id
			WHERE
			    r.personal_id = :sp_id AND r.tipo_pd = 1
			";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':sp_id',$sp_id,PDO::PARAM_INT);
			$this->stmt->execute();
			$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			$conceptos['percepciones'] = $this->result;
			#recuperar las percepciones 
			$this->sql = "
			SELECT
			    r.id,
			    r.tipo_pd,
			    r.pd_id,
			    pd.nombre,
			    r.monto AS monto_regla,
			    pd.monto AS monto_origen
			FROM
			    reglas AS r
			INNER JOIN per_ded AS pd
			ON
			    pd.id = r.pd_id
			WHERE
			    r.personal_id = :sp_id AND r.tipo_pd = 2
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
			#var_dump($_POST['funciones']);exit;
			$nombre	= (isset($_POST['n_concepto'])) ? mb_strtoupper($_POST['n_concepto']) : NULL ;	
			$tipo	= (isset($_POST['concepto'])) ? mb_strtoupper($_POST['concepto']) : NULL ;	
			$monto	= (!empty($_POST['monto'])) ? mb_strtoupper($_POST['monto']) : NULL ;	
			$porce	= (!empty($_POST['percent'])) ? mb_strtoupper($_POST['percent']) : NULL ;	
			$ci		= (isset($_POST['cve_int'])) ? mb_strtoupper($_POST['cve_int']) : NULL ;
			$ce		= (isset($_POST['cve_ext'])) ? mb_strtoupper($_POST['cve_ext']) : NULL ;
			$condicion		= (isset($_POST['condicion'])) ? mb_strtoupper($_POST['condicion']) : NULL ;
			$funcion		= (!empty($_POST['funciones'])) ? $_POST['funciones'] : NULL ;
			$c_sat		= (!empty($_POST['c_sat'])) ? $_POST['c_sat'] : NULL ;
			$graba		= (!empty($_POST['graba'])) ? $_POST['graba'] : NULL ;
			$isr	= (!empty($_POST['isr'])) ? $_POST['isr'] : NULL ;
			$issemym	= (!empty($_POST['issemym'])) ? $_POST['issemym'] : NULL ;
			
			$this->sql = "INSERT INTO 
			per_ded (id, nombre, tipo, monto, porcentaje, cve_int, cve_ext, condicion, formula_id, csat_id, graba, g_isr, g_issemym)
			VALUES ('', :nombre, :tipo, :monto, :porce, :ci, :ce, :cond, :fun, :c_sat, :graba ,:isr ,:issemym );";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':nombre',$nombre,PDO::PARAM_STR);
			$this->stmt->bindParam(':tipo',$tipo,PDO::PARAM_INT);
			$this->stmt->bindParam(':monto',$monto,PDO::PARAM_STR|PDO::PARAM_BOOL);
			$this->stmt->bindParam(':porce',$porce,PDO::PARAM_INT|PDO::PARAM_BOOL);
			$this->stmt->bindParam(':ci',$ci,PDO::PARAM_STR);
			$this->stmt->bindParam(':ce',$ce,PDO::PARAM_STR);
			$this->stmt->bindParam(':cond',$condicion,PDO::PARAM_INT);
			$this->stmt->bindParam(':fun',$funcion,PDO::PARAM_INT|PDO::PARAM_BOOL);
			$this->stmt->bindParam(':c_sat',$c_sat,PDO::PARAM_INT|PDO::PARAM_BOOL);

			$this->stmt->bindParam(':graba',$graba,PDO::PARAM_INT|PDO::PARAM_BOOL);
			$this->stmt->bindParam(':isr',$isr,PDO::PARAM_INT|PDO::PARAM_BOOL);
			$this->stmt->bindParam(':issemym',$issemym,PDO::PARAM_INT|PDO::PARAM_BOOL);
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
			$sp_id	= (isset($_POST['sp_id'])) ? mb_strtoupper($_POST['sp_id']) : NULL ;	
			$num_quin	= (isset($_POST['num_quin'])) ? mb_strtoupper($_POST['num_quin']) : NULL ;	
			$f_ini	= (isset($_POST['f_ini'])) ? mb_strtoupper($_POST['f_ini']) : NULL ;	
			$f_fin	= (isset($_POST['f_fin'])) ? mb_strtoupper($_POST['f_fin']) : NULL ;	
			$concepto	= (isset($_POST['concepto'])) ? mb_strtoupper($_POST['concepto']) : NULL ;	
			$importe	= (isset($_POST['importe'])) ? mb_strtoupper($_POST['importe']) : NULL ;
			$this->sql = "INSERT INTO reglas(
			    id,
			    personal_id,
			    tipo_pd,
			    pd_id,
			    monto,
			    n_quin,
			    f_ini,
			    f_fin
			) VALUES (
				'',
				:personal_id,
			    :tipo_pd,
			    :pd_id,
			    :monto,
			    :n_quin,
			    :f_ini,
			    :f_fin
			);
			";	
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':personal_id',$sp_id,PDO::PARAM_INT);
			$this->stmt->bindParam(':tipo_pd',$t_concepto,PDO::PARAM_INT);
			$this->stmt->bindParam(':pd_id',$concepto,PDO::PARAM_STR);
			$this->stmt->bindParam(':monto',$importe,PDO::PARAM_STR);
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
	public function savePago()
	{
		try {
			
			$num_quincena	= (!empty($_POST['num_quincena'])) ? mb_strtoupper($_POST['num_quincena']) : NULL ;	
			$sp_id	= (!empty($_POST['sp_id'])) ? mb_strtoupper($_POST['sp_id']) : NULL ;	
			$year = date('Y');
			#validar que la quincena aun no se haya pagado
			$this->sql = "SELECT COUNT(id) AS cuenta FROM percepciones_sp WHERE personal_id = :sp AND year = :y AND quincena = :q GROUP BY id ";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':sp', $sp_id, PDO::PARAM_INT);
			$this->stmt->bindParam(':y', $year, PDO::PARAM_INT);
			$this->stmt->bindParam(':q', $num_quincena, PDO::PARAM_INT);
			$this->stmt->execute();
			$cuenta = $this->stmt->fetch(PDO::FETCH_OBJ)->cuenta;
			if ($cuenta > 0) {
				throw new Exception("ESTA QUINCENA YA A SIDO PAGADA", 1);
				
			}
			#$t_concepto	= (!empty($_POST['t_concepto'])) ? mb_strtoupper($_POST['t_concepto']) : NULL ;	
			$this->sql = "INSERT INTO percepciones_sp(
			    id,
			    percepcion_id,
			    personal_id,
			    importe,
			    quincena,
			    year			    
			) VALUES (
				'',
				:concepto,
				:personal_id,
				:importe,
				:quincena,
				:year
			);
			";

			for ($i=0; $i < count($_POST['percepciones']) ; $i++) { 
				$this->stmt = $this->pdo->prepare($this->sql);
				$this->stmt->bindParam(':concepto',$_POST['percepciones'][$i],PDO::PARAM_INT);
				$this->stmt->bindParam(':personal_id',$sp_id,PDO::PARAM_INT);
				$this->stmt->bindParam(':importe',$_POST['per_monto'][$i],PDO::PARAM_STR);
				$this->stmt->bindParam(':quincena',$num_quincena,PDO::PARAM_INT);
				$this->stmt->bindParam(':year',$year,PDO::PARAM_INT);
				$this->stmt->execute();
			}
			if ( isset($_POST['deducciones']) ) {
				$this->sql = "INSERT INTO deducciones_sp(
				    id,
				    deduccion_id,
				    personal_id,
				    importe,
				    quincena,
				    year			    
				) VALUES (
					'',
					:concepto,
					:personal_id,
					:importe,
					:quincena,
					:year
				);
				";
				for ($i=0; $i < count($_POST['deducciones']) ; $i++) { 
					$this->stmt = $this->pdo->prepare($this->sql);
					$this->stmt->bindParam(':concepto',$_POST['deducciones'][$i],PDO::PARAM_INT);
					$this->stmt->bindParam(':personal_id',$sp_id,PDO::PARAM_INT);
					$this->stmt->bindParam(':importe',$_POST['ded_monto'][$i],PDO::PARAM_STR);
					$this->stmt->bindParam(':quincena',$num_quincena,PDO::PARAM_INT);
					$this->stmt->bindParam(':year',$year,PDO::PARAM_INT);
					$this->stmt->execute();
				}
			}
			
			
			$alerta = array( 'status'=>'success','message'=>'LOS DATOS DEL PAGO HAN SIDO GUARDADOS DE MANERA EXITOSA.' );
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
	public function getRetardos()#Recuperar el nombre de la percepcion o deduccion
	{
		try {
			$sp = (!isset($_POST['sp'])) ? NULL : $_POST['sp'] ;
			$q  = (!isset($_POST['q'])) ? NULL : $_POST['q'] ;
			if (is_null($sp)) {
				throw new Exception("NO ESTA DEFINIDO EL SERVIDOR PÚBLICO.", 1);				
			}
			$this->sql = "
			SELECT *, DATE_FORMAT(TIMEDIFF(h_entrada,'09:10:00'),'%i') AS min_retardos
			FROM registro_es 
			WHERE personal_id = :id AND quincena_id = :q";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':id',$sp, PDO::PARAM_INT);
			$this->stmt->bindParam(':q',$q, PDO::PARAM_INT);
			$this->stmt->execute();
			$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			$res = array('status'=>'success','tiempos'=>$this->result);
			return json_encode($res);
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	#Obtener el sueldo base de un Servidor publico.
	public function getSueldoBase($sp)
	{
		try {
			$this->sql = "SELECT psp.* FROM per_ded AS pd 
			INNER JOIN percepciones_sp AS psp ON psp.percepcion_id = pd.id 
			WHERE pd.nombre LIKE 'SUELDO BASE' AND psp.personal_id = :sp";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':sp',$sp, PDO::PARAM_INT);
			$this->stmt->execute();
			if ( $this->stmt->rowCount() > 0 ) {
				$this->result = $this->stmt->fetch(PDO::FETCH_OBJ)->importe;
			}else{
				$this->result ='0.00';
			}
			return $this->result;
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	public function getInfoPerDed()#Recuperar info de la percepcion o deduccion
	{
		try {
			$calculadora = new CalculadoraModel;
			$pd = (!isset($_POST['pd'])) ? NULL : $_POST['pd'] ;
			$sp = (!isset($_POST['sp'])) ? NULL : $_POST['sp'] ;
			$sb = 0;
			if ( is_null($pd) ) {
				return json_encode(array('id'=>'0','name'=>'NO RECONOCIDO','valor'=>'0','cond'=>'error'));
			}
			$this->sql = "SELECT * FROM per_ded WHERE id = :id ";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':id',$pd, PDO::PARAM_INT);
			$this->stmt->execute();
			$result = $this->stmt->fetch(PDO::FETCH_OBJ);
			if ( $result->condicion == 'CALCULABLE' ) {
				$this->sql = "SELECT * FROM formulas WHERE id = :id ";
				$this->stmt = $this->pdo->prepare($this->sql);
				$this->stmt->bindParam(':id',$result->formula_id, PDO::PARAM_INT);
				$this->stmt->execute();
				$formula = $this->stmt->fetch(PDO::FETCH_OBJ);
				$sb = $this->getSueldoBase($sp);
				$fun =  $formula->funcion;
				$monto = $calculadora->$fun($sb)['value'];
				$res = array('id'=>$result->id,'name'=>$result->nombre,'valor'=>$monto,'cond'=>$result->condicion);
			}else{
				$res = array('id'=>$result->id,'name'=>$result->nombre,'valor'=>$result->monto,'cond'=>$result->condicion);
			}
			#$res = array('id'=>$this->result->id,'name'=>$this->result->nombre,'valor'=>$this->result->monto,'cond'=>$this->result->condicion);
			return json_encode($res);
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	public function getQuincenaPagada()#Recuperar info de la percepcion o deduccion
	{
		try {
			
			$quincena = $_POST['parametros'][1]['quincena'];
			$year =  $_POST['parametros'][0]['year'];
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
			$this->sql = "SELECT 
			p.id, CONCAT(p.nombre,' ',p.ap_pat,' ',p.ap_mat) AS full_name , 
			a.nombre AS n_area,  
			n.nombre AS n_nivel  ,
			d.t_sindicato
			FROM personal AS p
			INNER JOIN areas AS a ON a.id = p.area_id
			INNER JOIN niveles_rangos AS n ON n.id = p.nivel
			LEFT JOIN datos_laborables_sp AS d ON d.persona_id = p.id
			";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->execute();
			$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			$cont = array(); $aux = array();
			foreach ($this->result as $key => $r) {
				$suma_ded = 0; $suma_per = 0;
				$aux['full_name'] = $r->full_name;
				$aux['n_area'] = $r->n_area;
				$aux['n_nivel'] = $r->n_nivel;
				#consultar las percepciones
				$sql_per ="SELECT * FROM percepciones_sp WHERE personal_id = :sp_id AND quincena = :q AND year = :y; ";
				$this->stmt = $this->pdo->prepare($sql_per);
				$this->stmt->bindParam(':sp_id', $r->id, PDO::PARAM_STR);
				$this->stmt->bindParam(':q', $quincena, PDO::PARAM_INT);
				$this->stmt->bindParam(':y', $year, PDO::PARAM_INT);
				$this->stmt->execute();
				if ( $this->stmt->rowCount() > 0  ) {
					$percepciones = $this->stmt->fetchAll(PDO::FETCH_OBJ);
					foreach ($percepciones as $key => $p) {
						$suma_per = (float)$suma_per + (float) $p->importe;
					}
					$aux['t_per'] = $suma_per;
				}else{
					$aux['t_per'] = '0.00';
				}
				
				#consultar las deducciones
				$sql_ded ="SELECT * FROM deducciones_sp WHERE personal_id = :sp_id AND quincena = :q AND year = :y; ";
				$this->stmt = $this->pdo->prepare($sql_ded);
				$this->stmt->bindParam(':sp_id', $r->id, PDO::PARAM_STR);
				$this->stmt->bindParam(':q', $quincena, PDO::PARAM_INT);
				$this->stmt->bindParam(':y', $year, PDO::PARAM_INT);
				$this->stmt->execute();
				if ( $this->stmt->rowCount() > 0 ) {
					$deducciones = $this->stmt->fetchAll(PDO::FETCH_OBJ);
					foreach ($deducciones as $key => $d) {
						$suma_ded = (float)$suma_ded + (float) $d->importe;
					}
					$aux['t_ded'] = $suma_ded;
				}else{
					$aux['t_ded'] = '0.00';
				}
				#Total general 
				$aux['t_general'] = "$". ((float) $suma_per - (float) $suma_ded);
				array_push($cont, $aux);
			}
			$total = 0;
			$this->sql = "SELECT COUNT(*) AS total FROM personal AS p 
			INNER JOIN niveles_rangos AS nr ON nr.id = p.nivel
			WHERE 1=1 $wh";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->execute();
			$total = $this->stmt->fetch(PDO::FETCH_OBJ)->total;
			
			return $anexgrid->responde($cont,$total);
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	public function getTimbrado()
	{
		try {
			$year = $_POST['year'];
			$quincena = $_POST['quincena'];
			$t_reporte = $_POST['t_reporte'];
			

			if ( $t_reporte == "1" ) { 
				$tabla = 'percepciones_sp'; 
				$as = 'per'; 
				$col = 'percepcion_id';
				$sat = "c_percepciones_sat";
			}
			if ( $t_reporte == "2" ) { 
				$tabla = 'deducciones_sp'; 
				$as = 'ded'; 
				$col = 'deduccion_id';
				$sat = "c_deducciones_sat";
			}
			if ($t_reporte == '1' || $t_reporte == '2') {
				$this->sql = "
				SELECT $as.*, p.clave,p.nombre,p.ap_pat,p.ap_mat,p.clave,
				pd.nombre AS pd_name, pd.cve_ext, sat.clave AS cve_sat, 
				sat.nombre AS name_sat , dl.clave_sp
				FROM $tabla AS $as 
				INNER JOIN personal AS p ON p.id = $as.personal_id
				INNER JOIN per_ded AS pd ON pd.id = $as.$col
				LEFT JOIN $sat AS sat ON sat.id = pd.csat_id
				LEFT JOIN datos_laborables_sp AS dl ON dl.persona_id = p.id
				WHERE $as.year = $year AND $as.quincena = $quincena
				";
				#echo $this->sql;exit;
				$this->stmt = $this->pdo->prepare($this->sql);
				$this->stmt->execute();
				$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			}
			if ( $t_reporte == "4" ) { 
				if ( empty($_FILES['file']['tmp_name']) ) {
					throw new Exception("DEBE SELECCIONAR UN ARCHIVO XML.", 1);
				}
				$filexml = $_FILES['file']['tmp_name'];
				$xml = simplexml_load_file($filexml); 
				$ns = $xml->getNamespaces(true);
				$xml->registerXPathNamespace('cfdi', $ns['cfdi']);
				$xml->registerXPathNamespace('t', $ns['tfd']);
				foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
					$sello = $tfd['SelloCFD']; 
					$fechaTim = $tfd['FechaTimbrado']; 
					$uuid = $tfd['UUID']; 
					//echo $tfd['NoCertificadoSAT']; 
					$version = $tfd['Version']; 
					$sello = $tfd['SelloSAT']; 
				}
				foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){ 
				   $rfc = trim($Receptor['Rfc']); 
				   $nombre =  $Receptor['Nombre']; 
				} 
				
				#buscar al SP por RFC
				$rfc = "%".$rfc."%";
				$this->sql = "SELECT * FROM personal WHERE rfc LIKE :rfc";
				$this->stmt = $this->pdo->prepare($this->sql);
				$this->stmt->bindParam(':rfc',$rfc,PDO::PARAM_STR);
				$this->stmt->execute();
				$sp_id = $this->stmt->fetch(PDO::FETCH_OBJ)->id;	
				
				#Insertar en la tabla de xml 
				$this->sql = "INSERT INTO registros_xml (id, personal_id, quincena, year, uuid) VALUES ('', :sp_id, :quincena, :year, :uuid);";
				$this->stmt = $this->pdo->prepare($this->sql);
				$this->stmt->bindParam(':sp_id',$sp_id,PDO::PARAM_INT);
				$this->stmt->bindParam(':quincena',$quincena,PDO::PARAM_INT);
				$this->stmt->bindParam(':year',$year,PDO::PARAM_INT);
				$this->stmt->bindParam(':uuid',$uuid,PDO::PARAM_STR);
				$this->stmt->execute();		
				#Buscar los datos
				$this->sql = "SELECT p.*, xml.uuid, per.importe, a.nombre AS name_area, 
				d.n_pu_act AS puesto, dl.f_ingreso_gem, dl.t_sindicato	
				FROM personal AS p 
				LEFT JOIN registros_xml as xml ON xml.personal_id = p.id
				LEFT JOIN percepciones_sp as per ON per.personal_id = p.id
				LEFT JOIN areas as a ON a.id = p.area_id
				LEFT JOIN datos_plaza as d ON d.personal_id = p.id
				LEFT JOIN datos_laborables_sp as dl ON dl.persona_id = p.id
				WHERE xml.year = :year AND xml.quincena = :quincena";
				$this->stmt = $this->pdo->prepare($this->sql);
				$this->stmt->bindParam(':quincena',$quincena,PDO::PARAM_INT);
				$this->stmt->bindParam(':year',$year,PDO::PARAM_INT);
				$this->stmt->execute();
				$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			}

			
			return json_encode(array('status' =>'success', 'data' => $this->result ));
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	public function getCatSAT()
	{
		try {
			$c = $_POST['c'];
			if ( $c == '1' ) {
				$tabla = "c_percepciones_sat";
			}
			if ( $c == '2' ) {
				$tabla = "c_deducciones_sat";
			}
			$this->sql = "
			SELECT *
			FROM $tabla 
			";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->execute();
			$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			return json_encode(array('status' =>'success', 'data' => $this->result ));
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	public function ALFGRAL()
	{
		try {
			$y = $_POST['year'];
			$q = $_POST['c_quincena'];
			$data = array();
			$this->sql = "
			SELECT p.*,dp.nu_plaza, a.clave AS cve_area, dp.n_pu_act FROM personal  AS p
			INNER JOIN datos_plaza AS dp ON dp.personal_id = p.id
			INNER JOIN areas AS a ON a.id = p.area_id
			";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->execute();
			$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			$aux = array();
			foreach ($this->result as $key => $sp) {
				$aux['id'] = $sp->id;
				$aux['nu_plaza'] = $sp->nu_plaza;
				$aux['nombre'] = $sp->nombre;
				$aux['ap_pat'] = $sp->ap_pat;
				$aux['ap_mat'] = $sp->ap_mat;
				$aux['rfc'] = $sp->rfc;
				$aux['issemym'] = $sp->issemym;
				$aux['cve_area'] = $sp->cve_area;
				$aux['n_pu_act'] = $sp->n_pu_act;
				#buscar las percepciones del ser pub
				$sql_per ="SELECT psp.*,pd.nombre AS name_pd, pd.cve_int, pd.cve_ext 
				FROM percepciones_sp AS psp
				INNER JOIN per_ded AS pd ON pd.id = psp.percepcion_id
				WHERE psp.personal_id = :sp_id AND psp.quincena = :q AND psp.year = :y; ";
				$this->stmt = $this->pdo->prepare($sql_per);
				$this->stmt->bindParam(':sp_id', $sp->id, PDO::PARAM_INT);
				$this->stmt->bindParam(':q', $q, PDO::PARAM_INT);
				$this->stmt->bindParam(':y', $y, PDO::PARAM_INT);
				$this->stmt->execute();
				$r_per = $this->stmt->fetchAll(PDO::FETCH_OBJ);
				$aux['percepciones'] = $r_per;

				#buscar las deducciones del ser pub
				$sql_ded ="SELECT dsp.*,pd.nombre AS name_pd, pd.cve_int, pd.cve_ext  
				FROM deducciones_sp AS dsp
				INNER JOIN per_ded AS pd ON pd.id = dsp.deduccion_id
				WHERE dsp.personal_id = :sp_id AND dsp.quincena = :q AND dsp.year = :y; ";
				$this->stmt = $this->pdo->prepare($sql_ded);
				$this->stmt->bindParam(':sp_id', $sp->id, PDO::PARAM_INT);
				$this->stmt->bindParam(':q', $q, PDO::PARAM_INT);
				$this->stmt->bindParam(':y', $y, PDO::PARAM_INT);
				$this->stmt->execute();
				$r_ded = $this->stmt->fetchAll(PDO::FETCH_OBJ);
				$aux['deducciones'] = $r_ded;
				
				array_push($data, $aux);
			}
			
			return array('status' =>'success', 'data' => $data );
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	public function FIRMAS($a)
	{
		try {
			$y = $_POST['year'];
			$q = $_POST['c_quincena'];
			$this->sql = "
			SELECT p.id, p.nombre, p.ap_pat, p.ap_mat, p.rfc,p.area_id, dp.nu_plaza 
			FROM personal AS p 
			LEFT JOIN datos_plaza AS dp ON dp.personal_id = p.id
			WHERE p.area_id = $a
			ORDER BY p.area_id ASC
			";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->execute();
			$personas = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			
			$data = array();
			$aux = array();
			
			foreach ($personas as $key => $p) {
				$suma_p = 0;
				$suma_d = 0;
				$total = 0;
				$aux['id'] = $p->id;
				$aux['nombre'] = $p->nombre;
				$aux['ap_pat'] = $p->ap_pat;
				$aux['ap_mat'] = $p->ap_mat;
				$aux['rfc'] = $p->rfc;
				$aux['nu_plaza'] = $p->nu_plaza;
				#Suma de percepciones
				$this->sql = "
				SELECT * FROM percepciones_sp WHERE personal_id = :sp_id AND quincena = :q AND year = :y
				";
				$this->stmt = $this->pdo->prepare($this->sql);
				$this->stmt->bindParam(':sp_id',$p->id, PDO::PARAM_INT);
				$this->stmt->bindParam(':q',$q, PDO::PARAM_INT);
				$this->stmt->bindParam(':y',$y, PDO::PARAM_INT);
				$this->stmt->execute();
				$per = $this->stmt->fetchAll(PDO::FETCH_OBJ);
				foreach ($per as $key => $pe) {
					$suma_p += $pe->importe;
				}
				$aux['total_p'] = $suma_p;
				#suma de deducciones
				$this->sql = "
				SELECT * FROM deducciones_sp WHERE personal_id = :sp_id AND quincena = :q AND year = :y
				";
				$this->stmt = $this->pdo->prepare($this->sql);
				$this->stmt->bindParam(':sp_id',$p->id, PDO::PARAM_INT);
				$this->stmt->bindParam(':q',$q, PDO::PARAM_INT);
				$this->stmt->bindParam(':y',$y, PDO::PARAM_INT);
				$this->stmt->execute();
				$ded = $this->stmt->fetchAll(PDO::FETCH_OBJ);
				foreach ($ded as $key => $de) {
					$suma_d += $de->importe;
				}
				$aux['total_d'] = $suma_d;
				#suma total
				$total = $suma_p - $suma_d;
				$aux['total'] = $total;
				array_push($data, $aux);
			}
			return (object) array('status' =>'success', 'data' => $data );
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	public function LISPEN()
	{
		try {
			$this->sql = "
			SELECT pen.*, a.nombre, a.clave, p.rfc FROM pensiones  AS pen
			INNER JOIN personal AS p ON p.id = pen.personal_id
			INNER JOIN areas AS a ON a.id = p.area_id
			";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->execute();
			$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			return array('status' =>'success', 'data' => $this->result );
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	public function LISPROYE()
	{
		try {
			$q = $_POST['c_quincena'];
			$this->sql = "
			SELECT DISTINCT(percepcion_id) AS per_id, pd.cve_ext, pd.nombre, p.importe FROM percepciones_sp AS p
			INNER JOIN per_ded AS pd ON pd.id = p.percepcion_id
			WHERE quincena = :q
			";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':q',$q,PDO::PARAM_INT);
			$this->stmt->execute();
			$per_quin = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			$data = array ();
			$aux = array();
			foreach ($per_quin as $key => $pq) {
				$aux['id'] = $pq->per_id;
				$aux['cve_ext'] = $pq->cve_ext;
				$aux['nombre'] = $pq->nombre;
				#
				$this->sql = "
				SELECT SUM(importe) AS suma 
				FROM percepciones_sp 
				WHERE quincena = :q AND percepcion_id = $pq->per_id
				";
				$this->stmt = $this->pdo->prepare($this->sql);
				$this->stmt->bindParam(':q',$q,PDO::PARAM_INT);
				$this->stmt->execute();
				$suma = $this->stmt->fetch(PDO::FETCH_OBJ)->suma;
				$aux['importe'] = $suma;
				array_push($data, $aux);
			}
			$this->sql = "
			SELECT DISTINCT(deduccion_id) AS per_id, pd.cve_ext, pd.nombre, p.importe FROM deducciones_sp AS p
			INNER JOIN per_ded AS pd ON pd.id = p.deduccion_id
			WHERE quincena = :q
			";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':q',$q,PDO::PARAM_INT);
			$this->stmt->execute();
			$ded_quin = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			
			foreach ($ded_quin as $key => $pq) {
				$aux['id'] = $pq->per_id;
				$aux['cve_ext'] = $pq->cve_ext;
				$aux['nombre'] = $pq->nombre;
				#
				$this->sql = "
				SELECT SUM(importe) AS suma 
				FROM percepciones_sp 
				WHERE quincena = :q AND percepcion_id = $pq->per_id
				";
				$this->stmt = $this->pdo->prepare($this->sql);
				$this->stmt->bindParam(':q',$q,PDO::PARAM_INT);
				$this->stmt->execute();
				$suma = $this->stmt->fetch(PDO::FETCH_OBJ)->suma;
				$aux['importe'] = $suma;
				array_push($data, $aux);
			}
			
			return array('status' =>'success', 'data' => $data );
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	public function getAreas()
	{
		try {
			$this->sql = "
			SELECT * FROM areas 
			";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->execute();
			$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			return json_encode(array('status' =>'success', 'data' => $this->result ));
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	public function getDataUser()
	{
		try {
			$this->sql = "
			SELECT p.*,a.nombre AS name_area FROM personal AS p 
			INNER JOIN areas AS a ON a.id = p.area_id
			WHERE p.id = :sp
			";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':sp',$_POST['sp_id']);
			$this->stmt->execute();
			$this->result = $this->stmt->fetch(PDO::FETCH_OBJ);
			return array('status' =>'success', 'data' => $this->result );
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	public function getDatePago()
	{
		try {
			$this->sql = "
			SELECT DATE(created_at) AS f_pago FROM percepciones_sp WHERE personal_id = :sp  AND quincena = :q AND year = :y
			";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':sp',$_POST['sp_id']);
			$this->stmt->bindParam(':q',$_POST['c_quincena']);
			$this->stmt->bindParam(':y',$_POST['year']);
			$this->stmt->execute();
			$this->result = $this->stmt->fetch(PDO::FETCH_OBJ);
			return array('status' =>'success', 'data' => $this->result );
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	public function getPeriodo()
	{
		try {
			$this->sql = "
			SELECT * FROM catalogo_quincenas WHERE id = :q 
			";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':q',$_POST['c_quincena']);
			$this->stmt->execute();
			$this->result = $this->stmt->fetch(PDO::FETCH_OBJ);
			return array('status' =>'success', 'data' => $this->result );
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	public function getPercepcionesQuincena()
	{
		try {
			$this->sql = "
			SELECT per.*, pd.nombre AS name_per, pd.cve_ext  FROM percepciones_sp AS per 
			INNER JOIN per_ded AS pd ON pd.id = per.percepcion_id
			WHERE per.personal_id = :sp AND per.quincena = :q AND per.year = :y 
			";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':sp',$_POST['sp_id']);
			$this->stmt->bindParam(':q',$_POST['c_quincena']);
			$this->stmt->bindParam(':y',$_POST['year']);
			$this->stmt->execute();
			$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			return array('status' =>'success', 'data' => $this->result );
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	public function getDeduccionesQuincena()
	{
		try {
			$this->sql = "
			SELECT ded.*, pd.nombre AS name_ded,pd.cve_ext  FROM deducciones_sp AS ded 
			INNER JOIN per_ded AS pd ON pd.id = ded.deduccion_id
			WHERE ded.personal_id = :sp AND ded.quincena = :q AND ded.year = :y 
			";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':sp',$_POST['sp_id']);
			$this->stmt->bindParam(':q',$_POST['c_quincena']);
			$this->stmt->bindParam(':y',$_POST['year']);
			$this->stmt->execute();
			$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			return array('status' =>'success', 'data' => $this->result );
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	
	public function getDispersion()
	{
		try {
			$quincena = $_POST['quincenas'];
			$year = $_POST['year'];
			$c = $_POST['cuenta'];
			$inner = "";
			$wh = "";
			if ( $c == '1' ) {
				$wh .= " AND b.banco = 1";
			}elseif($c == '2'){
				$wh .= " AND b.banco != 1 ";
			}elseif ($c == '3') {
				$inner = " INNER JOIN pensiones AS pen ON pen.personal_id =  p.id  ";
			}
			$this->sql = "
			SELECT p.id, CONCAT(p.nombre,' ',p.ap_pat, ' ', p.ap_mat) AS full_name,
			b.clave 
			FROM  personal  AS p
			INNER JOIN ibanco_sp AS b ON b.personal_id =  p.id
			$inner
			WHERE 1=1
			";
			#echo $this->sql;exit;
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->execute();
			$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			#Buscar el montos 
			
			$data = array();
			foreach ($this->result as $persona) {
				$sum_per = 0;
				$sum_ded = 0;
				$aux = array();
				#buscar las percepciones
				$per = "SELECT * FROM percepciones_sp 
				WHERE  personal_id = :sp AND quincena = :q AND year = :y";
				$this->stmt = $this->pdo->prepare($per); 
				$this->stmt->bindParam(':sp', $persona->id, PDO::PARAM_INT);
				$this->stmt->bindParam(':y', $year, PDO::PARAM_INT);
				$this->stmt->bindParam(':q', $quincena, PDO::PARAM_INT);
				$this->stmt->execute();
				$r_per = $this->stmt->fetchAll(PDO::FETCH_OBJ);
				foreach ($r_per as $p) {
					$sum_per = (float)$sum_per + (float)$p->importe;
				}
				#buscar las deudcciones 
				$ded = "SELECT * FROM deducciones_sp 
				WHERE  personal_id = :sp AND quincena = :q AND year = :y";
				$this->stmt = $this->pdo->prepare($ded); 
				$this->stmt->bindParam(':sp', $persona->id, PDO::PARAM_INT);
				$this->stmt->bindParam(':y', $year, PDO::PARAM_INT);
				$this->stmt->bindParam(':q', $quincena, PDO::PARAM_INT);
				$this->stmt->execute();
				$r_ded = $this->stmt->fetchAll(PDO::FETCH_OBJ);
				foreach ($r_ded as $ded) {
					$sum_ded += $ded->importe;
				}
				$aux['id'] = $persona->id;
				$aux['clave'] = $persona->clave;
				$aux['full_name'] = $persona->full_name;
				$aux['importe'] = ( $sum_per - $sum_ded );
				array_push($data, $aux);
			}
			return json_encode(array('status' =>'success', 'data' => $data ));
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}

	public function getColumnPD()
	{
		try {
			$data = array();
			$aux = array();
			$year = $_POST['year'];
			$quincena = $_POST['quincenas'];
			#Buscar datos del SP 
			$this->sql = "
			SELECT p.* , dp.nu_plaza,nr.nombre AS nivel
			FROM personal AS p
			LEFT JOIN datos_plaza AS dp ON dp.personal_id = p.id
			INNER JOIN niveles_rangos AS nr ON nr.id = p.nivel
			";
			$this->stmt = $this->pdo->prepare($this->sql); 
			$this->stmt->bindParam(':y',$year,PDO::PARAM_INT);
			$this->stmt->bindParam(':q',$quincena,PDO::PARAM_INT);
			$this->stmt->execute();
			$info_sp = $this->stmt->fetchAll(PDO::FETCH_OBJ); 
			if ( $this->stmt->rowCount() > 0 ) {
				foreach ($info_sp as $key => $sp) {
					$aux['id'] = $sp->id;
					$aux['nombre'] = $sp->nombre;
					$aux['ap_pat'] = $sp->ap_pat;
					$aux['ap_mat'] = $sp->ap_mat;
					$aux['curp'] = $sp->curp;
					$aux['rfc'] = $sp->rfc;
					$aux['issemym'] = $sp->issemym;
					$aux['nivel'] = $sp->nivel;
					$aux['categoria'] = $sp->nu_plaza;
					$this->sql = "
					SELECT pd.nombre, pd.cve_int, pd.cve_ext , p.importe
					FROM percepciones_sp AS p
					INNER JOIN per_ded AS pd ON pd.id = p.percepcion_id
					WHERE year = :y AND quincena = :q AND p.personal_id = :sp
					GROUP BY pd.cve_ext ORDER BY pd.cve_ext ASC ;";
					$this->stmt = $this->pdo->prepare($this->sql); 
					$this->stmt->bindParam(':y',$year,PDO::PARAM_INT);
					$this->stmt->bindParam(':q',$quincena,PDO::PARAM_INT);
					$this->stmt->bindParam(':sp',$sp->id,PDO::PARAM_INT);
					$this->stmt->execute();
					if ($this->stmt->rowCount() > 0 ) {
						$aux['percepciones_sp'] = $this->stmt->fetchAll(PDO::FETCH_OBJ);
					}else{
						$aux['percepciones_sp'] = NULL;
					}
					$this->sql = "
					SELECT pd.nombre, pd.cve_int, pd.cve_ext, d.importe
					FROM deducciones_sp AS d
					INNER JOIN per_ded AS pd ON pd.id = d.deduccion_id
					WHERE year = :y AND quincena = :q AND d.personal_id = :sp
					ORDER BY pd.cve_ext ASC;";
					$this->stmt = $this->pdo->prepare($this->sql); 
					$this->stmt->bindParam(':y',$year,PDO::PARAM_INT);
					$this->stmt->bindParam(':q',$quincena,PDO::PARAM_INT);
					$this->stmt->bindParam(':sp',$sp->id,PDO::PARAM_INT);
					$this->stmt->execute();
					if ($this->stmt->rowCount() > 0 ) {
						$aux['deducciones_sp'] = $this->stmt->fetchAll(PDO::FETCH_OBJ);
					}else{
						$aux['deducciones_sp'] = NULL;
					}
					$data['info_sp'][$key] = $aux;
				}
				#agregar el orden de las per / ded 
				$this->sql = "
				SELECT pd.nombre, pd.cve_int, pd.cve_ext 
				FROM percepciones_sp AS p
				INNER JOIN per_ded AS pd ON pd.id = p.percepcion_id
				WHERE year = :y AND quincena = :q
				GROUP BY pd.cve_ext ORDER BY pd.cve_ext;";
				$this->stmt = $this->pdo->prepare($this->sql); 
				$this->stmt->bindParam(':y',$year,PDO::PARAM_INT);
				$this->stmt->bindParam(':q',$quincena,PDO::PARAM_INT);
				$this->stmt->execute();
				if ($this->stmt->rowCount() > 0 ) {
					$percepciones_sp = $this->stmt->fetchAll(PDO::FETCH_OBJ);
				}else{
					$percepciones_sp = NULL;
				}
				$this->sql = "
				SELECT pd.nombre, pd.cve_int, pd.cve_ext 
				FROM deducciones_sp AS d
				INNER JOIN per_ded AS pd ON pd.id = d.deduccion_id
				WHERE year = :y AND quincena = :q 
				GROUP BY pd.cve_ext ORDER BY pd.cve_ext;";
				$this->stmt = $this->pdo->prepare($this->sql); 
				$this->stmt->bindParam(':y',$year,PDO::PARAM_INT);
				$this->stmt->bindParam(':q',$quincena,PDO::PARAM_INT);
				$this->stmt->execute();
				if ($this->stmt->rowCount() > 0 ) {
					$deducciones_sp = $this->stmt->fetchAll(PDO::FETCH_OBJ);
				}else{
					$deducciones_sp = NULL;
				}
				$data['percepciones_sp'] = $percepciones_sp;
				$data['deducciones_sp'] = $deducciones_sp;
			}
			
			return json_encode(array('status' =>'success', 'data' => $data ));
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	public function getReglas()#Recuperar  las reglas aplicadas a servidores publicos
	{
		try {
			$anexgrid = new AnexGrid();
			$wh = "";
			foreach ($anexgrid->filtros as $filter) {
				if ( $filter['columna'] != '' ) {
					if ( $filter['columna'] == 'full_name') {
						$wh .= " AND CONCAT(p.nombre,' ',p.ap_pat,' ',p.ap_mat) LIKE '%".$filter['valor']."%'";
					}elseif($filter['columna'] == 'pd.nombre'){
						$wh .= " AND ".$filter['columna']." LIKE '%".$filter['valor']."%'";
					}else{
						$wh .= " AND ".$filter['columna']." = ".$filter['valor'];
					}
				}
			}

			$this->sql = "
			SELECT r.*, CONCAT(p.nombre,' ',p.ap_pat,' ',p.ap_mat) AS full_name, pd.nombre AS pd_name
			FROM reglas AS r
			INNER JOIN personal AS p ON p.id = r.personal_id
			INNER JOIN per_ded AS pd ON pd.id = r.pd_id
			WHERE 1=1 $wh ORDER BY $anexgrid->columna $anexgrid->columna_orden LIMIT $anexgrid->pagina , $anexgrid->limite";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->execute();
			$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			$total = 0;
			$this->sql = "SELECT COUNT(*) AS total FROM reglas AS r
			INNER JOIN personal AS p ON p.id = r.personal_id
			INNER JOIN per_ded AS pd ON pd.id = r.pd_id
			WHERE 1=1 $wh";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->execute();
			$total = $this->stmt->fetch(PDO::FETCH_OBJ)->total;
			return $anexgrid->responde($this->result,$total);
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	public function getReglasArray($sp)#Recuperar  las reglas aplicadas a servidores publicos
	{
		try {
			$this->sql = "
			SELECT r.*, pd.nombre AS pd_name, pd.id AS pd_id, pd.g_isr
			FROM reglas AS r
			INNER JOIN personal AS p ON p.id = r.personal_id
			INNER JOIN per_ded AS pd ON pd.id = r.pd_id
			WHERE  p.id = :sp";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':sp',$sp ,PDO::PARAM_INT);
			//$this->stmt->bindParam(':', ,PDO::PARAM_INT);
			$this->stmt->execute();
			$this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			
			return $this->result;
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	public function getInfoQuincena($q)#Recuperar  las reglas aplicadas a servidores publicos
	{
		try {
			$this->sql = "
			SELECT *, CONCAT( dia_ini,'-',num_mes,'-',YEAR(NOW()) ) AS fecha_ini,
			CONCAT( dia_fin,'-',num_mes,'-',YEAR(NOW()) ) AS fecha_fin   
			FROM catalogo_quincenas WHERE id = :id ";
			$this->stmt = $this->pdo->prepare($this->sql);
			$this->stmt->bindParam(':id',$q ,PDO::PARAM_INT);
			$this->stmt->execute();
			$this->result = $this->stmt->fetch(PDO::FETCH_OBJ);
			
			return json_encode($this->result);
		} catch (Exception $e) {
			return json_encode( array('status' =>'error', 'message' => $e->getMessage() ) );
		}
	}
	
}
?>