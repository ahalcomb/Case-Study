<?php

class Application_Model_DbTable_ThirdPartyPaymentRecipientIndicators extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'third_party_payment_recipient_indicators';
	protected $_primary = 'third_party_payment_recipient_indicator_id';

	// Save the transaction to the database
    public function insertThirdPartyPaymentRecipientIndicators($name)
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
    		return $existing_id["third_party_payment_recipient_indicator_id"];
    	}
    }
	
}