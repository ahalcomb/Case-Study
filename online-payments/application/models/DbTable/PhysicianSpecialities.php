<?php

class Application_Model_DbTable_PhysicianSpecialities extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'physician_specialities';
	protected $_primary = 'physician_specialty_id';

	// Save the transaction to the database
    public function insertSpecialitiesHospital($name)
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
    		return $existing_id["physician_specialty_id"];
    	}
    }
	
}