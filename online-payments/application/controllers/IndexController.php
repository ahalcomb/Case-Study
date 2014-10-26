<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {

    }

    public function downloadXlsAction()
    {
    	ini_set('memory_limit', '2048M');// had to increse memory limit since these XLS files can get big...
    	set_time_limit( 0 );

    	$this->_helper->viewRenderer->setNoRender(true);

    	$transaction_model = new Application_Model_Transactions();

    	$params = $this->getRequest()->getParams();
    	$term = $params['term'];
    	$search_result  = array();
		$last_count = 2000;
		$offset = 0;
		$finalData = array();
		$header = true;

		$filename = TMP_PATH . "/payment_data_" . date('Ymd_his') . ".xls";
		$ret_filename = "/online-payments/public/tmp/payment_data_" . date('Ymd_his') . ".xls";

		if ($term) {
			$filename = TMP_PATH . "/payment_data_search_term_" . str_replace(' ', '_', $term). "_" . date('Ymd_his') . ".xls";
			$ret_filename = "/online-payments/public/tmp/payment_data_search_term_" . str_replace(' ', '_', $term). "_" . date('Ymd_his') . ".xls";
		} else {
			$term = null;
		}

		$realPath = realpath( $filename );
		 
		if ( false === $realPath )
		{
			touch( $filename );
			chmod( $filename, 0777 );
		}
		 
		$filename = realpath( $filename );
		$handle = fopen( $filename, "a+" );//since we are adding in segments, add to end of file...

		//we only want to get 2000 at a time to write to file... otherwise the array is WAY too big...
		while ($last_count >= 2000) {

			$search_result = $transaction_model->searchFullTransaction($term, $offset*2000, 2000);
			$last_count = count($search_result);

			// var_dump($search_result);die()

			$xls_array = $this->prepXlsArray($search_result);
			 
			foreach ( $xls_array  AS $xls_row )
			{
				if ($header == true) {
					fputcsv( $handle, array_keys($xls_row), "\t" );
					$header = false;
				}
				fputcsv( $handle, $xls_row, "\t" );
			}
			$offset++;
		}
		 
		fclose( $handle );
		 
		$this->getResponse()->setRawHeader( "Content-Type: application/vnd.ms-excel; charset=UTF-8" )
		->setRawHeader( "Content-Disposition: attachment; filename=excel.xls" )
		->setRawHeader( "Content-Transfer-Encoding: binary" )
		->setRawHeader( "Expires: 0" )
		->setRawHeader( "Cache-Control: must-revalidate, post-check=0, pre-check=0" )
		->setRawHeader( "Pragma: public" )
		->setRawHeader( "Content-Length: " . filesize( $filename ) )
		->sendResponse();
		 
		echo $ret_filename;

    }

    public function autocompleteAjaxAction()
    {
    	$this->_helper->viewRenderer->setNoRender(true);
    	$params = $this->getRequest()->getParams();

    	$term = $params['query'];
    	echo json_encode($this->getAutocomplete($term));

    }

    private function getAutocomplete($term)
    {
    	$this->_helper->viewRenderer->setNoRender(true);

    	$term_model = new Application_Model_AutocompleteTerms();

    	// //need to build search array to return...
    	return $term_model->searchTerms($term);

    }

    public function searchTransactionsAjaxAction()
    {
    	$this->_helper->viewRenderer->setNoRender(true);
    	$params = $this->getRequest()->getParams();

    	$transaction_model = new Application_Model_Transactions();

    	$length = $params['length'];
    	$start_at = $params['start'];

    	$return_obj = new stdClass;
    	$return_obj->draw = $params['draw'];
		$return_obj->data = array();
		$term = $params['search']['value'];


		$search_t = $transaction_model->searchTotalTransaction($term);
		$search = $transaction_model->searchFullTransaction($term, $start_at, $length);

		$search_total = $search_t["num"];
    	$return_obj->recordsTotal=$search_total;
    	$return_obj->recordsFiltered=$search_total;

		$num = 0;

		//put returned data in format for the table.

		foreach ($search as $key => $result) {
			$return_obj->data[$num] = new stdClass;

			$bio_drug = json_decode($result["bio_drug"], true);
			$medical_supply = json_decode($result["medical_supply"], true);

			//setup object data rows...
			$return_obj->data[$num]->General_Transaction_ID = $result['transaction_id'];
			$return_obj->data[$num]->Program_Year = $result ["program_year"];
			$return_obj->data[$num]->Payment_Publication_Date = $result["payment_publication_date"];
			$return_obj->data[$num]->Submitting_Applicable_Manufacturer_or_Applicable_GPO_Name = $result["manufacturer_or_gpo_name"];
			$return_obj->data[$num]->Covered_Recipient_Type = $result["covered_recipient_type"];
			$return_obj->data[$num]->Teaching_Hospital_ID = $result["teaching_hospital_id"];
			$return_obj->data[$num]->Teaching_Hospital_Name = $result["teaching_hospital"];
			$return_obj->data[$num]->Physician_Profile_ID = $result["physician_profile_id"];
			$return_obj->data[$num]->Physician_First_Name = $result["physician_first_name"];
			$return_obj->data[$num]->Physician_Middle_Name = $result["physician_middle_name"];
			$return_obj->data[$num]->Physician_Last_Name = $result["physician_last_name"];
			$return_obj->data[$num]->Physician_Name_Suffix = $result["physician_name_suffix"];
			$return_obj->data[$num]->Recipient_Primary_Business_Street_Address_Line1 = $result["r_ad1"];
			$return_obj->data[$num]->Recipient_Primary_Business_Street_Address_Line2 = $result["r_ad2"];
			$return_obj->data[$num]->Recipient_City = $result["r_city"];
			$return_obj->data[$num]->Recipient_State = $result["r_state"];
			$return_obj->data[$num]->Recipient_Zip_Code = $result["r_zip"];
			$return_obj->data[$num]->Recipient_Country = $result["r_country"];
			$return_obj->data[$num]->Recipient_Province = $result["r_province"];
			$return_obj->data[$num]->Recipient_Postal_Code = $result["r_postal_code"];
			$return_obj->data[$num]->Physician_Primary_Type = $result["physician_primary_type"];
			$return_obj->data[$num]->Physician_Specialty = $result["physician_specialty"];
			$return_obj->data[$num]->Physician_License_State_code1 = $result["state_code1"];
			$return_obj->data[$num]->Physician_License_State_code2 = $result["state_code2"];
			$return_obj->data[$num]->Physician_License_State_code3 = $result["state_code3"];
			$return_obj->data[$num]->Physician_License_State_code4 = $result["state_code4"];
			$return_obj->data[$num]->Physician_License_State_code5 = $result["state_code5"];
			$return_obj->data[$num]->Product_Indicator = $result["product_indicator"];
			$return_obj->data[$num]->Name_of_Associated_Covered_Drug_or_Biological1 = $bio_drug[0]['name'];
			$return_obj->data[$num]->Name_of_Associated_Covered_Drug_or_Biological2 = $bio_drug[1]['name'];
			$return_obj->data[$num]->Name_of_Associated_Covered_Drug_or_Biological3 = $bio_drug[2]['name'];
			$return_obj->data[$num]->Name_of_Associated_Covered_Drug_or_Biological4 = $bio_drug[3]['name'];
			$return_obj->data[$num]->Name_of_Associated_Covered_Drug_or_Biological5 = $bio_drug[4]['name'];
			$return_obj->data[$num]->NDC_of_Associated_Covered_Drug_or_Biological1 = $bio_drug[0]['ndc'];
			$return_obj->data[$num]->NDC_of_Associated_Covered_Drug_or_Biological2 = $bio_drug[1]['ndc'];
			$return_obj->data[$num]->NDC_of_Associated_Covered_Drug_or_Biological3 = $bio_drug[2]['ndc'];
			$return_obj->data[$num]->NDC_of_Associated_Covered_Drug_or_Biological4 = $bio_drug[3]['ndc'];
			$return_obj->data[$num]->NDC_of_Associated_Covered_Drug_or_Biological5 = $bio_drug[4]['ndc'];
			$return_obj->data[$num]->Name_of_Associated_Covered_Device_or_Medical_Supply1 = $medical_supply[0]['name'];
			$return_obj->data[$num]->Name_of_Associated_Covered_Device_or_Medical_Supply2 = $medical_supply[1]['name'];
			$return_obj->data[$num]->Name_of_Associated_Covered_Device_or_Medical_Supply3 = $medical_supply[2]['name'];
			$return_obj->data[$num]->Name_of_Associated_Covered_Device_or_Medical_Supply4 = $medical_supply[3]['name'];
			$return_obj->data[$num]->Name_of_Associated_Covered_Device_or_Medical_Supply5 = $medical_supply[4]['name'];
			$return_obj->data[$num]->Applicable_Manufacturer_or_Applicable_GPO_Making_Payment_Name = $result["apm_name"];
			$return_obj->data[$num]->Applicable_Manufacturer_or_Applicable_GPO_Making_Payment_ID = $result["applicable_manufacturers_or_gpo_making_payment_id"];
			$return_obj->data[$num]->Applicable_Manufacturer_or_Applicable_GPO_Making_Payment_State = $result["apm_state"];
			$return_obj->data[$num]->Applicable_Manufacturer_or_Applicable_GPO_Making_Payment_Country = $result["apm_country"];
			$return_obj->data[$num]->Dispute_Status_for_Publication = ($data["dispute_status_for_publication"] == '1') ? $result["dispute_status_for_publication"] = 'Yes': $result["dispute_status_for_publication"] = 'No';
			$return_obj->data[$num]->Total_Amount_of_Payment_USDollars = '$'.$result["total_amount_of_payment_usdollars"];
			$return_obj->data[$num]->Date_of_Payment = $result["date_of_payment"];
			$return_obj->data[$num]->Number_of_Payments_Included_in_Total_Amount = $result["number_of_payments_included_in_total_amount"];
			$return_obj->data[$num]->Form_of_Payment_or_Transfer_of_Value = $result["form_of_payment"];
			$return_obj->data[$num]->Nature_of_Payment_or_Transfer_of_Value = $result["nature_of_payment"];
			$return_obj->data[$num]->City_of_Travel = $result["city_of_travel"];
			$return_obj->data[$num]->State_of_Travel = $result["state_of_travel"];
			$return_obj->data[$num]->Country_of_Travel = $result["country_of_travel"];
			$return_obj->data[$num]->Physician_Ownership_Indicator = ($data["physician_ownership_indicator"] == '1') ? $result["physician_ownership_indicator"] = 'Yes': $result["physician_ownership_indicator"] = 'No';
			$return_obj->data[$num]->Third_Party_Payment_Recipient_Indicator = ($data["third_party_indicators"] == '1') ? $result["third_party_indicators"] = 'Yes': $result["third_party_indicators"] = 'No';
			$return_obj->data[$num]->Name_of_Third_Party_Entity_Receiving_Payment_or_Transfer_of_Value = $result["third_party_recip_name"];
			$return_obj->data[$num]->Charity_Indicator = ($data["charity_indicator"] == '1') ? $result["charity_indicator"] = 'Yes': $result["charity_indicator"] = 'No';
			$return_obj->data[$num]->Third_Party_Equals_Covered_Recipient_Indicator = ($data["third_party_equals_covered_recipient_indicator"] == '1') ? $result["third_party_equals_covered_recipient_indicator"] = 'Yes': $result["third_party_equals_covered_recipient_indicator"] = 'No';
			$return_obj->data[$num]->Contextual_Information = $result["contextual_information"];
			$return_obj->data[$num]->Delay_in_Publication_of_General_Payment_Indicator = ($data["delay_in_publication_of_general_payment_indicator"] == '1') ? $result["delay_in_publication_of_general_payment_indicator"] = 'Yes': $result["delay_in_publication_of_general_payment_indicator"] = 'No';
			$num++;
		}

		echo json_encode($return_obj);

    }

    public function importAjaxAction()
    {
    	$this->_helper->viewRenderer->setNoRender(true);
    	
		$transaction_model = new Application_Model_Transactions();
		$transaction_model->importTransactions();

    }

	private function prepXlsArray($search_result)
	{
		$return = array();
		foreach ($search_result as $key => $result) {

			$bio_drug = json_decode($result["bio_drug"], true);
			$medical_supply = json_decode($result["medical_supply"], true);

			$return[] = array(
				'General_Transaction_ID' => utf8_decode($result['transaction_id']),
				'Program_Year' => utf8_decode($result["program_year"]),
				'Payment_Publication_Date' => utf8_decode($result["payment_publication_date"]),
				'Submitting_Applicable_Manufacturer_or_Applicable_GPO_Name' => utf8_decode($result["manufacturer_or_gpo_name"]),
				'Covered_Recipient_Type' => utf8_decode($result["covered_recipient_type"]),
				'Teaching_Hospital_ID' => utf8_decode($result["teaching_hospital_id"]),
				'Teaching_Hospital_Name' => utf8_decode($result["teaching_hospital"]),
				'Physician_Profile_ID' => utf8_decode($result["physician_profile_id"]),
				'Physician_First_Name' => utf8_decode($result["physician_first_name"]),
				'Physician_Middle_Name' => utf8_decode($result["physician_middle_name"]),
				'Physician_Last_Name' => utf8_decode($result["physician_last_name"]),
				'Physician_Name_Suffix' => utf8_decode($result["physician_name_suffix"]),
				'Recipient_Primary_Business_Street_Address_Line1' => utf8_decode($result["r_ad1"]),
				'Recipient_Primary_Business_Street_Address_Line2' => utf8_decode($result["r_ad2"]),
				'Recipient_City' => utf8_decode($result["r_city"]),
				'Recipient_State' => utf8_decode($result["r_state"]),
				'Recipient_Zip_Code' => utf8_decode($result["r_zip"]),
				'Recipient_Country' => utf8_decode($result["r_country"]),
				'Recipient_Province' => utf8_decode($result["r_province"]),
				'Recipient_Postal_Code' => utf8_decode($result["r_postal_code"]),
				'Physician_Primary_Type' => utf8_decode($result["physician_primary_type"]),
				'Physician_Specialty' => utf8_decode($result["physician_specialty"]),
				'Physician_License_State_code1' => utf8_decode($result["state_code1"]), 
				'Physician_License_State_code2' => utf8_decode($result["state_code2"]), 
				'Physician_License_State_code3' => utf8_decode($result["state_code3"]), 
				'Physician_License_State_code4' => utf8_decode($result["state_code4"]), 
				'Physician_License_State_code5' => utf8_decode($result["state_code5"]), 
				'Product_Indicator' => utf8_decode($result["product_indicator"]),
				'Name_of_Associated_Covered_Drug_or_Biological1' => utf8_decode($bio_drug[0]['name']),
				'Name_of_Associated_Covered_Drug_or_Biological2' => utf8_decode($bio_drug[1]['name']),
				'Name_of_Associated_Covered_Drug_or_Biological3' => utf8_decode($bio_drug[2]['name']),
				'Name_of_Associated_Covered_Drug_or_Biological4' => utf8_decode($bio_drug[3]['name']),
				'Name_of_Associated_Covered_Drug_or_Biological5' => utf8_decode($bio_drug[4]['name']),
				'NDC_of_Associated_Covered_Drug_or_Biological1' => utf8_decode($bio_drug[0]['ndc']),
				'NDC_of_Associated_Covered_Drug_or_Biological2' => utf8_decode($bio_drug[1]['ndc']),
				'NDC_of_Associated_Covered_Drug_or_Biological3' => utf8_decode($bio_drug[2]['ndc']),
				'NDC_of_Associated_Covered_Drug_or_Biological4' => utf8_decode($bio_drug[3]['ndc']),
				'NDC_of_Associated_Covered_Drug_or_Biological5' => utf8_decode($bio_drug[4]['ndc']),
				'Name_of_Associated_Covered_Device_or_Medical_Supply1' => utf8_decode($medical_supply[0]['name']),
				'Name_of_Associated_Covered_Device_or_Medical_Supply2' => utf8_decode($medical_supply[1]['name']),
				'Name_of_Associated_Covered_Device_or_Medical_Supply3' => utf8_decode($medical_supply[2]['name']),
				'Name_of_Associated_Covered_Device_or_Medical_Supply4' => utf8_decode($medical_supply[3]['name']),
				'Name_of_Associated_Covered_Device_or_Medical_Supply5' => utf8_decode($medical_supply[4]['name']),
				'Applicable_Manufacturer_or_Applicable_GPO_Making_Payment_Name' => utf8_decode($result["apm_name"]),
				'Applicable_Manufacturer_or_Applicable_GPO_Making_Payment_ID' => utf8_decode($result["applicable_manufacturers_or_gpo_making_payment_id"]),
				'Applicable_Manufacturer_or_Applicable_GPO_Making_Payment_State' => utf8_decode($result["apm_state"]),
				'Applicable_Manufacturer_or_Applicable_GPO_Making_Payment_Country' => utf8_decode($result["apm_country"]),
				'Dispute_Status_for_Publication' => ($data["dispute_status_for_publication"] == '1') ? 'Yes': 'No',
				'Total_Amount_of_Payment_USDollars' => utf8_decode('$'.$result["total_amount_of_payment_usdollars"]),
				'Date_of_Payment' => utf8_decode($result["date_of_payment"]),
				'Number_of_Payments_Included_in_Total_Amount' => utf8_decode($result["number_of_payments_included_in_total_amount"]),
				'Form_of_Payment_or_Transfer_of_Value' => utf8_decode($result["form_of_payment"]),
				'Nature_of_Payment_or_Transfer_of_Value' => utf8_decode($result["nature_of_payment"]),
				'City_of_Travel' => utf8_decode($result["city_of_travel"]),
				'State_of_Travel' => utf8_decode($result["state_of_travel"]),
				'Country_of_Travel' => utf8_decode($result["country_of_travel"]),
				'Physician_Ownership_Indicator' => ($data["physician_ownership_indicator"] == '1') ?  'Yes': 'No',
				'Third_Party_Payment_Recipient_Indicator' => ($data["third_party_indicators"] == '1') ? 'Yes': 'No',
				'Name_of_Third_Party_Entity_Receiving_Payment_or_Transfer_of_Value' => utf8_decode($result["third_party_recip_name"]),
				'Charity_Indicator' => ($data["charity_indicator"] == '1') ?  'Yes': 'No',
				'Third_Party_Equals_Covered_Recipient_Indicator' => ($data["third_party_equals_covered_recipient_indicator"] == '1') ?  'Yes': 'No',
				'Contextual_Information' => utf8_decode($result["contextual_information"]),
				'Delay_in_Publication_of_General_Payment_Indicator' => ($data["delay_in_publication_of_general_payment_indicator"] == '1') ? 'Yes': 'No'
			);
		}

		return $return;
	}

}

