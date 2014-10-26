<?php

class Application_Model_DbTable_TeachingHospitals extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'teaching_hospitals';
	protected $_primary = 'teaching_hospital_id';

	// Save the transaction to the database
    public function insertTeachingHospital($id, $name)
    {
    	//first check if name exists

    	$existing_id = $this->getById($id);

    	if ($existing_id == false) {
			// Build up data set to be inserted
			$data = array(
				'teaching_hospital_id'=>$id,
				'name' => $name
			);
			return $this->insert($data);
    	} else {
    		return $existing_id["teaching_hospital_id"];
    	}
    }
	
}