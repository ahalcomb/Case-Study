<?php

class Application_Model_DbTable_Recipients extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'recipients';
	protected $_primary = 'recipient_id';

	// Save the transaction to the database
    public function insertRecipients($address1, $address2, $city, 
    	$state, $zip, $country, $province, $postal_code)
    {
    	//first check if name exists

    	$existing_id = $this->getByInfo($address1, $address2, $city, $state, $country);

    	if ($existing_id == false) {
			// Build up data set to be inserted
			$data = array(
				'primary_business_street_address_line1' => $address1,
				'primary_business_street_address_line2' => $address2,
				'city' => $city,
				'state' => $state,
				'zip' => $zip,
				'country' => $country,
				'province' => $province,
				'postal_code' => $postal_code
			);
			return $this->insert($data);
    	} else {
    		return $existing_id["recipient_id"];
    	}
    }
	
}