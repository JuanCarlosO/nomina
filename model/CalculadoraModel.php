<?php 
/**
 * Calculadora de financiera
 */
include_once 'UAAModel.php';
class CalculadoraModel
{
	private $sueldob;
	private $dias = 30.4;
	protected $result;
	public function definePrimaVac_uno($sb)
	{
		try {
			$this->sueldob = $sb;
			$producto = 12.5;
			$r = (($this->sueldob/$this->dias)*$producto);
			$r = round( $r, 2, PHP_ROUND_HALF_ODD);
			$result = array('status' => 'success', 'value'=> $r);
			return $result;
		} catch (Exception $e) {
			return $result = array('status' => 'error', 'value'=> $e);
		}
	}
	protected function complementoPrimaVac($sb)
	{
		try {
			$this->sueldob = $sb;
			$adelanto= (($this->sueldob/$dias)*12.5);
			$total = (($this->sueldob/$dias)*25);
			$r = $total - $adelanto;
			$r = round( $r, 2, PHP_ROUND_HALF_ODD);
			$result = array('status' => 'success', 'value'=> $r);
			return $result;
		} catch (Exception $e) {
			return $result = array('status' => 'error', 'value'=> $e);
		}
	}
	
	protected function adelantoAguinaldo($sb)
	{
		try {
			$this->sueldob = $sb;
			$r = (($this->sueldob/$this->dias)*20);
			$r = round( $r, 2, PHP_ROUND_HALF_ODD);
			$result = array('status' => 'success', 'value'=> $r);
			return $result;
		} catch (Exception $e) {
			return $result = array('status' => 'error', 'value'=> $e);
		}
	}
	protected function complementoAguinaldo($sb)
	{
		try {
			$this->sueldob = $sb;
			$adelanto = (($this->sueldob/$this->dias)*20);
			$total = (($this->sueldob/$this->dias)*60);
			$r = $adelanto - $total;
			$r = round( $r, 2, PHP_ROUND_HALF_ODD);
			$result = array('status' => 'success', 'value'=> $r);
			return $result;
		} catch (Exception $e) {
			return $result = array('status' => 'error', 'value'=> $e);
		}
	}
	#DIAS ECONOMICOS PARA SINDICALIZADOS 
	protected function diasEconomicosSind($sb)
	{
		try {
			$this->sueldob = $sb;
			$r = (($this->sueldob/30.4)*18);
			$result = array('status' => 'success', 'value'=> $r);
			return $result;
		} catch (Exception $e) {
			return $result = array('status' => 'error', 'value'=> $e);
		}
	}
	//Gratificacion por convenio 1
	protected function gratxconvenio1($sb)
	{
		try {
			$this->sueldob = $sb;
			$r = (($this->sueldob/30.4)*10);
			$result = array('status' => 'success', 'value'=> $r);
			return $result;
		} catch (Exception $e) {
			return $result = array('status' => 'error', 'value'=> $e);
		}
	}
	#Gratificacion por convenio 2 
	protected function gratxconvenio2($sb)
	{
		try {
			$this->sueldob = $sb;
			$r1 = (($this->sueldob/30.4)*10);
			$r2 (($this->sueldob / 30.4) * 20);
			$r = $r1 - $r2;
			$result = array('status' => 'success', 'value'=> $r);
			return $result;
		} catch (Exception $e) {
			return $result = array('status' => 'error', 'value'=> $e);
		}
	}
	#Calculo de ISR
	public function getISR($total)
	{
		try {
			$uaa = new UAAModel;
			$prom_men = (($total/15.2)*30.4);
			#buscar el promedio mensual en el tabulador
			$tabulador = $uaa->getItemTabulador( $prom_men );
			
			$lim_inf = $tabulador->limite_inf1;
			$porcentaje = $tabulador->porce_excedente;
			$cuota_f = $tabulador->cuota_fija;
			$subsidio = $tabulador->subsidio;
			$excedente = $prom_men - $lim_inf;
			$imp_marg = (($excedente * $porcentaje) / 100) ;
			$isr_determ = $imp_marg + $cuota_f;
			$isr_prom = $isr_determ - $subsidio ;
			$isr_per = (($isr_prom / 30.4) * 15.2);
			return $isr_per;
		} catch (Exception $e) {
			return $result = array('status' => 'error', 'value'=> $e);
		}
	}
	//
}
?>