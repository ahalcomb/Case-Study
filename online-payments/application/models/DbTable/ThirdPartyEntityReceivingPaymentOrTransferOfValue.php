<?php

class Application_Model_DbTable_ThirdPartyEntityReceivingPaymentOrTransferOfValue extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'third_party_entity_receiving_payment_or_transfer_of_value';
	protected $_primary = 'third_party_entity_receiving_payment_or_transfer_of_value_id';

	// Save the transaction to the database
    public function insertThirdPartyEntityReceivingPaymentOrTransferOfValue($name)
    {
    	//first check if name exists

    	$existing_id = $this->getByName($name);

    	if ($existing_id == false) {
			// Build up data set to be inserted
			$data = array(
				'name' => $name
			);
			return $this->insert($data);
    	} else {
    		return $existing_id["third_party_entity_receiving_payment_or_transfer_of_value_id"];
    	}
    }
	
}