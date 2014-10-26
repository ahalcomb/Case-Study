<?php

class Application_Model_PhysicianProfiles extends Application_Model_DbTable_PhysicianProfiles
{
	
	protected $_name = 'physician_profiles';
	protected $_primary = 'physician_profile_id';
	
	public function init()
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$this->table = 'physician_profiles';
	}
	
	public function getById($id)
	{
		$select = $this->select()->from('physician_profiles')
		->where( 'physician_profile_id = ?', $id );
		return $this->db->query($select)->fetch();
	}

	public function getByName($name)
	{
		$select = $this->select()->from('physician_profiles')
		->where( 'lower(physician_first_name) = ?', strtolower($name) );
		return $this->db->query($select)->fetch();
	}

}