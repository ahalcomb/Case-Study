<?php

class Application_Model_DbTable_Transactions extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'transactions';
	protected $_primary = 'transaction_id';

	// Save the transaction to the database
    public function insertTransaction($data)
    {
		return $this->insert($data);
    }

    public function importTransactions()
    {
		$manufacturer_or_gpo_name_model = new Application_Model_ManufacturerOrGpoNames();
		$covered_recipient_type_model = new Application_Model_CoveredRecipientTypes();
		$teaching_hospital_model = new Application_Model_TeachingHospitals();
		$physician_profile_model = new Application_Model_PhysicianProfiles();
		$product_indicator_model = new Application_Model_ProductIndicators();
		$manufacturers_gpo_payments_model = new Application_Model_ApplicableManufacturersOrGpoMakingPayments();
		$form_of_payment_model = new Application_Model_FormOfPaymentOrTransferOfValues();
		$nature_of_payment_model = new Application_Model_NatureOfPaymentOrTransferOfValues();
		$recipient_model = new Application_Model_Recipients();
		$third_party_recip_indicators_model = new Application_Model_ThirdPartyPaymentRecipientIndicators();
		$third_party_recieving_payment_model = new Application_Model_ThirdPartyEntityReceivingPaymentOrTransferOfValue();
		$term_model = new Application_Model_AutocompleteTerms();

		$download_location = dirname(__FILE__) . '/../../../public/data/payment-data.csv';
		$fp = fopen ($download_location, 'w+');
		//This is the location of the CSV we want from the payments website
		$ch = curl_init('https://openpaymentsdata.cms.gov/api/views/hrpy-hqv8/rows.csv?accessType=DOWNLOAD');
		curl_setopt($ch, CURLOPT_TIMEOUT, 50);
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);

		echo "recieved file\n";

		$header_line = true;

		$start = microtime(true);

		//loop through the new file that we imported
		if (($handle = fopen($download_location, "r")) !== FALSE) {
		    while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
		    	if (!$header_line) {
			        //get information from the CSV into variables
					$general_transaction_id = $data[0];
					//if transaction id already exists then dont insert it...
					if ($this->getById($general_transaction_id) == false) {
						$program_year = $data[1];
						$physician_profile_id = $data[7];
						$physician_first_name = $data[8];
						$physician_middle_name = $data[9];
						$physician_last_name = $data[10];
						$physician_name_suffix = $data[11];
						$physician_specialty = $data[21];
						$physician_primary_type = $data[20];
						$physician_license_state_code_ar = array($data[22], $data[23], $data[24], $data[25], $data[26]);
						$recipient_primary_business_street_address_line1 = $data[12];
						$recipient_primary_business_street_address_line2 = $data[13];
						$recipient_city = $data[14];
						$recipient_state = $data[15];
						$recipient_zip_code = $data[16];
						$recipient_country = $data[17];
						$recipient_province = $data[18];
						$recipient_postal_code = $data[19];
						$pub_date_array = explode("/",$data[2]);
						$name_drug_or_biological1 = $data[28];
						$name_drug_or_biological2 = $data[29];
						$name_drug_or_biological3 = $data[30];
						$name_drug_or_biological4 = $data[31];
						$name_drug_or_biological5 = $data[32];
						$ndc_drug_or_biological1 = $data[33];
						$ndc_drug_or_biological2 = $data[34];
						$ndc_drug_or_biological3 = $data[35];
						$ndc_drug_or_biological4 = $data[36];
						$ndc_drug_or_biological5 = $data[37];
						$name_medical_supply1 = $data[38];
						$name_medical_supply2 = $data[39];
						$name_medical_supply3 =$data[40];
						$name_medical_supply4 = $data[41];
						$name_medical_supply5 = $data[42];
						$manufacturer_payment_name = $data[43];
						$manufacturer_payment_id = $data[44];
						$manufacturer_payment_state = $data[45];
						$manufacturer_payment_country = $data[46];
						$city_of_travel = $data[53];
						$state_of_travel = $data[54];
						$country_of_travel = $data[55];
						$physician_ownership_indicator = ($data[56] == "Yes") ? $data[56] = 1: $data[56] = 0;
						$name_of_third_party_entity_receiving_payment_or_transfer_of_value = $data[58];
						$dispute_status_for_publication = ($data[47] == "Yes") ? $data[47] = 1: $data[47] = 0;
						$total_amount_of_payment_usdollars = str_replace('$', '', $data[48]);
						$pay_date_array = explode("/",$data[49]);
						$date_of_payment = $pay_date_array[2] . "-" . $pay_date_array[0] . "-" . $pay_date_array[1];
						$number_of_payments_included_in_total_amount = $data[50];
						$charity_indicator = ($data[59] == "Yes") ? $data[59] = 1: $data[59] = 0;
						$third_party_equals_covered_recipient_indicator = ($data[60] == "Yes") ? $data[60] = 1: $data[60] = 0;
						$contextual_information = $data[61];
						$delay_in_publication_of_general_payment_indicator = ($data[62] == "Yes") ? $data[62] = 1: $data[62] = 0;
						$term_arr = array($data[2],$data[3],$data[7],$data[8],$data[9],$data[10],$data[11],$data[21],
									$data[22],$data[23],$data[24],$data[25],$data[26],$data[12],$data[13],
									$data[14],$data[15],$data[16],$data[17],$data[18],$data[19],$data[21],
									$data[27],$data[28],$data[29],$data[30],$data[31],$data[32],$data[33],
									$data[34],$data[35],$data[36],$data[37],$data[38],$data[39],$data[41],
									$data[42],$data[43],$data[44],$data[45],$data[46],$data[53],$data[54],$data[55]);
						$biological_drug_array = array(array('name'=>$name_drug_or_biological1, 'ndc'=>$ndc_drug_or_biological1),
														array('name'=>$name_drug_or_biological2, 'ndc'=>$ndc_drug_or_biological2),
														array('name'=>$name_drug_or_biological3, 'ndc'=>$ndc_drug_or_biological3),
														array('name'=>$name_drug_or_biological4, 'ndc'=>$ndc_drug_or_biological4),
														array('name'=>$name_drug_or_biological5, 'ndc'=>$ndc_drug_or_biological5));

						$medical_supply_array = array(array( 'name'=> $name_medical_supply1 ),
														array( 'name'=> $name_medical_supply2 ),
														array( 'name'=> $name_medical_supply3 ),
														array( 'name'=> $name_medical_supply4 ),
														array( 'name'=> $name_medical_supply5 ));

						$payment_publication_date = $pub_date_array[2] . "-" . $pub_date_array[0] . "-" . $pub_date_array[1];
						$manufacturer_or_gpo_id = $manufacturer_or_gpo_name_model->insertManufacturerOrGpoNames($data[3]);
						$covered_recipient_type_id = $covered_recipient_type_model->insertCoveredRecipientTypes($data[4]);

						$teaching_hospital_id = null;
						if ($data[5]) {
							$teaching_hospital_id = $teaching_hospital_model->insertTeachingHospital($data[5], $data[6]);
							$term_arr[] = $data[5];
							$term_arr[] = $data[6];
						}			

						$physician_profile_model->insertPhysician($physician_profile_id, $physician_first_name, $physician_middle_name, $physician_last_name, $physician_name_suffix,
						$physician_specialty, $physician_primary_type, $physician_license_state_code_ar);

						$recipient_id = $recipient_model->insertRecipients($recipient_primary_business_street_address_line1, $recipient_primary_business_street_address_line2, 
																		$recipient_city, $recipient_state, 
																		$recipient_zip_code, $recipient_country, $recipient_province, $recipient_postal_code);

						$product_indicator_id = $product_indicator_model->insertProductIndicators($data[27]);
						$manufacturers_gpo_payments_model->insertDrugOrBiologicals($manufacturer_payment_id, $manufacturer_payment_name, $manufacturer_payment_state, $manufacturer_payment_country);
						// $form_of_payment_or_transfer_of_value = $data[51];
						$form_of_payment_id = $form_of_payment_model->insertFormOfPaymentOrTransferOfValues($data[51]);
						$nature_of_payment_id = $nature_of_payment_model->insertNatureOfPaymentOrTransferOfValues($data[52]);
						$third_party_payment_recipient_indicator_id = $third_party_recip_indicators_model->insertThirdPartyPaymentRecipientIndicators($data[57]);
						$third_party_recieving_payment_id = $third_party_recieving_payment_model->insertThirdPartyEntityReceivingPaymentOrTransferOfValue($name_of_third_party_entity_receiving_payment_or_transfer_of_value);

						$term_model->insertTerms($term_arr);

						$data = array (
							'transaction_id'=> $general_transaction_id,
							'program_year'=> $program_year,
							'payment_publication_date'=>$payment_publication_date,
							'teaching_hospital_id'=> $teaching_hospital_id,
							'manufacturer_or_gpo_name_id'=> $manufacturer_or_gpo_id,
							'covered_recipient_type_id'=> $covered_recipient_type_id,
							'physician_profile_id'=> $physician_profile_id,
							'product_indicator_id'=> $product_indicator_id,
							'applicable_manufacturer_or_applicable_gpo_making_payment_id'=> $manufacturer_payment_id,
							'form_of_payment_or_transfer_of_value_id'=> $form_of_payment_id,
							'nature_of_payment_or_transfer_of_value_id'=> $nature_of_payment_id,
							'state_of_travel'=> $state_of_travel,
							'city_of_travel'=> $city_of_travel,
							'country_of_travel'=> $country_of_travel,
							'physician_ownership_indicator' => $physician_ownership_indicator,
							'charity_indicator' => $charity_indicator,
							'third_party_equals_covered_recipient_indicator' => $third_party_equals_covered_recipient_indicator,
							'contextual_information'=> $contextual_information,
							'delay_in_publication_of_general_payment_indicator'=>$delay_in_publication_of_general_payment_indicator,
							'dispute_status_for_publication' =>$dispute_status_for_publication,
							'total_amount_of_payment_usdollars'=>$total_amount_of_payment_usdollars,
							'date_of_payment'=>$date_of_payment,
							'number_of_payments_included_in_total_amount'=> $number_of_payments_included_in_total_amount,
							'recipient_id' => $recipient_id,
							'third_party_payment_recipient_indicator_id'=>$third_party_payment_recipient_indicator_id,
							'third_party_entity_receiving_payment_or_transfer_of_value_id'=>$third_party_recieving_payment_id,
							'third_party_entity_receiving_payment_or_transfer_of_value_id'=>$third_party_recieving_payment_id,
							'bio_drug'=>json_encode($biological_drug_array),
							'medical_supply'=>json_encode($medical_supply_array)
							);

						$trans_id = $this->insert($data);

						echo "\nTransaction id: " . $trans_id;
					} else {
						echo "Transaction already exists...\n";
					}
				} else {
					$header_line = false;
				}
		    }

		    $time_elapsed_us = (microtime(true) - $start)/60;

		    echo "\nAdding data took this much time: " . $time_elapsed_us;
		    fclose($handle);
		}

		return true;

		//okay now we have the file, now to add to db...
    }
	
}