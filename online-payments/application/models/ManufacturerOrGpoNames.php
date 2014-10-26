<?php

class Application_Model_ManufacturerOrGpoNames extends Application_Model_DbTable_ManufacturerOrGpoNames
{
	
	protected $_name = 'manufacturer_or_gpo_names';
	protected $_primary = 'manufacturer_or_gpo_name_id';
	
	public function init()
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$this->table = 'manufacturer_or_gpo_names';
	}
	
	public function getById($id)
	{
		$select = $this->select()->from('manufacturer_or_gpo_names')->where( 'manufacturer_or_gpo_name_id = ?', $id );
		return $this->db->query($select)->fetch();
	}

	public function getByName($name)
	{
		$select = $this->select()->from('manufacturer_or_gpo_names')->where( 'lower(name) = ?', strtolower($name) );
		return $this->db->query($select)->fetch();
	}
	
	public function searchManufacturerGpoName($value){
		$select = $this->select()->from('manufacturer_or_gpo_names')
		->where( 'lower(name) LIKE ?', '%'. strtolower($value) . '%' );
		return $this->db->query($select)->fetchAll();		
	}

}