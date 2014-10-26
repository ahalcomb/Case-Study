<?php

class Application_Model_Recipients extends Application_Model_DbTable_Recipients
{
	
	protected $_name = 'recipients';
	protected $_primary = 'recipient_id';
	
	public function init()
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$this->table = 'recipients';
	}
	
	public function getById($id)
	{
		$select = $this->select()->from('recipients')->where( 'recipient_id = ?', $id );
		return $this->db->query($select)->fetch();
	}

	public function getByInfo($address1, $address2, $city, $state, $country)
	{

		$select = $this->select()->from('recipients')
		->where( 'lower(primary_business_street_address_line1) = ?', strtolower($address1) )
		->where( 'lower(primary_business_street_address_line2) = ?', strtolower($address2) )
		->where( 'lower(city) = ?', strtolower($city) )
		->where( 'lower(state) = ?', strtolower($state) );

		return $this->db->query($select)->fetch();
	}
	
	public function getByCity($city){
		$select = $this->select()->from('recipients')
		->where( 'lower(city) LIKE ?', '%'. strtolower($city) . '%' );

		return $this->db->query($select)->fetchAll();		
	}

	public function getByState($state){
		$select = $this->select()->from('recipients')
		->where( 'lower(state) LIKE ?', '%'. strtolower($state) . '%' );

		return $this->db->query($select)->fetchAll();		
	}

}