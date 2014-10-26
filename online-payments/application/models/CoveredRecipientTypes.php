<?php

class Application_Model_CoveredRecipientTypes extends Application_Model_DbTable_CoveredRecipientTypes
{
	
	protected $_name = 'covered_recipient_types';
	protected $_primary = 'covered_recipient_type_id';
	
	public function init()
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$this->table = 'covered_recipient_types';
	}
	
	public function getById($id)
	{
		$select = $this->select()->from('covered_recipient_types')->where( 'covered_recipient_type_id = ?', $id );
		return $this->db->query($select)->fetch();
	}

	public function getByName($name)
	{
		$select = $this->select()->from('covered_recipient_types')->where( 'lower(name) = ?', strtolower($name) );
		return $this->db->query($select)->fetch();
	}
	
	public function searchCoveredRecipientTypesName($value){
		$select = $this->select()->from('covered_recipient_types')
		->where( 'lower(name) LIKE ?', '%'. strtolower($value) . '%' );
		
		return $this->db->query($select)->fetchAll();		
	}

}