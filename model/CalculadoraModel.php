<?php 
/**
 * Calculadora de financiera
 */
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
	//
}
?>