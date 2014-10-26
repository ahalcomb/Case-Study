<?php

class Application_Model_DbTable_CoveredRecipientTypes extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'covered_recipient_types';
	protected $_primary = 'covered_recipient_type_id';

	// Save the transaction to the database
    public function insertCoveredRecipientTypes($name)
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
    		return $existing_id["covered_recipient_type_id"];
    	}
    }
	
}