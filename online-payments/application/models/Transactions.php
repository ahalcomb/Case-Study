<?php

class Application_Model_Transactions extends Application_Model_DbTable_Transactions
{
	
	protected $_name = 'transactions';
	protected $_primary = 'transaction_id';

	public function init()
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$this->table = 'transactions';
	}
	
	public function getById($id = null)
	{
		if($id) {
			$select = $this->select()->from('transactions')->where( 'transaction_id = ?', $id );
			return $this->db->query($select)->fetch();
		}	
	}

    public function searchFullTransaction($term =null, $start=null, $num_return=unll)
    {
    	$select = $this-> makeQuery($term, $start, $num_return);

		return $this->db->query($select)->fetchAll();
    }

    public function searchTotalTransaction($term = null)
    {

		$select = $this-> makeQuery($term, null, null, true);

		return $this->db->query($select)->fetch();
    }

    private function makeQuery($term = null, $start = null, $num_return= null, $count = false) {

    	$select = $this->select();

    	if ($count == false){
    		$select->from('transactions');
    	} else {
    		$select->from('transactions',array("num"=>"COUNT(*)"));
    	}


    	$select->joinLeft('manufacturer_or_gpo_names', 'transactions.manufacturer_or_gpo_name_id = manufacturer_or_gpo_names.manufacturer_or_gpo_name_id',array('manufacturer_or_gpo_name' => 'name'))
    		->joinLeft('covered_recipient_types', 'transactions.covered_recipient_type_id = covered_recipient_types.covered_recipient_type_id',array('covered_recipient_type' => 'name'))
    		->joinLeft('teaching_hospitals', 'transactions.teaching_hospital_id = teaching_hospitals.teaching_hospital_id',array('teaching_hospital' => 'name'))
    		->joinLeft('physician_profiles', 'transactions.physician_profile_id = physician_profiles.physician_profile_id')
    		->joinLeft('physician_specialities', 'physician_profiles.physician_specialty_id = physician_specialities.physician_specialty_id',array('physician_specialty' => 'name'))
    		->joinLeft('physician_primary_types', 'physician_profiles.physician_primary_type_id = physician_primary_types.physician_primary_type_id',array('physician_primary_type' => 'name'))
			->joinLeft('recipients', 'transactions.recipient_id = recipients.recipient_id',array('r_ad1' => 'primary_business_street_address_line1', 'r_ad2' => 'primary_business_street_address_line2', 'r_city' => 'city', 'r_state' => 'state', 'r_zip' => 'zip', 'r_country' => 'country', 'r_province' => 'province', 'r_postal_code' => 'postal_code'))
    		->joinLeft('product_indicators', 'transactions.product_indicator_id = product_indicators.product_indicator_id',array('product_indicator' => 'name'))
    		->joinLeft('applicable_manufacturers_or_gpo_making_payments', 'transactions.applicable_manufacturer_or_applicable_gpo_making_payment_id = applicable_manufacturers_or_gpo_making_payments.applicable_manufacturers_or_gpo_making_payment_id',array('apm_name' => 'name', 'apm_state' => 'state', 'apm_country' => 'country'))
    		->joinLeft('form_of_payment_or_transfer_of_values', 'transactions.form_of_payment_or_transfer_of_value_id = form_of_payment_or_transfer_of_values.form_of_payment_or_transfer_of_value_id',array('form_of_payment' => 'name'))
    		->joinLeft('nature_of_payment_or_transfer_of_values', 'transactions.nature_of_payment_or_transfer_of_value_id = nature_of_payment_or_transfer_of_values.nature_of_payment_or_transfer_of_value_id',array('nature_of_payment' => 'name'))
    		->joinLeft('third_party_payment_recipient_indicators', 'transactions.third_party_payment_recipient_indicator_id = third_party_payment_recipient_indicators.third_party_payment_recipient_indicator_id',array('third_party_indicators' => 'name'))
    		->joinLeft('third_party_entity_receiving_payment_or_transfer_of_value', 'transactions.third_party_entity_receiving_payment_or_transfer_of_value_id = third_party_entity_receiving_payment_or_transfer_of_value.third_party_entity_receiving_payment_or_transfer_of_value_id',array('third_party_recip_name' => 'name'));


    		if (!is_null($term)) {
    			//Lots of different params to search! Oh my!
    			$select->where("transactions.city_of_travel LIKE ?", '%'.$term.'%')
			        ->orWhere("transactions.state_of_travel LIKE ?", '%'.$term.'%')
			        ->orWhere("transactions.country_of_travel LIKE ?", '%'.$term.'%')
			        ->orWhere("manufacturer_or_gpo_names.name LIKE ?", '%'.$term.'%')
			        ->orWhere("covered_recipient_types.name LIKE ?", '%'.$term.'%')
			        ->orWhere("teaching_hospitals.name LIKE ?", '%'.$term.'%')
			        ->orWhere("primary_business_street_address_line1 LIKE ?", '%'.$term.'%')
			        ->orWhere("primary_business_street_address_line2 LIKE ?", '%'.$term.'%')
			        ->orWhere("recipients.city LIKE ?", '%'.$term.'%')
			        ->orWhere("recipients.state LIKE ?", '%'.$term.'%')
			        ->orWhere("recipients.zip LIKE ?", '%'.$term.'%')
			        ->orWhere("recipients.province LIKE ?", '%'.$term.'%')
			        ->orWhere("recipients.postal_code LIKE ?", '%'.$term.'%')
			        ->orWhere("product_indicators.name LIKE ?", '%'.$term.'%')
			        ->orWhere("physician_profiles.physician_profile_id LIKE ?", '%'.$term.'%')
			        ->orWhere("physician_profiles.physician_first_name LIKE ?", '%'.$term.'%')
			        ->orWhere("physician_profiles.physician_middle_name LIKE ?", '%'.$term.'%')
			        ->orWhere("physician_profiles.physician_last_name LIKE ?", '%'.$term.'%')
			        ->orWhere("physician_profiles.physician_name_suffix LIKE ?", '%'.$term.'%')
			        ->orWhere("physician_profiles.state_code1 LIKE ?", '%'.$term.'%')
			        ->orWhere("physician_profiles.state_code2 LIKE ?", '%'.$term.'%')
			        ->orWhere("physician_profiles.state_code3 LIKE ?", '%'.$term.'%')
			        ->orWhere("physician_profiles.state_code4 LIKE ?", '%'.$term.'%')
			        ->orWhere("physician_profiles.state_code5 LIKE ?", '%'.$term.'%')
			        ->orWhere("transactions.bio_drug LIKE ? AND 'name' <> ? AND 'ndc' <> ?", '%'.$term.'%', 'lower('.$term.')', 'lower('.$term.')')
			        ->orWhere("transactions.medical_supply LIKE ? AND 'name' <> ?", '%'.$term.'%', 'lower('.$term.')')
			        ->orWhere("physician_specialities.name LIKE ?", '%'.$term.'%')
			        ->orWhere("physician_primary_types.name LIKE ?", '%'.$term.'%')
			        ->orWhere("transactions.transaction_id LIKE ?", '%'.$term.'%')
			        ->orWhere("transactions.program_year LIKE ?", '%'.$term.'%')
			        ->orWhere("transactions.payment_publication_date LIKE ?", '%'.$term.'%')
			        ->orWhere("transactions.date_of_payment LIKE ?", '%'.$term.'%')
			        ->orWhere("transactions.contextual_information LIKE ?", '%'.$term.'%')
			        ->orWhere("applicable_manufacturers_or_gpo_making_payments.name LIKE ?", '%'.$term.'%')
			        ->orWhere("applicable_manufacturers_or_gpo_making_payments.state LIKE ?", '%'.$term.'%')
			        ->orWhere("applicable_manufacturers_or_gpo_making_payments.country LIKE ?", '%'.$term.'%')
			        ->orWhere("nature_of_payment_or_transfer_of_values.name LIKE ?", '%'.$term.'%')
			        ->orWhere("form_of_payment_or_transfer_of_values.name LIKE ?", '%'.$term.'%')
			        ->orWhere("third_party_payment_recipient_indicators.name LIKE ?", '%'.$term.'%')
			        ->orWhere("third_party_entity_receiving_payment_or_transfer_of_value.name LIKE ?", '%'.$term.'%');

    		}

	        if (isset($num_return) && isset($start)) {
	        	$select->limit($num_return, $start);
	        }


	        $select->setIntegrityCheck(false);

	        return $select;
    }

}