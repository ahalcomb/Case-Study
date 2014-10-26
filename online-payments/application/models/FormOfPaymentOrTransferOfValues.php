<?php

class Application_Model_FormOfPaymentOrTransferOfValues extends Application_Model_DbTable_FormOfPaymentOrTransferOfValues
{
	
	protected $_name = 'form_of_payment_or_transfer_of_values';
	protected $_primary = 'form_of_payment_or_transfer_of_value_id';
	
	public function init()
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$this->table = 'form_of_payment_or_transfer_of_values';
	}
	
	public function getById($id)
	{
		$select = $this->select()->from('form_of_payment_or_transfer_of_values')->where( 'form_of_payment_or_transfer_of_value_id = ?', $id );
		return $this->db->query($select)->fetch();
	}

	public function getByName($name)
	{
		$select = $this->select()->from('form_of_payment_or_transfer_of_values')->where( 'lower(name) = ?', strtolower($name) );
		return $this->db->query($select)->fetch();
	}

}