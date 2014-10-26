<?php

class Application_Model_TeachingHospitals extends Application_Model_DbTable_TeachingHospitals
{
	
	protected $_name = 'teaching_hospitals';
	protected $_primary = 'teaching_hospital_id';
	
	public function init()
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$this->table = 'teaching_hospitals';
	}
	
	public function getById($id)
	{
		$select = $this->select()->from('teaching_hospitals')->where( 'teaching_hospital_id = ?', $id );
		return $this->db->query($select)->fetch();
	}

	public function getByName($name)
	{
		$select = $this->select()->from('teaching_hospitals')->where( 'lower(name) = ?', strtolower($name) );
		return $this->db->query($select)->fetch();
	}
	
	public function searchHospitalsName($value){
		$select = $this->select()->from('teaching_hospitals')
		->where( 'lower(name) LIKE ?', '%'. strtolower($value) . '%' );

		return $this->db->query($select)->fetchAll();		
	}

}