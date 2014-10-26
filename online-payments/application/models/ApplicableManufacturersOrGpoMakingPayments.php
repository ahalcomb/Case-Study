<?php

class Application_Model_ApplicableManufacturersOrGpoMakingPayments extends Application_Model_DbTable_ApplicableManufacturersOrGpoMakingPayments
{
	
	protected $_name = 'applicable_manufacturers_or_gpo_making_payments';
	protected $_primary = 'applicable_manufacturers_or_gpo_making_payment_id';
	
	public function init()
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$this->table = 'applicable_manufacturers_or_gpo_making_payments';
	}
	
	public function getById($id)
	{
		$select = $this->select()->from('applicable_manufacturers_or_gpo_making_payments')->where( 'applicable_manufacturers_or_gpo_making_payment_id = ?', $id );
		return $this->db->query($select)->fetch();
	}

	public function getByName($name)
	{
		$select = $this->select()->from('applicable_manufacturers_or_gpo_making_payments')->where( 'lower(name) = ?', strtolower($name) );
		return $this->db->query($select)->fetch();
	}
	
	public function searchManuGpoMakingPaymentName($value){

		$this->select()->from('applicable_manufacturers_or_gpo_making_payments')
		->where( 'lower(name) LIKE ?', '%'. strtolower($value) . '%' );

		return $this->db->query($select)->fetchAll();		
	}

	public function searchManuGpoMakingPaymentStateName($value){
		$select = "SELECT * FROM applicable_manufacturers_or_gpo_making_payments 
				   WHERE lower(state) LIKE '%" . strtolower(trim($value)) ."%'";

		$this->select()->from('applicable_manufacturers_or_gpo_making_payments')
		->where( 'lower(state) LIKE ?', '%'. strtolower($value) . '%' );

		return $this->db->query($select)->fetchAll();		
	}

	public function searchManuGpoMakingPaymentCountryName($value){
		$this->select()->from('applicable_manufacturers_or_gpo_making_payments')
		->where( 'lower(country) LIKE ?', '%'. strtolower($value) . '%' );

		return $this->db->query($select)->fetchAll();		
	}

}