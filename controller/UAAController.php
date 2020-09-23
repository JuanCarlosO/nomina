<?php
/**
 * Controlador de Usuarios 
 */
include_once '../model/UAAModel.php';
class UAAController 
{
	protected $model;
	function __construct()
	{
		$this->model = new UAAModel();
	}
	public function getPersonal()
	{
		return $this->model->getPersonal();
	}
	public function getPersonalBy()
	{
		return $this->model->getPersonalBy();
	}
	public function getCatalogo($c_quincena)
	{
		return $this->model->getCatalogo($c_quincena);
	}
	public function getPerDed()
	{
		return $this->model->getPerDed();
	}
	public function getNamesPersonal()
	{
		return $this->model->getNamesPersonal();
	}
	public function saveNivel()
	{
		return $this->model->saveNivel();
	}
	public function getNR()
	{
		return $this->model->getNR();
	}
	public function savePersonal()
	{
		return $this->model->savePersonal();
	}
	public function saveDataFUMP()
	{
		return $this->model->saveDataFUMP();
	}
	public function get_CVE_RFC()
	{
		return $this->model->get_CVE_RFC();
	}
	public function saveEntrada()
	{
		return $this->model->saveEntrada();
	}
	public function saveSalida()
	{
		return $this->model->saveSalida();
	}
	public function getRegistroSP()
	{
		return $this->model->getRegistroSP();
	}
	public function getPerDedBySP()
	{
		return $this->model->getPerDedBySP();
	}
	public function savePD()
	{
		return $this->model->savePD();
	}
	public function saveRegla()
	{
		return $this->model->saveRegla();
	}
	public function savePago()
	{
		return $this->model->savePago();
	}
	
}
?>