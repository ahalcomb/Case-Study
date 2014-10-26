<?php

class Application_Model_DbTable_ProductIndicators extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'product_indicators';
	protected $_primary = 'product_indicator_id';

	// Save the transaction to the database
    public function insertProductIndicators($name)
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
    		return $existing_id["product_indicator_id"];
    	}
    }
	
}