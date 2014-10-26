<?php

class Application_Model_PhysicianSpecialities extends Application_Model_DbTable_PhysicianSpecialities
{
	
	protected $_name = 'physician_specialities';
	protected $_primary = 'physician_specialty_id';
	
	public function init()
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$this->table = 'physician_specialities';
	}
	
	public function getById($id)
	{
		$select = $this->select()->from('physician_specialities')->where( 'physician_specialty_id = ?', $id );
		return $this->db->query($select)->fetch();
	}

	public function getByName($name)
	{
		$select = $this->select()->from('physician_specialities')->where( 'lower(name) = ?', strtolower($name) );
		return $this->db->query($select)->fetch();
	}
	
	public function searchSpecialitiesName($value){
		$select = $this->select()->from('physician_specialities')
		->where( 'lower(name) LIKE ?', '%'. strtolower($value) . '%' );

		return $this->db->query($select)->fetchAll();		
	}

}