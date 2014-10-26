<?php

class Application_Model_NatureOfPaymentOrTransferOfValues extends Application_Model_DbTable_NatureOfPaymentOrTransferOfValues
{
	
	protected $_name = 'nature_of_payment_or_transfer_of_values';
	protected $_primary = 'nature_of_payment_or_transfer_of_value_id';
	
	public function init()
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$this->table = 'nature_of_payment_or_transfer_of_values';
	}
	
	public function getById($id)
	{
		$select = $this->select()->from('nature_of_payment_or_transfer_of_values')->where( 'nature_of_payment_or_transfer_of_value_id = ?', $id );
		return $this->db->query($select)->fetch();
	}

	public function getByName($name)
	{
		$select = $this->select()->from('nature_of_payment_or_transfer_of_values')->where( 'lower(name) = ?', strtolower($name) );
		return $this->db->query($select)->fetch();
	}

}