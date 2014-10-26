<?php

class Application_Model_ThirdPartyEntityReceivingPaymentOrTransferOfValue extends Application_Model_DbTable_ThirdPartyEntityReceivingPaymentOrTransferOfValue
{
	
	protected $_name = 'third_party_entity_receiving_payment_or_transfer_of_value';
	protected $_primary = 'third_party_entity_receiving_payment_or_transfer_of_value_id';
	
	public function init()
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$this->table = 'third_party_entity_receiving_payment_or_transfer_of_value';
	}
	
	public function getById($id)
	{
		$select = $this->select()->from('third_party_entity_receiving_payment_or_transfer_of_value')->where( 'third_party_entity_receiving_payment_or_transfer_of_value_id = ?', $id );
		return $this->db->query($select)->fetch();
	}

	public function getByName($name)
	{
		$select = $this->select()->from('third_party_entity_receiving_payment_or_transfer_of_value')->where( 'lower(name) = ?', strtolower($name) );
		return $this->db->query($select)->fetch();
	}
	
	public function searchThirdPartyEntityReceivingPaymentOrTransferOfValueName($value){

		$select = $this->select()->from('third_party_entity_receiving_payment_or_transfer_of_value')
		->where( 'lower(name) LIKE ?', '%'. strtolower($value) . '%' );

		return $this->db->query($select)->fetchAll();		
	}

}