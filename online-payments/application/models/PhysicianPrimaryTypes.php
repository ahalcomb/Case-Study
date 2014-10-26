<?php

class Application_Model_PhysicianPrimaryTypes extends Application_Model_DbTable_PhysicianPrimaryTypes
{
	
	protected $_name = 'physician_primary_types';
	protected $_primary = 'physician_primary_type_id';
	
	public function init()
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$this->table = 'physician_primary_types';
	}
	
	public function getById($id)
	{
		$select = $this->select()->from('physician_primary_types')->where( 'physician_primary_type_id = ?', $id );
		return $this->db->query($select)->fetch();
	}

	public function getByName($name)
	{
		$select = $this->select()->from('physician_primary_types')->where( 'lower(name) = ?', strtolower($name) );
		return $this->db->query($select)->fetch();
	}
	
	public function searchPhysicianTypesName($value){
		$select = $this->select()->from('physician_primary_types')
		->where( 'lower(name) LIKE ?', '%'. strtolower($value) . '%' );
		
		return $this->db->query($select)->fetchAll();		
	}

}