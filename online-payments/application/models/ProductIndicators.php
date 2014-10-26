<?php

class Application_Model_ProductIndicators extends Application_Model_DbTable_ProductIndicators
{
	
	protected $_name = 'product_indicators';
	protected $_primary = 'product_indicator_id';
	
	public function init()
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$this->table = 'product_indicators';
	}
	
	public function getById($id)
	{
		$select = $this->select()->from('product_indicators')->where( 'product_indicator_id = ?', $id );
		return $this->db->query($select)->fetch();
	}

	public function getByName($name)
	{
		$select = $this->select()->from('product_indicators')->where( 'lower(name) = ?', strtolower($name) );
		return $this->db->query($select)->fetch();
	}
	
	public function searchInidicatorsName($value){
		$select = $this->select()->from('product_indicators')
		->where( 'lower(name) LIKE ?', '%'. strtolower($value) . '%' );

		return $this->db->query($select)->fetchAll();		
	}

}