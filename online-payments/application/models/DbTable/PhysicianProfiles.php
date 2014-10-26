<?php

class Application_Model_DbTable_PhysicianProfiles extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'physician_profiles';
	protected $_primary = 'physician_profile_id';

	// Save the transaction to the database
    public function insertPhysician($id, $first_name, $middle_name, $last_name, $suffix,
    	$specialty, $primary_type, $state_code_ar)
    {
    	//first check if name exists

    	$existing_id = $this->getById($id);

    	if ($existing_id == false) {

    		//need to get specialty id
    		$physician_specialty_model = new Application_Model_PhysicianSpecialities();
    		$specialty_id = $physician_specialty_model->insertSpecialitiesHospital($specialty);

    		//need to get primary_type id
    		$primary_type_model = new Application_Model_PhysicianPrimaryTypes();
    		$physician_primary_type_id = $primary_type_model->insertPrimaryTypes($primary_type);

			// Build up data set to be inserted
			$data = array(
				'physician_profile_id'=>$id,
				'physician_first_name' => $first_name,
				'physician_middle_name' => $middle_name,
				'physician_last_name' => $last_name,
				'physician_name_suffix' => $suffix,
				'physician_specialty_id' => $specialty_id,
				'physician_primary_type_id' => $physician_primary_type_id,
                'state_code1'=> $state_code_ar[0],
                'state_code2'=> $state_code_ar[1],
                'state_code3'=> $state_code_ar[2],
                'state_code4'=> $state_code_ar[3],
                'state_code5'=> $state_code_ar[4]
			);
			$physician_profile_id = $this->insert($data);

    		return $physician_profile_id;		
    	} else {
    		return $existing_id["physician_profile_id"];
    	}
    }
	
}