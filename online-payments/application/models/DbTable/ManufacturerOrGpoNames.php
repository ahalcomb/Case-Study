<?php

class Application_Model_DbTable_ManufacturerOrGpoNames extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'manufacturer_or_gpo_names';
	protected $_primary = 'manufacturer_or_gpo_name_id';

	// Save the transaction to the database
    public function insertManufacturerOrGpoNames($name)
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
    		return $existing_id["manufacturer_or_gpo_name_id"];
    	}
    }
	
}