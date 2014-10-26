<?php

class Application_Model_DbTable_PhysicianPrimaryTypes extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'physician_primary_types';
	protected $_primary = 'physician_primary_type_id';

	// Save the transaction to the database
    public function insertPrimaryTypes($name)
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
    		return $existing_id["physician_primary_type_id"];
    	}
    }
	
}