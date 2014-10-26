<?php

class Application_Model_DbTable_NatureOfPaymentOrTransferOfValues extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'nature_of_payment_or_transfer_of_values';
	protected $_primary = 'nature_of_payment_or_transfer_of_value_id';

	// Save the transaction to the database
    public function insertNatureOfPaymentOrTransferOfValues($name)
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
    		return $existing_id["nature_of_payment_or_transfer_of_value_id"];
    	}
    }
	
}