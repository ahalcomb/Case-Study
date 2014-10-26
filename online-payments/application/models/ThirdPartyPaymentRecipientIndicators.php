<?php

class Application_Model_ThirdPartyPaymentRecipientIndicators extends Application_Model_DbTable_ThirdPartyPaymentRecipientIndicators
{
	
	protected $_name = 'third_party_payment_recipient_indicators';
	protected $_primary = 'third_party_payment_recipient_indicator_id';
	
	public function init()
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$this->table = 'third_party_payment_recipient_indicators';
	}
	
	public function getById($id)
	{
		$select = $this->select()->from('third_party_payment_recipient_indicators')->where( 'third_party_payment_recipient_indicator_id = ?', $id );
		return $this->db->query($select)->fetch();
	}

	public function getByName($name)
	{
		$select = $this->select()->from('third_party_payment_recipient_indicators')->where( 'lower(name) = ?', strtolower($name) );
		return $this->db->query($select)->fetch();
	}
	
	public function searchThirdPartyPaymentRecipientIndicatorsName($value){

		$select = $this->select()->from('third_party_payment_recipient_indicators')
		->where( 'lower(name) LIKE ?', '%'. strtolower($value) . '%' );

		return $this->db->query($select)->fetchAll();		
	}

}