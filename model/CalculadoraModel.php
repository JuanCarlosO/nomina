<?php 
/**
 * Calculadora de financiera
 */
class CalculadoraModel
{
	private $sueldob;
	private $dias = 30.4;
	protected $result;
	protected function definePrimaVac_uno($sb)
	{
		try {
			$this->sueldob = $sb;
			$producto = 12.5;
			$r = (($this->sueldob/$dias)*$producto);
			$result = array('status' => 'success', 'value'=> $r);
		} catch (Exception $e) {
			return $result = array('status' => 'error', 'value'=> $e);
		}
	}
}
?>