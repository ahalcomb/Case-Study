<?php

class Application_Model_DbTable_ApplicableManufacturersOrGpoMakingPayments extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'applicable_manufacturers_or_gpo_making_payments';
	protected $_primary = 'applicable_manufacturers_or_gpo_making_payment_id';

	// Save the transaction to the database
    public function insertDrugOrBiologicals($id, $name, $state, $country)
    {
    	//first check if name exists

    	$existing_id = $this->getById($id);

    	// var_dump($id, $existing_id);die();

    	if ($existing_id == false) {
			// Build up data set to be inserted

			$data = array(
				'applicable_manufacturers_or_gpo_making_payment_id'=>$id,
				'name' => $name,
				'state' => $state,
				'country' => $country
			);			return $this->insert($data);
    	} else {
    		return $existing_id["applicable_manufacturers_or_gpo_making_payment_id"];
    	}
    }
	
}